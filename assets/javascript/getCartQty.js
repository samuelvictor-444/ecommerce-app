window.addEventListener("DOMContentLoaded", () => {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const totalQty = cart.reduce((sum, item) => sum + item.quantity, 0);

  const mCartQuantity = document.querySelector("#mobile_cart_quantity");
  const cartQtySpan = document.querySelector(".cart_quantity");

  if (cart.length === 0) {
    
    mCartQuantity.style.display = "none";
    mCartQuantity.textContent = "";

  } else if (mCartQuantity || cartQtySpan) {
    mCartQuantity.style.display = "flex";
    mCartQuantity.textContent = totalQty;

    cartQtySpan.textContent = totalQty;
  }
});

