@extends('layouts.layout')

@section('title', 'Laporan Bulanan')

@section('content')
    <div>
    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('sukses') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
        </div>
    @endif

    @if(Auth::guard('dudi')->check())
        <div class="card shadow-sm p-3 mb-4">
            <form action="{{ route('dudi.bulanan.index') }}" method="get" class="row align-items-center">
                <label for="murid_id" class="col-md-2 col-form-label fw-bold">Pilih Murid</label>
                <select name="murid_id" id="murid_id" class="form-select" onchange="this.form.submit()">
                    @forelse($murids as $m)
                        <option value="{{ $m->id }}" {{ $selectedMuridId == $m->id ? 'selected' : '' }}>
                            {{ $m->nama_murid }} - ({{ $m->nis ?? 'NIS -' }})
                        </option>
                    @empty
                        <option value="">-- Belum ada Murid --</option>
                    @endforelse
                </select>
            </form>
        </div>
    @endif

    @if(Auth::guard('murid')->check())
        @if($laporans->count() < 6)
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('murid.bulanan.tambah') }}"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
                <br>
            </div>
        @endif
    @endif

        <div class="card shadow-sm p-2 mb-4">
            <div class="row align-items-center">
                <div class="col-md-7">
                    @php
                        $laporanAwal = $laporans->first();
                    @endphp
                    <table class="table table-borderless text-start">
                        <tr><td>Nama Siswa</td><td>: {{ $laporanAwal->murid->nama_murid ?? '-' }}</td></tr>
                        <tr><td>Nama Pembimbing</td><td>: {{ $laporanAwal->dudi->nama_pembimbing ?? '-' }}</td></tr>
                        <tr><td>Nama Guru Pembimbing</td><td>: {{ $laporanAwal->pembimbing->nama ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            @for($i = 1; $i <= 6; $i++)
                @php $lapbulan = $laporans->get($i); @endphp
                <li class="nav-item" role="presentation">
                    <button 
                        class="nav-link {{ $i === 1 ? 'active' : '' }} me-2"
                        id="pills-bulan-{{ $i }}-tab"
                        data-bs-toggle="pill"
                        data-bs-target="#pills-bulan-{{ $i }}"
                        type="button" role="tab">
                        Bulan {{ $i }}
                        @if($lapbulan)
                            @if($lapbulan->status_verifikasi === 'diverifikasi')
                                <span class="badge bg-success ms-1"><i class="bi bi-check-circle"></i></span>
                            @else
                                <span class="badge bg-warning text-dark ms-1"><i class="bi bi-clock"></i></span>
                            @endif
                        @endif
                    </button>
                </li>
            @endfor
        </ul>

        <div class="tab-content" id="pills-tabcontent">
            @for($i = 1; $i <= 6; $i++)
            
            @php $laporan = $laporans->get($i); @endphp
            <div class="tab-pane fade {{ $i === 1 ? 'show active' : '' }}" id="pills-bulan-{{ $i }}" role="tabpanel">
                <div class="card shadow-sm p-3">
                    <table class="table table-bordered align-middle text-center">
                        <thead>
                            <tr class="table-warning align-middle">
                                <th>No</th>
                                <th>Nama Pekerjaan</th>
                                <th>Perencanaan Kegiatan</th>
                                <th>Pelaksanaan Kegiatan</th>
                                <th>Catatan Instruktur</th>
                                <th>Status Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($laporan)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $laporan->nama_pekerjaan }}</td>
                                    <td>{{ $laporan->perencanaan_kegiatan }}</td>
                                    <td>{{ $laporan->pelaksanaan_kegiatan }}</td>
                                    <td>{{ $laporan->catatan_instruktur }}</td>
                                    <td>
                                        @if(Auth::guard('dudi')->check())
                                            @if($laporan->status_verifikasi === 'diverifikasi')
                                                <span class="badge bg-success fs-6"><i class="bi bi-check-check me-1">Diverifikasi</i></span>
                                            @else
                                                <form action="{{ route('dudi.bulanan.verifikasi', $laporan->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-check-circle me-1"></i>Verifikasi
                                                    </button>
                                                </form>
                                            @endif

                                        @elseif(Auth::guard('murid')->check())
                                            @if($laporan->status_verifikasi === 'diverifikasi')
                                                <span class="badge bg-success fs-6"><i class="bi bi-check-check me-1"></i>Diverifikasi oleh Dudi</span>
                                            @else
                                                <span class="badge bg-warning text-dark fs-6"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if(Auth::guard('murid')->check())
                                                @if($laporan->status_verifikasi !== 'diverifikasi')
                                                    <a href="{{ route('murid.bulanan.edit', $laporan->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                                                    <form action="{{ route('murid.bulanan.delete', $laporan->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill">Hapus</i></button>
                                                    </form>
                                                @else
                                                    <span class="text-muted fs-7"><i>Dikunci</i></span>
                                                @endif
                                            @endif

                                            @if(Auth::guard('dudi')->check())
                                                <a href="{{ route('dudi.bulanan.edit', $laporan->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2 text-secondary"></i>Edit Catatan</button></a>
                                                <form action="{{ route('dudi.bulanan.delete', $laporan->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill">Hapus</i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="7" class="text-center p-4">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        Belum ada laporan untuk Bulan ke-{{ $i }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endfor
        </div>
    </div>
@endsection