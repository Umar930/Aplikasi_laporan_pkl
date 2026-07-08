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
        $observasi=Observasi::with('murid')->latest()->get();
        return view('observasi.index',compact('observasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
        if(!Auth::guard('guru')->check()&&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }

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
                    'ketercapaian'=>$data['ketercapaian']
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
        if(!Auth::guard('guru')->check()&&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }

        $observasi=Observasi::with('details')->findOrFail($id);

        $indikators=Tujuan_Pembelajaran_Indikator::select('point_utama',DB::raw('MIN(id) as id'))
        ->groupBy('point_utama')->get()
        ->keyBy('indikator_id');

        $observasiEksis=$observasi->details->keyBy('indikator_id');

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
        if(!Auth::guard('guru')->check()&&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
        

        DB::beginTransaction();
        try{
            $observasi=Observasi::findOrFail($id);
            $observasi->update([
                'pekerjaan_proyek'=>$request->pekerjaan_proyek,
            ]);

            $observasi->details()->delete();
            foreach($request->observasi as $indikator_id =>$data){
                Observasi_details::updateOrCreate([
                    'observasi_id'=>$id,
                    'indikator_id'=>$indikator_id,
                    'ketercapaian'=>$data['ketercapaian'],
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
        if(!Auth::guard('guru')->check()&&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak hanya dudi dan guru yang bisa menghapus data ini');
        }

        try{
            $observasi=Observasi::findOrFail($id);

            $observasi->delete();
            return redirect()->route('observasi.index')->with('sukses','data berhasil dihapus');
        }catch(\Exception $e){
            return redirect()->back()->with('error','gagal menghaspus data: '.$e->getMessage());
        }
    }

    public function verifikasidetail($id){
        $detail=Observasi_details::findOrFail($id);

        if(Auth::guard('guru')->check()){
            $detail->guru_verifikator_id = Auth::guard('guru')->id();
        }

        if(Auth::guard('dudi')->check()){
            $detail->dudi_verifikator_id=Auth::guard('dudi')->id();
        }
        if($detail->dudi_verifikator_id && $detail->dudi_verifikator_id){
            $detail->status_verifikasi='diverifikasi';
        }

        $detail->save();

        return back()->with('sukses','data berhasil diverifikasi');
    }
} 