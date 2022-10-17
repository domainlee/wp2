<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?><?php if (wp_title('', false)) { echo ' | ';} ?><?php wp_title(''); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php wp_head(); ?>
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <style>
        html {
        .light {
            display: inline-block;
        }
        .dark {
            display: none;
        }
        // init
            --text: #000000;
            --bg: #fffdf1;
            --bg-section: #FFFFFF;
            --bg-selection: #030a16;
            --text-selection: #fffdf1;
            --bg-heading: url('../img/bg_heading.png');
            --bg-small: url('../img/bg_resume_heading_small-1.png');
            --bg-blog-heading: url('../img/bg_blog_heading.png');
            --bg-blockquote: #f9f9f9;

        // about
           --bg-about-button: #000000;
        --text-about-button: #FFFFFF;

        // resume
           --bg-resume-skill: #e6e6e6;

        // project
           --bg-nav: transparent;
        --bg-hover-nav: #000000;
        --text-nav-button-active: #FFFFFF;
        --bg-nav-button-active: #000000;

        // service
           --bg-service: #efefef;

        // social
           --bg-social-icon: #f5f0d6;
        }

        html[data-theme='dark'] {
        .light {
            display: none;
        }
        .dark {
            display: inline-block;
        }
        //init
        --text: #e3dfca;
        --bg: #040c1d;
        --bg-section: #030a16;
        --bg-selection: #fffdf1;
        --text-selection: #030a16;
        --bg-heading: url('../img/bg_heading-dark.png');
        --bg-small: url('../img/bg_resume_heading_small-dark-1.png');
        --bg-blog-heading: url('../img/bg_blog_heading-dark.png');
        --bg-blockquote: #040c1d;

        //about
        --bg-about-button: #e3dfca;
        --text-about-button: #040c1d;

        //resume
           --bg-resume-skill: #5d5d5d;

        // project
            --bg-nav: transparent;
            --bg-hover-nav: #e3dfca;
            --text-nav-button-active: #000000;
            --bg-nav-button-active: #FFFFFF;

        // service
           --bg-service: #040c1d;

        // social
           --bg-social-icon: #091831;
        }
    </style>

</head>
<body class="home" <?php body_class(); ?>>

    <!-- start loading-->
    <?php cr_loading(); ?>
    <!-- end loading-->

    <!-- start header-->
    <header class="header d-flex align-content-center flex-row" itemscope itemtype="https://schema.org/WPHeader">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="header_inner d-flex align-items-center">
                        <div class="header__left">
                            <?php cr_site_branding(); ?>
                        </div>
                        <div class="header__menu ms-auto d-flex flex-row justify-content-center align-items-center">
                            <div class="header__nav d-flex align-items-center justify-content-center mx-0 mx-lg-3">
                                <?php cr_navigation(); ?>
                            </div>
                            <a class="header__button-menu d-inline-flex d-lg-none"></a>
                            <a class="button-dark-mode"><i class="icofont-moon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="header--fixed"></div>
    <!-- end header-->