window.addEventListener("DOMContentLoaded", () => {
  const loginBtn = document.querySelector("#Continue");
  const emailInput = document.querySelector("#userEmail");
  const hiddenEmail = document.querySelector("#hiddenEmail");
  const userpwd = document.querySelector("#pwd_input");
  const emailContainer = $("#email_input");
  const loginContainer = document.querySelector("#user_log_box");
  const otp_container = document.querySelector("#otp_verify");

  function startProgress() {
    const progressBar = document.querySelector(".progress_x");
    const slide = progressBar.querySelector(".slide");

    progressBar.classList.add("display");

    // reset animation in case user retries
    slide.style.animation = "none";
    slide.offsetHeight; // force reflow
    slide.style.animation = "slideContinuous 1s linear infinite";
  }

  function stopProgress() {
    const progressBar = document.querySelector(".progress_x");
    if (progressBar.classList.contains("display")) {
      progressBar.classList.remove("display");
    }
  }

  emailInput.addEventListener("input", () => {
    document.querySelector("#email_input").querySelector("p").innerHTML = "";
  });

  userpwd.addEventListener("input", () => {
    document.querySelector("#pwd_input p").textContent = "";
  });

  // Track current step (1 = email, 2 = password)
  let step = 1;

  loginBtn.addEventListener("click", async () => {
    if (step === 1) {
      hiddenEmail.value = emailInput.value;

      const userEmail = hiddenEmail.value.trim();

      if (!userEmail) {
        document.querySelector("#email_input").querySelector("p").innerHTML =
          "Oops! We need your email to continue.";
        return;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(userEmail)) {
        document.querySelector("#email_input").querySelector("p").innerHTML =
          "Oops! That email doesn’t seem right. Double-check and try again.";
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
            startProgress();
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

              stopProgress();

              step = 2;
            }, 2000);
          } else {
            stopProgress();
            document.querySelector("#email_input p").textContent =
              result.message;
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
        document.querySelector("#pwd_input p").textContent =
          "Please provide your password to access your account";
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
            startProgress();

            setTimeout(() => {
              $(loginContainer).animate(
                {
                  left: "-500px",
                  opacity: 0,
                },
                500,
                () => {
                  // hide after animation
                  $(loginContainer).hide();
                }
              );

              $(otp_container)
                .css({ left: "500px", display: "block", opacity: 0 })
                .animate({ left: "0px", opacity: 1 }, 500);

              stopProgress();

              document.querySelector(
                "#otp-message"
              ).textContent = `We have sent a verification code to ${result.user_email}`;
              step = 3;
            }, 2000);

            // window.location.href = result.redirect;
          } else {
            stopProgress();
            document.querySelector("#pwd_input p").textContent = result.message;
          }
        } else {
          throw new Error(`HTTP ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        console.error("Password verification failed:", error);
      }
    } else if (step === 3) {
      
    }
  });
});
