@extends('layouts.layout')

@section('title', 'Laporan Harian')

@section('content')
<div>

    @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('sukses') }}
        </div>
    @endif

    @if(Auth::guard('murid')->check())
        <div class="d-flex justify-content-end mb-3">
            <a class="ms-auto me-2" href="{{ route('murid.harian.tambah') }}"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
            <br>
        </div>
    @endif

    @if(!Auth::guard('murid')->check() && $murids->isNotEmpty())
        <div class="card shadow-sm p-3 mb-4">
            <form method="get" class="row align-items-center g-3" action="{{ route('dudi.harian.index') }}">
                <label for="" class="col-md-2 fw-bold">Pilih Siswa</label>
                <div class="col-md-6">
                    <select name="murid_id" id="murid_id" onchange="this.form.submit()" class="form-select">
                        @foreach($murids as $m)
                            <option value="{{ $m->id }}" {{ $selectedMuridId == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_murid }} (NIS: {{ $m->nis ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    @endif

    <div class="card shadow-sm p-3 mb-4">
        <div class="row align-items-center">
            <div class="col-md-7">
                <table class="table table-borderless text-start">
                    <tr><td><strong>Nama Siswa</strong></td><td>: {{ $selectedMurid->nama_murid ?? 'siswa tidak ditemukan' }}</td></tr>
                    <tr><td><strong>Kelas</strong></td><td>: {{ $selectedMurid->kelas ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="position-relative d-flex align-items-center mb-3">
        <button class="btn btn-outline-secondary btn-sm me-2" id="scrollLeft"><i class="bi bi-chevron-left"></i></button>

        <div class="overflow-hidden flex-grow-1" id="tabContainer" style="white-space: nowrap; scroll-behavior: smooth;">
            <ul class="nav nav-pills flex-nowrap gap-1" id="pills-tab" role="tablist" style="display: inline-flex;">
                @for($m = 1; $m <= 24; $m++)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $m == 1 ? 'active' : ''}}" type="button" role="tab" data-bs-target="#pills-m{{ $m }}" id="pills-m{{ $m }}-tab" data-bs-toggle="pill">
                            Minggu {{ $m }}
                        </button>
                    </li>
                @endfor
            </ul>
        </div>

        <button class="btn btn-outline-secondary btn-sm ms-2" id="scrollRight"><i class="bi bi-chevron-right"></i></button>
    </div>

    <div class="tab-content" id="pills-tabContent">
        @for($m = 1; $m <= 24; $m++)
            @php
                $laporanMinggu = $laporansGroupped->get($m, collect());
                $isAllVerifiedByGuru = $laporanMinggu->isNotEmpty() && $laporanMinggu->every(fn($item) => $item->diverifikasi_oleh_guru !== null);
            @endphp

            <div id="pills-m{{ $m }}" role="tabpanel" class="tab-pane fade {{ $m == 1 ? 'show active' : '' }}">
                <div class="card shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <table class="table table-bordered">
                            <thead class="text-center align-middle">
                                <tr class="table-primary">
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Hari/Tanggal</th>
                                    <th rowspan="2">Kompetensi</th>
                                    <th rowspan="2">Topik Pembelajaran</th>
                                    <th rowspan="2">Nilai Karater</th>
                                    <th colspan="2">Status Verifikasi</th>
                                    <th rowspan="2">Aksi</th>
                                </tr>
                                <tr class="table-secondary align-middle text-center">
                                    <th>Diverifikasi Pembimbing</th>
                                    <th>Diverifikasi Guru</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle text-center">
                                @forelse($laporanMinggu as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_hari)->translatedFormat('l, d F Y') }}</td>
                                        <td>{{ $item->kompetensi_dasar }}</td>
                                        <td>{{ $item->Topik_pembelajaran }}</td>
                                        <td>{{ $item->nilai_karakter_budaya }}</td>
                                        <td>
                                            @if($item->diverifikasi_oleh_dudi)
                                                <span class="badge bg-success"><i class="bi bi-check-lg me-1"></i>Terverifikasi</span>
                                            @else
                                                @if(Auth::guard('dudi')->check())
                                                    <form action="{{ route('dudi.harian.verifikasi', $item->id) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                                            <i class="bi bi-check-circle me-1"></i>Verifikasi
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                                @endif
                                            @endif
                                        </td>
                                        @if($loop->first)
                                        <td rowspan="{{ $laporanMinggu->count() }}">
                                            @if($item->diverifikasi_oleh_guru && $isAllVerifiedByGuru)
                                                <span class="badge bg-success"><i class="bi bi-check-lg me-1"></i>Terverifikasi</span>
                                            @else
                                                @if(Auth::guard('guru')->check() && $laporanMinggu->isNotEmpty())
                                                    <form action="{{ route('guru.harian.verifikasi', $item->id) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="murid_id" value="{{ $selectedMuridId }}">
                                                        <input type="hidden" name="minggu_ke" value="{{ $m }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                                            <i class="bi bi-check-circle me-1">Verifikasi Minggu ke-{{ $m }}</i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                                                @endif
                                            @endif
                                        </td>
                                        @endif
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                @if(!$item->diverifikasi_oleh_dudi && !$item->diverifikasi_oleh_guru && Auth::guard('murid')->check())
                                                    <a href="{{ route('murid.harian.edit', $item->id) }}"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                                                    <form action="{{ route('murid.harian.delete', $item->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash-fill me-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted fs-7">Dikunci</span>
                                                @endif

                                                @if(Auth::guard('dudi')->check())
                                                    <form action="{{ route('dudi.harian.delete', $item->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash-fill me-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                                @if(Auth::guard('guru')->check())
                                                    <form action="{{ route('guru.harian.delete', $item->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash-fill me-2"></i>Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center p-4 text-muted">
                                            <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                            Belum ada laporan harian untuk Minggu ke-{{ $m }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

<script>
    document.getElementById('scrollLeft').addEventListener('click',function(){
        document.getElementById('tabContainer').scrollLeft -= 200;
    });
    document.getElementById('scrollRight').addEventListener('click',function(){
        document.getElementById('tabContainer').scrollLeft += 200;
    });
</script>
@endsection