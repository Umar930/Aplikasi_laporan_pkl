<?php

namespace App\Http\Controllers;

use App\Models\Guru_Pembimbing;
use App\Models\Konsentrasi_Keahlian;
use App\Models\Identitas_Dudi;
use App\Models\Murid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showlogin(){

        return view('auth.login');
        
    }

    public function showregister(){

        $konsentrasi = Konsentrasi_Keahlian::all();
        return view('auth.register', compact('konsentrasi'));
    }

    public function register(Request $request){
            $request->validate([
               'user_type'=>'required|in:web,guru,dudi,murid'
            ]);

            $type=$request->user_type;

            switch($type){
                case 'web':
                    return $this->handleWebRegister($request);
                case 'guru':
                    return $this->handleGuruRegister($request);
                case 'dudi':
                    return $this->handleDudiRegister($request);
                case 'murid':
                    return $this->handleMuridRegister($request);            
            }
    }

    protected function handleWebRegister(Request $request){
        $data=$request->validate([
            'name'=>'required|String|max:255',
            'email'=>'required|String|email|max:255|unique:users',
            'password'=>'required|String|min:8|confirmed',
        ]);

        $user=User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('sukses','Registrasi Admin berhasil! Silahkan login');
    }

    protected function handleGuruRegister(Request $request){
        $data =$request->validate([
            'nama'=>'required|string|max:255',
            'nip'=>'required|string|max:20|unique:guru_pembimbings',
            'email'=>'required|string|email|max:255|unique:guru_pembimbings',
            'password'=>'required|string|min:8|confirmed',
        ]);

        $guru=Guru_Pembimbing::create([
            'nama'=>$data['nama'],
            'nip'=>$data['nip'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('sukses','Registrasi Guru berhasil! Silahkan login');
    }

    protected function handleDudiRegister(Request $request){
        $data=$request->validate([
            'nama_dudi'=>'required|string|max:255',
            'alamat_dudi'=>'required|string|',
            'no_telepon'=>'required|string|',
            'nama_pembimbing'=>'required|string|max:255',
            'email'=>'required|string|max:255|email|unique:identitas_dudi',
            'password'=>'required|string|min:8|confirmed',
        ]);

        $dudi=Identitas_Dudi::create([
            'nama_dudi'=>$data['nama_dudi'],
            'alamat_dudi'=>$data['alamat_dudi'],
            'no_telepon'=>$data['no_telepon'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('sukses','Registrasi Dudi berhasil! Silahkan login');
    }

    protected function handleMuridRegister(Request $request){
        $data=$request->validate([
            'nama_murid'=>'required|string|max:255',
            'kelas'=>'required|string',
            'konsentrasi_keahlian_id'=>'required|exist:konsentrasi_keahlian,id',
            'tempat_lahir'=>'required|string',
            'tanggal_lahir'=>'required|date',
            'nis'=>'required|string|unique:murid',
            'jenis_kelamin'=>'required|in:pria,wanita',
            'alamat_siswa'=>'required|string',
            'alamat_wali_ortu'=>'required|string',
            'nama_wali_ortu'=>'required|string',
            'no_telepon'=>'required|string',
            'no_telepon_wali'=>'required|string',
            'dudi_id'=>'required|exists:identitas_dudi,id',
            'guru_pembimbing_id'=>'required|exists:guru_pembimbings,id',
        ]);

        $murid=Murid::create($data);

        return redirect()->route('login')->with('sukses','Registrasi Murid berhasil! Silahkan login');
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
            return redirect()->intended("/{$guard}/dashboard");
        }
        return back()->withErrors(['email'=>'kredensial yang dimasukkan tidak cocok!'])->withInput();
    }

    public function logout(Request $request){
        $guards=['web','murid','dudi','murid'];
        $activeGuard='web';

        foreach($guards as $guard){
            if(Auth::guard($guard)->check()){
                $activeGuard=$guard;
                break;
            }
        }

        Auth::guard($activeGuard)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sukses','anda telah logout.');
    }

}