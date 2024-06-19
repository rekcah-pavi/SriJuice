<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Summary</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="CSS/main.css">
    <link rel="stylesheet" href="CSS/cart.css">
    <title>cart</title>
<link rel="icon" type="image/x-icon" href="IMG/logo.png">
</head>
<body>

<section id="header">
    <script src="JS/header.js"></script>
</section>

    <section id="card">

    <div class="cart-summary">
        <div id="cart-items"></div>
        
        <div class="summary">
            <div class="total">
                <h2>Total</h2>
                <h2 id="total-amount">Rs. 0.00</h2>
            </div>
        </div>
    </div>

    <section id="payment">
        <div class="container">
            <div class="shipping">
                <h2>Shipping address</h2>
                <table id="shipping-address-table">
                    <tr>
                        <td>Name</td>
                        <td id="address-name">N/A</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td id="address-phone">N/A</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td id="address-details">N/A</td>
                    </tr>
                    <tr>
                        <td>Postal Code</td>
                        <td id="address-postal">N/A</td>
                    </tr>
                </table>
                <button id="edit-address-btn" class="checkout">Edit Address</button>
            </div>
            <div class="payment-summary">
                <h2>Total Payment</h2>
                <table>
                    <tr>
                        <td>Discount</td>
                        <td id="payment-subtotal">Rs. 0</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td>Free</td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td>Rs. 0</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td id="payment-total"><strong>Rs. 0</strong></td>
                    </tr>
                </table>
                <button id="checkoutBtn" class="checkout" onclick="place_order()">Pay now</button>
                <div class="payment-icons">
                    <i class="fab fa-cc-paypal" style="font-size: 80px;"></i>
                    <i class="fab fa-cc-mastercard" style="font-size: 80px;"></i>
                </div>
            </div>
        </div>
    </section>

</section>

    <section id="footer">
        <script src="JS/footer.js"></script>
    </section>

    <script src="JS/main.js"></script>
    <script src="JS/cart.js"></script>
</body>
</html>
