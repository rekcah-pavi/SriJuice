var subtotal = 0;

function getCookie(name) {
    let cookieArr = document.cookie.split(';');
    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split('=');
        if (name === cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null;
}

function saveCards(cards) {
    document.cookie = `cards=${encodeURIComponent(JSON.stringify(cards))}; path=/; max-age=${30 * 24 * 60 * 60}`;
}

function loadCartItems() {
    let cartItemsContainer = document.getElementById('cart-items');
    cartItemsContainer.innerHTML = ''; 
    let cartItems = JSON.parse(getCookie('cards')) || [];

    subtotal = 0;

    cartItems.forEach((item, index) => {
        let itemElement = document.createElement('div');
        itemElement.className = 'cart-item';
        itemElement.dataset.index = index;
        itemElement.innerHTML = `
            <img src="${item.img_path}" alt="${item.title}">
            <div class="item-details">
                <h2>${item.title}</h2>
                <p>${item.title}</p>
            </div>
            <div class="item-quantity">
                <button class="quantity-button decrement"><i class="fas fa-minus"></i></button>
                <input type="text" value="${item.quantity}" readonly>
                <button class="quantity-button increment"><i class="fas fa-plus"></i></button>
            </div>
            <div class="item-price">Rs. ${parseFloat(item.price * item.quantity).toFixed(2)}</div>
            <button class="remove-item"><i class="fas fa-trash"></i></button>
        `;
        cartItemsContainer.appendChild(itemElement);
        subtotal += parseFloat(item.price) * item.quantity;
    });

    updateTotals(subtotal);
}

function updateTotals(subtotal) {
    document.getElementById('total-amount').innerText = `Rs. ${subtotal.toFixed(2)}`;
    document.getElementById('payment-total').innerText = `Rs. ${subtotal.toFixed(2)}`;
}

function updateCartItem(index, quantity) {
    let cartItems = JSON.parse(getCookie('cards')) || [];
    if (index >= 0 && index < cartItems.length) {
        cartItems[index].quantity = quantity;
        saveCards(cartItems);
        loadCartItems();
    }
}

function removeCartItem(index) {
    let cartItems = JSON.parse(getCookie('cards')) || [];
    if (index >= 0 && index < cartItems.length) {
        cartItems.splice(index, 1);
        saveCards(cartItems);
        loadCartItems();
    }
}

document.getElementById('cart-items').addEventListener('click', function(e) {
    if (e.target.classList.contains('increment') || e.target.closest('.increment')) {
        let itemElement = e.target.closest('.cart-item');
        let index = parseInt(itemElement.dataset.index);
        let quantityInput = itemElement.querySelector('.item-quantity input');
        let newQuantity = parseInt(quantityInput.value) + 1;
        updateCartItem(index, newQuantity);
    }

    if (e.target.classList.contains('decrement') || e.target.closest('.decrement')) {
        let itemElement = e.target.closest('.cart-item');
        let index = parseInt(itemElement.dataset.index);
        let quantityInput = itemElement.querySelector('.item-quantity input');
        let newQuantity = parseInt(quantityInput.value) - 1;
        if (newQuantity > 0) {
            updateCartItem(index, newQuantity);
        }
    }

    if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
        let itemElement = e.target.closest('.cart-item');
        let index = parseInt(itemElement.dataset.index);
        removeCartItem(index);
    }
});

function fetchShippingAddress() {
    fetch('SYS/details.php')
        .then(response => response.json())
        .then(data => {
            if(!data.name){
                return;
            }
            let address = JSON.parse(data.address);
            document.getElementById('address-name').innerText = data.name;
            document.getElementById('address-phone').innerText = address.phone;
            document.getElementById('address-details').innerText = `${address.area}, ${address.district}, ${address.province}`;
            document.getElementById('address-postal').innerText = address.postalCode;
        })
        .catch(error => console.error('Error fetching shipping address:', error));
}

document.getElementById('edit-address-btn').addEventListener('click', function() {
    window.location.href = 'account.php?type=addr';
});

loadCartItems();
fetchShippingAddress();

function place_order() {
    if (document.getElementById('address-details').innerText == "N/A") {
        show_message("You must add address first!");
        return;
    }
    if (subtotal == 0) {
        show_message("At least add one item!");
        return;
    }

    let cartItems = JSON.parse(getCookie('cards')) || [];
    let orderDetails = cartItems.map(item => ({
        title: item.title,
        img_path: item.img_path,
        price: item.price,
        quantity: item.quantity
    }));

    let data = {
        orderDetails: JSON.stringify(orderDetails), 
        total: subtotal.toFixed(2),
        count: cartItems.length,
    };

    $.ajax({
        type: "POST",
        url: "SYS/orderhandler.php",
        data: data,
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            show_message(jsonResponse.message, "account.php", "Go to orders");
            document.cookie = 'cards=; Path=/; Expires=Thu, 01 Jan 2000 00:00:01 GMT;';
            loadCartItems();
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}
