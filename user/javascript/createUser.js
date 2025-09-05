window.addEventListener("DOMContentLoaded", () => {
  const signInBtn = document.querySelector("#signInBtn");

  if (!signInBtn) {
    console.log("signInBtn not found");
    return;
  }

  signInBtn.addEventListener("click", async () => {
    const firstName = document.querySelector("#firstName").value.trim();
    const lastName = document.querySelector("#lastName").value.trim();
    const email = document.querySelector("#email").value.trim();
    const phone = document.querySelector("#phone").value.trim();
    const dateOfBirth = document.querySelector("#dateOfBirth").value.trim();
    const gender = document.querySelector("#gender").value.trim();
    const password = document.querySelector("#password").value.trim();

    // check if input are empty
    if (
      !firstName ||
      !lastName ||
      !email ||
      !phone ||
      !dateOfBirth ||
      !gender ||
      !password
    ) {
      console.log("please fill in all empty flieds");
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      console.log("Invalid email format");
      return;
    }

    const phoneRegex = /^[0-9]{10,15}$/; // Adjust length as needed
    if (!phoneRegex.test(phone)) {
      console.log("Invalid phone number");
      return;
    }

    const formData = document.querySelector("#createUser");

    const createUser = new FormData(formData);

    try {
      const response = await fetch("api/createUserAcc", {
        method: "POST",
        body: createUser,
      });

      if (response.ok) {
        const result = await response.json();

        if (result.success) {
          alert(result.message);
        } else {
          alert(result.message);
        }
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.error("Error while signing up user:", error);
      alert("Something went wrong. Please try again.");
    }
  });
});
