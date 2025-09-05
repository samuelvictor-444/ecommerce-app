

<?php

require_once "api/includes/dbh.inc.php";

$category_slug = trim($_GET["category"]);
$categoryName = "";
$productCount = 0;

if ($category_slug) {
    try {
        $query = "SELECT id , name FROM categories WHERE slug = :slug LIMIT 1";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":slug", $category_slug, PDO::PARAM_STR);

        $stmt->execute();

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            $categoryName = $category['name'];

            $stmt2 = $pdo->prepare("SELECT COUNT(*) as count FROM products WHERE category_id = :category_id");

            $stmt2->bindParam(":category_id", $category["id"], PDO::PARAM_INT);
            $stmt2->execute();

            $productCount = $stmt2->fetch(PDO::FETCH_COLUMN);
        }


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$selectedSort = trim($_GET['sort'] ?? "popularity");




?>



<div class="cate_pag_container" id="categoryProductsByTag">

    <div class="url_">
        <a href="index.php"> home</a>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
            <path
                d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
            </path>
        </svg>
        <a id="slug_id" class="slug_id_name"></a>
    </div>


    <div class="container_section" id="container_cate_sect">

    </div>

    <div class="container_section call_action">
        <h1>call to order : 09037870902</h1>
    </div>

    <div class="cate_container_product">

        <!-- displays sub categories -->
        <div class="container_sub_cate">

        </div>
        <!-- ends displays sub categories -->

        <button class="prev btns_cate" id="left" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                <path
                    d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                </path>
            </svg>
        </button>

        <button class="next btns_cate" id="right" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                <path
                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                </path>
            </svg>
        </button>

    </div>

    <div class="container_store_cate">

        <div class="container_h">
            <h1>Official Stores</h1>
        </div>

        <!-- container that holds list of official stores -->

        <div class="container_st"> </div>
        <!-- ends container that holds list of official stores -->
    </div>



    <div class="container_wrapper_p_cate">
        <div class="container_side_section">
            <h1>Category</h1>

            <div class="container_cate_side">
                <h2 class="slug_cate"></h2>
                <div class="sub_cate_sec">
                    <!-- <a href=""><span>men's fashion</span></a> -->
                </div>
            </div>

            <div class="brand_sect">
                <h1>BRAND</h1>
                <div class="cont_search">
                    <form>
                        <div class="w_se">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#1f1f1f">
                                <path
                                    d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                            </svg>
                            <input type="search" id="search_brands_" placeholder="Search">
                        </div>
                    </form>
                </div>
                <!--  container that hold list of brands  -->
                <div class="container_filter" id="search_brands">


                </div>

                <!-- ends  container that hold list of brands  -->
            </div>

            <section class="container_price_cate">

                <header class="price_c">
                    <h2>price</h2>
                    <button class="applyPrice" id="applyPrice" type="button">apply</button>
                </header>

                <div class="range_slider">
                    <input type="range" min="310" class="minPrice" max="804600" value="310" id="fromSlider">
                    <input type="range" min="310" class="maxPrice" max="804600" value="804600" id="toSlider">
                </div>

                <div class="input_n_">
                    <div class="pi_w">
                        <input type="number" value="310" min="310" max="804600" id="fromInput" placeholder="Min">
                    </div>
                    <span class="sepra">-</span>
                    <div class="pi_w">
                        <input type="number" value="804600" min="310" max="804600" id="toInput" placeholder="Max">
                    </div>
                </div>


            </section>

            <div class="brand_sect con_dis">
                <h1>Discount Percentage</h1>
                <!--  container that hold list of brands  -->
                <div class="container_filter" id="dis_cont">
                    <div class="_df_sect" id="discount_p">
                        <a href="#" data-discount="50" class="_me_start fb_ "> 50% or more</a>
                        <a href="#" data-discount="40" class="_me_start fb_ ">
                            40% or more</a>
                        <a href="#" data-discount="30" class="_me_start fb_ ">
                            30% or more</a>
                        <a href="#" data-discount="20" class="_me_start fb_ ">
                            20% or more</a>
                        <a href="#" data-discount="10" class="_me_start fb_ ">
                            10% or more</a>
                    </div>

                </div>

                <!-- ends  container that hold list of brands  -->
            </div>

            <div class="brand_sect con_dis">
                <h1>Product Rating </h1>
                <!--  container that hold list of brands  -->
                <div class="container_filter" id="rate">
                    <div class="_df_sect" id="dis_rating">
                        <a href="#" data-product_rating="5" class="_me_start fb_">
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <span id="rating_p"> & above </span></a>

                        <a href="#" data-product_rating="4" class="_me_start fb_">
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <span id="rating_p"> & above </span></a>

                        <a href="#" data-product_rating="3" class="_me_start fb_">
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <span id="rating_p"> & above </span></a>

                        <a href="#" data-product_rating="2" class="_me_start fb_">
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <span id="rating_p"> & above </span></a>

                        <a href="#" data-product_rating="1" class="_me_start fb_ ">
                            <svg class="active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <svg class="unactive" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16"
                                height="16" fill="currentColor">
                                <path
                                    d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z">
                                </path>
                            </svg>

                            <span id="rating_p"> & above </span></a>


                    </div>

                </div>

                <!-- ends  container that hold list of brands  -->
            </div>

            <div class="brand_sect con_dis">
                <h1>seller score </h1>
                <!--  container that hold list of brands  -->
                <div class="container_filter" id="">
                    <div class="_df_sect" id="dis_seller_score">
                        <a href="#" data-seller_score="80" class="_me_start fb_"> 80% or
                            more</a>
                        <a href="#" data-seller_score="60" class="_me_start fb_"> 60% or
                            more</a>
                        <a href="#" data-seller_score="40" class="_me_start fb_"> 40% or
                            more</a>
                        <a href="#" data-seller_score="20" class="_me_start fb_"> 20% or
                            more</a>
                    </div>

                </div>

                <!-- ends  container that hold list of brands  -->
            </div>

            <div class="brand_sect con_dis">
                <h1>Shipped From</h1>
                <!--  container that hold list of brands  -->
                <div class="container_filter" id="dis_cont">
                    <div class="_df_sect" id="ShippedFrom">
                        <a href="" class="_me_start fb_ "> Shipped from Nigeria</a>
                    </div>

                </div>

                <!-- ends  container that hold list of brands  -->
            </div>

        </div>

        <div class="container_rigth_side">


            <div class="con_pro">

                <div class="wrpp_f">
                    <h1 class="slug_cate_2"><?= htmlspecialchars($categoryName) ?></h1>
                    <p>(<?= number_format($productCount) ?> products found)</p>
                    <!-- dropdown container -->
                    <div class="container_dd">

                        <button id="dd_btn">
                            <p id="p_color">Sort by:</p> <span id="span_color">
                                <?php if ($selectedSort) { ?>
                                    <?php echo $selectedSort ?>
                                <?php } ?>
                                <svg xmlns="http://www.w3.org/2000/svg" id="open_md_mo" viewBox="0 0 24 24" width="18"
                                    height="18" fill="currentColor">
                                    <path
                                        d="M11.9999 13.1714L16.9497 8.22168L18.3639 9.63589L11.9999 15.9999L5.63599 9.63589L7.0502 8.22168L11.9999 13.1714Z">
                                    </path>
                                </svg>

                                <svg class="" id="close_md_mo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    width="18" height="18" fill="currentColor">
                                    <path
                                        d="M11.9999 10.8284L7.0502 15.7782L5.63599 14.364L11.9999 8L18.3639 14.364L16.9497 15.7782L11.9999 10.8284Z">
                                    </path>
                                </svg>
                            </span>
                        </button>

                        <!--  container that holds products sorting -->
                        <div class="dd_container" id="wrapper_dd">
                            <a href="#" data-sort="popularity"
                                class="_me_start fb_  <?= $selectedSort === "popularity" ? "check_me" : "" ?>">
                                <span>Popularity </span></a>
                            <a href="#" data-sort="new_arrival"
                                class="_me_start fb_ <?= $selectedSort === "new_arrival" ? "check_me" : "" ?>">
                                <span>new
                                    arrival </span></a>
                            <a href="#" data-sort="lowToHigh"
                                class="_me_start fb_ <?= $selectedSort === "lowToHigh" ? "check_me" : "" ?> ">
                                <span>Price:
                                    Low to High </span></a>
                            <a href="#" data-sort="highToLow"
                                class="_me_start fb_ <?= $selectedSort === "highToLow" ? "check_me" : "" ?>">
                                <span>Price:
                                    High to Low </span></a>
                            <a href="#" data-sort="product_rating"
                                class="_me_start fb_ <?= $selectedSort === "product_rating" ? "check_me" : "" ?>">
                                <span>Product Rating </span></a>
                        </div>
                        <!-- ends  container that holds products sorting -->

                    </div>

                    <!-- ends dropdown container -->
                </div>

                <div class="wrapper" id="related_results">
                    <div class="wrapp_re">
                        <a>Related result:</a>
                    </div>



                    <div class="bb">
                        <button type="button" class="related_ser" id="left">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22"
                                fill="currentColor">
                                <path
                                    d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z">
                                </path>
                            </svg>
                        </button>

                        <button type="button" class="related_ser" id="right">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22"
                                fill="currentColor">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>


            </div>


            <!-- container product wrapper -->

            <div class="container_product_catelog">


            </div>
            <!-- ends container product wrapper -->

            <!-- container that holds product pagination -->
            <div class="pagination"></div>
            <!-- ends container that holds product pagination -->


        </div>

    </div>

    <!-- container that displays recently_viewed product to the users -->
    <div class="recently_viewed" id="recently_viewed">
        <div class="container_header_cate">
            <h1>you recently viewed</h1>
        </div>

        <div class="container_cate_tag_pro" id="wrp_recent"> </div>


    </div>
    <!-- container that displays recently_viewed product to the users -->

    <!-- container that displays category info -->
    <div class="container_cate_info">

    </div>
    <!-- ends container that displays category info -->


</div>
  



<!-- container that hold mobile sort container -->
<div class="mobSortContainer">
    <section class="mobile_sort_wrapper">
        <div class="cw_sec">
            <header>
                <h2>Sort by</h2>
                <button type="button" id="close_sort_con_">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                        fill="currentColor">
                        <path
                            d="M10.5859 12L2.79297 4.20706L4.20718 2.79285L12.0001 10.5857L19.793 2.79285L21.2072 4.20706L13.4143 12L21.2072 19.7928L19.793 21.2071L12.0001 13.4142L4.20718 21.2071L2.79297 19.7928L10.5859 12Z">
                        </path>
                    </svg>
                </button>
            </header>
            <form class="_sort_by_c">
                <article>
                    <fieldset class="_mom_sort">
                        <legend>sort</legend>
                        <div class="_sort_section">

                            <input type="radio" class="rad" id="fi_sort_0" name="sort" value="popularity"
                                <?= $selectedSort === "popularity" ? "checked" : "" ?>>
                            <label for="fi_sort_0" class="sort_p_m"> <?php echo $selectedSort ?></label>

                        </div>

                        <div class="_sort_section">
                            <input type="radio" class="rad" id="fi_sort_1" name="sort" value="new_arrival">
                            <label for="fi_sort_1" class="sort_p_m">Newest Arrivals</label>
                        </div>

                        <div class="_sort_section">
                            <input type="radio" class="rad" id="fi_sort_2" name="sort" value="lowToHigh">
                            <label for="fi_sort_2" class="sort_p_m">Price: Low to High</label>
                        </div>

                        <div class="_sort_section">
                            <input type="radio" class="rad" id="fi_sort_3" name="sort" value="highToLow">
                            <label for="fi_sort_3" class="sort_p_m">Price: High to Low</label>
                        </div>

                        <div class="_sort_section">
                            <input type="radio" class="rad" id="fi_sort_4" name="sort" value="product_rating">
                            <label for="fi_sort_4" class="sort_p_m">Products Rating</label>
                        </div>



                    </fieldset>

                </article>
            </form>
        </div>
    </section>
</div>
<!-- container that hold mobile sort container -->







<!-- container that displays message to the user -->
<div class="message">
    <div class="error"></div>
    <!-- <div class="success"></div> -->

</div>

<!-- ends container that displays message to the user -->


<div class="product_variation">
    <section class="container_vari">
        <div class="pop">
            <h1>Please select a variation</h1> <button><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    width="18" height="18" fill="currentColor">
                    <path
                        d="M10.5859 12L2.79297 4.20706L4.20718 2.79285L12.0001 10.5857L19.793 2.79285L21.2072 4.20706L13.4143 12L21.2072 19.7928L19.793 21.2071L12.0001 13.4142L4.20718 21.2071L2.79297 19.7928L10.5859 12Z">
                    </path>
                </svg> </button>
        </div>

        <div class="container_vari_selection">

            <div class="vari_cont">

                <div class="cont_warp1">
                    <h3>M</h3>
                    <div class="wrp_">
                        <p>₦ 12,780</p> <span><del>₦ 20,000</del></span>
                    </div>
                </div>

                <div class="cont_warp2">
                    <button type="button" class="remove_decre" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"
                            fill="currentColor">
                            <path d="M5 11V13H19V11H5Z"></path>
                        </svg>
                    </button>

                    <span id="quantity">0</span>

                    <button type="button" class="add_incre">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"
                            fill="currentColor">
                            <path
                                d="M13.0001 10.9999L22.0002 10.9997L22.0002 12.9997L13.0001 12.9999L13.0001 21.9998L11.0001 21.9998L11.0001 12.9999L2.00004 13.0001L2 11.0001L11.0001 10.9999L11 2.00025L13 2.00024L13.0001 10.9999Z">
                            </path>
                        </svg>
                    </button>
                </div>

            </div>


        </div>

        <section class="btns_con">
            <a href="#">Continue Shopping</a>
            <button>Go to Cart</button>
        </section>

    </section>
</div>

<script>
    const inputSearch = document.querySelector("#search_brands_");

    function searchBrand() {
        let input, filter, container, a, i, txtValue, result;

        input = document.querySelector("#search_brands_");
        filter = input.value.toUpperCase();
        container = document.querySelector("#search_brands");
        li = container.getElementsByTagName("a");

        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("span")[0];
            txtValue = a.textContent || a.innerText;

            if (txtValue.indexOf(filter) > -1) {

                li[i].style.display = "block";
            } else {
                li[i].style.display = "none";
            }
        }

    }

    inputSearch.addEventListener('keyup', searchBrand);


    let ddBtn = document.querySelector("#span_color");
    ddBtn.addEventListener("click", () => {
        let dropdown = document.getElementById("wrapper_dd").classList.toggle('display_flex');
        let Btn = document.querySelector("#dd_btn").classList.toggle("add_bg");

        let pColor = document.querySelector("#p_color").classList.toggle("p_color_");
        let sColor = document.querySelector("#span_color").classList.toggle("p_color_");
        let openSvg = document.querySelector("#open_md_mo").classList.toggle("visibleSvg");
        let closeSvg = document.querySelector("#close_md_mo").classList.toggle("InvisibleSvg")
    });


    window.addEventListener("click", (event) => {
        if (!event.target.matches("#span_color")) {
            let dropdown = document.getElementsByClassName("dd_container");
            let Btn = document.querySelector("#dd_btn").classList.remove("add_bg");
            let pColor = document.querySelector("#p_color").classList.remove("p_color_");
            let sColor = document.querySelector("#span_color").classList.remove("p_color_");
            let openSvg = document.querySelector("#open_md_mo").classList.remove("visibleSvg");
            let closeSvg = document.querySelector("#close_md_mo").classList.remove("InvisibleSvg")

            let i;

            for (i = 0; i < dropdown.length; i++) {
                let openDropDown = dropdown[i];
                if (openDropDown.classList.contains("display_flex")) {
                    openDropDown.classList.remove("display_flex");

                }
            }

        }
    });


    const selectedSort = "<?php echo $selectedSort ?>";


</script>