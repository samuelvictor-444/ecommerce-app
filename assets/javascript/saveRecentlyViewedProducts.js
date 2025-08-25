window.addEventListener("DOMContentLoaded", () => {
  function setRecentlyViewedProduct() {
    const productSlug = new URLSearchParams(window.location.search).get("name");

    if (!productSlug) {
      console.error("product not found");
      return;
    }

    let viewed = JSON.parse(localStorage.getItem("recentlyViewed")) || [];

    // Remove if already exists (to avoid duplicates)
    viewed = viewed.filter((item) => item !== productSlug);

    // Add the slug to the beginning (most recent first)
    viewed.unshift(productSlug);

    localStorage.setItem("recentlyViewed", JSON.stringify(viewed));
  }

  setRecentlyViewedProduct();
  
});
