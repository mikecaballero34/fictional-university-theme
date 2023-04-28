<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="container">
            <h1 class="school-logo-text float-left">
                <a href="<?= site_url(); ?>">
                    <strong>Fictional</strong>
                    University
                </a>
            </h1>
            <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">
                    <?php
                    /*wp_nav_menu([
                        'theme_location'  => 'headerMenuLocation'
                    ]); */ ?>
                    <ul>
                        <li <?= is_page('about-us') || wp_get_post_parent_id(0) == 21 ? 'class="current-menu-item"' : '' ?>><a href="<?= home_url('about-us'); ?>">About Us</a></li>
                        <li <?= get_post_type() === 'program' ? 'class="current-menu-item"' : ''; ?>><a href="<?= get_post_type_archive_link('program'); ?>">Programs</a></li>
                        <li <?= get_post_type() === 'event' || is_page('past-events') ? 'class="current-menu-item"' : ''; ?>><a href="<?= get_post_type_archive_link('event'); ?>">Events</a></li>
                        <li <?= get_post_type() === 'campus' ? 'class="current-menu-item"' : ''; ?>><a href="<?= get_post_type_archive_link('campus'); ?>">Campuses</a></li>
                        <li <?= get_post_type() === 'post' ? 'class="current-menu-item"' : ''; ?>><a href="<?= home_url('/blog'); ?>">Blog</a></li>
                    </ul>
                </nav>
                <div class="site-header__util">
                    <?php
                    if (is_user_logged_in()) { ?>
                        <a href="<?= esc_url(home_url('/my-notes')); ?>" class="btn btn--small btn--orange float-left push-right">My notes</a>
                        <a href="<?= wp_logout_url(); ?>" class="btn btn--small btn--dark-orange float-left btn--with-photo">
                            <span class="site-header__avatar"><?= get_avatar(get_current_user_id(), 60); ?></span>
                            <span class="btn__text">Log Out</span>
                        </a>
                    <?php
                    } else { ?>
                        <a href="<?= esc_url(wp_login_url()); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
                        <a href="<?= esc_url(wp_registration_url()); ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
                    <?php
                    } ?>

                    <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </header>