<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login/signup</title>
  <link rel="icon" type="image/x-icon" href="IMG/logo.png">
  <link rel="stylesheet" href="CSS/main.css">
  <link rel="stylesheet" href="CSS/login.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .password-container {
      position: relative;
    }
    .password-container input {
      width: calc(100% - 30px);
    }
    .password-container .fa-eye, .password-container .fa-eye-slash {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }
  </style>
</head>
<body>

<section id="header">
    <script src="JS/header.js"></script>
</section>

<section id="login">
  <div class="container">
    <div class="forms-container">
      <div class="form-control signup-form">
        <form action="SYS/signuphandler.php" method="post" onsubmit="return validateLogin()">
          <h2>Signup</h2>
          <input type="text" name="uname" placeholder="Name" required />
          <input type="email" name="mail" placeholder="Email" required />
          <div class="password-container">
            <input type="password" id="password" name="pass" placeholder="Password" required />
            <i class="fa fa-eye" id="togglePassword"></i>
          </div>
          <div class="password-container">
            <input type="password" id="cpassword" name="cpass" placeholder="Confirm password" required />
            <i class="fa fa-eye" id="toggleCPassword"></i>
          </div>
          <button>Signup</button>
        </form>
      </div>
      <div class="form-control signin-form">
        <form action="SYS/loginhandler.php" method="post">
          <h2>Signin</h2>
          <input id="mmaaii" type="email" placeholder="Email" name="mail" required />
          <div class="password-container">
            <input id="pmmaaii" type="password" placeholder="Password" name="pass" required />
            <i class="fa fa-eye" id="toggleSigninPassword"></i>
          </div>
          <button>Signin</button>
          <p><a href="javascript:void(0)" onclick="forgetpass(document.querySelector('input[id=mmaaii]').value)">Forget password?</a></p>
        </form>
      </div>
    </div>
    <div class="intros-container">
      <div class="intro-control signin-intro">
        <div class="intro-control__inner">
          <h2>Welcome back!</h2>
          <p>
            Welcome back to our store! We're delighted to see you return.
          </p>
          <button id="signup-btn">No account yet? Signup.</button>
        </div>
      </div>
      <div class="intro-control signup-intro">
        <div class="intro-control__inner">
          <h2>Come join us!</h2>
          <p>
            We're thrilled to welcome you here! If you haven't done so already, sign up now to unlock exclusive offers, rewards, and discounts.
          </p>
          <button id="signin-btn">Already have an account? Signin.</button>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="footer">
    <script src="JS/footer.js"></script>
</section>

<script src="JS/main.js"></script>
<script src="JS/login.js"></script>
</body>
</html>
