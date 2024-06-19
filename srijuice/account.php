<?php
session_start();

if (isset($_SESSION['admin'])){
	header("Location: admin_account.php");
    return;
} 


if(!isset($_SESSION['logged_in'])){
	header("Location: login.php");
    return;
} 
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="CSS/main.css">
<link rel="stylesheet" href="CSS/account.css">
<title>Account</title>
<link rel="icon" type="image/x-icon" href="IMG/logo.png">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<section id="header">
    <script src="JS/header.js"></script>
</section>


<section id="account">
    <div class="container">
        <header class="header">
            <h1>Hello <span id="nam"></span></h1>
        </header>
        <nav class="nav">
            <button class="nav-btn" id="ordersBtn"><i class="fas fa-shopping-cart"></i>My Orders</button>
            <button class="nav-btn" id="editAccountBtn"><i class="fas fa-user"></i>Account Details</button>
            <button class="nav-btn" id="addressBtn"><i class="fas fa-home"></i>Address</button>
            <button class="nav-btn" id="logoutBtn"><i class="fas fa-sign-out-alt"></i>Logout</button>
        </nav>
        <div class="content">
            <section class="orders">
            </section>

   

            <section class="edit-account">
                <form action="SYS/update_signuphandler.php" method="post" onsubmit="return validateLogin()">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="uname" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="mail" placeholder="Enter your email" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="pass" placeholder="Enter your password" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Confirm password</label>
                        <input type="password" id="cpassword" name="cpass" placeholder="Re-enter your password" required>
                    </div>

                    <div class="form-group">
                        <button type="submit">Save</button>
                    </div>
                </form>
            </section>
            

            <section class="edit-address">
                <form onsubmit="change_adr(); return false;">
                    <div class="form-group">
                        <label for="province">Province</label>
                        <select id="province" required>
                            <option value="">Select Province</option>
                            <option value="Central">Central</option>
                            <option value="Eastern">Eastern</option>
                            <option value="Northern">Northern</option>
                            <option value="Southern">Southern</option>
                            <option value="Western">Western</option>
                            <option value="North Western">North Western</option>
                            <option value="North Central">North Central</option>
                            <option value="Uva">Uva</option>
                            <option value="Sabaragamuwa">Sabaragamuwa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" id="district" placeholder="Enter your district" required>
                    </div>
                    <div class="form-group">
                        <label for="area">Area</label>
                        <input type="text" id="area" placeholder="Enter your area" required>
                    </div>
                    <div class="form-group">
                        <label for="postalCode">Postal Code</label>
                        <input type="number" id="postalCode" placeholder="Enter your postal code" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="number" id="phone" placeholder="Enter your phone number" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Save</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</section>






<section id="footer">
  <script src="JS/footer.js"></script>
</section>





<script src="JS/main.js"></script>
<script src="JS/account.js"></script>

</body>
</html>
