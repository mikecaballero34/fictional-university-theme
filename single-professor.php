<?php

get_header();

while (have_posts()) {
    the_post();

    $pageBannerImage = get_field('page_banner_background_image')['url'] ?? get_theme_file_uri('/images/ocean.jpg');

    get_template_part('template-parts/banner', '', [
        'title'     => get_the_title(),
        'subtitle'  => get_field('page_banner_subtitle'),
        'image'     => $pageBannerImage
    ]); ?>

    <div class="container container--narrow page-section">

        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?php the_post_thumbnail('professorPortrait'); ?>
                </div>
                <div class="two-third">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <?php
        $relatedProgramas = get_field('related_programs');

        if ($relatedProgramas) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
            echo '<ul class="link-list min-list">';
            foreach ($relatedProgramas as $program) { ?>
                <li><a href="<?= get_the_permalink($program); ?>"><?= get_the_title($program); ?></a></li>
        <?php
            }
            echo '</ul>';
        }
        ?>
    </div>

<?php
}
get_footer();
