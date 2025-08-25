window.addEventListener("DOMContentLoaded", () => {
  const applyBtn = document.querySelector(".applyPrice");

  applyBtn.addEventListener("click", () => {
    const min = document.querySelector(".minPrice").value;
    const max = document.querySelector(".maxPrice").value;

    const slug = new URLSearchParams(window.location.search).get("category");

    if (!slug) {
      console.error("category not found");
      return;
    }

    const targetUrl = `catelog.php?category=${slug}&price_min=${min}&price_max=${max}`;

    // Navigate to catalog listing page with selected filters
    window.location.href = targetUrl;
  });



  function handleFilterClick(containerId, paramName) {
    const params = new URLSearchParams(window.location.search);
    const slug = params.get("category") || "";

    if (!slug) {
      console.error("container not found");
      return;
    }

    document.querySelectorAll(`#${containerId} a`).forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();

        const value = link.dataset[paramName];

        params.set(paramName, value);
        params.set("category", slug);

        // Redirect with all filter params
        window.location.href = `catalog.php?${params.toString()}`;
      });
    });
  }

  handleFilterClick("discount_p" , "discount");
  handleFilterClick("dis_seller_score" , "seller_score");
  handleFilterClick("dis_rating" , "product_rating");
  handleFilterClick("wrapper_dd" , "sort");
});
