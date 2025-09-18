window.addEventListener("DOMContentLoaded", () => {
  async function fetchUserDetails() {
    const userFirstName = document.querySelector("#first_name");
    const userLastName = document.querySelector("#last_name");
    const userFullName = document.querySelector("#user_name");
    const userPhone = document.querySelector("#user_phone");

    userFullName.innerHTML = "";

    const userDOB = document.querySelector("#userDOB");

    const userGender = document.querySelector("#user_gender");

    const userMiddleName = document.querySelector("#middle_name");

    try {
      const response = await fetch("../api/loginUser/fetchUserDetails.php", {
        method: "POST",
      });

      if (response.ok) {
        const result = await response.json();

        if (result.success) {
          userFirstName.value = result.user.firstName;

          userLastName.value = result.user.lastName;

          userFullName.innerHTML = `Hello ${
            result.user.firstName + " " + result.user.lastName
          }`;

          userDOB.value = result.user.dateOfBirth;
          userGender.value = result.user.gender;
          userMiddleName.value = result.user.middleName;

          userPhone.value = result.user.phoneNumber;
        } else {
          alert(result.message);
          setTimeout(() => {
            window.location.href = "./loginUser.php";
          }, 2000);
        }
      } else {
        throw new Error(`HTTPS ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.error("error occured while fetching user basic details", error);
    }
  } // ends function fetchUserDetails

  fetchUserDetails();

  function updateUserDetails() {
    const redirect =
      new URLSearchParams(window.location.search).get("redirect") ||
      "../index.php";
    if (!redirect) return;

    const updateBtn = document.querySelector("#saveUserDetails");
    updateBtn.addEventListener("click", async () => {
      const userFirstName = document.querySelector("#first_name");
      const userMiddleName = document.querySelector("#middle_name");

      const userLastName = document.querySelector("#last_name");
      const userGender = document.querySelector("#user_gender");
      const userDOB = document.querySelector("#userDOB");
      const userPhone = document.querySelector("#user_phone");

      if (!userFirstName.value.trim()) {
        userFirstName.classList.add("error");
        return;
      }

      if (!userLastName.value.trim()) {
        userLastName.classList.add("error");
        return;
      }

      if (!userMiddleName.value.trim()) {
        userMiddleName.classList.add("error");
        return;
      }

      if (!userGender.value.trim()) {
        userGender.classList.add("error");
        return;
      }

      if (!userDOB.value.trim()) {
        userDOB.classList.add("error");
        return;
      }

      if (!userPhone.value.trim()) {
        userPhone.classList.add("error");
        return;
      }

      const form = document.querySelector("#user_profile_form");
      const formData = new FormData(form);

      try {
        const response = await fetch("../api/loginUser/updateUserDetails.php", {
          method: "POST",
          body: formData,
        });

        if (response.ok) {
          const result = await response.json();

          const successBox = document.querySelector("#successBox");
          successBox.innerHTML = "";

          if (result.success) {
            successBox.innerHTML = result.message;
            successBox.classList.add("success", "show");

            setTimeout(() => {
              successBox.classList.remove("success", "show");
              successBox.innerHTML = "";
              window.location.href = redirect;
            }, 3000); // 3 seconds


          } else {
            successBox.innerHTML = result.message;
            successBox.classList.add("error", "show");

            setTimeout(() => {
              successBox.classList.remove("error", "show");
              successBox.innerHTML = "";
            }, 3000); // 3 seconds



          }
        } else {
          throw new Error(`HTTPS ERROR STATUS ${response.status}`);
        }
      } catch (error) {
        console.error(
          "error occured while updating users basic details",
          error
        );
      }
    }); // ends addEventListener updateBtn
  } // ends function updateUserDetails

  updateUserDetails();
});
