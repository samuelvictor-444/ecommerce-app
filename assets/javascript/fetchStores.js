window.addEventListener("DOMContentLoaded", () => {
  async function fetchLimitedStores() {
    const container = document.querySelector(".storeAv");

    if (!container) {
      console.error("container not found");
      return;
    }

    try {
      const response = await fetch("api/getStores.php?limitedStores");
      const limitedStores = await response.json();

      if (!Array.isArray(limitedStores)) {
        console.error("invalid response format");
        return;
      }

      if (response.ok) {
        container.innerHTML = "";

        limitedStores.forEach((limitedStore) => {
          container.innerHTML += `
                 <a href="store.php?store_name=${encodeURIComponent(
                   limitedStore.storeSlug
                 )}&store_id=${encodeURIComponent(limitedStore.store_id)}">
                 <span> ${limitedStore.storeName} </span>  </a>`;
        });
      } else {
        throw new Error(`HTTP ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.error("error occured while fetchimg limited stores " + error);
    }
  } // ends function fetchLimitedStores();

  fetchLimitedStores();

  async function fetchAllStores() {
    const container = document.querySelector(".container_category");

    if (!container) {
      console.error("container not found ");
      return;
    }

    try {
      const response = await fetch("api/getStores.php?allStores");
      const allStores = await response.json();

      if (!Array.isArray(allStores)) {
        console.error("invaild response format");
        return;
      }

      if (response.ok) {
        container.innerHTML = "";

        allStores.forEach((allStore) => {
          // create anchor tag
          const a = document.createElement("a");
          a.href = `store.php?store_name=${encodeURIComponent(
            allStore.storeSlug
          )}&store_id=${encodeURIComponent(allStore.store_id)}`;

          // create the div
          const div = document.createElement("div");
          div.className = "cate_cont";

          div.innerHTML = `<img src="${allStore.storelogo}" alt="${allStore.storeName}">`;

          a.appendChild(div);
          container.appendChild(a);
        });
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.error("error while fetching all stores " + error);
    }
  } // ends function fetchAllStores();

  fetchAllStores();

  async function VisibleStores() {
    const container = document.querySelector(".avaiable_store_mobile");

    if (!container) {
      console.error("container not found");
      return;
    }

    try {
      const response = await fetch("api/getStores.php?VisibleStores");
      const stores = await response.json();

      if (!Array.isArray(stores)) {
        console.error("invalid response format");
        return;
      }

      container.innerHTML = "";

      stores.forEach((store) => {
        container.innerHTML += `  <a href="store.php?store=${encodeURIComponent(
          store.store_slug
        )}&store_id=${encodeURIComponent(store.store_id)}">
            <div class="ava_container">
                <div class="m_img">
                    <img src="${store.store_img}" alt="">
                </div>

                <div class="m_desc">
                    <h3>${store.store_name}</h3>
                    <p>${store.store_description}</p>
                    <span>shop now <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="currentColor"><path d="m309.67-81.33-61-61.67L587-481.33 248.67-819.67l61-61.66 400 400-400 400Z"/></svg> </span>
                </div>
            </div>
        </a>`;
      });
    } catch (error) {
      console.error("error while fetching stores " + error);
    }
  }

  VisibleStores();

  async function getOfficialStores() {
    const container = document.querySelector(".container_st");
    const slug = new URLSearchParams(window.location.search).get("category");

    if (!slug || !container) {
      console.error("category not found or container not found");
      return;
    }

    try {
      const response = await fetch(`api/getOfficalStoreCategory.php?slug=${slug}`);

      if (response.ok) {
        const officialStores = await response.json();

        if (!Array.isArray(officialStores)) {
          console.error("invaild response format");
          return;
        }

        if (officialStores.length === 0) {
           const wrapper = document.querySelector(".container_store_cate");
           if(wrapper) wrapper.style.display = "none"; 
          return;
        }

        container.innerHTML = "";

        officialStores.slice(0, 6).forEach((officialStore) => {
          const a = document.createElement("a");
          a.href = encodeURIComponent(officialStore.store_slug);

          const div = document.createElement("div");
          div.classList.add("store_wrapper");

          const img = document.createElement("img");
          img.src = officialStore.store_img;
          img.alt = officialStore.store_name;

          div.appendChild(img);
          a.appendChild(div);
          container.appendChild(a);
        });
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.log("error occurred while fetching official store " + error);
    }
  }

  getOfficialStores();
});
