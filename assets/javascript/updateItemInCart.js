window.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("click", (e) => {
    const incrementBtn = e.target.closest(".increment");
    const decrementBtn = e.target.closest(".decrement");
    const removeBtn = e.target.closest(".removeItem");
    const cartItem = e.target.closest("._product_added");

    if (!incrementBtn && !decrementBtn && !removeBtn) return;

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (!cartItem) return;

    const slug = cartItem.dataset.slug;
    const valueId = cartItem.dataset.value;
    const productName = cartItem.dataset.name;

    const quantitySpan = cartItem.querySelector(".incre");
    let quantity = parseInt(quantitySpan.textContent);
    const cartQtySpan = document.querySelector(".cart_quantity");
    const mCartQtySpan = document.querySelector("#mobile_cart_quantity");

    // Find product in cart
    let item = cart.find(
      (p) =>
        p.slug === slug && (valueId ? p.attribute_value_id == valueId : true)
    );

    if (!item) return;

    // ✅ Clean productPrice before using
    const parsePrice = (price) => {
      if (!price) return 0;
      return parseFloat(
        String(price).replace(/[^\d.]/g, "") // remove ₦ and commas
      );
    };

    // function to recalc totals
    const recalcTotals = () => {
      let totalQty = cart.reduce((sum, p) => sum + parseInt(p.quantity), 0);
      cartQtySpan.textContent = totalQty;
      mCartQtySpan.textContent = totalQty;

      let subTotal = cart.reduce((sum, p) => {
        let price = parsePrice(p.price) || 0; // use productPrice directly
        let qty = Number(p.quantity) || 0;
        return sum + price * qty;
      }, 0);

      // update all subtotal elements
      document.querySelectorAll(".totalP").forEach((el) => {
        el.textContent = "₦ " + subTotal.toLocaleString();
      });
    };

    const setAllBtnsState = (disabled) => {
      document.querySelectorAll("._product_added").forEach((cartItem) => {
        const incrementBtn = cartItem.querySelector(".increment");
        const decrementBtn = cartItem.querySelector(".decrement");

        [incrementBtn, decrementBtn].forEach((btn) => {
          if (!btn) return;
          if (disabled) {
            btn.classList.add("processing");
            btn.setAttribute("disabled", true);
          } else {
            btn.classList.remove("processing");
            btn.removeAttribute("disabled");

            // Make sure decrement is disabled if quantity === 1
            const qtySpan = cartItem.querySelector(".incre");
            if (qtySpan && parseInt(qtySpan.textContent) <= 1) {
              if (decrementBtn) decrementBtn.setAttribute("disabled", true);
            }
          }
        });
      });
    };

    // increment operation
    if (incrementBtn) {
      setAllBtnsState(true);

      const spinner = document.createElement("small");
      spinner.classList.add("spin");

      quantitySpan.appendChild(spinner);

      setTimeout(() => {
        if (quantitySpan.contains(spinner)) {
          quantitySpan.removeChild(spinner);
        }
        item.quantity = parseInt(item.quantity) + 1;
        quantity = item.quantity;

        quantitySpan.textContent = quantity;

        sweetAlert(productName, "Quantity has been updated successfully");

        // Save updated cart
        localStorage.setItem("cart", JSON.stringify(cart));

        setAllBtnsState(false);
        recalcTotals();
      }, 500);
    } // ends increment operation

    if (decrementBtn) {
      if (item.quantity > 1) {
        setAllBtnsState(true);

        const spinner = document.createElement("small");
        spinner.classList.add("spin");

        quantitySpan.appendChild(spinner);

        setTimeout(() => {
          if (quantitySpan.contains(spinner)) {
            quantitySpan.removeChild(spinner);
          }
          item.quantity = Math.max(1, parseInt(item.quantity) - 1);
          quantity = item.quantity;

          quantitySpan.textContent = quantity;

          sweetAlert(productName, "Quantity has been updated successfully");

          // Save updated cart
          localStorage.setItem("cart", JSON.stringify(cart));

          setAllBtnsState(false);
          recalcTotals();

          if (item.quantity === 1) {
            decrementBtn.setAttribute("disabled", true);
          } else {
            decrementBtn.removeAttribute("disabled");
            decrementBtn.classList.remove("inactive");
          }
        }, 500);
      }
    }

    if (removeBtn) {
      // remove from array
      cart = cart.filter((c) => c.key !== item.key);

      const counterDisplay = document.querySelector(".counter_");
      const totalCount = cart.length;

      if (counterDisplay) {
        counterDisplay.textContent = `Cart (${totalCount})`;
      }

      // remove this item row
      cartItem.remove();

      // save
      localStorage.setItem("cart", JSON.stringify(cart));

      // recalc totals
      recalcTotals();

      // check if cart is empty
      if (cart.length === 0) {
        document.querySelector(".product_added_container").style.display =
          "none";
        document.querySelector(".mobile_check_out").style.display = "none";
        document.querySelector(".empty_cart_box").style.display = "block";

        
        setTimeout(() => {
            window.location.reload(true);
        },500);
      }

      sweetAlert(productName, "has been removed from cart successfully");
    }

    // Save updated cart
    localStorage.setItem("cart", JSON.stringify(cart));

    // ✅ recalc total cart quantity
    let totalQty = cart.reduce((sum, p) => sum + Number(p.quantity), 0);
    cartQtySpan.textContent = totalQty;
    mCartQtySpan.textContent = totalQty;
  });

  function sweetAlert(message1, message2) {
    const container = document.querySelector(".message");

    if (!container) return; // Prevent error if .message does not exist

    const existingAlert = container.querySelector(".success");
    if (existingAlert) {
      container.removeChild(existingAlert);
    }

    const div = document.createElement("div");
    div.classList.add("success");
    div.style.left = "-700px";

    const h2 = document.createElement("h2");
    const p = document.createElement("p");
    const span = document.createElement("span");

    if (message1 && message2) {
      div.classList.add("active");
      p.textContent = message1;
      span.textContent = message2;
    }

    h2.appendChild(p);
    h2.appendChild(span);
    div.appendChild(h2);
    container.appendChild(div);

    // 🎵 Optional sound feedback
    const audio = new Audio(
      "./assets/audio/notification-sound-effect-372475.mp3"
    );
    audio.play();

    // 📳 Vibration for mobile (if supported)
    if (navigator.vibrate) {
      navigator.vibrate([100, 50, 100]);
    }

    // Remove the alert after 3 seconds
    setTimeout(() => {
      div.classList.remove("active");

      // Remove the DOM element completely after another 2 seconds
      setTimeout(() => {
        if (container.contains(div)) {
          container.removeChild(div);
        }
      }, 500);
    }, 500);
  } // ends function sweetAlert
});
