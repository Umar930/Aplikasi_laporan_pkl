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
                            <input type="text" placeholder="Email" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Nama</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-person-fill text-secondary"></i>
                        </span>
                    </div>
                    <br>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="number" placeholder="NIP" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">NIP</label>
                        </div>
                        <!-- <span class="input-group-text">
                            <i class="bi bi-envelope-fill text-secondary"></i>
                        </span> -->
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
                            <input type="Password" placeholder="Password" class="form-control" id="floatingInput" required>
                            <label for="floatingInput">Password</label>
                        </div>
                        <span class="input-group-text">
                            <i class="bi bi-key-fill text-secondary"></i>
                        </span>
                    </div>
                </form>
                <br>
                <button class="btn btn-success" type="submit">Register</button>
            </div>
        </div>
    </div>
</body>
</html>