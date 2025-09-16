function handleCredentialResponse(response) {
  const idToken = response.credential; // Google ID Token (JWT)

  const redirect =
    new URLSearchParams(window.location.search).get("redirect") || "/";

  fetch("../api/loginUser/google-login.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id_token: idToken }),
  })
    .then(async (res) => {
      const text = await res.text();
      console.log("Raw response:", text); // see what’s actually returned
      try {
        const data = JSON.parse(text);
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
          alert("Login failed: " + data.message);
        }
      } catch (e) {
        console.error("Invalid JSON response:", text, e);
      }
    })
    .catch((err) => console.error("Fetch error:", err));
}
