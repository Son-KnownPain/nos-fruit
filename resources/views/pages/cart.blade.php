@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="page-heading">Giỏ hàng</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">HÌnh ảnh</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Đơn giá</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Thành tiền</th>
                    <th scope="col">Xóa</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sum = 0;
                @endphp
                @foreach (App\Helper::getProductsInCart() as $product)
                    @php
                        $sum += ($product['price'] - ($product['price'] * $product['discount'])) * $product['quantity'];
                    @endphp
                    <tr class="cart-item{{ $product['id'] }}">
                        <td scope="col">
                            <img src="/images/products/{{ $product['thumbnail'] }}" alt="Hinh anh san pham" class="product-img">
                        </td>
                        <td scope="col">
                            {{ $product['name'] }}
                        </td>
                        <td scope="col" class="price price{{ $product['id'] }}" data-unit-price="{{ $product['price'] - ($product['price'] * $product['discount']) }}">
                            {{ App\Helper::moneyFormat($product['price'] - ($product['price'] * $product['discount'])) }} VNĐ
                        </td>
                        <td scope="col">
                            <i class="fa-solid fa-minus icon" onclick="decrease( {{ $product['id'] }} )"></i>
                            <span class="quantity{{ $product['id'] }}" data-quantity="{{ $product['quantity'] }}">{{ $product['quantity'] }}</span>
                            <i class="fa-solid fa-plus icon" onclick="increase( {{ $product['id'] }} )"></i>
                        </td>
                        <td scope="col" class="price final-price{{ $product['id'] }}">
                            {{ App\Helper::moneyFormat(($product['price'] - ($product['price'] * $product['discount'])) * $product['quantity']) }} VNĐ
                        </td>
                        <td scope="col">
                            <span class="remove-btn" onclick="deleteItemOutOfCart({{ $product['id'] }})">
                                <i class="fa-solid fa-trash"></i>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="payment">
            <h3 class="price-to-pay">
                Thành tiền: <span class="price-value total-price" data-total-price="{{ $sum }}">{{ App\Helper::moneyFormat($sum) }} VNĐ</span>
            </h3>
            <div class="actions">
                <a href="/products" class="action-btn">
                    Tiếp tục mua sắm
                </a>
                <a href="/checkout" class="action-btn">
                    Đặt hàng
                </a>
            </div>
        </div>
    </div>
@endsection

@section('head')
    @vite(['resources/scss/cart.scss'])
@endsection
