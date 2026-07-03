<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <div style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
        <h2 class="fw-bold">Jurnal Kegiatan Harian</h2>
        <a class="ms-auto me-5" href="{{ route('jurnal-kegiatan.create') }}"><button class="btn btn-primary">Tambah</button></a>
        <br><br>
        <table border="2" class="table table-hover">
            <thead>
                <tr class="table-primary" style="text-align:center;">
                    <th>No</th>
                    <th>Hari/Tanggal</th>
                    <th>Kompetensi</th>
                    <th>Topik Pekerjaan</th>
                    <th>Nilai Karater</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($jurnal_kegiatan))
                @foreach($jurnal_kegiatan as $jurnal_kegiatan)
                <tr style="text-align:center;">
                    <td>{{ $jurnal_kegiatan->id }}</td>
                    <td>{{ $jurnal_kegiatan->hari_tanggal }}</td>
                    <td>{{ $jurnal_kegiatan->kompetensi }}</td>
                    <td>{{ $jurnal_kegiatan->topik_pekerjaan }}</td>
                    <td>{{ $jurnal_kegiatan->nilai_karakter }}</td>
                    <td>
                        <div style="display:flex; justify-content:center;">
                            <a href="{{ route('jurnal-kegiatan.edit', $jurnal_kegiatan->id) }}"><button class="btn btn-warning">Edit</button></a>
                            <form action="{{ route('jurnal-kegiatan.destroy', $jurnal_kegiatan->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td>Belum ada data</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>