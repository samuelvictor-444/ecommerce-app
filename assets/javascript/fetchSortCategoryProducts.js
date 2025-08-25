window.addEventListener("DOMContentLoaded", async () => {
  function formatPrice(price) {
    price = Number(price);
    return price <= 10
      ? price
      : price.toLocaleString("en-NG", { maximumFractionDigits: 0 });
  } // ends formatPrice

  function displaymobileSort() {
    const wrapper = document.querySelector(".container_rigth_side");
    const mobSort = document.createElement("div");

    const slug = new URLSearchParams(window.location.search).get("category");

    if (!slug) {
      console.error("category not found");
      return;
    }

    mobSort.classList = "sort";
    mobSort.innerHTML = "";

    const sortWrapper = document.createElement("div");
    sortWrapper.classList = "bbdf";

    const btn = document.createElement("button");
    btn.id = "sort_by";
    btn.classList = "filter_pro";
    btn.type = "button";

    const span = document.createElement("span");
    span.innerHTML = "sort by";

    const svg = document.createElement("div");
    svg.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="ic_xp" width="24" height="24" viewBox="0 0 24 24" style="transform: rotate(90deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1);">
                                    <path d="m15 12 5-4-5-4v2.999H2v2h13zm7 3H9v-3l-5 4 5 4v-3h13z"></path>
                                </svg>`;

    svg.style.display = "flex";

    const a = document.querySelector("a");
    a.classList = "filter_pro2";
    a.innerHTML = "filter";
    a.href = `filterProduct/filter_mobile_product.php?category=${slug}`;

    const aSvg = document.createElement("div");
    aSvg.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="ic_xp" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                    <path d="M10 18H14V16H10V18ZM3 6V8H21V6H3ZM6 13H18V11H6V13Z"></path>
                                </svg>`;

    aSvg.style.display = "flex";

    a.appendChild(aSvg);

    btn.appendChild(span);
    btn.appendChild(svg);

    sortWrapper.appendChild(btn);
    sortWrapper.appendChild(a);
    mobSort.appendChild(sortWrapper);

    wrapper.appendChild(mobSort);
    const mbSort = document.querySelector(".mobSortContainer");

    btn.addEventListener("click", () => {
      mbSort.style.display = "flex";
    });

    const closeSort = document.querySelector("#close_sort_con_");
    closeSort.addEventListener("click", () => {
      mbSort.style.display = "none";
    });
  }

  displaymobileSort();

  const container = document.querySelector(".container_product_catelog");
  const slug = new URLSearchParams(window.location.search).get("category");

  const sortContainer = document.querySelector(".sort");
  const relatedSearch = document.querySelector("#related_results");

  if (!slug || !container) {
    console.error("container or category missing");
    return;
  }

  try {
    const response = await fetch(
      `api/sort.php?category=${slug}&sort=${selectedSort}`
    );

    if (response.ok) {
      const data = await response.json();

      if (!data || !Array.isArray(data.products)) {
        console.error("invalid response format");
        return;
      }

      if (data.products.length === 0) {
        console.warn("no product found");
        sortContainer.style.display = "none";
        relatedSearch.style.display = "none";
        return;
      }

      container.innerHTML = "";

      data.products.forEach((product) => {
        const price = Number(product.price);
        const oldPrice = Number(product.old_price);

        const discountAmount = oldPrice - price;
        const discountPercent =
          oldPrice > 0 ? Math.round((discountAmount / oldPrice) * 100) : 0;

        const ratings = parseFloat(product.rating) || 0;

        let starsHTML = "";

        for (let i = 1; i <= 5; i++) {
          if (ratings >= i) {
            starsHTML += `
        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 18.26L4.95 22.21 6.52 14.28 0.59 8.79 8.61 7.84 12 0.5l3.39 7.34 8.02 0.95-5.93 5.49 1.57 7.93z"/>
        </svg>`;
          } else if (ratings >= i - 0.5) {
            starsHTML += `
        <svg class="half" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502V15.968ZM12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>
        `;
          } else {
            starsHTML += `
        <svg class="inactive" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#DBDBDB" viewBox="0 0 24 24">
          <path d="M12 18.26L4.95 22.21 6.52 14.28 0.59 8.79 8.61 7.84 12 0.5l3.39 7.34 8.02 0.95-5.93 5.49 1.57 7.93z"/>
        </svg>`;
          }
        }

        const hasVariation = product.has_variation;

        container.innerHTML += `  <div class="product_c" data-name="${
          product.name
        }"  data-has-variation="${product.has_variation}" data-slug="${
          product.slug
        }">
                    <a href="product.php?id=${encodeURIComponent(
                      product.id
                    )}&name=${product.slug}">
                        <div>
                            <img src="${product.image}" alt="">
                        </div>
                        <h2 class="p_name">${product.name} </h2>
                        <div class="p_price">&#8358; ${formatPrice(
                          product.price
                        )}</div>
                        <div class="p_price_old"><del>&#8358; ${formatPrice(
                          product.old_price
                        )}</del> <span>${
          discountPercent > 0 ? `${discountPercent}%` : ""
        }</span></div>
                        <div class="p_ratings"><div class="rates_reviews"> ${starsHTML} <span>(${ratings.toFixed(1)})</span></div>
       
        </div>

                    </a>
                    <div class="btn_add">
                   

                        <button type="button" data-id="${
                          product.id
                        }" data-name="${product.name}" data-price="${
          product.price
        }" data-image="${product.image}" data-slug="${
          product.slug
        }" class="add_to_cart added_to" data-old=${
          product.old_price
        } data-has-variation="${product.has_variation}">add to cart</button>
         <div class="increment_decrement">
                    <button type="button" data-name="${
                      product.name
                    }" data-image="${product.image}" data-slug="${
          product.slug
        }"  class="incre_decre ${
          hasVariation > 0 ? "decBtnVary" : "decrement"
        } " id="${
          hasVariation > 0 ? "decBtnVary" : "decrement"
        }"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M5 11V13H19V11H5Z"></path></svg></button>
                    <span id='sp'></span>
                    <button type="button" data-name="${
                      product.name
                    }" data-image="${product.image}"  data-slug="${
          product.slug
        }" class="incre_decre ${
          hasVariation > 0 ? "incBtnVary" : "increment"
        } " id="${
          hasVariation > 0 ? "incBtnVary" : "increment"
        }"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z"></path></svg></button>
                    </div>

                    </div>
                </div>`;
      });

      const paginationContainer = document.querySelector(".pagination");
      paginationContainer.innerHTML = "";

      const { currentPage, totalPages } = data.pagination;
      const slug = new URLSearchParams(window.location.search).get("category");

      function createPageLink(
        page,
        content = null,
        isActive = false,
        isDisabled = false
      ) {
        const link = document.createElement("a");
        link.href = isDisabled
          ? "#"
          : `catalog.php?category=${slug}&page=${page}`;

        if (typeof content === "string" && content.trim().startsWith("<svg")) {
          const svgNode = document
            .createRange()
            .createContextualFragment(content);
          link.appendChild(svgNode);
        } else {
          link.textContent = content || page;
        }

        if (isActive) link.classList.add("act_");
        if (isDisabled) {
          link.classList.add("disabled");
          link.style.pointerEvents = "none";
        }

        return link;
      }

      function createEllipsis() {
        const span = document.createElement("span");
        span.textContent = "...";
        span.className = "ellipsis";
        return span;
      }

      if (totalPages > 1) {
        // ← Prev
        const prevSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
                                <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                </path>
                            </svg>`;
        paginationContainer.appendChild(
          createPageLink(currentPage - 1, prevSvg, false, currentPage === 1)
        );

        // First Page
        if (currentPage > 2) {
          paginationContainer.appendChild(createPageLink(1));
        }

        // ... before current
        if (currentPage > 3) {
          paginationContainer.appendChild(createEllipsis());
        }

        // Current Page -1, Current, Current +1
        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
          if (i > 0 && i <= totalPages) {
            paginationContainer.appendChild(
              createPageLink(i, null, i === currentPage)
            );
          }
        }

        // ... after current
        if (currentPage < totalPages - 2) {
          paginationContainer.appendChild(createEllipsis());
        }

        // Last Page
        if (currentPage < totalPages - 1) {
          paginationContainer.appendChild(createPageLink(totalPages));
        }

        // → Next
        const nextSvg = `
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="currentColor">
  <path d="M8.29 6.71a1 1 0 011.42 0L15 12l-5.29 5.29a1 1 0 01-1.42-1.42L12.17 12 8.29 8.12a1 1 0 010-1.41z"/>
</svg>
`;

        paginationContainer.appendChild(
          createPageLink(
            currentPage + 1,
            nextSvg,
            false,
            currentPage === totalPages
          )
        );
      }

      // handle fallback case
      if (data.fallback) {
        console.warn("Fallback triggered — showing default products");
      }

      document.dispatchEvent(new Event("productsRendered"));
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  } catch (error) {
    console.log("error occured while fecth default sort products " + error);
  }

  // function that display sort product on mobile
  document.querySelectorAll("input[name='sort']").forEach((sort) => {
    sort.addEventListener("change", async function () {
      const selectedSortOpt = this.value;
      const slug =
        new URLSearchParams(window.location.search).get("category") || "";
      const page = 1; // always reset to first page on sort

      try {
        const response = await fetch(
          `api/sort.php?category=${slug}&sort=${selectedSortOpt}&page=${page}`
        );

        if (response.ok) {
          const data = await response.json();

          if (data.success) {
            document.querySelector(".mobSortContainer").style.display = "none";

            const container = document.querySelector(
              ".container_product_catelog"
            );

            document.querySelector("#preloader").style.display = "flex";
            container.innerHTML = "";

            data.products.forEach((product) => {
              const price = Number(product.price);
              const oldPrice = Number(product.old_price);

              const discountAmount = oldPrice - price;
              const discountPercent =
                oldPrice > 0
                  ? Math.round((discountAmount / oldPrice) * 100)
                  : 0;

              const ratings = parseFloat(product.rating) || 0;
              let starsHTML = "";

              for (let i = 1; i <= 5; i++) {
                if (ratings >= i) {
                  starsHTML += `
        <svg class="active" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 18.26L4.95 22.21 6.52 14.28 0.59 8.79 8.61 7.84 12 0.5l3.39 7.34 8.02 0.95-5.93 5.49 1.57 7.93z"/>
        </svg>`;
                } else if (ratings >= i - 0.5) {
                  starsHTML += `
        <svg class="half" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12.0006 15.968L16.2473 18.3451L15.2988 13.5717L18.8719 10.2674L14.039 9.69434L12.0006 5.27502V15.968ZM12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path></svg>
        `;
                } else {
                  starsHTML += `
        <svg class="inactive" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#DBDBDB" viewBox="0 0 24 24">
          <path d="M12 18.26L4.95 22.21 6.52 14.28 0.59 8.79 8.61 7.84 12 0.5l3.39 7.34 8.02 0.95-5.93 5.49 1.57 7.93z"/>
        </svg>`;
                }

              }

              const hasVariation = product.has_variation;

              container.innerHTML += `  <div class="product_c" data-slug=${
                product.slug
              }>
                    <a href="product.php?id=${encodeURIComponent(
                      product.id
                    )}&name=${product.slug}">
                        <div>
                            <img src="${product.image}" alt="">
                        </div>
                        <h2 class="p_name">${product.name} </h2>
                        <div class="p_price">&#8358; ${formatPrice(
                          product.price
                        )}</div>
                        <div class="p_price_old"><del>&#8358; ${formatPrice(
                          product.old_price
                        )}</del> <span>${
                discountPercent > 0 ? `${discountPercent}%` : ""
              }</span></div>
                        <div class="p_ratings"> ${starsHTML} <span>(${ratings.toFixed(
                1
              )})</span></div>
                    </a>
                    <div class="btn_add">
                   

                        <button type="button" data-id="${
                          product.id
                        }" data-name="${product.name}" data-price="${
                product.price
              }" data-image="${product.image}" data-slug="${
                product.slug
              }" class="add_to_cart added_to" data-has-variation="${
                product.has_variation
              }">add to cart</button>
         <div class="increment_decrement">
                    <button type="button" class="incre_decre ${
                      hasVariation > 0 ? "decBtnVary" : "decrement"
                    } " data-price="${product.price}" data-image="${
                product.image
              }" data-id="${product.id}" data-name="${
                product.name
              }"  data-slug="${product.slug}" id="${
                hasVariation > 0 ? "decBtnVary" : "decrement"
              } "><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M5 11V13H19V11H5Z"></path></svg></button>
                    <span id="sp">0</span>
                    <button type="button" class="incre_decre ${
                      hasVariation > 0 ? "incBtnVary" : "increment"
                    } " data-price="${product.price}" data-image="${
                product.image
              }" data-id="${product.id}" data-name="${
                product.name
              }" data-slug="${product.slug}"  id="${
                hasVariation > 0 ? "incBtnVary" : "increment"
              }"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z"></path></svg>
                </button>
                    </div>

                    </div>
                </div>`;
            });

            setTimeout(() => {
              document.querySelector("#preloader").style.display = "none";
              $("html, body").animate(
                {
                  scrollTop: $(".container_wrapper_p_cate").position().top - 150,
                },
                1000
              );
            }, 3000);
          }
        } else {
          throw new Error(`HTTP ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        console.log("error while fetching sort products " + error);
      }

      document.dispatchEvent(new Event("productsSort"));
    }); // end sort
  }); // ends function that display sort product on mobile
});
