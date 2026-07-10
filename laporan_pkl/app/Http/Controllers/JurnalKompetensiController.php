<?php

namespace App\Http\Controllers;

use App\Models\Jurnal_Kompetensi;
use App\Models\JurnalDetail;
use App\Models\Kompetensi_Dasar;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class JurnalKompetensiController extends Controller
{
    
    public function index()
    {
        if(Auth::guard('web')->check()){
            $jurnal=Jurnal_Kompetensi::with('murid')->latest()->get();
        }elseif(Auth::guard('guru')->check()){
            $guruId=Auth::guard('guru')->id();
            $jurnal=Jurnal_Kompetensi::whereHas('murid',function($query) use ($guruId){
                $query->where('guru_pembimbing_id',$guruId);
            })->with('murid')->latest()->get();
        }elseif(Auth::guard('dudi')->check()){
            $dudiId=Auth::guard('dudi')->id();
            $jurnal=Jurnal_Kompetensi::whereHas('murid',function($query) use ($dudiId){
               $query->where('dudi_id',$dudiId);
            })->with('murid')->latest()->get();
         }else{
            abort(403,'akses ditolak');
         }   
        
        
        return view('jurnal-kompetensi.index',compact('jurnal'));
    }

    public function create()
    {
        $this->authCrud();

        $murid=Murid::all();
        $kompetensi=Kompetensi_Dasar::all();
        return view('jurnal-kompetensi.tambah',compact('kompetensi','murid'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authCrud();

        $cek = Jurnal_Kompetensi::where(
            'murid_id',
            $request->murid_id
        )->exists();
        
        if($cek){
            return back()->with(
                'error',
                'Jurnal murid sudah ada.'
            );
        }


        DB::beginTransaction();
        try{
        $jurnal=Jurnal_Kompetensi::create([
            'murid_id'=>$request->murid_id
        ]);


        foreach($request->kompetensi as $kompetensi_id=>$data){
            $request->validate([
                'murid_id'=>'required|exists:murid,id',
                'kompetensi'=>'required|array',
                'kompetensi.*.pelaksanaan'=>'required',
                'kompetensi.*.nilai_minimal'=>'required|integer',
                'kompetensi.*.nilai'=>'required|integer',
                'kompetensi.*.tanggal'=>'required|date',
            ]);
            JurnalDetail::create([
                'jurnal_kompetensi_id'=>$jurnal->id,
                'kompetensi_dasar_id'=>$kompetensi_id,
                'pelaksanaan_pembelajaran'=>$data['pelaksanaan'],
                'nilai_minimal_kompetensi'=>$data['nilai_minimal'],
                'nilai_kompetensi'=>$data['nilai'],
                'tanggal'=>$data['tanggal'],
                'keterangan'=>$data['keterangan'],
            ]);
        }
        DB::commit();
        return redirect()->route('jurnal-kompetensi.index')->with('sukses','data berhasil ditambahkan');
    }catch(\Exception $e){
        DB::rollBack();
        return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();
    }
}

    public function show($id)
    {
        $jurnal=Jurnal_Kompetensi::with(['murid','details.kompetensiDasar'])->findOrFail($id);
        if(!$this->cekAksesData($jurnal)){
            abort(403,'akses ditolak');
        }

        return view('jurnal-kompetensi.index',compact('jurnal'));
    }

    public function edit($id)
    {
        $this->authCrud();

        $jurnal=Jurnal_Kompetensi::with('details.kompetensiDasar')->findOrFail($id);
        if(!$this->cekAksesData($jurnal)){
            abort(403,'akses ditolak');
        }
        $kompetensi=Kompetensi_Dasar::all();
        return view('jurnal-kompetensi.edit',compact('jurnal','kompetensi'));
    }

    public function update(Request $request,$id)
    {
        $this->authCrud();

        DB::beginTransaction();
        try{
        $jurnal=Jurnal_Kompetensi::findOrFail($id);
        if(!$this->cekAksesData($jurnal)){
            abort(403,'akses ditolak');
        }
        $request->validate([
            'kompetensi'=>'required|array',
            'kompetensi.*.pelaksanaan'=>'required',
            'kompetensi.*.nilai_minimal'=>'required|integer',
            'kompetensi.*.nilai'=>'required|integer',
            'kompetensi.*.tanggal'=>'required|date',
        ]);

        // $jurnal->details()->delete();

        foreach($request->kompetensi as $kompetensi_id=>$data){

            JurnalDetail::updateOrCreate([
                'jurnal_kompetensi_id'=>$jurnal->id,
                'kompetensi_dasar_id'=>$kompetensi_id,
                ],[
                    'pelaksanaan_pembelajaran'=>$data['pelaksanaan'],
                'nilai_minimal_kompetensi'=>$data['nilai_minimal'],
                'nilai_kompetensi'=>$data['nilai'],
                'tanggal'=>$data['tanggal'],
                'keterangan'=>$data['keterangan'] ?? null,
                ]);
        }
        DB::commit();
        return redirect()->route('jurnal-kompetensi.index')->with('sukses','data berhasil diperbarui');
    }catch(\Exception $e){
        DB::rollBack();
        return redirect()->back()->with('error','gagal menyimpan: '.$e->getMessage())->withInput();    
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authCrud();
      
        $jurnal = Jurnal_Kompetensi::findOrFail($id);
        if(!$this->cekAksesData($jurnal)){
            abort(403,'akses ditolak');
        }

        $jurnal->delete();   
        
        return redirect()->route('jurnal-kompetensi.index')->with('sukses','data telah dihapus');
    }

    public function verifikasiguru($detailId){
        if(!Auth::guard('guru')->check() &&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
      
        $detail=JurnalDetail::findOrFail($detailId);
        if(!$this->cekAksesData($detail->jurnal)){
            abort(403,'akses ditolak');
        }

        $detail->diverifikasi_oleh_guru = Auth::guard('guru')->id();

        if(
    $detail->diverifikasi_oleh_guru &&
    $detail->diverifikasi_oleh_dudi
        ){
    $detail->status_verifikasi='diverifikasi';
        }

        $detail->save();
    }

    public function verifikasidudi($detailId){
        if(!Auth::guard('guru')->check() &&!Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
      
        $detail=JurnalDetail::findOrFail($detailId);
        if(!$this->cekAksesData($detail->jurnal)){
            abort(403,'akses ditolak');
        }

        if(
            $detail->diverifikasi_oleh_guru &&
            $detail->diverifikasi_oleh_dudi
                ){
            $detail->status_verifikasi='diverifikasi';
                }
        
                $detail->save();
    }

    private function authCrud(){
        if(!Auth::guard('web')->check() && !Auth::guard('guru')->check() && !Auth::guard('dudi')->check()){
            abort(403,'akses ditolak');
        }
    }

    private function cekAksesData($jurnal){
        if(Auth::guard('web')->check()){
            return true;
        }
    
        if(Auth::guard('guru')->check()){
            return $jurnal->murid->guru_pembimbing_id == Auth::guard('guru')->id();
        }
    
        if(Auth::guard('dudi')->check()){
            return $jurnal->murid->dudi_id == Auth::guard('dudi')->id();
        }
    
       
        
    return false;
    }
}