window.addEventListener("DOMContentLoaded", async () => {
  const categorySlug = new URLSearchParams(window.location.search).get(
    "category"
  );
  if (!categorySlug) console.error("no category found");

  try {
    const response = await fetch(`api/fetchCatelogListing.php?`)
    
  } catch (error) {
    console.log("error occurred while fetching catelog listing products ", error);
  }
});
