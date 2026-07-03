<?php

namespace App\Http\Controllers;

use App\Models\laporan_bulanan;
use App\Models\laporan_harian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function indexharian(){
        $harian=laporan_harian::all();
        return view('laporan-harian.index',compact('harian'));
    }

    public function indexbulanan(){
        $bulanan=laporan_bulanan::all();
        return view('laporan-bulanan.index',compact('bulanan'));
    }

    public function createharian(){
        return view('laporan-harian.tambah');
    }

    public function createbulanan(){
        return view('laporan-bulanan.tambah');
    }

    public function editharian(String $id){
        $harian=laporan_harian::findOrFail($id);
        return view('laporan-harian.edit');
    }

    public function editbulanan(String $id){
        $bulanan=laporan_bulanan::findOrFail($id);
        return view('laporan-bulanan.edit');
    }


    
}
