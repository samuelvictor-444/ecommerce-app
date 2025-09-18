window.addEventListener("DOMContentLoaded", () => {
  const resendEmailBtn = document.querySelector("#resend_otp_email");
  const resendSmsBtn = document.querySelector("#resend_sms_email");
  const countDownContainer = document.querySelector(".count_down");
  const containerResend = document.querySelector(".container_resend");
  const colx = document.querySelector("#colx");
  const otpMessage = document.querySelector("#otp-message");
  const otpErrorMsg = document.querySelector("#otp_error_msg");

  if (!resendEmailBtn || !resendSmsBtn) return;

  function startProgress() {
    document.querySelectorAll(".progress_x").forEach((item) => {
      const slide = item.querySelector(".slide");
      item.classList.add("display");
      slide.style.animation = "none";
      void slide.offsetWidth; // reflow
      slide.style.animation = "";
    });
  }

  function stopProgress() {
    document.querySelectorAll(".progress_x").forEach((item) => {
      item.classList.remove("display");
    });
  }

  let otpTimer = null; // keep timer reference outside

  async function resendOtp(type) {
    if (otpTimer) return; // ignore clicks if countdown is running

    startProgress();

    // disable buttons while processing
    resendEmailBtn.disabled = true;
    resendSmsBtn.disabled = true;

    document.querySelector("#otp_verify").style.opacity = 0.4;

    try {
      const response = await fetch("../api/loginUser/resend_userOpt.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ type }),
      });

      if (!response.ok) throw new Error(`HTTP ERROR ${response.status}`);

      const result = await response.json();

      if (!result.success) {
        document.querySelector("#otp_verify").style.opacity = 1;
        otpErrorMsg.textContent = result.message || "Failed to resend OTP";
        resendEmailBtn.disabled = false;
        resendSmsBtn.disabled = false;

        setTimeout(() => {
          otpErrorMsg.textContent = "";
        }, 4000);

        return;
      }

      otpMessage.textContent = `${result.message}`;
      document.querySelector("#otp_verify").style.opacity = 1;

      // Hide resend buttons & show countdown
      containerResend.style.visibility = "hidden";
      colx.style.visibility = "hidden";
      countDownContainer.style.display = "flex";
      let count = 60;
      const counterSpan = document.querySelector("#counter");
      counterSpan.textContent = `${count} seconds`;

      otpTimer = setInterval(() => {
        count--; // decrement AFTER displaying
        if (count > 0) {
          counterSpan.textContent = `${count} seconds`;
        } else {
          clearInterval(otpTimer);
          otpTimer = null;
          counterSpan.textContent = "0";

          // Show buttons again
          containerResend.style.visibility = "visible";
          colx.style.visibility = "visible";
          countDownContainer.style.display = "none";

          // Re-enable buttons
          resendEmailBtn.disabled = false;
          resendSmsBtn.disabled = false;
        }
      }, 1000);
    } catch (error) {
      document.querySelector("#otp_verify").style.opacity = 1;
      console.error("Error resending OTP:", error);
      resendEmailBtn.disabled = false;
      resendSmsBtn.disabled = false;
    } finally {
      stopProgress();
    }
  }

  // Attach click events
  resendEmailBtn.addEventListener("click", (e) => {
    e.preventDefault();
    resendOtp("email");
  });

  resendSmsBtn.addEventListener("click", (e) => {
    e.preventDefault();
    resendOtp("sms");
  });
});
