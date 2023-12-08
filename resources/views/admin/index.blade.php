@extends('admin.main')

@section('content')
    <h2 class="heading">Trang Quản Trị Website NOS Fruits</h2>
    <h3 class="title">
        <i class="fa-solid fa-table"></i>
        Các bảng dữ liệu chính
    </h3>
    <p class="text">
        Users, Products, Categories, Orders, OrderDetails, Contacts
    </p>

    <h3 class="title">1. Bảng Users</h3>
    <p class="text">
        UserID: Mã người dùng <br>
        Email: Mail của người dùng, dùng để đăng nhập <br>
        Phone: Số điện thoại người dùng <br>
        Name: Tên người dùng <br>
        Level: Cấp độ ủy quyền (0: người dùng, 1: nhân viên, 2: quản trị viên) <br>
        Password: Mật khẩu <br>
        Address: Địa chỉ nhận hàng
    </p>

    <h3 class="title">2. Bảng Products</h3>
    <p class="text">
        ProductID: Mã sản phẩm <br>
        CategoryID: Mã danh mục <br>
        ProductName: Tên sản phẩm <br>
        Price: Giá <br>
        Quantity: Số lượng còn trong kho <br>
        Discount: Chiết khấu giảm giá sản phẩm ( Range: 0% - 100% ) <br>
        Summary: Sơ lược thông tin sản phẩm <br>
        Description: Mô tả sản phẩm <br>
        Thumbnail: Hình ảnh trưng bày cho sản phẩm, giá trị là đường dẫn tới hình ảnh
    </p>

    <h3 class="title">3. Bảng Categories</h3>
    <p class="text">
        CategoryID: Mã danh mục <br>
        CategoryName: Tên danh mục <br>
        Slug: Slug của danh mục. VD: hoa-qua
    </p>

    <h3 class="title">4. Bảng Orders</h3>
    <p class="text">
        OrderID: Mã đơn hàng <br>
        UserID: Mã người dùng (người mua) đặt đơn hàng này <br>
        EnteredAddress: Địa chỉ mà người mua nhập bằng tay(user input) <br>
        Address: Địa chỉ chuẩn, theo định dạng xã, huyện, tỉnh <br>
        Phone: Số điện thoại liên hệ trong đơn hàng này <br>
        Note: Ghi chú của người mua gửi cho người bán hàng <br>
        OrderDate: Ngày mà người mua xác nhận đặt hàng <br>
        DeliveryDate: Ngày bắt đầu giao hàng <br>
        Status: Trạng thái đơn hàng (Chờ xác nhận, Đang giao, Đã giao)
    </p>

    <h3 class="title">5. Bảng OrderDetails</h3>
    <p class="text">
        OrderID: Mã đơn hàng <br>
        ProductID: Mã sản phẩm <br>
        UnitPrice: Đơn giá, giá mỗi sản phẩm <br>
        Quantity: Số lượng <br>
        Discount: Chiết khấu
    </p>

    <h3 class="title">6. Bảng Contacts</h3>
    <p class="text">
        ContactID: Mã của một liên hệ của người dùng <br>
        ContactName: Tên người liên hệ <br>
        Email: Mail của người liên hệ <br>
        Message: Lời nhắn của họ
    </p>
@endsection

@section('head')
    @vite(['resources/scss/admin/index.scss'])
@endsection