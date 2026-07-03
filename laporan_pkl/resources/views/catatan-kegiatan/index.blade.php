<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
</head>
<body>
    <div style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
        <h2 class="fw-bold">Catatan Kegiatan</h2>
        <a class="ms-auto me-5" href="{{ route('catatan-kegiatan.create') }}"><button class="btn btn-primary">Tambah</button></a>
        <br><br>
        <table class="table table-hover">
            <thead>
                <tr style="text-align:center;" class="table-warning">
                    <th>No</th>
                    <th>Nama Pekerjaan</th>
                    <th>Perencanaan Kegiatan</th>
                    <th>Pelaksanaan Kegiatan</th>
                    <th>Catatan Instruktur</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($catatan_kegiatan as $catatan_kegiatan)
                <tr style="text-align:center;">
                    <td>{{ $catatan_kegiatan->id }}</td>
                    <td>{{ $catatan_kegiatan->nama_pekerjaan }}</td>
                    <td>{{ $catatan_kegiatan->perencanaan_kegiatan }}</td>
                    <td>{{ $catatan_kegiatan->pelaksanaan_kegiatan }}</td>
                    <td>{{ $catatan_kegiatan->catatan_instruktur }}</td>
                    <td>
                        <div style="display:flex;">
                            <a href="{{ route('catatan-kegiatan.edit', $catatan_kegiatan->id) }}"><button class="btn btn-warning">Edit</button></a>
                            <form action="{{ route('catatan-kegiatan.destroy', $catatan_kegiatan->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>