<?php

namespace App\Http\Controllers;

use App\Models\Jurnal_kompetensi;
use Illuminate\Http\Request;

class JurnalKompetensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurnal_kompetensi=Jurnal_Kompetensi::all();
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
    public function show(Jurnal_kompetensi $jurnal_kompetensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurnal_kompetensi $jurnal_kompetensi)
    {
        //
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
