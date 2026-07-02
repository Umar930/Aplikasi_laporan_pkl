<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color: #f4f9f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        h1{
            text-align: center;
            margin-top: 200px;
            font-size: 80px;
            color: #198754;
        }
        .container{
            display:flex;
            justify-content:center;
            gap: 5px;
            margin-top:-20px;
        }
        .container a{
            text-decoration:none;
        }
        .container p{
            margin-left:50px;
            margin-top:-2px;
        }
        .container a button{
            font-size:20px;
            border-radius: 10px;
            border: none;
            background:transparent;
            color: #198754;
            cursor:pointer;
        }
        .container a button:hover{
            /* background-color: #146c43; */
            text-decoration: underline #146c43;
        }
    </style>
</head>
<body>
    <h1>Welcome</h1>
    <div class="container">
        <a href="{{ route('register') }}"><button>Register</button></a>
        <p>Sudah punya akun?</p>
        <a href="{{ route('login') }}"><button>Login</button></a>
    </div>
</body>
</html>