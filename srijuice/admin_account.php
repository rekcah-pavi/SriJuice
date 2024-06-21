<?php
session_start();

if(isset($_SESSION['user'])){
	header("Location: account.php");
}


if(!isset($_SESSION['admin'])){
	header("Location: login.php");
} 


 
?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="CSS/main.css">
<link rel="stylesheet" href="CSS/admin_account.css">
<title>Admin account</title>
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
            <h1>Hello Admin</h1>
        </header>

        <nav class="nav">
            <button class="nav-btn" id="ordersBtn"><i class="fas fa-shopping-cart"></i>Orders</button>
            <button class="nav-btn" id="accountsBtn"><i class="fa-solid fa-user"></i>Accounts</button>
            <button class="nav-btn" id="logoutBtn"><i class="fas fa-sign-out-alt"></i>Logout</button>
        </nav>


   
        <div class="content">
            <div class="orders"></div>  
            <div class="accounts" style="display: none;"></div>
        </div>
    </div>
    <script src="JS/admin_account.js"></script>
    </section>
</body>
</html>



<section id="footer">
  <script src="JS/footer.js"></script>
</section>





<script src="JS/main.js"></script>
<script src="JS/admin_account.js"></script>

</body>
</html>

