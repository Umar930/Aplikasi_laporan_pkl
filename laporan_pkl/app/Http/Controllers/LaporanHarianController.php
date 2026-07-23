<?php

namespace App\Http\Controllers;

use App\Models\Laporan_Harian;
use App\Models\Laporan_Nilai;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanHarianController extends Controller
{
    public function index(Request $request){

        $selectedMuridId = null; 
        $murids = collect();

        if(Auth::guard('murid')->check()){
            $selectedMuridId=Auth::guard('murid')->id();
        }elseif(Auth::guard('guru')->check()){
            $guruId=Auth::guard('guru')->id();
            $murids=Murid::where('guru_pembimbing_id', $guruId)->get();
            $selectedMuridId = $request->get('murid_id', $murids->first()?->id);
        }elseif(Auth::guard('dudi')->check()){
            $dudiId=Auth::guard('dudi')->id();
            $murids=Murid::where('dudi_id', $dudiId)->get();
            $selectedMuridId = $request->get('murid_id', $murids->first()?->id);
        }elseif(Auth::guard('web')->check()){
            $murids = Murid::all();
            $selectedMuridId = $request->get('murid_id', $murids->first()?->id);
        }else{
            abort(403,'akses ditolak');
        }

        $selectedMurid = Murid::find($selectedMuridId);

        $laporansGroupped = collect();
        if($selectedMuridId){
            $laporansGroupped = Laporan_Harian::where('murid_id', $selectedMuridId)
                ->orderBy('tanggal_hari', 'asc')
                ->get()
                ->groupBy('minggu_ke');
        }

        return view('laporan-harian.index',compact('murids','selectedMuridId','selectedMurid','laporansGroupped'));
    }
    
    public function edit(Laporan_Harian $laporan,$id){

        if($laporan->diverifikasi_oleh_dudi || $laporan->diverifikasi_oleh_guru){
            return redirect()->back()->with('error','laporan sudah terkunci atau diverifikasi');
        }

        return view('laporan-harian.edit');
    }

    public function create(){

        return view('laporan-harian.tambah');
    }

    public function store(Request $request){

        $muridAktif = Auth::guard('murid')->user();

        $jumlahLaporan = Laporan_Harian::where('murid_id', $muridAktif->id)->count();

        if($jumlahLaporan >= 168){
            return redirect()->route('laporan-harian.index')->with('error','Anda sudah memenuhi batas maksimal laporan harian');
        }

        $request->validate([
            'tanggal_hari'=>'required|date',
            'kompetensi_dasar'=>'required|string',
            'Topik_pembelajaran'=>'required|string',
            'nilai_karakter_budaya'=>'required|string',
        ]);

        $mingguKe = (int) ceil(($jumlahLaporan + 1) / 7 );

        Laporan_Harian::create([
            'murid_id' => $muridAktif->id,
            'minggu_ke'=> $mingguKe,
            'tanggal_hari'=>$request->tanggal_hari,
            'kompetensi_dasar'=>$request->kompetensi_dasar,
            'Topik_pembelajaran'=>$request->Topik_pembelajaran,
            'nilai_karakter_budaya'=>$request->nilai_karakter_budaya,
            'status_verifikasi'=>'pending'
        ]);

        return redirect()->route('murid.harian.index')->with('sukses','berhasil tambah laporan harian untuk minggu ke-'.$mingguKe);
    }

    public function show(){

    }
    
    public function update(Request $request,Laporan_Harian $laporan){

        if($laporan->diverifikasi_oleh_dudi || $laporan->diverifikasi_oleh_guru){
            return redirect()->back()->with('error','laporan sudah dikunci atau diverifikasi');
        }

        $request->validate([
            'tanggal_hari'=>'requeired|date',
            'kompetensi_dasar'=>'requeired|string',
            'Topik_Pembelajaran'=>'requeired|string',
            'nilai_karakter_budaya'=>'requeired|string',
        ]);

        $laporan->update($request->all());

        return redirect('murid.harian.index')->with('sukses','data laporan harian berhasil diupdate');
    }
    
    public function delete(Laporan_Harian $laporan,$id){

        if($laporan->diverifikasi_oleh_dudi || $laporan->diverifikasi_oleh_guru){
            return redirect()->back()->with('error','laporan sudah diverifikasi atau dikunci');
        }

        $laporan = Laporan_Harian::findOrFail($id);
        $laporan->delete();
        return redirect()->route('murid.harian.index')->with('sukses','data laporan harian berhasil dihapus');
    }

    public function verifikasiDudi(Request $request,$id){
        $laporan=Laporan_Harian::findOrFail($id);

        if(!Auth::guard('dudi')->check()){
            abort(403, 'Akses khusus Pembimbing Dudi');
        }

        $laporan->update([
            'diverifikasi_oleh_dudi' => Auth::guard('dudi')->id()
        ]);
    

        return redirect()->back()->with('sukses','Laporan Harian berhasil diverifikasi');
    }

    public function verifikasiGuru(Request $request,$id){
        $laporan=Laporan_Harian::findOrFail($id);

        if(!Auth::guard('guru')->check()){
            abort(403, 'Akses khusus Guru Pembimbing');
        }

        $request->validate([
            'murid_id'=>'required|exists:murid,id',
            'minggu_ke'=>'required|integer',
        ]);

        Laporan_Harian::where('murid_id',$request->murid_id)
            ->where('minggu_ke',$request->minggu_ke)
            ->update([
                'diverifikasi_oleh_guru' => Auth::guard('guru')->id()
            ]);

        return redirect()->back()->with('sukses','seluruh laporan harian Minggu ke-' . $request->minggu_ke . 'berhasil diverifikasi');
    }
} 