<div class="component-product">
    <div class="img-box">
        <img src="{{ $img }}" alt="Hinh anh san pham" class="img">
    </div>
    <div class="info">
        <h5 class="name">
            <a href="/product-detail/{{ $id }}" class="link" title="Xem thông tin chi tiết">{{ $name }}</a>
        </h5>
        <h5 class="price">
            <s class="price-strikethrough">
                {{ $money($strikethroughPrice) }}
            </s>
            {{ $money($price).' VNĐ' }}
        </h5>
    </div>

    <div class="actions">
        <a href="/add-to-cart/{{ $id }}" class="add-cart-btn" title="Thêm sản phẩm vào giỏ hàng">
            <i class="fa-solid fa-cart-plus"></i>
        </a>
    </div>
</div>