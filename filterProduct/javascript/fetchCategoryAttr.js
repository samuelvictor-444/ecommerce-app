window.addEventListener("DOMContentLoaded", () => {
  const variationMap = {};
  let selectedFilter = {
    rating: null,
    discount: null,
    price_min: null,
    price_max: null,
    sellerScore: null,
    shippedFrom: null,
    subCategory: null,
    brand: null,
  };

  const display = document.getElementById("sub_w");
  const subCategoryCon = document.querySelector(".sub_cate_F");

  let SaveBtn = document.querySelector("#saveVari");
  const saveBrandBtn = document.querySelector("#saveBrands");
  const resetBtn = document.querySelector("#reset_btn");
  const showBtn = document.querySelector("#show_p");
  // reset product rating section btn
  const resetRating = document.querySelector("#resetRate");

  // reset discount section btn
  const resetDiscountBtn = document.querySelector("#resetDicount");

  // reset sellersScore section btn
  const sellerScoreBtn = document.querySelector("#seller_s");

  // reset shipped from btn
  const resetShippedFrom = document.querySelector("#resetShippedFrom");

  // Price Range (if you use sliders or inputs)
  const minInput = document.querySelector(".price_min");
  const maxInput = document.querySelector(".price_max");
  const minSlider = document.querySelector(".fromSlider");
  const maxSlider = document.querySelector(".toSlider");

  async function fetchCateAttr() {
    const categorySlug = new URLSearchParams(window.location.search).get(
      "category"
    );
    const container = document.querySelector(".card_c");

    if (!categorySlug || !container) {
      console.error("category or container not found");
      return;
    }

    try {
      const response = await fetch(
        `../api/getCategoryAttributes.php?category=${categorySlug}`
      );

      if (response.ok) {
        const data = await response.json();

        if (data) {
          data.forEach((item) => {
            const btn = document.createElement("button");
            btn.classList.add("_bet_s", "vary_type");
            btn.id = item.attribute_slug;
            btn.type = "button";
            btn.dataset.type = item.attribute_slug;

            const div = document.createElement("div");
            div.classList.add("_oh");

            const divSvg = document.createElement("div");
            divSvg.classList.add("svg_");
            divSvg.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="ic" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                            </path>
                        </svg>`;

            const h1 = document.createElement("h1");
            h1.textContent = item.attribute_name;

            const span = document.createElement("span");
            span.id = `selected_${item.attribute_slug}`;
            span.textContent = "";

            div.appendChild(h1);
            div.appendChild(span);
            btn.appendChild(div);
            btn.appendChild(divSvg);

            container.appendChild(btn);

            variationMap[item.attribute_slug] = item.values;

            if (!(item.attribute_slug in selectedFilter)) {
              selectedFilter[item.attribute_slug] = null;
            }
          });

          // display variation values
          let currentVariationType = "";

          function ErrorMsg(message) {
            const errorDiv = document.createElement("div");
            errorDiv.classList.add("errorMsg");

            const errorMsgDiv = document.createElement("div");
            errorMsgDiv.classList.add("errorMsgDiv");

            const errorContext = document.createElement("div");
            errorContext.classList.add("errorMsgContext");

            errorContext.innerText = message;

            errorMsgDiv.appendChild(errorContext);
            document.body.appendChild(errorDiv);
            document.body.appendChild(errorMsgDiv);

            setTimeout(() => {
              document.body.removeChild(errorDiv);
              document.body.removeChild(errorMsgDiv);
            }, 2000);
          } // ErrorMsg

          document.querySelectorAll(".vary_type").forEach((btn) => {
            btn.addEventListener("click", () => {
              SaveBtn.textContent = "save";
              currentVariationType = btn.dataset.type;
              showVariationOptions(currentVariationType);
            }); //ends  addEventListener
          }); // ends forEach loop

          function showVariationOptions(type) {
            document.querySelector(".vari").textContent = type;
            document.querySelector(".var_type").id = `id_${type}`;
            document.querySelector(".vari_tion").id = `id_li_${type}`;

            const container = document.querySelector(".vari_tion");
            container.innerHTML = "";

            const options = variationMap[type];

            // console.log(options);

            options.forEach((option) => {
              const id = `${type}_${option.id}`;

              container.innerHTML += `
                    <li class="pvs">
                                    <div>
                                        <input type="radio" class="rad" id="${id}" name="variationOption" value="${
                option.value
              }" 
                                        ${
                                          selectedFilter[type] === option.value
                                            ? "checked"
                                            : ""
                                        }>
                                        <label for="${id}" class="lab">
                                            ${option.value}
                                        </label>
                                    </div>
                                </li>

                              
                `;

              $("#variations__con").css("display", "block");
              $("#variations__con").animate(
                {
                  left: "0px",
                },
                500
              );
            });

            let input = document.querySelector(`#id_${type}`);
            input?.addEventListener("keyup", () => {
              const inputField = document.getElementById(`id_${type}`);
              const ul = document.getElementById(`id_li_${type}`);

              // ✅ Check first
              if (!inputField || !ul) return;

              const filter = inputField.value.toUpperCase();
              const li = ul.getElementsByTagName("li");

              for (let i = 0; i < li.length; i++) {
                const a = li[i].getElementsByTagName("label")[0];
                const txtValue = a?.textContent || a?.innerText || "";
                li[i].style.display = txtValue.toUpperCase().includes(filter)
                  ? ""
                  : "none";
              }
            });
          } // ends function showVariationOptions

          // function that save selected variation
          document.querySelector("#saveVari").addEventListener("click", () => {
            const selected = document.querySelector(
              "input[name='variationOption']:checked"
            );

            if (!selected) {
              ErrorMsg(
                "Oops! You need to pick at least one option  before we can show you the goodies 🎁"
              );
              return;
            }

            SaveBtn.classList.add("loading");
            SaveBtn.textContent = "saving";
            SaveBtn.setAttribute("disabled", true);

            setTimeout(() => {
              SaveBtn.classList.remove("loading");
              SaveBtn.innerHTML = `saved  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M11.602 13.7599L13.014 15.1719L21.4795 6.7063L22.8938 8.12051L13.014 18.0003L6.65 11.6363L8.06421 10.2221L10.189 12.3469L11.6025 13.7594L11.602 13.7599ZM11.6037 10.9322L16.5563 5.97949L17.9666 7.38977L13.014 12.3424L11.6037 10.9322ZM8.77698 16.5873L7.36396 18.0003L1 11.6363L2.41421 10.2221L3.82723 11.6352L3.82604 11.6363L8.77698 16.5873Z"></path></svg>`;
              SaveBtn.removeAttribute("disabled");

              if (selected) {
                selectedFilter[currentVariationType] = selected.value;
                // console.log(selectedFilter);
              }

              updateSelectedDisplay();
              updateResetBtn();
            }, 2000);

            setTimeout(() => {
              $("#variations__con").animate({ left: "-395px" }, 200);
            }, 3000);
          }); // ends function that save selected variation

          document
            .querySelector("#saveBrands")
            .addEventListener("click", () => {
              let selected = document.querySelector(
                "input[name=brands_m]:checked"
              );

              if (!selected) {
                ErrorMsg(
                  "Oops! You need to pick at least one brand before we can show you the goodies 🎁"
                );
                return;
              }

              saveBrandBtn.classList.add("loading");
              saveBrandBtn.textContent = "saving";
              saveBrandBtn.setAttribute("disabled", true);

              setTimeout(() => {
                saveBrandBtn.classList.remove("loading");
                saveBrandBtn.innerHTML = `saved  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M11.602 13.7599L13.014 15.1719L21.4795 6.7063L22.8938 8.12051L13.014 18.0003L6.65 11.6363L8.06421 10.2221L10.189 12.3469L11.6025 13.7594L11.602 13.7599ZM11.6037 10.9322L16.5563 5.97949L17.9666 7.38977L13.014 12.3424L11.6037 10.9322ZM8.77698 16.5873L7.36396 18.0003L1 11.6363L2.41421 10.2221L3.82723 11.6352L3.82604 11.6363L8.77698 16.5873Z"></path></svg>`;
                saveBrandBtn.removeAttribute("disabled");

                if (selected) {
                  selectedFilter.brand = selected.value;
                }

                const displayBrandContext =
                  document.querySelector("#sub_brands");

                displayBrandContext.innerHTML = selected.value;

                updateResetBtn();

                setTimeout(() => {
                  $("#brand_variations__con").animate({ left: "-395px" }, 50);
                  saveBrandBtn.textContent = "save";
                }, 1000);
              }, 2000);
            });

          $("#c_it_2").click(function () {
            const $target = $("#variations__con");

            // Clear animation queue and reflow
            $target.stop(true, true);
            void $target[0].offsetHeight;

            $target.animate({ left: "-395px" }, 100, function () {
              $target.fadeOut(100);
            });
          });

          // function that add the sub Category to the url
          subCategoryCon.addEventListener("change", (e) => {
            if (e.target.classList.contains("cate")) {
              const msgCon = document.createElement("div");
              msgCon.classList.add("success");

              const msgBox = document.createElement("div");
              msgBox.classList.add("successBox");

              msgBox.innerHTML = " <h3>sub category successfull saved </h3>";

              msgCon.appendChild(msgBox);

              setTimeout(() => {
                document.body.removeChild(msgCon);
              }, 2000);

              selectedFilter.subCategory = e.target.value;

              display.textContent = selectedFilter.subCategory;

              document.body.appendChild(msgCon);
              updateResetBtn();
            }
          }); // ends function that add the sub Category to the url

          // function that toggle select products by  rating
          document.querySelectorAll(".rate").forEach((el) => {
            el.addEventListener("change", () => {
              selectedFilter.rating = el.value;
              resetRating.style.display = "flex";
              updateResetBtn();
            });
          }); // ends function that toggle select products by  rating

          resetRating.addEventListener("click", () => {
            selectedFilter.rating = null;

            document.querySelectorAll(".rate").forEach((el) => {
              el.checked = false;
            });

            updateResetBtn();
          }); // ends function that reset the selected rating to none

          document.querySelectorAll(".discount").forEach((el) => {
            el.addEventListener("change", () => {
              selectedFilter.discount = el.value;
              resetDiscountBtn.style.display = "flex";
              updateResetBtn();
            });
          });

          resetDiscountBtn.addEventListener("click", () => {
            selectedFilter.discount = null;
            document.querySelectorAll(".discount").forEach((el) => {
              el.checked = false;
            });

            updateResetBtn();
          });

          document.querySelectorAll(".seller_score").forEach((el) => {
            el.addEventListener("change", () => {
              selectedFilter.sellerScore = el.value;
              sellerScoreBtn.style.display = "flex";
              updateResetBtn();
            });
          });

          sellerScoreBtn.addEventListener("click", () => {
            selectedFilter.sellerScore = null;
            document.querySelectorAll(".seller_score").forEach((el) => {
              el.checked = false;
            });

            updateResetBtn();
          });

          // function that toggle select shipped from
          document
            .querySelector(".wrapper_shiped")
            .addEventListener("change", (el) => {
              if (el.target.classList.contains("shipped_ff")) {
                selectedFilter.shippedFrom = el.target.value;
                resetShippedFrom.style.display = "flex";
                updateResetBtn();
              }
            });

          resetShippedFrom.addEventListener("click", () => {
            selectedFilter.shippedFrom = null;
            document.querySelectorAll(".shipped_ff").forEach((el) => {
              el.checked = false;
              updateResetBtn();
            });
          });

          minSlider.addEventListener("input", (e) => {
            let val = parseInt(e.target.value);
            if (val > parseInt(maxSlider.value))
              val = parseInt(maxSlider.value);
            minInput.value = val;
            selectedFilter.price_min = val;
            updateResetBtn();
          });

          maxSlider.addEventListener("input", (e) => {
            let val = parseInt(e.target.value);
            if (val < parseInt(minSlider.value))
              val = parseInt(minSlider.value);
            maxInput.value = val;
            selectedFilter.price_max = val;
            updateResetBtn();
          });

          // Update slider when input changes
          minInput.addEventListener("input", (e) => {
            let val = parseInt(e.target.value);
            if (val > parseInt(maxSlider.value))
              val = parseInt(maxSlider.value);
            if (val < parseInt(minSlider.min)) val = parseInt(minSlider.min);
            minSlider.value = val;
            selectedFilter.price_min = val;
            updateResetBtn();
          });

          maxInput.addEventListener("input", (e) => {
            let val = parseInt(e.target.value);
            if (val < parseInt(minSlider.value))
              val = parseInt(minSlider.value);
            if (val > parseInt(maxSlider.max)) val = parseInt(maxSlider.max);
            maxSlider.value = val;
            selectedFilter.price_max = val;

            updateResetBtn();
          });

          // if statment that checks if btn is set
          if (resetBtn) {
            // reset btn function
            resetBtn.addEventListener("click", () => {
              // Reset all selected filters
              for (let key in selectedFilter) {
                selectedFilter[key] = null;
              }

              // Uncheck all radio buttons
              document
                .querySelectorAll("input[name='variationOption']:checked")
                .forEach((el) => (el.checked = false));

              // Uncheck all shipped checkboxes
              document
                .querySelectorAll("input[name='shipped']:checked")
                .forEach((el) => (el.checked = false));

              // Uncheck all brand checkboxes
              document
                .querySelectorAll("input[name='brands_m']:checked")
                .forEach((el) => (el.checked = false));

              // Clear sub brands display
              document.querySelector("#sub_brands").textContent = "";
              display.textContent = "";

              // Clear subcategory
              document.querySelector(".sub_cate_F").value = "";

              // Clear rating, discount, sellerScore
              document
                .querySelectorAll(".rate, .discount, .seller_score")
                .forEach((el) => {
                  el.checked = false;
                });

              // Reset sliders and inputs
              minInput.value = minSlider.min;
              maxInput.value = maxSlider.max;
              minSlider.value = minSlider.min;
              maxSlider.value = maxSlider.max;

              // Reset buttons
              SaveBtn.textContent = "save";
              SaveBtn.removeAttribute("disabled");
              saveBrandBtn.textContent = "save";
              saveBrandBtn.removeAttribute("disabled");

              // display all the reset btn base on rating, discount , sellerscore none
              resetDiscountBtn.style.display = "none";
              sellerScoreBtn.style.display = "none";
              resetRating.style.display = "none";
              resetShippedFrom.style.display = "none";

              // Update UI
              updateSelectedDisplay();
              updateResetBtn();

              // Optionally close panels
              $("#variations__con")
                .animate({ left: "-395px" }, 100)
                .fadeOut(100);
              $("#brand_variations__con")
                .animate({ left: "-395px" }, 100)
                .fadeOut(100);
            });
          } // ends if statment that checks if btn is set

          // if show product btn
          if (showBtn) {
            showBtn.addEventListener("click", () => {
              const params = new URLSearchParams();

              for (const key in selectedFilter) {
                if (selectedFilter[key]) {
                  params.set(key, selectedFilter[key]);
                }
              }

              params.set("category", categorySlug);

              const preloader = document.querySelector("#preloader");
              preloader.style.display = "flex";

              setTimeout(() => {
                window.location = `../catalog_listing.php?${params.toString()}`;
              }, 5000);
            }); // ends function showProduct
          } // ends  if show product btn

          function updateSelectedDisplay() {
            for (const key in selectedFilter) {
              const display = document.querySelector(`#selected_${key}`);
              if (display) display.textContent = selectedFilter[key];
            }
          } // ends function updateSelectedDisplay

          function isAnyFiterSelected() {
            return Object.values(selectedFilter).some(
              (val) => val !== null && val !== ""
            );
          }

          function updateResetBtn() {
            if (isAnyFiterSelected()) {
              resetBtn.removeAttribute("disabled");
              resetBtn.classList.add("active");
              resetBtn.classList.remove("_ds");
              showBtn.removeAttribute("disabled");
              showBtn.classList.remove("_ds");
              showBtn.classList.add("_prime");
            } else {
              resetBtn.setAttribute("disabled", true);
              showBtn.setAttribute("disabled", true);
              resetBtn.classList.remove("active");
              resetBtn.classList.add("_ds");
              showBtn.classList.remove("_prime");
              showBtn.classList.add("_ds");
              resetDiscountBtn.style.display = "none";
              resetRating.style.display = "none";
              sellerScoreBtn.style.display = "none";
              resetShippedFrom.style.display = "none";
            }
          }
        }
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.log("error while fetching category attributes " + error);
    }
  } // end function fetchCateAttr

  fetchCateAttr();
});
