<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="/images/display/watermelon-icon.png" type="image/x-icon">
    {{-- Font awesome cdn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Bs5 cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    @yield('head')
</head>
<body>
    <div class="app">
        <header class="header">
            <a href="/admin" class="logo-link">
                NOS Fruits Admin
                <i class="fa-solid fa-hammer"></i>
            </a>

            <div class="menu">
                <a href="/admin/logout" class="menu-item">Đăng xuất</a>
            </div>
        </header>
        <div class="sidebar">
            <a href="/admin" class="sidebar-item-link">
                <i class="fa-solid fa-house-user"></i>
                Trang chủ
            </a>
            <a href="/admin/users" class="sidebar-item-link">
                <i class="fa-solid fa-users"></i>
                Người dùng
            </a>
            <a href="/admin/products" class="sidebar-item-link">
                <i class="fa-solid fa-boxes-stacked"></i>
                Sản phẩm
            </a>
            <a href="/admin/categories" class="sidebar-item-link">
                <i class="fa-solid fa-layer-group"></i>
                Danh mục
            </a>
            <a href="/admin/contacts" class="sidebar-item-link">
                <i class="fa-solid fa-envelope"></i>
                Liên hệ
            </a>
            <a href="/admin/orders" class="sidebar-item-link">
                <i class="fa-solid fa-inbox"></i>
                Đơn hàng
            </a>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>

@yield('script')

</html>