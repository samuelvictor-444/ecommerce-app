window.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("click", (e) => {
    const addToCartBtn = e.target.closest(".add_to_cart");

    if (addToCartBtn) {
      if (addToCartBtn.classList.contains("processing")) return; // ⛔ skip if already clicked
      addToCartBtn.classList.add("processing"); // ✅ mark it busy

      const hasVariation = addToCartBtn.dataset.hasVariation === "1";
      const slug = addToCartBtn.dataset.slug;
      const spinner = document.createElement("span");

      // Get the specific increment_decrement section for this product
      const productContainer = document.querySelector(
        `.product_c[data-slug="${slug}"]`
      );
      const incrementDecrementBox = productContainer.querySelector(
        ".increment_decrement"
      );

      const incrementBtn = incrementDecrementBox.querySelector(".increment");
      const decrementBtn = incrementDecrementBox.querySelector(".decrement");

      const quantitySpan = incrementDecrementBox.querySelector("span");
      const productName = addToCartBtn.dataset.name;

      if (hasVariation) {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];

        const totalQtyForSlug = cart
          .filter((item) => item.slug === slug)
          .reduce((sum, item) => sum + item.quantity, 0);

        showVariationOverlay(slug, addToCartBtn, productName, totalQtyForSlug);
        return;
      } else {
        addToCartBtn.style.display = "none";

        // addToCartBtn.setAttribute("disabled", true);

        incrementDecrementBox.style.setProperty("display", "flex");

        incrementBtn.style.setProperty("visibility", "hidden", "important");
        decrementBtn.style.setProperty("visibility", "hidden", "important");

        spinner.classList.add("spin");

        if (!quantitySpan.querySelector(".spin")) {
          quantitySpan.innerHTML = ""; // Optional: clear first
          quantitySpan.appendChild(spinner);
        }

        const item = {
          key: addToCartBtn.dataset.slug,
          slug: addToCartBtn.dataset.slug,
          attribute_value_id: null,
          quantity: 1,
          name: addToCartBtn.dataset.name,
          price: parseFloat(addToCartBtn.dataset.price),
          oldPrice: parseFloat(addToCartBtn.dataset.old),
          image: addToCartBtn.dataset.image,
        };

        setTimeout(() => {
          if (quantitySpan.contains(spinner)) {
            quantitySpan.removeChild(spinner);
          }

          quantitySpan.textContent = "1";

          incrementBtn.style.setProperty("visibility", "visible", "important");
          decrementBtn.style.setProperty("visibility", "visible", "important");

          addToCartBtn.classList.remove("processing"); // ✅ now allow new clicks again

          addToLocalCart(item);
          setupIncrementDecrementListeners();
          sweetAlert(productName, "product add successfully to cart");
        }, 500);
      }
      
      return;
    }
  }); // ends addEventListener on the document

  async function showVariationOverlay(slug, addToCartBtn, productName) {
    addToCartBtn.setAttribute("disabled", true);

    const overLay = document.querySelector(".product_variation");
    const variationContainer = document.querySelector(
      ".container_vari_selection"
    );
    const closeBtn = document.querySelector(".product_variation .pop button");
    const continueBtn = document.querySelector(".btns_con a");
    const goToCartBtn = document.querySelector(".btns_con button");
  

    overLay.style.display = "flex";

    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    let hasAnyQty = false;

    const response = await fetch(`api/get_variations.php?slug=${slug}`);

    if (response.ok) {
      const data = await response.json();

      variationContainer.innerHTML = "";
      if (data) {
        data.forEach((variation) => {
          const {
            value_name,
            price,
            old_price,
            attribute_value_id,
            attribute_name,
          } = variation;

          const variationItem = document.createElement("div");
          variationItem.classList.add("vari_cont");
          variationItem.dataset.valueId = attribute_value_id;
          variationItem.dataset.slug = slug;
          variationItem.dataset.name = productName;

          const key = `${slug}_${attribute_value_id}`;
          const existingItem = cart.find((item) => item.key === key);
          const savedQty = existingItem ? existingItem.quantity : 0;

          if (savedQty > 0) hasAnyQty = true;

          variationItem.innerHTML = `
  <div class="cont_warp1">
    <h3>${attribute_name}: ${value_name}</h3>
    <div class="wrp_">
      <p>₦ ${Number(price).toLocaleString()}</p>
      <span><del>₦ ${Number(old_price).toLocaleString()}</del></span>
    </div>
  </div>
  <div class="cont_warp2">
    <button class="remove_decre ${savedQty > 0 ? "active" : ""}" ${
            savedQty > 0 ? "" : "disabled"
          }>
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M5 11V13H19V11H5Z"></path></svg>
    </button>
    <span id="quantity">${savedQty}</span>
    <button class="add_incre">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M13 11H22V13H13V22H11V13H2V11H11V2H13V11Z"></path></svg>
    </button>
  </div>
`;

          variationContainer.appendChild(variationItem);
        });

        variationContainer.addEventListener("click", (e) => {
          const btn = e.target.closest("button");
          if (!btn) return;

          
          const goToCartBtn = document.querySelector(".btns_con button");
          const variationItem = btn.closest(".vari_cont");
          const valueId = variationItem.dataset.valueId || null;
          const slug = variationItem.dataset.slug;
          const productName = variationItem.dataset.name;
          const quantitySpan = variationItem.querySelector("#quantity");
          let quantity = parseInt(quantitySpan.textContent);
          const mCartQuantity = document.querySelector("#mobile_cart_quantity");

          const decrement = variationItem.querySelector(".remove_decre ");

          const productImg = addToCartBtn.dataset.image;
          const productPrice = parseFloat(addToCartBtn.dataset.price);
          const productOldPrice = parseFloat(addToCartBtn.dataset.old);
          const key = `${slug}_${valueId}`;

          const productBox = document.querySelector(
            `.product_c[data-slug="${slug}"]`
          );

          let cart = JSON.parse(localStorage.getItem("cart")) || [];

          const cartItem = {
            key,
            slug,
            quantity,
            attribute_value_id: parseInt(valueId),
            productName,
            productImg,
            price :productPrice,
            productOldPrice,
          };

          if (btn.classList.contains("add_incre")) {
            const key = valueId ? `${slug}_${valueId}` : slug;
            const exists = cart.find((item) => item.key === key);

            quantity++;

            btn.setAttribute("disabled", true);
            decrement.setAttribute("disabled", true);
            goToCartBtn.setAttribute("disabled", true);

            btn.classList.add("updating");
            decrement.classList.add("updating");
            goToCartBtn.classList.add("updating");

            const spinner = document.createElement("span");
            spinner.classList.add("spin");

            quantitySpan.appendChild(spinner);

            setTimeout(() => {
               quantitySpan.textContent = quantity;

              btn.removeAttribute("disabled", true);
              decrement.removeAttribute("disabled", true);
              goToCartBtn.removeAttribute("disabled", true);

              btn.classList.remove("updating");
              decrement.classList.remove("updating");
              goToCartBtn.classList.remove("updating");

              if (productBox) {
                if (quantity >= 1 || quantity !== 0) {
                  variationItem.querySelector(".remove_decre").disabled = false;
                  variationItem
                    .querySelector(".remove_decre")
                    .classList.add("active");

                  goToCartBtn.classList.add("activate");
                  goToCartBtn.addEventListener("click", handleGoToCartClick);

                  mCartQuantity.style.setProperty(
                    "display",
                    "flex",
                    "important"
                  );

                  cartItem.quantity = quantity;
                  cartItem.attribute_value_id = parseInt(valueId);
                  addToLocalCart(cartItem);
                  updateInlineCounter(slug);
                }
              }

              if (!exists) {
                // send success message
                sweetAlert(
                  productName,
                  "has been added to your cart successfully"
                );
              } else {
                // send update message to the user
                sweetAlert(
                  productName,
                  " Quantity has been updated successfully"
                );
              }
            }, 500);
          } else if (btn.classList.contains("remove_decre")) {
            if (quantity > 0) {
              quantity--;

              const increment = variationItem.querySelector(".add_incre");

              btn.setAttribute("disabled", true);
              increment.setAttribute("disabled", true);
              goToCartBtn.setAttribute("disabled", true);

              btn.classList.add("updating");
              increment.classList.add("updating");
              goToCartBtn.classList.add("updating");

              const spinner = document.createElement("span");
              spinner.classList.add("spin");

              quantitySpan.appendChild(spinner);

              setTimeout(() => {
                quantitySpan.textContent = quantity;

                btn.removeAttribute("disabled", true);
                increment.removeAttribute("disabled", true);
                goToCartBtn.removeAttribute("disabled", true);

                btn.classList.remove("updating");
                increment.classList.remove("updating");
                goToCartBtn.classList.remove("updating");

                cartItem.quantity = quantity;
                cartItem.attribute_value_id = parseInt(valueId);

                addToLocalCart(cartItem);
                updateInlineCounter(slug);

                sweetAlert(
                  productName,
                  " Quantity has been updated successfully"
                );

                if (quantity === 0) {
                  btn.disabled = true;
                  variationItem
                    .querySelector(".remove_decre")
                    .classList.remove("active");

                  cartItem.quantity = quantity;
                  cartItem.attribute_value_id = parseInt(valueId);
                  addToLocalCart(cartItem);
                  updateInlineCounter(slug);

                  // Check if any variation of the same product still exists in cart with quantity > 0
                  const cart = JSON.parse(localStorage.getItem("cart")) || [];
                  const hasOtherQuantities = cart.some(
                    (item) => item.slug === slug && item.quantity > 0
                  );

                  if (!hasOtherQuantities) {
                    goToCartBtn.classList.remove("activate");
                    goToCartBtn.removeEventListener(
                      "click",
                      handleGoToCartClick
                    );
                  }
                }
              }, 500);
            }
          }
        });

        const closeOverlay = () => {
          addToCartBtn.removeAttribute("disabled");
          addToCartBtn.classList.remove("processing");
          overLay.style.display = "none";
        };

        closeBtn.addEventListener("click", closeOverlay);
        continueBtn.addEventListener("click", closeOverlay);

        // ✅ Activate the Go to Cart button if any variation was already added
        if (hasAnyQty) {
          goToCartBtn.classList.add("activate");
        }
      }
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  }

  // function  updateInlineCounter
  function updateInlineCounter(slug) {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    const productBox = document.querySelector(
      `.product_c[data-slug="${slug}"]`
    );
    const addBtn = productBox?.querySelector(".add_to_cart");
    const inlineCounter = productBox?.querySelector(".increment_decrement");

    const totalQtyForSlug = cart
      .filter((item) => item.slug === slug)
      .reduce((sum, item) => sum + item.quantity, 0);

    if (addBtn && inlineCounter) {
      if (totalQtyForSlug > 0) {
        addBtn.style.setProperty("display", "none", "important");
        inlineCounter.style.display = "flex";
        const counterSpan = inlineCounter.querySelector("span");
        if (counterSpan) {
          counterSpan.textContent = totalQtyForSlug;
        }
      } else {
        addBtn.style.setProperty("display", "block", "important");
        inlineCounter.style.display = "none";
      }
    }
  } // ends function updateInlineCounter

  document.addEventListener("click", (e) => {
    const incrementBtn = e.target.closest(".incBtnVary");
    const decrementBtn = e.target.closest(".decBtnVary");

    if (incrementBtn || decrementBtn) {
      e.preventDefault();
      e.stopPropagation();

      const productBox = e.target.closest(".product_c");
      const slug = productBox?.dataset.slug;

      if (!slug) return;

      // Reopen the variation overlay
      const addToCartBtn = productBox.querySelector(".add_to_cart");
      const productName = addToCartBtn.dataset.name;

      showVariationOverlay(slug, addToCartBtn, productName);
    }
  });

  function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    let total = 0;

    cart.forEach((item) => {
      total += item.quantity;
    });

    const cartQtySpan = document.querySelector(".cart_quantity");
    const mCartQtySpan = document.querySelector("#mobile_cart_quantity");

    if (cartQtySpan || mCartQtySpan) {
      if (total === 0) {
        mCartQtySpan.style.display = "none";
        cartQtySpan.textContent = total;
        mCartQtySpan.textContent = total;
      } else {
        mCartQtySpan.style.display = "flex";
        cartQtySpan.textContent = total;
        mCartQtySpan.textContent = total;
      }
    }
  } // ends function updateCartCount

  function addToLocalCart(item) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    const existingIndex = cart.findIndex(
      (p) =>
        p.slug === item.slug && p.attribute_value_id === item.attribute_value_id
    );

    if (item.quantity <= 0) {
      // Remove item if quantity is zero
      if (existingIndex > -1) {
        cart.splice(existingIndex, 1);
      }
    } else if (existingIndex > -1) {
      // 🛠️ Replace the existing quantity with item.quantity (not += 1)
      cart[existingIndex].quantity = item.quantity;
    } else {
      cart.push(item);
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
  } // ends function addToLocalCart

  function setupIncrementDecrementListeners() {
    document.querySelectorAll(".product_c").forEach((productContainer) => {
      const spinner = document.createElement("span");
      const slug = productContainer.dataset.slug;
      const addToCartBtn = productContainer.querySelector(".add_to_cart");
      const incrementDecrementBox = productContainer.querySelector(
        ".increment_decrement"
      );
      const incrementBtn = incrementDecrementBox?.querySelector(".increment");
      const decrementBtn = incrementDecrementBox?.querySelector(".decrement");
      const quantitySpan = incrementDecrementBox?.querySelector("span");

      if (!incrementBtn || !decrementBtn || !addToCartBtn || !quantitySpan)
        return;

      const productName = addToCartBtn.dataset.name;
      const price = parseFloat(addToCartBtn.dataset.price);
      const image = addToCartBtn.dataset.image;

      // Prevent multiple listeners
      incrementBtn.replaceWith(incrementBtn.cloneNode(true));
      decrementBtn.replaceWith(decrementBtn.cloneNode(true));

      const newIncrementBtn = productContainer.querySelector(".increment");
      const newDecrementBtn = productContainer.querySelector(".decrement");

      newIncrementBtn.addEventListener("click", () => {
        newIncrementBtn.setAttribute("disabled", true);
        newDecrementBtn.setAttribute("disabled", true);

        newIncrementBtn.classList.add("updating");
        newDecrementBtn.classList.add("updating");

        quantitySpan.appendChild(spinner);
        spinner.classList.add("spin");

        let currentQty = parseInt(quantitySpan.textContent.trim()) || 1;
        let newQty = currentQty + 1;

        setTimeout(() => {
          quantitySpan.removeChild(spinner);
          spinner.classList.remove("spin");

          newIncrementBtn.removeAttribute("disabled");
          newDecrementBtn.removeAttribute("disabled");

          newIncrementBtn.classList.remove("updating");
          newDecrementBtn.classList.remove("updating");

          quantitySpan.textContent = newQty;

          const item = {
            key: slug,
            slug: slug,
            attribute_value_id: null,
            quantity: newQty,
            name: addToCartBtn.dataset.name,
            price: parseFloat(addToCartBtn.dataset.price),
            image: addToCartBtn.dataset.image,
          };

          addToLocalCart(item);

          sweetAlert(productName, "Quantity has been updated successfully");
        }, 500);
      });

      newDecrementBtn.addEventListener("click", () => {
        newIncrementBtn.setAttribute("disabled", true);
        newDecrementBtn.setAttribute("disabled", true);

        newIncrementBtn.classList.add("updating");
        newDecrementBtn.classList.add("updating");

        quantitySpan.appendChild(spinner);
        spinner.classList.add("spin");

        let currentQty = parseInt(quantitySpan.textContent.trim()) || 1;

        setTimeout(() => {
          quantitySpan.removeChild(spinner);
          spinner.classList.remove("spin");

          newIncrementBtn.removeAttribute("disabled");
          newDecrementBtn.removeAttribute("disabled");

          newIncrementBtn.classList.remove("updating");
          newDecrementBtn.classList.remove("updating");

          if (currentQty > 0) {
            currentQty--;
            quantitySpan.textContent = currentQty;

            const item = {
              key: slug,
              slug: slug,
              attribute_value_id: null,
              quantity: currentQty,
              name: addToCartBtn.dataset.name,
              price: parseFloat(addToCartBtn.dataset.price),
              image: addToCartBtn.dataset.image,
            };

            addToLocalCart(item);

            if (currentQty === 0) {
              incrementDecrementBox.style.display = "none";
              addToCartBtn.style.display = "block";
              addToCartBtn.removeAttribute("disabled");

              sweetAlert(productName, " has been removed from your cart");
            } else {
              addToCartBtn.setAttribute("disabled", true);

              sweetAlert(
                productName,
                " Quantity has been updated successfully"
              );
            }
          }
        }, 500); // ends setTimeout function
      });
    });
  } // ends function setupIncrementDecrementListeners

  function handleGoToCartClick() {
    window.location.href = "cart.php";
  } // ends function handleGoToCartClick

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

  function syncCartWithUI() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    cart.forEach((item) => {
      const productContainer = document.querySelector(
        `.product_c[data-slug="${item.slug}"]`
      );

      if (!productContainer) return;

      const addToCartBtn = productContainer.querySelector(".add_to_cart");
      const incrementDecrementBox = productContainer.querySelector(
        ".increment_decrement"
      );
      const quantitySpan = incrementDecrementBox.querySelector("span");

      // Update UI
      addToCartBtn.style.setProperty("display", "none", "important");
      addToCartBtn.setAttribute("disabled", true);
      incrementDecrementBox.style.setProperty("display", "flex", "important");
      quantitySpan.textContent = item.quantity;
    });

    // Reattach increment/decrement logic using helper
    setupIncrementDecrementListeners();
  } // ends function syncCartWithUI

  document.addEventListener("productsRendered", () => {
    syncCartWithUI(); // now it runs at the right time

    const productBoxes = document.querySelectorAll(".product_c");

    productBoxes.forEach((box) => {
      const slug = box.dataset.slug;
      updateInlineCounter(slug);
    });
  });

  document.addEventListener("productsSort", () => {
    syncCartWithUI(); // now it runs at the right time

    const productBoxes = document.querySelectorAll(".product_c");

    productBoxes.forEach((box) => {
      const slug = box.dataset.slug;
      updateInlineCounter(slug);
    });
  });

  updateCartCount();
});
