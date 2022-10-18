        <!-- start footer -->
        <section class="footer py-5 py-md-4">
            <div class="container-xl">
                <div class="row align-items-center">
                    <div class="col-12 col-md-2">
                        <h2 class="footer__logo m-0 text-center text-md-start">
                            <?php cr_footer_branding(); ?>
                        </h2>
                    </div>
                    <div class="col-12 col-md-5">
                        <?php cr_footer_social(); ?>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="footer__copywriter text-center text-md-end">
                            Copyright © 2022 All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end footer -->

        <script>
            // setting paginator for blog
            SETTING = {
                POST_PER_PAGE: 6,
                LOAD_POST: 2
            }
        </script>
        <?php wp_footer(); ?>
    </body>
</html>