@extends('layouts.layout')

@section('title', 'Jurnal Kompetensi')

@section('content')
    <div style="display:flex; flex-direction:column;">
        <a class="ms-auto me-2" href=""><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
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
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr class="table-primary align-middle text-center">
                    <th>Sekolah</th>
                    <th>Dunia Kerja</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>
                        <a href="#"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                        <a href="#"><button class="btn btn-danger"><i class="bi bi-trash-fill me-2"></i>Hapus</button></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection