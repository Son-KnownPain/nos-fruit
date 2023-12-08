@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="profile">
            <div class="row">
                <div class="col-xl-3">
                    <div class="sidemenu">
                        <h3 class="title">Menu</h3>
                        <a href="/profile" class="item-link {{ $active == 'profile' ? 'active' : '' }}">Thông tin tài khoản</a>
                        <a href="/profile?section=orders" class="item-link {{ $active == 'orders' ? 'active' : '' }}">Đơn hàng của tôi</a>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="right-content">
                        @if (Session::has('orders'))
                            <h3 class="title">Đơn hàng của tôi</h3>

                            @if (empty($orders))
                                <h2 class="orders-empty-title">
                                    Không có đơn hàng nào!
                                    <a href="/products">Mua sắm ngay</a>
                                </h2>
                            @else
                                <table class="styled-table">
                                    <thead>
                                        <tr>
                                            <th>Ngày đặt</th>
                                            <th>Địa chỉ</th>
                                            <th>Tổng giá tiền</th>
                                            <th>Tình trạng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr class="order-tr" title="Xem Chi Tiết" data-id="{{ $order['orderRecord']['id'] }}">
                                                <td>{{ $order['orderRecord']['order_date'] }}</td>
                                                <td>{{ $order['orderRecord']['address'] }}</td>
                                                <td>{{ App\Helper::moneyFormat($order['totalPrice']) }} VNĐ</td>
                                                @switch($order['orderRecord']['status'])
                                                    @case(1)
                                                        <td>Chờ xác nhận</td>
                                                        @break
                                                    @case(2)
                                                        <td>Đang giao</td>
                                                        @break
                                                    @case(3)
                                                        <td>Đã giao</td>
                                                        @break
                                                    @default
                                                        <td>Không hợp lệ</td>
                                                @endswitch
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @else
                            <h3 class="title" id="edit-address">Thông tin tài khoản</h3>
                            <div class="profile-info">
                                <h1 class="key">
                                    Họ tên: 
                                    <span class="value">
                                        {{ $user->name }}
                                        @if (Auth::user()->level == 3)
                                            <i class="fa-solid fa-circle-check"></i>
                                        @endif
                                    </span>
                                </h1>
                                <h1 class="key">Số điện thoại: <span class="value">{{ $user->phone }}</span></h1>
                                <h1 class="key">Email: <span class="value">{{ $user->email }}</span></h1>
                                <h1 class="key">Địa chỉ nhận hàng: <span class="value">{{ $user->address }}</span></h1>
                            </div>
                            
                            <form class="address-form" action="/profile/address/update" method="POST">
                                @method('PUT')
                                @csrf
                                <h3 class="title">
                                    Chỉnh sửa địa chỉ
                                </h3>

                                <label for="province">Tỉnh</label>
                                <select name="province" id="province">
                                </select>

                                <label for="district">Huyện, Quận</label>
                                <select name="district" id="district">
                                </select>

                                <label for="ward">Xã, Phường</label>
                                <select name="ward" id="ward">
                                </select>

                                <button class="submit-btn">Chỉnh sửa</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="order-detail-modal">
        <div class="order-detail">
            <div class="container">
                <span class="close-btn">
                    <i class="fa-solid fa-square-xmark"></i>
                </span>
                <h3 class="order-detail-title">Xem chi tiết đơn hàng</h3>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Các thông tin</th>
                            <th>Giá trị</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ngày đặt hàng</td>
                            <td>2022-02-02 21:21:21</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ</td>
                            <td>Xã Đông Phú, Huyện Châu Thành, Tỉnh Hậu Giang</td>
                        </tr>
                        <tr>
                            <td>Địa chỉ do bạn nhập</td>
                            <td>Cầu cái cui, ấp phú nhơn</td>
                        </tr>
                        <tr>
                            <td>Số điện thoại</td>
                            <td>0389845752</td>
                        </tr>
                        <tr>
                            <td>Tổng giá tiền</td>
                            <td>350.000 VNĐ</td>
                        </tr>
                        <tr>
                            <td>Đã giao lúc</td>
                            <td>Hiện chưa giao đến bạn</td>
                        </tr>
                        <tr>
                            <td>Ghi chú của bạn</td>
                            <td>Lựa cho mình quả ngon nhé shop !</td>
                        </tr>
                        <tr>
                            <td>Trạng thái đơn hàng</td>
                            <td>Đang giao</td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="order-detail-title">Các sản phẩm</h3>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="row product-item">
                            <div class="col-xl-6">
                                <img width="100%" src="/images/products/dautay.webp" alt="Hinh anh san pham" class="product-image">
                            </div>
                            <div class="col-xl-6">
                                <h4 class="name">Dâu tây Đà Lạt</h4>
                                <span class="quantity-text">
                                    Số lượng: 4
                                </span>
                                <h5 class="price">{{ App\Helper::moneyFormat( 350000 ) }} VNĐ / 1</h5>
                                <h5 class="price">Tổng giá: {{ App\Helper::moneyFormat( 1400000 ) }} VNĐ</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="row product-item">
                            <div class="col-xl-6">
                                <img width="100%" src="/images/products/dautay.webp" alt="Hinh anh san pham" class="product-image">
                            </div>
                            <div class="col-xl-6">
                                <h4 class="name">Dâu tây Đà Lạt</h4>
                                <span class="quantity-text">
                                    Số lượng: 4
                                </span>
                                <h5 class="price">{{ App\Helper::moneyFormat( 350000 ) }} VNĐ / 1</h5>
                                <h5 class="price">Tổng giá: {{ App\Helper::moneyFormat( 1400000 ) }} VNĐ</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loader"></div>

    @if (Session::has('verify_success'))
        <x-alert type="success" text="{{Session::get('verify_success')}}" />
    @endif

    @if (Session::has('order_success'))
        <x-alert type="success" text="{{Session::get('order_success')}}" />
    @endif
@endsection

@section('head')
    @vite(['resources/scss/profile.scss', 'resources/scss/components/alert.scss'])
    <link rel="stylesheet" href="/libraries/loading/loading.css">
@endsection

@section('script')
    <script src="/libraries/loading/loading.js"></script>
    <script src="/js/address.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="/js/jquery/orders.js"></script>
@endsection