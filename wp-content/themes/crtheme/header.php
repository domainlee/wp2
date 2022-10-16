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
</head>

<body class="home" <?php body_class(); ?>>

    <!-- start loading-->
    <div class="loading">
        <div class="loading__inner">
            <div class="loading__list">
                <span>L</span><span>O</span><span>A</span><span>D</span><span>I</span><span>N</span><span>G</span>
            </div>
        </div>
    </div>
    <!-- end loading-->

    <!-- start header-->
    <section class="header d-flex align-content-center flex-row">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="header_inner d-flex align-items-center">
                        <div class="header__left">
                            <a href="index.html">
                                <h1 class="header__logo m-0">
                                    <img class="light" src="assets/img/logo.png" alt="logo" />
                                    <img class="dark" src="assets/img/logo-dark.png" alt="logo" />
                                </h1>
                            </a>
                        </div>
                        <div class="header__menu ms-auto d-flex flex-row justify-content-center align-items-center">
                            <div class="header__nav d-flex align-items-center justify-content-center mx-0 mx-lg-3">
                                <ul class="header__navigation nav d-flex flex-column flex-lg-row justify-content-center align-items-center">
                                    <li class="nav-item"><a class="nav-link" href="#about-me">About</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#my-resume">Resume</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#my-service">Services</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#my-project">Project</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#my-client">Clients</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#my-blog">Blog</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                                </ul>
                            </div>
                            <a class="header__button-menu d-inline-flex d-lg-none"></a>
                            <a class="button-dark-mode"><i class="icofont-moon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="header--fixed"></div>
    <!-- end header-->