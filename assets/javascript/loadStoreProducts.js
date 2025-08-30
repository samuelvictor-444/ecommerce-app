window.addEventListener("DOMContentLoaded", (e) => {
  e.preventDefault();

  function formatPrice(price) {
    price = Number(price);
    return price <= 10
      ? price
      : price.toLocaleString("en-NG", { maximumFractionDigits: 0 });
  } // ends formatPrice

  async function loadProduct1() {
    try {
      const response = await fetch("api/get_products.php?category=mystore");
      const products = await response.json();

      const container = document.querySelector("#store_1");

      products.slice(0, 7).forEach((product) => {
        container.innerHTML += `
          <a href="product.php?id=${encodeURIComponent(
            product.productId
          )}&name=${encodeURIComponent(product.productSlug)}">
                    <div class="product_store_">
                        <div class="pro_img">
                            <img src="${product.productImgSrc}" alt="">
                        </div>
                        <div class="container_pro_info">
                            <h2 class="prod_name">${product.productName}</h2>
                            <p class="price">&#8358;${formatPrice(
                              product.productPrice
                            )}</p>
                            <span class="old_p"><small><del>&#8358;${formatPrice(
                              product.productOldPrice
                            )}</del></small></span>
                        </div>
                    </div>
                </a>

        `;
      });
    } catch (error) {
      console.error(error + "error occur while fetching product");
    }
  } // ends async fuction loadProduct1

  loadProduct1(); // call to the async function loadProduct1

  async function loadProduct2() {
    try {
      const response = await fetch("api/get_products.php?category=neiva");
      const products = await response.json();

      const container = document.querySelector("#store_2");

      products.slice(0, 7).forEach((product) => {
        container.innerHTML += `
        
          <a href="product.php?id=${encodeURIComponent(
            product.productId
          )}&name=${encodeURIComponent(product.productSlug)}">
                    <div class="product_store_">
                        <div class="pro_img">
                            <img src="${product.productImgSrc}" alt="">
                        </div>
                        <div class="container_pro_info">
                            <h2 class="prod_name">${product.productName}</h2>
                            <p class="price">&#8358;${formatPrice(
                              product.productPrice
                            )}</p>
                            <span class="old_p"><small><del>&#8358;${formatPrice(
                              product.productOldPrice
                            )}</del></small></span>
                        </div>
                    </div>
                </a>

        `;
      });
    } catch (error) {
      console.error(error + "error occur while fetching product");
    }
  } // ends async fuction loadProduct2

  loadProduct2(); // call to the async function loadProduct2
});
