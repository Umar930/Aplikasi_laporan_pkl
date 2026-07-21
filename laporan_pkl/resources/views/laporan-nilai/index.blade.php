@extends('layouts.layout')

@section('title', 'Laporan Nilai')

@section('content')
    <div style="display:flex; flex-direction:column;">

        @if(session('sukses')) <div class="alert alert-success">{{ session('sukses') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

         @if (Auth::guard('dudi')->check())
            <a class="ms-auto me-2" href="{{ route('dudi.nilai.tambah') }}"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        @endif
        <br>

        @if (Auth::guard('guru')->check())
            <a class="ms-auto me-2" href="{{ route('guru.nilai.tambah') }}"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        @endif
        <br>


        @if ($laporanAktif)
        <div class="card bg-light border-0 shadow-sm p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <table class="table table-borderless m-0 text-start">
                        <tr><td class="fw-bold">Nama Murid </td><td>: {{$laporanAktif->murid->nama_murid ?? '-' }}</td></tr>
                        <tr><td class="fw-bold">NISN </td><td>: {{ $laporanAktif->nisn }}</td></tr>
                        <tr><td class="fw-bold">Program Keahlian </td><td>: {{ $laporanAktif->program_keahlian }}</td></tr>
                        <tr><td class="fw-bold">Konsentrasi Keahlian </td><td>: {{ $laporanAktif->konsentrasi_keahlian }}</td></tr>
                        <tr><td class="fw-bold">Tempat PKL </td><td>: {{ $laporanAktif->tempat_pkl }}</td></tr>
                        <tr><td class="fw-bold">Tanggal Mulai & Berakhir </td><td>: {{ $laporanAktif->tanggal_mulai }} <strong>s/d</strong> {{ $laporanAktif->tanggal_berakhir }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mb-4 mt-4 gap-2">
            @if (Auth::guard('guru')->check())
            <a href="{{ route('guru.nilai.edit', $laporanAktif->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
            <form action="{{ route('guru.nilai.destroy', $laporanAktif->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger"><i class="bi bi-trash-fill me-2"></i>Hapus</button>
            </form>
            @endif

            @if (Auth::guard('dudi')->check())
            <a href="{{ route('dudi.nilai.edit', $laporanAktif->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
            <form action="{{ route('dudi.nilai.destroy', $laporanAktif->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger"><i class="bi bi-trash-fill me-2"></i>Hapus</button>
            </form>
            @endif
        </div>
        <table border="1" class="table mb-5">
            <thead>
                <tr class="table-danger align-middle text-center">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tujuan Pembelajaran</th>
                    <th rowspan="2">Skor</th>
                    <th rowspan="2">Deskripsi</th>
                    <th class="table-secondary" colspan="3">Kehadiran</th>
                </tr>
                <tr class="table-secondary align-middle text-center">
                    <th>Sakit</th>
                    <th>Ijin</th>
                    <th>Tanpa Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp

                @forelse($laporanAktif->nilai_details as $detail)

                <tr class="text-center">
                    <td>{{ $no++ }}</td>
                    <td class="fw-bold">{{ $detail->indikator->point_utama ?? 'Tujuan Pembelajaran Tidak Diketahui' }}</td>
                    <td>{{ $detail->skor }}</td>
                    <td>{{ $detail->deskripsi ?? '-' }}</td>
                    @if ($loop->first)
                    <td rowspan="{{$laporanAktif->nilai_details->count()}}" class="align-middle">{{ $laporanAktif->kehadiran_sakit }} Hari</td>
                    <td rowspan="{{$laporanAktif->nilai_details->count()}}" class="align-middle">{{ $laporanAktif->kehadiran_ijin }} Hari</td>
                    <td rowspan="{{$laporanAktif->nilai_details->count()}}" class="align-middle">{{ $laporanAktif->kehadiran_tanpa_keterangan }} Hari</td>
                    @endif
                </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-warning text-center my-5 py-4 fw-bold">Belum ada data nilai siswa</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @endif

        <div class="d-flex justify-content-center mt-2 mb-4">
            {{ $nilaiPaginate->links('pagination::bootstrap-5') }}
        </div>

        <h4 class="fw-bold me-auto ms-3">Kriteria Penilaian:</h4>
        <table class="table w-25 me-auto ms-3">
            <thead>
                <tr class="table-info" style="text-align:center;">
                    <th>No</th>
                    <th>Nilai Angka</th>
                    <th>Kriteria</th>
                    <th>Huruf</th>
                </tr>
            </thead>
            <tbody style="text-align:center;" class="table-secondary">
                <tr>
                    <td>1</td>
                    <td>Nilai 90 - 100</td>
                    <td>Sangat Baik</td>
                    <td>A</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Nilai 80 - 89</td>
                    <td>Baik</td>
                    <td>B</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Nilai 65 - 79</td>
                    <td>Cukup</td>
                    <td>C</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Nilai 65 kebawah</td>
                    <td>Kurang</td>
                    <td>D</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card bg-light border-0 shadow-sm p-2 mb-4">
            <div class="row">
                <div class="col-md-4">
                    <table class="table table-borderless text-start">
                        <tr><td class="fw-bold">Catatan: {{$laporanAktif->catatan ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
@endsection