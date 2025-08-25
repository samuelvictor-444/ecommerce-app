window.addEventListener("DOMContentLoaded", () => {
  function formatPrice(price) {
    price = Number(price);
    return price <= 10
      ? price
      : price.toLocaleString("en-NG", { maximumFractionDigits: 0 });
  } // ends formatPrice

  async function fetchRecentlyViewed() {
    const slugs = JSON.parse(localStorage.getItem("recentlyViewed")) || [];
    const container = document.querySelector("#recently_viewed");

    if (!slugs || slugs.length === 0) {
      container.innerHTML = "";
      container.style.display = "none";

      return;
    }

    const response = await fetch("api/get_recently_viewed.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ slugs }),
    });

    if (response.ok) {
      const data = await response.json();

      if (data.length === 0) {
        container.innerHTML = "";
        container.style.display = "none";
        return;
      }

      const wrapper = document.querySelector("#wrp_recent");
      wrapper.innerHTML = "";

      const html = data
        .map(
          (product) => `
          
                <div class="product_cate_p">
                 <a href="product.php?id=${product.id}&name=${product.slug}">
                    <div class="product_img_">
                        <img src="${product.image}" alt="${product.name}">
                    </div>
                    <div class="description_p">
                        <h2 class="product_name">${product.name}</h2>
                        <p class="product_price">₦${formatPrice(
                          product.price
                        )}</p>
                        <span class="old_price_sub"><small>₦${formatPrice(
                          product.old_price
                        )}</small></span>
                    </div>
                      </a>
                </div>
          
      `
        )
        .join("");

      wrapper.innerHTML = html;

      const items = wrapper.querySelectorAll(".product_cate_p");

      if (items.length >= 7) {
        const div = document.createElement("div");
        div.className = "carousal";

        const btn1 = document.createElement("button");
        btn1.className = "btn_btn";
        btn1.id = "left";
        btn1.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                </path>
                            </svg>`;

        const btn2 = document.createElement("button");
        btn2.className = "btn_btn";
        btn2.id = "right";
        btn2.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                <path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>`;

        div.appendChild(btn1);
        div.appendChild(btn2);

        container.appendChild(div);

        const btns = div.querySelectorAll("button");

        scrollSlider(wrapper, btns);
      }
      
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  }

  function scrollSlider(container, btns) {
    const slider = container.querySelectorAll(".product_cate_p");

    if (!slider.length) return;
    const sliderWidth = slider[0].offsetWidth;

    function updateBtn() {
      const atStart = container.scrollLeft <= 0;
      const atEnd =
        Math.ceil(container.scrollLeft + container.clientWidth) >=
        container.scrollWidth;

      btns.forEach((btn) => {
        if (btn.id === "left") {
          btn.disabled = atStart;
          btn.classList.toggle("disabledBtn", atStart);
          if (atStart) {
            btn.classList.remove("strong_active_btn");
          } else {
            btn.classList.add("strong_active_btn");
          }
        } else if ((btn.id = "right")) {
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
        const scrollAmount = btn.id === "right" ? sliderWidth : -sliderWidth;
        container.scrollBy({ left: scrollAmount, behavior: "smooth" });

        // Slight delay to allow scroll to update
        setTimeout(updateBtn, 300);
      });
    }); // ends foreach loop

    // Update button states on scroll too
    container.addEventListener("scroll", updateBtn);
    updateBtn(); // initial call 

  }

  fetchRecentlyViewed();
});
