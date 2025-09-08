window.addEventListener("DOMContentLoaded", () => {
  const loginBtn = document.querySelector("#Continue");
  const emailInput = document.querySelector("#userEmail");
  const hiddenEmail = document.querySelector("#hiddenEmail");
  const userpwd = document.querySelector("#pwd_input");
  const emailContainer = $("#email_input");
  const loginContainer = document.querySelector("#user_log_box");
  const otp_container = document.querySelector("#otp_verify");
  const passwordInput = document.querySelector("#password");
  function startProgress() {
    const progressBar = document.querySelectorAll(".progress_x");

    progressBar.forEach((item) => {
      const slide = item.querySelector(".slide");

      item.classList.add("display");

      // reset animation in case user retries
      slide.style.animation = "none";
      void slide.offsetWidth; // reflow
      slide.style.animation = "";
    });
  }

  function stopProgress() {
    const progressBar = document.querySelectorAll(".progress_x");

    progressBar.forEach((item) => {
      if (item.classList.contains("display")) {
        item.classList.remove("display");
      }
    });
  }

  if (!loginBtn.classList.contains("disabled")) {
    loginBtn.classList.add("disabled");
  }

  emailInput.addEventListener("input", () => {
    document.querySelector("#email_input").querySelector("p").innerHTML = "";
    if (loginBtn.classList.contains("disabled")) {
      loginBtn.classList.remove("disabled");
    }

    if (emailInput.value === "") {
      if (!loginBtn.classList.contains("disabled")) {
        loginBtn.classList.add("disabled");
      }
    }
  });

  let togglePwd = document.querySelector(".visible_togg");
  if (!togglePwd) return;
  togglePwd.addEventListener("click", () => {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      document.querySelector(".show_pwd").style.display = "flex";
      document.querySelector(".not_v").style.display = "none";
    } else {
      passwordInput.type = "password";
      document.querySelector(".not_v").style.display = "flex";
      document.querySelector(".show_pwd").style.display = "none";
    }
  });

  passwordInput.addEventListener("input", () => {
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

      startProgress();

      emailInput.disabled = true;
      loginBtn.disabled = true;
      loginBtn.classList.add("disabled");

      document.querySelector("#user_log_box").style.opacity = 0.4;

      try {
        const response = await fetch("../api/loginUser/loginUser.php", {
          method: "POST",
          body: loginUser,
        });

        if (response.ok) {
          const result = await response.json();

          if (result.success) {
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

              document.querySelector("#subH").textContent =
                "Enter your account password to securely continue and access your personalized dashboard.";

              loginBtn.classList.remove("disabled");
              loginBtn.disabled = false;
              loginBtn.textContent = "Login";
              stopProgress();
              document.querySelector("#user_log_box").style.opacity = 1;

              step = 2;

              document.querySelector(".social_login").style.display = "none";
              document.querySelector(".forgotten_pwd").style.display = "flex";
            }, 800);
          } else {
            stopProgress();
            emailInput.disabled = false;
            loginBtn.disabled = false;
            loginBtn.classList.remove("disabled");

            document.querySelector("#user_log_box").style.opacity = 1;
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
      let password = document.querySelector("#password").value.trim();
      if (!password) {
        document.querySelector("#pwd_input p").textContent =
          "Please provide your password to access your account";
        return;
      }

      const form = document.querySelector("#loginUser");
      const loginUser = new FormData(form);

      startProgress();

      document.querySelector("#password").disabled = true;
      loginBtn.disabled = true;
      loginBtn.classList.add("disabled");
      document.querySelector("#user_log_box").style.opacity = 0.4;

      try {
        const response = await fetch("../api/loginUser/verifyPassword.php", {
          method: "POST",
          body: loginUser,
        });

        if (response.ok) {
          const result = await response.json();

          if (result.success) {
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

              $(".count_down").html(
                `<p>Didn't receive the verification code? It could take a bit of time, request a new code in <span id="counter"></span>. </p>`
              );

              let otpTimer;
              function countDown() {
                clearInterval(otpTimer);
                let count = 60;
                const counterSpan = document.querySelector("#counter");

                otpTimer = setInterval(() => {
                  counterSpan.textContent = `${count} seconds`;
                  count--;

                  if (count < 0) {
                    clearInterval(otpTimer);
                    counterSpan.textContent = "0";
                    // show resend UI
                    document.querySelector(
                      ".container_resend"
                    ).style.visibility = "visible";
                    document.querySelector("#colx").style.visibility =
                      "visible";

                    document.querySelector(".count_down").style.display =
                      "none";
                  }
                }, 1000);
              }

              countDown();

              document.querySelector("#otp-message").textContent = `${
                result.message + " " + result.user_email
              } `;

              stopProgress();

              loginBtn.classList.remove("disabled");
              loginBtn.disabled = false;
              document.querySelector("#user_log_box").style.opacity = 1;

              step = 3;
            }, 800);

            // window.location.href = result.redirect;
          } else {
            stopProgress();
            document.querySelector("#password").disabled = false;
            loginBtn.disabled = false;
            loginBtn.classList.remove("disabled");

            document.querySelector("#user_log_box").style.opacity = 1;
            document.querySelector("#pwd_input p").textContent = result.message;
          }
        } else {
          throw new Error(`HTTP ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        console.error("Password verification failed:", error);
      }
    }
  });

  const verifyOptBtn = document.querySelector("#verify_opt");
  const otpInputs = document.querySelectorAll(".opt_input");

  otpInputs.forEach((input, index) => {
    input.addEventListener("input", () => {
      document.querySelector("#otp_error_msg").textContent = "";
      input.value = input.value.replace(/[^0-9]/g, "").slice(0, 1);

      if (input.value.length === 1 && index < otpInputs.length - 1) {
        otpInputs[index + 1].focus();
      }
    });

    input.addEventListener("keydown", (e) => {
      if (e.key === "Backspace" && input.value === "" && index > 0) {
        otpInputs[index - 1].focus();
      }
    });
  });

  otpInputs[0].addEventListener("paste", (e) => {
    e.preventDefault();
    const paste = (e.clipboardData || window.clipboardData).getData("text");
    if (/^\d{4}$/.test(paste)) {
      otpInputs.forEach((input, i) => {
        input.value = paste[i] || "";
      });
      otpInputs[otpInputs.length - 1].focus();
    }
  });

  verifyOptBtn.addEventListener("click", async () => {
    if (step !== 3) return; // only run at step 3

    let otp = "";

    otpInputs.forEach((input) => {
      otp += input.value;
    });

    if (otp.length < otpInputs.length) {
      const firstEmpty = Array.from(otpInputs).find((input) => !input.value);
      if (firstEmpty) firstEmpty.focus();
      return;
    }

    if (otp.length < 4) {
      document.querySelector("#otp_error_msg").textContent =
        "Please enter the full OTP";
      return;
    }

    const form = document.querySelector("#user_verify_otp");
    const formData = new FormData(form);

    startProgress();

    verifyOptBtn.classList.add("disabled");
    verifyOptBtn.disabled = true;
    document.querySelector("#otp_verify").style.opacity = 0.4;

    try {
      const response = await fetch("../api/loginUser/verify_otp.php", {
        method: "POST",
        body: formData,
      });

      if (response.ok) {
        const result = await response.json();

        if (result.success) {
          setTimeout(() => {
            stopProgress();
            document.querySelector("#otp_verify").style.opacity = 1;

            window.location.href = result.redirect;
          }, 1500);
        } else {
          stopProgress();
          verifyOptBtn.classList.remove("disabled");
          verifyOptBtn.disabled = false;
          document.querySelector("#otp_verify").style.opacity = 1;
          document.querySelector("#otp_error_msg").textContent = result.message;
          otpInputs.forEach((input) => (input.value = ""));
          otpInputs[0].focus();
        }
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.error("OTP verification failed:", error);
      document.querySelector("#otp_error_msg").textContent =
        "Something went wrong. Try again.";
    }
  }); // end function  verifyOptBtn
});
