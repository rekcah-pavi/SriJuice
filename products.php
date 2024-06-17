<?php
session_start();



if (isset($_SESSION['admin'])){
  if (! isset($_GET['user'])) {
      header("Location: ?user=admin");
      exit();
  }

}
else{
  if (isset($_GET['user'])) {
    header("Location: products.php");
    exit();
}

}


?>



<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="CSS/main.css">
<link rel="stylesheet" href="CSS/index.css">
<title>Products</title>
<link rel="icon" type="image/x-icon" href="IMG/logo.png">
</head>
<body>

<section id="header">
    <script src="JS/header.js"></script>
</section>





<section id="products">
<div id="search-container">
    <input type="text" id="product-search" placeholder="Search for products...">
</div>


    <div id="add-product-section">
        <div class="row"></div>
    </div>
    <div class="items" id="product-container">
    </div>

 
  <div id="editProductModal" class="mmodal">
    <div class="mmodal-content">
        <span class="bclose">&times;</span>
        <h2>Edit Product</h2>
        <form id="editProductForm">
            <input type="hidden" id="editOriginalName" name="original_name">
            <label for="editProductType">Type:</label>
            <input type="text" id="editProductType" name="type" required>
            <label for="editProductImage">Image URL:</label>
            <input type="text" id="editProductImage" name="img_path" required>
            <label for="editProductName">Name:</label>
            <input type="text" id="editProductName" name="name" required>
            <label for="editProductPrice">Price:</label>
            <input type="number" id="editProductPrice" name="price" required>
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<div id="addProductModal" class="mmodal">
    <div class="mmodal-content">
        <span class="bclose">&times;</span>
        <h2>Add Product</h2>
        <form id="addProductForm">
            <label for="addProductType">Type:</label>
            <input type="text" id="addProductType" name="type" required>
            <label for="addProductImage">Image URL:</label>
            <input type="text" id="addProductImage" name="img_path" required>
            <label for="addProductName">Name:</label>
            <input type="text" id="addProductName" name="name" required>
            <label for="addProductPrice">Price:</label>
            <input type="number" id="addProductPrice" name="price" required>
            <button type="submit">Save</button>
        </form>
    </div>
</div>



<script src="JS/load_products.js"></script>
</section>

 

<section id="footer">
  <script src="JS/footer.js"></script>
</section>



<script src="JS/main.js"></script>


</body>
</html>
