<div class="container">

    <div class="container_bann_in">
        <!-- container that holds the index slider -->

        <div class="container_slider">
            <!--  container that holds the index slider images -->
            <div class="slider">


            </div>

            <!-- ends container that holds the index slider images -->

            <div class="container_slider_btn">

                <button class="prev">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#1f1f1f">
                        <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
                    </svg>
                </button>

                <button class="next">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#1f1f1f">
                        <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- ends container that holds the index slider -->

        <!-- container that holds the slide img  -->
        <div class="container_cont">

        </div>
        <!-- container that holds the slide img  -->

    </div>

    <!-- mobile info section -->
    <div class="mobile_info_body_section">
        <p>call to order: 09037870902 , 08148714348 </p>
    </div>
    <!-- ends mobile info section -->

    <!-- mobile slider  -->
    <div class="mobile_body_slider">
        <!-- container that hold slider on mobile -->
        <div class="con_mob_body_slider"></div>
        <!-- ends container that hold slider on mobile -->
    </div>
    <!-- ends mobile slider  -->

    <!-- mobile banners   -->
    <div class="mobile_banners_m">

    </div>
    <!-- mobile banners   -->


    <!-- container that holds todas deal product -->
    <div class="container_deal">
        <div class="top_container">
            <h1>today's deal</h1>
        </div>

        <!-- container that hold todays deal product -->

        <div class="container_products">

        </div>

        <!-- ends container that hold todays deal product -->

    </div>
    <!--  ends container that holds todas deal product -->

    <!-- delivery items container -->

    <div class="container_deliv">
        <div class="top_container conainer_top2">
            <h1>Same Day Delivery (KongaNow)</h1>
        </div>

        <!-- container hold product cate -->
        <div class="container_prod" id="product2_id">


        </div>

        <!-- end container hold product cate -->
    </div>

    <!-- delivery items container -->

    <!-- container cate log -->

    <div class="container_category">

    </div>

    <!-- end container cate log -->


    <!-- container that hold promos  -->
    <div class="container_ads">

    </div>

    <!-- ends container that hold promos  -->

    <!-- product container 1 -->

    <div class="container_product_item">

        <div class="container_header_section">
            <h1>Usman Store</h1>
        </div>

        <!--  store product  -->

        <div class="product_container_" id="store_1">

        </div>

        <!--  ends  store product  -->
    </div>

    <!-- ends product container 1 -->

    <!-- product container 2 -->
    <div class="container_product_item">

        <div class="container_header_section store_id_2">
            <h1>Neiva Store</h1>
        </div>

        <!--  store product  -->

        <div class="product_container_" id="store_2">

        </div>

        <!--  ends  store product  -->

    </div>
    <!-- ends product container 2 -->

    <!--  container that hold info  -->
    <div class="container_online_info">
        <h3>Konga Online Shopping in Nigeria - Best Shopping Site</h3>
        <div class="_7b0d9_KpSFb">Konga.com is Nigeria’s number one online Shopping destination.We pride ourselves
            in having everything you could possibly need for life and living at the best prices than anywhere else.
            Our access to Original Equipment Manufacturers and premium sellers gives us a wide range of products at
            very low prices. Some of our popular categories include electronics, mobile phones, computers, <a
                href="https://www.konga.com/content/Cerave" style="color: #e80a80;">Fashion</a>, home and kitchen,
            Building and construction materials and a whole lot more from premium brands. Some of our other
            categories include Food and drinks, automotive and industrial, books, musical equipment, babies and kids
            items, sports and fitness, to mention a few. To make your shopping experience swift and memorable, there
            are also added services like gift vouchers, consumer promotion activities across different categories
            and bulk purchases with hassle-free delivery. Enjoy free shipping rates for certain products and with
            the bulk purchase option, you can enjoy low shipping rates, discounted prices and flexible payment. When
            you shop on our platform, you can pay with your debit card or via KongaPay, which is a convenient and
            secured payment solution. Get the best of lifestyle services online. Don't miss out on the biggest sales
            online which takes place on special dates yearly. Don't miss out on our <a
                href="https://www.konga.com/content/valentine2025" style="color: #e80a80;">Valentine 2025</a>. Buy
            <a href="https://www.konga.com/content/cerave" style="color: #0072CE;">CeraVe Facial Cleansers</a>, <a
                href="https://www.konga.com/brand/cerave" style="color: #0072CE;">CeraVe Skin Care</a>, <a
                href="https://www.konga.com/content/cerave" style="color: #0072CE;">CeraVe Moisturizers</a>, and
            more original <a href="https://www.konga.com/content/Cerave" style="color: #e80a80;">Cerave</a> &amp; <a
                href="https://www.konga.com/content/Garnier" style="color: #e80a80;">Garnier</a> Products in Nigeria
        </div>
        <div class="see_more">see more</div>
    </div>
    <!-- ends container that hold info  -->

    <!-- container that holds avaiable store -->

    <div class="avaiable_store_mobile">

    </div>

    <!-- ends container that holds avaiable store -->

</div>


<script>

    let currentIndex = 0;
    let orginalSlide = [];

    function scrollSlider_mob(direction = 'right') {
        const sliderContainer = document.querySelector('.con_mob_body_slider');
        const slides = sliderContainer.querySelectorAll('a');

        if (orginalSlide.length === 0) {
            orginalSlide = Array.from(slides);
        }

        const slideWidth = orginalSlide[0].offsetWidth;

        const isAtEnd = Math.ceil(sliderContainer.scrollLeft + sliderContainer.clientWidth) >= sliderContainer.scrollWidth;

        if (isAtEnd) {
            // Scroll back to start only after the last image is fully shown
            sliderContainer.scrollTo({
                left: 0,
                behavior: "smooth"
            });
            currentIndex = 0;
        } else {
            // Normal scroll
            sliderContainer.scrollBy({
                left: direction === 'right' ? slideWidth : -slideWidth,
                behavior: "smooth",
            });

            currentIndex = (direction === 'right')
                ? (currentIndex + 1) % orginalSlide.length
                : Math.max(0, currentIndex - 1);
        }
    }


    function seeMore() {
        const $seeContainer = $(".see_more");

        if (!$seeContainer) {
            console.log("container not found");
            return;
        }

        $seeContainer.click(function () {
            $("._7b0d9_KpSFb").toggleClass("seeOpen");
            const isOpen = $("._7b0d9_KpSFb").hasClass("seeOpen");
            $(this).html(isOpen ? "see less" : "see more");
        });

    } // ends function see more see less

  

    window.addEventListener("DOMContentLoaded", () => {
        setInterval(scrollSlider_mob, 4000);
        seeMore();
    });

</script>