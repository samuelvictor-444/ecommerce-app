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

            let cart = JSON.parse(localStorage.getItem("cart")) || [];

            try {
              let response = await fetch("./api/payment.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ cart }),
              });

              if (response.ok) {
                const data = await response.json();

                if (data.success) {
                  if (data.redirect_url) {
                    setTimeout(() => {
                      document.querySelector("body").removeChild(div);
                      window.location.href = data.redirect_url;
                    }, 3000);
                  } else {
                    document.querySelector("body").removeChild(div);
                    console.error(data.message);
                  }
                } else {
                  document.querySelector("body").removeChild(div);
                  console.log(data.message);
                }
              } else {
                throw new Error(`HTTPS ERROR STATUS ${response.status}`);
              }
            } catch (error) {
              console.error("error occured while sending cart details", error);
            }
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
