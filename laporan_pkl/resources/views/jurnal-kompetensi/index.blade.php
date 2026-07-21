@extends('layouts.layout')

@section('title', 'Jurnal Kompetensi')

@section('content')
    <div style="display:flex; flex-direction:column;">


        @if(session('sukses'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('sukses') }}
            </div>
        @endif

        @unless(Auth::guard('murid')->check())
        <a class="ms-auto me-2" href="{{ route('guru.jurnal.tambah') }}"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        @endunless
        <br>

        @if($jurnalAktif)
        <div class="card shadow-sm p-2 mb-2 mt-2">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <table class="table table-borderless text-start">
                        <tr><td>Nama Murid</td><td>: {{ $jurnalAktif->murid->nama_murid }}</td></tr>
                        <tr><td>Kelas</td><td>: {{ $jurnalAktif->murid->kelas }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        @unless(Auth::guard('murid')->check())
        <div class="d-flex mb-4 mt-4 gap-2">
            <a href="{{ route('guru.jurnal.edit', $jurnalAktif->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
            <form action="{{ route('guru.jurnal.hapus', $jurnalAktif->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill me-2"></i>Hapus</button>
            </form>
        </div>
        @endunless

        <table class="table">
            <thead>
                <tr class="table-success align-middle text-center">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Kompetensi</th>
                    <th rowspan="2">Pelaksanaan Pembelajaran</th>
                    <th rowspan="2">Nilai Minimal Kompetensi</th>
                    <th rowspan="2">Nilai Kompetensi</th>
                    <th width="15%" rowspan="2">Tanggal</th>
                    <th rowspan="2">Keterangan</th>
                    <th rowspan="2">Status Diverifikasi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp

                @forelse($detailGroup as $kategori => $details)
                <tr class="text-center">
                    <td rowspan="{{ $details->count() + 1 }}" class="text-center fw-bold bg-light">{{ $no++ }}</td>
                    <td class="fw-bold bg-light">{{ $kategori }}</td>
                </tr>
                @foreach($details as $index => $detail)
                <tr class="align-middle">
                    <td>{{ $index + 1 }}. {{ $detail->kompetensi->nama_kompetensi ?? '-' }}</td>
                    <td>
                        {{ $detail->pelaksanaan_pembelajaran }}
                    </td>
                    <td class="text-center fw-bold">{{ $detail->nilai_minimal_kompetensi }}</td>
                    <td class="text-center fw-bold {{ $detail->nilai_kompetensi >= $detail->nilai_minimal_kompetensi ? 'text-success' : 'text-danger' }}">{{ $detail->nilai_kompetensi }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($detail->tanggal)->format('Y-m-d') }}</td>
                    <td class="text-center fw-bold">{{ $detail->keterangan ?? '-' }}</td>
                    <td></td>
                </tr>
                @endforeach
                @empty
                <tr>
                    <td colspan="9" class="text-center align-middle py-5">
                        Belum ada data Jurnal.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @else
            <div class="alert alert-danger fw-bold text-center mt-4">
                Belum ada data Jurnal Kompetensi Siswa
            </div>
        @endif
    </div>
@endsection