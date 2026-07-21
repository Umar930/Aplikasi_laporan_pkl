@extends('layouts.layout')

@section('title', 'Tambah Laporan Bulanan')

@section('content')

    <div class="container mt-4 mb-4">
        <div class="card p-4 shadow-sm">
            @if(Auth::guard('murid')->check())
            <h3 class="fw-bold">Tambah Laporan Bulanan</h3>

            <form action="{{ route('murid.bulanan.store') }}" method="post">
                @csrf
                
                <div class="row g-3 mb-4">
                    <label for="" class="form-label">Nama Siswa</label>
                    <select name="murid_id" id="" class="form-select">
                        <option value="">-- Pilih Murid --</option>
                        @foreach(\App\Models\Murid::all() as $murid)
                            <option value="{{ $murid->id }}">{{ $murid->nama_murid }}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="" class="form-label">Nama Pembimbing</label>
                    <select name="dudi_id" id="" class="form-select">
                        <option value="">-- Pilih Pembimbing Dudi --</option>
                        @foreach(\App\Models\Identitas_Dudi::all() as $dudi)
                            <option value="{{ $dudi->id }}">{{ $dudi->nama_pembimbing }}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="" class="form-label">Nama Guru Pembimbing</label>
                    <select name="guru_pembimbing_id" id="" class="form-select">
                        <option value="">-- Pilih Guru Pembimbing --</option>
                        @foreach(\App\Models\Guru_Pembimbing::all() as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                        @endforeach
                    </select>
                    <br>
                    <div class="col-md-6">
                        <label for="" class="form-label">Nama Pekerjaan</label>
                        <input type="text" name="nama_pekerjaan" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Perencanaan Kegiatan</label>
                        <input type="text" name="perencanaan_kegiatan" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Pelaksanaan Kegiatan</label>
                        <input type="text" name="pelaksanaan_kegiatan" class="form-control">
                    </div>
                </div>

                <a href="{{ route('murid.bulanan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success">Tambah Laporan</button>
            </form>
            @endif
        </div>
    </div>

@endsection