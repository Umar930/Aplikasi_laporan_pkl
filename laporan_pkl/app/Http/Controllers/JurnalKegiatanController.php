<?php

namespace App\Http\Controllers;

use App\Models\Jurnal_kegiatan;
use Illuminate\Http\Request;

class JurnalKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurnal_kegiatan = Jurnal_kegiatan::all();
        return view('jurnal-kegiatan.index', compact('jurnal_kegiatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurnal-kegiatan.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari_tanggal' => 'required',
            'kompetensi' => 'required',
            'topik_pekerjaan' => 'required',
            'nilai_karakter' => 'required',
        ]);

        Jurnal_kegiatan::create($request->all());
        return redirect()->route('jurnal-kegiatan.index')->with('success','berhasil tambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal_kegiatan $jurnal_kegiatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jurnal_kegiatan = Jurnal_kegiatan::findOrFail($id);
        return view('jurnal-kegiatan.edit', compact('jurnal_kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'hari_tanggal' => 'required',
            'kompetensi' => 'required',
            'topik_pekerjaan' => 'required',
            'nilai_karakter' => 'required',
        ]);

        $jurnal_kegiatan = Jurnal_kegiatan::findOrFail($id);
        $jurnal_kegiatan = $jurnal_kegiatan->update($request->all());
        return redirect()->route('jurnal-kegiatan.index')->with('success', 'berhasil edit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jurnal_kegiatan = Jurnal_kegiatan::findOrFail($id);
        $jurnal_kegiatan->delete();
        return redirect()->route('jurnal-kegiatan.index')->with('success', 'berhasil hapus data');
    }
}
