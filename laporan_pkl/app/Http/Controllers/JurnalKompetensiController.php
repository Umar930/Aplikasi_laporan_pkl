<?php

namespace App\Http\Controllers;

use App\Models\Jurnal_kompetensi;
use App\Models\Kompetensi_Dasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class JurnalKompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurnal_kompetensi=Jurnal_kompetensi::all();
        $dasar=Kompetensi_Dasar::all();
        return view('jurnal-kompetensi.index',compact('jurnal_kompetensi','dasar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }

        $jurnal_kompetensi=Jurnal_kompetensi::all();
        $dasar=Kompetensi_Dasar::all();
        return view('jurnal-kompetensi.tambah',compact('jurnal_kompetensi','dasar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kompetensi=$request->validate([
            'murid_id'=>'required',
            'komptensi_dasar_id'=>'required',
            'pelaksanaan_pembelajaran'=>'required',
            'nilai_minimal_kompetensi'=>'required',
            'nilai_kompetensi'=>'required',
            'tanggal'=>'required',
            'keterangan'=>'required',
        ],[
            'murid_id.required'=>'harap mengisi data diri murid',
            'kompetesni_dasar_id.required'=>'masalah dari sistem pertanyaan tidak muncul',
            'pelaksanaan_pembelajaran.required'=>'harap mengisi pelaksaan pembelajaran',
            'nilai_minimal_kompetensi.required'=>'harap mengisi nilai minimal kompetensi',
            'nilai_kompetensi.required'=>'harap mengisi nilai kompetensi',
            'tanggal.required'=>'harap mengisi tanggal',
            'keterangan.required'=>'harap mengisi keterangan',
        ]);

        Jurnal_kompetensi::create($kompetensi);

        return redirect('jurnal-kompetensi.index')->with('sukses','data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal_kompetensi $jurnal_kompetensi)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        Jurnal_kompetensi::findOrFail($id);
        return view('jurnal-kompetensi.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurnal_kompetensi $jurnal_kompetensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal_kompetensi $jurnal_kompetensi)
    {
        //
    }
}
