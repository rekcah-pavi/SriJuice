
    var ordersBtn2 = document.getElementById('ordersBtn');
    var logoutBtn2 = document.getElementById('logoutBtn');
    var ordersSection2 = document.querySelector('.orders');


    ordersBtn2.addEventListener('click', () => {
        ordersSection2.style.display = 'block';
        fetchOrders();
    });

    logoutBtn2.addEventListener('click', () => {
        window.location.href = 'SYS/logouthandler.php';
    });

    window.fetchOrders = function () {
        $.ajax({
            url: 'SYS/admin_orderhandler.php',
            method: 'GET',
            dataType: 'json',
            success: function(orders) {
                if (!Array.isArray(orders)) {
                    ordersSection2.innerHTML = 'No orders found';
                    return;
                }

                ordersSection2.innerHTML = '';
                orders.forEach(order => {
                    const orderDiv = document.createElement('div');
                    orderDiv.className = 'order';
                    orderDiv.id = `order-${order.order_id}`;
                    orderDiv.innerHTML = `
                        <div><span>Order Id:</span> <a href="#">#${order.order_id}</a></div>
                        <div><span>Email:</span> ${order.email}</div>
                        <div><span>Status:</span>
                            <select class="status-dropdown" data-order-id="${order.order_id}">
                                <option value="Pending" ${order.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                <option value="Shipped" ${order.status === 'Shipped' ? 'selected' : ''}>Shipped</option>
                                <option value="Completed" ${order.status === 'Completed' ? 'selected' : ''}>Completed</option>
                            </select>
                            <button class="save-status-btn" onclick="saveOrderStatus(${order.order_id})">Save</button>
                        </div>
                        <div><span>Date:</span> ${order.date}</div>
                        <div><span>Total:</span> ${order.total}RS for ${order.count} items</div>
                        <div class="order-actions">
                            <button class="view-btn" onclick="viewOrder(${order.order_id})">Show Items</button>
                            <button class="delete-btn" onclick="deleteOrder(${order.order_id})">Delete Order</button>
                        </div>
                    `;
                    ordersSection2.appendChild(orderDiv);
                });
            },
            error: function(error) {
                console.error('Error fetching orders:', error);
            }
        });
    }

    window.viewOrder = function (orderId) {
        $.ajax({
            url: `SYS/admin_orderhandler.php?id=${orderId}`,
            method: 'GET',
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
            error: function(error) {
                console.error('Error fetching order details:', error);
            }
        });
    }

    window.viewLessOrder = function (orderId) {
        const orderDiv = document.querySelector(`#order-${orderId}`);
        const orderDetailsDiv = orderDiv.querySelector('.order-details');
        orderDiv.removeChild(orderDetailsDiv);
        orderDiv.querySelector('.view-btn').style.display = 'inline-block';
    }

    window.saveOrderStatus = function(orderId) {
        const selectElement = document.querySelector(`.status-dropdown[data-order-id="${orderId}"]`);
        const newStatus = selectElement.value;

        $.ajax({
            url: `SYS/admin_orderhandler.php`,
            method: 'PUT',
            data: { id: orderId, status: newStatus },
            success: function(response) {
                var parsedResponse = JSON.parse(response);
                show_message(parsedResponse.message);
                fetchOrders(); 
            },
            error: function(error) {
                console.error('Error updating order status:', error);
            }
        });
    }

    window.deleteOrder = function(orderId) {
        if (confirm("Are you sure you want to delete this order?")) {
            $.ajax({
                url: `SYS/admin_orderhandler.php`,
                method: 'DELETE',
                data: { id: orderId },
                success: function(response) {
                    var parsedResponse = JSON.parse(response);
                    show_message(parsedResponse.message);
                    fetchOrders(); 
                },
                error: function(error) {
                    console.error('Error deleting order:', error);
                }
            });
        }
    }

ordersSection2.style.display = 'block';
fetchOrders();
