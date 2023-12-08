@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="product-info">
            <div class="row">
                <div class="col-xl-6">
                    <div class="image-box">
                        <img src="/images/products/{{ $product->thumbnail }}" alt="Hinh anh san pham" class="product-img">
                    </div>
                </div>
                <div class="col-xl-6">
                    <h3 class="name">{{ $product['name'] }}</h3>
                    <p class="line-attribute">
                        Tình trạng:
                        <span class="value">
                            @if ($product['quantity'] == 0)
                                Hết hàng
                            @else
                                Còn hàng
                            @endif
                        </span>
                    </p>
                    <p class="line-attribute">
                        Mã sản phẩm:
                        <span class="value">
                            S0{{ $product['id'] }}
                        </span>
                    </p>
                    <h3 class="price">
                        {{ $money($product['price'] - ($product['price'] * $product['discount'])).' VNĐ' }}
                        @if ($product->discount != 0)
                            <s class="strikethrough-price">
                                {{ $money($product['price']).' VNĐ' }}
                            </s>
                        @endif
                    </h3>
                    <p class="sumary">
                        {{ $product['summary'] }}
                    </p>
                    <div class="actions">
                        <h4 class="title">Số lượng</h4>
                        <i class="icon fa-solid fa-minus" id="minus-btn"></i>
                        <span class="quantity" data-quantity="1" id="quantity-display">1</span>
                        <i class="icon fa-solid fa-plus" id="plus-btn"></i>
                        <a class="add-cart-btn" id="add-btn" data-id="{{ $product['id'] }}">
                            <i class="fa-solid fa-cart-plus"></i>
                            Thêm vào giỏ hàng
                        </a>
                    </div>
                    {{-- <div class="images-list-box">
                        <div class="row">
                            <div class="col-xl-2">
                                <img src="/images/products/dautay.webp" alt="Hinh anh de chon" class="img-item active">
                            </div>
                            <div class="col-xl-2">
                                <img src="/images/products/dautay.webp" alt="Hinh anh de chon" class="img-item">
                            </div>
                            <div class="col-xl-2">
                                <img src="/images/products/dautay.webp" alt="Hinh anh de chon" class="img-item">
                            </div>
                            <div class="col-xl-2">
                                <img src="/images/products/dautay.webp" alt="Hinh anh de chon" class="img-item">
                            </div>
                            <div class="col-xl-2">
                                <img src="/images/products/dautay.webp" alt="Hinh anh de chon" class="img-item">
                            </div>
                            <div class="col-xl-2">
                                <img src="/images/products/dautay.webp" alt="Hinh anh de chon" class="img-item">
                            </div>
                        </div>
                    </div> --}}
                    <div class="description">
                        <h3 class="title">Mô tả</h3>

                        <div class="text">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="related-products">
            <h2 class="heading">Sản phẩm tương tự</h2>

            <div class="row">
                @if (App\Models\Product::where('category_id', '=', $product->category_id)->where('id', '!=', $product->id)->get()->count() == 0)
                    <div class="col-xl-12">
                        <h4 style="padding: 12px; margin: 0;">Không có sản phẩm tương tự</h4>
                    </div>
                @endif
                @foreach (App\Models\Product::where('category_id', '=', $product->category_id)->where('id', '!=', $product->id)->get() as $product)
                    @if ($loop->index <= 5)
                        <div class="col-xl-2">
                            <x-product 
                                    img="/images/products/{{ $product->thumbnail }}" 
                                    name="{{ $product->name }}"
                                    price="{{ $product->price - ($product->price * $product->discount) }}"
                                    strikethrough-price="{{ $product->price }}"
                                    id="{{ $product->id }}"
                                />
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div id="toast"></div>
    <div id="loader"></div>
@endsection

@section('head')
    @vite(['resources/scss/product_detail.scss', 'resources/scss/components/product.scss'])
    <link rel="stylesheet" href="/libraries/messages/messages.css">
    <link rel="stylesheet" href="/libraries/loading/loading.css">
@endsection

@section('script')
    <script src="/js/cart-in-detail.js"></script>
    <script src="/libraries/messages/messages.js"></script>
    <script src="/libraries/loading/loading.js"></script>
@endsection
