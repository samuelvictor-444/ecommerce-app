window.addEventListener("load", async () => {
  await fetchRecentViewed();
  updateCartCount();
  likedProduct();
  syncCartWithUI();
  locationSelection();
});

window.addEventListener("DOMContentLoaded", async () => {
  const slug = new URLSearchParams(window.location.search).get("name");

  if (!slug) {
    console.error("slug not found");
    return;
  }

  try {
    const response = await fetch(`api/getProductDetails.php?slug=${slug}`);

    if (response.ok) {
      const product = await response.json();

      if (product) {
        renderProduct(product);
      } else {
        console.error("No product data returned from API");
      }
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  } catch (e) {
    console.error("error occured while fetching product details " + e);
  }
});

function renderProduct(product) {
  const imgCont = document.querySelector("#maginify");
  imgCont.innerHTML = "";

  // display main product image
  const mainImg = document.createElement("img");
  mainImg.classList.add("fade-in", "show");

  const productImg = document.querySelector(".product_img");
  const mobCon = document.querySelector("#maginify_mob");

  if (product.image && product.image.length) {
    mainImg.src = product.image;
    productImg.src = product.image;

    imgCont.appendChild(mainImg);
  }

  // display mobile products images
  if (product.image && product.image.length) {
    mobCon.innerHTML = "";
    if (product.images.length >= 1) {
      product.images.forEach((img, index) => {
        mobCon.innerHTML += `
    
       <a class="pro">
                    <div class="pro_uct">
                        <img src="${img.image_url}" alt="">
                    </div>
                </a>`;
      });
    } else {
      mobCon.innerHTML = `
    
       <a class="pro">
                    <div class="pro_uct">
                        <img class="single" src="${product.image}" alt="">
                    </div>
                </a>`;
    }
  } // ends display mobile products images

  // Thumbnails
  const thumbBoxImg = document.querySelector(".caro");
  if (product.images.length >= 1) {
    thumbBoxImg.innerHTML = "";

    const wrapper = document.querySelector(".pro_img_ve");
    const sliderBtn = document.querySelector(".sliderbtn");

    if (product.images.length < 6) {
      sliderBtn.style.display = "none";
      wrapper.classList.add("active");
    }

    product.images.forEach((img, index) => {
      const thumb = document.createElement("div");
      thumb.classList.add("itm_");

      const imgs = document.createElement("img");
      imgs.src = img.image_url;

      thumb.appendChild(imgs);
      thumbBoxImg.appendChild(thumb);

      // add EventListener
      thumb.addEventListener("click", () => {
        // Remove show class to start from opacity 0
        mainImg.classList.remove("show");

        // Change image after a small delay
        setTimeout(() => {
          mainImg.src = img.image_url;
          mainImg.classList.add("show");
        }, 300); // Small delay so browser detects the change
      }); // ends add addEventListener
    });

    const ConBtn = sliderBtn.querySelectorAll("button"); // slider btn
    const slides = thumbBoxImg.querySelectorAll(".itm_");

    const slidesWidth = slides[0].offsetWidth;

    function updateBtnStates() {
      const atStart = thumbBoxImg.scrollLeft <= 0;
      const atEnd =
        Math.ceil(thumbBoxImg.scrollLeft + thumbBoxImg.clientWidth) >=
        thumbBoxImg.scrollWidth;

      ConBtn.forEach((btn) => {
        if (btn.id === "leftid") {
          btn.disabled = atStart;
          btn.classList.toggle("disabledBtn", atStart);
        } else if (btn.id === "rightid") {
          btn.disabled = atEnd;
          btn.classList.toggle("disabledBtn", atEnd);
        }
      });
    }

    ConBtn.forEach((btn) => {
      btn.addEventListener("click", () => {
        const scrollAmount = btn.id === "rightid" ? slidesWidth : -slidesWidth;
        thumbBoxImg.scrollBy({ left: scrollAmount, behavior: "smooth" });

        // Slight delay to allow scroll to update
        setTimeout(updateBtnStates, 300);
      });
    });
  } else {
    thumbBoxImg.style.display = "none";
  }

  // product name
  const productName = document.querySelectorAll(".product_name");
  productName.forEach((name) => {
    name.textContent = product.name;
  });

  // product price
  const productPrice = document.querySelectorAll(".product_price");
  if (productPrice)
    productPrice.forEach((price) => {
      price.innerHTML = `&#x20A6; ${formatPrice(product.price)}`;
    });

  // old price
  const oldPrice = document.querySelectorAll(".old_pr");
  if (oldPrice)
    oldPrice.forEach((oldP) => {
      oldP.innerHTML = `&#x20A6; ${formatPrice(product.old_price)}`;
    });

  const discount = document.querySelectorAll(".bugdt");

  if (discount) {
    discount.forEach((dis) => {
      const discountAmount = Number(product.old_price) - Number(product.price);
      const discountPercent =
        Number(product.old_price) > 0
          ? Math.round((discountAmount / Number(product.old_price)) * 100)
          : 0;

      // Only show if discount exists
      dis.textContent = discountPercent > 0 ? `${discountPercent}%` : "";
    });
  }

  // product rating
  const productRating = product.rating;
  const maxRating = 5;
  const percent = (productRating / maxRating) * 100;
  document.querySelectorAll(".in_s").forEach((rate) => {
    rate.style.width = percent + "%";
  });

  // product varaition
  const variationWrapper = document.querySelector(".vary_wrpp");
  const mvariationWrapper = document.querySelector(".mVar");

  if (product.variation) {
    if (product.variation.length === 0) {
      mvariationWrapper.style.setProperty("display", "none", "important");
      variationWrapper.style.setProperty("display", "none", "important");
    }

    const varOpts = document.querySelectorAll(".var"); // both mobile + desktop

    // build variation groups once
    function buildVariationGroups() {
      const fragment = document.createDocumentFragment();

      Object.keys(product.variation).forEach((attr) => {
        const group = document.createElement("div");
        group.classList.add("variation-group");

        // Attribute label (e.g., Size:)
        const label = document.createElement("label");
        label.classList.add("lab");
        label.textContent = attr + ":";
        group.appendChild(label);

        // Options container
        const optCon = document.createElement("div");
        optCon.classList.add("varii");

        product.variation[attr].forEach((value, index) => {
          const inputId = `${attr}-${value}-${index}`;

          const input = document.createElement("input");
          input.type = "radio";
          input.name = attr;
          input.id = inputId;
          input.value = value;
          input.classList.add("vi");

          const labelIn = document.createElement("label");
          labelIn.classList.add("vl");
          labelIn.htmlFor = inputId;
          labelIn.textContent = value;

          optCon.appendChild(input);
          optCon.appendChild(labelIn);
        });

        group.appendChild(optCon);
        fragment.appendChild(group);
      });

      return fragment;
    }

    // put groups into both .var containers
    varOpts.forEach((container) => {
      container.innerHTML = ""; // clear if needed
      container.appendChild(buildVariationGroups().cloneNode(true));
    });

  }

  // add product to cart
  const btn = document.querySelectorAll(".add_me_c");

  btn.forEach((btn) => {
    if (!btn) return;
    const increDecBox = document.querySelectorAll(".incre_decre");
    const productViewer = document.querySelectorAll(".pro_d_view");
    btn.classList.add("add_to_cart");
    btn.dataset.name = product.name;
    btn.dataset.slug = product.slug;
    btn.dataset.price = product.price;
    btn.dataset.id = product.id;
    btn.dataset.old = product.old_price;
    btn.dataset.image = product.image;
    btn.dataset.hasVariation = product.has_variation;

    increDecBox.forEach((box) => {
      box.dataset.slug = product.slug;
    });

    if (btn.dataset.hasVariation > 0) {
      increDecBox.forEach((box) => {
        const button = box.querySelectorAll("button");

        button.forEach((btns) => {
          if (btns.classList.contains("increment")) {
            btns.classList.replace("increment", "incBtnVary");
          } else if (btns.classList.contains("decrement")) {
            btns.classList.replace("decrement", "decBtnVary");
          }
        });
      });
    }

    productViewer.forEach((viwer) => {
      viwer.dataset.slug = product.slug;
    });

    document.addEventListener("click", (e) => {
      const addToCartBtn = e.target.closest(".add_to_cart");
      if (addToCartBtn) {
        if (addToCartBtn.classList.contains("processing")) return;
        addToCartBtn.classList.add("processing"); // ✅ mark it busy

        const hasVariation = addToCartBtn.dataset.hasVariation === "1";
        const slug = addToCartBtn.dataset.slug;
        const spinner = document.createElement("span");

        const increment_box = document.querySelectorAll(
          `.incre_decre[data-slug=${product.slug}]`
        );

        increment_box.forEach((box) => {
          const quantitySpan = box.querySelector("span");
          const productName = product.name;

          if (hasVariation) {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const totalQtyForSlug = cart
              .filter((item) => item.slug === slug)
              .reduce((sum, item) => sum + item.quantity, 0);
            showVariationOverlay(
              slug,
              addToCartBtn,
              productName,
              totalQtyForSlug
            );
            return;
          } else {
            addToCartBtn.innerHTML = "";
            spinner.classList.add("spin");
            addToCartBtn.appendChild(spinner);

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

            // const incrementBtn = box.querySelector(".increment");
            // const decrementBtn = box.querySelector(".decrement");

           

            setTimeout(() => {
      
              addToCartBtn.style.display = "none";
              quantitySpan.textContent = "1";
              box.style.display = "flex";

              addToCartBtn.classList.remove("processing");

              addToLocalCart(item);
              setupIncrementDecrementListeners();
              sweetAlert(productName, "product add successfully to cart");
            }, 2000);
          }
        });

        return;
      }
    });
  });
}

async function showVariationOverlay(slug, addToCartBtn, productName) {
  addToCartBtn.setAttribute("disabled", true);

  const overLay = document.querySelector(".pop");
  const variationContainer = document.querySelector(".cr_sel");
  const closeBtn = overLay.querySelector("#close_");
  const continueBtn = overLay.querySelector(".cont_nue");
  const goToCartBtn = overLay.querySelector("._c");

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

        const image = addToCartBtn.dataset.image;

        const variationItem = document.createElement("div");
        variationItem.classList.add("vr_p");
        variationItem.dataset.valueId = attribute_value_id;
        variationItem.dataset.slug = slug;
        variationItem.dataset.name = productName;

        const key = `${slug}_${attribute_value_id}`;
        const existingItem = cart.find((item) => item.key === key);
        const savedQty = existingItem ? existingItem.quantity : 0;

        if (savedQty > 0) hasAnyQty = true;

        variationItem.innerHTML = `
           <div class="ppry">
                                 <p class="pry_">${attribute_name}: ${value_name}</p>
                                 <div class="_-df">
                                     <p class="pric_">₦ ${Number(
                                       price
                                     ).toLocaleString()}</p>
                                     <p class="old_pri">₦ ${Number(
                                       old_price
                                     ).toLocaleString()}</p>
                                 </div>
                                 <p class="pr12">Few units left</p>
                             </div>

                             <div  class="var_form">
                                 <button type="button" class="inc_b remove_v ${
                                   savedQty > 0 ? "active" : ""
                                 } "  ${savedQty > 0 ? "" : "disabled"}>
                                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                         <path d="M19 11H5V13H19V11Z"></path>
                                     </svg>
                                 </button>

                                 <span id="inc">${savedQty}</span>

                                 <button type="button" class="inc_b incre" id="" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                         <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
                                     </svg></button>
                             </div>
           `;

        variationContainer.appendChild(variationItem);
      });

      variationContainer.addEventListener("click", (e) => {
        const btn = e.target.closest("button");
        if (!btn) return;

        const goToCartBtn = overLay.querySelector("._c");
        const variationItem = btn.closest(".vr_p");
        const valueId = variationItem.dataset.valueId || null;
        const slug = variationItem.dataset.slug;
        const productName = variationItem.dataset.name;
        const quantitySpan = variationItem.querySelector("#inc");
        let quantity = parseInt(quantitySpan.textContent);
        const mCartQuantity = document.querySelector("#mobile_cart_quantity");

        const decrement = variationItem.querySelector(".remove_v");

        const productImg = addToCartBtn.dataset.image;
        const productPrice = parseFloat(addToCartBtn.dataset.price);
        const productOldPrice = parseFloat(addToCartBtn.dataset.old);
        const key = `${slug}_${valueId}`;

        const productBox = document.querySelector(
          `.pro_d_view[data-slug="${slug}"]`
        );

        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        const cartItem = {
          key,
          slug,
          quantity,
          attribute_value_id: parseInt(valueId),
          productName,
          productImg,
          productPrice,
          productOldPrice,
        };

        if (btn.classList.contains("incre")) {
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
          spinner.classList.add("spin", "disp");

          quantitySpan.appendChild(spinner);

          setTimeout(() => {
            quantitySpan.textContent = quantity;

            btn.removeAttribute("disabled", true);
            decrement.removeAttribute("disabled");
            goToCartBtn.removeAttribute("disabled", true);

            btn.classList.remove("updating");
            decrement.classList.remove("updating");
            goToCartBtn.classList.remove("updating");

            if (productBox) {
              if (quantity >= 1 || quantity !== 0) {
                decrement.disabled = false;

                goToCartBtn.classList.remove("disabled");
                goToCartBtn.addEventListener("click", handleGoToCartClick);

                mCartQuantity.style.setProperty("display", "flex", "important");

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
          }, 2500);
        } else if (btn.classList.contains("remove_v")) {
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
                  goToCartBtn.removeEventListener("click", handleGoToCartClick);
                } else if (hasOtherQuantities) {
                  goToCartBtn.addEventListener("click", handleGoToCartClick);
                }
              }
            }, 2500);
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
        goToCartBtn.classList.remove("disabled");
      }
    }
  } else {
    throw new Error(`HTTPS ERROR STATUS ${response.status}`);
  }
}

document.addEventListener("click", (e) => {
  const incrementBtn = e.target.closest(".incBtnVary");
  const decrementBtn = e.target.closest(".decBtnVary");

  if (incrementBtn || decrementBtn) {
    e.preventDefault();
    e.stopPropagation();

    const productBox = e.target.closest(".pro_d_view");
    const slug = productBox?.dataset.slug;

    if (!slug) return;

    // Reopen the variation overlay
    const addToCartBtn = productBox.querySelector(".add_to_cart");
    const productName = addToCartBtn.dataset.name;
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const goToCartBtn = document.querySelector("._c");

    const hasOtherQuantities = cart.some(
      (item) => item.slug === slug && item.quantity > 0
    );

    if (!hasOtherQuantities) {
      goToCartBtn.removeEventListener("click", handleGoToCartClick);
    } else if (hasOtherQuantities) {
      goToCartBtn.addEventListener("click", handleGoToCartClick);
    }

    showVariationOverlay(slug, addToCartBtn, productName);
  }
});

function handleGoToCartClick() {
  window.location.href = "cart.php";
} // ends function handleGoToCartClick

function setupIncrementDecrementListeners() {
  const addToCartBtn = document.querySelectorAll(".add_to_cart");

  addToCartBtn.forEach((addCart) => {
    const increDecBox = document.querySelectorAll(".incre_decre");
    increDecBox.forEach((box) => {
      const spinner = document.createElement("span");
      const slug = addCart.dataset.slug;

      const incrementBtn = box?.querySelector(".increment");
      const decrementBtn = box?.querySelector(".decrement");
      const quantitySpan = box?.querySelector("span");

      if (!incrementBtn || !decrementBtn || !addToCartBtn || !quantitySpan)
        return;

      const productName = addCart.dataset.name;

      // Prevent multiple listeners
      incrementBtn.replaceWith(incrementBtn.cloneNode(true));
      decrementBtn.replaceWith(decrementBtn.cloneNode(true));

      const newIncrementBtn = box.querySelector(".increment");
      const newDecrementBtn = box.querySelector(".decrement");

      newIncrementBtn.addEventListener("click", () => {
        newIncrementBtn.setAttribute("disabled", true);
        newDecrementBtn.setAttribute("disabled", true);

        newIncrementBtn.classList.add("updating");
        newDecrementBtn.classList.add("updating");

        quantitySpan.appendChild(spinner);
        spinner.classList.add("spin2");

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
            slug,
            attribute_value_id: null,
            quantity: newQty,
            name: addCart.dataset.name,
            price: parseFloat(addCart.dataset.price),
            oldPrice: parseFloat(addCart.dataset.old),
            image: addCart.dataset.image,
          };

          addToLocalCart(item);
          sweetAlert(productName, "Quantity has been updated successfully");
        }, 2500);
      });

      newDecrementBtn.addEventListener("click", () => {
        newIncrementBtn.setAttribute("disabled", true);
        newDecrementBtn.setAttribute("disabled", true);

        newIncrementBtn.classList.add("updating");
        newDecrementBtn.classList.add("updating");

        quantitySpan.appendChild(spinner);
        spinner.classList.add("spin2");

        let currentQty = parseInt(quantitySpan.textContent.trim()) || 1;

        setTimeout(() => {
          quantitySpan.removeChild(spinner);
          spinner.classList.remove("spin2");

          newIncrementBtn.removeAttribute("disabled");
          newDecrementBtn.removeAttribute("disabled");

          newIncrementBtn.classList.remove("updating");
          newDecrementBtn.classList.remove("updating");

          if (currentQty > 0) {
            currentQty--;
            quantitySpan.textContent = currentQty;

            const item = {
              key: slug,
              slug,
              attribute_value_id: null,
              quantity: currentQty,
              name: addCart.dataset.name,
              price: parseFloat(addCart.dataset.price),
              image: addCart.dataset.image,
            };

            addToLocalCart(item);

            if (currentQty === 0) {
              box.style.display = "none";
              addCart.style.display = "flex";
              addCart.removeAttribute("disabled");
              addCart.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                        <path d="M12.0049 2C15.3186 2 18.0049 4.68629 18.0049 8V9H22.0049V11H20.8379L20.0813 20.083C20.0381 20.6013 19.6048 21 19.0847 21H4.92502C4.40493 21 3.97166 20.6013 3.92847 20.083L3.17088 11H2.00488V9H6.00488V8C6.00488 4.68629 8.69117 2 12.0049 2ZM18.8309 11H5.17788L5.84488 19H18.1639L18.8309 11ZM13.0049 13V17H11.0049V13H13.0049ZM9.00488 13V17H7.00488V13H9.00488ZM17.0049 13V17H15.0049V13H17.0049ZM12.0049 4C9.86269 4 8.1138 5.68397 8.00978 7.80036L8.00488 8V9H16.0049V8C16.0049 5.8578 14.3209 4.10892 12.2045 4.0049L12.0049 4Z">
                                        </path>
                                    </svg><span>add to cart</span>`;

              sweetAlert(productName, " has been removed from your cart");
            } else {
              addCart.setAttribute("disabled", true);

              sweetAlert(
                productName,
                " Quantity has been updated successfully"
              );
            }
          }
        }, 2500); // ends setTimeout function
      });
    });
  });
}

// function  updateInlineCounter
function updateInlineCounter(slug) {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  const productBox = document.querySelector(`.pro_d_view[data-slug="${slug}"]`);
  const addBtn = productBox?.querySelector(".add_to_cart");
  const inlineCounter = productBox?.querySelector(".incre_decre");

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

function formatPrice(price) {
  price = Number(price);
  return price <= 10
    ? price
    : price.toLocaleString("en-NG", { maximumFractionDigits: 0 });
} // ends formatPrice

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
    }, 2000);
  }, 3000);
} // ends function sweetAlert

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

function syncCartWithUI() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  cart.forEach((item) => {
    const productContainer = document.querySelectorAll(
      `.pro_d_view[data-slug="${item.slug}"]`
    );

    if (!productContainer) return;

    productContainer.forEach((pro_con) => {
      const addToCartBtn = pro_con.querySelector(".add_to_cart");
      const incrementDecrementBox = pro_con.querySelector(".incre_decre");
      const quantitySpan = incrementDecrementBox.querySelector("span");

      // Update UI
      addToCartBtn.style.setProperty("display", "none", "important");
      addToCartBtn.setAttribute("disabled", true);
      incrementDecrementBox.style.setProperty("display", "flex", "important");
      quantitySpan.textContent = item.quantity;
    });
  });

  // Reattach increment/decrement logic using helper
  setupIncrementDecrementListeners();
} // ends function syncCartWithUI

async function fetchRecentViewed() {
  const slugs = JSON.parse(localStorage.getItem("recentlyViewed")) || [];
  const wrapperD = document.querySelector("#recently_viewed_wrp");
  const wrapperM = document.querySelector("#mobile_view_page");
  const containerD = document.querySelector("#recently_viewed_p");
  const containerM = document.querySelector("#mobileRecentV");

  if (!slugs || slugs.length === 0) {
    wrapperM.innerHTML = "";
    wrapperD.innerHTML = "";
    wrapperM.style.display = "none";
    wrapperD.style.display = "none";
    return;
  }

  if (!containerD || !containerM) return;

  try {
    const response = await fetch("api/get_recently_viewed.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ slugs }),
    });

    if (response.ok) {
      const data = await response.json();

      if (data.length === 0) {
        wrapperD.innerHTML = "";
        wrapperM.innerHTML = "";

        wrapperD.style.display = "none";
        wrapperM.style.display = "none";

        return;
      }

      containerD.innerHTML = "";
      containerM.innerHTML = "";

      const html = data
        .map(
          (products) => `
        
         <a href="product.php?id=${products.id}&name=${products.slug}">
                                <div class="product-garllery">
                                    <img src="${products.image}" alt="">
                                    <div class="name">
                                        <p>${products.name}</p>
                                        <div class="price"><strong>&#x20A6; ${formatPrice(
                                          products.price
                                        )}</strong></div>
                                        <div class="old-price"><del><small>&#x20A6; ${formatPrice(
                                          products.old_price
                                        )}</small></del></div>
                                    </div>
                                </div>
                            </a>

       `
        )
        .join("");

      containerD.innerHTML = html;
      containerM.innerHTML = html;

      const item1 = containerD.querySelectorAll("a");
      const btnsCon = containerD.closest(".carousel-slider-container--");

      const btns = btnsCon.querySelectorAll("button");

      btns.forEach((btn) => {
        if (item1.length >= 7) {
          btn.classList.add("act");
        } else {
          btn.classList.remove("act");
          btn.style.display = "none";
        }
      });

      scrollSlider(containerD, btns);
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  } catch (error) {}
}

async function likedProduct() {
  const slug = new URLSearchParams(window.location.search).get("name");

  if (!slug) return;

  try {
    const response = await fetch(`api/getRelatedProduct.php?slug=${slug}`);

    if (response.ok) {
      const data = await response.json();
      const relatedProducts = data.related || data;

      if (relatedProducts) {
        const container = document.querySelector(".dRelated");
        const mWrapper = document.querySelector("#may_like_mobile");
        const mContainer = mWrapper.querySelector("#may_likeMobile");
        const currentSells = document.querySelector(".sell_curren_prod");

        container.innerHTML = "";
        mContainer.innerHTML = "";
        currentSells.innerHTML = "";

        relatedProducts.forEach((item) => {
          let card = `
             <a href="product.php?id=${item.id}&name=${item.slug}">
                                    <div class="product-garllery">
                                        <img src="${item.image}" alt="">
                                        <div class="name">
                                            <p>${item.name}</p>
                                            <div class="price"><strong>&#x20A6; ${formatPrice(
                                              item.price
                                            )}</strong></div>
                                            <div class="old-price"><del><small>&#x20A6; ${formatPrice(
                                              item.old_price
                                            )}</small></del></div>
                                        </div>
                                    </div>
                                </a>
        `;

          container.innerHTML += card;
          mContainer.innerHTML += card;
        });

        relatedProducts.splice(0, 2).forEach((item) => {
          let cardC = `
                          <a href="product.php?id=${item.id}&name=${item.slug}">
                                <div class="produc_container">
                                    <img src="${item.image}" alt="">
                                    <div class="descp">
                                        <span id="name_p"> ${item.name} </span>
                                        <span id="product_price">&#x20A6; ${formatPrice(
                                          item.price
                                        )}</span>
                                    </div>
                                </div>
                            </a>
`;

          currentSells.innerHTML += cardC;
        });

        const item = container.querySelectorAll("a");
        const btnsCon = container.closest(".carousel-slider-container--");

        const btns = btnsCon.querySelectorAll("button");

        btns.forEach((btn) => {
          if (item.length >= 7) {
            btn.classList.add("act");
          } else {
            btn.classList.remove("act");
            btn.style.display = "none";
          }
        });

        scrollSlider(container, btns);
      }
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  } catch (error) {
    console.error("error while fething related products: ", error);
  }
}

function scrollSlider(container, btns) {
  const slider = container.querySelectorAll("a");

  if (!slider.length) return;
  const sliderWidth = slider[0].offsetWidth;

  function updateBtn() {
    const atStart = container.scrollLeft <= 0;
    const atEnd =
      Math.ceil(container.scrollLeft + container.clientWidth) >=
      container.scrollWidth;

    btns.forEach((btn) => {
      if (btn.id === "prev-slide") {
        btn.disabled = atStart;
        btn.classList.toggle("disabledBtn", atStart);
        if (atStart) {
          btn.classList.remove("strong_active_btn");
        } else {
          btn.classList.add("strong_active_btn");
        }
      } else if ((btn.id = "next-slide")) {
        btn.disabled = atEnd;
        btn.classList.toggle("disabledBtn", atEnd);
        if (atEnd) {
          btn.classList.remove("strong_active_btn");
        } else {
          btn.classList.add("strong_active_btn");
        }
      }
    });
  }

  btns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const scrollAmount = btn.id === "next-slide" ? sliderWidth : -sliderWidth;
      container.scrollBy({ left: scrollAmount, behavior: "smooth" });

      // Slight delay to allow scroll to update
      setTimeout(updateBtn, 300);
    });
  }); // ends foreach loop

  // Update button states on scroll too
  container.addEventListener("scroll", updateBtn);
  updateBtn(); // initial call
}


function locationSelection(defaultLGA = "Ikeja") {
  const stateSelects = document.querySelectorAll(".state_locale");
  const lgaSelects = document.querySelectorAll(".select-lga");

  if (!stateSelects.length || !lgaSelects.length) return;

  // Populate LGAs for a given state and dropdown
  async function populateLGAs(stateSelect, lgaDropdown, defaultLGA) {
    try {
      const stateId = stateSelect.value;
      if (!stateId) return;

      const response = await fetch(`api/fetchLGAs.php?state=${stateId}`);
      if (!response.ok) throw new Error(`HTTP ERROR: ${response.status}`);

      const data = await response.json();
      if (!Array.isArray(data)) return;

      // Reset dropdown
      lgaDropdown.innerHTML = '<option value="">-- Select LGA --</option>';

      // Fill LGAs
      data.forEach((lga) => {
        const option = document.createElement("option");
        option.value = lga;
        option.textContent = lga;
        lgaDropdown.appendChild(option);
      });

      // Apply default only if it exists in the new list
      if (defaultLGA && data.includes(defaultLGA)) {
        lgaDropdown.value = defaultLGA;
      }

      // Fetch delivery options if an LGA is selected
      if (lgaDropdown.value) {
        fetchDeliveryOptions(stateSelect.value, lgaDropdown.value);
      }
    } catch (error) {
      console.error("Error fetching LGAs:", error);
    }
  }

  // Pair state & LGA dropdowns by index
  stateSelects.forEach((stateSelect, index) => {
    const lgaDropdown = lgaSelects[index]; 
    if (!lgaDropdown) return;

    // On state change → load LGAs
    stateSelect.addEventListener("change", () => {
      populateLGAs(stateSelect, lgaDropdown);
    });

    // On page load → preload LGAs
    if (stateSelect.value) {
      populateLGAs(stateSelect, lgaDropdown, defaultLGA);
    }

    // On LGA change → fetch delivery options
    lgaDropdown.addEventListener("change", () => {
      if (lgaDropdown.value) {
        fetchDeliveryOptions(stateSelect.value, lgaDropdown.value);
      }
    });
  });
}


async function fetchDeliveryOptions(stateSelect, lga) {
  try {
    const response = await fetch(
      `api/fetchDeliveryOptions.php?state=${stateSelect}&lga=${lga}`
    );
    if (response.ok) {
      const data = await response.json();

      if (!Array.isArray(data) || !data.length) {
        console.error("No delivery options found");
        return;
      }

      if (data) {
        const container = document.querySelectorAll(".data_info_b");
        if (!container.length) return;

        // Date calculation helper
        const formatDate = (daysToAdd) => {
          const d = new Date();
          d.setDate(d.getDate() + daysToAdd);
          return d.toLocaleDateString("en-GB", {
            day: "numeric",
            month: "long",
          });
        };

        container.forEach((item) => {
          const wrapper = document.querySelectorAll(".sect_p");
          wrapper.forEach((wrp) => {
            item.classList.add("blur");
            const spinner = document.createElement("div");
            spinner.classList.add("loader");

            wrp.appendChild(spinner);

            setTimeout(() => {
              wrp.removeChild(spinner);
              item.classList.remove("blur");

              item.innerHTML = "";
              data.forEach((option) => {
                const minDate = formatDate(option.min_days);
                const maxDate = formatDate(option.max_days);

                // Format option type for display
                const label =
                  option.option_type === "pickup_station"
                    ? "Pickup Station"
                    : "Door Delivery";

                item.innerHTML += `<article class="_gf_p">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40" class="base" fill="currentColor">
                                                <path d="M5.50045 20C6.32888 20 7.00045 20.6715 7.00045 21.5C7.00045 22.3284 6.32888 23 5.50045 23C4.67203 23 4.00045 22.3284 4.00045 21.5C4.00045 20.6715 4.67203 20 5.50045 20ZM18.5005 20C19.3289 20 20.0005 20.6715 20.0005 21.5C20.0005 22.3284 19.3289 23 18.5005 23C17.672 23 17.0005 22.3284 17.0005 21.5C17.0005 20.6715 17.672 20 18.5005 20ZM2.17203 1.75732L5.99981 5.58532V16.9993L20.0005 17V19H5.00045C4.44817 19 4.00045 18.5522 4.00045 18L3.99981 6.41332L0.757812 3.17154L2.17203 1.75732ZM16.0005 2.99996C16.5527 2.99996 17.0005 3.44768 17.0005 3.99996L16.9998 5.99932L19.9936 5.99996C20.5497 5.99996 21.0005 6.45563 21.0005 6.99536V15.0046C21.0005 15.5543 20.5505 16 19.9936 16H8.0073C7.45123 16 7.00045 15.5443 7.00045 15.0046V6.99536C7.00045 6.44562 7.4504 5.99996 8.0073 5.99996L10.9998 5.99932L11.0005 3.99996C11.0005 3.44768 11.4482 2.99996 12.0005 2.99996H16.0005ZM11.0005 7.99996H10.0005V14H11.0005V7.99996ZM18.0005 7.99996H17.0005V14H18.0005V7.99996ZM15.0005 4.99996H13.0005V5.99996H15.0005V4.99996Z">
                                                </path>
                                            </svg>
                                            <div class="_cbet_way">
                                                <div class="cl_1">
                                                    <h4>${label}</h4>
                                                    <button type="button" class="del" id="dilt_1_te">details</button>
                                                </div>
                                                <div class="cl_2">
                                                    <div class="cl_3">Delivery Fees <em>₦ ${formatPrice(
                                                      option.fee
                                                    )}</em></div>
                                                    <div class="cl_3">
                                                        Arriving at pickup station between
                                                        <em>${minDate} </em> &amp; <em>${maxDate} </em> when you order
                                                        within next <em>28mins</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>`;
              });
            }, 2000);
          });
        });
      }
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  } catch (error) {
    console.error("error while fetching delivery options", error);
  }
}
