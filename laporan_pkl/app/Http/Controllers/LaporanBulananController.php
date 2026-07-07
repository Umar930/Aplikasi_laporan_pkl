<?php

namespace App\Http\Controllers;

use App\Models\laporan_bulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanBulananController extends Controller
{
    public function index(){
        if(Auth::guard('murid')->check()){
            $murid_id=Auth::guard('murid')->id();
            $laporans=laporan_bulanan::where('murid_id',$murid_id)->latest()->get();
        }
        if(Auth::guard('guru')->check()){
            $guruId=Auth::guard('guru')->id();
            $laporans=laporan_bulanan::whereHas('murid',function($query) use ($guruId){
                $query->where('guru_pembimmbing_id',$guruId);
            })->with('murid')->latest()->get();
        }
        if(Auth::guard('dudi')->check()){
            $dudiId=Auth::guard('dudi')->id();
            $laporans=laporan_bulanan::whereHas('murid',function($query) use ($dudiId){
                $query->where('dudi_id',$dudiId);
            })->with('murid')->latest()->get();
        }
        return view('laporan-bulanan.index',compact('laporans'));
    }
    public function show(){
        
    }

    public function create(){
        if(!Auth::guard('murid')->check() && Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }

        $murid=Auth::guard('murid')->user();

        return view('laporan-bulanan.tambah');
    }
    
    public function store(Request $request){
        if(Auth::guard('murid')->check()){
            abort(403,'akses ditolak');
        }

        $request->validate([
            'nama_pekerjaan'=>'required|string',
            'perencanaan_kegiatan'=>'required|string',
            'pelaksanaa_kegiatan'=>'required|string',
            
        ]);

        $muridAktif=Auth::guard('murid')->user();

        laporan_bulanan::create([
            'murid_id'=>$muridAktif->id,
            'dudi_id'=>$muridAktif->dudi_id,
            'guru_pembimbing_id'=>$muridAktif->guru_pembimbing_id,
            'nama_pekerjaan'=>$request->guru_pembimbing_id,
            'perencanaan_kegiatan'=>$request->perencanaan_kegiatan,
            'pelaksanaa_kegiatan'=>$request->pelaksanaa_kegiatan,
            'status_verifikasi'=>'pending',
        ]);

        return redirect('laporan-bulanan.index')->with('sukses','data berhasil ditambahkan');
    }

    public function update(Request $request, laporan_bulanan $laporan){
        if(!Auth::guard('dudi')->check()){
            $request->validate([
                'catatan_instruktur'=>'required|string'
            ]);
        }

        if($laporan->status_verifikasi === 'diverifikasi'){
            return redirect()->back()->with('error','laporan sudah dikunci atau diverifikasi');
        }

        $laporan->update([
            'catatan_instruktur'=>$request->catatan_instruktur,
            'status_verifikasi'=>'diverifikasi',
            'diverifikasi_oleh_dudi'=>Auth::guard('dudi')->id(),
        ]);

        if(Auth::guard('murid')->check()){
            if($laporan->status_verifikasi === 'diverifikasi'){
                return redirect()->back()->with('error','laporan sudah dikunci atau diverifikasi');
            }
            
            $request->validate([
                'nama_pekerjaan'=>'required|string',
                'perencanaan_kegiatan'=>'required|string',
                'pelaksanaa_kegiatan'=>'required|string',
            ]);

            $laporan->update($request->only([
                'nama_pekerjaan','perencanaan_kegiatan','pelaksanaa_kegiatan'
            ]));
            return redirect('laporan-bulanan.index')->with('sukses','data berhasil diubah');
        }

        abort(403);
    }
    
    public function edit(laporan_bulanan $laporan){

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
