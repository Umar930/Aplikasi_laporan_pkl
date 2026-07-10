@extends('layouts.layout')

@section('title', 'Observasi')

@section('content')
    <div style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
        @unless(Auth::guard('murid')->check())
        <a href="#" class="ms-auto me-2"><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        @endunless
        <br>
        <table class="table table-hover">
            <thead>
                <tr style="text-align:center;" class="table-danger">
                    <th>No</th>
                    <th>Tujuan Pembelajaran</th>
                    <th>Ketercapaian</th>
                    <th>Deskripsi</th>
                    <th>Status Verifikasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($tujuan_pembelajaran as $point_utama => $items)

                @foreach($items as $index => $item)
                <tr class="text-center">
                    @if($loop->first)
                    <td rowspan="{{ $items->count() + 6 }}">{{ $no++ }}</td>
                    <td class="fw-bold">{{ $point_utama }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td>{{ $item->point_details }}</td>
                    <td>
                        <select class="form-select" name="ketercapaian" id="ketercapaian">
                            <option value="ketercapaian">-- Ketercapaian --</option>
                            <option value="ya">Ya</option>
                            <option value="tidak">Tidak</option>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td style="text-align:center;">
                        <div class="d-flex">
                            <a href="#"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                            <a href="#"><button class="btn btn-danger"><i class="bi bi-trash-fill me-2"></i>Hapus</button></a>
                        </div>
                    </td>
                </tr>
                @endforeach

                @empty
                <tr>
                    <td>Belum ada data</td>
                </tr>

                @endforelse
                </tr>
            </tbody>
        </table>
    </div>
@endsection