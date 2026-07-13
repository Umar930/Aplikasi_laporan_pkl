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
        $tujuan_pembelajaran = Tujuan_Pembelajaran_Indikator::all()->groupBy('point_utama');

        return view('laporan-nilai.index', compact('tujuan_pembelajaran'));
    }

    public function guru()
    {
        $tujuan_pembelajaran = Tujuan_Pembelajaran_Indikator::all()->groupBy('point_utama');

        return view('observasi.index', compact('tujuan_pembelajaran'));
    }

    public function dudi()
    {
        $tujuan_pembelajaran = Tujuan_Pembelajaran_Indikator::all()->groupBy('point_utama');

        return view('observasi.index', compact('tujuan_pembelajaran'));
    }

    public function web()
    {
        $tujuan_pembelajaran = Tujuan_Pembelajaran_Indikator::all()->groupBy('point_utama');

        return view('observasi.index', compact('tujuan_pembelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::guard('web')->check()){
            abort(403,'akses anda ditolak');
        }
        $indikator=Tujuan_Pembelajaran_Indikator::all();
        return view('indikatot.tambah');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        if(!Auth::guard('web')->check()){
            abort(403,'akses anda ditolak');
        }

        $request->validate([
            'point_utama'=>'requeired',
            'point_details'=>'required'
        ]);

        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>$request->point_utama,
            'point_details'=>$request->point_details,
        ]);

        return redirect('indikator.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $indikator=Tujuan_Pembelajaran_Indikator::all();
        return view('indikator.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $indikator=Tujuan_Pembelajaran_Indikator::findOrFail($id);
        return view('indikator.index',compact('indikator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(!Auth::guard('web')->check()){
            abort(403,'akses ditolak');
        }

        $indikator=Tujuan_Pembelajaran_Indikator::findOrFail($id);

        $indikator->update([
            'point_utama'=>$request->point_utama,
            'point_details'=>$request->point_details,
        ]);

        return redirect('indikator.index',compact('indikator'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!Auth::guard('web')->check()){
            abort(403,'akses ditolak');
        }

        $indikator=Tujuan_Pembelajaran_Indikator::findOrFail($id);
        $indikator->delete();
        return redirect('indikator.index')->with('sukses','data berhasil dihapus');
    }
}
