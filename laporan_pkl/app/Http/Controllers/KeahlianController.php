<?php

namespace App\Http\Controllers;

use App\Models\Konsentrasi_Keahlian;
use Illuminate\Http\Request;

class KeahlianController extends Controller
{
    public function index(){
        $konsentrasi=Konsentrasi_Keahlian::all();
        return view('auth.register-murid');
    }

    public function show(){

    }

    public function store(){

    }

    public function edit(){

    }

    public function update(){

    }
    
    public function destroy(){

    }
}