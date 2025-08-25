window.addEventListener("DOMContentLoaded", () => {
  async function fetchCatePageDescription() {
    const container = document.querySelector(".container_cate_info");
    const cateSlug = new URLSearchParams(window.location.search).get(
      "category"
    );

    if (!container || !cateSlug) {
      console.error("description or category not found");
      return;
    }

    try {
      const response = await fetch(
        `api/getCateDescription.php?category=${cateSlug}`
      );

      if (response.ok) {
        const data = await response.json();

        if (!data || !Array.isArray(data)) {
          console.error("invalid response format");
          return;
        }

        const item = data[0];

        if (item.success) {
          if (!item.description ) {
            container.style.display = "none";

            return;
          }

          container.innerHTML = item.description;
        } else {
          console.log("error occured while fetching category description");
        }
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.log("error while fetching category description " + error);
    }
  }

  fetchCatePageDescription();
});
