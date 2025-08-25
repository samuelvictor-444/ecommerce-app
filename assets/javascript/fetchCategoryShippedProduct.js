window.addEventListener("DOMContentLoaded" , async () => {
   const container = document.querySelector("#ShippedFrom");
   const slug = new URLSearchParams(window.location.search).get("category");

   if(!container || !slug) {
     console.error("container  not found or category not found " );
     return;
   }

   try {
    const response = await fetch(`api/getShippedFrom.php?category=${slug}`);

    if(response.ok) {
        const data = await response.json();

        if(!Array.isArray(data)) {
            console.error("invalid response format");
            return;
        }

        container.innerHTML = "";
        data.forEach(item => {
           const a = document.createElement("a"); 
           a.classList.add("_me_start");
           a.classList.add("fb_");
           a.href = `http://localhost/usman_clothing_service/catelog.php?category=${encodeURIComponent(slug)}&shippedFrom=${encodeURIComponent(item.shipped_from_location)}`;
           a.innerText = item.shipped_from_location;

           container.appendChild(a);
        });

    }else {
        throw new Error(`HTTPS ERORR STATUS ${response.status}`);
    }
    
   } catch (error) {
      console.error("erorr while fetching avaiable shipped location " + error);
   }
});