window.addEventListener("DOMContentLoaded", async () => {

  try {
    const response = await fetch("api/get_ads.php");
    const ads = await response.json();

    const container = document.querySelector(".container_ads");
    container.innerHTML = "";

    ads.forEach((ad) => {
      const div = document.createElement("div");
      div.classList = "container_ads_it";
      div.dataset.store = ad.storeSlug;

      div.innerHTML = `<img src="${ad.image}" alt="${ad.title}"></img>`;

      div.addEventListener("click", () => {
        window.location.href = `store.php?store=${ad.storeSlug}`;
      });



      container.appendChild(div);
    });

  } catch (error) {
    console.error(error + " while fetching promos product");
  }
});
