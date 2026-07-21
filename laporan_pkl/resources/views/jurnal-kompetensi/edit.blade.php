@extends('layouts.layout')

@section('title', 'Edit Jurnal Kompetensi')

@section('content')

<div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <h3 class="fw-bold mb-4">Edit Jurnal Siswa</h3>
        <form action="{{ route('guru.jurnal.update', $jurnal->id) }}" method="POST">
            @csrf
            @method('PUT')

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
                            <option value="{{ $m->id }}" {{ $jurnal->murid_id == $m->id ? 'selected' : '' }}>{{ $m->nama_murid }}</option>
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

                        @php $dataLama = $jurnal->jurnaldetail->where('kompetensi_dasar_id', $item->id)->first(); @endphp
                        <tr class="align-middle">
                            <td>{{ $index + 1 }}. {{ $item->nama_kompetensi }}</td>
                            <td class="align-middle">
                                <select class="form-select" name="kompetensi[{{ $item->id }}][pelaksanaan_pembelajaran]" required id="">
                                    <option value="Sekolah Dan Dunia Kerja" {{ $dataLama->pelaksanaan_pembelajaran == 'Sekolah Dan Dunia Kerja' ? 'selected' : '' }}>Sekolah Dan Dunia Kerja</option>
                                    <option value="Sekolah" {{ $dataLama->pelaksanaan_pembelajaran == 'Sekolah' ? 'selected' : '' }}> Sekolah </option>
                                    <option value="Dunia Kerja" {{ $dataLama->pelaksanaan_pembelajaran == 'Dunia Kerja' ? 'selected' : '' }}>Dunia Kerja</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="kompetensi[{{ $item->id }}][nilai_minimal_kompetensi]" value="{{ $dataLama->nilai_minimal_kompetensi }}" required class="form-control text-center">
                            </td>
                            <td>
                                <input type="number" class="form-control text-center" required value="{{ $dataLama->nilai_kompetensi }}" name="kompetensi[{{ $item->id }}][nilai_kompetensi]">
                            </td>
                            <td>
                                <input type="date" class="form-control text-center" value="{{ $dataLama->tanggal ? \Carbon\Carbon::parse($dataLama->tanggal)->format('Y-m-d') : date('Y-m-d') }}" required name="kompetensi[{{ $item->id }}][tanggal]">
                            </td>
                            <td>
                                <input type="text" class="form-control text-center" value="{{ $dataLama->keterangan }}" name="kompetensi[{{ $item->id }}][keterangan]">
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-start gap-2">
                <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-warning">Update Data</button>
            </div>
        </form>
    </div>
</div>

@endsection