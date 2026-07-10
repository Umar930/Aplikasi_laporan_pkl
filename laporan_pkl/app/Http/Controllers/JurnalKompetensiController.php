<?php

namespace App\Http\Controllers;

use App\Models\Jurnal_kompetensi;
use App\Models\JurnalDetail;
use App\Models\Kompetensi_Dasar;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class JurnalKompetensiController extends Controller
{
    
    public function index()
    {
        $jurnal_kompetensi=Jurnal_kompetensi::with('murid')->latest()->get();
        return view('jurnal-kompetensi.index',compact('jurnal_kompetensi','dasar'));
    }

    public function create()
    {
        if(!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }

        $murid=Murid::all();
        $kompetensi=Kompetensi_Dasar::all();
        return view('jurnal-kompetensi.tambah',compact('kompetensi','murid'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::guard('guru')->check() &&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }

        DB::beginTransaction();
        try{
        $jurnal=Jurnal_kompetensi::create([
            'murid_id'=>$request->murid_id
        ]);



        foreach($request->kompetensi as $kompetensi_id=>$data){
            $request->validate([
                'murid_id'=>'required|exists:murid,id',
                'kompetensi'=>'required|array',
                'kompetensi.*.pelaksanaan'=>'required',
                'kompetensi.*.nilai_minimal'=>'required|integer',
                'kompetensi.*.nilai'=>'required|integer',
                'kompetensi.*.tanggal'=>'required|date',
            ]);
            JurnalDetail::create([
                'jurnal_kompetensi_id'=>$jurnal->id,
                'kompetensi_dasar_id'=>$kompetensi_id,
                'pelaksanaan_pembelajaran'=>$data['pelaksanaan'],
                'nilai_minimal_kompetensi'=>$data['nilai_minimal'],
                'nilai_kompetensi'=>$data['nilai'],
                'tanggal'=>$data['tanggal'],
                'keterangan'=>$data['keterangan'],
            ]);
        }
        DB::commit();
        return redirect()->route('jurnal-kompetensi.index')->with('sukses','data berhasil ditambahkan');
    }catch(\Exception $e){
        DB::rollBack();
        return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();
    }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jurnal=Jurnal_Kompetensi::with(['murid','details.kompetensiDasar'])->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(!Auth::guard('guru')->check() &&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
        $jurnal=Jurnal_kompetensi::with('details.kompetensiDasar')->findOrFail($id);
        $kompetensi=Kompetensi_Dasar::all();
        return view('jurnal-kompetensi.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if(!Auth::guard('guru')->check() &&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
        DB::beginTransaction();
        try{
        $jurnal=Jurnal_kompetensi::create([
            'murid_id'=>$request->murid_id
        ]);
        $jurnal->details()->delete();

        foreach($request->kompetensi as $kompetensi_id=>$data){
            $request->validate([
                'murid_id'=>'required|exists:murid,id',
                'kompetensi'=>'required|array',
                'kompetensi.*.pelaksanaan'=>'required',
                'kompetensi.*.nilai_minimal'=>'required|integer',
                'kompetensi.*.nilai'=>'required|integer',
                'kompetensi.*.tanggal'=>'required|date',
            ]);
            JurnalDetail::create([
                'jurnal_kompetensi_id'=>$jurnal->id,
                'kompetensi_dasar_id'=>$kompetensi_id,
                'pelaksanaan_pembelajaran'=>$data['pelaksanaan'],
                'nilai_minimal_kompetensi'=>$data['nilai_minimal'],
                'nilai_kompetensi'=>$data['nilai'],
                'tanggal'=>$data['tanggal'],
                'keterangan'=>$data['keterangan'],
            ]);
        }
        DB::commit();
        return redirect()->route('jurnal-kompetensi.index')->with('sukses','data berhasil ditambahkan');
    }catch(\Exception $e){
        DB::rollBack();
        return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();
 
        
    }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(!Auth::guard('guru')->check() &&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
      
        $jurnal = Jurnal_kompetensi::findOrFail($id);

        $jurnal->delete();       
    }

    public function verifikasiguru($detailId){
        if(!Auth::guard('guru')->check() &&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
      
        $detail=JurnalDetail::findOrFail($detailId);

        $detail->update([
            'status_verifikasi'=>'diverifikasi',
            'diverifikasi_oleh_guru'=>Auth::guard('guru')->id()
        ]);
    }

    public function verifikasidudi($detailId){
        if(!Auth::guard('guru')->check() &&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
      
        $detail=JurnalDetail::findOrFail($detailId);

        $detail->update([
            'status_verifikasi'=>'diverifikasi',
            'diverifikasi_oleh_dudi'=>Auth::guard('dudi')->id()
        ]);
    }

}