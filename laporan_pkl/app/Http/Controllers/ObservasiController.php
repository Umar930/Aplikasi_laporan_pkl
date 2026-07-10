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
        $observasi=Observasi::with('murid')->latest()->get();
    }
    elseif(Auth::guard('guru')->check()){
        $guruId=Auth::guard('guru')->id();
        $observasi=Observasi::whereHas('murid',function($query) use ($guruId){
            $query->where('guru_pembimbing_id',$guruId);
        })->with('murid')->latest()->get();
    }
    elseif(Auth::guard('dudi')->check()){
        $dudiId=Auth::guard('dudi')->id();
        $observasi=Observasi::whereHas('murid',function($query) use ($dudiId){
            $query->where('dudi_id',$dudiId);
        })->with('murid')->latest()->get();
    }else{
        abort(403);
    }   
    return view('observasi.index',compact('observasi'));
   }

    public function create()
    {
        $daftarMurid=collect();
        if(Auth::guard('guru')->check()){
            $daftarMurid=Murid::where('guru_pembimbing_id',Auth::guard('guru')->id())->get();
        }elseif(Auth::guard('dudi')->check()){
            $daftarMurid=Murid::where('dudi_id',Auth::guard('dudi')->id())->get();   }  
            $indikators=Tujuan_Pembelajaran_Indikator::all();
        
            return view('observasi.tambah',compact('daftarMurid','indikators'));
    }

    
    public function store(Request $request)
    {
        $this->authCrud();

        $request->validate([
             'murid_id'=>'required',
            'pekerjaan_proyek'=>'required',
            'observasi'=>'required|array',
        ]);

        
        DB::beginTransaction();
        try{
            $observasi=Observasi::create([
                'murid_id'=>$request->murid_id,
                'pekerjaan_proyek'=>$request->pekerjaan_proyek,
                'status_verifikasi'=>'pending'
            ]);
            foreach($request->observasi as $indikator_id =>$data){
                Observasi_details::create([
                    'observasi_id'=>$observasi->id,
                    'indikator_id'=>$indikator_id,
                    'ketercapaian'=>$data['ketercapaian'],
                    'deskripsi'=>$data['deskripsi'] ?? null,
                ]);
            }
            DB::commit();
                return redirect()->route('observasi.index')->with('sukses','data observasi berhasil disimpan');
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

        return view('observasi.edit',compact('observasiEksis','indikators','infoProyek','observasi'));
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
                'pekerjaan_proyek'=>$request->pekerjaan_proyek,
            ]);

            $observasi->details()->delete();
            foreach($request->observasi as $indikator_id =>$data){
                Observasi_details::create([
                    'observasi_id'=>$id,
                    'indikator_id'=>$indikator_id,
                    'ketercapaian'=>$data['ketercapaian'],
                    'deskripsi'=>$data['deksripsi'] ?? null,
                ]);
            }
            DB::commit();
                return redirect()->route('observasi.index')->with('sukses','data observasi berhasil disimpan');
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
            return redirect()->route('observasi.index')->with('sukses','data berhasil dihapus');
        }catch(\Exception $e){
            return redirect()->back()->with('error','gagal menghaspus data: '.$e->getMessage());
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