window.addEventListener("DOMContentLoaded", () => {
  async function fetchLimitedCategory() {
    const container = document.querySelector(".mob_c_dat");

    if (!container) {
      console.error("container not found mobile");
      return;
    }

    try {
      const response = await fetch("api/getCategory.php?categoryProduct");
      const categories = await response.json();

      if (!Array.isArray(categories)) {
        console.error("invalid response format");
        return;
      }

      container.innerHTML = "";

      categories.forEach((category) => {
        container.innerHTML += `
            <a href="category.php?category=${encodeURIComponent(
              category.productSlug
            )}">
                <span> ${category.ProductCategory} </span>
            </a>
         `;
      });
    } catch (error) {
      console.error("error while fetching category " + error);
    }
  } // ends function fetchLimitedCategory();

  fetchLimitedCategory();

  async function fetchLimitedNavCategory() {
    const container = document.querySelector(".container_cate_6");

    if (!container) {
      console.error("container not found ");
      return;
    }

    try {
      const response = await fetch("api/getCategory.php?NavLinkCategory");
      const navLinks = await response.json();

      if (!Array.isArray(navLinks)) {
        console.error("invalid response format");
        return;
      }

      if (response.ok) {
        container.innerHTML = "";

        navLinks.forEach((navLink) => {
          container.innerHTML += `
             <a href="category.php?category=${encodeURIComponent(
               navLink.productSlug
             )}">${navLink.ProductCategory}</a>
          `;
        });
      } else {
        throw new Error(`HTTP ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.error("error occurred while fetching nav link category " + error);
    }
  } // ends function fetchLimitedNavCategory();

  fetchLimitedNavCategory();

  async function getCateoryMetaData() {
    const params = new URLSearchParams(window.location.search);
    const slug = params.get("category");

    if (!slug) {
      return;
    }

    try {
      const response = await fetch(`api/getCategoryDetails.php?slug=${slug}`);
      const data = await response.json();

      if (response.ok) {
        if (data.error) {
          console.warn("category not found");
          return;
        }

        // set page title and meta
        document.title = `${data.seo_title}`;
        document
          .querySelector('meta[name="description"]')
          .setAttribute("content", data.seo_description);

        const name = document.querySelector("#container_cate_sect");
        const slugId = document.querySelector("#slug_id");
        const slugIdName = document.querySelector(".slug_cate");
     

        name.innerHTML = `<h1>${data.name}</h1>`;

        slugId.textContent = `${data.slug}`;

        slugIdName.textContent = `${data.name}`;




      } else {
        throw new Error(`HTTP ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.error("error occurred while fetching category metadata " + error);
    }
  } // ends function getCateoryMetaData

  getCateoryMetaData();


  
});
