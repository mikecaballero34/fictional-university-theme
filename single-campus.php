<?php

get_header();

while (have_posts()) {
    the_post();

    get_template_part('template-parts/banner'); ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?= get_post_type_archive_link('campus'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    All Campuses
                </a>
                <span class="metabox__main">
                    <?php the_title(); ?>
                </span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content(); ?>
        </div>

        <?php
        $relatedPrograms = new WP_Query([
            'post_type'         => 'program',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'orderby'           => 'title',
            'order'             => 'ASC',
            'meta_query'        => [
                [
                    'key'       => 'related_campuses',
                    'compare'   => 'LIKE',
                    'value'     => '"' . get_the_ID() . '"'
                ]
            ]
        ]);
        if ($relatedPrograms->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Programs available at this campus.</h2>';
            echo '<ul class="min-list link-list">';
            while ($relatedPrograms->have_posts()) {
                $relatedPrograms->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </li>
        <?php
            }
            echo '</ul>';
        }

        wp_reset_postdata(); ?>
    </div>

<?php
}
get_footer();
