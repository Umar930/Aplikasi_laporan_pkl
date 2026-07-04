<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <div style="display:flex; justify-content:center;">
        <div class="card col-md-4 mt-5">
            <div class="card-body">
                <form action="{{ route('login') }}">
                    <h2 style="text-align:center;" class="fw-bold">Register</h2>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Nama" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Nama</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-person-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Kelas" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Kelas</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-buildings text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Konsentrasi Keahlian" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Konsentrasi Keahlian</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-code-slash text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Tempat Lahir" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Tempat Lahir</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-building text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="date" placeholder="Tanggal Lahir" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Tanggal Hari</label>
                        </div>
                        <!-- <span class="input-group-text">
                            <i class="bi bi-building text-secondary"></i>
                        </span> -->
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="number" placeholder="NIS" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">NIS</label>
                        </div>
                        <!-- <span class="input-group-text">
                            <i class="bi bi-building text-secondary"></i>
                        </span> -->
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <select placeholder="Jenis Kelamin" class="form-select" name="" id="" required>
                                <option value="pria">Pria</option>
                                <option value="wanita">Wanita</option>
                            </select>
                            <label for="floatingInput">Jenis Kelamin</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-gender-male text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Alamat Siswa" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Alamat Siswa</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-house-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Alamat Wali/Ortu" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Alamat Wali/Ortu</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-house-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Golongan Darah" class="form-control" id="floatingInput">
                            <label for="floatingInput">Golongan Darah</label>
                        </div>
                        <!-- <span class="input-group-text">
                            <i class="bi bi-home text-secondary"></i>
                        </span> -->
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <textarea name="" id="floatingInput" class="form-control" placeholder="Catatan Kesehatan"></textarea>
                            <label for="floatingInput">Catatan Kesehatan</label>
                        </div>
                        <!-- <span class="input-group-text">
                            <i class="bi bi-building text-secondary"></i>
                        </span> -->
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Nama Wali/Ortu" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Nama Wali/Ortu</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-person-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="tel" placeholder="No Telepon" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">No Telepon</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-telephone-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="tel" placeholder="No Telepon Wali/Ortu" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">No Telepon Wali/Ortu</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-telephone-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Identitas Dudi" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Nama Dudi</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-person-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Nama Guru Pembimbing" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Nama Guru Pembimbing</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-person-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <button class="btn btn-success" type="submit">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>