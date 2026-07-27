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

        <div class="d-flex gap-2 mb-3 mt-3">
            @if(Auth::guard('guru')->check())
                @if($observasiAktif->status_verifikasi !== 'diverifikasi')
                    <a href="{{ route('guru.observasi.edit', $observasiAktif->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                @else
                    <span class="text-muted fs-7"><i>Dikunci</i></span>
                    <form action="{{ route('guru.observasi.hapus', $observasiAktif->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill">Hapus</i></button>
                    </form>
                @endif
            @endif
        
            @if(Auth::guard('dudi')->check())
                @if($observasiAktif->status_verifikasi !== 'diverifikasi')
                    <a href="{{ route('dudi.observasi.edit', $observasiAktif->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                @else
                    <span class="text-muted fs-7"><i>Dikunci</i></span>
                    <form action="{{ route('dudi.observasi.hapus', $observasiAktif->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill">Hapus</i></button>
                    </form>
                @endif
            @endif
        </div>

        @php
            $totalBarisTabel = 0;
            foreach($detailGroup as $details){
                $totalBarisTabel += ( 1 + $details->count() + 1 );
            }
        @endphp
    
        <br>
        <table class="table table-bordered">
            <thead>
                <tr class="table-danger align-middle text-center">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tujuan Pembelajaran</th>
                    <th rowspan="2">Ketercapaian</th>
                    <th rowspan="2">Deskripsi</th>
                    <th colspan="2">Status Verifikasi</th>
                </tr>
                <tr>
                    <th>Diverifikasi Dudi</th>
                    <th>Diverifikasi Guru</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp

                @forelse($detailGroup as $point_utama => $details)

                <tr>
                    <td rowspan="{{ $details->count() + 7 }}" class="fw-bold text-center">{{ $no++ }}</td>
                    <td colspan="2" class="fw-bold">{{ $point_utama }}</td>
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
                    <td class="align-middle text-center" rowspan="{{ $detail->count() + 4 }}">{{ $detail->deskripsi }}</td>
                    <td rowspan="{{ $totalBarisTabel }}" class="text-center align-middle bg-body-tertiary">
                        @if($observasiAktif->diverifikasi_oleh_dudi)
                            <span class="badge bg-success py-2 px-3"><i class="bi bi-check-circle me-1"></i>Terverifikasi</span>
                        @else
                            @if(Auth::guard('dudi')->check())
                                <form action="{{ route('dudi.observasi.verifikasi', $observasiAktif->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-check-circle me-1"></i>Verifikasi
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-warning text-dark py-2 px-3">
                                    <i class="bi bi-hourglass-split me-1"></i>Pending
                                </span>
                            @endif
                        @endif
                    </td>
                    <td rowspan="{{ $totalBarisTabel}}" class="text-center align-middle bg-body-tertiary">
                        @if($observasiAktif->diverifikasi_oleh_guru)
                            <span class="badge bg-success py-2 px-3"><i class="bi bi-check-circle me-1"></i>Terverifikasi</span>
                        @else
                            @if(Auth::guard('guru')->check())
                                <form action="{{ route('guru.observasi.verifikasi', $observasiAktif->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-check-circle me-1"></i>Verifikasi
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-warning text-dark py-2 px-3">
                                    <i class="bi bi-hourglass-split me-1"></i>Pending
                                </span>
                            @endif
                        @endif
                    </td>
                    @endif
                </tr>
                <tr class="table-secondary">
                    @if($loop->last)
                    <td class="fw-bold">Skor</td>
                    <td class="text-center">{{ $detail->skor }}</td>
                    @endif
                </tr>
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

    <div class="d-flex justify-content-center mt-4">
        {{ $observasiPaginate->links('pagination::bootstrap-5') }}
    </div>

    @else
        <div class="text-center align-middle alert alert-danger my-5 py-4 fw-bold shadow-sm col-md-12">
            Belum ada data Observasi Siswa
        </div>
    @endif
@endsection