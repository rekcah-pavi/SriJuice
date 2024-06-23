const signupBtn = document.getElementById("signup-btn");
const signinBtn = document.getElementById("signin-btn");
const mainContainer = document.querySelector(".container");

signupBtn.addEventListener("click", () => {
  mainContainer.classList.toggle("change");
});
signinBtn.addEventListener("click", () => {
  mainContainer.classList.toggle("change");
});


function validateLogin() {
  showLoading();
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("cpassword").value;

  if (password !== confirmPassword) {
      show_message("Passwords do not match. Please check!");
      return false;
  }
  return true;
}


function forgetpass(email) {
  if (email === "") {
      show_message("Please enter the email First!");
      return;
  }
  emailInput = document.getElementById("mmaaii");

  if (! emailInput.checkValidity()) {
    show_message("Please enter Valid email!");
    return;
  }

  if (confirm("Do you want to reset password?")) {
        showLoading();
        $.ajax({
            type: "POST",
            url: "SYS/pass_reset.php", 
            data: { email: email },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    show_message("password reset has been sent to your email!");
                    hideLoading();
                    
                } else {
                    show_message("Failed ~> "+response.message);
                    hideLoading();
                }
            },
            error: function(xhr, status, error) {
                show_message("Error occurred while sending request. ~> "+error.message);
                console.error(xhr, status, error);
                hideLoading();
            }
        });
        
        
      }
}



$(document).ready(function() {
  $('#togglePassword').on('click', function() {
    const passwordField = $('#password');
    const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
    passwordField.attr('type', type);
    $(this).toggleClass('fa-eye fa-eye-slash');
  });

  $('#toggleCPassword').on('click', function() {
    const passwordField = $('#cpassword');
    const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
    passwordField.attr('type', type);
    $(this).toggleClass('fa-eye fa-eye-slash');
  });

  $('#toggleSigninPassword').on('click', function() {
    const passwordField = $('#pmmaaii');
    const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
    passwordField.attr('type', type);
    $(this).toggleClass('fa-eye fa-eye-slash');
  });
});



const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
if (urlParams.get('status') === 'reset') {
  show_message("Account updated sucessfully!");
}

if (urlParams.get('status') === 'wrong') {
  show_message("Wrong username or password!");
}

if (urlParams.get('status') === 'create') {
  show_message("Account created sucessfully!");
}

if (urlParams.get('status') === 'exist') {
  show_message("Account Olready exist!");
}

if (urlParams.get('status') === 'logout') {
  show_message("Logout sucessfully!");
}

if (urlParams.get('status') === 'iemail') {
  show_message("Invalid email address!");
}

if (urlParams.get('status') === 'codexp') {
  show_message("Passsword reset code expired try again!");
}

if (urlParams.get('status') === 'resetd') {
  show_message("Password reset successful! Click the eye icon to check your password. You can change it in your account settings.");
}

if (urlParams.get('email')){
  document.getElementById("mmaaii").value = urlParams.get('email');
}

if (urlParams.get('pass')){
  document.getElementById("pmmaaii").value = urlParams.get('pass');
}

  





