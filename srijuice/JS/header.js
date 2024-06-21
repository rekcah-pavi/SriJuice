var div = document.getElementById('header');

div.innerHTML = `
<nav class="navbar">
    <img src="IMG/logo.png" width="40px" >
    <ul>
        <li><a href="index.php"><i class="fa fa-apple-alt"></i> Home</a></li>
        <li><a href="products.php"><i class="fa fa-lemon"></i> Products</a></li>
        <li><a href="account.php"><i class="fa fa-info-circle"></i> Account</a></li>
        <li id="dcc"><a href="cart.php"><i class="fa fa-shopping-cart"></i> Cart</a></li>
    </ul>
    <span class="menu-icon"><i class="fa fa-bars"></i></span>
  </nav>

  <a href="#" id="goTopBtn" title="Go to top"><i class="fa fa-chevron-circle-up"></i></a>


  <div id="customModal" class="modal">
  <div class="modal-content">
      <span class="close">&times;</span>
      <div id="modalMessage"></div>
      <a id="mmmm" href="cart.php"> Go to Carts</a>
  </div>
</div>

  
  

`