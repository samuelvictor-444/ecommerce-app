<?php

$category = trim($_GET['category']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/mobile_filter.css">
    <script src="../assets/javascript/jquery.js"></script>
    <script src="javascript/fetchSubCateMobile.js"></script>
    <script src="javascript/shippedFrom.js"></script>
    <script src="javascript/fetchBrandsMobile.js"></script>
    <link rel="stylesheet" href="../assets/css/preloader.css">
</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader-text">
            <img src="../assets/images/logo_ic.png">
        </div>
    </div>



    <div class="jm" id="bb">
        <header class="hdr">
            <div class="main_contianer_">
                <a href="http://localhost/usman_clothing_service/category.php?category=<?php echo $category ?>"
                    class="nav_cont">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        fill="currentColor">
                        <path
                            d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z">
                        </path>
                    </svg></a>
                <h1 class="elli">Filter</h1>
            </div>
        </header>

        <div class="main_container_product_selection">
            <form action="" method="post" class="_previ">
                <div class="card_c">

                    <button type="button" class="_bet_s" id="dsp">
                        <div class="_oh">
                            <h1>Category</h1>
                            <div id="wrp_">
                                <p><?php echo $category ?></p>
                                <span id="sub_w"></span>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ic" viewBox="0 0 24 24" width="24" height="24"
                            fill="currentColor">
                            <path
                                d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                            </path>
                        </svg>
                    </button>

                    <button type="button" class="_bet_s bran" id="brand_s">
                        <div class="_oh">
                            <h1>Brand</h1>
                            <div id="wrp_">
                                <span id="sub_brands"></span>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ic" viewBox="0 0 24 24" width="24" height="24"
                            fill="currentColor">
                            <path
                                d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                            </path>
                        </svg>
                    </button>


                    <article class="_hr_sec">
                        <header class="_phm">
                            <h2>Price (₦)</h2>
                        </header>

                        <fieldset class="rng_" name="price">
                            <div class="rs_w">
                                <input type="range" min="310" max="804600" value="310" id="fromSlider"
                                    class="fromSlider">
                                <input type="range" min="310" max="804600" value="804600" id="toSlider"
                                    class="toSlider">
                            </div>
                            <div class="ris_w">
                                <div class="ri_f">
                                    <label for="fi-price_min">Min.</label>
                                    <div class="ri_w">
                                        <input type="number" class="price_min" value="310" min="310" max="804600"
                                            id="fromInput" placeholder="Min">
                                    </div>
                                </div>
                                <div class="ri_f">
                                    <label for="fi-price_min">Max.</label>
                                    <div class="ri_w">
                                        <input type="number" class="price_max" value="804600" min="310" max="804600"
                                            id="toInput" placeholder="Max">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </article>

                    <article class="_hr_sec">
                        <header class="_phm">
                            <h2>Product Rating</h2>
                            <button type="button" id="resetRate">reset</button>
                        </header>
                        <fieldset name="Rating" class="fi_w w">
                            <legend>rating</legend>

                            <div class="pvs">
                                <input type="radio" class="rad rate" id="fa_rating_0" name="ratings" value="4-5">
                                <label for="fa_rating_0" class="lab">
                                    <div class="star">
                                        <div class="in" style="width: 20%;"></div>
                                    </div>
                                    &amp; above
                                </label>
                            </div>

                            <div class="pvs">
                                <input type="radio" class="rad rate" id="fa_rating_1" name="ratings" value="3-5">
                                <label for="fa_rating_1" class="lab">
                                    <div class="star">
                                        <div class="in" style="width: 40%;"></div>
                                    </div>
                                    &amp; above
                                </label>
                            </div>

                            <div class="pvs">
                                <input type="radio" class="rad rate" id="fa_rating_2" name="ratings" value="2-5">
                                <label for="fa_rating_2" class="lab">
                                    <div class="star">
                                        <div class="in" style="width: 60%;"></div>
                                    </div>
                                    &amp; above
                                </label>
                            </div>

                            <div class="pvs">
                                <input type="radio" class="rad rate" id="fa_rating_3" name="ratings" value="1-5">
                                <label for="fa_rating_3" class="lab">
                                    <div class="star">
                                        <div class="in" style="width: 80%;"></div>
                                    </div>
                                    &amp; above
                                </label>
                            </div>

                        </fieldset>
                    </article>

                    <article class="_hr_sec">
                        <header class="_phm">
                            <h2>Discount Percentage</h2>
                            <button type="button" id="resetDicount">reset</button>
                        </header>
                        <fieldset name="price_discount" class="fi_w w">
                            <legend>price_discount</legend>

                            <div class="pvs">
                                <input type="radio" class="rad discount" id="fa_price_discount_0" name="discounts"
                                    value="4-5">
                                <label for="fa_price_discount_0" class="lab">
                                    40% &amp; above
                                </label>
                            </div>

                            <div class="pvs">
                                <input type="radio" class="rad discount" id="fa_price_discount_1" name="discounts"
                                    value="3-5">
                                <label for="fa_price_discount_1" class="lab">
                                    30% &amp; above
                                </label>
                            </div>

                            <div class="pvs">
                                <input type="radio" class="rad discount" id="fa_price_discount_2" name="discounts"
                                    value="2-5">
                                <label for="fa_price_discount_2" class="lab">
                                    20% &amp; above
                                </label>
                            </div>

                            <div class="pvs">
                                <input type="radio" class="rad discount" id="fa_price_discount_3" name="discounts"
                                    value="1-5">
                                <label for="fa_price_discount_3" class="lab">
                                    10% &amp; above
                                </label>
                            </div>

                        </fieldset>
                    </article>

                    <article class="_hr_sec">
                        <header class="_phm">
                            <h2>Seller Score</h2>
                            <button type="button" id="seller_s">reset</button>
                        </header>
                        <fieldset name="price_discount" class="fi_w w">
                            <legend>seller_score</legend>

                            <div class="pvs">
                                <input type="radio" class="rad seller_score" id="fa_seller_score_0" name="sellerScores"
                                    value="4-5">
                                <label for="fa_seller_score_0" class="lab">
                                    80% &amp; above
                                </label>
                            </div>

                            <div class="pvs">
                                <input type="radio" class="rad seller_score" id="fa_seller_score_1" name="sellerScores"
                                    value="3-5">
                                <label for="fa_seller_score_1" class="lab">
                                    60% &amp; above
                                </label>
                            </div>

                            <div class="pvs">
                                <input type="radio" class="rad seller_score" id="fa_seller_score_2" name="sellerScores"
                                    value="2-5">
                                <label for="fa_seller_score_2" class="lab">
                                    40% &amp; above
                                </label>
                            </div>

                            <div class="pvs">
                                <input type="radio" class="rad seller_score" id="fa_seller_score_3" name="sellerScores"
                                    value="1-5">
                                <label for="fa_seller_score_3" class="lab">
                                    20% &amp; above
                                </label>
                            </div>

                        </fieldset>
                    </article>

                    <article class="_hr_sec">
                        <header class="_phm">
                            <h2>Shipped From</h2>
                            <button type="button" id="resetShippedFrom">reset</button>
                        </header>
                        <fieldset name="shipped_from" class="fi_w wrapper_shiped">


                        </fieldset>
                    </article>

                </div>
            </form>

            <div class="sc_ts">
                <button class="btn_s _ds" id="reset_btn" type="button" disabled>reset</button>
                <button id="show_p" class="btn_s _ds" disabled>Show Products</button>
            </div>
        </div>
        <!-- _prime -->
        <!-- hidden container that displays more sub categories -->
        <div class="categories_wrapper categorie">
            <header class="hdr">
                <div class="main_contianer_">
                    <a href="#" class="nav_cont" id="c_it">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            fill="currentColor">
                            <path
                                d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z">
                            </path>
                        </svg></a>
                    <h1 class="elli">Sub Category</h1>
                </div>
            </header>

            <main class="container_w">
                <form id="">
                    <article class="cat">
                        <fieldset class="fi_w w sub_cate_F" id="sub_category" name="category">
                            <legend>sub category</legend>


                        </fieldset>
                    </article>
                </form>
            </main>
        </div>
        <!-- ends hidden container that displays more sub categories -->


        <!-- hidden container that displays more variations -->
        <div class="categories_wrapper" id="variations__con">
            <header class="hdr">
                <div class="main_contianer_">
                    <a href="#" class="nav_cont" id="c_it_2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            fill="currentColor">
                            <path
                                d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z">
                            </path>
                        </svg></a>
                    <h1 class="elli vari"></h1>
                </div>
            </header>

            <main class="container_w">
                <form action="" method="get">
                    <article class="cat">
                        <header class="ser_c">
                            <div class="serh">
                                <svg xmlns="http://www.w3.org/2000/svg" class="ic_s" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                    </path>
                                </svg>
                                <input type="search" placeholder="Search" class="search_mode var_type" id="">
                            </div>
                        </header>
                        <fieldset class="fi_w w">

                            <ul id="" class="vari_tion"> </ul>
                        </fieldset>
                    </article>

                    <div class="comfrim_">
                        <button type="button" class="save" id="saveVari">save</button>
                    </div>
                </form>
            </main>
        </div>
        <!-- ends hidden container that displays more variations -->

        <!-- hidden container that displays brands by category -->
        <div class="categories_wrapper" id="brand_variations__con">
            <header class="hdr">
                <div class="main_contianer_">
                    <a href="#" class="nav_cont" id="c_it_3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            fill="currentColor">
                            <path
                                d="M7.82843 10.9999H20V12.9999H7.82843L13.1924 18.3638L11.7782 19.778L4 11.9999L11.7782 4.22168L13.1924 5.63589L7.82843 10.9999Z">
                            </path>
                        </svg></a>
                    <h1 class="elli vari">brand</h1>
                </div>
            </header>

            <main class="container_w">
                <form action="" method="get">
                    <article class="cat">
                        <header class="ser_c">
                            <div class="serh">
                                <svg xmlns="http://www.w3.org/2000/svg" class="ic_s" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                    </path>
                                </svg>
                                <input type="search" placeholder="Search" class="search_mode" id="searchBrandFilter">
                            </div>
                        </header>
                        <fieldset class="fi_w w">

                            <ul id="myULFilter" class="brands">


                            </ul>
                        </fieldset>
                    </article>

                    <div class="comfrim_">
                        <button type="button" class="save" id="saveBrands">save</button>
                    </div>
                </form>
            </main>
        </div>
        <!-- ends hidden container that displays brands by category -->



        <!-- hidden container that displays some info -->
        <div class="over_l" id="overy_lay">
            <div class="pop_up">
                <section class="cw">
                    <header class="t_bar">
                        <h2>Aba Price Express</h2>
                        <button type="button" class="cls" id="kil">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ic_" viewBox="0 0 24 24" width="24"
                                height="24" fill="currentColor">
                                <path
                                    d="M10.5859 12L2.79297 4.20706L4.20718 2.79285L12.0001 10.5857L19.793 2.79285L21.2072 4.20706L13.4143 12L21.2072 19.7928L19.793 21.2071L12.0001 13.4142L4.20718 21.2071L2.79297 19.7928L10.5859 12Z">
                                </path>
                            </svg>
                        </button>
                    </header>

                    <div class="markup">
                        JUMIA Express for all the products indicated as Free Delivery in Lagos, Abuja, Ibadan, Warri,
                        Benin, Abeokuta, Akure, and Portharcourt can benefit from:
                        <br>
                        1. Free door delivery on orders above ₦99,999 for Lagos, Abuja, Ibadan, Warri, Benin, Abeokuta,
                        Akure, and Port Harcourt.
                        <br>
                        2. Free delivery on Pickup station orders above ₦14,999 for Lagos &amp; Abeokuta while other
                        cities are above ₦9,999.
                        <br>
                        Note: Free delivery offer is not valid for bulky items.

                        JUMIA Express offers you next-day delivery in Lagos if you order before 2 pm.
                        <br><br>
                        Click <a href="https://www.jumia.com.ng/jumia-express/"> here</a> to get more details.
                    </div>
                </section>
            </div>
        </div>
        <!-- end hidden container that displays some info -->


    </div>

    <script src="javascript/mobileProductPrice.js"></script>
    <script>
        $(window).ready(function () {

            $("#dsp").click(function () {
                $(".categorie").css("display", "block");
                $(".categorie").animate({
                    left: "0px",
                }, 500)
            });

            $("#c_it").click(function () {
                $(".categorie").animate({
                    left: "-395px",
                }, 500);

                setTimeout(() => {
                    $(".categorie").css("display", "none");
                }, 500)
            })

            // function that toggle brands slider bar 
            $("#brand_s").click(function () {
                $("#brand_variations__con").css("display", "block");
                $("#brand_variations__con").animate({
                    left: "0px"
                });
            });

            $("#c_it_3").click(function () {
                $("#brand_variations__con").animate({
                    left: "-395px",
                });

                setTimeout(() => {
                    $("#brand_variations__con").css("display", "none");
                }, 500);
            })


        })
    </script>
    <script src="javascript/fetchCategoryAttr.js"></script>


</body>

</html>