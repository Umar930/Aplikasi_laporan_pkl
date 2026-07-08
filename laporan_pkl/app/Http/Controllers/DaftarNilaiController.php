<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Laporan_Nilai;
use App\Models\Laporan_nilai_details;
use App\Models\Tujuan_Pembelajaran_Indikator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DaftarNilaiController extends Controller
{
    public function index()
    {
        $nilai=Laporan_Nilai::with('murid')->latest()->get();
        return view('daftar-nilai.index',compact('nilai'));
    }

    public function create()
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }
        $murid=Murid::orderBy('nama')->get();
        $indikators=Tujuan_Pembelajaran_Indikator::all();

        return view('daftar-nilai.tambah',compact('murid','indikators','nilaiEksis'));
    }

    public function store(Request $request,$murid_id)
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }

        $cekNilai=Laporan_Nilai::where('murid_id',$request->murid_id)->exist();

        if($cekNilai){
            return back()->with('error','data nilai siswa sudah ada');
        }
        
        $this->validateRequest($request);

        DB::beginTransaction();
        try{

            $laporan=Laporan_Nilai::create([
                'murid_id'=>$request->murid_id,
                'nisn'=>$request->nisn,
                'tanggal_mulai'=>$request->tanggal_mulai,
                'tanggal_berakhir'=>$request->tanggal_berakhir,
                'catatan'=>$request->catatan,
                'kehadiran_sakit'=>$request->kehadiran_sakit,
                'kehadiran_ijin'=>$request->kehadiran_ijin,
                'kehadiran_tanpa_keterangan'=>$request->kehadiran_tanpa_keterangan,
            ]);

            foreach($request->nilai as $indikator_id=>$dataIndikator){
                Laporan_nilai_details::create([
                    'laporan_nilai_id'=>$laporan->id,
                    'indikator_id'=>$indikator_id,
                    'skor'=>$dataIndikator['skor'],
                    'deskripsi'=>$dataIndikator['deskripsi']??null,
                    
                ]);
            }
            DB::commit();
            return redirect()->route('laporan-nilai.index',$murid_id)->with('sukses','berhasil disimpan');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();
        }
    }

    public function show(String $id)
    {
        $laporan=Laporan_Nilai::with([
            'murid',
            'details.indikator'
        ])->findOrFail($id);
        return view('daftar-nilai.tambah',compact('laporan'));
    }

    public function edit($id,$murid_id)
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }
        $laporan=Laporan_Nilai::with('details')->findOrFail($id);
        $indikators=Tujuan_Pembelajaran_Indikator::all();
        

        return view('laporan-nilai.edit',compact('murid','indikators','nilaiEksis','infoUmum'));
    }

    public function update(Request $request,$murid_id,$id)
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }
        $this->validateRequest($request);

        DB::beginTransaction();
        try{

            $laporan=Laporan_Nilai::findOrFail($id);

            $laporan->update([
                'tanggal_mulai'=>$request->tanggal_mulai,
                'tanggal_berakhir'=>$request->tanggal_berakhir,
                'catatan'=>$request->catatan,
                'kehadiran_sakit'=>$request->kehadiran_sakit,
                'kehadiran_ijin'=>$request->kehadiran_ijin,
                'kehadiran_tanpa_keterangan'=>$request->kehadiran_tanpa_keterangan,    
            ]);
            foreach($request->nilai as $indikator_id=>$dataIndikator){
                Laporan_nilai_details::updateOrCreate([
                    'laporan_nilai_id'=>$id,
                    'indikator_id'=>$indikator_id,
                ],[
                    'skor'=>$dataIndikator['skor'],
                    'deskripsi'=>$dataIndikator['deskripsi']??null,
                ]);
            }
            DB::commit();
            return redirect()->route('laporan-nilai.index',$murid_id)->with('sukses','laporan berhasil di update');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','gagal update data: '.$e->getMessage())->withInput();
        };
    }

    
    public function destroy($murid_id,$id)
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }
        try{
            $laporan=Laporan_Nilai::findOrFail($id);
            $laporan->delete();
            return redirect()->route('dashboard')->with('sukses','data berhasil di hapus');
        }catch(\exception $e){
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    protected function validateRequest(Request $request){
        return $request->validate([
            'murid_id' =>'required|exist:murid,id',
            'nisn' =>'required|string',
            'tanggal_mulai' =>'required|date',
            'tanggal_berakhir' =>'required|date',
            'kehadiran_sakit' =>'required|integer|min:0',
            'kehadiran_ijin' =>'required|integer|min:0',
            'kehadiran_tanpa_keterangan' =>'required|integer|min:0',
            'catatan' =>'nullable|string',
            'nilai' =>'required|array',
            'nilai.*.skor' =>'required|numeric|min:0|max:100',
            'nilai.*.deskrpsi' =>'required|string',
        ]);
    }

    public function verifikasidetail($id){
        $detail=Laporan_nilai_details::findOrFail($id);

        if(Auth::guard('guru')->check()){
            $detail->guru_verifikator_id = Auth::guard('guru')->id();
        }

        if(Auth::guard('dudi')->check()){
            $detail->dudi_verifikator_id=Auth::guard('dudi')->id();
        }
        if($detail->dudi_verifikator_id && $detail->dudi_verifikator_id){
            $detail->status_verifikasi='diverifikasi';
        }

        $detail->save();

        return back()->with('sukses','data berhasil diverifikasi');
    }
}