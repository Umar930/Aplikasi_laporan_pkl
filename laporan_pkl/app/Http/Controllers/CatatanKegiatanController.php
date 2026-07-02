<?php

namespace App\Http\Controllers;

use App\Models\Catatan_kegiatan;
use Illuminate\Http\Request;

class CatatanKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catatan_kegiatan = Catatan_kegiatan::all();
        return view('catatan-kegiatan.index', compact('catatan_kegiatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('catatan-kegiatan.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pekerjaan' => 'required',
            'perencanaan_kegiatan' => 'required',
            'pelaksanaan_kegiatan' => 'required',
            'catatan_instruktur' => 'required',
        ]);

        Catatan_kegiatan::create($request->all());
        return redirect()->route('catatan-kegiatan.index')->with('success','berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Catatan_kegiatan $catatan_kegiatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $catatan_kegiatan = Catatan_kegiatan::findOrFail($id);
        return view('catatan-kegiatan.edit', compact('catatan_kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pekerjaan' => 'required',
            'perencanaan_kegiatan' => 'required',
            'pelaksanaan_kegiatan' => 'required',
            'catatan_instruktur' => 'required',
        ]);

        $catatan_kegiatan = Catatan_kegiatan::findOrFail($id);
        $catatan_kegiatan = $catatan_kegiatan->update($request->all());
        return redirect()->route('catatan-kegiatan.index')->with('success', 'berhasil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catatan_kegiatan $catatan_kegiatan)
    {
        $catatan_kegiatan = Catatan_kegiatan::findOrFail($id);
        $catatan_kegiatan->delete();
        return redirect()->route('catatan-kegiatan.index')->with('success', 'berhasil');
    }
}
