@extends('layouts.layout')

@section('title', 'Edit Laporan Bulanan')

@section('content')

    <div class="container mt-4 mb-4">
        <div class="card p-4 shadow-sm">
            @if(Auth::guard('murid')->check())
            <h3 class="fw-bold">Edit Laporan Bulanan</h3>
            <form action="{{ route('murid.bulanan.update', $laporan->id) }}" method="post">
                @csrf
                @method('PUT')
                
                <div class="row g-3 mb-4">
                    <label for="" class="form-label">Nama Siswa</label>
                    <select name="murid_id" id="" class="form-select">
                        <option value="">-- Pilih Murid --</option>
                        @foreach(\App\Models\Murid::all() as $murid)
                            <option value="{{ $murid->id }}"  {{ $laporan->murid_id == $murid->id ? 'selected' : '' }}>{{ $murid->nama_murid }}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="" class="form-label">Nama Pembimbing</label>
                    <select name="dudi_id" id="" class="form-select">
                        <option value="">-- Pilih Pembimbing Dudi --</option>
                        @foreach(\App\Models\Identitas_Dudi::all() as $dudi)
                            <option value="{{ $dudi->id }}" {{ $laporan->dudi_id == $dudi->id ? 'selected' : '' }}>{{ $dudi->nama_pembimbing }}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="" class="form-label">Nama Guru Pembimbing</label>
                    <select name="guru_pembimbing_id" id="" class="form-select">
                        <option value="">-- Pilih Guru Pembimbing --</option>
                        @foreach(\App\Models\Guru_Pembimbing::all() as $guru)
                            <option value="{{ $guru->id }}" {{ $laporan->guru_pembimbing_id == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                        @endforeach
                    </select>
                    <br>
                    <div class="col-md-6">
                        <label for="" class="form-label">Nama Pekerjaan</label>
                        <input type="text" name="nama_pekerjaan" value="{{ $laporan->nama_pekerjaan }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Perencanaan Kegiatan</label>
                        <input type="text" name="perencanaan_kegiatan" value="{{ $laporan->perencanaan_kegiatan }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Pelaksanaan Kegiatan</label>
                        <input type="text" name="pelaksanaan_kegiatan" value="{{ $laporan->pelaksanaan_kegiatan }}" class="form-control">
                    </div>
                </div>

                <a href="{{ route('murid.bulanan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success">Edit Laporan</button>
            </form>
            @endif

            @if(Auth::guard('dudi')->check())
            <h3 class="fw-bold">Edit Catatan Laporan</h3>
            <form action="{{ route('dudi.bulanan.update', $laporan->id) }}" method="post">
                @csrf
                @method('PUT')

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="" class="form-label">Catatan Pembimbing</label>
                        <textarea name="catatan_instruktur" class="form-control" id="">{{ old('catatan_instruktur', $laporan->catatan_instruktur) }}</textarea>
                    </div>
                </div>

                <a href="{{ route('dudi.bulanan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success">Edit catatan Laporan</button>
            </form>
            @endif
        </div>
    </div>

@endsection