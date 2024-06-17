document.addEventListener('DOMContentLoaded', function () {
    const ordersBtn = document.getElementById('ordersBtn');
    const editAccountBtn = document.getElementById('editAccountBtn');
    const addressBtn = document.getElementById('addressBtn');
    const logoutBtn = document.getElementById('logoutBtn');

    const ordersSection = document.querySelector('.orders');
    const editAccountSection = document.querySelector('.edit-account');
    const editAddressSection = document.querySelector('.edit-address');


    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if (urlParams.get('type') === 'addr') {
        ordersSection.style.display = 'none';
        editAccountSection.style.display = 'none';
        editAddressSection.style.display = 'block';

    } else if (urlParams.get('type') === 'acc') {
        ordersSection.style.display = 'none';
        editAccountSection.style.display = 'block';
        editAddressSection.style.display = 'none';
        
    } else {
        ordersSection.style.display = 'block';
        editAccountSection.style.display = 'none';
        editAddressSection.style.display = 'none';
    }
    
    

    ordersBtn.addEventListener('click', () => {
        ordersSection.style.display = 'block';
        editAccountSection.style.display = 'none';
        editAddressSection.style.display = 'none';
    });

    editAccountBtn.addEventListener('click', () => {
        ordersSection.style.display = 'none';
        editAccountSection.style.display = 'block';
        editAddressSection.style.display = 'none';
    });

    addressBtn.addEventListener('click', () => {
        ordersSection.style.display = 'none';
        editAccountSection.style.display = 'none';
        editAddressSection.style.display = 'block';
    });

    logoutBtn.addEventListener('click', () => {
        window.location.href = 'SYS/logouthandler.php';
    });

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const provinceInput = document.getElementById("province");
    const districtInput = document.getElementById("district");
    const areaInput = document.getElementById("area");
    const postalCodeInput = document.getElementById("postalCode");
    const phoneInput = document.getElementById("phone");

    $.ajax({
        url: 'SYS/details.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            nameInput.value = data.name || '';
            document.getElementById('nam').textContent = ' ' + data.name + '!';
            emailInput.value = data.email || '';

            const addressData = JSON.parse(data.address);
            if (addressData) {
                provinceInput.value = addressData.province || '';
                districtInput.value = addressData.district || '';
                areaInput.value = addressData.area || '';
                postalCodeInput.value = addressData.postalCode || '';
                phoneInput.value = addressData.phone || '';
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });

    $.ajax({
        url: 'SYS/orderhandler.php',
        type: 'GET',
        dataType: 'json',
        success: function(orders) {
            const ordersSection = document.querySelector('.orders');
            if (!Array.isArray(orders)) {
                ordersSection.innerHTML = 'No orders found';
                return;
            }

            ordersSection.innerHTML = '';
            orders.forEach(order => {
                const orderDiv = document.createElement('div');
                orderDiv.className = 'order';
                orderDiv.id = `order-${order.order_id}`;
                orderDiv.innerHTML = `
                    <div><span>Order Id:</span> <a href="#">#${order.order_id}</a></div>
                    <div><span>Status:</span> ${order.status}</div>
                    <div><span>Date:</span> ${order.date}</div>
                    <div><span>Total:</span> ${order.total}RS for ${order.count} items</div>
                    <div class="order-actions"><button class="view-btn" onclick="viewOrder(${order.order_id})">Show Items</button></div>
                `;
                ordersSection.appendChild(orderDiv);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching orders:', error);
        }
    });
});

function viewOrder(orderId) {
    $.ajax({
        url: `SYS/orderhandler.php?id=${orderId}`,
        type: 'GET',
        dataType: 'json',
        success: function(orderDetails) {
            let items = [];
            if (typeof orderDetails.order_details === 'string') {
                items = JSON.parse(orderDetails.order_details);
            } else if (Array.isArray(orderDetails.order_details)) {
                items = orderDetails.order_details;
            }

            const orderDiv = document.querySelector(`#order-${orderId}`);
            const orderDetailsDiv = document.createElement('div');
            orderDetailsDiv.className = 'order-details';
            orderDetailsDiv.innerHTML = `
                <div><span>Items:</span> ${items.length ? items.map(item => `
                    <div>
                        <img src="${item.img_path}" alt="${item.title}">
                        <div>${item.title}</div>
                        <div>${item.quantity} x ${item.price}RS</div>
                    </div>
                `).join('') : 'No items found'}</div>
                <button class="view-btn" onclick="viewLessOrder(${orderId})">Hide Items</button>
            `;
            orderDiv.appendChild(orderDetailsDiv);
            orderDiv.querySelector('.view-btn').style.display = 'none';
        },
        error: function(xhr, status, error) {
            console.error('Error fetching order details:', error);
        }
    });
}

function viewLessOrder(orderId) {
    const orderDiv = document.querySelector(`#order-${orderId}`);
    const orderDetailsDiv = orderDiv.querySelector('.order-details');
    orderDiv.removeChild(orderDetailsDiv);
    orderDiv.querySelector('.view-btn').style.display = 'inline-block';
}

function change_adr() {
    var province = document.getElementById("province").value;
    var district = document.getElementById("district").value;
    var area = document.getElementById("area").value;
    var postalCode = document.getElementById("postalCode").value;
    var phone = document.getElementById("phone").value;

    var data = {
        province: province,
        district: district,
        area: area,
        postalCode: postalCode,
        phone: phone
    };

    $.ajax({
        type: "POST",
        url: "SYS/update_address.php",
        contentType: "application/json",
        data: JSON.stringify(data),
        success: function(response) {
            var parsedResponse = JSON.parse(response);
            console.log(parsedResponse);
            show_message("Address updated successfully");
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed: ", status, error);
        }
    });
}


function validateLogin() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("cpassword").value;

    if (password !== confirmPassword) {
        show_message("Passwords do not match. Please Check!.");
        return false;
    }
    return true;
}