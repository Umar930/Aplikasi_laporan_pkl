<?php

namespace App\Http\Controllers;

use App\Models\Laporan_Harian;
use App\Models\Laporan_Nilai;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HarianController extends Controller
{
    public function index(){
        if(Auth::guard('murid')->check()){
            $murid_id=Auth::guard('murid')->id();
            $laporans=Laporan_Harian::where('murid_id',$murid_id)->latest()->get();
            return view('laporan-harian.index',compact('laporans'));
        }
        if(Auth::guard('guru')->check()){
            $guruId=Auth::guard('guru')->id();
            $laporans=Laporan_Harian::whereHas('murid',function($query) use ($guruId){
            $query->where('guru_pembimbing_id',$guruId);
            })->with('murid')->latest()->get();
            return view('laporan-harian.index',compact('laporans'));
        }
        if(Auth::guard('dudi')->check()){
            $dudiId=Auth::guard('dudi')->id();
            $laporans=Laporan_Harian::whereHas('murid',function($query) use ($dudiId){
            $query->where('dudi_id',$dudiId);
            })->with('murid')->latest()->get();
            return view('laporan-harian.index',compact('laporans'));
        }

        if(Auth::guard('web')->check()){
            $laporans=Laporan_Harian::with(['murid','dudi','guru'])->latest()->get();
            return view('laporan-harian.index',compact('laporans'));
        }

        abort(403,'akses ditolak');
    }
    
    public function edit(Laporan_Harian $laporan){
        if(!Auth::guard('murid')->check() || $laporan->murid_id !== Auth::guard('murid')->id()){
            abort(403);
        }

        if($laporan->status_verifikasi === 'diverifikasi'){
            return redirect()->back()->with('error','laporan sudah terkunci atau diverifikasi');
        }

        return view('laporan-harian.edit');
    }

    public function create(){
        if(!Auth::guard('murid')->check()){
            abort(403,'akses ditolak');
        }
        return view('laporan-harian.tambah',compact('harian'));
    }

    public function store(Request $request){
        if(Auth::guard('murid')->check()){
            abort(403,'akses ditolak');
        }

        $request->validate([
            'tanggal_hari'=>'required|date',
            'kompetensi_dasar'=>'required|string',
            'Topik_pembelajaran'=>'required|string',
            'nilai_karakter_budaya'=>'required|string',
        ]);

        Laporan_Harian::create([
            'murid_id' => Auth::guard('murid')->id(),
            'tanggal_hari'=>$request->tanggal_hari,
            'kompetensi_dasar'=>$request->kompetensi_dasar,
            'nilai_karakter_budaya'=>$request->nilai_karakter_budaya,
            'status_verifikasi'=>'pending'
        ]);

        return redirect('laporan-harian.index')->with('sukses','data berhasil di tambahkan');
    }

    public function show(){

    }
    
    public function update(Request $request,Laporan_Harian $laporan){

        if(!Auth::guard('murid')->check() || $laporan->murid_id !== Auth::guard('murid')->id()){
            abort(403);
        }

        if($laporan->status_verifikasi === 'diverifikasi'){
            return redirect()->back()->with('error','laporan sudah dikunci atau diverifikasi');
        }

        $request->validate([
            'tanggal_hari'=>'requeired|date',
            'kompetensi_dasar'=>'requeired|string',
            'Topik_Pembelajaran'=>'requeired|string',
            'nilai_karakter_budaya'=>'requeired|string',
        ]);

        $laporan->update($request->all());

        return redirect('laporan-harian.index')->with('sukses','data berhasil diubah');
    }
    
    public function delete(Laporan_Harian $laporan){
        if(!Auth::guard('murid')->check() || $laporan->murid_id !== Auth::guard('murid')->id()){
            abort(403);
        }

        if($laporan->status_verifikasi === 'diverifikasi'){
            return redirect()->back()->with('error','laporan sudah diverifikasi atau dikunci');
        }

        $laporan->delete();
        return redirect('laporan-harian.index')->with('sukses','data berhasil dihapus');
    }

    public function verifikasi(Request $request,$id){
        $laporan=Laporan_Harian::findOrFail($id);

        if(Auth::guard('guru')->check()){
            $laporan->diverifikasi_oleh_guru=Auth::guard('guru')->id();
        }
        elseif(Auth::guard('dudi')->check()){
            $laporan->diverifikasi_oleh_dudi=Auth::guard('dudi')->id();
        }
        elseif(Auth::guard('web')->check()){
            $laporan->diverifikasi_oleh_admin=Auth::guard('web')->id();
        }
        else{
            abort(403,'akses anda ditolak');
        }

        return redirect()->route('laporan-harian.index')->with('sukses','data telah berhasil diverifikasi');
    }
} 