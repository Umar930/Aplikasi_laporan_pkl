<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Observasi;
use App\Models\Tujuan_Pembelajaran_Indikator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ObservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $observasi=Observasi::all();
        return view('observasi.index',compact('observasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($murid_id)
    {   
        $murid=Murid::findOrFail($murid_id);
        $daftarMurid=collect();
        
        if(Auth::guard('guru')->check()){
            $daftarMurid=Murid::where('guru_pembimbing_id',Auth::guard('guru')->id())->get();
        }elseif(Auth::guard('dudi')->check()){
            $daftarMurid=Murid::where('dudi_id',Auth::guard('dudi')->id())->get();
        }else{
            abort(403,'hanya guru dan dudi yang bisa mengakses halaman ini');
        }
        $aspekObservasi=Tujuan_Pembelajaran_Indikator::select('point_utama',DB::raw('MIN(id) as id'))->groupBy('point_utama')->get();
        $observasiEksis=collect();

        return view('observasi.tambah',compact('daftarMurid','murid','aspekObservasi','observasiEksis'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$murid_id)
    {
        if(!Auth::guard('guru')->check()&&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
        $request->validate([
            'murid_id'=>'required|exists:murid,id',
            'pekerjaan_proyek'=>'required|string|max:255',
            'observasi'=>'required|array',
            'observasi.*.ketercapaian'=>'required|in:iya,tidak'
        ]);

        DB::beginTransaction();
        try{
            foreach($request->observasi as $indikator_id =>$data){
                Observasi::updateOrCreate([
                    'murid_id' =>$murid_id,
                    'indikator_id' =>$indikator_id,
                ],[
                    
                    'guru_pembimbing_id'=>Auth::guard('guru')->id() ?? Murid::find($request->murid_id)->guru_pembimbing_id,
                    'pekerjaan_proyek'=>$request->pekerjaan_proyek,
                    'ketercapaian' =>$data['ketercapaian'],
                    'status_verifikasi' =>'pending',
                ]);
            }
            DB::commit();
                return redirect()->route('observasi.index',$murid_id)->with('sukses','data observasi berhasil disimpan');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($murid_id)
    {
        $murid= Murid::findOrFail($murid_id);

        $daftarObservasi=Observasi::with('indikator')->where('murid_id',$murid_id)->get();
        $infoProyek=$daftarObservasi->first();

        return view('observasi.index',compact('murid','daftarObservasi','infoProyek'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($murid_id)
    {
        if(!Auth::guard('guru')->check()&&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }

        $murid=Murid::findOrFail($murid_id);

        $aspekObservasi=Tujuan_Pembelajaran_Indikator::select('point_utama',DB::raw('MIN(id) as id'))
        ->groupBy('point_utama')->get()
        ->keyBy('indikator_id');

        $observasiEksis=Observasi::where('murid_id',$murid_id)->get()->keyBy('indikator_id');

        if($observasiEksis->isEmpty()){
            return redirect('observasi.tambah')->with('error','data observasi belum ada');
        }

        $infoProyek=$observasiEksis->first()->pekerjaan_proyek;

        return view('observasi.edit',compact('observasiEksis','aspekObservasi','infoProyek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $murid_id)
    {
        if(!Auth::guard('guru')->check()&&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
        $request->validate([
            'pekerjaan_proyek'=>'required|string|max:255',
            'observasi'=>'required|array',
            'observasi.*.ketercapaian'=>'required|in:iya,tidak'
        ]);

        DB::beginTransaction();
        try{
            $murid=Murid::findOrFail($murid_id);
            $guru_pembimbing_id=Auth::guard('guru')->id() ?? $murid->guru_pembimbing_id;
            foreach($request->observasi as $indikator_id =>$data){
                Observasi::updateOrCreate([
                    'murid_id' =>$murid_id,
                    'indikator_id' =>$indikator_id,
                ],[
                     'pekerjaan_proyek'=>$request->pekerjaan_proyek,
                    'ketercapaian' =>$data['ketercapaian'],
                    'status_verifikasi' =>'pending',
                ]);
            }
            DB::commit();
                return redirect()->route('observasi.index',$murid_id)->with('sukses','data observasi berhasil disimpan');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($murid_id)
    {
        if(!Auth::guard('guru')->check()&&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak hanya dudi dan guru yang bisa menghapus data ini');
        }

        try{
            Observasi::where('murid_id', $murid_id)->delete();
            return redirect()->route('observasi.index')->with('sukses','data berhasil dihapus');
        }catch(\Exception $e){
            return redirect()->back()->with('error','gagal menghaspus data: '.$e->getMessage());
        }
    }
} 