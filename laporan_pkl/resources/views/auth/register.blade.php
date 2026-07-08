<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h4 class="card-tittle text-center fw-bold text-dark mb-4">Daftar Pengguna</h4>

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show text-sm" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <ul class="nav nav-pills nav-justified mb-4 bg-white p-1 rounded border" id="registerTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-murid" onclick="switchRegisterTab('murid')">Murid</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-guru" onclick="switchRegisterTab('guru')">Guru</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-dudi" onclick="switchRegisterTab('dudi')">Dudi</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-web" onclick="switchRegisterTab('web')">Admin</button>
                            </li>
                        </ul>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden" name="user_type" id="user_type" value="{{ old('user_type', 'murid') }}">

                            <div class="mb-3 data-field" data-user="murid">
                                <label for="nama_murid" class="form-label fw-bold">Nama Murid</label>
                                <input type="text" name="nama_murid" id="nama_murid" value="{{ old('nama_murid') }}" class="form-control">
                            </div>

                            <div class="mb-3 data-field" data-user="web">
                                <label for="name" class="form-label fw-bold">Nama Admin</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
                            </div>

                            <div class="mb-3 data-field" data-user="guru">
                                <label for="nama" class="form-label fw-bold">Nama Guru</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-control">
                            </div>
                            <div class="mb-3 data-field" data-user="guru">
                                <label for="nip" class="form-label fw-bold">NIP</label>
                                <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="form-control">
                            </div>

                            <div class="mb-3 data-field" data-user="dudi">
                                <label for="nama_dudi" class="form-label fw-bold">Nama DUDI</label>
                                <input type="text" name="nama_dudi" id="nama_dudi" value="{{ old('nama_dudi') }}" class="form-control">
                            </div>
                            <div class="mb-3 data-field" data-user="dudi">
                                <label for="alamat_dudi" class="form-label fw-bold">Alamat Perusahaan DUDI</label>
                                <textarea type="text" name="alamat_dudi" id="alamat_dudi" rows="2" class="form-control">{{ old('alamat_dudi') }}</textarea>
                            </div>
                            <div class="mb-3 data-field" data-user="dudi">
                                <label for="no_telepon" id="no_telepon" class="form-label fw-bold">No Telepon DUDI</label>
                                <input class="form-control" type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}">
                            </div>
                            <div class="mb-3 data-field" data-user="dudi">
                                <label for="nama_pembimbing" class="form-label fw-bold">Nama Pembimbing</label>
                                <input type="text" name="nama_pembimbing" id="nama_pembimbing" value="{{ old('nama_pembimbing') }}" class="form-control">
                            </div>

                            <div class="mb-3 data-field" data-user="web guru dudi">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Masukkan Email">
                            </div>
                            <div class="row data-field" data-user="web guru dudi">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 Karakter">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi Password">
                                </div>
                            </div>

                            <div class="data-field" data-user="murid">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nis" class="form-label fw-bold">NIS</label>
                                        <input class="form-control" type="text" name="nis" id="nis" value="{{ old('nis') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kelas" class="form-label fw-bold">Kelas</label>
                                        <input class="form-control" type="text" name="kelas" id="kelas" value="{{ old('kelas') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="konsentrasi_keahlian_id" class="form-label fw-bold">Konsentrasi Keahlian</label>
                                    <select name="konsentrasi_keahlian_id" id="konsentrasi_keahlian_id" class="form-select">
                                        <option value="">-- Pilih Keahlian --</option>
                                        @foreach($konsentrasi as $item)
                                        <option value="{{ $item->id }}">{{ $item->{'konsentrasi-keahlian'} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tempat_lahir" class="form-label fw-bold">Tempat Lahir</label>
                                        <input class="form-control" type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                                        <input class="form-control" type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold d-block" for="">Jenis Kelamin</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="pria" value="pria" {{ old('jenis_kelamin', 'pria') == 'pria' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pria">Pria</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="wanita" value="wanita" {{ old('jenis_kelamin', 'wanita') == 'wanita' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wanita">Wanita</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat_siswa" class="form-label fw-bold">Alamat Siswa</label>
                                    <textarea name="alamat_siswa" id="alamat_siswa" class="form-control" rows="2">{{ old('alamat_siswa') }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_wali_ortu" class="form-label fw-bold">Nama Wali / Ortu</label>
                                        <input class="form-control" type="text" name="nama_wali_ortu" id="nama_wali_ortu" value="{{ old('nama_wali_ortu') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="alamat_wali_ortu" class="form-label fw-bold">Alamat Wali / Ortu</label>
                                        <input class="form-control" type="text" name="alamat_wali_ortu" id="alamat_wali_ortu" value="{{ old('alamat_wali_ortu') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="no_telepon" id="no_telepon" class="form-label fw-bold">No Telepon Siswa</label>
                                        <input class="form-control" type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="no_telepon_wali" class="form-label fw-bold">No Telepon Wali / Ortu</label>
                                        <input class="form-control" type="text" name="no_telepon_wali" id="no_telepon_wali" value="{{ old('no_telepon_wali') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="dudi_id" class="form-label fw-bold">Nama DUDI</label>
                                    <select name="dudi_id" id="dudi_id" class="form-select">
                                        <option value="">-- Pilih DUDI --</option>
                                        @foreach(\App\Models\Identitas_Dudi::all() as $dudi)
                                        <option value="{{ $dudi->id }}" {{ old('dudi_id') == $dudi->id ? 'selected' : '' }}>{{ $dudi->nama_dudi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="guru_pembimbing_id" class="form-label fw-bold">Nama Pembimbing</label>
                                    <select name="guru_pembimbing_id" id="guru_pembimbing_id" class="form-select">
                                        <option value="">-- Pilih Guru Pembimbing --</option>
                                        @foreach(\App\Models\Guru_Pembimbing::all() as $guru)
                                        <option value="{{ $guru->id }}" {{ old('guru_pembimbing_id') == $guru->id ? 'selected' : '' }}>{{ $guru->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" id="btn-register-submit" class="btn btn-primary btn-lg shadow-sm">
                                    Daftar
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <span class="text-muted text-sm">Sudah punya akun?<a href="{{ route('login') }}">Login di sini</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function switchRegisterTab(type){
            document.getElementById('user_type').value = type;

            const role = ['murid','guru','dudi','web'];
            role.forEach(r => {
                const tabBtn = document.getElementById('tab-' + r);
                if (r === type){
                    tabBtn.classList.add('active');
                } else {
                    tabBtn.classList.remove('active');
                }
            });

            const field = document.querySelectorAll('.data-field');
            field.forEach(field => {
                const allowedUsers = field.getAttribute('data-user').split(' ');

                const inputs = field.querySelectorAll('input, select, textarea');

                if (allowedUsers.includes(type)) {
                    field.classList.remove('d-none');

                    inputs.forEach(input => {
                        input.disabled = false;
                        if(input.id !== 'password' && input.id !== 'password_confirmation'){
                            input.required = true;
                        }
                    });
                } else {
                    field.classList.add('d-none');

                    inputs.forEach(input => {
                        input.disabled = true;
                        input.required = false;
                    });
                }
            });

            const btnSubmit = document.getElementById('btn-register-submit');
            const no_telpon = document.getElementById('no_telepon');

            if(type === 'murid'){
                btnSubmit.className = "btn btn-primary btn-lg shadow-sm";
                no_telepon.innerText = "No Telepon Siswa";
            } else if(type === 'guru'){
                btnSubmit.className = "btn btn-success btn-lg shadow-sm";
            } else if(type === 'dudi'){
                btnSubmit.className = "btn btn-warning btn-lg shadow-sm";
                no_telepon.innerText = "No Telepon DUDI";
            } else if(type === 'web'){
                btnSubmit.className = "btn btn-danger btn-lg shadow-sm";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const currentType = document.getElementById('user_type').value;
            switchRegisterTab(currentType);
        });
    </script>
</body>
</html>