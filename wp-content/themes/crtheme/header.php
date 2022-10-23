<!doctype html>
<html <?php language_attributes(); ?> class="no-js front-end">
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