// JavaScript Document

//Fixed Navigation bar changes size when the page is scrolled down
window.onscroll = function() {
    shrinkNavbar();
};

function shrinkNavbar() {
    const navbar = document.getElementById("navbar");
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        navbar.classList.add("shrink");
    } else {
        navbar.classList.remove("shrink");
    }
}


//Home -> Click "Explore" button -> Navigates to the Category section
function scrollToSection(Category_section) {
    const section = document.getElementById(Category_section);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

//faq 
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}

 // Function to update the total price based on quantity
        function updateQuantity(change) {
            let quantity = parseInt(document.getElementById('quantity').value);
            quantity = quantity + change;
            if (quantity < 1) {
                quantity = 1;
            }
            document.getElementById('quantity').value = quantity;
            
            let price = parseFloat(document.getElementById('price').innerText);
            document.getElementById('total-price').innerText = (price * quantity).toFixed(2);
        }