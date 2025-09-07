window.addEventListener("DOMContentLoaded", () => {
  const loginBtn = document.querySelector("#Continue");
  const emailInput = document.querySelector("#userEmail");
  const hiddenEmail = document.querySelector("#hiddenEmail");
  const userpwd = document.querySelector("#pwd_input");
  const emailContainer = $("#email_input");

      const currentPage = encodeURIComponent(window.location.pathname);


  // Track current step (1 = email, 2 = password)
  let step = 1;

  loginBtn.addEventListener("click", async () => {
    if (step === 1) {
      hiddenEmail.value = emailInput.value;

      const userEmail = hiddenEmail.value.trim();

      if (!userEmail) {
        console.log("please enter your email");
        return;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(userEmail)) {
        console.log("Invalid email format");
        return;
      }

      const form = document.querySelector("#loginUser");
      const loginUser = new FormData(form);

      try {
        const response = await fetch("../api/loginUser/loginUser.php", {
          method: "POST",
          body: loginUser,
        });

        if (response.ok) {
          const result = await response.json();

          if (result.success) {
            alert(result.message);

            emailInput.disabled = true;
            loginBtn.disabled = true;

            loginBtn.classList.add("disabled");

            setTimeout(() => {
              emailContainer.animate(
                {
                  left: "-500px",
                  opacity: 0,
                },
                500,
                () => {
                  // hide after animation
                  emailContainer.hide();
                }
              );

              $(userpwd)
                .css({ left: "500px", display: "block", opacity: 0 })
                .animate({ left: "0px", opacity: 1 }, 500);

              loginBtn.classList.remove("disabled");
              loginBtn.disabled = false;
              loginBtn.textContent = "Login";

              step = 2;
            }, 2000);
          } else {
            alert(result.message);
          }
        } else {
          throw new Error(`HTTPS ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        console.error("Login request failed:", error);
      }
    } else if (step === 2) {
      const password = document.querySelector("#password").value.trim();
      if (!password) {
        alert("Please enter your password");
        return;
      }

      const form = document.querySelector("#loginUser");
      const loginUser = new FormData(form);

      try {
        const response = await fetch("../api/loginUser/verifyPassword.php", {
          method: "POST",
          body: loginUser,
        });

        if (response.ok) {
          const result = await response.json();

          if (result.success) {
            alert(result.message);
            window.location.href = result.redirect;
          } else {
            alert(result.message);
          }
        } else {
          throw new Error(`HTTP ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        console.error("Password verification failed:", error);
      }
    }
  });
});
