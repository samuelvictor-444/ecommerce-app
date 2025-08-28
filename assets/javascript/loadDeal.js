window.addEventListener("DOMContentLoaded", async () => {
  function formatPrice(price) {
    price = Number(price);
    return price <= 10
      ? price
      : price.toLocaleString("en-NG", { maximumFractionDigits: 0 });
  } // ends formatPrice

  try {
    const response = await fetch("api/get_products.php?category=today_deal");
    const products = await response.json();

    const productContainer = document.querySelector(".container_products");

    products.forEach((product) => {
      const price = Number(product.productPrice);
      const oldPrice = Number(product.productOldPrice);

      const discountAmount = oldPrice - price;
      const discountPercent =
      oldPrice > 0 ? Math.round((discountAmount / oldPrice) * 100) : 0;

      const div = document.createElement("div");
      div.classList = "container_pro";

      const a = document.createElement("a");
      a.href = `product.php?id=${encodeURIComponent(product.productId)}&name=${
        product.productName
      }`;

      const productImgDiv = document.createElement("div");
      productImgDiv.classList = "product_img";

      const productImg = document.createElement("img");
      productImg.src = product.productImgSrc;

      const productInfoDiv = document.createElement("div");
      productInfoDiv.classList = "product_info";

      const productName = document.createElement("p");
      productName.classList = "product_name";
      productName.innerText = product.productName;

      const productPrice = document.createElement("p");
      productPrice.classList = "product_price";
      productPrice.innerHTML = `<strong>&#8358;${formatPrice(
        product.productPrice
      )}</strong>`;

      const productOldPrice = document.createElement("p");
      productOldPrice.classList = "old_price";
      productOldPrice.innerHTML = `<del>&#8358;${formatPrice(product.productOldPrice)}</del>  `;

      const discount = document.createElement("p");
      discount.classList = "old_price";
      discount.id = "discount_";
      discount.innerHTML = `${discountPercent > 0 ? `<span>Save ₦${formatPrice(discountAmount)} (${discountPercent}%)</span>` : ''}`;

      productImgDiv.appendChild(productImg);

      productInfoDiv.appendChild(productName);
      productInfoDiv.appendChild(productPrice);
      productInfoDiv.appendChild(productOldPrice);
      productInfoDiv.appendChild(discount)

      a.appendChild(productImgDiv);
      a.appendChild(productInfoDiv);

      div.appendChild(a);

      productContainer.appendChild(div);
    });
  } catch (error) {
    console.log(error + " while fetching today deal product ");
  }
});
