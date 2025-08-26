<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../includes/header.css" />
    <link rel="stylesheet" href="../includes/footer.css" />
    <link rel="stylesheet" href="assets/css/productCss/styles.css">
    <link rel="stylesheet" href="assets/css/productCss/cart_p.css">
    <script src="script.js"></script>
    <link href=" https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css " rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../jquery1.js"></script>
    <script src="../includes/loader.js"></script>
    <link rel="stylesheet" href="../includes/loader.css">
</head>

<body>
    <?php include '../includes/header.php' ?>
    <?php include '../includes/loader.php' ?>
    <div class="body_container_wrapper" id="bb">

        <!-- mobile check out section  -->
        <div class="mobile_check_out">
            <article class="moblie_check_out_art">
                <h1 class="_mobile_h1">cart summary</h1>
                <div class="_m_card">
                    <div class="cls">
                        <h2 class="_mob_h2">Subtotal</h2>
                        <p class="_mob_p">&#x20A6; 2,172,089</p>
                    </div>
                </div>

                <!-- mobile check container that holds the check out btn -->
                <div class="_mobile_che_btn">
                    <button class="mob_il cll" id="_tel_pho" type="button">
                        <i class='bx bxs-phone bx-tada'></i>
                    </button>
                    <button class="mob_il che_o" id="" type="button">
                        Checkout (&#x20A6; 2,172,089)
                    </button>
                </div>
                <!-- ends mobile check container that holds the check out btn -->
            </article>
        </div>
        <!-- ends mobile check out section  -->

        <!-- CONTAINER THAT DISPLAY EMPTY CART BOX TO THE USER  -->

        <div class="empty_cart_box">
            <img src="../images/cart.668e6453.svg" alt="" height="100" width="100">
            <h2 class="-Pwy">Your cart is empty!</h2>
            <p class="-lh-15">Browse our categories and discover our best deals!</p>
            <button id="_start_shopping" class="_start_shopping_p">start shopping</button>
        </div>

        <!-- ENDS CONTAINER THAT DISPLAY EMPTY CART BOX TO THE USER  -->


<!----------------------------------------- CONTANINER THAT DISPLAY CART PRODUCT TO THE USERS---------------------------------------------->

        <div class="product_added_container">
            <div class="clo_4">
                <header class="-pvs">
                    <h2>Cart (4)</h2>
                </header>
                <article class="_product_added dr" id="product_c">
                    <a href="product_check.php" id="core">
                        <div class="img-c">
                            <img src="../images/parrotrice.jpg" alt="" width="72" height="72">
                        </div>

                        <div class="main_">
                            <h3 class="name">Qasa 16" 5 Blade Solar Standing Fan + Solar Panel</h3>
                            <p class="status">in stock</p>
                            <p class="status_"><span id="label">Seller :</span> Aba Price</p>
                            <p id="unit_left">Few uints left</p>
                            <div class="ft"><img src="../images/crat.png" alt=""></div>
                        </div>

                        <div class="sd_">
                            <div class="price_"> &#x20A6; 86,900</div>
                            <div class="src_pr">
                                <div class="old_p">&#x20A6; 115,000</div>
                                <div class="srg_h">24%</div>
                            </div>
                        </div>
                    </a>
                    <section class="bt">
                        <button class="btns_"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M7 4V2H17V4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7ZM6 6V20H18V6H6ZM9 9H11V17H9V9ZM13 9H15V17H13V9Z"></path>
                            </svg>Remove</button>

                        <form action="" method="post" class="-mal">
                            <button id="" class="_qty" value="" type="button" disabled="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path d="M5 11h14v2H5z"></path>
                                </svg>
                            </button>
                            <span class="incre">1</span>
                            <button id="" class="_qty" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                </svg>
                            </button>
                        </form>
                    </section>
                </article>

                <article class="_product_added dr" id="product_c">
                    <a href="product_check.php" id="core">
                        <div class="img-c">
                            <img src="../images/asion.jpg" alt="" width="72" height="72">
                        </div>

                        <div class="main_">
                            <h3 class="name">ASHION 2024 Men's Casual Shoes Big Size 39-47</h3>
                            <p class="status">in stock</p>
                            <p class="status_"><span id="label">Seller :</span>SAMUEL OKHOIGBE</p>
                            <p id="unit_left">Few uints left</p>
                            <div class="ft"><img src="../images/crat.png" alt=""></div>
                        </div>

                        <div class="sd_">
                            <div class="price_"> &#x20A6; 6,230</div>
                            <div class="src_pr">
                                <div class="old_p">&#x20A6; 15,000</div>
                                <div class="srg_h">24%</div>
                            </div>
                        </div>
                    </a>
                    <section class="bt">
                        <button class="btns_" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M7 4V2H17V4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7ZM6 6V20H18V6H6ZM9 9H11V17H9V9ZM13 9H15V17H13V9Z"></path>
                            </svg>Remove</button>

                        <form action="" method="post" class="-mal">
                            <button id="" class="_qty" value="" type="button" disabled="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path d="M5 11h14v2H5z"></path>
                                </svg>
                            </button>
                            <span class="incre">1</span>
                            <button id="" class="_qty" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                </svg>
                            </button>
                        </form>
                    </section>
                </article>

                <article class="_product_added dr" id="product_c">
                    <a href="" id="core">
                        <div class="img-c">
                            <img src="../images/school.jpg" alt="" width="72" height="72">
                        </div>

                        <div class="main_">
                            <h3 class="name">Backpack Casual Laptop School Bag</h3>
                            <p class="status">in stock</p>
                            <p class="status_"><span id="label">Seller :</span>FREE KNIGHT STORE</p>
                            <p id="unit_left">Few uints left</p>
                            <div class="ft"><img src="../images/crat.png" alt=""></div>
                        </div>

                        <div class="sd_">
                            <div class="price_"> &#x20A6; 6,256</div>
                            <div class="src_pr">
                                <div class="old_p">&#x20A6; 12,900</div>
                                <div class="srg_h">52%</div>
                            </div>
                        </div>
                    </a>
                    <section class="bt">
                        <button class="btns_" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M7 4V2H17V4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7ZM6 6V20H18V6H6ZM9 9H11V17H9V9ZM13 9H15V17H13V9Z"></path>
                            </svg>Remove</button>

                        <form action="" method="post" class="-mal">
                            <button id="" class="_qty" value="" type="button" disabled="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path d="M5 11h14v2H5z"></path>
                                </svg>
                            </button>
                            <span class="incre">1</span>
                            <button id="" class="_qty" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                </svg>
                            </button>
                        </form>
                    </section>
                </article>

                <article class="_product_added dr" id="product_c">
                    <a href="" id="core">
                        <div class="img-c">
                            <img src="../images/nio.jpg" alt="" width="72" height="72">
                        </div>

                        <div class="main_">
                            <h3 class="name">NIVEA Pearl & Beauty Anti-Perspirant Roll-on For Women 48h - 50ml (Pack Of 2)</h3>
                            <p class="status">in stock</p>
                            <p class="status_"><span id="label">Seller :</span>FREE KNIGHT STORE</p>
                            <p id="unit_left">Few uints left</p>
                            <div class="ft"><img src="../images/crat.png" alt=""></div>
                        </div>

                        <div class="sd_">
                            <div class="price_"> &#x20A6; 3,240</div>
                            <div class="src_pr">
                                <div class="old_p">&#x20A6; 3,600</div>
                                <div class="srg_h">10%</div>
                            </div>
                        </div>
                    </a>
                    <section class="bt">
                        <button class="btns_"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                <path d="M7 4V2H17V4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7ZM6 6V20H18V6H6ZM9 9H11V17H9V9ZM13 9H15V17H13V9Z"></path>
                            </svg>Remove</button>

                        <form action="" method="post" class="-mal">
                            <button id="" class="_qty" value="" type="button" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path d="M5 11h14v2H5z"></path>
                                </svg>
                            </button>
                            <span class="incre">1</span>
                            <button id="" class="_qty" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                </svg>
                            </button>
                        </form>
                    </section>
                </article>
            </div>

            <div class="col_2">
                <div class="card_pr">
                    <h1>CART SUMMARY</h1>
                    <div class="_prty">
                        <p id="_ow_a">Subtotal</p>
                        <p id="pp_r">&#x20A6; 17,996</p>
                    </div>
                    <p id="_pw">Delivery fees not included yet.</p>
                    <div class="check_out">
                        <button class="chek_out">Checkout (₦ 17,996)</button>
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


        <!------- TOP CONTAINER BANNER WRAPPER --->

        <div class="top-container-wrapper display_n">
            <div class="top-header-section">
                <h2>Top selling items</h2>
                <a href="">see all <i class="ri-arrow-right-s-line"></i></a>
            </div>
            <!---- javascript carousel slider----->
            <div class="container-slider-box">
                <div class="carousel-slider-container--">
                    <button id="prev-slide" class="slide-buttons slide-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="24" width="24">
                            <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path>
                        </svg></button>

                    <div class="product-list image-list">
                        <a href="product_check.php">
                            <div class="product-garllery">
                                <img src="../images/asion.jpg" alt="">
                                <div class="name">
                                    <p>ASHION 2024 Men's Casual Shoes Big Size 39-47</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/ph.jpg" alt="">
                                <div class="name">
                                    <p>Nokia C31 - 6.75" HD+ - 3GB/32GB MEMORY- 4G LTE- 5050mAh- Mint</p>
                                    <div class="price"><strong>&#x20A6; 83,930</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 99,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/del.jpg" alt="">
                                <div class="name">
                                    <p>ECOFLOW DELTA 2 Portable Power Station With 1-3kWh Expandable Capacity, LFP Battery, Fast Charging, For Home Backup Power, Camping & RVs</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../productImg/bluetooth.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/keyb.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/po.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/oo.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/pac8.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/pac4.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/pac10.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/pac6.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <button id="next-slide" class="slide-buttons slide-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="24" width="24">
                            <path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path>
                        </svg></button>
                    <div class="slider-scrollbarC slider-scrollbar">
                        <div class="scrollbar-trackC">
                            <div class="scrollbar-thumbC scrollbar-thumb"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!---- javascript carousel slider----->
        </div>
        <!------- TOP CONTAINER BANNER WRAPPER --->

        <div class="top-container-wrapper rec">
            <div class="top-header-section --limi">
                <div class="mq">
                    <h2>Recently Vewied Product</h2>
                </div>
                <a href="" id="_dis_none">see all <i class="ri-arrow-right-s-line"></i></a>
            </div>
            <!---- javascript carousel slider----->
            <div class="container-slider-box">
                <div class="carousel-slider-container--">
                    <button id="prev-slide" class="slide-buttons slide-buttonCli"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="24" width="24">
                            <path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path>
                        </svg></button>

                    <div class="product-list image-listsCli">
                        <a href="">
                            <div class="product-garllery">
                                <img src="../productImg/watch.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../productImg/indomie.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../productImg/speaker.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../productImg/bluetooth.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../productImg/dano.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/po.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/keyb.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/kk.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/nutri.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/kids.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>

                        <a href="">
                            <div class="product-garllery">
                                <img src="../images/oo.jpg" alt="">
                                <div class="name">
                                    <p>Ace Elec 20000 MAh Ultra Slim Portable Power Bank.</p>
                                    <div class="price"><strong>&#x20A6; 6,230</strong></div>
                                    <div class="old-price"><del><small>&#x20A6; 15,000</small></del></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <button id="next-slide" class="slide-buttons slide-buttonCli"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="24" width="24">
                            <path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"></path>
                        </svg></button>
                    <div class="slider-scrollbarC slider-scrollbarCli">
                        <div class="scrollbar-trackC">
                            <div class="scrollbar-thumbC scrollbar-thumbsCli"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!---- javascript carousel slider----->
        </div>


        <div class="over_lay">
            <section>
                <button id="r_mon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                    </svg>
                </button>
                <h2 id="he_text">Returns are easy</h2>
                <div class="_f16_no">
                    To know more about our return and refund policy, please visit: https://www.jumia.com.ng/sp-returns-refunds
                </div>
            </section>
        </div>

    </div>
    <?php include '../includes/footer.php' ?>


    <script>
        $(document).ready(function() {
            $('._start_shopping_p').click(function() {
                $(location).attr('href', 'index.php')
            });

            $('#_deta').click(function() {
                $('.over_lay').css('display', 'flex');
                $('.over_lay').fadeIn();
            });

            $('.over_lay').click(function() {
                $('.over_lay').css('display', 'none');
                $('.over_lay').fadeOut();
            });

            $('#_tel_pho').click(function() {
                $(location).attr('href', 'tel:09037870902');
            });
        });
    </script>
</body>

</html>