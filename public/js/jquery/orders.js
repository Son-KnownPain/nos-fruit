$(document).ready(() => {

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

    // Khi click vào tr thì hiện modal
    $(".order-tr").click(function() {
        myLoader();
        $.get("/profile/order-detail/" + $(this).data('id'), (data, status) => {
            myLoader(false);

            if (status === "success" && data.order != null) {
                const {orderRecord, totalPrice, orderDetailRecords, user} = data.order;

                let orderStatusText = '';

                switch(orderRecord.status) {
                    case 0:
                        orderStatusText = 'Đã bị hủy bỏ bởi shop'
                        break;
                    case 1:
                        orderStatusText = 'Chờ xác nhận'
                        break;
                    case 2:
                        orderStatusText = 'Hiện đang giao đến bạn'
                        break;
                    case 3:
                        orderStatusText = 'Đã giao'
                        break;
                    default:
                }

                const productsHtml = orderDetailRecords.map(item => {
                    return `<div class="col-xl-6">
                                <div class="row product-item">
                                    <div class="col-xl-6">
                                        <img width="100%" src="/images/products/${item.thumbnail}" alt="Hinh anh san pham" class="product-image">
                                    </div>
                                    <div class="col-xl-6">
                                        <h4 class="name">${item.product_name}</h4>
                                        <span class="quantity-text">
                                            Số lượng: ${item.quantity}
                                        </span>
                                        <h5 class="price">Đơn giá: ${moneyFormat(item.unit_price - (item.unit_price * item.discount))} VNĐ</h5>
                                        <h5 class="price">Tổng giá: ${ moneyFormat((item.unit_price - (item.unit_price * item.discount)) * item.quantity) } VNĐ</h5>
                                    </div>
                                </div>
                            </div>`;
                }).join('');

                $("#order-detail-modal").html(`
                    <div class="order-detail">
                        <div class="container">
                            <span class="close-btn">
                                <i class="fa-solid fa-square-xmark"></i>
                            </span>
                            <h3 class="order-detail-title">Xem chi tiết đơn hàng</h3>
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>Các thông tin</th>
                                        <th>Giá trị</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Ngày đặt hàng</td>
                                        <td>${ orderRecord.order_date }</td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ</td>
                                        <td>${ orderRecord.address }</td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ do bạn nhập</td>
                                        <td>${ orderRecord.entered_address || '<i class="fa-solid fa-head-side-cough-slash"></i> Trống' }</td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại</td>
                                        <td>${ orderRecord.phone }</td>
                                    </tr>
                                    <tr>
                                        <td>Tổng giá tiền</td>
                                        <td>${moneyFormat( totalPrice )} VNĐ</td>
                                    </tr>
                                    <tr>
                                        <td>Đã giao lúc</td>
                                        <td>${ orderRecord.status == 3 ? (orderRecord.delivery_date ?? 'Chưa cập nhật') : 'Hiện chưa giao đến bạn' }</td>
                                    </tr>
                                    <tr>
                                        <td>Ghi chú của bạn</td>
                                        <td>${ orderRecord.note || '<i class="fa-solid fa-head-side-cough-slash"></i> Trống' }</td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái đơn hàng</td>
                                        <td>${ orderStatusText }</td>
                                    </tr>
                                </tbody>
                            </table>
            
                            <h3 class="order-detail-title">Các sản phẩm</h3>
            
                            <div class="row">
                                ${productsHtml}
                            </div>
                        </div>
                    </div>
                `);

                $("#order-detail-modal").addClass("active");
                // Đóng modal
                $(".close-btn").click(() => {
                    $("#order-detail-modal").removeClass("active");
                });
            }

        });
    });

    
});
