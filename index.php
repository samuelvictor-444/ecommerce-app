<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Clothes , Mens Wear's , Women's Clothes In Aba_Usman Online Shopping | Usman Clothing Services </title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <script src="assets/javascript/header_script.js"></script>
    <script src="assets/javascript/jquery.js"></script>

</head>

<body>

    <?php include_once './includes/header.php'; ?>

    <?php include_once './includes/body.php' ?>

    <?php include_once './includes/footer.php'; ?>

    <script src="assets/javascript/loadDeal.js"></script>
    <script src="assets/javascript/loadProduct2.js"></script>
    <script src="assets/javascript/loadCateAds.js"></script>
    <script src="assets/javascript/loadStoreProducts.js"></script>
    <script src="assets/javascript/searchProduct.js"></script>
    <script src="assets/javascript/loadSliderImages.js"></script>
    <script src="assets/javascript/fetchCategory.js"></script>
    <script src="assets/javascript/fetchStores.js"></script>
    <script src="assets/javascript/subcribe.js"></script>
    <script>
        $(window).ready(function () {

            $('.container_slider').mouseover(function () {
                $('.container_slider_btn button').fadeIn().css('display', 'flex');
            });

            $('.container_slider').mouseleave(function () {
                $('.container_slider_btn button').fadeOut();
            });
        });

        function slideStore(direction = "right") {

            let currentIndex = 0;
            let orginalSlide = [];

            const sliderContainer = document.querySelector(".container_category");
            const slides = sliderContainer.querySelectorAll("a");

            console.log(Array.from(slides))

            if (orginalSlide.length === 0) {
                orginalSlide = Array.from(slides);
            }

            const slideWidth = orginalSlide[0].offsetWidth;

            const isAtEnd =
                Math.ceil(sliderContainer.scrollLeft + sliderContainer.clientWidth) >=
                sliderContainer.scrollWidth;

            if (isAtEnd) {
                // Scroll back to start only after the last image is fully shown
                sliderContainer.scrollTo({
                    left: 0,
                    behavior: "smooth",
                });
                currentIndex = 0;
            } else {
                // Normal scroll
                sliderContainer.scrollBy({
                    left: direction === "right" ? slideWidth : -slideWidth,
                    behavior: "smooth",
                });

                currentIndex =
                    direction === "right"
                        ? (currentIndex + 1) % orginalSlide.length
                        : Math.max(0, currentIndex - 1);
            }
        }

        //  slideStore();
    </script>
    <script src="assets/javascript/getCartQty.js"></script>

</body>

</html>