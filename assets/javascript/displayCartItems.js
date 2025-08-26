window.addEventListener("DOMContentLoaded", async () => {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  const emptyCartContainer = document.querySelector(".empty_cart_box");
  const cartPContainer = document.querySelector(".product_added_container");

  if (!emptyCartContainer) return;

  // check if cart is empty
  if (cart.length === 0) {
    emptyCartContainer.style.display = "block";
    return;
  }

  emptyCartContainer.style.setProperty("display", "none", "important");
  cartPContainer.style.setProperty("display", "flex");

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

          wrapper.innerHTML += `  <article class="_product_added dr" id="product_c">
                        <a href="product_check.php" id="core">
                            <div class="img-c">
                                <img src="${product.image}" alt="" width="72" height="72">
                            </div>

                            <div class="main_">
                                <h3 class="name">${product.name}</h3>
                                <p class="status">in stock</p>
                                <p class="status_"><span id="label">Seller :</span> Aba Price</p>
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
                                    <div class="srg_h">${discountPercent > 0 ? `${discountPercent}%` : ""}</div>
                                </div>
                            </div>
                        </a>
                        <section class="bt">
                            <button class="btns_"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                    height="24" fill="currentColor">
                                    <path
                                        d="M7 4V2H17V4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7ZM6 6V20H18V6H6ZM9 9H11V17H9V9ZM13 9H15V17H13V9Z">
                                    </path>
                                </svg>Remove</button>

                            <div class="-mal">
                                <button id="" class="_qty inactive" value="" type="button" disabled="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        style="fill: rgba(0, 0, 0, 1);">
                                        <path d="M5 11h14v2H5z"></path>
                                    </svg>
                                </button>
                                <span class="incre">${product.quantity}</span>
                                <button id="" class="_qty" type="button">
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
