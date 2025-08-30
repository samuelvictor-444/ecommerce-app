window.addEventListener("DOMContentLoaded" , () => {
    async function fetchAllBrands() {
        const container = document.querySelector("#search_brands");
        const slug = new URLSearchParams(window.location.search).get("category");

        if(!container || !slug) {
            console.error("container not found or categoey not found");
            return;
        }

        try {
            const response = await fetch(`api/getBrandsByCategory.php?slug=${slug}`);
            if (response.ok) {
                const data = await response.json();

                if(!Array.isArray(data)) {
                    console.error("invalid response format");
                    return;
                }

                if(data.length === 0) {
                   const wrapper = document.querySelector(".brand_sect");
                   if (wrapper) wrapper.style.display = "none";
                }

                container.innerHTML = ""; 
                data.forEach(item => {
                    const a  = document.createElement("a");
                    a.href = `http://localhost/usman_clothing_service/catalog_listing.php?category=${slug}&brand=${encodeURIComponent(item.slug)}`;

                    const span = document.createElement("span");
                    span.innerText = item.name;

                    a.appendChild(span);
                    container.appendChild(a);
                });

            }else {
                throw new Error(`HTPP ERROR STATUS ${response.status}`);
            }
            
        } catch (error) {
            console.error("error occured while fetching brands " + error);
        }


    }


    fetchAllBrands();
});