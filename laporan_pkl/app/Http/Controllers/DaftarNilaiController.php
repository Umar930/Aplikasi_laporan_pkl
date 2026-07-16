<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Laporan_Nilai;
use App\Models\Laporan_nilai_details;
use App\Models\Tujuan_Pembelajaran_Indikator;
use App\Models\Konsentrasi_Keahlian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DaftarNilaiController extends Controller
{
    public function index()
    {
        if(Auth::guard('web')->check()){
            $query=Laporan_Nilai::with('murid','nilai_details');
        }elseif(Auth::guard('guru')->check()){
            $guruId=Auth::guard('guru')->id();
            $query=Laporan_Nilai::whereHas('murid',function($q) use ($guruId){
                $q->where('guru_pembimbing_id',$guruId);
            })->with('murid','nilai_details');
        }elseif(Auth::guard('dudi')->check()){
            $dudiId=Auth::guard('dudi')->id();
            $query=Laporan_Nilai::whereHas('murid',function($q) use ($dudiId){
                $q->where('dudi_id',$dudiId);
            })->with('murid','nilai_details');
        }else{
            abort(403);
        }

        $nilaiPaginate = $query->latest()->paginate(1);

        $laporanAktif = $nilaiPaginate->first();
        $nilaiEksis = collect();
        if($laporanAktif && $laporanAktif->nilai_details){
            $nilaiEksis = $laporanAktif->nilai_details->keyBy('indikator_id');
        }

        $query = Laporan_Nilai::with(['murid', 'nilai_details.indikator']);

        $konsentrasi = Konsentrasi_Keahlian::all();
        $tujuan_pembelajaran = Tujuan_Pembelajaran_Indikator::all()->groupBy('point_utama');
        return view('laporan-nilai.index',compact('konsentrasi','tujuan_pembelajaran','nilaiPaginate','laporanAktif','nilaiEksis'));
    }

    public function create()
    {
        $this->authCrud();
        if(Auth::guard('guru')->check()){
            
        $murid=Murid::Where('guru_pembimbing_id',Auth::guard('guru')->id())->get();
        }elseif(Auth::guard('dudi')->check()){
            $murid=Murid::Where('dudi_id',Auth::guard('dudi')->id())->get();
        }else{
        $murid=Murid::orderBy('nama_murid')->get();
    }
        $tujuan_pembelajaran=Tujuan_Pembelajaran_Indikator::all()->pluck('point_utama','id')->unique();

        $program = Konsentrasi_Keahlian::pluck('program_keahlian')->unique();
        $konsentrasi = Konsentrasi_Keahlian::all();

        if(Auth::guard('guru')->check()) {
            return view('laporan-nilai.tambah', compact('program','konsentrasi','murid','tujuan_pembelajaran'));
        }
        if(Auth::guard('dudi')->check()) {
            return view('laporan-nilai.tambah', compact('program','konsentrasi','murid','tujuan_pembelajaran'));
        }

        return view('laporan-nilai.tambah',compact('program','konsentrasi','murid','tujuan_pembelajaran'));
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
                'program_keahlian'=>$request->program_keahlian,
                'konsentrasi_keahlian'=>$request->konsentrasi_keahlian,
                'tempat_pkl'=>$request->tempat_pkl,
                'tanggal_mulai'=>$request->tanggal_mulai,
                'tanggal_berakhir'=>$request->tanggal_berakhir,
                'catatan'=>$request->catatan,
                'kehadiran_sakit'=>$request->kehadiran_sakit,
                'kehadiran_ijin'=>$request->kehadiran_ijin,
                'kehadiran_tanpa_keterangan'=>$request->kehadiran_tanpa_keterangan,
            ]);

            foreach($request->nilai as $index => $dataIndikator){
                if (!empty($dataIndikator['indikator_id'])) {
                    Laporan_nilai_details::create([
                    'laporan_nilai_id'=>$laporan->id,
                    'indikator_id'=>$dataIndikator['indikator_id'],
                    'skor'=>$dataIndikator['skor'],
                    'deskripsi'=>$dataIndikator['deskripsi']??null,
                    
                    ]);
                }
            }
            DB::commit();

            if (Auth::guard('guru')->check()) {
                return redirect()->route('guru.nilai.index')->with('sukses', 'data berhasil ditambahkan oleh Guru');
            } elseif (Auth::guard('dudi')->check()) {
                return redirect()->route('dudi.nilai.index')->with('sukses', 'data berhasil ditambahkan oleh Dudi');
            }

            return redirect()->back()->with('sukses','berhasil disimpan');
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
        return view('laporan-nilai.index',compact('laporan'));
    }
    

    public function edit($id)
    {
        $this->authCrud();

        if(Auth::guard('guru')->check()){
            
        $murid=Murid::Where('guru_pembimbing_id',Auth::guard('guru')->id())->get();
        }elseif(Auth::guard('dudi')->check()){
            $murid=Murid::Where('dudi_id',Auth::guard('dudi')->id())->get();
        }else{
        $murid=Murid::orderBy('nama_murid')->get();
        }

         $laporan=Laporan_Nilai::with('nilai_details')->findOrFail($id);

         if(!$this->cekAksesData($laporan)){
            abort(403,'anda tidak memiliki akses untuk mengubah data');
         }

        $tujuan_pembelajaran=Tujuan_Pembelajaran_Indikator::all()->pluck('point_utama','id')->unique();
        $konsentrasi = Konsentrasi_Keahlian::all();
        $program = Konsentrasi_Keahlian::pluck('program_keahlian')->unique();
        $nilaiEksis=$laporan->nilai_details->keyBy('indikator_id');
        $infoUmum=$laporan;

        if(Auth::guard('guru')->check()) {
            return view('laporan-nilai.edit', compact('laporan','program','konsentrasi','murid','tujuan_pembelajaran'));
        }
        if(Auth::guard('dudi')->check()) {
            return view('laporan-nilai.edit', compact('laporan','program','konsentrasi','murid','tujuan_pembelajaran'));
        }
        return view('laporan-nilai.edit',compact('program','konsentrasi','murid','tujuan_pembelajaran','laporan','nilaiEksis','infoUmum'));
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
                'murid_id'=>$request->murid_id,
                'nisn'=>$request->nisn,
                'program_keahlian'=>$request->program_keahlian,
                'konsentrasi_keahlian'=>$request->konsentrasi_keahlian,
                'tempat_pkl'=>$request->tempat_pkl,
                'tanggal_mulai'=>$request->tanggal_mulai,
                'tanggal_berakhir'=>$request->tanggal_berakhir,
                'catatan'=>$request->catatan,
                'kehadiran_sakit'=>$request->kehadiran_sakit,
                'kehadiran_ijin'=>$request->kehadiran_ijin,
                'kehadiran_tanpa_keterangan'=>$request->kehadiran_tanpa_keterangan,    
            ]);
            foreach($request->nilai as $index => $dataIndikator){
                if (!empty($dataIndikator['indikator_id'])) {
                    Laporan_nilai_details::updateOrCreate([
                    'laporan_nilai_id'=>$id,
                    'indikator_id'=>$dataIndikator['indikator_id'],
                    ],[
                    'skor'=>$dataIndikator['skor'],
                    'deskripsi'=>$dataIndikator['deskripsi']??null,
                    ]);
                }
            }
    
            DB::commit();

            if (Auth::guard('guru')->check()) {
                return redirect()->route('guru.nilai.index')->with('sukses', 'data berhasil diupdate oleh Guru');
            } elseif (Auth::guard('dudi')->check()) {
                return redirect()->route('dudi.nilai.index')->with('sukses', 'data berhasil diupdate oleh Dudi');
            }
            return redirect()->back()->with('sukses','laporan berhasil di update');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','gagal update data: '.$e->getMessage())->withInput();
        }
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

            if (Auth::guard('guru')->check()) {
                return redirect()->route('guru.nilai.index')->with('sukses', 'data berhasil dihapus oleh Guru');
            } elseif (Auth::guard('dudi')->check()) {
                return redirect()->route('dudi.nilai.index')->with('sukses', 'data berhasil dihapus oleh Dudi');
            }
            return redirect()->back()->with('sukses','data berhasil di hapus');
        }catch(\exception $e){
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    protected function validateRequest(Request $request){
        return $request->validate([
            'murid_id' =>'required|exists:murid,id',
            'nisn' =>'required|string',
            'program_keahlian' => 'required|string',
            'konsentrasi_keahlian' => 'required|string',
            'tanggal_mulai' =>'required|date',
            'tanggal_berakhir' =>'required|date',
            'tempat_pkl' =>'required|string',
            'kehadiran_sakit' =>'required|integer|min:0',
            'kehadiran_ijin' =>'required|integer|min:0',
            'kehadiran_tanpa_keterangan' =>'required|integer|min:0',
            'catatan' =>'nullable|string',
            'nilai' =>'required|array',
            'nilai.*.indikator_id' =>'nullable|integer',
            'nilai.*.skor' =>'nullable|numeric|min:0|max:100',
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