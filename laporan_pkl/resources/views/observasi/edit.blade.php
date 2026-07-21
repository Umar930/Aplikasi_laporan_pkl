@extends('layouts.layout')

@section('title', 'Edit Data Observasi')

@section('content')

<div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <h3 class="fw-bold mb-4">Edit Observasi Siswa</h3>

        @if (Auth::guard('guru')->check())
        <form action="{{ route('guru.observasi.update', $observasi->id) }}" method="POST">
            @csrf
            @method('PUT')

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <h6 class="fw-bold">Gagal menyimpan data</h6>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label for="" class="form-label">Nama Murid</label>
            <select name="murid_id" id="" class="form-select">
                <option value="">-- Pilih Murid</option>
                @foreach($daftarMurid as $murid)
                    <option value="{{ $murid->id }}" {{ $observasi->murid_id == $murid->id ? 'selected' : '' }}>{{ $murid->nama_murid }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="">Tempat PKL</label>
            <input type="text" name="tempat_pkl" class="form-control" value="{{ $observasi->tempat_pkl }}">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="">Nama Pembimbing</label>
            <select name="dudi_id" id="" class="form-select">
                <option value="">-- Nama Pembimbing --</option>
                @foreach (\App\Models\Identitas_Dudi::all() as $dudi)
                    <option value="{{ $dudi->id }}" {{ $observasi->dudi_id == $dudi->id ? 'selected' : '' }}>{{ $dudi->nama_pembimbing }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="">Guru Pembimbing</label>
            <select name="guru_pembimbing_id" id="" class="form-select">
                <option value="">-- Guru Pembimbing --</option>
                @foreach (\App\Models\Guru_Pembimbing::all() as $guru)
                    <option value="{{ $guru->id }}" {{ $observasi->guru_pembimbing_id == $guru->id ? 'selected' : '' }} >{{ $guru->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="" class="form-label">Pekerjaan / Projek</label>
            <input type="text" name="pekerjaan_proyek" value="{{ $observasi->pekerjaan_proyek }}" class="form-control">
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered align-middle">
            <thead class="table-secondary text-center">
                <tr>
                    <td>Tujuan Pembelajaran / Indikator</td>
                    <td>Ketercapaian</td>
                    <td>Deskripsi</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $detailGroup = $tujuan_pembelajaran->groupBy('point_utama');
                    $no = 1;
                @endphp

                @foreach($detailGroup as $point_utama => $items)
                    <tr>
                        <td class="fw-bold">
                            {{ $no++ }}. {{ $point_utama }}
                        </td>
                    </tr>
                    @foreach($items as $item)

                    @php $detailLama = $observasi->details->where('indikator_id', $item->id)->first(); @endphp
                        <tr>
                            <td>{{ $item->point_details }}</td>
                            <td>
                                <select class="form-select fw-bold text-center" name="observasi[{{ $item->id }}][ketercapaian]" id="" required>
                                    <option value="iya" {{ old("observasi.{$item->id}.ketercapaian", $detailLama->ketercapaian) == 'iya' ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ old("observasi.{$item->id}.ketercapaian", $detailLama->ketercapaian) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </td>
                            @if ($loop->first)
                            <td rowspan="{{ $item->count() }}">
                                <textarea name="observasi[{{ $item->id }}][deskripsi]" value="{{ old('observasi.{ $item->id }.deskripsi', $detailLama->deskripsi) }}" class="form-control" id=""></textarea>
                            </td>
                            @endif
                        </tr>
                        @if($loop->last)
                        <tr>
                            <td class="fw-bold pe-4">Skor</td>
                            <td class="text-center">
                                <input type="number" step="0.01" name="observasi[{{ $item->id }}][skor]" value="{{ old('observasi.{ $item->id }.skor', $detailLama->skor) }}" class="form-control fw-bold">
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-start gap-2 mt-4">
        <a href="{{ route('guru.observasi.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Edit Observasi Siswa</button>
    </div>
</form>
@endif




        @if (Auth::guard('dudi')->check())
        <form action="{{ route('dudi.observasi.update', $observasi->id) }}" method="POST">
            @csrf
            @method('PUT')

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <h6 class="fw-bold">Gagal menyimpan data</h6>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label for="" class="form-label">Nama Murid</label>
            <select name="murid_id" id="" class="form-select">
                <option value="">-- Pilih Murid</option>
                @foreach($daftarMurid as $murid)
                    <option value="{{ $murid->id }}" {{ $observasi->murid_id == $murid->id ? 'selected' : '' }}>{{ $murid->nama_murid }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="">Tempat PKL</label>
            <input type="text" name="tempat_pkl" class="form-control" value="{{ $observasi->tempat_pkl }}">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="">Nama Pembimbing</label>
            <select name="dudi_id" id="" class="form-select">
                <option value="">-- Nama Pembimbing --</option>
                @foreach (\App\Models\Identitas_Dudi::all() as $dudi)
                    <option value="{{ $dudi->id }}" {{ $observasi->dudi_id == $dudi->id ? 'selected' : '' }}>{{ $dudi->nama_pembimbing }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="">Guru Pembimbing</label>
            <select name="guru_pembimbing_id" id="" class="form-select">
                <option value="">-- Guru Pembimbing --</option>
                @foreach (\App\Models\Guru_Pembimbing::all() as $guru)
                    <option value="{{ $guru->id }}" {{ $observasi->guru_pembimbing_id == $guru->id ? 'selected' : '' }} >{{ $guru->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="" class="form-label">Pekerjaan / Projek</label>
            <input type="text" name="pekerjaan_proyek" value="{{ $observasi->pekerjaan_proyek }}" class="form-control">
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered align-middle">
            <thead class="table-secondary text-center">
                <tr>
                    <td>Tujuan Pembelajaran / Indikator</td>
                    <td>Ketercapaian</td>
                    <td>Deskripsi</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $detailGroup = $tujuan_pembelajaran->groupBy('point_utama');
                    $no = 1;
                @endphp

                @foreach($detailGroup as $point_utama => $items)
                    <tr>
                        <td class="fw-bold">
                            {{ $no++ }}. {{ $point_utama }}
                        </td>
                    </tr>
                    @foreach($items as $item)

                    @php $detailLama = $observasi->details->where('indikator_id', $item->id)->first(); @endphp
                        <tr>
                            <td>{{ $item->point_details }}</td>
                            <td>
                                <select class="form-select fw-bold text-center" name="observasi[{{ $item->id }}][ketercapaian]" id="" required>
                                    <option value="iya" {{ old("observasi.{$item->id}.ketercapaian", $detailLama->ketercapaian) == 'iya' ? 'selected' : '' }}>Ya</option>
                                    <option value="tidak" {{ old("observasi.{$item->id}.ketercapaian", $detailLama->ketercapaian) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </td>
                            @if ($loop->first)
                            <td rowspan="{{ $item->count() }}">
                                <textarea name="observasi[{{ $item->id }}][deskripsi]" value="{{ old('observasi.{ $item->id }.deskripsi', $detailLama->deskripsi) }}" class="form-control" id=""></textarea>
                            </td>
                            @endif
                        </tr>
                        @if($loop->last)
                        <tr>
                            <td class="fw-bold pe-4">Skor</td>
                            <td class="text-center">
                                <input type="number" step="0.01" name="observasi[{{ $item->id }}][skor]" value="{{ old('observasi.{ $item->id }.skor', $detailLama->skor) }}" class="form-control fw-bold">
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-start gap-2 mt-4">
        <a href="{{ route('dudi.observasi.index') }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Edit Observasi Siswa</button>
    </div>
</form>
@endif
    </div>
</div>

@endsection