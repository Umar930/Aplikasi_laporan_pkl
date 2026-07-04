<?php

namespace App\Http\Controllers;

use App\Models\Laporan_Nilai;
use App\Models\Tujuan_Pembelajaran_Indikator;
use Illuminate\Http\Request;

class DaftarNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nilai=Laporan_Nilai::all();
        $indikator=Tujuan_Pembelajaran_Indikator::all();
        return view('daftar-nilai.index',compact('nilai','indikator'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nilai=Laporan_Nilai::all();
        return view('daftar-nilai.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $nilai=Laporan_Nilai::findOrFail($id);
        return view('daftar-nilai.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
