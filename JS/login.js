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
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("cpassword").value;

  if (password !== confirmPassword) {
      show_message("Passwords do not match. Please check!");
      return false;
  }
  return true;
}


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




