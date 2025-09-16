window.addEventListener("DOMContentLoaded", () => {
  async function fetchUserDetails() {
    try {
      const response = await fetch("../api/loginUser/fetchUserDetails.php",{
        method:"POST"
      });

      if (response.ok) {
        const result = await response.json();

        if (result.success) {
          alert("success");
        } else {
          alert(result.message);
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
