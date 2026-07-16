<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: screen; height: 100vh;">
    <div class="card shdow border-0" style="width:100%; max-width: 400px;">
        <div class="card-body p-4">
            <h4 class="card-tittle text-center fw-bold text-darl mb-4">Login Pengguna</h4>

            @if (session('sukses'))
                <div class="alert alert-success alert-dismissible fade show py-2 px-3 text-sm" role="alert">
                    {{ session('sukses') }}
                    <button type="button" class="btn-close align-items-center" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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

        <ul class="nav nav-pills nav-justified mb-4 bg-white p-1 rounded border" id="loginTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-murid" onclick="switchTab('murid')">Murid</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-guru" onclick="switchTab('guru')">Guru</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-dudi" onclick="switchTab('dudi')">Dudi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-web" onclick="switchTab('web')">Admin</button>
            </li>
        </ul>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <input type="hidden" name="user_type" id="user_type" value="{{ old('user_type', 'murid') }}">

            <div id="form-murid" class="mb-3">
                <label for="nis" class="form-label fw-semibold">Nomor Induk Siswa (NIS)</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis') }}" class="form-control form-control-lg" placeholder="Masukkan NIS Anda">
            </div>

            <div id="form-kredensial" class="d-none">
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control form-control-lg" placeholder="Masukkan Email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Masukkan Passowrd">
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" id="btn-submit" class="btn btn-primary btn-lg shadow-sm">
                    Login
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function switchTab(type) {

            document.getElementById('user_type').value = type;

            const tabs = ['murid', 'guru', 'dudi', 'web'];
            tabs.forEach(t => {
                const tabBtn = document.getElementById('tab-' +  t);
                if (t === type) {
                    tabBtn.classList.add('active');
                } else {
                    tabBtn.classList.remove('active');
                }
            });

            const formMurid = document.getElementById('form-murid');
            const formKredensial = document.getElementById('form-kredensial');
            const inputNis = document.getElementById('nis');
            const inputEmail = document.getElementById('email');
            const inputPassword = document.getElementById('password');
            const btnSubmit = document.getElementById('btn-submit')

            if(type === 'murid') {
                formMurid.classList.remove('d-none');
                formKredensial.classList.add('d-none');

                inputNis.required = true;
                inputEmail.required = false;
                inputPassword.required = false;

                btnSubmit.innerText = "Masuk sebagai Murid";
                btnSubmit.className = "btn btn-primary btn-lg shadow-sm";
            } else{
                formMurid.classList.add('d-none');
                formKredensial.classList.remove('d-none');

                inputNis.required = false;
                inputEmail.required = true;
                inputPassword.required = true;

                if(type === 'guru') {
                    btnSubmit.innerText = "Masuk sebagai Guru";
                    btnSubmit.className = "btn btn-success btn-lg shadow-sm";
                } else if(type === 'dudi'){
                    btnSubmit.innerText = "Masuk sebagai Dudi";
                    btnSubmit.className = "btn btn-warning btn-lg shadow-sm";
                } else if(type === 'web'){
                    btnSubmit.innerText = "Masuk sebagai Admin";
                    btnSubmit.className = "btn btn-danger btn-lg shadow-sm";
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function(){
            const currentType = document.getElementById('user_type').value;
            switchTab(currentType);
        });
    </script>
</body>
</html>