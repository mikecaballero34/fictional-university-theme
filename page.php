<?php

get_header();

while (have_posts()) {
    the_post();

    get_template_part('template-parts/banner'); ?>

    <div class="container container--narrow page-section">
        <?php
        //Verify if current page is a child page
        $parentPageID = wp_get_post_parent_id(get_the_ID());
        if ($parentPageID) { ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?= get_the_permalink($parentPageID); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Back to <?= get_the_title($parentPageID); ?>
                    </a>
                    <span class="metabox__main"><?php the_title(); ?></span>
                </p>
            </div>
        <?php
        }

        $children = get_pages([
            'child_of'  => get_the_ID()
        ]);

        // Show this menu only if is parent page or child page, not apply for pages that are alone
        if ($parentPageID || $children) { ?>

            <div class="page-links">
                <h2 class="page-links__title">
                    <a href="<?= get_the_permalink($parentPageID); ?>">
                        <?= get_the_title($parentPageID); ?>
                    </a>
                </h2>
                <ul class="min-list">
                    <?php

                    $childOf = !empty($parentPageID) ? $parentPageID : get_the_ID();

                    wp_list_pages([
                        'title_li'      => null,
                        'child_of'      => $childOf,
                        'sort_column'   => 'menu_order'
                    ]); ?>
                </ul>
            </div>
        <?php
        } ?>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>
    </div>

<?php
}
get_footer();
