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
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
