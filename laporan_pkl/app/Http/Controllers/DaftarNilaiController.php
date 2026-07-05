<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Laporan_Nilai;
use App\Models\Tujuan_Pembelajaran_Indikator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DaftarNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $nilai=Laporan_Nilai::all();
        $indikators=Tujuan_Pembelajaran_Indikator::all();
        return view('daftar-nilai.index',compact('nilai','indikators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($murid_id)
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }
        $murid=Murid::findOrFail($murid_id);
        $indikators=Tujuan_Pembelajaran_Indikator::all();

        $cekNilai=Laporan_Nilai::where('murid_id',$murid_id)->exists();
            if($cekNilai){
                return redirect()->route('laporan-nilai.edit',$murid_id)->with(
                    'info','data nilai sudah ada'
                );
            }
        $nilaiEksis=collect();
        return view('daftar-nilai.tambah',compact('murid','indikators','nilaiEksis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$murid_id)
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }
        $this->validateRequest($request);

        DB::beginTransaction();
        try{
            foreach($request->nilai as $indikator_id=>$dataIndikator){
                Laporan_Nilai::create([
                    'murid_id'=>$murid_id,
                    'indikator_id'=>$indikator_id,
                    'nisn' => $request->nisn,
                    'tanggal_mulai'=>$request->tanggal_mulai,
                    'tanggal_berakhir'=>$request->tanggal_berakhir,
                    'skor'=>$dataIndikator['skor'],
                    'deskripsi'=>$dataIndikator['deskripsi']??null,
                    'catatan'=>$request->catatan,
                    'kehadiran_sakit'=>$request->kehadiran_sakit,
                    'kehadiran_ijin'=>$request->kehadiran_ijin,
                    'kehadiran_tanpa_keterangan'=>$request->kehadiran_tanpa_keterangan,
                ]);
            }
            DB::commit();
            return redirect()->route('laporan-nilai.index',$murid_id)->with('sukses','berhasil disimpan');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($murid_id)
    {
        $murid=Murid::findOrFail($murid_id);
        $daftarNilai=Laporan_Nilai::with('indikator')->where('murid_id',$murid_id)->get();
        $infoUmum=$daftarNilai->first();

        return view('daftar-nilai.tambah',compact('murid','daftarNilai','infoUmum'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($murid_id)
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }
        $murid=Murid::findOrFail($murid_id);
        $indikators=Tujuan_Pembelajaran_Indikator::all();
        

        $nilaiEksis=Laporan_Nilai::where('murid_id',$murid_id)->get()->keyBy('indikator_id');

        if($nilaiEksis->isEmpty()){
            return redirect()->route('laporan-nilai.edit',$murid_id)->with('error','data nilai belum harap mengisi dulu');
        }

        $infoUmum=$nilaiEksis->first();
        return view('laporan-nilai.edit',compact('murid','indikators','nilaiEksis','infoUmum'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$murid_id)
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }
        $this->validateRequest($request);

        DB::beginTransaction();
        try{
            foreach($request->nilai as $indikator_id=>$dataIndikator){
                Laporan_Nilai::updateOrCreate([
                    'murid_id'=>$murid_id,
                    'indikator_id'=>$indikator_id,
                ],[
                    'nisn' => $request->nisn,
                    'tanggal_mulai'=>$request->tanggal_mulai,
                    'tanggal_berakhir'=>$request->tanggal_berakhir,
                    'skor'=>$dataIndikator['skor'],
                    'deskripsi'=>$dataIndikator['deskripsi']??null,
                    'catatan'=>$request->catatan,
                    'kehadiran_sakit'=>$request->kehadiran_sakit,
                    'kehadiran_ijin'=>$request->kehadiran_ijin,
                    'kehadiran_tanpa_keterangan'=>$request->kehadiran_tanpa_keterangan,
                ]);
            }
            DB::commit();
            return redirect()->route('laporan-nilai.index',$murid_id)->with('sukses','laporan berhasil di update');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error','gagal update data: '.$e->getMessage())->withInput();
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($murid_id)
    {
        if (!Auth::guard('guru')->check() && !Auth::guard('dudi')->check()) {
            abort(403, 'Akses ditolak');
        }
        try{
            Laporan_Nilai::where('murid_id',$murid_id)->delete();

            return redirect()->route('dashboard')->with('sukses','data berhasil di hapus');
        }catch(\exception $e){
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    protected function validateRequest(Request $request){
        return $request->validate([
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
}