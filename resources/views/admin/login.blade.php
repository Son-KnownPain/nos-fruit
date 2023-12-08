<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NOS Fruits Admin - Login</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="/images/display/watermelon-icon.png" type="image/x-icon">
    {{-- Font awesome cdn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Bs5 cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #808080;
    }
    
    h3 {
        color: #fff;
    }

    label {
        display: block;
        margin-top: 12px;
        color: #fff;
    }

    input {
        display: block;
        margin-bottom: 12px;
        outline: none;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 4px;
        border: 1px solid #333;
    }

    button {
        font-size: 16px;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        border: 1px solid #fff;
        border-radius: 4px;
        color: #fff;
        background-color: #119282;
        padding: 4px;
    }
</style>
<body>
    <form action="/admin/login/store" method="POST">
        @csrf
        <h3 style="text-align: center;">Vui lòng xác thực</h3>
        @if (Session::has('wrong'))
            <h3 style="position: fixed; background-color: red; color: #fff; bottom: 0; left: 0;">{{Session::get('wrong')}}</h3>
        @endif
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Nhập email">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Nhập mật khẩu">
        <button>Đăng nhập</button>
    </form>
</body>
</html>