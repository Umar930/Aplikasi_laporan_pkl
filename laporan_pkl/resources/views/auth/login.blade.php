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
    <div class="mt-5" style="display:flex; justify-content:center;">
        <div class="card col-md-3">
            <div class="card-body">
                <h2 style="text-align:center;" class="fw-bold">Login</h2>
                <form action="{{ route('laporan-bulanan') }}">
                    <div class="form-floating">
                        <input type="email" placeholder="Email" class="form-control" id="floatingInput">
                        <label for="floatingInput">Email</label>
                    </div>
                    <br>
                    <div class="form-floating">
                        <input type="password" placeholder="Password" class="form-control" id="floatingInput">
                        <label for="floatingInput">Password</label>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>