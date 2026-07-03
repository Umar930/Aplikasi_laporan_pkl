@extends('layouts.layout')

@section('title', 'Laporan Bulanan')

@section('content')
    <div style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
        <a class="ms-auto me-2" href=""><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        <br>
        <table class="table table-hover">
            <thead>
                <tr style="text-align:center;" class="table-warning">
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
                <tr style="text-align:center;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="#"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                        <a href="#"><button class="btn btn-danger"><i class="bi bi-trash-fill me-2"></i>Hapus</button></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection