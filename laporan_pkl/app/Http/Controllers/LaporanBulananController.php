<?php

namespace App\Http\Controllers;

use App\Models\Laporan_Bulanan;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanBulananController extends Controller
{
    public function index(Request $request){

        $selectedMuridId = null;
        $murids = collect();

        if(Auth::guard('murid')->check()){
            $selectedMuridId=Auth::guard('murid')->id();
        } elseif(Auth::guard('guru')->check()){
            $guruId=Auth::guard('guru')->id();
            $murids = Murid::where('guru_pembimbing_id', $guruId)->get();
            $selectedMuridId = $request->input('murid_id', $murids->first()?->id);
        } elseif(Auth::guard('dudi')->check()){
            $dudiId=Auth::guard('dudi')->id();
            $murids = Murid::where('dudi_id', $dudiId)->get();
            $selectedMuridId = $request->input('murid_id', $murids->first()?->id);
        } else{
            abort(403, 'Akses ditolak');
        }

        $laporans = Laporan_Bulanan::where('murid_id', $selectedMuridId)
        ->with(['murid','pembimbing','dudi'])
        ->get()
        ->keyBy(function($item){
            return (int) $item->bulan_ke;
        });
        
        return view('laporan-bulanan.index',compact('laporans', 'selectedMuridId','murids'));
    }
    public function show(){
        
    }

    public function create(){

        $murid=Auth::guard('murid')->user();

        $jumlahLaporan = Laporan_Bulanan::where('murid_id', $murid->id)->count();

        if($jumlahLaporan >= 6){
            return redirect()->route('laporan-bulanan.index')->with('error','anda sudah membuat 6 laporan bulanan!');
        }

        return view('laporan-bulanan.tambah', compact('murid','jumlahLaporan'));
    }
    
    public function store(Request $request){
        $muridAktif=Auth::guard('murid')->user();

        $jumlahLaporan = Laporan_Bulanan::where('murid_id', $muridAktif->id)->count();

        if($jumlahLaporan >= 6){
            return redirect()->route('laporan-bulanan.index')->with('error','anda sudah membuat 6 laporan bulanan!');
        }

        if(Auth::guard('murid')->check()){
            $request->validate([
            'nama_pekerjaan'=>'required|string',
            'perencanaan_kegiatan'=>'required|string',
            'pelaksanaan_kegiatan'=>'required|string',
            ]);

            $bulanke = $jumlahLaporan + 1;

            Laporan_Bulanan::create([
                'murid_id'=>$muridAktif->id,
                'dudi_id'=>$muridAktif->dudi_id,
                'guru_pembimbing_id'=>$muridAktif->guru_pembimbing_id,
                'bulan_ke'=>$bulanke,
                'nama_pekerjaan'=>$request->nama_pekerjaan,
                'perencanaan_kegiatan'=>$request->perencanaan_kegiatan,
                'pelaksanaan_kegiatan'=>$request->pelaksanaan_kegiatan,
                'status_verifikasi'=>'pending',
            ]);
        }

        if(Auth::guard('murid')->check()){
            return redirect()->route('murid.bulanan.index')->with('suskes','berhasil ditambahkan oleh murid');
        }
        if(Auth::guard('dudi')->check()){
            return redirect()->route('dudi.bulanan.index')->with('suskes','berhasil ditambahkan oleh dudi');
        }

        return redirect()->route('laporan-bulanan.index')->with('sukses','data berhasil ditambahkan');
    }

    public function update(Request $request,$id){

        
        $laporan = Laporan_Bulanan::findOrFail($id);

        if(Auth::guard('dudi')->check()){
            // if($laporan->status_verifikasi === 'diverifikasi'){
            // return redirect()->back()->with('error','laporan sudah dikunci atau diverifikasi');
            // }

            $request->validate([
                'catatan_instruktur'=>'nullable|string',
            ]);

            DB::beginTransaction();
            try {
            
            $laporan->update([
            'catatan_instruktur'=>$request->catatan_instruktur,
            'status_verifikasi'=>'diverifikasi',
            'diverifikasi_oleh_dudi'=>Auth::guard('dudi')->id(),
            ]);

            DB::commit();
            return redirect()->route('dudi.bulanan.index')->with('sukses','berhasil diupdate oleh Dudi');
            }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();    
            }
        }

        if(Auth::guard('murid')->check()){
            if($laporan->status_verifikasi === 'diverifikasi'){
                return redirect()->back()->with('error','laporan sudah dikunci atau diverifikasi');
            }
            
            $request->validate([
                'nama_pekerjaan'=>'required|string',
                'perencanaan_kegiatan'=>'required|string',
                'pelaksanaan_kegiatan'=>'required|string',
            ]);

            DB::beginTransaction();
            try {
            
            $laporan->update($request->only([
                'nama_pekerjaan','perencanaan_kegiatan','pelaksanaan_kegiatan'
            ]));

            DB::commit();
            return redirect()->route('murid.bulanan.index')->with('sukses','berhasil diupdate oleh Murid');
            }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();    
            }
        }
        
    }
    
    public function edit(Laporan_Bulanan $laporan, $id){
        $laporan = Laporan_Bulanan::findOrFail($id);

        if($laporan->status_diverifikasi === 'diverifikasi'){
            return redirect()->back()->with('error','data sudah di verifikasi atau dikunci');
        }

        return view('laporan-bulanan.edit', compact('laporan'));
    }

    public function delete(Laporan_Bulanan $laporan, $id){

        $laporan = Laporan_Bulanan::findOrFail($id);

        // if($laporan->status_verifikasi === 'diverifikasi'){
        //     return redirect()->back()->with('error','data sudah dikunci atau di verifikasi');
        // }

        $laporan->delete();

        if(Auth::guard('murid')->check()){
            return redirect()->route('murid.bulanan.index')->with('sukses','data berhasil dihapus oleh Murid');
        }
        if(Auth::guard('dudi')->check()){
            return redirect()->route('dudi.bulanan.index')->with('sukses','data berhasil dihapus oleh Dudi');
        }
        return redirect()->route('laporan-bulanan.index')->with('sukses','data berhasil dihapus');

    }

    public function verifikasi(Request $request,$id){
        $laporan=Laporan_Bulanan::findOrFail($id);

        if(Auth::guard('dudi')->check()){
            $laporan->update([
                'status_verifikasi' => 'Diverifikasi',
                'Diverifikasi oleh Dudi' => Auth::guard('dudi')->id(),
            ]);
        }

        if(Auth::guard('murid')->check()){
            return redirect()->route('murid.bulanan.index')->with('sukses','data berhasil diverifikasi');
        }
        if(Auth::guard('dudi')->check()){
            return redirect()->route('dudi.bulanan.index')->with('sukses','data berhasil diverifikasi');
        }
        return redirect()->route('laporan-bulanan.index')->with('sukses','data telah berhasil di verifikasi');
    }
}