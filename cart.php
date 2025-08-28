<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href=" https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css " rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="assets/javascript/jquery.js"></script>
    <link rel="stylesheet" href="assets/css/productCss/styles.css">
    <link rel="stylesheet" href="assets/css/productCss/cart_p.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/category.css">
    <script src="assets/javascript/header_script.js"></script>
    <style>
        body {
            background-color: #f1f1f2;
        }

        .footer_container {
            margin-top: 0px;
        }

        .counter_ {
            cursor: default;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

      
    </style>


</head>

<body>
    <?php include './includes/header.php' ?>

    <div class="body_container_wrapper">

        <!-- mobile check out section  -->
        <div class="mobile_check_out">
            <article class="moblie_check_out_art">
                <h1 class="_mobile_h1">cart summary</h1>
                <div class="_m_card">
                    <div class="cls">
                        <h2 class="_mob_h2">Subtotal</h2>
                        <p class="_mob_p totalP"></p>
                    </div>
                </div>

                <!-- mobile check container that holds the check out btn -->
                <div class="_mobile_che_btn">
                    <button class="mob_il cll" id="_tel_pho" type="button">
                        <i class='bx bxs-phone bx-tada'></i>
                    </button>
                    <button class="mob_il che_o" id="" type="button">
                        Checkout (<span class="totalP"></span>)
                    </button>
                </div>
                <!-- ends mobile check container that holds the check out btn -->
            </article>
        </div>
        <!-- ends mobile check out section  -->

        <!-- CONTAINER THAT DISPLAY EMPTY CART BOX TO THE USER  -->

        <div class="empty_cart_box">
            <!-- <img src="assets/images/cart.668e6453.svg" alt="" height="100" width="100"> -->
            <svg xmlns="http://www.w3.org/2000/svg" height="56px" viewBox="0 -960 960 960" width="56px"
                fill="currentColor">
                <path
                    d="m634-440-81-80h69l110-200H353l-80-80h525q23 0 35.5 19.5t.5 42.5L692-482q-11 20-28 31t-30 11ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm540 52L566-280H304q-44 0-67-37.5t-3-78.5l42-86-72-162L28-820l56-56L876-84l-56 56ZM486-360l-80-80h-62l-40 80h182Zm136-160h-69 69Zm58 440q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80Z" />
            </svg>
            <h2 class="-Pwy">Your cart is empty!</h2>
            <p class="-lh-15">Browse our categories and discover our best deals!</p>
            <button id="_start_shopping" class="_start_shopping_p">start shopping</button>
        </div>

        <!-- ENDS CONTAINER THAT DISPLAY EMPTY CART BOX TO THE USER  -->


        <!----------------------------------------- CONTANINER THAT DISPLAY CART PRODUCT TO THE USERS---------------------------------------------->

        <div class="product_added_container">
            <div class="clo_4">
                <header class="-pvs">
                    <h2 class="counter_">Cart (4)</h2>
                </header>

                <div class="added_cart"> </div>

            </div>

            <div class="col_2">
                <div class="card_pr">
                    <h1>CART SUMMARY</h1>
                    <div class="_prty">
                        <p id="_ow_a">Subtotal</p>
                        <p id="pp_r" class="totalP">&#x20A6;</p>
                    </div>
                    <p id="_pw">Delivery fees not included yet.</p>
                    <div class="check_out">
                        <button class="chek_out">Checkout (<span class="totalP"></span>)</button>
                    </div>
                </div>

                <div class="_pas_">
                    <h2>Returns are easy</h2>
                    Free return within 7 days for ALL eligible items 
                    <button id="_deta">Details</button>
                </div>
            </div>
        </div>

        <!----------------------------------------- CONTANINER THAT DISPLAY CART PRODUCT TO THE USERS---------------------------------------------->

        <div class="top-container-wrapper rec" id="recently_viewed">
            <div class="top-header-section --limi">
                <div class="mq">
                    <h2>Recently Vewied Product</h2>
                </div>
                <a href="" id="_dis_none">see all <i class="ri-arrow-right-s-line"></i></a>
            </div>
            <!---- javascript carousel slider----->
            <div class="container-slider-box">
                <div class="carousel-slider-container--">

                    <div class="product-list image-listsCli" id="wrp_recent">


                    </div>

                </div>
            </div>
            <!---- javascript carousel slider----->
        </div>


        <div class="over_lay">
            <section>
                <button id="r_mon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        fill="currentColor">
                        <path
                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                        </path>
                    </svg>
                </button>
                <h2 id="he_text">Returns are easy</h2>
                <div class="_f16_no">
                    To know more about our return and refund policy, please visit:
                    https://www.jumia.com.ng/sp-returns-refunds
                </div>
            </section>
        </div>

    </div>
    <?php include './includes/footer.php' ?>



    <script>
        $(document).ready(function () {
            $('._start_shopping_p').click(function () {
                $(location).attr('href', 'index.php')
            });

            $('#_deta').click(function () {
                $('.over_lay').css('display', 'flex');
                $('.over_lay').fadeIn();
            });

            $('.over_lay').click(function () {
                $('.over_lay').css('display', 'none');
                $('.over_lay').fadeOut();
            });

            $('#_tel_pho').click(function () {
                $(location).attr('href', 'tel:09037870902');
            });
        });
    </script>
    <script src="assets/javascript/searchProduct.js"></script>
    <script src="assets/javascript/subcribe.js"></script>
    <script src="assets/javascript/getCartQty.js"></script>
    <script src="assets/javascript/loadSliderImages.js"></script>
    <script src="assets/javascript/getRecentlyViewed.js"></script>
    <script src="assets/javascript/displayCartItems.js"></script>
    <script src="assets/javascript/fetchCategory.js"></script>
    <script src="assets/javascript/updateItemInCart.js"></script>

    <div class="message"> </div>
</body>

</html>