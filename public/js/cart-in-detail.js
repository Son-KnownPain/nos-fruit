// Sẽ có phụ thuộc vào thư viện messages, loader


function money(price) {
    price = price + '';
    price = [...price].reverse().join("");

    let result = '';

    for (let i = 0; i < price.length; i++) {
        if (i%3 == 0 && i != 0) {
            result += '.';
        }
        result += price[i];
    }

    result = [...result].reverse().join('');

    return result;
}


const decreaseBtn = document.getElementById('minus-btn');
const increaseBtn = document.getElementById('plus-btn');
const quantityDisplayElement = document.getElementById('quantity-display');
const addToCart = document.getElementById('add-btn');

if (parseInt(quantityDisplayElement.dataset.quantity) == 1) {
    decreaseBtn.style.display = 'none';
}

increaseBtn.onclick = e => {
    quantityDisplayElement.textContent = parseInt(quantityDisplayElement.dataset.quantity) + 1;
    quantityDisplayElement.dataset.quantity = parseInt(quantityDisplayElement.dataset.quantity) + 1;
    if (parseInt(quantityDisplayElement.dataset.quantity) > 1) {
        decreaseBtn.style.display = 'inline-block';
    }
}

decreaseBtn.onclick = e => {
    if (parseInt(quantityDisplayElement.dataset.quantity) == 1) {
        return;
    }
    quantityDisplayElement.textContent = parseInt(quantityDisplayElement.dataset.quantity) - 1;
    quantityDisplayElement.dataset.quantity = parseInt(quantityDisplayElement.dataset.quantity) - 1;
    if (parseInt(quantityDisplayElement.dataset.quantity) == 1) {
        decreaseBtn.style.display = 'none';
    }
}

addToCart.onclick = e => {
    myLoader(true);
    const quantity = parseInt(quantityDisplayElement.dataset.quantity);
    fetch('/add-multi-to-cart/' + addToCart.dataset.id + '?q=' + quantity)
        .then(res => res.json())
        .then(response => {
            const totalPriceElements = document.querySelectorAll('.total-price');
            const currentTotalPrice = totalPriceElements[0].dataset.totalPrice;

            const { add, data } = response;
            if (add) {
                const cartItem = document.querySelector('.cart-item' + data.id);
                if (cartItem == null) {
                    toast({
                        title: 'Thêm thành công',
                        type: 'success',
                        message: 'Thêm thành công sản phẩm mới vào giỏ hàng',
                        duration: 3000,
                    });
                    const cartProducts = document.querySelector('.cart-products');
                    const htmlOfCartProducts = cartProducts.innerHTML;
                    const cartDisplay = document.getElementById('cart-display');

                    const newItem = `<div class="row cart-product-item cart-item${data.id}">
                                        <div class="col-xl-3">
                                            <img src="/images/products/${data.thumbnail}" alt="Hinh anh san pham" class="product-image">
                                        </div>
                                        <div class="col-xl-6">
                                            <h4 class="name">${data.name}</h4>
                                            <h4 class="price price${data.id}" style="display: none" data-unit-price="${data.price}"></h4>
                                            <h5 class="price final-price${data.id}">${money(data.price * data.quantity)} VNĐ</h5>
                                            <div class="quantity-box">
                                                <a class="decrease-btn quantity-change-btn" onclick="decrease( ${data.id} )">
                                                    <i class="fa-solid fa-minus"></i>
                                                </a>
                                                <span class="quantity-text quantity${data.id}" data-quantity="${data.quantity}">
                                                    ${data.quantity}
                                                </span>
                                                <a class="increase-btn quantity-change-btn" onclick="increase( ${data.id} )">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <a class="remove-product-btn" title="Xóa sản phẩm khỏi giỏ hàng" onclick="deleteItemOutOfCart(${data.id})">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>`;

                    cartProducts.innerHTML = htmlOfCartProducts + newItem;
                    cartDisplay.dataset.quantity = parseInt(cartDisplay.dataset.quantity) + 1;
                    cartDisplay.textContent = `Giỏ hàng (${cartDisplay.dataset.quantity})`;
                    totalPriceElements.forEach(element => {
                        element.dataset.totalPrice = parseInt(currentTotalPrice) + parseInt(data.price * data.quantity);
                        element.textContent = moneyFormat(parseInt(currentTotalPrice) + parseInt(data.price * data.quantity))  + ' VNĐ';
                    })
                } else {
                    toast({
                        title: 'Thêm thành công',
                        type: 'success',
                        message: 'Sản phẩm đã có sẵn, số lượng đã được tăng lên',
                        duration: 3000,
                    });
                    const cartItem = document.querySelector(`.cart-item${data.id}`);

                    const oldData = {
                        finalPrice: parseInt(document.querySelector(`.price${data.id}`).dataset.unitPrice) * parseInt(document.querySelector(`.quantity${data.id}`).dataset.quantity),
                        quantity: parseInt(document.querySelector(`.quantity${data.id}`).dataset.quantity),
                    }

                    const newContent = `<div class="col-xl-3">
                                            <img src="/images/products/${data.thumbnail}" alt="Hinh anh san pham" class="product-image">
                                        </div>
                                        <div class="col-xl-6">
                                            <h4 class="name">${data.name}</h4>
                                            <h4 class="price price${data.id}" style="display: none" data-unit-price="${data.price}"></h4>
                                            <h5 class="price final-price${data.id}">${money((data.price * data.quantity) + oldData.finalPrice)} VNĐ</h5>
                                            <div class="quantity-box">
                                                <a class="decrease-btn quantity-change-btn" onclick="decrease( ${data.id} )">
                                                    <i class="fa-solid fa-minus"></i>
                                                </a>
                                                <span class="quantity-text quantity${data.id}" data-quantity="${data.quantity + oldData.quantity}">
                                                    ${data.quantity + oldData.quantity}
                                                </span>
                                                <a class="increase-btn quantity-change-btn" onclick="increase( ${data.id} )">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <a class="remove-product-btn" title="Xóa sản phẩm khỏi giỏ hàng" onclick="deleteItemOutOfCart(${data.id})">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>`;

                    cartItem.innerHTML = newContent;
                    totalPriceElements.forEach(element => {
                        element.dataset.totalPrice = parseInt(currentTotalPrice) + parseInt(data.price * data.quantity);
                        element.textContent = moneyFormat(parseInt(currentTotalPrice) + parseInt(data.price * data.quantity))  + ' VNĐ';
                    })
                }
            } else {
                toast({
                    title: 'Thêm thất bại!',
                    type: 'error',
                    message: 'Thêm vào giỏ hàng thất bại, đã xảy ra sự cố ở máy chủ,',
                    duration: 3000,
                });
            }
            myLoader(false);
        });
}