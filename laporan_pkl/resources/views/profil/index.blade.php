@extends('layouts.layout')

@if(Auth::guard('murid')->check())
@section('title', 'Profil Murid')
@endif

@if(Auth::guard('guru')->check())
@section('title', 'Profil Guru')
@endif

@if(Auth::guard('dudi')->check())
@section('title', 'Profil Dudi')
@endif

@if(Auth::guard('web')->check())
@section('title', 'Profil Admin')
@endif


@section('content')
<div class="w-50">
    <form action="">
        @csrf

        @if(Auth::guard('murid')->check())
        <label class="form-label" for="">Nama Murid</label>
        <div class="input-group">
            <input class="form-control" type="text">
            <span class="input-group-text">
                <i class="bi bi-person-fill"></i>
            </span>
        </div>
        <br>
            <label class="form-label" for="">Kelas</label>
            <input class="form-control" type="text">
            <br>
            <label class="form-label" for="">Konsentrasi Keahlian</label>
            <div class="input-group">
                <input class="form-control" type="text">
                <span class="input-group-text">
                    <i class="bi bi-code-slash"></i>
                </span>
            </div>
            <br>
            <label class="form-label" for="">Tempat Lahir</label>
            <div class="input-group">
                <input class="form-control" type="text">
                <span class="input-group-text">
                    <i class="bi bi-building"></i>
                </span>
            </div>
            <br>
            <label class="form-label" for="">Tanggal Lahir</label>
            <input class="form-control" type="date">
            <br>
            <label class="form-label" for="">Nis</label>
            <input class="form-control" type="number">
            <br>
            <label class="form-label" for="">Jenis Kelamin</label>
            <br>
            <div class="input-group">
                <select class="form-select" name="" id="">
                    <option value="pria">Pria</option>
                    <option value="wanita">Wanita</option>
                </select>
                <span class="input-group-text">
                    <i class="bi bi-gender-male"></i>
                </span>
            </div>
            <br>
            <label class="form-label" for="">Alamat Siswa</label>
            <div class="input-group">
                <input class="form-control" type="text">
                <span class="input-group-text">
                    <i class="bi bi-house-fill"></i>
                </span>
            </div>
            <br>
            <label class="form-label" for="">Alamat Wali/Ortu</label>
            <div class="input-group">
                <input class="form-control" type="text">
                <span class="input-group-text">
                    <i class="bi bi-house-fill"></i>
                </span>
            </div>
            <br>
            <label class="form-label" for="">Golongan Darah</label>
            <input class="form-control" type="text">
            <br>
            <label class="form-label" for="">Catatan Kesehatan</label>
            <textarea class="form-control" name="" id="" placeholder="Catatan Kesehatan"></textarea>
            <br>
            <label class="form-label" for="">Nama Wali/Ortu</label>
            <div class="input-group">
                <input class="form-control" type="text">
                <span class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </span>
            </div>
            <br>
            <label class="form-label" for="">No Telpon Siswa</label>
            <div class="input-group">
                <input class="form-control" type="tel">
                <span class="input-group-text">
                    <i class="bi bi-telephone-fill"></i>
                </span>
            </div>
            <br>
            <label class="form-label" for="">No Telpon Wali/Ortu</label>
            <div class="input-group">
                <input class="form-control" type="tel">
                <span class="input-group-text">
                    <i class="bi bi-telephone-fill"></i>
                </span>
            </div>
            <br>
        @endif

        @if(Auth::guard('guru')->check())
            <label class="form-label" for="">Nama Guru</label>
            <div class="input-group">
            <input class="form-control" type="text">
            <span class="input-group-text">
                <i class="bi bi-person-fill"></i>
            </span>
            </div>
            <br>
            <label class="form-label" for="">Nip</label>
            <input class="form-control" type="number">
            <br>
            <label class="form-label" for="">Email</label>
            <div class="input-group">
                <input class="form-control" type="email">
                <span class="input-group-text">
                    <i class="bi bi-envelope-fill"></i>
                </span>
            </div>
            <br>
        @endif

        @if(Auth::guard('dudi')->check())
            <label class="form-label" for="">Nama Dudi</label>
            <div class="input-group">
            <input class="form-control" type="text">
            <span class="input-group-text">
                <i class="bi bi-person-fill"></i>
            </span>
            </div>
            <br>
            <label class="form-label" for="">Alamat Perusahaan</label>
            <textarea name="" id="" class="form-control"></textarea>
            <br>
            <label class="form-label" for="">No Telepon</label>
            <div class="input-group">
                <input class="form-control" type="tel">
                <span class="input-group-text">
                    <i class="bi bi-telephone-fill"></i>
                </span>
            </div>
            <br>
            <label class="form-label" for="">Email</label>
            <div class="input-group">
                <input class="form-control" type="email">
                <span class="input-group-text">
                    <i class="bi bi-envelope-fill"></i>
                </span>
            </div>
            <br>
        @endif

        @if(Auth::guard('web')->check())
            <label class="form-label" for="">Nama Admin</label>
            <div class="input-group">
            <input class="form-control" type="text">
            <span class="input-group-text">
                <i class="bi bi-person-fill"></i>
            </span>
            </div>
            <br>
            <label class="form-label" for="">Email</label>
            <div class="input-group">
                <input class="form-control" type="email">
                <span class="input-group-text">
                    <i class="bi bi-envelope-fill"></i>
                </span>
            </div>
            <br>
        @endif
        <button type="submit" class="btn btn-success">Simpan Perubahan<i class="bi bi-person-fill ms-2"></i></button>
    </form>
</div>
@endsection