// File này để sử dụng ajax tăng giảm số lượng sản phẩm

// Hàm format tiền
function moneyFormat(price) {
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

function increase(id) {
    const quantityElements = document.querySelectorAll('.quantity' + id);
    const priceElements = document.querySelectorAll('.price' + id);
    const finalPrices = document.querySelectorAll('.final-price' + id);
    const totalPriceElements = document.querySelectorAll('.total-price');
    const currentQuantity = quantityElements[0].dataset.quantity;

    fetch('/cart/increase/' + id)
        .then(res => res.json())
        .then(data => {
            if (data.change) {
                quantityElements.forEach(element => {
                    element.textContent = parseInt(currentQuantity) + 1;
                    element.dataset.quantity = parseInt(currentQuantity) + 1;
                });
            
                const unitPrice = priceElements[0].dataset.unitPrice;
            
                finalPrices.forEach(element => {
                    element.textContent = moneyFormat(parseInt(unitPrice) * (parseInt(currentQuantity) + 1)) + ' VNĐ';
                });

                const currentTotalPrice = totalPriceElements[0].dataset.totalPrice;

                totalPriceElements.forEach(element => {
                    element.dataset.totalPrice = parseInt(currentTotalPrice) + parseInt(unitPrice);
                    element.textContent = moneyFormat(parseInt(currentTotalPrice) + parseInt(unitPrice))  + ' VNĐ';
                })
            } else {
                // Code when fail
            }
        });
}

function decrease(id) {
    const quantityElements = document.querySelectorAll('.quantity' + id);
    const priceElements = document.querySelectorAll('.price' + id);
    const finalPrices = document.querySelectorAll('.final-price' + id);
    const totalPriceElements = document.querySelectorAll('.total-price');

    const currentQuantity = quantityElements[0].dataset.quantity;

    fetch('/cart/decrease/' + id)
        .then(res => res.json())
        .then(data => {
            if (data.change) {
                quantityElements.forEach(element => {
                    element.textContent = parseInt(currentQuantity) - 1;
                    element.dataset.quantity = parseInt(currentQuantity) - 1;
                });
            
                const unitPrice = priceElements[0].dataset.unitPrice;
            
                finalPrices.forEach(element => {
                    element.textContent = moneyFormat(parseInt(unitPrice) * (parseInt(currentQuantity) - 1)) + ' VNĐ';
                });

                const currentTotalPrice = totalPriceElements[0].dataset.totalPrice;

                totalPriceElements.forEach(element => {
                    element.dataset.totalPrice = parseInt(currentTotalPrice) - parseInt(unitPrice);
                    element.textContent = moneyFormat(parseInt(currentTotalPrice) - parseInt(unitPrice)) + ' VNĐ';
                })
            } else {
                // Code when fail
            }
        });
}

function deleteItemOutOfCart(id) {
    const quantityElements = document.querySelectorAll('.quantity' + id);
    const priceElements = document.querySelectorAll('.price' + id);
    const totalPriceElements = document.querySelectorAll('.total-price');
    const cartItems = document.querySelectorAll('.cart-item' + id);
    const cartQuantity = document.getElementById('cart-display');

    fetch('/cart/delete/' + id)
        .then(res => res.json())
        .then(data => {
            if (data.change) {
                const currentQuantity = quantityElements[0].dataset.quantity;
                const unitPrice = priceElements[0].dataset.unitPrice;
                const currentTotalPrice = totalPriceElements[0].dataset.totalPrice;

                totalPriceElements.forEach(element => {
                    element.dataset.totalPrice = parseInt(currentTotalPrice) - (parseInt(unitPrice) * currentQuantity);
                    element.textContent = moneyFormat(parseInt(currentTotalPrice) - (parseInt(unitPrice) * currentQuantity)) + ' VNĐ';
                })

                cartItems.forEach(item => {
                    item.remove()
                });

                cartQuantity.textContent = 'Giỏ hàng (' + (parseInt(cartQuantity.dataset.quantity) - 1) + ')';
                cartQuantity.dataset.quantity = parseInt(cartQuantity.dataset.quantity) - 1;
            } else {
                // Code when fail
            }
        });
}