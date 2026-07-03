<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Identitas_Dudi;
use App\Models\Murid;
use App\Models\Guru_Pembimbing;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showlogin(){

        return view('auth.login');
        
    }

    public function showregister(){

        return view('auth.register');
    }

    public function register(Request $request){

    }

    public function login(Request $request){
        $request->validate([
            'user_type'=>'required|in:web,guru,dudi,murid'
        ]);

        $type=$request->user_type;
        switch($type){
            case 'murid':
                return $this->handleMuridLogin($request);
            case 'dudi':
            case 'guru':
            case 'web':
                return $this->handleCredentialLogin($request,$type);
            
        }

    }

    protected function handleMuridLogin(Request $request){
        $request->validate([
            'nis'=>'required|string'
        ]);

        $murid=\App\Models\Murid::Where('nis',$request->nis)->first();

        if($murid){
            \Illuminate\Support\Facades\Auth::guard('murid')->login($murid);
            $request->session()->regenerate();
            return redirect()->intended('murid/dashboard');
        }

        return back()->withErrors(['nis'=>'Nis tidak ditemukan'])->withInput();


    }

    protected function handleCredentialLogin(Request $request,String $guard){
        $credentials=$request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        if(Auth::guard($guard)->attempt($credentials)){
            $request->session()->regenerate();
            return back()->inetended("/{$guard}/dashboard");
        }
    }

    public function logout(){
        
    }
}