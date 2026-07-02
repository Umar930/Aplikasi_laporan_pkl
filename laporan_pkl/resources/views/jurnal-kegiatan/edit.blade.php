<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h2>Tambah Jurnal</h2>
        <form action="{{ route('jurnal-kegiatan.update', $jurnal_kegiatan->id) }}" method="post">
            @csrf
            @method('PUT')
            <label for="">Hari/Tanggal</label>
            <br>
            <input type="date" name="hari_tanggal" value="{{ old('hari_tanggal', $jurnal_kegiatan->hari_tanggal) }}">
            <br>
            <label for="">Kompetensi</label>
            <br>
            <input type="text" name="kompetensi" value="{{ old('kompetensi', $jurnal_kegiatan->kompetensi) }}">
            <br>
            <label for="">Topik Pekerjaan</label>
            <br>
            <input type="text" name="topik_pekerjaan" value="{{ old('topik_pekerjaan', $jurnal_kegiatan->topik_pekerjaan) }}">
            <br>
            <label for="">Nilai Karakter</label>
            <br>
            <select name="nilai_karakter" value="{{ old('nilai_karakter', $jurnal_kegiatan->nilai_karakter) }}" id="">
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