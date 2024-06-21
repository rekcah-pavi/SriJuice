
const menuIcon = document.querySelector('.menu-icon i');
const navUl = document.querySelector('.navbar ul');

menuIcon.addEventListener('click', () => {
  navUl.classList.toggle('show');
  if (navUl.classList.contains('show')) {
      menuIcon.classList.replace('fa-bars', 'fa-times');
  } else {
      menuIcon.classList.replace('fa-times', 'fa-bars');
  }
});




window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    const goTopBtn = document.getElementById("goTopBtn");
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        goTopBtn.style.display = "block";
    } else {
        goTopBtn.style.display = "none";
    }
}


document.getElementById("goTopBtn").addEventListener("click", function(event) {
    event.preventDefault(); 
    document.body.scrollTop = 0; 
    document.documentElement.scrollTop = 0; 
});




function show_message(text,href,htext){
    var modal = document.getElementById("customModal");
    var closeBtn = document.getElementsByClassName("close")[0];
    closeBtn.onclick = function() {
        modal.style.display = "none";
    };
    var modalMessage = document.getElementById("modalMessage");
    modalMessage.innerText = text;
    modal.style.display = "block";
    var link = document.getElementById("mmmm");
    link.href = href;
    link.textContent = htext;
    setTimeout(function() {
        modal.style.display = "none";
    }, 5000);

}

function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}

const isAdmin = getCookie('admin') === 'true';


if (isAdmin) {
    document.getElementById("dcc").style.display = "none";
}