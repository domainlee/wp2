<?php

/**
 * Team Member block
 *
 * @package      ClientName
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

$about_main_image_large_center = get_field('about_main_image_large_center');
$img_main = get_template_directory_uri() .'/assets/img/bg_avatar.png';
// left content
$about_icon_left_top = get_field('about_icon_left_top');
$about_text_left_top = get_field('about_text_left_top');
$about_text_left_bottom = get_field('about_text_left_bottom');
$about_text_left_bottom_number = get_field('about_text_left_bottom_number');
$text_right_middle = get_field('text_right_middle');
$about_left_list_social = get_field('about_left_list_social');
// right content
$about_right_title_name = get_field('about_right_title_name');
$about_list_name_roles = get_field('about_list_name_roles');
$about_intro = get_field('about_intro');
$button_contact_text = get_field('button_contact_text');
$button_contact_url = get_field('button_contact_url');
$name_outer = '["Ervin Jason","Designer","Developer"]';

?>
<!-- start about me -->

<section id="about-me <?php echo $block['id'] ?>" class="about-me mb-0" >
    <div class="container-xl h-100">
        <div class="row align-items-center h-100">
            <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0">
                <figure class="about-me__avatar ratio ratio-1x1 lazy" data-viewport="custom" data-delay="1000" data-src="<?php echo !empty($about_main_image_large_center['url']) ? $about_main_image_large_center['url']:$img_main ?>">
                    <div class="about-me__clients" data-viewport="opacity">
                        <div class="brand">
                            <?php if(!empty($about_left_list_social)): ?>
                                <?php foreach ($about_left_list_social as $i): ?>
                                    <i class="<?php echo $i['about_icon_social_left']?>" style="background-color: <?php echo $i['about_bg_icon_social_left']?>"></i>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <i class="icofont-brand-disney"></i>
                            <i class="icofont-brand-gucci"></i>
                            <i class="icofont-brand-adobe"></i>
                            <?php endif; ?>
                        </div>
                        <?php echo $text_right_middle ? $text_right_middle:'20+<br/>Happy Clients'; ?>
                    </div>
                    <div class="about-me__awards" data-viewport="opacity">
                        <i class="<?php echo $about_icon_left_top ? trim($about_icon_left_top):'icofont-royal'; ?>"></i>
                        <span class="d-block"><?php echo $about_text_left_top ? $about_text_left_top : 'Best Design Awards'; ?></span>
                    </div>
                    <div class="about-me__exp" data-viewport="opacity">
                        <strong><?php echo $about_text_left_bottom_number ? $about_text_left_bottom_number : '9+';?></strong>
                        <span><?php echo $about_text_left_bottom ? $about_text_left_bottom:'Years of<br/>Experiencs'; ?></span>
                    </div>
                </figure>
            </div>
            <div class="col-12 col-md-10 col-lg-5 offset-0 offset-md-1">
                <h3 class="about-me__name" data-viewport="opacity" data-delay="600">
                    <span class="d-block"><?php echo !empty($about_right_title_name) ? $about_right_title_name : 'Hi, I am'; ?></span>
                    <strong class="d-block type--js" data-period="2000" data-type='<?php echo !empty($about_list_name_roles) ? $about_list_name_roles : $name_outer ?>'></strong>
                </h3>
                <div class="about-me__intro" data-viewport="opacity" data-delay="500">
                    <?php echo $about_intro; ?>
                </div>
                <div class="about-me__contact d-flex justify-content-between align-items-center" data-viewport="opacity">
                    <div class="about-me__button">
                        <a href="<?php echo $button_contact_url ? $button_contact_url:'#contact' ?>"><?php echo $button_contact_text ? $button_contact_text:'Contact' ?></a>
                    </div>
                    <?php cr_footer_social(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end about me -->


