@extends('layouts.layout')

@section('title', 'Tambah Laporan Nilai')

@section('content')

<div class="container mt-4 mb-5">
    <div class="card p-4 shadow-sm">
        @if(Auth::guard('guru')->check())
        <h3 class="fw-bold border-bottom mb-4">Tambah Laporan Nilai Siswa</h3>
        <form action="{{ route('guru.nilai.store') }}" method="POST">
            @csrf

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
                    <label for="" class="form-label fw-bold">Nama Murid</label>
                    <select name="murid_id" id="murid_id" class="form-select" required>
                        <option value="">-- Pilih Murid yang Terdaftar --</option>
                        @foreach($murid as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_murid }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">NISN</label>
                    <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN Siswa" required>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Program Keahlian</label>
                    <select name="program_keahlian" id="" class="form-select">
                        <option value="">-- Program Keahlian --</option>
                        @foreach($program as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Konsentrasi Keahlian</label>
                    <select name="konsentrasi_keahlian" id="" class="form-select">
                        <option value="">-- Konsentrasi Keahlian --</option>
                        @foreach($konsentrasi as $items)
                            <option value="{{ $items->konsentrasi_keahlian }}">{{ $items->konsentrasi_keahlian }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Tanggal Berakhir</label>
                    <input type="date" name="tanggal_berakhir" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Tempat PKL</label>
                    <input type="text" name="tempat_pkl" class="form-control" required>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="" class="form-label fw-bold">Sakit (Hari)</label>
                    <input type="number" name="kehadiran_sakit" class="form-control" value="0" min="0" required>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label fw-bold">Ijin (Hari)</label>
                    <input type="number" name="kehadiran_ijin" class="form-control" value="0" min="0" required>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label fw-bold">Tanpa Keterangan (Hari)</label>
                    <input type="number" name="kehadiran_tanpa_keterangan" class="form-control" value="0" min="0" required>
                </div>
                <div class="col-12">
                    <label for="" class="form-label fw-bold">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Tambahkan Catatan Siswa.."></textarea>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Tujuan Pembelajaran</th>
                            <th>Skor</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp

                        @foreach($tujuan_pembelajaran as $items)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                {{ $items->point_utama ?? 'Tujuan Pembelajaran tidak diketahui' }}

                                <input type="hidden" name="nilai[{{ $items->id }}][indikator_id]" value="{{ $items->id }}">
                            </td>
                            <td>
                                <input type="number" name="nilai[{{ $items->id }}][skor]" class="form-control text-center fw-bold" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" name="nilai[{{ $items->id }}][deskripsi]" class="form-control" placeholder="Deskripsi Kemajuan Kompetensi Siswa">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('guru.nilai.index') }}" class="btn btn-secondary">Batal</a>
                <button class="btn btn-success">Simpan Nilai Siswa</button>
            </div>
        </form>
        @endif



        @if(Auth::guard('dudi')->check())
        <form action="{{ route('dudi.nilai.store') }}" method="POST">
            @csrf

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
                    <label for="" class="form-label fw-bold">Nama Murid</label>
                    <select name="murid_id" id="murid_id" class="form-select" required>
                        <option value="">-- Pilih Murid yang Terdaftar --</option>
                        @foreach($murid as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_murid }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">NISN</label>
                    <input type="text" name="nisn" class="form-control" placeholder="Masukkan NISN Siswa" required>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Program Keahlian</label>
                    <select name="program_keahlian" id="" class="form-select">
                        <option value="">-- Program Keahlian --</option>
                        @foreach($program as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Konsentrasi Keahlian</label>
                    <select name="konsentrasi_keahlian" id="" class="form-select">
                        <option value="">-- Konsentrasi Keahlian --</option>
                        @foreach($konsentrasi as $items)
                            <option value="{{ $items->konsentrasi_keahlian }}">{{ $items->konsentrasi_keahlian }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Tanggal Berakhir</label>
                    <input type="date" name="tanggal_berakhir" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label fw-bold">Tempat PKL</label>
                    <input type="text" name="tempat_pkl" class="form-control" required>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="" class="form-label fw-bold">Sakit (Hari)</label>
                    <input type="number" name="kehadiran_sakit" class="form-control" value="0" min="0" required>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label fw-bold">Ijin (Hari)</label>
                    <input type="number" name="kehadiran_ijin" class="form-control" value="0" min="0" required>
                </div>
                <div class="col-md-4">
                    <label for="" class="form-label fw-bold">Tanpa Keterangan (Hari)</label>
                    <input type="number" name="kehadiran_tanpa_keterangan" class="form-control" value="0" min="0" required>
                </div>
                <div class="col-12">
                    <label for="" class="form-label fw-bold">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Tambahkan Catatan Siswa.."></textarea>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Tujuan Pembelajaran</th>
                            <th>Skor</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp

                        @foreach($tujuan_pembelajaran as $items)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                {{ $items->point_utama ?? 'Tujuan Pembelajaran tidak diketahui' }}

                                <input type="hidden" name="nilai[{{ $items->id }}][indikator_id]" value="{{ $items->id }}">
                            </td>
                            <td>
                                <input type="number" name="nilai[{{ $items->id }}][skor]" class="form-control text-center fw-bold" min="0" max="100">
                            </td>
                            <td>
                                <input type="text" name="nilai[{{ $items->id }}][deskripsi]" class="form-control" placeholder="Deskripsi Kemajuan Kompetensi Siswa">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('dudi.nilai.index') }}" class="btn btn-secondary">Batal</a>
                <button class="btn btn-success">Simpan Nilai Siswa</button>
            </div>
        </form>
        @endif

        @if(Auth::guard('web')->check())
            <h3 class="fw-bold">Tambah Tujuan Pembelajaran</h3>
            <form action="{{ route('web.pembelajaran.indikator') }}" method="post">
                @csrf
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="" class="form-label">Point Utama</label>
                        <input type="text" class="form-control" name="point_utama">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Point Detail</label>
                        <input type="text" class="form-control" name="point_details">
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

@endsection