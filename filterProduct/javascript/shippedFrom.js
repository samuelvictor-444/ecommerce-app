window.addEventListener("DOMContentLoaded", () => {
  async function getShippedFrom() {
    const categorySlug = new URLSearchParams(window.location.search).get(
      "category"
    );
    const container = document.querySelector(".wrapper_shiped");

    if (!container || !categorySlug) {
      console.error("category or container not found");
      return;
    }

    try {
      const response = await fetch(
        `../api/getShippedFrom.php?category=${categorySlug}`
      );

      if (response.ok) {
        const data = await response.json();

        if (data) {
          container.innerHTML = "";

          data.forEach((location) => {
            container.innerHTML += `
                  <div class="pdf_cont">
                                <input type="radio" value="${location.shipped_from_location}" name="shipped" id="${location.shipped_from_location}" class="cb shipped_ff">
                                <label for="${location.shipped_from_location}" class="brand_t">${location.shipped_from_location}</label>
                            </div>
                 `;
          });


        }
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.log(
        "error occured ewhile fetching category attribute by location " + error
      );
    }
  } // ends function getShippedFrom

  getShippedFrom();
});
