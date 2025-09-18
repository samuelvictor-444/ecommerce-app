window.addEventListener("DOMContentLoaded", () => {
  const checkOutBtns = document.querySelectorAll(".chek_out");

  checkOutBtns.forEach((checkOutBtn) => {
    checkOutBtn.addEventListener("click", async () => {
      try {
        const response = await fetch("api/checkIsUserLogin.php");

        if (response.ok) {
          const result = await response.json();
          if (result.success) {
            const div = document.createElement("div");
            div.classList.add("inProgress");

            const loader = document.createElement("div");
            loader.classList.add("loader");

            div.appendChild(loader);
            document.querySelector("body").appendChild(div);

            setTimeout(() => {
              window.location.href = "./api/payment.php";
            }, 2000);
          } else {
            const currentPage = encodeURIComponent(window.location.pathname);
            window.location.href = `user/loginUser.php?redirect=${currentPage}`;
          }
        } else {
          throw new Error(`HTTPS ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        console.log("error while if user is loginIn ", error);
      }
    });
  });
});
