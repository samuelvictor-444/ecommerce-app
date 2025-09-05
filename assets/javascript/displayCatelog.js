window.addEventListener("DOMContentLoaded", async () => {
  const queryString = window.location.search;

  if (!queryString) {
    console.error("No query params found");
    return;
  }


  try {
    const response = await fetch(`api/fetchCatelogListing.php${queryString}`);

    
  } catch (error) {
    console.log(
      "error occurred while fetching catelog listing products ",
      error
    );
  }
});
