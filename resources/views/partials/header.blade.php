<div class="container">
    <div class="top">
        <a href="/" class="logo-link">
            <img src="/images/display/app-logo.jpg" alt="Logo Image" class="logo">
        </a>
        
        <div class="search">
            <input type="text" name="search" class="input" placeholder="Tìm kiếm">
            <a class="search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>
        </div>
    
        <div class="actions">
            <div class="accounts">
                @if (Auth::user())
                    <a href="/profile" class="login">Trang cá nhân</a>
                    <span class="separator">|</span>
                    <a href="/logout" class="register">Đăng xuất</a>
                @else
                    <a href="/login" class="login">Đăng nhập</a>
                    <span class="separator">|</span>
                    <a href="/register" class="register">Đăng ký</a>
                @endif
            </div>
            <div class="cart">
                <i class="fa-solid fa-cart-shopping"></i>
                <span data-quantity="{{ count(App\Helper::getProductsInCart()) }}" id="cart-display">Giỏ hàng ({{ count(App\Helper::getProductsInCart()) }})</span>
                
                <div class="modal-cart">
                    <div class="cart-products">
                        @php 
                            $sum = 0;
                        @endphp
                        @foreach (App\Helper::getProductsInCart() as $product)
                            @php 
                                $sum += ($product['price'] - ($product['price'] * $product['discount'])) * $product['quantity'];
                            @endphp
                            <div class="row cart-product-item cart-item{{ $product['id'] }}">
                                <div class="col-xl-3">
                                    <img src="/images/products/{{ $product['thumbnail'] }}" alt="Hinh anh san pham" class="product-image">
                                </div>
                                <div class="col-xl-6">
                                    <h4 class="name">{{ $product['name'] }}</h4>
                                    <h4 class="price price{{ $product['id'] }}" style="display: none" data-unit-price="{{ $product['price'] - ($product['price'] * $product['discount']) }}"></h4>
                                    <h5 class="price final-price{{ $product['id'] }}">{{ App\Helper::moneyFormat( ($product['price'] - ($product['price'] * $product['discount'])) * $product['quantity'] ) }} VNĐ</h5>
                                    <div class="quantity-box">
                                        <a class="decrease-btn quantity-change-btn" onclick="decrease( {{ $product['id'] }} )">
                                            <i class="fa-solid fa-minus"></i>
                                        </a>
                                        <span class="quantity-text quantity{{ $product['id'] }}" data-quantity="{{ $product['quantity'] }}">
                                            {{ $product['quantity'] }}
                                        </span>
                                        <a class="increase-btn quantity-change-btn" onclick="increase( {{ $product['id'] }} )">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <a class="remove-product-btn" title="Xóa sản phẩm khỏi giỏ hàng" onclick="deleteItemOutOfCart({{ $product['id'] }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
    
                    <div class="body">
                        <div class="total">
                            <h4 class="left-heading">
                                Tổng số tiền
                            </h4>
    
                            <h4 class="total-price" data-total-price="{{ $sum }}">
                                {{ App\Helper::moneyFormat($sum) }} VNĐ
                            </h4>
                        </div>
    
    
                        <div class="cart-actions">
                            <div class="row">
                                <div class="col-xl-6">
                                    <a href="/checkout" class="pay-btn action-btn">
                                        Thanh toán
                                    </a>
                                </div>
                                <div class="col-xl-6">
                                    <a href="/cart" class="view-cart-btn action-btn">
                                        Xem giỏ hàng
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

            
        </div>
    </div>

    <div class="bottom">
        <ul class="nav">
            <li class="item">
                <a href="/" class="item-link">
                    Trang chủ
                </a>
            </li>
            <li class="item">
                <a href="/introduce" class="item-link">
                    Giới thiệu
                </a>
            </li>
            <li class="item">
                <span class="item-link">
                    Sản phẩm
                    <i class="fa-sharp fa-solid fa-caret-down"></i>

                    <div class="subnav">
                        <a href="/products" class="subitem">Tất cả sản phẩm</a>
                        @foreach (App\Models\Category::all() as $category)
                            <a href="/products?c={{ $category->slug }}" class="subitem">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </span>
            </li>
            <li class="item">
                <a href="/contact" class="item-link">
                    Liên hệ
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    function myRedirect(link) {
        window.location.href = link;
    }

    // Handle search
    const searchBtn = document.querySelector('.search-btn');
    const saerchInput = document.querySelector('input[name=search]');
    const handleSearch = () => {
        const searchValue = saerchInput.value;
        myRedirect('/search?keyword=' + encodeURI(searchValue));
    }
    searchBtn.onclick = function() {
        handleSearch();
    }
    document.querySelector('input[name=search]').onkeyup = function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            handleSearch();
        }
    }

</script>