<?php

$args['title'] = isset($args['title']) ? $args['title'] : get_the_title();
$args['subtitle'] = isset($args['subtitle']) ? $args['subtitle'] : get_field('page_banner_subtitle');
$args['image'] = isset($args['image']) ? $args['image'] : get_theme_file_uri('/images/ocean.jpg'); ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?= $args['image']; ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?= $args['title']; ?></h1>
        <div class="page-banner__intro">
            <p><?= $args['subtitle']; ?></p>
        </div>
    </div>
</div>