<?php

/**
 * Team Member block
 *
 * @package      ClientName
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

$title = get_field('question');
$asw = get_field('asw');
?>
<style>
    .testimonial {
        display: flex;
    }
    .testimonial__left {
        width: 50%;
    }
    .testimonial__right {
        width: 50%;
    }
</style>
<div class="testimonial">
    <div class="testimonial__left"><?= $title; ?></div>
    <div class="testimonial__right"><?= $asw; ?></div>
</div>


