@extends('layouts.layout')

@section('title', 'Laporan Harian')

@section('content')
    <div style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
        <a class="ms-auto me-2" href=""><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        <br>
        <table class="table table-hover">
            <thead>
                <tr class="table-primary" style="text-align:center;">
                    <th>No</th>
                    <th>Hari/Tanggal</th>
                    <th>Kompetensi</th>
                    <th>Topik Pembelajaran</th>
                    <th>Nilai Karater</th>
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
                        <div class="d-flex">
                            <a href="#"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                        <a href="#"><button class="btn btn-danger"><i class="bi bi-trash-fill me-2"></i>Hapus</button></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection