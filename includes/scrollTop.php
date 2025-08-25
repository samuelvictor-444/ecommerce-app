<style>
    .scrollToTop_btn {
        box-shadow: 0 0 0 1px #f68b1e;
        background-color: #fff;
        top: calc(100% - 32px);
        transform: translateY(-56px);
        cursor: pointer;
        pointer-events: all;
        height: 40px;
        width: 40px;
        z-index: 99;
        border-radius: 50px;
        position: fixed;
        display: none;
        align-items: center;
        justify-content: center;
        right: 20px;
        transition: 0.5s ease;
    }

    .scrollToTop_btn:hover {
        background-color: #fef3e9;
    }
</style>


<script>


    $(document).ready(function () {

        const btn = $(".scrollToTop_btn");
        const top = 700;

        
        $(window).on("scroll", function () {


            if (window.scrollY > top) {
                if (!btn.is(":visible")) {
                    btn.css("display", "flex").hide().fadeIn();
                }


            } else {
                btn.fadeOut();
            }


        });

        btn.click(function () {
            $('html , body').animate({
                scrollTop: 0
            }, 1000);
        })
    });


</script>

<div class="scrollToTop_btn">
    <svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#1f1f1f">
        <path d="m256-424-56-56 280-280 280 280-56 56-224-223-224 223Z" />
    </svg>
</div>