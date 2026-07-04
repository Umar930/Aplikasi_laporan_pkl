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
                            <input type="text" placeholder="Nama Dudi" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Nama Dudi</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-person-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Alamat" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Alamat</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-house-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="tel" placeholder="No Telpon" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">No Telpon</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-telephone-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" placeholder="Nama Pembimbing" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Nama Pembimbing</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-person-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="email" placeholder="Email" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Email</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-envelope-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="password" placeholder="Password" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Password</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-key-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>