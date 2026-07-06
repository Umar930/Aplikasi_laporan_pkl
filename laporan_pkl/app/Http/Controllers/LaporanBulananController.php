<?php

namespace App\Http\Controllers;

use App\Models\laporan_bulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulananController extends Controller
{
    public function index(){
        if(Auth::guard('murid')->check()){
            $murid_id=Auth::guard('murid')->id();
            $laporans=laporan_bulanan::where('murid_id',$murid_id)->latest()->get();
            return view('laporan-bulanan.index',compact('laporans'));
        }
        if(Auth::guard('guru')->check()){
            $guruId=Auth::guard('guru')->id();
            $laporans=laporan_bulanan::whereHas('murid',function($query) use ($guruId){
                $query->where('guru_pembimmbing_id',$guruId);
            })->with('murid')->latest()->get();
            return view('laporan-bulanan.index',compact('laporans'));
        }
        if(Auth::guard('dudi')->check()){
            $dudiId=Auth::guard('dudi')->id();
            $laporans=laporan_bulanan::whereHas('murid',function($query) use ($dudiId){
                $query->where('dudi_id',$dudiId);
            })->with('murid')->latest()->get();
            return view('laporan-bulanan.index',compact('laporans'));
        }
    }
    public function show(){
        
    }

    public function create(laporan_bulanan $laporan){
        if(!Auth::guard('murid')->check() && Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }

        return view('laporan-bulanan.tambah');
    }
    
    public function store(Request $request){
        if(Auth::guard('murid')->check()){
            abort(403,'akses ditolak');
        }

        $request->validate([
            'dudi_id'=>'required|exist:identitas_dudi,id',
            'guru_pembimbing'=>'required|exist:guru_pembimbings,id',
            'nama_pekerjaan'=>'required|string',
            'perencanaan_kegiatan'=>'required|string',
            'pelaksanaa_kegiatan'=>'required|string',
            
        ]);

        laporan_bulanan::create([
            'murid_id'=>Auth::guard('murid')->id(),
            'dudi_id'=>Auth::guard('dudi')->id(),
            'guru_pembimbing_id'=>$request->guru_pembimbing_id,
            'nama_pekerjaan'=>$request->guru_pembimbing_id,
            'perencanaan_kegiatan'=>$request->perencanaan_kegiatan,
            'pelaksanaa_kegiatan'=>$request->pelaksanaa_kegiatan,
            'status_verifikasi'=>'pending',
        ]);

        return redirect('laporan-bulanan.index')->with('sukses','data berhasil ditambahkan');
    }

    public function update(Request $request, laporan_bulanan $laporan){
        if(!Auth::guard('murid') || $laporan->murid_id !== Auth::guard('murid')->id()){
            abort(403,'akses ditolak');
        }

        if($laporan->status_verifikasi === 'diverifikasi'){
            return redirect()->back()->with('error','laporan sudah dikunci atau diverifikasi');
        }

        $request->validate([
            'nama_pekerjaan'=>'required|string',
            'perencaan_kegiatan'=>'required|string',
            'pelaksanaa_kegiatan'=>'required|string',
        ]);

        $laporan->update($request->all());

        return redirect('laporan-bulanan.index')->with('sukses','data berhasil diubah');

    }
    
    public function edit(laporan_bulanan $laporan){
        if(!Auth::guard('murid')->check() || $laporan->murid_id !== Auth::guard('murid')->id()){
            abort(403,'akses ditolak');
        }

        if($laporan->status_diverifikasi === 'diverifikasi'){
            return redirect()->back()->with('error','data sudah di verifikasi atau dikunci');
        }

        return view('laporan-bulanan.edit');
    }
    public function delete(laporan_bulanan $laporan){
        if(!Auth::guard('murid')->check() || $laporan->murid_id !== Auth::guard('murid')->id()){
            abort(403,'akses ditolak');
        }

        if($laporan->status_verifikasi === 'diverifikasi'){
            return redirect()->back()->with('error','data sudah dikunci atau di verifikasi');
        }

        $laporan->delete();
        return redirect('laporan-bulanan.index')->with('sukses','data berhasil dihapus');

    }

    public function verifikasi(Request $request,$id){
        $laporan=laporan_bulanan::findOrFail($id);

        if(Auth::guard('dudi')->check()){
            $laporan->diverifikasi_oleh_dudi=Auth::guard('dudi')->id();
        }else{
            abort(403,'akses ditolak');
        }

        return redirect()->route('laporan-bulanan.index')->with('sukses','data telah berhasil di verifikasi');
    }
}
