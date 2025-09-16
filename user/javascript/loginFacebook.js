window.addEventListener("DOMContentLoaded", () => {
  window.fbAsyncInit = function () {
    FB.init({
      appId: "1125484135595374",
      cookies: true,
      xfbml: true,
      version: "v17.0",
    });
  };

  document.querySelector("#facebook").addEventListener("click", () => {
    FB.login(
      function (response) {
        if (response.authResponse) {
          const accessToken = response.authResponse.accessToken;
          const redirect =
            new URLSearchParams(window.location.search).get("redirect") || "/";

          (async () => {
            try {
              const response = await fetch(
                "../api/loginUser/facebook-login.php",
                {
                  method: "POST",
                  headers: { "Content-Type": "application/json" },
                  body: JSON.stringify({ accessToken }),
                }
              );

              if (response.ok) {
                const data = await response.json();

                if (data.success) {
                  const body = document.querySelector("body");
                  body.innerHTML = "";

                  const div = document.createElement("div");
                  div.classList.add("successfull");

                  const p = document.createElement("p");

                  const img = document.createElement("img");
                  img.classList.add("logo");
                  img.src = "../assets/images/acc_logo.png";

                  if (data.profile_incomplete) {
                    p.innerHTML = "Welcome! Let’s finish your profile setup.";

                    div.appendChild(img);
                    div.appendChild(p);
                    body.appendChild(div);

                    setTimeout(() => {
                      window.location.href = `./complete-profile.php?redirect=${redirect}`;
                    }, 4000);
                  } else {
                    p.innerHTML = "Login SuccessFull";

                    div.appendChild(img);
                    div.appendChild(p);
                    body.appendChild(div);

                    setTimeout(() => {
                      window.location.href = redirect;
                    }, 4000);
                  }
                } else {
                  console.error("Login failed:", data.message);
                }
              } else {
                throw new Error(`HTTPS ERROR STATUS ${response.status}`);
              }
            } catch (error) {
              console.log("error while login with facebook", error);
            }
          })();
        } else {
          console.log("User cancelled login or did not fully authorize.");
        }
      },
      { scope: "email,user_birthday,user_gender" }
    );
  });
});
