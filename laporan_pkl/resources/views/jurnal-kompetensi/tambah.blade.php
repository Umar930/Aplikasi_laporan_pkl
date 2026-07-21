@extends('layouts.layout')

@section('title', 'Tambah Jurnal Kompetensi')

@section('content')

<div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <h3 class="fw-bold mb-4">Tambah Jurnal Siswa</h3>
        <form action="{{ route('guru.jurnal.store') }}" method="POST">
            @csrf

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <h6 class="fw-bold">Gagal Menyimpan Data</h6>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="" class="form-label">Nama Siswa</label>
                    <select name="murid_id" class="form-select" id="">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($murid as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_murid }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-secondary text-center">
                        <tr class="align-middle">
                            <th rowspan="2">No</th>
                            <th rowspan="2">Kompetensi Dasar</th>
                            <th rowspan="2">Pelaksanaan Pembelajran</th>
                            <th rowspan="2">Nilai Minimal Kompetensi</th>
                            <th rowspan="2">Nilai Kompetensi</th>
                            <th rowspan="2">Tanggal</th>
                            <th rowspan="2">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        
                        $detailGroup = $kompetensi->groupBy('kategori_utama');
                        $no = 1;

                        @endphp

                        @foreach($detailGroup as $kompetensi => $items)

                        <tr>
                            <td rowspan="{{ $items->count() + 1 }}">{{ $no++ }}</td>
                            <td class="fw-bold">{{ $kompetensi }}</td>
                        </tr>

                        @foreach($items as $index => $item)
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}. {{ $item->nama_kompetensi }}</td>
                            <td class="align-middle">
                                <select class="form-select" name="kompetensi[{{ $item->id }}][pelaksanaan_pembelajaran]" required id="">
                                    <option value="Sekolah Dan Dunia Kerja">Sekolah Dan Dunia Kerja</option>
                                    <option value="Sekolah"> Sekolah </option>
                                    <option value="Dunia Kerja">Dunia Kerja</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="kompetensi[{{ $item->id }}][nilai_minimal_kompetensi]" required class="form-control text-center">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center" required name="kompetensi[{{ $item->id }}][nilai_kompetensi]">
                            </td>
                            <td>
                                <input type="date" class="form-control text-center" value="{{ date('Y-m-d') }}" required name="kompetensi[{{ $item->id }}][tanggal]">
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" name="kompetensi[{{ $item->id }}][keterangan]">
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-start gap-2">
                <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

@endsection