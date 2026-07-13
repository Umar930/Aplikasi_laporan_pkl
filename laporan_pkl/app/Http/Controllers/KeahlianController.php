<?php

namespace App\Http\Controllers;

use App\Models\Konsentrasi_Keahlian;
use Database\Seeders\KonsentrasiKeahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeahlianController extends Controller
{
    public function index(){
        $konsentrasi=Konsentrasi_Keahlian::all();
        return view('auth.register-murid');
    }

    public function create(){
        if(!Auth::guard('web')->check()){
            abort(403,'akses ditolak');
        }

        return view('keahlian.tambah');
    }

    public function store(Request $request){
        if(!Auth::guard('web')->check()){
            abort(403,'akses ditolak');
        }

        $request->validate([
        'program_keahlian'=>'required',
        'konsentrasi-keahlian'=>'required',
        ]);

        Konsentrasi_Keahlian::create([
            
        'program_keahlian'=>$request->program_keahlian,
        'konsentrasi_keahlian'=>$request->konsentrasi_keahlian,
        ]);
        
        return redirect('keahlian.index')->with('sukses','data berhasil ditambahkan');
    }

    public function show(){
        // if(!Auth::guard('web')->check()){
        //     abort(403,'akses ditolak');
        // }
    }

    public function edit($id){
        if(!Auth::guard('web')->check()){
            abort(403,'akses ditolak');
        }

        $keahlian=Konsentrasi_Keahlian::findOrFail($id);
        return view('keahlian.edit');
    }

    public function update(Request $request,$id){
        if(!Auth::guard('web')->check()){
            abort(403,'akses ditolak');
        }

        $keahlian=Konsentrasi_Keahlian::findOrFail($id);

        $keahlian->update([
            'program_keahlian'=>$request->program_keahlian,
            'konsentrasi_keahlian'=>$request->konsentrasi_keahlian,
        ]);
        return redirect('keahlian.index')->with('sukses','data berhasil diubah');

    }
    
    public function destroy($id){
        if(!Auth::guard('web')->check()){
            abort(403,'akses ditolak');
        }

        $keahlian=Konsentrasi_Keahlian::findOrFail($id);
        $keahlian->delete();
        return redirect('keahlian.index')->with('sukses','data berhasil dihapus');
    }
}