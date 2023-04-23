<?php

get_header();

get_template_part('template-parts/banner', '', [
    'title'     => 'All Events',
    'subtitle'  => 'See what is going on in our world.'
]); ?>

<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        the_post();
        get_template_part('template-parts/content', get_post_type());
    }

    echo paginate_links(); ?>
    <hr class="section-break">
    <p>Looking for a recap of past events? <a href="<?= site_url('/past-events'); ?>">Check outour past events archive</a></p>
</div>
<?php get_footer();
