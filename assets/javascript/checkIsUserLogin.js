window.addEventListener("DOMContentLoaded", async () => {
  try {
    const response = await fetch("api/checkIsUserLogin.php");

    if (response.ok) {
      const result = await response.json();
      if (result.success) {
        document.querySelector("#logIn_us").style.display = "none";

        document.querySelector(".container_banner_5").innerHTML = `
          
         <a id="loggedIn">
                <div class="container_link">login / signup</div>
            </a>
        
        `;

        document.querySelector(
          ".container_link"
        ).innerHTML = `Hi, ${result.userFirstName} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z"></path></svg>`;

        const containerNav = document.querySelector(".container_banner_5");
        const dropDown = `
             <div class="dd_content" id="">
                    <a href="" class="dd_links"><div class="user_a"> <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px" fill="currentColor"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>   My Profile </div></a>
                    <a href="" class="dd_links"><div class="user_a"> <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px" fill="currentColor"><path d="M160-160v-516L82-846l72-34 94 202h464l94-202 72 34-78 170v516H160Zm240-280h160q17 0 28.5-11.5T600-480q0-17-11.5-28.5T560-520H400q-17 0-28.5 11.5T360-480q0 17 11.5 28.5T400-440ZM240-240h480v-358H240v358Zm0 0v-358 358Z"/></svg> My Order</div>  </a>
                    <a href="" class="dd_links"><div class="user_a"> <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px" fill="currentColor"><path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Zm0-108q96-86 158-147.5t98-107q36-45.5 50-81t14-70.5q0-60-40-100t-100-40q-47 0-87 26.5T518-680h-76q-15-41-55-67.5T300-774q-60 0-100 40t-40 100q0 35 14 70.5t50 81q36 45.5 98 107T480-228Zm0-273Z"/></svg> My Saved Item </div></a>
                    <a href="" class="dd_links"><div class="user_a"> <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960" width="22px" fill="currentColor"><path d="M240-160q-66 0-113-47T80-320v-320q0-66 47-113t113-47h480q66 0 113 47t47 113v320q0 66-47 113t-113 47H240Zm0-480h480q22 0 42 5t38 16v-21q0-33-23.5-56.5T720-720H240q-33 0-56.5 23.5T160-640v21q18-11 38-16t42-5Zm-74 130 445 108q9 2 18 0t17-8l139-116q-11-15-28-24.5t-37-9.5H240q-26 0-45.5 13.5T166-510Z"/></svg> My Wallet </div></a>
                                        <a href="" class="dd_links"><div class="user_a"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#f8982d"><path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z"/></svg> Track My Orders </div></a>
  <a id="logout" class="dd_links logout"><div class="user_a"> <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg> Logout</div>
                </div></a>

        `;

        // Create a temporary container
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = dropDown;

        // Append the actual element to the container
        containerNav.appendChild(tempDiv.firstElementChild);

        // if user click logout btn
        containerNav.addEventListener("click", async (e) => {
          if (e.target.closest("#logout")) {
            try {
              const response = await fetch("api/loginUser/logout.php", {
                method: "POST",
              });

              if (response.ok) {
                const result = await response.json();

                if (result.success) {
                  location.reload(); // refresh page to show logged-out state
                  alert(result.message);
                }
              } else {
                throw new Error(`HTTPS ERROR STATUS ${response.status}`);
              }
            } catch (error) {
              console.log("error occured while trying to logout", error);
            }
          }
        });
      } else {
        document.querySelector(".container_link").textContent =
          "login / signup";
      }
    } else {
      throw new Error(`HTTPS ERROR STATUS ${response.status}`);
    }
  } catch (error) {
    console.log("error while if user is loginIn ", error);
  }
});
