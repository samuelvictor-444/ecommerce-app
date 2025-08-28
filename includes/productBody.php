<?php
$product_slug = $_GET['name'] ?? null;

if ($product_slug) {
    require_once "./api/includes/dbh.inc.php";

    $query = " SELECT p.name AS product_name, 
               sc.name AS subcategory_name, sc.slug AS subcategory_slug,
               c.name AS category_name, c.slug AS category_slug
        FROM products p
        JOIN subCategories sc ON p.subcategory_id = sc.id
        JOIN categories c ON sc.category_id = c.id
        WHERE p.slug = :slug";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":slug", $product_slug);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>


<div class="warpper_container">


    <div class="body_container_wrapp">

        <!-- div that shows the path and product cetegorie -->
        <div class="cate_locat_section" id="bb">
            <?php if ($product) { ?>
                <h2 class="_mob_h2">You are here</h2>
                <a href="index.php" class="lin_sec ar">Home</a>
                <a class="lin_sec ar"><?= htmlspecialchars($product["category_name"]); ?></a>

                <a class="lin_sec ar"> <?= htmlspecialchars($product['subcategory_name']) ?></a>


                <a class="lin_sec "><?= htmlspecialchars($product['product_name']) ?></a>

            <?php } ?>
        </div>
        <!-- ends  div that shows the path and product cetegorie -->

        <!--  desktop product page view container  -->
        <div class="product_page_view pro_d_view">
            <section class="pr_">
                <div class="crad_ve">
                    <div class="col6_">
                        <div class="i_gm">
                            <!-- desktop product section  -->
                            <div class="pro_img_v">

                                <!-- product image -->
                                <a class="itm" id="maginify">

                                </a>
                                <!-- ends product image -->

                            </div>
                            <!--ends desktop product section  -->

                            <div class="pro_img_ve">
                                <!-- product image variation -->
                                <div class="flx_im caro"></div>
                                <!-- product image variation -->

                                <div class="sliderbtn">
                                    <button class="prev_b carousel_" type="button" id="leftid">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="currentColor">
                                            <path
                                                d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button class="next_b carousel_" type="button" id="rightid">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24" fill="currentColor">
                                            <path
                                                d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <section class="_hrs">
                            <h2 class="shr_">Share this product</h2>
                            <div class="_df_ic">
                                <button class="_rand" type="button" id="face_book">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"
                                        fill="currentColor">
                                        <path
                                            d="M14 13.5H16.5L17.5 9.5H14V7.5C14 6.47062 14 5.5 16 5.5H17.5V2.1401C17.1743 2.09685 15.943 2 14.6429 2C11.9284 2 10 .65686 10 6.69971V9.5H7V13.5H10V22H14V13.5Z">
                                        </path>
                                    </svg>
                                </button>
                                <button class="_rand" type="button" id="twitter">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"
                                        fill="currentColor">
                                        <path
                                            d="M22.2125 5.65605C21.4491 5.99375 20.6395 6.21555 19.8106 6.31411C20.6839 5.79132 21.3374 4.9689 21.6493 4.00005C20.8287 4.48761 19.9305 4.83077 18.9938 5.01461C18.2031 4.17106 17.098 3.69303 15.9418 3.69434C13.6326 3.69434 11.7597 5.56661 11.7597 7.87683C11.7597 8.20458 11.7973 8.52242 11.8676 8.82909C8.39047 8.65404 5.31007 6.99005 3.24678 4.45941C2.87529 5.09767 2.68005 5.82318 2.68104 6.56167C2.68104 8.01259 3.4196 9.29324 4.54149 10.043C3.87737 10.022 3.22788 9.84264 2.64718 9.51973C2.64654 9.5373 2.64654 9.55487 2.64654 9.57148C2.64654 11.5984 4.08819 13.2892 6.00199 13.6731C5.6428 13.7703 5.27232 13.8194 4.90022 13.8191C4.62997 13.8191 4.36771 13.7942 4.11279 13.7453C4.64531 15.4065 6.18886 16.6159 8.0196 16.6491C6.53813 17.8118 4.70869 18.4426 2.82543 18.4399C2.49212 18.4402 2.15909 18.4205 1.82812 18.3811C3.74004 19.6102 5.96552 20.2625 8.23842 20.2601C15.9316 20.2601 20.138 13.8875 20.138 8.36111C20.138 8.1803 20.1336 7.99886 20.1256 7.81997C20.9443 7.22845 21.651 6.49567 22.2125 5.65605Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </section>
                    </div>
                    <!-- div that display the product infomations  -->
                    <div class="col_10">
                        <!-- div that display the product name  -->
                        <div class="c0l_">
                            <div class="pr_na">
                                <h1 class="product_name"> </h1>
                            </div>
                            <a href="" class="fav_l">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                    fill="currentColor">
                                    <path
                                        d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853ZM18.827 6.1701C17.3279 4.66794 14.9076 4.60701 13.337 6.01687L12.0019 7.21524L10.6661 6.01781C9.09098 4.60597 6.67506 4.66808 5.17157 6.17157C3.68183 7.66131 3.60704 10.0473 4.97993 11.6232L11.9999 18.6543L19.0201 11.6232C20.3935 10.0467 20.319 7.66525 18.827 6.1701Z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <!--ends  div that display the product name  -->

                        <!-- div container that display the product info variation -->
                        <div class="c1l_">
                            <div class="pr_pric">
                                <div class="_pws">
                                    <!-- product name -->
                                    <span id="spn_pr" class="product_price"> </span>
                                    <div class="cont_old">
                                        <!-- product old price -->
                                        <span class="old_pr">&#x20A6; 13,400</span>
                                        <!-- product discount -->
                                        <span class="bugdt"> </span>
                                    </div>
                                </div>
                            </div>
                            <p class="-dft_p">Some variations with low stock</p>
                            <p class="-dft_p_low">9 unit left</p>
                            <div class="mark_up1">+ shipping from <em>&#x20A6; 600</em> to LEKKI-AJAH (SANGOTEDO)</div>

                            <div class="mar">
                                <div class="rate_">4.1 out of 5
                                    <div class="in_s"></div>
                                </div>
                                <!-- <a href="" class="more_r">(7 verified ratings)</a> -->
                            </div>

                        </div>
                        <!-- ends div container that display the product info variation -->

                        <!--  div container that display the product variation  -->
                        <div class="c2l_">
                            <div class="vary_wrpp">
                                <div class="hr_sct">
                                    <span>Variation available</span>
                                    <button type="button" class="more_" id="guide_s">Size Guide</button>
                                </div>
                                <div class="var">


                                </div>
                            </div>
                            <!-- div container that enable  user to add to cart  -->
                            <div class="container_add_to_cart">
                                <button type="button" class="add_cart add_me_c">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                        fill="currentColor">
                                        <path
                                            d="M12.0049 2C15.3186 2 18.0049 4.68629 18.0049 8V9H22.0049V11H20.8379L20.0813 20.083C20.0381 20.6013 19.6048 21 19.0847 21H4.92502C4.40493 21 3.97166 20.6013 3.92847 20.083L3.17088 11H2.00488V9H6.00488V8C6.00488 4.68629 8.69117 2 12.0049 2ZM18.8309 11H5.17788L5.84488 19H18.1639L18.8309 11ZM13.0049 13V17H11.0049V13H13.0049ZM9.00488 13V17H7.00488V13H9.00488ZM17.0049 13V17H15.0049V13H17.0049ZM12.0049 4C9.86269 4 8.1138 5.68397 8.00978 7.80036L8.00488 8V9H16.0049V8C16.0049 5.8578 14.3209 4.10892 12.2045 4.0049L12.0049 4Z">
                                        </path>
                                    </svg>
                                    <span>add to cart</span></button>
                                <div class="incre_decre">
                                    <button class="decrement btn_add" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="currentColor">
                                            <path d="M200-440v-80h560v80H200Z" />
                                        </svg>
                                    </button>

                                    <span class="inline counter">0</span>
                                    <button class="increment btn_add" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="currentColor">
                                            <path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!--ends div container that enable  user to add to cart  -->
                        </div>
                        <!--  div container that display the product variation  -->


                        <section class="prom_">
                            <h2 class="-hrw_">Promotions</h2>
                            <div class="bet_s">
                                <a href="" class="prz">
                                    <!-- <svg viewBox="0 0 24 24" class="ic -me-base -fsh0 -mrs" width="24" height="24">
                                        <use
                                            xlink:href="https://www.Aba Price.com.ng/assets_he/images/i-global.2771d4ef.svg#Aba Price-star">
                                        </use>
                                    </svg> -->
                                    Call 07006000000 To Place Your Order</a>
                                <a href="" class="prz">
                                    <!-- <svg viewBox="0 0 24 24" class="ic -me-base -fsh0 -mrs"
                                        width="24" height="24">
                                        <use
                                            xlink:href="https://www.Aba Price.com.ng/assets_he/images/i-global.2771d4ef.svg#Aba Price-star">
                                        </use>
                                    </svg> -->
                                    Need extra money? Loan up to N500,000 on the Aba PricePay Android app. </a>
                                <a href="" class="prz">
                                    <!-- <svg viewBox="0 0 24 24" class="ic -me-base -fsh0 -mrs" width="24" height="24">
                                        <use
                                            xlink:href="https://www.Aba Price.com.ng/assets_he/images/i-global.2771d4ef.svg#Aba Price-star">
                                        </use>
                                    </svg> -->
                                    Enjoy cheaper shipping fees when you select a PickUp Station at checkout.</a>
                            </div>
                        </section>
                    </div>
                    <!-- ends div that display the product infomations  -->

                    <div class="col11_1">
                        <a href="">Report incorrect product information</a>
                    </div>
                </div>
            </section>

            <!-- next section container div that display some information  -->
            <div class="col_4m">
                <section class="rev_pro">
                    <h2>Delivery & Returns</h2>
                    <div class="__hr">
                        <article class="_arf">
                            <div class="bbxt_p">
                                <h3><img src="./assets/images/crat.png" alt="" width="114px"></h3>
                                <p>Free delivery on thousands of products in Lagos, Ibadan & Abuja 
                                    <button class="a _more" id="deta_">Details</button>
                                </p>
                            </div>
                        </article>
                    </div>
                    <div class="__hr">
                        <article class="_arf">
                            <div class="pr_bxx">
                                <h3>Choose your location</h3>
                                <div class="locat">
                                    <div class="_fi_w_l">
                                        <select required="" id="states" class="sel  state_locale" name="state">
                                            <option value="" disabled>Please select</option>
                                            <option value="Abia">Abia</option>
                                            <option value="Adamawa">Adamawa</option>
                                            <option value="AkwaIbom">Akwa Ibom</option>
                                            <option value="Anambra">Anambra</option>
                                            <option value="Bauchi">Bauchi</option>
                                            <option value="6">Bayelsa</option>
                                            <option value="Bayelsa">Benue</option>
                                            <option value="Borno">Borno</option>
                                            <option value="cross_river">Cross River</option>
                                            <option value="delta">Delta</option>
                                            <option value="ebonyi">Ebonyi</option>
                                            <option value="Edo">Edo</option>
                                            <option value="Ekiti">Ekiti</option>
                                            <option value="Enugu">Enugu</option>
                                            <option value="FCT">Federal Capital Territory</option>
                                            <option value="Gombe">Gombe</option>
                                            <option value="Imo">Imo</option>
                                            <option value="Kaduna">Kaduna</option>
                                            <option value="Kano">Kano</option>
                                            <option value="Kogi">Kogi</option>
                                            <option value="Kwara">Kwara</option>
                                            <option value="Lagos" selected>Lagos</option>
                                            <option value="Nasarawa">Nasarawa</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Ogun">Ogun</option>
                                            <option value="Ondo">Ondo</option>
                                            <option value="30">Osun</option>
                                            <option value="Osun">Oyo</option>
                                            <option value="Plateau">Plateau</option>
                                            <option value="Rivers">Rivers</option>
                                        </select>
                                    </div>
                                    <div class="_fi_w_l">
                                        <select required="" class="sel select-lga" id="lga" name="lga" aria-label="lag">

                                        </select>
                                    </div>
                                </div>
                                <section class="sect_p">
                                    <div class="data_info_b ">
                                        <article class="_gf_p">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="40px" class="base"
                                                viewBox="0 -960 960 960" width="40px" fill="#5f6368">
                                                <path
                                                    d="M218.46-160q-24.58 0-41.52-16.94Q160-193.88 160-218.46v-139.28h33.85v139.28q0 9.23 7.69 16.92 7.69 7.69 16.92 7.69h139.28V-160H218.46Zm383.8 0v-33.85h139.28q9.23 0 16.92-7.69 7.69-7.69 7.69-16.92v-139.28H800v139.28q0 24.58-16.94 41.52Q766.12-160 741.54-160H602.26ZM160-602.26v-139.28q0-24.58 16.94-41.52Q193.88-800 218.46-800h139.28v33.85H218.46q-9.23 0-16.92 7.69-7.69 7.69-7.69 16.92v139.28H160Zm606.15 0v-139.28q0-9.23-7.69-16.92-7.69-7.69-16.92-7.69H602.26V-800h139.28q24.58 0 41.52 16.94Q800-766.12 800-741.54v139.28h-33.85ZM480-324.05q-64.79 0-110.37-45.58T324.05-480q0-64.79 45.58-110.37T480-635.95q64.79 0 110.37 45.58T635.95-480q0 64.79-45.58 110.37T480-324.05Zm0-33.85q51.13 0 86.62-35.48Q602.1-428.87 602.1-480t-35.48-86.62Q531.13-602.1 480-602.1t-86.62 35.48Q357.9-531.13 357.9-480t35.48 86.62Q428.87-357.9 480-357.9Zm0-122.1Z" />
                                            </svg>
                                            <div class="_cbet_way">
                                                <div class="cl_1">
                                                    <h4>Pickup Station</h4>
                                                    <button type="button" class="del" id="dilt_1">details</button>
                                                </div>
                                                <div class="cl_2">
                                                    <div class="cl_3">Delivery Fees <em>&#x20A6; 500</em></div>
                                                    <div class="cl_3">
                                                        Arriving at pickup station between
                                                        <em>22 August</em> &amp; <em>23 August</em> when you order
                                                        within next <em>28mins</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <article class="_gf_p">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="base" height="40"
                                                viewBox="0 -960 960 960" width="40" fill="#5f6368">
                                                <path
                                                    d="M227.51-195.38q-43.66 0-74.05-30.52-30.38-30.51-30.38-74.1H67.69v-395.38q0-27.62 18.5-46.12 18.5-18.5 46.12-18.5h529.23v144.62h92.31l138.46 186.15V-300h-64.62q0 43.59-30.56 74.1-30.57 30.52-74.23 30.52-43.67 0-74.05-30.52-30.39-30.51-30.39-74.1H332.31q0 43.85-30.57 74.23-30.56 30.39-74.23 30.39Zm.18-40q27 0 45.81-18.81Q292.31-273 292.31-300q0-27-18.81-45.81-18.81-18.81-45.81-18.81-27 0-45.81 18.81-18.8 18.81-18.8 45.81 0 27 18.8 45.81 18.81 18.81 45.81 18.81ZM107.69-340h25.85q8.54-26.46 34.77-45.54 26.23-19.08 59.38-19.08 31.62 0 58.62 18.7 27 18.69 35.54 45.92h299.69v-380H132.31q-9.23 0-16.93 7.69-7.69 7.69-7.69 16.93V-340Zm615.39 104.62q27 0 45.8-18.81Q787.69-273 787.69-300q0-27-18.81-45.81-18.8-18.81-45.8-18.81-27 0-45.81 18.81Q658.46-327 658.46-300q0 27 18.81 45.81 18.81 18.81 45.81 18.81ZM661.54-420H850L732.31-575.38h-70.77V-420ZM364.62-530Z" />
                                            </svg>
                                            <div class="_cbet_way">
                                                <div class="cl_1">
                                                    <h4>Door Delivery</h4>
                                                    <button type="button" class="del" id="dilt">details</button>
                                                </div>
                                                <div class="cl_2">
                                                    <div class="cl_3">Delivery Fees <em>&#x20A6; &#x20A6; 1,540</em>
                                                    </div>
                                                    <div class="cl_3">
                                                        Ready for delivery between
                                                        <em>22 August</em> &amp; <em>23 August</em> when you order
                                                        within next <em>28mins</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                </section>
                            </div>
                        </article>

                        <article class="_pas">
                            <svg xmlns="http://www.w3.org/2000/svg" class="base" height="40px" viewBox="0 -960 960 960"
                                width="40px" fill="#5f6368">
                                <path
                                    d="M207.13-355.9q-14-29.23-20.57-59.84Q180-446.36 180-478q0-124.56 87.85-212.87 87.84-88.31 212.15-88.31h66.64l-89.02-89.03 23.12-23.12 129.08 129.07-129.08 128.57-23.28-23.28 88.36-88.36H480q-110.56 0-188.36 78.21Q213.85-588.9 213.85-478q0 24.67 4.77 49.69 4.76 25.03 13.33 47.59l-24.82 24.82ZM478.95-67.69 349.87-196.77l129.08-128.56 22.61 22.61-88.51 89.03H480q110.56 0 188.36-78.22 77.79-78.22 77.79-189.12 0-24.66-4.43-49.69-4.44-25.02-13.82-47.59l24.82-24.82q13.49 29.23 20.38 59.85 6.9 30.61 6.9 62.25 0 124.57-87.85 212.88-87.84 88.3-212.15 88.3h-66.95l88.51 89.03-22.61 23.13Z" />
                            </svg>

                            <div class="_cbet_way">
                                <div class="cl_1">
                                    <h4>Return Policy</h4>
                                </div>
                                <div class="cl_2">
                                    <div class="cl_3">
                                        Free return within 7 days for ALL eligible items <a href="">Details</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>
                <div class="pty_pro">
                    <section class="card_s">
                        <a href="../seller_info_details/seller_info.php">
                            <h2>Seller Information</h2>
                            <svg xmlns="http://www.w3.org/2000/svg" class="by_" viewBox="0 0 24 24" width="24"
                                height="24" fill="currentColor">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>
                        </a>
                        <div class="in_ci_1">
                            <p>Weshopping-COD</p>
                            <div class="coi_1">
                                <div class="coi_2">
                                    <p><bdo dir="ltr" class="-prxs">94%</bdo>Seller Score</p>
                                    <p>
                                        <span class="-m"><strong>111</strong> </span> <span>Followers</span>
                                    </p>
                                </div>
                                <a href="">follow</a>
                            </div>
                        </div>
                        <div class="in_ci_2">
                            <h3>Seller Performance
                                <button type="button" id="perf">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                                        fill="currentColor">
                                        <path
                                            d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z">
                                        </path>
                                    </svg>
                                </button>
                            </h3>
                            <div class="clo_ry">
                                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12"
                                        fill="currentColor">
                                        <path
                                            d="M11.9998 17L6.12197 20.5902L7.72007 13.8906L2.48926 9.40983L9.35479 8.85942L11.9998 2.5L14.6449 8.85942L21.5104 9.40983L16.2796 13.8906L17.8777 20.5902L11.9998 17ZM11.9998 14.6564L14.8165 16.3769L14.0507 13.1664L16.5574 11.0192L13.2673 10.7554L11.9998 7.70792L10.7323 10.7554L7.44228 11.0192L9.94893 13.1664L9.18311 16.3769L11.9998 14.6564Z">
                                        </path>
                                    </svg></span>
                                <p>Order Fulfillment Rate:&nbsp; <b>Excellent</b></p>
                            </div>
                            <div class="clo_ry">
                                <span id="ave">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12"
                                        fill="currentColor">
                                        <path
                                            d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z">
                                        </path>
                                    </svg>
                                </span>
                                <p>Quality Score: &nbsp; <b>Average</b></p>
                            </div>
                            <div class="clo_ry">
                                <span id="ave_b">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12"
                                        fill="currentColor">
                                        <path
                                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </span>
                                <p>Customer Rating: &nbsp; <b>Poor</b></p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- ends next section container div that display some information  -->
        </div>
        <!--  ends desktop product page view container  -->


        <!-- mobile product veiw page container -->

        <div class="mobile_product_wrapper_con">

            <!-- end mobile slider container -->

            <div class="img_slider_product_mobile" id="maginify_mob"> </div>

            <!-- end mobile slider container -->

            <div class="container_section">
                <article>
                    <h1 class="product_name">Yamaha PSR-SX900 61-Key High-Level Arranger Keyboard</h1>
                    <div class="pr_pric">
                        <div class="_pws">
                            <span id="spn_pr" class="product_price">&#x20A6; 6,166</span>
                            <div class="cont_old">
                                <span class="old_pr">&#x20A6; 13,400</span>
                                <span class="bugdt">56%</span>
                            </div>
                        </div>
                    </div>
                    <p>in stock</p>
                    <p class="-dft_p_low">9 unit left</p>
                    <p>Brand : <span id="_brn">Yamaha | Similar products from Yamaha</span></p>
                    <div class="mark_up1">+ shipping from <em>&#x20A6; 600</em> to LEKKI-AJAH (SANGOTEDO)</div>
                    <div class="mar">
                        <div class="rate_">4.1 out of 5
                            <div class="in_s"></div>
                        </div>
                        <a href="" class="more_r">(7 verified ratings)</a>
                    </div>
                    <!--  div container that display the product variation  -->
                    <div class="c2l_ mVar">
                        <div class="hr_sct">
                            <span>Variation available</span>
                            <button type="button" class="more_" id="guide_s2">Size Guide</button>
                        </div>
                        <div>
                            <div class="var"></div>
                        </div>
                    </div>
                    <!--  div container that display the product variation  -->
                </article>
            </div>

            <section class="prom_">
                <h2 class="-hrw_">Promotions</h2>
                <div class="bet_s">
                    <a href="" class="prz">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24"
                            style="fill: rgba(0, 0, 0, 1);">
                            <path
                                d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                            </path>
                        </svg>
                        <span>Call 07006000000 To Place Your Order</span>
                    </a>
                    <a href="" class="prz">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24"
                            style="fill: rgba(0, 0, 0, 1);">
                            <path
                                d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                            </path>
                        </svg>
                        <span> Need extra money? Loan up to N500,000 on the Aba PricePay Android app.</span>
                    </a>
                    <a href="" class="prz">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24"
                            style="fill: rgba(0, 0, 0, 1);">
                            <path
                                d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                            </path>
                        </svg>
                        <span> Enjoy cheaper shipping fees when you select a PickUp Station at checkout. </span>
                    </a>
                </div>
            </section>

            <!-- ads container wrapper -->
            <div class="google_ads">
                <a href="">
                    <img src="assets/images/aab.png" alt="">
                </a>
            </div>
            <!-- ends ads container wrapper -->

            <!-- next section container div that display some information  -->
            <div class="col_4m">
                <section class="rev_pro">
                    <h2 class="header_c">Delivery & Returns</h2>
                    <div class="__hr">
                        <article class="_arf">
                            <div class="bbxt_p">
                                <h3><img src="" alt="" width="114px"></h3>
                                <p>Free delivery on thousands of products in Lagos, Ibadan & Abuja 
                                    <button class="a _more" id="detai_">Details</button>
                                </p>
                            </div>
                        </article>
                    </div>
                    <div class="__hr _pro_ch">
                        <article class="_arf">
                            <div class="pr_bxx">
                                <h3>Choose your location</h3>
                                <div class="locat">
                                    <div class="_fi_w_l">
                                        <select class="sel state_locale" id="state" aria-label="state">
                                            <option value="" disabled>Please select</option>
                                            <option value="Abia">Abia</option>
                                            <option value="Adamawa">Adamawa</option>
                                            <option value="AkwaIbom">Akwa Ibom</option>
                                            <option value="Anambra">Anambra</option>
                                            <option value="Bauchi">Bauchi</option>
                                            <option value="Bayelsa">Bayelsa</option>
                                            <option value="Benue">Benue</option>
                                            <option value="Borno">Borno</option>
                                            <option value="cross_river">Cross River</option>
                                            <option value="delta">Delta</option>
                                            <option value="Ebonyi">ebonyi</option>
                                            <option value="Edo">Edo</option>
                                            <option value="Ekiti">Ekiti</option>
                                            <option value="Enugu">Enugu</option>
                                            <option value="FCT">Federal Capital Territory</option>
                                            <option value="Gombe">Gombe</option>
                                            <option value="Imo">Imo</option>
                                            <option value="Kaduna">Kaduna</option>
                                            <option value="Kano">Kano</option>
                                            <option value="Kogi">Kogi</option>
                                            <option value="Kwara">Kwara</option>
                                            <option value="Lagos" selected>Lagos</option>
                                            <option value="Nasarawa">Nasarawa</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Ogun">Ogun</option>
                                            <option value="Ondo">Ondo</option>
                                            <option value="Osun">Osun</option>
                                            <option value="Oyo">Oyo</option>
                                            <option value="Plateau">Plateau</option>
                                            <option value="Rivers">Rivers</option>
                                        </select>
                                    </div>
                                    <div class="_fi_w_l">
                                        <select class="sel select-lga" id="lga">

                                        </select>
                                    </div>
                                </div>
                                <section class="sect_p">
                                    <div class="data_info_b ">
                                        <article class="_gf_p">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40"
                                                height="40" class="base" fill="currentColor">
                                                <path
                                                    d="M5.50045 20C6.32888 20 7.00045 20.6715 7.00045 21.5C7.00045 22.3284 6.32888 23 5.50045 23C4.67203 23 4.00045 22.3284 4.00045 21.5C4.00045 20.6715 4.67203 20 5.50045 20ZM18.5005 20C19.3289 20 20.0005 20.6715 20.0005 21.5C20.0005 22.3284 19.3289 23 18.5005 23C17.672 23 17.0005 22.3284 17.0005 21.5C17.0005 20.6715 17.672 20 18.5005 20ZM2.17203 1.75732L5.99981 5.58532V16.9993L20.0005 17V19H5.00045C4.44817 19 4.00045 18.5522 4.00045 18L3.99981 6.41332L0.757812 3.17154L2.17203 1.75732ZM16.0005 2.99996C16.5527 2.99996 17.0005 3.44768 17.0005 3.99996L16.9998 5.99932L19.9936 5.99996C20.5497 5.99996 21.0005 6.45563 21.0005 6.99536V15.0046C21.0005 15.5543 20.5505 16 19.9936 16H8.0073C7.45123 16 7.00045 15.5443 7.00045 15.0046V6.99536C7.00045 6.44562 7.4504 5.99996 8.0073 5.99996L10.9998 5.99932L11.0005 3.99996C11.0005 3.44768 11.4482 2.99996 12.0005 2.99996H16.0005ZM11.0005 7.99996H10.0005V14H11.0005V7.99996ZM18.0005 7.99996H17.0005V14H18.0005V7.99996ZM15.0005 4.99996H13.0005V5.99996H15.0005V4.99996Z">
                                                </path>
                                            </svg>
                                            <div class="_cbet_way">
                                                <div class="cl_1">
                                                    <h4>Pickup Station</h4>
                                                    <button type="button" class="del" id="dilt_1_te">details</button>
                                                </div>
                                                <div class="cl_2">
                                                    <div class="cl_3">Delivery Fees <em>&#x20A6; 500</em></div>
                                                    <div class="cl_3">
                                                        Arriving at pickup station between
                                                        <em>22 August</em> &amp; <em>23 August</em> when you order
                                                        within next <em>28mins</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <article class="_gf_p">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40"
                                                height="40" fill="currentColor" class="base">
                                                <path
                                                    d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z">
                                                </path>
                                            </svg>
                                            <div class="_cbet_way">
                                                <div class="cl_1">
                                                    <h4>Door Delivery</h4>
                                                    <button type="button" class="del" id="dilt_delive">details</button>
                                                </div>
                                                <div class="cl_2">
                                                    <div class="cl_3">Delivery Fees <em>&#x20A6; &#x20A6; 1,540</em>
                                                    </div>
                                                    <div class="cl_3">
                                                        Ready for delivery between
                                                        <em>22 August</em> &amp; <em>23 August</em> when you order
                                                        within next <em>28mins</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                </section>
                            </div>
                        </article>

                        <article class="_pas">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="base" width="40"
                                height="40" fill="currentColor">
                                <path
                                    d="M7 21.5C4.51472 21.5 2.5 19.4853 2.5 17C2.5 14.5147 4.51472 12.5 7 12.5C9.48528 12.5 11.5 14.5147 11.5 17C11.5 19.4853 9.48528 21.5 7 21.5ZM17 11.5C14.5147 11.5 12.5 9.48528 12.5 7C12.5 4.51472 14.5147 2.5 17 2.5C19.4853 2.5 21.5 4.51472 21.5 7C21.5 9.48528 19.4853 11.5 17 11.5ZM3 8C3 5.23858 5.23858 3 8 3H11V5H8C6.34315 5 5 6.34315 5 8V11H3V8ZM19 13V16C19 17.6569 17.6569 19 16 19H13V21H16C18.7614 21 21 18.7614 21 16V13H19Z">
                                </path>
                            </svg>

                            <div class="_cbet_way">
                                <div class="cl_1">
                                    <h4>Return Policy</h4>
                                </div>
                                <div class="cl_2">
                                    <div class="cl_3">
                                        Free return within 7 days for ALL eligible items <a href="">Details</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>
                <div class="pty_pro">
                    <section class="card_s">
                        <a href="../seller_info_details/seller_info.php">
                            <h2>Seller Information</h2>
                            <svg xmlns="http://www.w3.org/2000/svg" class="by_" viewBox="0 0 24 24" width="24"
                                height="24" fill="currentColor">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>
                        </a>
                        <div class="in_ci_1">
                            <p>Weshopping-COD</p>
                            <div class="coi_1">
                                <div class="coi_2">
                                    <p><bdo dir="ltr" class="-prxs">94%</bdo>Seller Score</p>
                                    <p>
                                        <span class="-m"><strong>111</strong> </span> <span>Followers</span>
                                    </p>
                                </div>
                                <a href="">follow</a>
                            </div>
                        </div>
                        <div class="in_ci_2">
                            <h3>Seller Performance
                                <button type="button" id="perf_2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                                        fill="currentColor">
                                        <path
                                            d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z">
                                        </path>
                                    </svg>
                                </button>
                            </h3>
                            <div class="clo_ry">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12"
                                        fill="currentColor">
                                        <path
                                            d="M11.9998 17L6.12197 20.5902L7.72007 13.8906L2.48926 9.40983L9.35479 8.85942L11.9998 2.5L14.6449 8.85942L21.5104 9.40983L16.2796 13.8906L17.8777 20.5902L11.9998 17ZM11.9998 14.6564L14.8165 16.3769L14.0507 13.1664L16.5574 11.0192L13.2673 10.7554L11.9998 7.70792L10.7323 10.7554L7.44228 11.0192L9.94893 13.1664L9.18311 16.3769L11.9998 14.6564Z">
                                        </path>
                                    </svg>
                                </span>
                                <p>Order Fulfillment Rate:&nbsp; <b>Excellent</b></p>
                            </div>
                            <div class="clo_ry">
                                <span id="ave">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12"
                                        fill="currentColor">
                                        <path
                                            d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z">
                                        </path>
                                    </svg>
                                </span>
                                <p>Quality Score: &nbsp; <b>Average</b></p>
                            </div>
                            <div class="clo_ry">
                                <span id="ave_b">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12"
                                        fill="currentColor">
                                        <path
                                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                                        </path>
                                    </svg>
                                </span>
                                <p>Customer Rating: &nbsp; <b>Poor</b></p>
                            </div>
                        </div>

                        <div class="sell_curren_prod "></div>
                    </section>
                </div>
            </div>
            <!-- ends next section container div that display some information  -->
            <div class="myn" id="product_details_mo">
                <h2 id="hrd">product details</h2>
                <a class="_dec" href="../seller_info_details/product_description.php">
                    <header class="pro_hr dsp">
                        <h2>Description</h2>
                        <svg class="sc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            fill="currentColor">
                            <path
                                d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                            </path>
                        </svg>
                    </header>
                </a>
                <div class="markup_con">
                    <div class="c">
                        <p><b>Weshopping-COD Focusing on the very latest in affordable Jumia fashion styles</b>, we
                            feature many newest product lines, providing maximum choice and convenience to our
                            discerning clientele. </p>
                        Details witness the quality, fine lines, tight splicing.Long sleeves with a sense of design are
                        essential in your wardrobe. You can pair it with jeans or slacks, which makes you the focus.The
                        design of cuff, decorate arm details, details reveal delicate!Detail experience, we do
                        better!Fit all types of situation.We also provide an extensive range of high quality, trendy
                        fashion clothing together to our valued customers.Our goal is always to provide our customers
                        with stunning, high quality fashion products at down to earth prices. Huge range of quality
                        fashion items: Extensive selection of the very latest styles for both clothing and
                        accessories.Long sleeves with a sense of design are essential in your wardrobe. You can pair it
                        with jeans or slacks, which makes you the focus。Come and join your shopping cart！！Exciting
                        products showcasing innovative styles are sourced and added daily by our experienced buyers.We
                        love fashion as much as you: Our fashion-savvy staff know quality when they see it, ensuring
                        that each item is perfect and ready to wear before it is shipped.Please be sure to purchase
                        products according to our size so that you will have a wonderful shopping experience.If the
                        project is good, please give it a five-star rating. Your praise is the driving force for our
                        continuous efforts.Please do ensure you include a valid, functioning phone number while ordering
                        for easy fast delivery.The color of the item may vary slightly due to the light and the screen,
                        pls understand it.Everything Is Under Best Arragement! Weshopping-cod offers trending
                        fashion-forward styles, edgy and innovative designs all delivered with a truly class-leading
                        professional service.
                    </div>
                </div>
            </div>


            <!-- div container that displays verified user comment -->

            <section class="specif">
                <h2 class="-hrw_w">Verified Customer Feedback</h2>
                <a href="../seller_info_details/product_reviews.php" id="comm">
                    <header class="pro_hr vri">
                        <h2>Product Rating & Reviews</h2>
                        <p class="hsx">
                            <span class="_score">4.3</span>
                            <span class="_sml">41 verified ratings</span>
                        </p>
                    </header>
                    <svg class="sc" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                        fill="currentColor">
                        <path
                            d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                        </path>
                    </svg>
                </a>

                <div class="rows_ ptyp">
                    <div class="cola_1">
                        <h2>Verified Ratings (70)</h2>
                        <div class="col_pesi">
                            <div class="pesi_p_1">
                                <b>3.9</b>/5
                            </div>
                            <div class="pesi_p_2star">
                                <div class="rated"></div>
                            </div>
                            <p>70 verified ratings</p>
                        </div>
                        <ul class="pt_xs">
                            <li aria-hidden="true">
                                5
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path
                                        d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                    </path>
                                </svg>
                                <p class="_pyt">(5)</p>
                                <div class="meter_ meter1"></div>
                            </li>
                            <li aria-hidden="true">
                                4
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path
                                        d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                    </path>
                                </svg>
                                <p class="_pyt">(1)</p>
                                <div class="meter_ meter2"></div>
                            </li>
                            <li aria-hidden="true">
                                3
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path
                                        d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                    </path>
                                </svg>
                                <p class="_pyt">(1)</p>
                                <div class="meter_ meter3"></div>
                            </li>
                            <li aria-hidden="true">
                                2
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path
                                        d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                    </path>
                                </svg>
                                <p class="_pyt">(1)</p>
                                <div class="meter_ meter4"></div>
                            </li>
                            <li aria-hidden="true">
                                1
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                    viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                    <path
                                        d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                    </path>
                                </svg>
                                <p class="_pyt">(0)</p>
                                <div class="meter_ meter5"></div>
                            </li>
                        </ul>
                    </div>
                    <div class="cola_2">
                        <h2 id="purc">Comments from Verified Purchases (5)</h2>
                        <article class="comment_section">
                            <div class="pesi_p_2star">
                                <div class="rated _rat"></div>
                            </div>
                            <h3> <?php echo "This is so lovely" ?> </h3>

                            <p> <?php echo "People love this on me am so happy" ?> </p>
                            <div class="user_com">
                                <div class="_user_id">
                                    <span id="_tyr"> <?php echo "22-08-2024" ?></span>
                                    <?php echo "<br>" ?>
                                    <span><?php echo "by SAMUEL OKHOIGBE" ?></span>
                                </div>
                                <div class="_verified_user">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22"
                                        fill="currentColor">
                                        <path
                                            d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                        </path>
                                    </svg>
                                    <?php echo "Verified Purchase" ?>
                                </div>
                            </div>
                        </article>

                        <article class="comment_section">
                            <div class="pesi_p_2star">
                                <div class="rated _rat1"></div>
                            </div>
                            <h3> <?php echo "not big enough pls" ?> </h3>
                            <p> <?php echo "People love this on me am so happy using this product because people love it on me thanks to aba price dot com you guys are great thank to the developer." ?>
                            </p>
                            <div class="user_com">
                                <div class="_user_id">
                                    <span id="_tyr"> <?php echo "22-08-2024" ?></span>
                                    <?php echo "<br>" ?>
                                    <span> <?php echo "by SAMUEL OKHOIGBE" ?></span>
                                </div>
                                <div class="_verified_user">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22"
                                        fill="currentColor">
                                        <path
                                            d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                        </path>
                                    </svg>
                                    <?php echo "Verified Purchase" ?>
                                </div>
                            </div>
                        </article>
                        <article class="comment_section">
                            <div class="pesi_p_2star">
                                <div class="rated _rat2"></div>
                            </div>
                            <h3> <?php echo "Nice" ?> </h3>
                            <p> <?php echo "People love this on me am so happy" ?> </p>
                            <div class="user_com">
                                <div class="_user_id">
                                    <span id="_tyr"> <?php echo "22-08-2024" ?></span>
                                    <?php echo "<br>" ?>
                                    <span><?php echo "by SAMUEL OKHOIGBE" ?></span>
                                </div>
                                <div class="_verified_user">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22"
                                        fill="currentColor">
                                        <path
                                            d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                        </path>
                                    </svg>
                                    <?php echo "Verified Purchase" ?>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <!-- ends div container that displays verified user comment -->

            <section class="_qes">
                <div class="aside_container_ _qu_cont">
                    <span>Questions about this product?</span>
                    <button type="button" class="chat_b">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                            fill="currentColor">
                            <path
                                d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM5.76282 17H20V5H4V18.3851L5.76282 17ZM11 10H13V12H11V10ZM7 10H9V12H7V10ZM15 10H17V12H15V10Z">
                            </path>
                        </svg>
                        chat
                    </button>
                </div>
            </section>

            <section class="_qes">
                <div class="aside_container_ _qu_cont_lin ">
                    <a href="" id="_abou_pro">Questions about this product?</a>
                </div>
            </section>

            <section class="add_c pro_d_view">
                <button class="mob_il cll i" id="_tel_pho" type="button">
                    <i class="bx bxs-phone bx-tada"></i>
                </button>
                <button class="add_me add_me_c" id="" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="add_bst" viewBox="0 0 24 24" width="24" height="24"
                        fill="currentColor">
                        <path
                            d="M12.0049 2C15.3186 2 18.0049 4.68629 18.0049 8V9H22.0049V11H20.8379L20.0813 20.083C20.0381 20.6013 19.6048 21 19.0847 21H4.92502C4.40493 21 3.97166 20.6013 3.92847 20.083L3.17088 11H2.00488V9H6.00488V8C6.00488 4.68629 8.69117 2 12.0049 2ZM18.8309 11H5.17788L5.84488 19H18.1639L18.8309 11ZM13.0049 13V17H11.0049V13H13.0049ZM9.00488 13V17H7.00488V13H9.00488ZM17.0049 13V17H15.0049V13H17.0049ZM12.0049 4C9.86269 4 8.1138 5.68397 8.00978 7.80036L8.00488 8V9H16.0049V8C16.0049 5.8578 14.3209 4.10892 12.2045 4.0049L12.0049 4Z">
                        </path>
                    </svg>
                    <span> add to cart</span>
                </button>
                <div class="incre_decre">
                    <button class="decrement btn_add" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="currentColor">
                            <path d="M200-440v-80h560v80H200Z" />
                        </svg>
                    </button>

                    <span class="inline counter">0</span>
                    <button class="increment btn_add" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="currentColor">
                            <path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z" />
                        </svg>
                    </button>
                </div>
            </section>

            <div class="top-container-wrapper" id="mobile_view_page">
                <div class="top-header-section --limi">
                    <div class="mq">
                        <h2>You Recently Viewed This Products</h2>
                    </div>
                    <a href="" class="_dis_n" id="_dis_none">see all <i class="ri-arrow-right-s-line"></i></a>
                </div>
                <!---- javascript carousel slider----->
                <div class="container-slider-box">
                    <div class="carousel-slider-container--">
                        <button id="prev-slide" class="slide-buttons slide-buttonCli"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="24"
                                width="24">
                                <path
                                    d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                </path>
                            </svg></button>

                        <!-- mobile recently viewed -->
                        <div class="product-list image-listsCli" id="mobileRecentV"> </div>

                        <!-- ends mobile recently viewed -->

                        <!-- <button id="next-slide" class="slide-buttons slide-buttonCli"><svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" height="24"
                                width="24">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg></button>
                        <div class="slider-scrollbarC slider-scrollbarCli">
                            <div class="scrollbar-trackC">
                                <div class="scrollbar-thumbC scrollbar-thumbsCli"></div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <!---- javascript carousel slider----->
            </div>

            <div class="top-container-wrapper" id="may_like_mobile">
                <div class="top-header-section --limi">
                    <div class="mq">
                        <h2>You may also like</h2>
                    </div>
                    <a href="" class="_dis_n" id="_dis_none">see all <i class="ri-arrow-right-s-line"></i></a>
                </div>
                <!---- javascript carousel slider----->
                <div class="container-slider-box">
                    <div class="carousel-slider-container--">
                        <!-- mobile recently viewed -->
                        <div class="product-list image-listsCli" id="may_likeMobile">


                        </div>

                        <!-- ends mobile recently viewed -->


                    </div>
                </div>
                <!---- javascript carousel slider----->
            </div>




        </div>

        <!-- ends mobile product veiw page container -->

        <!-- div container that displays the product details -->
        <div class="prod_det">
            <!-- div container that hold the product detail -->
            <div class="co_lp">
                <div class="myn" id="product_details">
                    <header class="pro_hr">
                        <h2>product details</h2>
                    </header>
                    <div class="markup_con">
                        <p><b>Weshopping-COD Focusing on the very latest in affordable Jumia fashion styles</b>, we
                            feature many newest product lines, providing maximum choice and convenience to our
                            discerning clientele. </p>
                        Details witness the quality, fine lines, tight splicing.Long sleeves with a sense of design are
                        essential in your wardrobe. You can pair it with jeans or slacks, which makes you the focus.The
                        design of cuff, decorate arm details, details reveal delicate!Detail experience, we do
                        better!Fit all types of situation.We also provide an extensive range of high quality, trendy
                        fashion clothing together to our valued customers.Our goal is always to provide our customers
                        with stunning, high quality fashion products at down to earth prices. Huge range of quality
                        fashion items: Extensive selection of the very latest styles for both clothing and
                        accessories.Long sleeves with a sense of design are essential in your wardrobe. You can pair it
                        with jeans or slacks, which makes you the focus。Come and join your shopping cart！！Exciting
                        products showcasing innovative styles are sourced and added daily by our experienced buyers.We
                        love fashion as much as you: Our fashion-savvy staff know quality when they see it, ensuring
                        that each item is perfect and ready to wear before it is shipped.Please be sure to purchase
                        products according to our size so that you will have a wonderful shopping experience.If the
                        project is good, please give it a five-star rating. Your praise is the driving force for our
                        continuous efforts.Please do ensure you include a valid, functioning phone number while ordering
                        for easy fast delivery.The color of the item may vary slightly due to the light and the screen,
                        pls understand it.Everything Is Under Best Arragement! Weshopping-cod offers trending
                        fashion-forward styles, edgy and innovative designs all delivered with a truly class-leading
                        professional service.
                    </div>
                </div>
                <!-- div section container that hold the product specification details -->
                <section class="specif" id="Specifications">
                    <header class="pro_hr">
                        <h2>Specifications</h2>
                    </header>

                    <div class="rows_">
                        <article class="col8_par">
                            <div class="card_b">
                                <h2>Key Features</h2>
                                <div class="marup">
                                    <ul>
                                        <li>Closure Type:Single Breasted</li>
                                        <li>Style:Casual</li>
                                        <li>Sleeve Style:REGULAR</li>
                                        <li>Model Number:Men Shirts</li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                        <article class="col8_par">
                            <div class="card_b">
                                <h2>What’s in the box</h2>
                                <div class="marup">
                                    1 x Mens Short Sleeve Shirt
                                </div>
                            </div>
                        </article>
                        <article class="col8_par">
                            <div class="card_b">
                                <h2>Specifications</h2>
                                <div class="marup">
                                    <ul class="ul_c">
                                        <li><b>SKU</b>: FA203MW2TOGLBNAFAMZ</li>
                                        <li><b>Product Line</b>: Weshopping-COD</li>
                                        <li><b>Weight (kg)</b>: 0.3</li>
                                        <li><b>Color</b>: Multicolor</li>
                                        <li><b>Care Label</b>: Details witness the quality, fine lines, tight splicing.
                                        </li>
                                        <li><b>Shop Type</b>: Aba Price Mall</li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>
                <!-- ends div section container that hold the product specification details -->


                <!-- div container that displays some product to users  second div container -->
                <div class="top-container-wrapper display_n" id="recently_viewed_wrp">
                    <div class="top-header-section">
                        <h2>You Recently Viewed This Products </h2>
                        <a href="">see all <i class="ri-arrow-right-s-line"></i></a>
                    </div>
                    <!---- javascript carousel slider----->
                    <div class="container-slider-box">
                        <div class="carousel-slider-container--">

                            <button id="prev-slide" class="slide-buttons slide-buttoncCon"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    height="24" width="24">
                                    <path
                                        d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                    </path>
                                </svg></button>

                            <div class="product-list image-listcCon" id="recently_viewed_p"></div>

                            <button id="next-slide" class="slide-buttons slide-buttoncCon"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    height="24" width="24">
                                    <path
                                        d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                    </path>
                                </svg></button>

                        </div>
                    </div>
                    <!---- javascript carousel slider----->
                </div>
                <!-- ends div container that displays some product to users  second div container -->

                <!-- div container that displays verified user comment  on desktop -->
                <section class="specif" id="Feedback">
                    <header class="pro_hr vri">
                        <h2>Verified Customer Feedback</h2>
                        <a href="../seller_info_details/product_reviews.php">see all <svg
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"
                                fill="currentColor">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg></a>
                    </header>

                    <div class="rows_ ptyp">
                        <div class="cola_1">
                            <h2>Verified Ratings (70)</h2>
                            <div class="col_pesi">
                                <div class="pesi_p_1">
                                    <b>3.9</b>/5
                                </div>
                                <div class="pesi_p_2star">
                                    <div class="rated"></div>
                                </div>
                                <p>70 verified ratings</p>
                            </div>
                            <ul class="pt_xs">
                                <li aria-hidden="true">
                                    5
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                        viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                        <path
                                            d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                        </path>
                                    </svg>
                                    <p class="_pyt">(5)</p>
                                    <div class="meter_ meter1"></div>
                                </li>
                                <li aria-hidden="true">
                                    4
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                        viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                        <path
                                            d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                        </path>
                                    </svg>
                                    <p class="_pyt">(1)</p>
                                    <div class="meter_ meter2"></div>
                                </li>
                                <li aria-hidden="true">
                                    3
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                        viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                        <path
                                            d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                        </path>
                                    </svg>
                                    <p class="_pyt">(1)</p>
                                    <div class="meter_ meter3"></div>
                                </li>
                                <li aria-hidden="true">
                                    2
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                        viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                        <path
                                            d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                        </path>
                                    </svg>
                                    <p class="_pyt">(1)</p>
                                    <div class="meter_ meter4"></div>
                                </li>
                                <li aria-hidden="true">
                                    1
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="sv"
                                        viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                                        <path
                                            d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z">
                                        </path>
                                    </svg>
                                    <p class="_pyt">(0)</p>
                                    <div class="meter_ meter5"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="cola_2">
                            <h2>Comments from Verified Purchases(5)</h2>
                            <article class="comment_section">
                                <div class="pesi_p_2star">
                                    <div class="rated _rat"></div>
                                </div>
                                <h3>This is so lovely</h3>
                                <p><?php echo "People love this on me am so happy using this product because people love it on me thanks to aba price dot com you guys are great thank to the developer." ?>
                                </p>
                                <div class="user_com">
                                    <div class="_user_id">
                                        <span id="_tyr">22-08-2024</span>
                                        <span>by SAMUEL OKHOIGBE</span>
                                    </div>
                                    <div class="_verified_user">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22"
                                            height="22" fill="currentColor">
                                            <path
                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                            </path>
                                        </svg>
                                        Verified Purchase
                                    </div>
                                </div>
                            </article>

                            <article class="comment_section">
                                <div class="pesi_p_2star">
                                    <div class="rated _rat1"></div>
                                </div>
                                <h3>not big enough </h3>
                                <p>People love this on me am so happy</p>
                                <div class="user_com">
                                    <div class="_user_id">
                                        <span id="_tyr">22-08-2024</span>
                                        <span>by SAMUEL OKHOIGBE</span>
                                    </div>
                                    <div class="_verified_user">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22"
                                            height="22" fill="currentColor">
                                            <path
                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                            </path>
                                        </svg>
                                        Verified Purchase
                                    </div>
                                </div>
                            </article>

                            <article class="comment_section">
                                <div class="pesi_p_2star">
                                    <div class="rated _rat2"></div>
                                </div>
                                <h3>Nice</h3>
                                <p>People love this on me am so happy</p>
                                <div class="user_com">
                                    <div class="_user_id">
                                        <span id="_tyr">22-08-2024</span>
                                        <span>by SAMUEL OKHOIGBE</span>
                                    </div>
                                    <div class="_verified_user">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22"
                                            height="22" fill="currentColor">
                                            <path
                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11.0026 16L6.75999 11.7574L8.17421 10.3431L11.0026 13.1716L16.6595 7.51472L18.0737 8.92893L11.0026 16Z">
                                            </path>
                                        </svg>
                                        Verified Purchase
                                    </div>
                                </div>
                            </article>

                        </div>
                    </div>
                </section>

                <!-- div container that displays some product the users may like second div container -->
                <div class="top-container-wrapper display_n">
                    <div class="top-header-section">
                        <h2>You may also like</h2>
                        <a href="">see all <i class="ri-arrow-right-s-line"></i></a>
                    </div>
                    <!---- javascript carousel slider----->
                    <div class="container-slider-box">
                        <div class="carousel-slider-container--">
                            <button id="prev-slide" class="slide-buttons slide-buttonSlideCarousels_"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    height="24" width="24">
                                    <path
                                        d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                    </path>
                                </svg></button>

                            <div class="product-list image-listSlideCarousels_ dRelated"></div>

                            <button id="next-slide" class="slide-buttons slide-buttonSlideCarousels_"><svg
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    height="24" width="24">
                                    <path
                                        d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                    </path>
                                </svg></button>

                        </div>
                    </div>
                    <!---- javascript carousel slider----->
                </div>
                <!-- ends div container that displays some product the users may like  thrid div container -->
            </div>
            <!-- ends div container that hold the product detail -->

            <!-- div container that displays product nav section -->
            <div class="_side_col4_cont">
                <div class="header_1">
                    <main id="n_v">
                        <a href="#product_details" class="pro_d">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                fill="currentColor">
                                <path
                                    d="M21 8V20.9932C21 21.5501 20.5552 22 20.0066 22H3.9934C3.44495 22 3 21.556 3 21.0082V2.9918C3 2.45531 3.4487 2 4.00221 2H14.9968L21 8ZM19 9H14V4H5V20H19V9ZM8 7H11V9H8V7ZM8 11H16V13H8V11ZM8 15H16V17H8V15Z">
                                </path>
                            </svg>
                            Product details
                        </a>
                        <a href="#Specifications" class="pro_d">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                fill="currentColor">
                                <path
                                    d="M8 4H21V6H8V4ZM4.5 6.5C3.67157 6.5 3 5.82843 3 5C3 4.17157 3.67157 3.5 4.5 3.5C5.32843 3.5 6 4.17157 6 5C6 5.82843 5.32843 6.5 4.5 6.5ZM4.5 13.5C3.67157 13.5 3 12.8284 3 12C3 11.1716 3.67157 10.5 4.5 10.5C5.32843 10.5 6 11.1716 6 12C6 12.8284 5.32843 13.5 4.5 13.5ZM4.5 20.4C3.67157 20.4 3 19.7284 3 18.9C3 18.0716 3.67157 17.4 4.5 17.4C5.32843 17.4 6 18.0716 6 18.9C6 19.7284 5.32843 20.4 4.5 20.4ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z">
                                </path>
                            </svg>
                            Specifications
                        </a>
                        <a href="#Feedback" class="pro_d" id="feedba1c">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                fill="currentColor">
                                <path
                                    d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM4 18.3851L5.76282 17H20V5H4V18.3851ZM11 13H13V15H11V13ZM11 7H13V12H11V7Z">
                                </path>
                            </svg>
                            Verified Customer Feedback
                        </a>
                    </main>

                    <article class="card_dd">
                        <div class="_fd">
                            <img src="" class="product_img" alt="" width="96" height="96" />
                            <div class="col_4_cl">
                                <h3 class="product_name"></h3>
                                <div class="_pvs2">
                                    <span class="product_price"></span>
                                    <div class="con_old">
                                        <span class="old_pr">&#x20A6; 9,999</span>
                                        <span id="_per_" class="bugdt">27%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </article>

                    <div class="aside_container_">
                        <span>Questions about this product?</span>
                        <button type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                fill="currentColor">
                                <path
                                    d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM5.76282 17H20V5H4V18.3851L5.76282 17ZM11 10H13V12H11V10ZM7 10H9V12H7V10ZM15 10H17V12H15V10Z">
                                </path>
                            </svg>
                            chat
                        </button>
                    </div>
                </div>
            </div>

            <!-- ends div container that displays product nav section -->
        </div>
        <!-- ends div container that displays the product details -->

        <!-- div container that displays advert -->
        <div class="avert">
            <img src="assets/images/bannergoo.jpeg" alt="">
        </div>
        <!-- ends div container that displays advert -->


        <!-- container that holds zoom images -->
        <div class="maginify_con">
            <section class="cw_r">
                <button type="button" id="close_" class="cls_p"><svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                        <path
                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                        </path>
                    </svg>
                </button>
                <h1>Product Images</h1>
                <div class="cont_se1">
                    <div class="_pvw">
                        <div class="container_mi">
                            <div class="img_zoom_1">
                                <img src="" alt="" id="image_tab">
                            </div>
                            <div class="img_zoom">
                                <div class="im_dr">

                                    <div class="itm_e">
                                        <img src="" alt="" onclick="imageTab(this)">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- ends container that holds zoom images -->

        <!-- product selection variation container -->
        <div class="pop">
            <section class="cw_r">
                <button type="button" id="close_" class="cls_ close_me">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        fill="currentColor">
                        <path
                            d="M10.5859 12L2.79297 4.20706L4.20718 2.79285L12.0001 10.5857L19.793 2.79285L21.2072 4.20706L13.4143 12L21.2072 19.7928L19.793 21.2071L12.0001 13.4142L4.20718 21.2071L2.79297 19.7928L10.5859 12Z">
                        </path>
                    </svg>
                </button>
                <h1>Please select a variation</h1>
                <div class="cont_se -pyw">

                    <div class="cr_sel">




                    </div>


                    <div class="footer_section">
                        <button type="button" class="_cont_btns cont_nue" id="cont_shp">Continue Shopping</button>
                        <button type="button" class="_cont_btns _c disabled">View Cart and Checkout</button>
                    </div>
                </div>
            </section>
        </div>
        <!-- product selection variation container -->




        <!-- overlay hidden container box  that display some info -->
        <div class="over_lay over_lay1">
            <section class="dir">
                <button id="r_mon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        fill="currentColor">
                        <path
                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                        </path>
                    </svg>
                </button>
                <h2 id="he_text">Aba Price Express</h2>
                <div class="_f16_nop">
                    <div class="mp">
                        Aba Price Express for all the products indicated as Free Delivery in Lagos, Abuja, Ibadan,
                        Warri, Benin, Abeokuta, Akure, and Portharcourt can benefit from: <br>
                        1. Free door delivery on orders above ₦99,999 for Lagos, Abuja, Ibadan, Warri, Benin, Abeokuta,
                        Akure, and Port Harcourt. <br>
                        2. Free delivery on Pickup station orders above ₦14,999 for Lagos & Abeokuta while other cities
                        are above ₦9,999.
                        <br>
                        Note: Free delivery offer is not valid for bulky items. Aba Price Express offers you next-day
                        delivery in Lagos if you order before 2 pm.
                        <br><br>
                        Click <a href=""> here</a> to get more details.
                    </div>
                </div>
            </section>
        </div>

        <div class="over_lay over_lay2">
            <section class="dir">
                <button id="r_mon" class="mm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        fill="currentColor">
                        <path
                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                        </path>
                    </svg>
                </button>
                <h2 id="he_text">Delivery Details</h2>
                <div class="_f16_nop">
                    <div class="mp">
                        <h3>Pickup Station</h3>
                        <p class="dli">Delivery time starts from the day you place your order to the day your order
                            arrives at the pickup station. You will be notified of your order's arrival, and you have to
                            retrieve it within 5 days. If the order is not picked up, it will be automatically
                            cancelled.</p>
                        <h3 class="bts">Delivery Fee Details</h3>
                        <div class="tst">
                            <span id="spn_0">Total Delivery Amount</span>
                            <span id="spn">₦ 500</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>


        <div class="over_lay over_lay3">
            <section class="dir">
                <button id="r_mon" class="mm_1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        fill="currentColor">
                        <path
                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                        </path>
                    </svg>
                </button>
                <h2 id="he_text">Delivery Details</h2>
                <div class="_f16_nop">
                    <div class="mp">
                        <h3>Door Delivery</h3>
                        <p class="dli">Delivery time starts from the day you place your order to the day one of our
                            associates makes a first attempt to deliver to you. Delivery will be attempted 2 times over
                            5 days (7.00 am to 5.30 pm) after which the item will be cancelled, if you are unreachable
                            or unable to receive the order.</p>
                        <h3 class="bts">Delivery Fee Details</h3>
                        <div class="tst">
                            <span id="spn_0">Total Delivery Amount</span>
                            <span id="spn">₦ 1,540</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="over_lay over_lay4">
            <section class="dir">
                <button id="r_mon" class="mm_2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        fill="currentColor">
                        <path
                            d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z">
                        </path>
                    </svg>
                </button>
                <h2 id="he_text">Seller Performance</h2>
                <div class="_f16_nop">
                    <div class="mp">
                        <p class="dli">To help you decide on the best offer we have several key metrics to help you with
                            your decision</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- ends overlay hidden container box  that display some info -->


    </div>
</div>

<div class="message">

</div>