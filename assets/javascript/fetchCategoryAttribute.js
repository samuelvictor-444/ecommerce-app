window.addEventListener("DOMContentLoaded", async () => {
  const container = document.querySelector(".container_side_section");
  const slug = new URLSearchParams(window.location.search).get("category");

  if (!container || !slug) {
    console.error("container not found or category not found");
    return;
  }

  try {
    const response = await fetch(
      `api/getCategoryAttributes.php?category=${slug}`
    );

    if (response.ok) {
      const data = await response.json();
      if (!Array.isArray(data)) {
        console.error("invaild response format");
        return;
      }

      data.forEach((item) => {
        const div = document.createElement("div");
        div.classList.add("brand_sect");

        const h1 = document.createElement("h1");
        h1.textContent = item.attribute_name;

        const div2 = document.createElement("div");
        div2.classList.add("container_filter");

        item.values.forEach((valueObj) => {
          const a = document.createElement("a");
          a.href = `http://localhost/usman_clothing_service/catalog_listing.php?category=${slug}&attr=${item.attribute_slug}=${encodeURIComponent(
            valueObj.value
          )}`;

          const span = document.createElement("span");
          span.innerText = valueObj.value;

          a.appendChild(span);
          div2.appendChild(a);
        });
        div.appendChild(h1);
        div.appendChild(div2);
 
        container.appendChild(div);

      });
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  } catch (error) {
    console.error("error occured while fetching category attributes " + error);
  }
});
