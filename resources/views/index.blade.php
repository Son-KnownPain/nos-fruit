@extends('layouts.main')

@section('content')
	<div class="container">
        <div class="introduce">
            <div class="row">
                <div class="col-xl-8">
                    <img src="images/display/slider_1.webp" alt="" class="slider-img">
                </div>
                <div class="col-xl-4">
                    <img src="images/display/banner_slider.webp" alt="" class="slider-img">
                    <div class="hot-products">
                        <div class="heading">
                            Danh mục hot
                        </div>
                        <ul class="list">
                            @foreach (App\Models\Category::all() as $category)
                                @if ($loop->index <= 6)
                                    <li class="item">
                                        <a href="/products?c={{ $category->slug }}" class="item-link">{{ $category->name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="services">
            <div class="row">
                <div class="col-xl-4">
                    <div class="item">
                        <img src="images/services/service_1.webp" alt="Service 1" class="service-img">
                        <div class="info">
                            <h4 class="heading">
                                Miễn phí vận chuyển
                            </h4>
                            <div class="text">
                                Chúng tôi vận chuyển miễn phí với đơn hàng trị giá trên 1.000.000đ
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="item">
                        <img src="images/services/service_2.webp" alt="Service 1" class="service-img">
                        <div class="info">
                            <h4 class="heading">
                                Hỗ trợ online 24/24
                            </h4>
                            <div class="text">
                                Đội tư vấn của chúng tôi luôn sẵn sàng hỗ trợ khi bạn gặp khó khăn
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="item">
                        <img src="images/services/service_3.webp" alt="Service 1" class="service-img">
                        <div class="info">
                            <h4 class="heading">
                                Quà tặng cuối tuần
                            </h4>
                            <div class="text">
                                Khuyến mại lớn, rinh quà tặng với mỗi thứ 7 và chủ nhật hàng tuần
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="products-box">
            <h3 class="heading">Hot</h3>
            <div class="products">
                <div class="row">
                    @foreach (App\Models\Product::all() as $product)
                        @if ($loop->index <= 5)
                            <div class="col-xl-2">
                                <x-product 
                                    img="{{ asset('images/products/'.$product->thumbnail) }}" 
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

        <div class="products-box">
            <h3 class="heading">Sản phẩm mới nhất</h3>
            <div class="products">
                <div class="row">
                    @foreach (App\Models\Product::all()->reverse() as $product)
                        @if ($loop->index <= 5)
                            <div class="col-xl-2">
                                <x-product 
                                    img="{{ asset('images/products/'.$product->thumbnail) }}" 
                                    name="{{ $product->name }}"
                                    price="{{ $product->price - ($product->price * $product->discount) }}"
                                    strikethrough-price="{{ $product->discount == 0 ? '' : $product->price }}"
                                    id="{{ $product->id }}"
                                />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="brands">
            <h2 class="heading">
                Thương hiệu
            </h2>

            <div class="row">
                <div class="col-xl-2">
                    <div class="item">
                        <img src="images/brands/brand_1.webp" alt="brand img" class="item-img">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="item">
                        <img src="images/brands/brand_2.webp" alt="brand img" class="item-img">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="item">
                        <img src="images/brands/brand_3.webp" alt="brand img" class="item-img">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="item">
                        <img src="images/brands/brand_4.webp" alt="brand img" class="item-img">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="item">
                        <img src="images/brands/brand_5.webp" alt="brand img" class="item-img">
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="item">
                        <img src="images/brands/brand_6.webp" alt="brand img" class="item-img">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('head')
    @vite(['resources/scss/index.scss', 'resources/scss/components/product.scss'])
@endsection