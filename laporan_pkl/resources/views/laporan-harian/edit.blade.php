@extends('layouts.layout')

@section('title', 'Tambah Laporan Harian')

@section('content')

<div class="container mb-4 mt-4">
    <div class="card shadow-sm p-4">
        <h3 class="fw-bold">Edit Laporan Harian</h3>
        <form action="{{ route('murid.harian.update', $laporan->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row g-3 mb-4">
                <div class="col-md-6 mb-2">
                    <label class="form-label" for="">Tanggal Hari</label>
                    <input value="{{ $laporan->tanggal_hari }}" required type="date" class="form-control" name="tanggal_hari">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label" for="">Kompetensi Dasar</label>
                    <input required type="text" value="{{ $laporan->kompetensi_dasar }}" class="form-control" name="kompetensi_dasar">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label" for="">Topik Pembelajaran</label>
                    <input required type="text" value="{{ $laporan->Topik_pembelajaran }}" class="form-control" name="Topik_pembelajaran">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label" for="">Nilai Karakter Budaya</label>
                    <input required type="text" value="{{ $laporan->nilai_karakter_budaya }}" class="form-control" name="nilai_karakter_budaya">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('murid.harian.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Edit Laporan Harian</button>
            </div>
        </form>
    </div>
</div>

@endsection