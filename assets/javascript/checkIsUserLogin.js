 window.addEventListener("DOMContentLoaded" ,async () => {
     
          try {
            const response = await fetch("api/checkIsUserLogin.php");

            if(response.ok) {

                const result = await response.json();
                if(result.success) {
                   alert("you are login in")
                }else {
                    alert("you are not login in");
                }

            }else{
                throw new Error(`HTTPS ERROR STATUS ${response.status}`);
            }
            
          } catch (error) {
             console.log("error while if user is loginIn ", error);
          }
    
});