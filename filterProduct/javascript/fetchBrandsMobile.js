window.addEventListener("DOMContentLoaded", async () => {
  const categorySlug = new URLSearchParams(window.location.search).get(
    "category"
  );
  const container = document.querySelector(".brands");
  const btn = document.querySelector("#brand_s");

  if (!categorySlug || !container) {
    console.log("category or container not found");
  }

  try {
    const response = await fetch(
      `../api/getBrandsByCategory.php?slug=${categorySlug}`
    );

    if (response.ok) {
      const data = await response.json();

      if (!Array.isArray(data) || data.length === "") {
        btn.style.display = "none";
        container.style.display = "none";

        return;
      }

      if (data) {
        container.innerHTML = "";

        data.forEach((item) => {
          {
            container.innerHTML += `
           
           <div class="pvs">
                                <input type="radio" class="rad brands_m" id="${item.slug}" name="brands_m" value="${item.slug}">
                                <label for="${item.slug}" class="lab">
                                  ${item.name}
                                </label>
                            </div>
           
           `;
          }
        });
      }
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  } catch (error) {
    console.error("error occured while fetching brand by category " + error);
  }

  function brandFiterSearch() {
    let input = document.getElementById("searchBrandFilter");

    input.addEventListener("keyup", () => {
      var input, filter, ul, li, a, i, txtValue;
      input = document.getElementById("searchBrandFilter");
      filter = input.value.toUpperCase();
      ul = document.getElementById("myULFilter");
      li = ul.getElementsByTagName("div");
      for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("label")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          li[i].style.display = "";
        } else {
          li[i].style.display = "none";
        }
      }
    });
  } // ends function  brandFiterSearch

  brandFiterSearch();
});
