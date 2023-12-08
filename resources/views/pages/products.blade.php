@extends('layouts.main')

@section('content')
    <div class="container">
        @if ($searching ?? false)
            <div class="search-info">
                <h3 class="search-text">
                    Kết quả tìm kiếm cho: 
                    <span class="keyword">{{ $searching }}</span>
                </h3>
            </div>
        @endif
        <div class="row">
            <div class="col-xl-3">
                <div class="filter-sidebar">
                    <h3 class="heading">
                        <i class="fa-solid fa-filter"></i>
                        Bộ lọc
                    </h3>
                    <div class="price-filter">
                        <h4 class="title">Mức giá</h4>
                        <label for="price-from" class="filter-label">Từ</label>
                        <select class="price-options" name="priceFrom" id="price-from">
                            <option value="0">0đ</option>
                            <option value="100000">100.000đ</option>
                            <option value="200000">200.000đ</option>
                            <option value="500000">500.000đ</option>
                            <option value="1000000">1.000.000đ</option>
                        </select>
                        <label for="price-to" class="filter-label">Tới</label>
                        <select class="price-options" name="priceTo" id="price-to">
                            <option value="100000">100.000đ</option>
                            <option value="200000">200.000đ</option>
                            <option value="500000">500.000đ</option>
                            <option value="1000000">1.000.000đ</option>
                            <option value="0">Trên 1 triệu</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="products-box">
                    <div class="heading">
                        <h3 class="heading-text">
                            <i class="fa-solid fa-list"></i>
                            Sản phẩm
                        </h3>
                    </div>

                    <div class="products-display">
                        <div class="row">
                            @foreach ($products as $product)
                                @if ($loop->index < 12)
                                    <div class="col-xl-3">
                                        <x-product 
                                            img="images/products/{{ $product->thumbnail }}" 
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
            </div>
        </div>
    </div>
@endsection

@section('head')
    @vite(['resources/scss/products.scss', 'resources/scss/components/product.scss'])
@endsection