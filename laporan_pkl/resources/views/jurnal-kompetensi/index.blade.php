@extends('layouts.layout')

@section('title', 'Jurnal Kompetensi')

@section('content')
    <div style="display:flex; flex-direction:column;">
        @unless(Auth::guard('murid')->check())
        <a class="ms-auto me-2" href="{{ route('jurnal-kompetensi.tambah') }}"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        @endunless
        <br>
        <table class="table table-hover">
            <thead>
                <tr class="table-success align-middle text-center">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Kompetensi</th>
                    <th class="table-primary" colspan="2">Pelaksanaan Pembelajaran</th>
                    <th rowspan="2">Nilai Minimal Kompetensi</th>
                    <th rowspan="2">Nilai Kompetensi</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Keterangan</th>
                    <th rowspan="2">Status Diverifikasi</th>
                    @unless(Auth::guard('murid')->check())
                    <th rowspan="2">Aksi</th>
                    @endunless
                </tr>
                <tr class="table-primary align-middle text-center">
                    <th>Sekolah</th>
                    <th>Dunia Kerja</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($kompetensi_dasars as $kategori => $items)
                @foreach($items as $index => $item)
                <tr class="text-center">
                    @if($loop->first)
                    <td rowspan="{{ $items->count() + 6 }}" class="text-center fw-bold bg-light">{{ $no++ }}</td>
                    <td class="fw-bold bg-light">{{ $kategori }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td>{{ $index + 1 }}. {{ $item->nama_kompetensi }}</td>
                    @unless(Auth::guard('murid')->check())
                    <td colspan="2" class="text-center align-middle">
                        <select class="form-select" name="pelaksanaan_pembelajran" id="pelaksanaan_pembelajaran">
                            <option value="">Sekolah dan Dunia Kerja</option>
                            <option value="">Sekolah</option>
                            <option value="">Dunia Kerja</option>
                        </select>
                    </td>
                    @endunless
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @unless(Auth::guard('murid')->check())
                    <td>
                        <div class="d-flex gap-1">
                            <a href="#"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                            <a href="#"><button class="btn btn-danger"><i class="bi bi-trash-fill me-2"></i>Hapus</button></a>
                        </div>
                    </td>
                    @endunless
                @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center align-middle py-5">
                        Belum ada data.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection