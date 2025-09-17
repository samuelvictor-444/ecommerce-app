window.addEventListener("DOMContentLoaded", () => {
  async function fetchUserDetails() {
    const userFirstName = document.querySelector("#first_name");
    const userLastName = document.querySelector("#last_name");
    const userFullName = document.querySelector("#user_name");
    userFullName.innerHTML = "";

    try {
      const response = await fetch("../api/loginUser/fetchUserDetails.php", {
        method: "POST",
      });

      if (response.ok) {
        const result = await response.json();

        if (result.success) {
          console.log(result.user);
          userFirstName.value = result.user.firstName;

          userLastName.value = result.user.lastName;

          userFullName.innerHTML = `Hello ${
            result.user.firstName + " " + result.user.lastName
          }`;

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
});
