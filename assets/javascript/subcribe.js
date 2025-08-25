window.addEventListener("DOMContentLoaded", () => {
  document.querySelector("#m_subscribe").addEventListener("click", async () => {
    const userEmail = document.querySelector(".subscribe_m").value.trim();

    // check if user submit empty input
    if (!userEmail) {
      alert("please enter your email");
      return;
    }

    const form = document.querySelector("#sub_mob_user");

    const formData = new FormData(form);

    try {
      const response = await fetch("api/subcribeUser.php", {
        method: "POST",
        body: formData,
      });

      if (response.ok) {
        const result = await response.json();

        if (result.success) {
          alert(result.message);
        } else {
          alert(result.message);
        }
      } else {
        throw new Error(`HTTP ERROR STATUS ${response.status}`);
      }
    } catch (error) {
      console.log("error occured whil subcribing " + error);
    }
  });
});
