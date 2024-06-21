<?php
session_start();
?>




<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="CSS/main.css">
<link rel="stylesheet" href="CSS/index.css">
<title>Srijuice</title>
<link rel="icon" type="image/x-icon" href="IMG/logo.png">
</head>
<body>

<section id="header">
    <script src="JS/header.js"></script>
</section>


<section id="sec2">
<div class="cc">
<div class="container">
  <div class="content">
      <h1>Fresh Pressed Goodness Since 2020</h1>
      <p>Discover a vibrant oasis of fresh, locally sourced juices that nourish your body and delight your taste buds. At Fruity Delights, we're passionate about crafting innovative flavor combinations that capture the essence of nature's finest fruits and vegetables.</p>
  </div>
  <div class="image-container">
      <img src="IMG/img.png" width="90%" alt="Juices">
  </div>
</div>
</div>
</section>


<section id="products">
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
            <input type="text" id="editProductPrice" name="price" required>
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<script src="JS/index_products.js"></script>
</section>





<section id="contact">
<div class="container">
  <div class="contact-form">
      <h2>Contact Us</h2>
      <form>
          <input type="text" name="name" placeholder="Name" required>
          <input type="email" name="email" placeholder="Email" required>
          <textarea name="message" placeholder="Message" required></textarea>
          <button type="submit">Submit</button>
      </form>
  </div>
  <div class="image-container">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31465.03767266671!2d80.0078269862749!3d9.669956936812778!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe53fd7be66aa5%3A0xc7da0d9203baf512!2sJaffna!5e0!3m2!1sen!2slk!4v1716041100258!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</div>
</section>



<section id="footer">
  <script src="JS/footer.js"></script>
</section>





<script src="JS/main.js"></script>
<script src="JS/index.js"></script>

</body>
</html>
