@extends('layouts.layout')

@section('title', 'Jurnal Kompetensi')

@section('content')
    <div style="display:flex; flex-direction:column;">


        @if(session('sukses'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('sukses') }}
            </div>
        @endif

        @if(Auth::guard('guru')->check())
        <a class="ms-auto me-2" href="{{ route('guru.jurnal.tambah') }}"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        @endif
        <br>
        @if(Auth::guard('dudi')->check())
        <a class="ms-auto me-2" href="{{ route('dudi.jurnal.tambah') }}"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        @endif
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

        <div class="d-flex gap-2 mb-3 mt-3">
            @if(Auth::guard('guru')->check())
                @if($jurnalAktif->status_diverifikasi !== 'diverifikasi')
                    <a href="{{ route('guru.jurnal.edit', $jurnalAktif->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                @else
                    <span class="text-muted fs-7"><i>Dikunci</i></span>
                    <form action="{{ route('guru.jurnal.hapus', $jurnalAktif->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill">Hapus</i></button>
                    </form>
                @endif
            @endif

            @if(Auth::guard('dudi')->check())
                @if($jurnalAktif->status_diverifikasi !== 'diverifikasi')
                    <a href="{{ route('dudi.jurnal.edit', $jurnalAktif->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                @else
                    <span class="text-muted fs-7"><i>Dikunci</i></span>
                    <form action="{{ route('dudi.jurnal.hapus', $jurnalAktif->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill">Hapus</i></button>
                    </form>
                @endif
            @endif
        </div>

        <table class="table table-bordered">
            <thead>
                <tr class="table-success align-middle text-center">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Kompetensi</th>
                    <th rowspan="2">Pelaksanaan Pembelajaran</th>
                    <th rowspan="2">Nilai Minimal Kompetensi</th>
                    <th rowspan="2">Nilai Kompetensi</th>
                    <th width="15%" rowspan="2">Tanggal</th>
                    <th rowspan="2">Keterangan</th>
                    <th colspan="2">Status Diverifikasi</th>
                </tr>
                <tr class="text-center align-middle">
                    <td>Diverifikasi Guru</td>
                    <td>Diverifikasi Dudi</td>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp

                @forelse($detailGroup as $kategori => $details)
                <tr class="">
                    <td rowspan="{{ $details->count() + 1 }}" class="text-center fw-bold bg-light">{{ $no++ }}</td>
                    <td colspan="2" class="fw-bold bg-light">{{ $kategori }}</td>
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
                    @if($loop->first)
                        <td rowspan="{{ $details->count() }}" class="align-middle">
                            @if($jurnalAktif->diverifikasi_oleh_guru)
                                <span class="badge bg-success py-2 px-3"><i class="bi bi-check-circle me-1"></i>Terverifikasi</span>
                            @else
                                @if(Auth::guard('guru')->check())
                                    <form action="{{ route('guru.jurnal.verifikasi', $jurnalAktif->id) }}" method="post">
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
                        <td rowspan="{{ $details->count() }}" class="align-middle">
                            @if($jurnalAktif->diverifikasi_oleh_dudi)
                                <span class="badge bg-success py-2 px-3"><i class="bi bi-check-circle me-1"></i>Terverifikasi</span>
                            @else
                                @if(Auth::guard('dudi')->check())
                                    <form action="{{ route('dudi.jurnal.verifikasi', $jurnalAktif->id) }}" method="post">
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