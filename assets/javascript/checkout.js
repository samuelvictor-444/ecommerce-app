window.addEventListener("DOMContentLoaded", () => {
  const checkOutBtns = document.querySelectorAll(".chek_out");

  checkOutBtns.forEach((checkOutBtn) => {
    checkOutBtn.addEventListener("click", async () => {
      const loaderDiv = document.createElement("div");
      loaderDiv.classList.add("inProgress");
      loaderDiv.innerHTML = `<div class="loader"></div>`;
      document.body.appendChild(loaderDiv);

      try {
        const loginResponse = await fetch("api/checkIsUserLogin.php");
        if (!loginResponse.ok)
          throw new Error(`Login check failed: ${loginResponse.status}`);

        const loginResult = await loginResponse.json();
        if (!loginResult.success) {
          window.location.href = `user/loginUser.php?redirect=${encodeURIComponent(
            window.location.pathname
          )}`;
          return;
        }

        let cart = [];
        try {
          cart = JSON.parse(localStorage.getItem("cart")) || [];
          if (!cart.length) throw new Error("Cart is empty");
        } catch (e) {
          console.error("Invalid cart in localStorage", e);
          return;
        }

        const paymentResponse = await fetch("./api/payment.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ cart }),
        });

        if (!paymentResponse.ok)
          throw new Error(`Payment init failed: ${paymentResponse.status}`);

        const paymentResult = await paymentResponse.json();

        if (paymentResult.success && paymentResult.payment_url) {
          console.log(paymentResult.message);
          setTimeout(() => {
            const loaderDiv = document.querySelector(".inProgress");
            if (loaderDiv) loaderDiv.remove();
            window.location.href = paymentResult.payment_url;
          }, 3000);
        } else {
          console.error(
            paymentResult.message || "Payment initialization failed"
          );
        }
      } catch (error) {
        console.error("Checkout error:", error);
      } finally {
        const loader = document.querySelector(".inProgress");
        if (loader) loader.remove();
      }
    });

  });
});
