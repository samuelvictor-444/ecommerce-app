window.addEventListener("DOMContentLoaded", async () => {
  await displaySideImg();
  await displaySliderImg();
  await fetchHearderBannerImage();
  await fetchHearderMobileBannerImage();
  await fetchMobileBannerSlider();
  await fetchMobileBanner();
});

async function displaySideImg() {
  const container = document.querySelector(".container_cont");

  if (!container) {
    console.warn("Slider container not found");
    return;
  }

  try {
    const response = await fetch(
      "api/get_sliderImages.php?category=sideBanner"
    );
    const images = await response.json();

    if (!Array.isArray(images)) {
      console.error("Invalid response format");
      return;
    }

    container.innerHTML = "";
    images.forEach((item) => {
      const div = document.createElement("div");
      div.className = "container_box";

      const img = document.createElement("img");
      img.src = item.banner_image;
      img.alt = item.banner_title;

      div.appendChild(img);
      container.appendChild(div);
    });
  } catch (error) {
    console.error("error occurred while fecthing banner images" + error);
  }
} // ends function displaySideImg

async function displaySliderImg() {
  const slider = document.querySelector(".slider");

  if (!slider) {
    console.warn("Slider container not found");
    return;
  }

  try {
    const response = await fetch(
      "api/get_sliderImages.php?category=homepage_slider"
    );
    const images = await response.json();

    if (!Array.isArray(images)) {
      console.error("Invalid response format");
      return;
    }

    slider.innerHTML = "";

    images.slice(0, 6).forEach((img) => {
      const imgTag = document.createElement("img");
      imgTag.className = "slider_imgs";
      imgTag.src = img.banner_image;
      imgTag.alt = img.banner_title;
      imgTag.loading = "lazy";

      slider.appendChild(imgTag);
    });

    displayRandImages();
  } catch (error) {
    console.error("erorr occurred while fetch images " + error);
  }
}

function displayRandImages() {
  const images = document.querySelectorAll(".slider_imgs");

  const nextBtn = document.querySelector(".next");
  const prevBtn = document.querySelector(".prev");

  if (images.length === 0 || !nextBtn || !prevBtn) return;

  let currentIndex = 0;
  let slideInterval = null;

  function showImg(index) {
    images.forEach((img, i) => {
      img.classList.remove("active");
    });

    images[index].classList.add("active");
  }

  function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    showImg(currentIndex);
  }

  function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImg(currentIndex);
  }

  function randomImg() {
    let randomIndex;
    do {
      randomIndex = Math.floor(Math.random() * images.length);
    } while (randomIndex === currentIndex);
    {
      currentIndex = randomIndex;
      showImg(currentIndex);
    }
  }

  function AutoStartSlide(interval = 5000) {
    if (!slideInterval) {
      slideInterval = setInterval(nextImage, interval);
    }
  }

  nextBtn.addEventListener("click", () => {
    nextImage();
  });

  prevBtn.addEventListener("click", () => {
    prevImage();
  });

  showImg(currentIndex);
  AutoStartSlide(5000);
} // ends display random images

async function fetchHearderBannerImage() {
  const container = document.querySelector(".container_banner");

  if (!container) {
    console.warn("container not found");
    return;
  }

  try {
    const response = await fetch(
      "api/get_sliderImages.php?category=headerBanner"
    );
    const bannerImg = await response.json();

    if (!Array.isArray(bannerImg)) {
      console.error("Invalid response format");
      return;
    }

    bannerImg.forEach((img) => {
      container.innerHTML += `  <img src="${img.banner_image}" alt="${img.banner_title}">`;
    });
  } catch (error) {
    console.error("error occured while fetching header banner img " + error);
  }
} //  ends fetchHearderBannerImage();

async function fetchHearderMobileBannerImage() {
  const mobileContainer = document.querySelector(".mobile_container_banner");

  if (!mobileContainer) {
    console.error("container not found");
    return;
  }

  try {
    const response = await fetch(
      "api/get_sliderImages.php?category=mobileBanner"
    );
    const banner = await response.json();

    if (!Array.isArray(banner)) {
      console.error("invalid response format");
      return;
    }

    banner.forEach((img) => {
      mobileContainer.innerHTML = `  <img src="${img.banner_image}" alt="${img.banner_title}">`;
    });
  } catch (error) {
    console.error("error occurred while fetching mobile banner " + error);
  }
}

async function fetchMobileBannerSlider() {
  const container = document.querySelector(".con_mob_body_slider");

  if (!container) {
    console.error("container not found");
    return;
  }

  try {
    const response = await fetch(
      "api/get_sliderImages.php?category=mobileSliderImg"
    );
    const Images = await response.json();

    if (!Array.isArray(Images)) {
      console.error("invalid response format");
      return;
    }

    container.innerHTML = "";

    Images.slice(0, 6).forEach((images) => {
      container.innerHTML += ` <a href="">
                <div class="slider_m_c">
                    <img src="${images.banner_image}" alt="${images.banner_title}">
                </div>
            </a>`;
    });
  } catch (error) {
    console.error("error occured while fetching moblise slider images " + error);
  }
}

async function fetchMobileBanner() {
  const container = document.querySelector(".mobile_banners_m");

  if (!container) {
    console.error("container not found");
    return;
  }

  try {
    const response = await fetch(
      "api/get_sliderImages.php?category=sideBanner"
    );
    const images = await response.json();

    if (!Array.isArray(images)) {
      console.error("invalid response format");
      return;
    }

    container.innerHTML = "";

    images.slice(0, 6).forEach((image) => {
      container.innerHTML += `
        <div class="container_mb">
                   <img src="${image.banner_image}" alt="${image.banner_title + image.id}">
             </div>
       `;
    });
  } catch (error) {
    console.error("error occurred while fetching images " + error);
  }
}
