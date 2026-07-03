@extends('layouts.layout')

@section('title', 'Laporan Nilai')

@section('content')
    <div style="display:flex; flex-direction:column;">
        <a class="ms-auto me-2" href=""><button class="btn btn-primary mt-4"><i class="bi bi-plus-lg me-2"></i>Tambah</button></a>
        <br>
        <table border="1" class="table table-hover mb-5">
            <thead>
                <tr class="table-danger align-middle text-center">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tujuan Pembelajaran</th>
                    <th rowspan="2">Skor</th>
                    <th rowspan="2">Deskripsi</th>
                    <th class="table-secondary" colspan="3">Kehadiran</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr class="table-secondary align-middle text-center">
                    <th>Sakit</th>
                    <th>Ijin</th>
                    <th>Tanpa Keterangan</th>
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
                    <td style="text-align:center;">
                        <a href="#"><button class="btn btn-warning"><i class="bi bi-pen-fill me-2"></i>Edit</button></a>
                        <a href="#"><button class="btn btn-danger"><i class="bi bi-trash-fill me-2"></i>Hapus</button></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <h4 class="fw-bold me-auto ms-3">Kriteria Penilaian:</h4>
        <table class="table w-25 me-auto ms-3">
            <thead>
                <tr class="table-info" style="text-align:center;">
                    <th>No</th>
                    <th>Nilai Angka</th>
                    <th>Kriteria</th>
                    <th>Huruf</th>
                </tr>
            </thead>
            <tbody style="text-align:center;" class="table-secondary">
                <tr>
                    <td>1</td>
                    <td>Nilai 90 - 100</td>
                    <td>Sangat Baik</td>
                    <td>A</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Nilai 80 - 89</td>
                    <td>Baik</td>
                    <td>B</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Nilai 65 - 79</td>
                    <td>Cukup</td>
                    <td>C</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Nilai 65 kebawah</td>
                    <td>Kurang</td>
                    <td>D</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection