window.addEventListener("DOMContentLoaded", async () => {

  function formatPrice(price) {
    price = Number(price);
    return price <= 10
      ? price
      : price.toLocaleString("en-NG", { maximumFractionDigits: 0 });
  } // ends formatPrice


  try {
    const response = await fetch("api/get_products.php?category=nike");
    const products = await response.json();

    const container = document.querySelector("#product2_id");

    products.slice(0 , 7).forEach((item) => {
      const  price = Number(item.productPrice);
      const  oldPrice = Number(item.productOldPrice);

      const discountAmount = oldPrice - price;
      const discountPercent = oldPrice > 0 ? Math.round((discountAmount / oldPrice) * 100) : 0;

      container.innerHTML += `

             <a href="product.php?id=${encodeURIComponent(item.productId)}&name=${item.productName}">
                    <div class="product_c">
                        <div class="img_p">
                            <img src="${item.productImgSrc}" alt="">
                        </div>

                        <h3 class="pr_name">${item.productName}</h3>

                        <div class="price">
                            <h2 class="p">₦${ formatPrice (item.productPrice)}</h2>
                            <div class="old_p">
                                <p><del>₦${formatPrice(item.productOldPrice)}</del></p>
                                 ${discountPercent > 0 ? `<div class="discount">Save ₦${formatPrice(discountAmount)} (${discountPercent}%)</div>` : ''}
                            </div>
                        </div>

                    </div>
                </a>

        `;

       
    });
  } catch (error) {
    console.error(error + " while fetching products");
  }
});
