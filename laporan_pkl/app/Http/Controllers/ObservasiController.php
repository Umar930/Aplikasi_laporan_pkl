<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Observasi;
use App\Models\Observasi_details;
use App\Models\Tujuan_Pembelajaran_Indikator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ObservasiController extends Controller
{
    public function index()
    {
        if(Auth::guard('web')->check()){
        $query=Observasi::with('murid.guru', 'murid.dudi', 'details.indikator');
    }
    elseif(Auth::guard('guru')->check()){
        $guruId=Auth::guard('guru')->id();
        $query=Observasi::whereHas('murid',function($q) use ($guruId){
            $q->where('guru_pembimbing_id',$guruId);
        })->with('murid.guru','murid.dudi','details.indikator');
    }
    elseif(Auth::guard('dudi')->check()){
        $dudiId=Auth::guard('dudi')->id();
        $query=Observasi::whereHas('murid',function($q) use ($dudiId){
            $q->where('dudi_id',$dudiId);
        })->with('murid.guru','murid.dudi','details.indikator');
    }else{
        abort(403);
    }   

    $observasiPaginate = $query->latest()->paginate(1);
    $observasiAktif = $observasiPaginate->first();

    $detailGroup = collect();
    if ($observasiAktif && $observasiAktif->details){
        $detailGroup = $observasiAktif->details->groupBy(function($detail) {
            return $detail->indikator->point_utama ?? 'lain-lain';
        });
    }

    $tujuan_pembelajaran = Tujuan_Pembelajaran_Indikator::all();

    return view('observasi.index',compact('tujuan_pembelajaran','observasiPaginate','observasiAktif','detailGroup'));
   }

    public function create()
    {
        $daftarMurid=collect();
        if(Auth::guard('guru')->check()){
            $daftarMurid=Murid::where('guru_pembimbing_id',Auth::guard('guru')->id())->get();
        }elseif(Auth::guard('dudi')->check()){
            $daftarMurid=Murid::where('dudi_id',Auth::guard('dudi')->id())->get();   }  

            $pembelajaran = Tujuan_Pembelajaran_Indikator::pluck('point_utama')->unique();
            $tujuan_pembelajaran = Tujuan_Pembelajaran_Indikator::all();
        
            return view('observasi.tambah',compact('tujuan_pembelajaran','pembelajaran','daftarMurid'));
    }

    
    public function store(Request $request)
    {
        $this->authCrud();

        $request->validate([
            'murid_id'=>'required',
            'tempat_pkl'=>'required',
            'dudi_id'=>'required',
            'guru_pembimbing_id'=>'required',
            'pekerjaan_proyek'=>'required',
            'observasi'=>'required|array',
            'observasi.*.ketercapaian'=>'required|in:iya,tidak',
            'observasi.*.deskripsi'=>'nullable|string',
            'observasi.*.skor'=>'nullable|numeric|min:0|max:100',
        ]);

        
        DB::beginTransaction();
        try{
            $observasi=Observasi::create([
                'murid_id'=>$request->murid_id,
                'tempat_pkl'=>$request->tempat_pkl,
                'dudi_id'=>$request->dudi_id,
                'guru_pembimbing_id'=>$request->guru_pembimbing_id,
                'pekerjaan_proyek'=>$request->pekerjaan_proyek,
                'status_verifikasi'=>'pending'
            ]);
            foreach($request->observasi as $indikator_id => $data){
                if (!empty($indikator_id)) {
                    Observasi_details::create([
                    'observasi_id'=>$observasi->id,
                    'indikator_id'=>$indikator_id,
                    'ketercapaian'=>$data['ketercapaian'],
                    'deskripsi'=>$data['deskripsi'] ?? null,
                    'skor'=>isset($data['skor']) ? $data['skor'] : null,
                    ]);
                }
            }

            DB::commit();

                if (Auth::guard('guru')->check()) {
                    return redirect()->route('guru.observasi.index')->with('sukses', 'data berhasil ditambahkan oleh Guru');
                } elseif (Auth::guard('dudi')->check()) {
                    return redirect()->route('dudi.observasi.index')->with('sukses', 'data berhasil ditambahkan oleh Dudi');
                }
                return redirect()->back()->with('sukses','data observasi berhasil disimpan');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $observasi=Observasi::with(['murid','details.indikator'])->findOrFail($id);
        return view('observasi.index',compact('observasi'));
    }

    public function edit($id)
    {
     $this->authCrud();

        $daftarMurid=collect();
        if(Auth::guard('guru')->check()){
            $daftarMurid=Murid::where('guru_pembimbing_id',Auth::guard('guru')->id())->get();
        }elseif(Auth::guard('dudi')->check()){
            $daftarMurid=Murid::where('dudi_id',Auth::guard('dudi')->id())->get();   }  

            $daftarMurid = Murid::orderBy('nama_murid')->get();

        $observasi=Observasi::with('details')->findOrFail($id);

        if(!$this->cekAksesData($observasi)){
            abort(403,'anda tidak memiliki akses untuk mengubah data ini');
        }

        $indikators=Tujuan_Pembelajaran_Indikator::select('point_utama',DB::raw('MIN(id) as id'))
        ->groupBy('point_utama')->get()
        ->keyBy('id');

        $observasiEksis=$observasi->details->keyBy('id');

        if($observasiEksis->isEmpty()){ 
            return redirect('observasi.tambah')->with('error','data observasi belum ada');
        }

        $infoProyek=$observasiEksis->first()->pekerjaan_proyek;

        $pembelajaran = Tujuan_Pembelajaran_Indikator::pluck('point_utama')->unique();
        $tujuan_pembelajaran = Tujuan_Pembelajaran_Indikator::all();

        return view('observasi.edit',compact('daftarMurid','pembelajaran','tujuan_pembelajaran','observasiEksis','indikators','infoProyek','observasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $this->authCrud();

        DB::beginTransaction();
        try{
            $observasi=Observasi::findOrFail($id);
            if(!$this->cekAksesData($observasi)){
                abort(403,'anda tidak memiliki akses untuk mengubah data ini');
            }
            $observasi->update([
                'murid_id'=>$request->murid_id,
                'tempat_pkl'=>$request->tempat_pkl,
                'dudi_id'=>$request->dudi_id,
                'guru_pembimbing_id'=>$request->guru_pembimbing_id,
                'pekerjaan_proyek'=>$request->pekerjaan_proyek,
            ]);

            $observasi->details()->delete();
            foreach($request->observasi as $indikator_id =>$data){
                Observasi_details::create([
                    'observasi_id'=>$id,
                    'indikator_id'=>$indikator_id,
                    'ketercapaian'=>$data['ketercapaian'],
                    'deskripsi'=>$data['deksripsi'] ?? null,
                    'skor'=>isset($data['skor']) ? $data['skor'] : null,
                ]);
            }
            DB::commit();

                if (Auth::guard('guru')->check()) {
                    return redirect()->route('guru.observasi.index')->with('sukses', 'data berhasil diupdate oleh Guru');
                } elseif (Auth::guard('dudi')->check()) {
                    return redirect()->route('dudi.observasi.index')->with('sukses', 'data berhasil diupdate oleh Dudi');
                }

                return redirect()->back()->with('sukses','data observasi berhasil disimpan');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $this->authCrud();

        try{
            $observasi=Observasi::findOrFail($id);
            if(!$this->cekAksesData($observasi)){
                abort(403,'anda tidak memiliki akses untuk mengubah data ini');
            }
            $observasi->delete();

            if (Auth::guard('guru')->check()) {
                return redirect()->route('guru.observasi.index')->with('sukses', 'data berhasil dihapus oleh Guru');
            } elseif (Auth::guard('dudi')->check()) {
                return redirect()->route('dudi.observasi.index')->with('sukses', 'data berhasil dihapus oleh Dudi');
                }
            return redirect()->back()->with('sukses','data berhasil dihapus');
        }catch(\Exception $e){
            return redirect()->back()->with('error','gagal menghapus data: '.$e->getMessage());
        }
    }

    public function verifikasidetail($id){
        $observasi=Observasi::findOrFail($id);

        if(!$this->cekAksesData($observasi)){
            abort(403,'anda tidak memiliki akses untuk mengubah data ini');
        }
        
        if(Auth::guard('guru')->check()){
            $observasi->diverifikasi_oleh_guru = Auth::guard('guru')->id();
        }

        if(Auth::guard('dudi')->check()){
            $observasi->diverifikasi_oleh_dudi=Auth::guard('dudi')->id();
        }
        if($observasi->diverifikasi_oleh_guru && $observasi->diverifikasi_oleh_dudi){
            $observasi->status_verifikasi='diverifikasi';
        }

        $observasi->save();

        return back()->with('sukses','data berhasil diverifikasi');
    }


    private function authCrud(){
        if(!Auth::guard('web')->check() && !Auth::guard('guru')->check() && !Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
    }

    private function cekAksesData($observasi)
{
    if(Auth::guard('web')->check()){
        return true;
    }

    if(Auth::guard('guru')->check()){
        return $observasi->murid->guru_pembimbing_id == Auth::guard('guru')->id();
    }

    if(Auth::guard('dudi')->check()){
        return $observasi->murid->dudi_id == Auth::guard('dudi')->id();
    }

    return false;
}
} 