window.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.querySelector("#search_product1");
  const searchBtn = document.querySelector("#search_b");
  const container = document.querySelector(".container_searched_product");

  // mobile search
  const mobileSearchInput = document.querySelector("#search_product_mob");
  const mobileSearchBtn = document.querySelector("#search_mob");

  const searchedProduct = document.querySelector(".searched_product");
  let typingTimer;

  const searchProducts = async () => {
    const query = searchInput.value.trim();

    if (query === "") {
      container.innerHTML = "";

      $(".search_product_container").fadeOut();
      return;
    }

    // show loading message
    container.innerHTML =
      " <div class='spinner-wrapper'> <div class='spinner'> </div><div class='spinner-text'>Loading.....</div></div>";

    try {
      const response = await fetch(
        `api/get_products.php?search=${encodeURIComponent(query)}`
      );
      const products = await response.json();

      container.innerHTML = "";

      if (products.length === 0) {
        container.innerHTML = "<p> No matching products found. </p>";
        return;
      }

      products.forEach((product) => {
        container.innerHTML += `
        
         <a href="product.php?id=${encodeURIComponent(
           product.productId
         )}&name=${encodeURIComponent(product.productName)}">
                <div class="container_PD">

                    <div class="container_img_ser">
                        <img src="${product.productImgSrc}" alt="">
                    </div>

                    <div class="container_product_if">
                        <h2>${product.productName}</h2>
                    </div>

                </div>
            </a>

        `;
      });
    } catch (error) {
      console.error("live search failed " + error);
    }
  };

  const searchProducts2 = async () => {
    const query = mobileSearchInput.value.trim();

    if (query === "") {
      container.innerHTML = "";

      $(".search_product_container").fadeOut();
      return;
    }

    // show loading message
    container.innerHTML =
      " <div class='spinner-wrapper'> <div class='spinner'> </div><div class='spinner-text'>Loading.....</div></div>";

    try {
      const response = await fetch(
        `api/get_products.php?search=${encodeURIComponent(query)}`
      );
      const products = await response.json();

      container.innerHTML = "";

      if (products.length === 0) {
        container.innerHTML = "<p> No matching products found. </p>";
        return;
      }

      products.forEach((product) => {
        container.innerHTML += `
        
         <a href="product.php?id=${encodeURIComponent(
           product.productId
         )}&name=${encodeURIComponent(product.productName)}">
                <div class="container_PD">

                    <div class="container_img_ser">
                        <img src="${product.productImgSrc}" alt="">
                    </div>

                    <div class="container_product_if">
                        <h2>${product.productName}</h2>
                    </div>

                </div>
            </a>

        `;
      });
    } catch (error) {
      console.error("live search failed " + error);
    }
  }; // ends searchProducts2 for mobile

  searchInput.addEventListener("input", () => {
    clearTimeout(typingTimer);

    typingTimer = setTimeout(() => {
      $(".search_product_container").fadeIn().css({ display: "flex" });

      searchProducts();
    }, 400);
  });

  searchBtn.addEventListener("click", () => {
    searchedProduct.style.top = "160px";
    $(".search_product_container").fadeIn().css({ display: "flex" });
    searchProducts();
  });

  mobileSearchInput.addEventListener("input", () => {
    clearTimeout(typingTimer);

    typingTimer = setTimeout(() => {
      $(".search_product_container").fadeIn().css({ display: "flex" });
      searchProducts2();
    }, 400);
  });

  mobileSearchBtn.addEventListener("click", () => {
    $(".search_product_container").fadeIn().css({ display: "flex" });
    searchProducts2();
  });

  document.querySelector("#close_btn").addEventListener("click", () => {
    $(".search_product_container").fadeOut();
    container.innerHTML = "";
  });

  $(".close_btn_mobile").click(function () {
    $(".search_product_container").fadeOut();
    container.innerHTML = "";
  });
  
});
