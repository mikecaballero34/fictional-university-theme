<?php

add_action('rest_api_init', 'universityLikeRoutes');

function universityLikeRoutes()
{
    register_rest_route('university/v1', 'manageLike', [
        'methods'   => WP_REST_Server::CREATABLE,
        'callback'  => 'createLike'
    ]);

    register_rest_route('university/v1', 'manageLike', [
        'methods'   => WP_REST_Server::DELETABLE,
        'callback'  => 'deleteLike'
    ]);
}

function createLike($data)
{
    if (is_user_logged_in()) {

        $professor = sanitize_text_field($data['professorId']);

        $existQuery = new WP_Query([
            'post_type'     => 'like',
            'author'        => get_current_user_id(),
            'meta_query'    => [
                [
                    'key'       => 'like_professor_id',
                    'field'     => '=',
                    'value'     => $professor
                ]
            ]
        ]);

        if (!$existQuery->have_posts() && get_post_type($professor) === 'professor') {
            return wp_insert_post([
                'post_type'     => 'like',
                'post_status'   => 'publish',
                'post_title'    => 'Second test',
                'meta_input'    => [
                    'like_professor_id' => $professor
                ]
            ]);
        } else {
            die('Invalid professor ID');
        }
    } else {
        die('Only logged in users can create a like.');
    }
}

function deleteLike($data)
{
    $likeId = sanitize_text_field($data['like']);

    if (get_current_user_id() == get_post_field('post_author', $likeId) && get_post_type($likeId) === 'like') {
        wp_delete_post($likeId, true);
        return 'Congrats like deleted';
    } else {
        die('You do not have permission to delete like.');
    }
}
