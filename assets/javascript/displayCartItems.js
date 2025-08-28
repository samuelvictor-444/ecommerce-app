window.addEventListener("DOMContentLoaded", async () => {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  const emptyCartContainer = document.querySelector(".empty_cart_box");
  const cartPContainer = document.querySelector(".product_added_container");
  const checkOutMobile = document.querySelector(".mobile_check_out");

  const counterDisplay = document.querySelector(".counter_");

  if (!emptyCartContainer) return;

  // check if cart is empty
  if (cart.length === 0) {
    checkOutMobile.style.display = "none";
    emptyCartContainer.style.display = "block";
    document.querySelector(".body_container_wrapper").style.marginBottom =
      "0px";

    return;
  }

  document.querySelector(".body_container_wrapper").style.marginBottom =
    "100px";

  // count total quantity of items in the cart
  let totalCount = cart.length;

  emptyCartContainer.style.setProperty("display", "none", "important");
  cartPContainer.style.setProperty("display", "flex");

  if (counterDisplay) {
    counterDisplay.textContent = `Cart (${totalCount})`;
  }

  try {
    const response = await fetch("api/getCartDetails.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(cart),
    });

    if (response.ok) {
      const products = await response.json();

      if (products) {
        const wrapper = document.querySelector(".added_cart");
        let total = 0;
        const totalP = document.querySelectorAll(".totalP");

        wrapper.innerHTML = "";

        products.forEach((product) => {
          const subTotal = product.price * product.quantity;
          total += subTotal;

          const price = Number(product.price);
          const oldPrice = Number(product.oldPrice);

          const discountAmount = oldPrice - price;
          const discountPercent =
            oldPrice > 0 ? Math.round((discountAmount / oldPrice) * 100) : 0;

          let variationHTML = "";
          if (product.variation && product.variationName) {
            variationHTML = `<p id="varya"> <span id="vN"> ${product.variationName}:<span id="v_V"> ${product.variation}</p>`;
          }

          $valueId = product.attrId;

          wrapper.innerHTML += `
          
          <article class="_product_added dr" id="product_c" data-value="${
            $valueId ? `${$valueId}` : ""
          }" data-name="${product.name}"  data-slug="${product.slug}">
                        <a href="product.php?id=${product.id}&name=${
            product.slug
          }" id="core">
                            <div class="img-c">
                                <img src="${
                                  product.image
                                }" alt="" width="72" height="72">
                            </div>

                            <div class="main_">
                                <h3 class="name">${product.name}</h3>
                                ${variationHTML}
                                <p class="status">in stock</p>
                                <p id="unit_left">Few uints left</p>
                                <div class="ft"><img src="../images/crat.png" alt=""></div>
                            </div>

                            <div class="sd_">
                                <div class="price_"> &#x20A6;${formatPrice(
                                  product.price
                                )}</div>
                                <div class="src_pr">
                                    <div class="old_p">&#x20A6; ${formatPrice(
                                      product.oldPrice
                                    )}</div>
                                    <div class="srg_h">${
                                      discountPercent > 0
                                        ? `${discountPercent}%`
                                        : ""
                                    }</div>
                                </div>
                            </div>
                        </a>
                        <section class="bt">
                            <button class="btns_ removeItem">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M600-240v-80h160v80H600Zm0-320v-80h280v80H600Zm0 160v-80h240v80H600ZM120-640H80v-80h160v-60h160v60h160v80h-40v360q0 33-23.5 56.5T440-200H200q-33 0-56.5-23.5T120-280v-360Zm80 0v360h240v-360H200Zm0 0v360-360Z"/></svg>
                            Remove</button>

                            <div class="-mal">
                                <button id="decrement" class="_qty decrement" value="" type="button"   ${
                                  product.quantity > 1 ? "" : "disabled"
                                }>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: rgba(0, 0, 0, 1);">
                                        <path d="M5 11h14v2H5z"></path>
                                    </svg>
                                </button>
                                <span class="incre">${product.quantity}</span>
                                <button id="increment" class="_qty increment" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: rgba(0, 0, 0, 1);">
                                        <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                    </svg>
                                </button>
                            </div>
                        </section>
                    </article>`;

          totalP.forEach((item) => {
            item.innerHTML = `&#x20A6;` + " " + formatPrice(total);
          });

          document.dispatchEvent(new Event("cart"));
        });
      }
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  } catch (error) {
    console.error("error fetching cart products", error);
  }

  function formatPrice(price) {
    price = Number(price);
    return price <= 10
      ? price
      : price.toLocaleString("en-NG", { maximumFractionDigits: 0 });
  } // ends formatPrice
});
