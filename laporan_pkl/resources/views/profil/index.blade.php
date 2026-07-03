@extends('layouts.layout')

@section('title', 'Profil')

@section('content')
<div>
    <form action="">
        @csrf
        <label for="">Nama</label>
        <input type="text">
        <br><br>
        <label for="">Kelas</label>
        <input type="text">
        <br><br>
        <label for="">Konsentrasi Keahlian</label>
        <input type="text">
        <br><br>
        <label for="">Tempat Lahir</label>
        <input type="text">
        <br><br>
        <label for="">Tanggal Hari</label>
        <input type="date">
        <br><br>
        <label for="">Nis</label>
        <input type="number">
        <br><br>
        <label for="">Jenis Kelamin</label>
        <input type="radio" value="laki-laki">Laki-Laki
        <input type="radio" value="perempuan">Perempeuan
        <br><br>
        <label for="">Alamat Siswa</label>
        <input type="text">
        <br><br>
        <label for="">Alamat Wali/Ortu</label>
        <input type="text">
        <br><br>
        <label for="">Golongan Darah</label>
        <input type="text">
        <br><br>
        <label for="">Catatan Kesehatan</label>
        <textarea name="" id="">
            catatan
        </textarea>
        <br><br>
        <label for="">Nama Wali/Ortu</label>
        <input type="text">
        <br><br>
        <label for="">No Telpon Siswa</label>
        <input type="number">
        <br><br>
        <label for="">No Telpon Wali/Ortu</label>
        <input type="number">
    </form>
</div>
@endsection