<?php

namespace App\Http\Controllers;

use App\Models\Kompetensi_Dasar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KompetensiDasarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kompetensi_dasars = Kompetensi_Dasar::all();
        return view('jurnal-kompetensi.index', compact('kompetensi_dasars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('jurnal-kompetensi.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'kategori_utama'=>'required',
            'nama_kompetensi'=>'required'
        ]);

        Kompetensi_Dasar::create([
            'kategori_utama'=>$request->kategori_utama,
            'nama_kompetensi'=>$request->nama_kompetensi
        ]);

        return redirect()->route('web.kompetensi.index')->with('sukses','data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kompetensi=Kompetensi_Dasar::all();

        return view('kompetensi.index',compact('kompetensi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kompetensi=Kompetensi_Dasar::findOrFail($id);

        return view('jurnal-kompetensi.edit',compact('kompetensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $kompetensi=Kompetensi_Dasar::findOrFail($id);

        $request->validate([
            'kategori_utama'=>'required',
            'nama_kompetensi'=>'required'
        ]);

        $kompetensi->update([
            'kategori_utama'=>$request->kategori_utama,
            'nama_kompetensi'=>$request->nama_kompetensi
        ]);

        return redirect()->route('web.kompetensi.index')->with('sukses','data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $kompetensi=Kompetensi_Dasar::findOrFail($id);

        $kompetensi->delete();

        return redirect('web.kompetensi.index')->with('sukses','data berhasil dihapus');
    }
}
