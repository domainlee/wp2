<?php

/**
 * Project Block
 **/

$resume_heading = get_field('resume_heading');
$resume_heading_sub = get_field('resume_heading_sub');
$resume_list = get_field('resume_list');
?>

<!-- start my project -->
<section id="my-project" class="my-project ">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="my-project__inner">
                    <h2 class="heading-default" data-viewport="opacity">My Project<span>Projects that I have done</span></h2>
                    <ul class="my-project__nav nav d-flex justify-content-center mb-3" data-viewport="opacity">
                        <li class="nav-item" role="presentation">
                            <button class="active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="" id="branding-tab" data-bs-toggle="tab" data-bs-target="#branding" type="button" role="tab" aria-controls="branding" aria-selected="false">Branding</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="" id="website-tab" data-bs-toggle="tab" data-bs-target="#website" type="button" role="tab" aria-controls="website" aria-selected="false">Website</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="" id="ui-ux-design-tab" data-bs-toggle="tab" data-bs-target="#ui-ux-design" type="button" role="tab" aria-controls="ui-ux-design" aria-selected="false">UI UX Design</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="" id="development-tab" data-bs-toggle="tab" data-bs-target="#development" type="button" role="tab" aria-controls="development" aria-selected="false">Development</button>
                        </li>
                    </ul>
                    <div class="tab-content" data-viewport="opacity">
                        <!-- start all project -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                            <div class="project__list">
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/lum3n--RBuQ2PK_L8-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Fit Room</h4>
                                            <p class="product__score mb-2">Branding / Website</p>
                                            <div class="product__view">
                                                <a class="button-image" href="<?php echo get_template_directory_uri() ?>/assets/images/lum3n--RBuQ2PK_L8-unsplash.jpg">View Detail</a>
                                            </div>
                                        </div>

                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/jazmin-quaynor-8ioenvmof-I-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Book Office</h4>
                                            <p class="product__score mb-2">Branding / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-iframe" href="https://www.youtube.com/watch?v=7e90gBu4pas">View Detail</a>
                                            </div>
                                        </div>

                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/domenico-loia-hGV2TfOh0ns-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Travel ASIA</h4>
                                            <p class="product__score mb-2">Development / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-image" href="<?php echo get_template_directory_uri() ?>/assets/images/domenico-loia-hGV2TfOh0ns-unsplash.jpg">View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/corinne-kutz-tMI2_-r5Nfo-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Fit Room</h4>
                                            <p class="product__score mb-2">Branding / Website</p>
                                            <div class="product__view">
                                                <a class="button-image mfp-iframe audio" href="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/1189749502&color=%23ff5500&auto_play=true&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true">View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/leone-venter-pVt9j3iWtPM-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Book Office</h4>
                                            <p class="product__score mb-2">Branding / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-image" href="<?php echo get_template_directory_uri() ?>/assets/images/leone-venter-pVt9j3iWtPM-unsplash.jpg">View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/sigmund-4UGmm3WRUoQ-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Travel ASIA</h4>
                                            <p class="product__score mb-2">Development / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-iframe" href="https://www.youtube.com/watch?v=uCf80e2eMoo" >View Detail</a>
                                            </div>
                                        </div>

                                    </figure>
                                </div>
                            </div>
                        </div>
                        <!-- end all project -->

                        <!-- start branding -->
                        <div class="tab-pane fade" id="branding" role="tabpanel" aria-labelledby="branding-tab">
                            <div class="project__list">
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/lum3n--RBuQ2PK_L8-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Fit Room</h4>
                                            <p class="product__score mb-2">Branding / Website</p>
                                            <div class="product__view">
                                                <a class="button-iframe" href="https://www.youtube.com/watch?v=uCf80e2eMoo">View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/jazmin-quaynor-8ioenvmof-I-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Book Office</h4>
                                            <p class="product__score mb-2">Branding / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-image" href="<?php echo get_template_directory_uri() ?>/assets/images/jazmin-quaynor-8ioenvmof-I-unsplash.jpg">View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/corinne-kutz-tMI2_-r5Nfo-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Fit Room</h4>
                                            <p class="product__score mb-2">Branding / Website</p>
                                            <div class="product__view">
                                                <a class="button-image mfp-iframe audio" href="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/1189749502&color=%23ff5500&auto_play=true&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true">View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/leone-venter-pVt9j3iWtPM-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Book Office</h4>
                                            <p class="product__score mb-2">Branding / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-image" href="<?php echo get_template_directory_uri() ?>/assets/images/leone-venter-pVt9j3iWtPM-unsplash.jpg" >View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <!-- end branding -->

                        <!-- start website -->
                        <div class="tab-pane fade" id="website" role="tabpanel" aria-labelledby="website-tab">
                            <div class="project__list">
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/lum3n--RBuQ2PK_L8-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Fit Room</h4>
                                            <p class="product__score mb-2">Branding / Website</p>
                                            <div class="product__view">
                                                <a class="button-image" href="<?php echo get_template_directory_uri() ?>/assets/images/lum3n--RBuQ2PK_L8-unsplash.jpg" >View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/corinne-kutz-tMI2_-r5Nfo-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Fit Room</h4>
                                            <p class="product__score mb-2">Branding / Website</p>
                                            <div class="product__view">
                                                <a class="button-iframe" href="https://www.youtube.com/watch?v=uCf80e2eMoo" >View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <!-- end website -->

                        <!-- start ui-ux-design -->
                        <div class="tab-pane fade" id="ui-ux-design" role="tabpanel" aria-labelledby="ui-ux-design-tab">
                            <div class="project__list">
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/jazmin-quaynor-8ioenvmof-I-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Book Office</h4>
                                            <p class="product__score mb-2">Branding / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-image" href="<?php echo get_template_directory_uri() ?>/assets/images/jazmin-quaynor-8ioenvmof-I-unsplash.jpg" >View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/domenico-loia-hGV2TfOh0ns-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Travel ASIA</h4>
                                            <p class="product__score mb-2">Development / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-iframe" href="https://www.youtube.com/watch?v=uCf80e2eMoo" >View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/leone-venter-pVt9j3iWtPM-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Book Office</h4>
                                            <p class="product__score mb-2">Branding / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-image" href="<?php echo get_template_directory_uri() ?>/assets/images/leone-venter-pVt9j3iWtPM-unsplash.jpg" >View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/sigmund-4UGmm3WRUoQ-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Travel ASIA</h4>
                                            <p class="product__score mb-2">Development / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-image mfp-iframe audio" href="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/1189749502&color=%23ff5500&auto_play=true&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true">View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <!-- end ui-ux-design -->

                        <!-- start development -->
                        <div class="tab-pane fade" id="development" role="tabpanel" aria-labelledby="development-tab">
                            <div class="project__list">
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/domenico-loia-hGV2TfOh0ns-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Travel ASIA</h4>
                                            <p class="product__score mb-2">Development / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-image" href="<?php echo get_template_directory_uri() ?>/assets/images/domenico-loia-hGV2TfOh0ns-unsplash.jpg" >View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                                <div class="product__item">
                                    <figure class="ratio ratio-4x3 lazy" data-src="<?php echo get_template_directory_uri() ?>/assets//images/sigmund-4UGmm3WRUoQ-unsplash.jpg">
                                        <div class="product__content">
                                            <h4 class="product__name mt-0 mb-2">Travel ASIA</h4>
                                            <p class="product__score mb-2">Development / UI UX Designer</p>
                                            <div class="product__view">
                                                <a class="button-iframe" href="https://www.youtube.com/watch?v=uCf80e2eMoo" >View Detail</a>
                                            </div>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <!-- end development -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end my project -->

