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
        if(Auth::guard('web')->check()){
            $nilai=Laporan_Nilai::with('murid')->latest()->get();
        }elseif(Auth::guard('guru')->check()){
            $guruId=Auth::guard('guru')->id();
            $nilai=Laporan_Nilai::whereHas('murid',function($query) use ($guruId){
                $query->where('guru_pembimbing_id',$guruId);
            })->with('murid')->latest()->get();
        }elseif(Auth::guard('dudi')->check()){
            $dudiId=Auth::guard('dudi')->id();
            $nilai=Laporan_Nilai::whereHas('murid',function($query) use ($dudiId){
                $query->where('dudi_id',$dudiId);
            })->with('murid')->latest()->get();
        }else{
            abort(403);
        }
        return view('daftar-nilai.index',compact('nilai'));
    }

    public function create()
    {
        $this->authCrud();
        if(Auth::guard('guru')->check()){
            
        $murid=Murid::Where('guru_pembimbing_id',Auth::guard('guru')->id())->get();
        }elseif(Auth::guard('dudi')->check()){
            $murid=Murid::Where('dudi_id',Auth::guard('dudi')->id())->get();
        }else{
        $murid=Murid::orderBy('nama')->get();
    }
        $indikators=Tujuan_Pembelajaran_Indikator::all();

        return view('daftar-nilai.tambah',compact('murid','indikators'));
    }

    public function store(Request $request)
    {
        $this->authCrud();
        $cekNilai=Laporan_Nilai::where('murid_id',$request->murid_id)->exists();
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
            return redirect()->route('laporan-nilai.index')->with('sukses','berhasil disimpan');
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
        return view('daftar-nilai.index',compact('laporan'));
    }
    

    public function edit($id)
    {
        $this->authCrud();
         $laporan=Laporan_Nilai::with('details')->findOrFail($id);

         if(!$this->cekAksesData($laporan)){
            abort(403,'anda tidak memiliki akses untuk mengubah data');
         }
        $indikators=Tujuan_Pembelajaran_Indikator::all();
        $nilaiEksis=$laporan->details->keyBy('indikator_id');
        $infoUmum=$laporan;
        return view('laporan-nilai.edit',compact('indikators','laporan','nilaiEksis','infoUmum'));
    }

    public function update(Request $request,$id)
    {
        $this->authCrud();
        $this->validateRequest($request);

        DB::beginTransaction();
        try{

            $laporan=Laporan_Nilai::findOrFail($id);
            if(!$this->cekAksesData($laporan)){
                abort(403,'anda tidak memiliki akses dari data');
            }
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
            return redirect()->route('laporan-nilai.index')->with('sukses','laporan berhasil di update');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','gagal update data: '.$e->getMessage())->withInput();
        };
    }

    
    public function destroy($id)
    {
        $this->authCrud();
        
        
        try{
            $laporan=Laporan_Nilai::findOrFail($id);
            if(!$this->cekAksesData($laporan)){
                abort(403,'anda tidak memiliki akses untuk mengubah data');
             }    
            $laporan->delete();
            return redirect()->route('laporan-nilai.index')->with('sukses','data berhasil di hapus');
        }catch(\exception $e){
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    protected function validateRequest(Request $request){
        return $request->validate([
            'murid_id' =>'required|exists:murid,id',
            'nisn' =>'required|string',
            'tanggal_mulai' =>'required|date',
            'tanggal_berakhir' =>'required|date',
            'kehadiran_sakit' =>'required|integer|min:0',
            'kehadiran_ijin' =>'required|integer|min:0',
            'kehadiran_tanpa_keterangan' =>'required|integer|min:0',
            'catatan' =>'nullable|string',
            'nilai' =>'required|array',
            'nilai.*.skor' =>'required|numeric|min:0|max:100',
            'nilai.*.deskripsi' =>'nullable|string',
        ]);
    }

    public function verifikasidetail($id){
        $detail=Laporan_nilai_details::findOrFail($id);

        if(Auth::guard('web')->check()){
            abort(403);
        }
        if(Auth::guard('guru')->check()){
            $detail->diverifikasi_oleh_guru = Auth::guard('guru')->id();
        }

        if(Auth::guard('dudi')->check()){
            $detail->diverfikasi_oleh_dudi=Auth::guard('dudi')->id();
        }
        if($detail->diverifikasi_oleh_guru && $detail->diverifikasi_oleh_dudi){
            $detail->status_verifikasi='diverifikasi';
        }
        if(Auth::guard('web')->check()){
            abort(403);
        }

        $detail->save();

        return back()->with('sukses','data berhasil diverifikasi');
    }

    private function authCrud(){
        if(!Auth::guard('web')->check() && !Auth::guard('guru')->check() && !Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
    }

    private function cekAksesData($laporan){
        if(Auth::guard('web')->check()){
            return true;
        }
    
        if(Auth::guard('guru')->check()){
            return $laporan->murid->guru_pembimbing_id == Auth::guard('guru')->id();
        }
    
        if(Auth::guard('dudi')->check()){
            return $laporan->murid->dudi_id == Auth::guard('dudi')->id();
        }
    
       

    return false;
    }
}