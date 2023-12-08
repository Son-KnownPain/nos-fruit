@extends('admin.main')

@section('content')
    <h2 class="heading">
        <i class="fa-solid fa-boxes-stacked"></i>
        Product Management
    </h2>
    <div class="search add">
        <input type="text" name="keyword" placeholder="Nhập tên sản phẩm" class="search-input" tabindex="1">
        <a id="search-btn" class="search-icon-link" tabindex="2">
            <i class="fa-solid fa-magnifying-glass"></i>
        </a>

        <select name="category_id" class="filter-level">
            <option value="0">Tất cả danh mục</option>
            @foreach ($categories as $category)
                <option value="{{$category->id}}" {{ Request::query('cid', 0) ==  $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
            @endforeach
        </select>

        <select name="status" class="filter-level">
            <option value="all" {{ Request::query('status', '') ==  "all" ? 'selected' : ''}}>Tất cả</option>
            <option value="yes" {{ Request::query('status', '') ==  "yes" ? 'selected' : ''}}>Còn hàng</option>
            <option value="no" {{ Request::query('status', '') ==  "no" ? 'selected' : ''}}>Hết hàng</option>
        </select>

        <a href="/admin/products/add" class="other-btn">Thêm sản phẩm mới</a>
    </div>

    <div class="products">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <img width="100px" src="{{asset('images/products/'.$product->thumbnail)}}" alt="Hình ảnh sản phẩm">
                        </td>
                        <td>{{$product->name}}</td>
                        <td>
                            <s style="font-size: 1.3rem; color: #888;">
                                <?php
                                    $price = (string) $product->price;
                                    $price = strrev($price);

                                    $result = '';

                                    for ($i=0; $i < strlen($price); $i++) { 
                                        if ($i % 3 == 0 && $i != 0) {
                                            $result .= '.';
                                        }

                                        $result .= $price[$i];
                                    }

                                    $result = strrev($result);

                                    echo $result;
                                ?>
                            </s>
                            |
                            <span>
                                <?php
                                    $price = (string) $product->price - ($product->price * $product->discount);
                                    $price = strrev($price);

                                    $result = '';

                                    for ($i=0; $i < strlen($price); $i++) { 
                                        if ($i % 3 == 0 && $i != 0) {
                                            $result .= '.';
                                        }

                                        $result .= $price[$i];
                                    }

                                    $result = strrev($result);

                                    echo $result.' VNĐ';
                                ?>
                            </span>
                        </td>
                        <td>{{$product->discount * 100}}%</td>
                        <td>{{$product->quantity}}</td>
                        <td>
                            <a href="/admin/products/edit/{{ $product->id }}" class="edit-link">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="" class="remove">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function handleSeach() {
            const searchKeyword = document.querySelector('input[name=keyword]').value;
            const category_id = document.querySelector('select[name=category_id]').value;
            const status = document.querySelector('select[name=status]').value;
            location.href = '/admin/products?search=' + searchKeyword + '&status=' + status + '&cid=' + category_id;
        }
        document.getElementById('search-btn').onclick = e => {
            handleSeach();
        }

        document.getElementById('search-btn').onkeypress = e => {
            handleSeach();
        }
    </script>

    @if (Session::has('update'))
        <x-alert type="success" text="{{ Session::get('update') }}" />
    @endif
    @if (Session::has('create'))
        <x-alert type="success" text="{{ Session::get('create') }}" />
    @endif
@endsection

@section('head')
    @vite(['resources/scss/admin/products/index.scss', 'resources/scss/components/alert.scss'])
@endsection