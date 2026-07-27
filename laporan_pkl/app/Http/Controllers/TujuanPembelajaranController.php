<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tujuan_Pembelajaran_Indikator;

class TujuanPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tujuan_pembelajaran = Tujuan_Pembelajaran_Indikator::all();

        return view('laporan-nilai.index', compact('tujuan_pembelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('laporan-nilai.tambah');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        $request->validate([
            'point_utama'=>'requeired',
            'point_details'=>'required'
        ]);

        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>$request->point_utama,
            'point_details'=>$request->point_details,
        ]);

        return redirect()->route('web.nilai.index')->with('sukses','berhasil tambah tujuan pembelajaran');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $indikator=Tujuan_Pembelajaran_Indikator::findOrFail($id);
        return view('laporan-nilai.edit',compact('indikator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $indikator=Tujuan_Pembelajaran_Indikator::findOrFail($id);

        $request->validate([
            'point_utama'=>'requeired',
            'point_details'=>'required'
        ]);

        $indikator->update([
            'point_utama'=>$request->point_utama,
            'point_details'=>$request->point_details,
        ]);

        return redirect()->route('web.nilai.index')->with('sukses','berhasil edit tujuan pembelajaran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $indikator=Tujuan_Pembelajaran_Indikator::findOrFail($id);
        $indikator->delete();
        return redirect()->route('web.nilai.index')->with('sukses','data berhasil dihapus');
    }
}
