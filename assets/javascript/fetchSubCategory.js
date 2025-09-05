window.addEventListener("DOMContentLoaded", () => {
  async function fetchAllSubCategory() {
    const container = document.querySelector(".container_sub_cate");
    const container2 = document.querySelector(".wrapp_re");

    if (!container || !container2) {
      console.error("container not found");
      return;
    }

    const slug = new URLSearchParams(window.location.search).get("category");

    if (!slug) {
      console.error("category not found");
      return;
    }

    try {
      const response = await fetch(`api/getSubCategories.php?slug=${slug}`);
      const subCategories = await response.json();

      if (!response.ok) throw new Error(`HTTP ERROR STATUS ${response.status}`);
      if (!Array.isArray(subCategories))
        throw new Error("Invalid response format");

      if (subCategories.length === 0) {
        const wrapper = document.querySelector(".cate_container_product");
        if (wrapper) wrapper.style.display = "none";
        if (container2) container2.style.display = "none";

        const wrappers = document.querySelector(".wrapper");
        const bb = wrappers.querySelector(".bb");

        wrappers.style.display = "none";
        bb.style.display = "none";
        return;
      }

      container.innerHTML = "";

      subCategories.forEach((subCategory) => {
        if (!subCategory.slug || !subCategory.name) return;

        container.innerHTML += `
          <a href="subCategory.php?subCate=${encodeURIComponent(
            subCategory.slug
          )}">
            <div class="cate_cont_d">
              <img src="${subCategory.sub_cate_logo}" alt="">
              <div class="text_cont">
                <p>${subCategory.name}</p>
              </div>
            </div>
          </a>
        `;

        container2.innerHTML += ` <a href="subCategory.php?subCate=${encodeURIComponent(
          subCategory.slug
        )}">${subCategory.name}</a>

      `;
      });

      const bb = document.querySelector(".bb");

      const btns = document.querySelectorAll(".btns_cate");
      const btns2 = bb.querySelectorAll(".related_ser");

      const shouldShowBtns = subCategories.length > 8;
      const shouldShowBtns2 = subCategories.length > 8;

      btns.forEach((btn) => {
        btn.style.display = shouldShowBtns ? "flex" : "none";
        btn.disabled = false;
        btn.classList.remove("disabledBtn");
      });

      btns2.forEach((btn) => {
        btn.style.display = shouldShowBtns2 ? "flex" : "none";
        btn.disabled = false;
        btn.classList.remove("disabledBtn");
      });

      if (shouldShowBtns) {
        setupSlider(container, btns);
      }

      if (shouldShowBtns2) {
        setupSlider2(container2, btns2);
      }
    } catch (error) {
      console.error("Error occurred while fetching subcategories: ", error);
    }
  }

  function setupSlider(container, btns) {
    const slides = container.querySelectorAll(".cate_cont_d");
    if (!slides.length) return;

    const slideWidth = slides[0].offsetWidth;

    function updateBtnStates() {
      const atStart = container.scrollLeft <= 0;
      const atEnd =
        Math.ceil(container.scrollLeft + container.clientWidth) >=
        container.scrollWidth;

      btns.forEach((btn) => {
        if (btn.id === "left") {
          btn.disabled = atStart;
          btn.classList.toggle("disabledBtn", atStart);
        } else if (btn.id === "right") {
          btn.disabled = atEnd;
          btn.classList.toggle("disabledBtn", atEnd);
        }
      });
    }

    // Attach click listeners
    btns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const scrollAmount = btn.id === "right" ? slideWidth : -slideWidth;
        container.scrollBy({ left: scrollAmount, behavior: "smooth" });

        // Slight delay to allow scroll to update
        setTimeout(updateBtnStates, 300);
      });
    });

    // Update button states on scroll too
    container.addEventListener("scroll", updateBtnStates);

    updateBtnStates(); // initial call
  }

  function setupSlider2(container, btns) {
    const slides = container.querySelectorAll("a");
    if (!slides.length) return;

    const slideWidth = slides[0].offsetWidth;

    function updateBtnStates() {
      const atStart = container.scrollLeft <= 0;
      const atEnd =
        Math.ceil(container.scrollLeft + container.clientWidth) >=
        container.scrollWidth;

      btns.forEach((btn) => {
        if (btn.id === "left") {
          btn.disabled = atStart;
          btn.classList.toggle("disabledBtn", atStart);
          if (atStart) {
            btn.classList.add("strong_active");
            btn.classList.remove("idx");
          } else {
            btn.classList.add("idx");
          }
        } else if (btn.id === "right") {
          btn.disabled = atEnd;
          btn.classList.toggle("disabledBtn", atEnd);
          if (atEnd) {
            btn.classList.remove("idx");
            btn.classList.add("strong_active");
          } else {
            btn.classList.add("idx");
            btn.classList.add("strong_active");
          }
        }
      });
    }

    // Attach click listeners
    btns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const scrollAmount = btn.id === "right" ? slideWidth : -slideWidth;
        container.scrollBy({ left: scrollAmount, behavior: "smooth" });

        // Slight delay to allow scroll to update
        setTimeout(updateBtnStates, 300);
      });
    });

    // Update button states on scroll too
    container.addEventListener("scroll", updateBtnStates);

    updateBtnStates(); // initial call
  }

  fetchAllSubCategory();

  async function fetchLimitedSubCategoryAndCategoryProductByTag() {
    function formatPrice(price) {
      price = Number(price);
      return price <= 10
        ? price
        : price.toLocaleString("en-NG", { maximumFractionDigits: 0 });
    }

    const container = document.querySelector("#categoryProductsByTag");
    const slug = new URLSearchParams(window.location.search).get("category");
    if (!slug || !container) return;

    try {
      const [adsRes, tagRes] = await Promise.all([
        fetch(`api/getSubCategories.php?slugB=${slug}`),
        fetch(`api/getProductsByTag.php?category=${slug}`),
      ]);

      const adsData = await adsRes.json();
      const tagData = await tagRes.json();

      let adsIndex = 0;
      let tagIndex = 0;

      // Keep looping until we exhaust both ads and tag data
      while (adsIndex < adsData.length || tagIndex < tagData.length) {
        // Display 2 ads
        if (adsIndex < adsData.length) {
          const adsDiv = document.createElement("div");
          adsDiv.classList.add("ads_cate");

          let adsHTML = "";

          for (let i = 0; i < 2 && adsIndex < adsData.length; i++, adsIndex++) {
            const ad = adsData[adsIndex];
            adsHTML += `
            <div class="container_cate_banner">
              <a href="subCategory.php?subCate=${encodeURIComponent(ad.slug)}">
                <img src="${ad.subCate_banner}" alt="${ad.name || ""}">
              </a>
            </div>

             <div class="container_cate_banner_mobile">
              <a href="subCategory.php?subCate=${encodeURIComponent(ad.slug)}">
                <img src="${ad.mSubCate_banner}" alt="${ad.name || ""}">
              </a>
            </div>
          `;
          }

          adsDiv.innerHTML = adsHTML;
          container.appendChild(adsDiv);
        }

        // Display 1 product tag group
        if (tagIndex < tagData.length) {
          const tag = tagData[tagIndex];
          const tagGroup = document.createElement("div");
          tagGroup.classList.add("category_tag_group");

          let productsHTML = "";
          tag.products.forEach((product) => {
            productsHTML += `
            <a href="product.php?id=${encodeURIComponent(product.id)}&name=${
              product.slug
            }">
              <div class="product_cate_p">
                <div class="product_img_">
                  <img src="${product.image}" alt="">
                </div>
                <div class="description_p">
                  <h2 class="product_name">${product.product_name}</h2>
                  <p class="product_price">&#8358;${formatPrice(
                    product.price
                  )}</p>
                  <span class="old_price_sub"><small>&#8358;${formatPrice(
                    product.old_price
                  )}</small></span>
                </div>
              </div>
            </a>
          `;
          });

          tagGroup.innerHTML = `
          <div class="container_header_cate">
            <h1>${tag.tag_name}</h1>
            <a href="tag.php?slug=${tag.tag_slug}">See All  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                <path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                </path>
            </svg></a>
          </div>
          <div class="container_cate_tag_pro">${productsHTML}</div>
        `;

          container.appendChild(tagGroup);
          tagIndex++;

          if (tag.products.length >= 7) {
            const div = document.createElement("div");
            div.classList.add("carousal");

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

            tagGroup.appendChild(div);

            const shouldShowBtn = tag.products.length >= 7;

            const btns = tagGroup.querySelectorAll(".carousal button");

            btns.forEach((btn) => {
              btn.style.display = shouldShowBtn ? "flex" : "none";
              btn.disabled = false;
              btn.classList.remove("disabledBtn");
            });

          const wrapper = tagGroup.querySelector(".container_cate_tag_pro");

            if (shouldShowBtn) {

              setupSlider2(wrapper , btns)
            }
          }
        }
      }
    } catch (error) {
      console.error(
        "Error occurred while fetching category tag product and sub category",
        error
      );
    }
  }

  fetchLimitedSubCategoryAndCategoryProductByTag();

  async function fetchLimitedSubCategory() {
    const container = document.querySelector(".sub_cate_sec");

    const slug = new URLSearchParams(window.location.search).get("category");

    if (!container || !slug) {
      console.error("container not found  or category not found ");
      return;
    }

    try {
      const response = await fetch(`api/getSubCategories.php?slugC=${slug}`);

      if (response.ok) {
        const data = await response.json();

        if (!Array.isArray(data)) {
          console.error("invalid response format");
          return;
        }

        if (data.length === 0) {
          if (container) container.style.display = "none";
        }

        container.innerHTML = "";
        data.slice(0, 7).forEach((item) => {
          const a = document.createElement("a");
          a.href = `catelog_listing.php?subCate=${encodeURIComponent(item.slug)}`;

          const span = document.createElement("span");
          span.innerText = item.name;

          a.appendChild(span);
          container.appendChild(a);
        });
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.error("error occured while fetching side sub category " + error);
    }
  } // ends async function fetchLimitedSubCategory

  fetchLimitedSubCategory();

 

});
