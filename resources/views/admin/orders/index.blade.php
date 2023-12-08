@extends('admin.main')

@section('content')
    <h2 class="heading">
        <i class="fa-solid fa-inbox"></i>
        Orders Management
    </h2>

    <div class="search add">
        <input type="text" name="keyword" placeholder="Nhập mã đơn hàng" class="search-input" tabindex="1">
        <a id="search-btn" class="search-icon-link" tabindex="2">
            <i class="fa-solid fa-magnifying-glass"></i>
        </a>
    </div>

    <div class="orders">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Price</th>
                    <th>Buyer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach (array_reverse($orders) as $order)
                    <tr>
                        <td>{{ $order['orderRecord']['order_date'] }}</td>
                        <td>{{ $order['orderRecord']['address'] }}</td>
                        <td>{{ $order['orderRecord']['phone'] }}</td>
                        <td>{{ App\Helper::moneyFormat($order['totalPrice']) }} VNĐ</td>
                        <td>{{ $order['user']->name }}</td>
                        <td>
                            @switch($order['orderRecord']['status'])
                                @case(1)
                                    <a href="/admin/orders/confirm/{{ $order['orderRecord']['id'] }}" class="actions wait" title="Chờ xác nhận -> Xác nhận đơn hàng">
                                        
                                        <i class="fa-solid fa-clipboard-check"></i>
                                    </a>
                                    @break
                                @case(2)
                                    <a href="/admin/orders/deliveried/{{ $order['orderRecord']['id'] }}" class="actions check" title="Xác nhận đơn hàng -> Đã giao">
                                        <i class="fa-solid fa-square-check"></i>
                                    </a>
                                    @break
                                @case(3)
                                    <a class="actions ship" title="Đã giao đến khách hàng">
                                        <i class="fa-solid fa-truck-fast"></i>
                                    </a>
                                    @break
                                @default
                                    
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if (Session::has('sm'))
        <x-alert type="success" text="{{ Session::get('sm') }}" />
    @endif
@endsection

@section('head')
    @vite(['resources/scss/admin/orders/index.scss', 'resources/scss/components/alert.scss'])
@endsection