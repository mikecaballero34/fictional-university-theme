<?php

get_header();

get_template_part('template-parts/banner', '', [
    'title'     => 'Past Events',
    'subtitle'  => 'A recap of our past events.'
]); ?>

<div class="container container--narrow page-section">
    <?php
    $pastEvents = new WP_Query([
        'post_type'         => 'event',
        'paged'             => get_query_var('paged', 1),
        'post_status'       => 'publish',
        'orderby'           => 'meta_value_num',
        'meta_key'          => 'event_date',
        'order'             => 'ASC',
        'meta_query'        => [
            [
                'key'       => 'event_date',
                'compare'   => '<',
                'value'     => date('Ymd'),
                'type'      => 'numeric'
            ]
        ]
    ]);
    while ($pastEvents->have_posts()) {
        $pastEvents->the_post();
        get_template_part('template-parts/content', get_post_type());
    }

    echo paginate_links([
        'total' => $pastEvents->max_num_pages
    ]); ?>
</div>
<?php get_footer();
