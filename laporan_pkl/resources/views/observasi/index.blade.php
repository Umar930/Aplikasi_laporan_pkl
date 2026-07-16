@extends('layouts.layout')

@section('title', 'Observasi')

@section('content')
    <div style="display:flex; flex-direction:column;">

        @if (session('sukses'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('sukses') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
        @endif

        @if(Auth::guard('guru')->check())
        <a href="{{ route('guru.observasi.tambah') }}" class="ms-auto me-2"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        @endif

        @if(Auth::guard('dudi')->check())
        <a href="{{ route('dudi.observasi.tambah') }}" class="ms-auto me-2"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        @endif

        @if ($observasiAktif)
        <div class="card bg-light border-0 shadow-sm p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <table class="table table-borderless m-0 text-start">
                        <tr><td class="fw-bold">Nama Murid </td><td>: {{$observasiAktif->murid->nama_murid }}</td></tr>
                        <tr><td class="fw-bold">Tempat_PKL </td><td>: {{ $observasiAktif->tempat_pkl }}</td></tr>
                        <tr><td class="fw-bold">Nama Pembimbing </td><td>: {{ $observasiAktif->dudi->nama_pembimbing ?? '-' }}</td></tr>
                        <tr><td class="fw-bold">Nama Guru Pembimbing </td><td>: {{ $observasiAktif->guru->nama ?? '-' }}</td></tr>
                        <tr><td class="fw-bold">Pekerjaan / Proyek </td><td>: {{ $observasiAktif->pekerjaan_proyek }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4 gap-2">
            @if(Auth::guard('guru')->check())
            <a href="{{ route('guru.observasi.edit', $observasiAktif->id) }}"><button class="btn btn-warning"><i class="bi bi-pencil-fill me-2"></i>Edit</button></a>
            <form action="{{ route('guru.observasi.destroy', $observasiAktif->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit"><i class="bi bi-trash-fill me-2"></i>Hapus</button>
            </form>
            @endif


            @if(Auth::guard('dudi')->check())
            <a href="{{ route('dudi.observasi.edit', $observasiAktif->id) }}"><button class="btn btn-warning"><i class="bi bi-pencil-fill me-2"></i>Edit</button></a>
            <form action="{{ route('dudi.observasi.destroy', $observasiAktif->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit"><i class="bi bi-trash-fill me-2"></i>Hapus</button>
            </form>
            @endif
        </div>
    
        <br>
        <table class="table">
            <thead>
                <tr style="text-align:center;" class="table-danger">
                    <th>No</th>
                    <th>Tujuan Pembelajaran</th>
                    <th>Ketercapaian</th>
                    <th>Deskripsi</th>
                    <th>Status Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp

                @forelse($detailGroup as $point_utama => $details)

                <tr class="text-center">
                    <td rowspan="{{ $details->count() + 1 }}" class="fw-bold text-center">{{ $no++ }}</td>
                    <td class="fw-bold">{{ $point_utama }}</td>
                </tr>

                @foreach ($details as $detail)

                <tr>
                    <td>{{ $detail->indikator->point_details }}</td>
                    <td class="text-center">
                        <span class="badge {{ $detail->ketercapaian == 'iya' ? 'bg-success' : 'bg-danger'}} px-3 py-2">
                            {{ strtoupper ($detail->ketercapaian) }}
                        </span>
                    </td>
                    @if($loop->first)
                    <td class="align-middle" rowspan="{{ $detail->count() }}">{{ $detail->deskripsi }}</td>
                    @endif
                    <td></td>
                </tr>
                @if($loop->last)
                <tr class="table-secondary">
                    <td></td>
                    <td class="fw-bold">Skor</td>
                    <td class="text-center">{{ $detail->skor }}</td>
                    <td></td>
                </tr>
                @endif
                @endforeach

                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Belum ada data</td>
                </tr>

                @endforelse
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4 gap-2">
        {{ $observasiPaginate->links('pagination::bootstrap-5') }}
    </div>

    @else
        <div class="text-center align-middle alert alert-warning my-5 py-4 fw-bold shadow-sm col-md-12">
            Belum ada data Observasi Siswa
        </div>
    @endif
@endsection