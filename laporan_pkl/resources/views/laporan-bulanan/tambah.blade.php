<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h2>Tambah Catatan</h2>
        <form action="{{ route('catatan-kegiatan.store') }}" method="post">
            @csrf
            <label for="">Nama Pekerjaan</label>
            <br>
            <input type="text" name="nama_pekerjaan" value="{{ old('nama_pekerjaan') }}">
            <br>
            <label for="">Perencanaan Kegiatan</label>
            <br>
            <input type="text" name="perencanaan_kegiatan" value="{{ old('perencanaan_kegiatan') }}">
            <br>
            <label for="">Pelaksanaan Kegiatan</label>
            <br>
            <input type="text" name="pelaksanaan_kegiatan" value="{{ old('pelaksanaan_kegiatan') }}">
            <br>
            <label for="">Catatan Instruktur</label>
            <br>
            <select name="catatan_instruktur" value="{{ old('catatan_instruktur') }}" id="">
                <option value="jujur">Jujur</option>
                <option value="disiplin">Disiplin</option>
                <option value="mandiri">Mandiri</option>
            </select>
            <br>
            <button type="submit">Tambah</button>
        </form>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </div>
</body>
</html>