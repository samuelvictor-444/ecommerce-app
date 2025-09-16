window.addEventListener("DOMContentLoaded", () => {
  const userEmailInput = document.querySelector("#userEmail");
  const userEmail = new URLSearchParams(window.location.search).get(
    "userEmail"
  );
  const resetBtn = document.querySelector("#Continue");
  const loginContainer = document.querySelector("#user_log_box");
  const otp_container = document.querySelector("#otp_verify");
  const resetPwdContainer = document.querySelector("#reset_pwd_c");
  const hiddenEmail = document.querySelector("#hiddenEmail");
  const h2 = document.querySelector("#verify_opt_h2");

  if (!userEmailInput || !resetBtn) return;

  userEmailInput.value = userEmail || "";
  userEmailInput.disabled = !!userEmail;
  userEmailInput.classList.toggle("disabled_E", !!userEmail);

  const toggleButton = () => {
    if (userEmailInput.value.trim() !== "") {
      resetBtn.classList.remove("disabled");
    } else {
      resetBtn.classList.add("disabled");
    }
  };

  toggleButton(); // initial check
  userEmailInput.addEventListener("input", toggleButton);

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

  const state = { step: 1, redirect: "" };

  resetBtn.addEventListener("click", async () => {
    if (state.step === 1) {
      hiddenEmail.value = userEmailInput.value;

      const userEmail = hiddenEmail.value.trim();

      if (!userEmail) {
        document.querySelector("#error").textContent =
          "Oops! We need your email to continue.";
        return;
      }

      const form = document.querySelector("#reset_pwd_user");
      const formData = new FormData(form);

      startProgress();

      document.querySelector("#user_log_box").style.opacity = 0.4;
      resetBtn.disabled = true;
      resetBtn.classList.add("disabled");

      try {
        const response = await fetch("../api/loginUser/reset_user_pwd.php", {
          method: "POST",
          body: formData,
        });

        if (response.ok) {
          const result = await response.json();

          if (result.success) {
            setTimeout(() => {
              $(loginContainer).animate(
                { left: "-100%", opacity: 0 },
                500,
                function () {
                  $(this).hide();
                  $(otp_container)
                    .css({ display: "block", opacity: 0, left: "100%" })
                    .animate({ left: "0%", opacity: 1 }, 500);
                }
              );

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

              document.querySelector(
                "#otp-message"
              ).textContent = `${result.message} `;

              h2.textContent = "Security code to reset password";

              stopProgress();

              document.querySelector("#user_log_box").style.opacity = 1;
            }, 800);

            state.step = 2;
          } else {
            stopProgress();
            document.querySelector("#user_log_box").style.opacity = 1;
            document.querySelector("#error").textContent = result.message;
            resetBtn.disabled = false;
            resetBtn.classList.remove("disabled");
          }
        } else {
          stopProgress();
          throw new Error(`HTTPS ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        stopProgress();
        resetBtn.disabled = false;
        resetBtn.classList.remove("disabled");
        document.querySelector("#user_log_box").style.opacity = 1;
        document.querySelector("#error").textContent =
          "Unable to send otp verification code";
        console.error("unable to send otp verification code", error);
      }
    } // ends step 1
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

  const otpLength = otpInputs.length;
  otpInputs[0].addEventListener("paste", (e) => {
    e.preventDefault();
    const paste = (e.clipboardData || window.clipboardData).getData("text");

    const regex = new RegExp(`^\\d{${otpLength}}$`);
    if (regex.test(paste)) {
      otpInputs.forEach((input, i) => {
        input.value = paste[i] || "";
      });
      otpInputs[otpLength - 1].focus();
    }
  });

  verifyOptBtn.addEventListener("click", async () => {
    if (state.step === 2) {
      let otp = "";

      otpInputs.forEach((input) => {
        otp += input.value;
      });

      if (otp.length < otpInputs.length) {
        const firstEmpty = Array.from(otpInputs).find((input) => !input.value);
        if (firstEmpty) firstEmpty.focus();
        document.querySelector("#otp_error_msg").textContent =
          "Please enter the full OTP";
        return;
      }

      if (!/^\d+$/.test(otp)) {
        document.querySelector("#otp_error_msg").textContent =
          "Invalid OTP, only digits are allowed.";
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
              $(otp_container).animate(
                { left: "-100%", opacity: 0 },
                500,
                function () {
                  $(this).hide();
                  $(resetPwdContainer)
                    .css({ display: "block", opacity: 0, left: "100%" })
                    .animate({ left: "0%", opacity: 1 }, 500);
                }
              );

              document.querySelector("#otp_verify").style.opacity = 1;

              state.redirect = result.redirect;

              stopProgress();
            }, 800);

            state.step = 3;
          } else {
            stopProgress();
            verifyOptBtn.classList.remove("disabled");
            verifyOptBtn.disabled = false;
            document.querySelector("#otp_verify").style.opacity = 1;
            document.querySelector("#otp_error_msg").textContent =
              result.message;
            otpInputs.forEach((input) => (input.value = ""));
            otpInputs[0].focus();
          }
        } else {
          throw new Error(`HTTPS ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        stopProgress();
        console.error("OTP verification failed:", error);
        document.querySelector("#otp_verify").style.opacity = 1;

        document.querySelector("#otp_error_msg").textContent =
          "Something went wrong. Try again.";
      }
    } //  ends step 2
  });

  const newPwdResetBtn = document.querySelector("#reset_pwd_btn");
  const pwdInput = document.querySelector("#password");
  const pwdError = document.querySelector("#pwd_input_reset p");

  pwdInput.addEventListener("input", () => {
    newPwdResetBtn.removeAttribute("disabled");
    newPwdResetBtn.classList.remove("disabled");
    pwdError.textContent = "";
  });

  let togglePwd = document.querySelector(".visible_togg");
  if (!togglePwd) return;
  const hidePwd = document.querySelector(".not_v");
  const showPwd = document.querySelector(".show_pwd");

  togglePwd.addEventListener("click", () => {
    if (pwdInput.type === "password") {
      pwdInput.type = "text";
      showPwd.style.display = "flex";
      hidePwd.style.display = "none";
    } else {
      pwdInput.type = "password";
      hidePwd.style.display = "flex";
      showPwd.style.display = "none";
    }
  });

  newPwdResetBtn.addEventListener("click", async () => {
    if (state.step === 3) {
      if (!pwdInput.value.trim()) {
        pwdError.textContent = "New password is required";
        return;
      }

      if (pwdInput.value.length < 8) {
        pwdError.textContent = "Password must be at least 8 characters long.";
        return;
      }

      pwdError.textContent = "";

      const form = document.querySelector("#ch_pwd_user");
      const formData = new FormData(form);

      startProgress();

      newPwdResetBtn.disabled = true;
      newPwdResetBtn.classList.add("disabled");

      try {
        const response = await fetch("../api/loginUser/update_newPwd.php", {
          method: "POST",
          body: formData,
        });

        if (response.ok) {
          const result = await response.json();
          if (result.success) {
            stopProgress();
            const body = document.querySelector("body");
            body.innerHTML = "";

            const div = document.createElement("div");
            div.classList.add("successfull");

            const p = document.createElement("p");

            const img = document.createElement("img");
            img.classList.add("logo");
            img.src = "../assets/images/acc_logo.png";

            p.innerHTML = result.message;

            div.appendChild(img);
            div.appendChild(p);
            body.appendChild(div);

            setTimeout(() => {
              window.location.href = state.redirect;
            }, 4000);
          } else {
            stopProgress();
            pwdError.textContent = result.message;
            newPwdResetBtn.disabled = false;
            newPwdResetBtn.classList.remove("disabled");
          }
        } else {
          throw new Error(`HTTPS ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        newPwdResetBtn.disabled = false;
        newPwdResetBtn.classList.remove("disabled");
        console.error("error occured while reseting pwd", error);
        pwdError.textContent = "Something went wrong. Please try again.";
      }
    }
  });
});
