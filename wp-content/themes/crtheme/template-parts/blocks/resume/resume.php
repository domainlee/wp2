<?php

/**
 * Team Member block
 *
 * @package      ClientName
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

$resume_heading = get_field('resume_heading');
$resume_heading_sub = get_field('resume_heading_sub');
$resume_list = get_field('resume_list');
//print_r($resume_list);
?>
<!-- start my resume -->
<section id="my-resume" class="my-resume ">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <h2 class="heading-default" data-viewport="custom"><?php echo !empty($resume_heading) ? $resume_heading:'My Resume'; ?><span><?php echo !empty($resume_heading_sub) ? $resume_heading_sub:'The services we provide'; ?></span></h2>
                <div class="">
                    <div class="row">
                        <?php if(!empty($resume_list)):  ?>
                            <?php $c = 0;foreach ($resume_list as $i): $c++; ?>
                                <?php if($i['resume_type'] == 'type_two'): ?>
                                <div class="col-12 col-md-6 pe-2 <?php echo ($c%2 ? 'pe-md-4 pe-lg-5':'ps-md-4 ps-lg-5') ?> my-resume__item <?php echo $c == 1 || $c == 2 ? 'mb-4':''; ?>">
                                    <h3 class="heading-default__small" data-viewport="opacity"><i class="icofont-gears"></i><?php echo $i['resume_item_heading'] ?></h3>
                                    <?php if(!empty($i['resume_type_skill'])): ?>
                                    <div class="my-resume__skill">
                                        <?php foreach ($i['resume_type_skill'] as $sk): ?>
                                        <div class="my-resume__skill--item " data-viewport="custom">
                                            <label><?php echo $sk['resume_type_two_label'] ?></label>
                                            <div class="my-resume__skill--precent" data-precent="<?php echo $sk['resume_type_two_precent'] ?>"><div></div><span class="count"></span></div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <div class="col-12 col-md-6 ps-2 <?php echo ($c%2 ? 'pe-md-4 pe-lg-5':'ps-md-4 ps-lg-5') ?> my-resume__item <?php echo $c == 1 || $c == 2 ? 'mb-4':''; ?>">
                                    <h3 class="heading-default__small" data-viewport="opacity"><i class="icofont-education"></i><?php echo $i['resume_item_heading'] ?></h3>
                                    <?php if(!empty($i['resume_type_text_list'])): ?>
                                    <div class="education__list highlight">
                                        <?php foreach ($i['resume_type_text_list'] as $tl): ?>
                                        <div class="education__item highlight__item" data-viewport="opacity">
                                            <div class="education__date"><?php echo $tl['resume_one_year'] ?></div>
                                            <div class="education__name"><?php echo $tl['resume_one_description'] ?></div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 col-md-6 pe-2 pe-md-4 pe-lg-5 my-resume__item mb-4">
                                <h3 class="heading-default__small" data-viewport="opacity"><i class="icofont-gears"></i>Skill</h3>
                                <div class="my-resume__skill">
                                    <div class="my-resume__skill--item " data-viewport="custom">
                                        <label>Photoshop</label>
                                        <div class="my-resume__skill--precent" data-precent="60"><div></div><span class="count"></span></div>
                                    </div>
                                    <div class="my-resume__skill--item " data-viewport="custom">
                                        <label>Wordpress</label>
                                        <div class="my-resume__skill--precent" data-precent="80"><div></div><span class="count"></span></div>
                                    </div>
                                    <div class="my-resume__skill--item " data-viewport="custom">
                                        <label>ReactJS</label>
                                        <div class="my-resume__skill--precent" data-precent="90"><div></div><span class="count"></span></div>
                                    </div>
                                    <div class="my-resume__skill--item " data-viewport="custom">
                                        <label>System Admin</label>
                                        <div class="my-resume__skill--precent" data-precent="50"><div></div><span class="count"></span></div>
                                    </div>
                                    <div class="my-resume__skill--item " data-viewport="custom">
                                        <label>Jquery</label>
                                        <div class="my-resume__skill--precent" data-precent="60"><div></div><span class="count"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 ps-2 ps-md-4 ps-lg-5 my-resume__item mb-4">
                                <h3 class="heading-default__small" data-viewport="opacity"><i class="icofont-education"></i>Education</h3>
                                <div class="education__list highlight">
                                    <div class="education__item highlight__item" data-viewport="opacity">
                                        <div class="education__date">2010 - 2012</div>
                                        <div class="education__name">Masters in Interaction Design</div>
                                        <div class="education__subname">University of North Texas, Denton, TX</div>
                                    </div>
                                    <div class="education__item highlight__item" data-viewport="opacity">
                                        <div class="education__date">2006 - 2009</div>
                                        <div class="education__name">Bachelor of Science in Computer Science</div>
                                        <div class="education__subname">University of North Texas, Denton, TX</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 pe-2 pe-md-4 pe-lg-5 my-resume__item">
                                <h3 class="heading-default__small" data-viewport="opacity"><i class="icofont-flora-flower"></i>Experience</h3>
                                <div class="experience__list highlight">
                                    <div class="experience__item highlight__item" data-viewport="opacity">
                                        <div class="experience__date">2014 - Present</div>
                                        <div class="experience__company">Soft Tech Inc.</div>
                                        <div class="experience__position">Senior UX Designer</div>
                                        <div class="experience__description">
                                            <p>Euismod vel bibendum ultrices, fringilla vel eros, donec euismod leo lectus.</p>
                                        </div>
                                    </div>
                                    <div class="experience__item highlight__item" data-viewport="opacity">
                                        <div class="experience__date">2010 - 2014</div>
                                        <div class="experience__company">Kana Design Studio</div>
                                        <div class="experience__position">Junior UX Designer</div>
                                        <div class="experience__description">
                                            <p>Euismod vel bibendum ultrices, fringilla vel eros, donec euismod leo lectus.</p>
                                        </div>
                                    </div>
                                    <div class="experience__item highlight__item" data-viewport="opacity">
                                        <div class="experience__date">2009 - 2010</div>
                                        <div class="experience__company">Paperart</div>
                                        <div class="experience__position">Junior UX Designer</div>
                                        <div class="experience__description">
                                            <p>Euismod vel bibendum ultrices, fringilla vel eros, donec euismod leo lectus.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 ps-2 ps-md-4 ps-lg-5 my-resume__item">
                                <h3 class="heading-default__small" data-viewport="opacity"><i class="icofont-crown-queen"></i>Awards</h3>
                                <div class="awards__list highlight">
                                    <div class="awards__item highlight__item" data-viewport="opacity">
                                        <div class="awards__date">06-2019</div>
                                        <div class="awards__name">Year of the Month</div>
                                        <div class="awards__description">
                                            <p>Euismod vel bibendum ultrices, fringilla vel eros, donec euismod leo lectus.</p>
                                        </div>
                                    </div>
                                    <div class="awards__item highlight__item" data-viewport="opacity">
                                        <div class="awards__date">04-2016</div>
                                        <div class="awards__name">Site of the Day</div>
                                        <div class="awards__description">
                                            <p>Euismod vel bibendum ultrices, fringilla vel eros, donec euismod leo lectus.</p>
                                        </div>
                                    </div>
                                    <div class="awards__item highlight__item" data-viewport="opacity">
                                        <div class="awards__date">01-2015</div>
                                        <div class="awards__name">Site of the Week</div>
                                        <div class="awards__description">
                                            <p>Euismod vel bibendum ultrices, fringilla vel eros, donec euismod leo lectus.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end my resume -->

