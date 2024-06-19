var div = document.getElementById('footer');

div.innerHTML = `

<footer class="footer">
      <div class="footer-container">
          <div class="footer-row">
              <div class="footer-col">
                  <h4>My Account</h4>
                  <ul>
                      <li><a href="account.php?type=acc">Edit account</a></li>
                      <li><a href="cart.php">View cart</a></li>
                      <li><a href="account.php?type=addr">Edit Address</a></li>
                      <li><a href="account.php">Track Order</a></li>
                  </ul>
              </div>
              <div class="footer-col">
                  <h4>Quick Links</h4>
                  <ul>
                      <li><a href="index.php">About Us</a></li>
                      <li><a href="private_policy.php">Privacy Policy</a></li>
                      <li><a href="products.php">Products</a></li>
                      <li><a href="index.php#contact">Contact</a></li>
                  </ul>
              </div>
              <div class="footer-col">
                  <h4>Follow Us</h4>
                  <div class="social-links">
                      <a href="https://github.com/rekcah-pavi"><i class="fab fa-github"></i></a>
                      <a href="https://rekcah05.t.me"><i class="fab fa-telegram"></i></a>
                  </div>
              </div>
          </div>
          
          <h5 align="center">
            Copyright © 2024 Srijuice - Developed by paviththanan.
          </h5>
      </div>
    </footer>

`