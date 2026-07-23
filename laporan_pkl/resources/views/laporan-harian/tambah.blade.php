@extends('layouts.layout')

@section('title', 'Tambah Laporan Harian')

@section('content')

<div class="container mb-4 mt-4">
    <div class="card shadow-sm p-4">
        <h3 class="fw-bold">Tambah Laporan Harian</h3>
        <form action="{{ route('murid.harian.store') }}" method="post">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-md-6 mb-2">
                    <label class="form-label" for="">Tanggal Hari</label>
                    <input value="{{ date('Y-m-d') }}" required type="date" class="form-control" name="tanggal_hari">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label" for="">Kompetensi Dasar</label>
                    <input required type="text" class="form-control" name="kompetensi_dasar">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label" for="">Topik Pembelajaran</label>
                    <input required type="text" class="form-control" name="Topik_pembelajaran">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label" for="">Nilai Karakter Budaya</label>
                    <input required type="text" class="form-control" name="nilai_karakter_budaya">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('murid.harian.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Tambah Laporan Harian</button>
            </div>
        </form>
    </div>
</div>

@endsection