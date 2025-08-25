window.addEventListener("DOMContentLoaded", () => {
  async function fetchMobileSubCate() {
    const category = new URLSearchParams(window.location.search).get(
      "category"
    );
    const container = document.querySelector("#sub_category");

    if (!category || !container) {
      console.error("container or category not found");
      return;
    }

    try {
      const response = await fetch(
        `../api/getSubCategories.php?slug=${category}`
      );

      if (response.ok) {
        const data = await response.json();

        if (data) {
          data.forEach((item) => {
            container.innerHTML += `
                            <div class="pvs">
                                <input type="radio" class="rad cate" id="${item.slug}" name="subCate" value="${item.slug}">
                                <label for="${item.slug}" class="lab">
                                    ${item.name}
                                </label>
                            </div>
           `;
          });

        }
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.error("error while fetching category sub category " + error);
    }
  } // ends fetchMobileSubCate

  fetchMobileSubCate();
});
