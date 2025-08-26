window.addEventListener("DOMContentLoaded" , async () => {
   const cart = JSON.parse(localStorage.getItem("cart")) || [];
  
   const emptyCartContainer = document.querySelector(".empty_cart_box");

   if(!emptyCartContainer) return;

   // check if cart is empty
   if(cart.length === 0) {
     emptyCartContainer.style.display = "block";
     return;
   }

   try {

      const response = await fetch("api/getCartDetails.php", {
         method:"POST",
         headers:{"Content-Type": "application/json"},
         body: JSON.stringify(cart)
      });

      if(response.ok) {
           const products = await response.json();

           if(products) {
            
           }

      }else {
         throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
      
   } catch (error) {
      console.error("error fetching cart products", error);
   }


});