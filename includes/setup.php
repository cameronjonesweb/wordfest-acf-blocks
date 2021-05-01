<?php

function wordfest_theme_support() {
	add_theme_support( 'custom-logo', array( 'width' => 300 ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
}

add_action( 'after_setup_theme', 'wordfest_theme_support' );

function wordfest_register_assets() {
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.6.0' );
	wp_register_style( 'theme', get_stylesheet_uri(), array(), '1.0' );
}

add_action( 'init', 'wordfest_register_assets' );

function wordfest_enqueue_assets() {
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'theme' );
}

add_action( 'wp_enqueue_scripts', 'wordfest_enqueue_assets' );

function wordfest_before_loop() {
	if ( ! is_singular() ) {
		?>
		<div class="wrap">
		<?php
	}
}

add_action( 'wordfest_before_loop', 'wordfest_before_loop' );

function wordfest_after_loop() {
	if ( ! is_singular() ) {
		?>
		</div>
		<?php
	}
}

add_action( 'wordfest_after_loop', 'wordfest_after_loop' );

function wordfest_before_post() {}

add_action( 'wordfest_before_post', 'wordfest_before_post' );

function wordfest_after_post() {}

add_action( 'wordfest_after_post', 'wordfest_after_post' );

function wordfest_post_class( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'wrap';
	}
	return $classes;
}

add_filter( 'post_class', 'wordfest_post_class' );

function wordfest_register_menus() {
	register_nav_menus(
		array(
			'primary' => 'Primary',
		)
	);
}

add_action( 'after_setup_theme', 'wordfest_register_menus' );

function wordfest_nav_menu_args( $args ) {
	if ( ! empty( $args['theme_location'] ) ) {
		$args['items_wrap'] = str_replace( '%2$s', '%2$s menu--' . sanitize_html_class( $args['theme_location'] ), $args['items_wrap'] );
	}
	return $args;
}

add_filter( 'wp_nav_menu_args', 'wordfest_nav_menu_args' );

function wordfest_nav_menu_item_args( $args, $item, $depth ) {
	if ( 'primary' === $args->theme_location ) {
	}
	return $args;
}

add_filter( 'nav_menu_item_args', 'wordfest_nav_menu_item_args', 10, 3 );

function wordfest_nav_menu_css_class( $classes, $item, $args, $depth ) {
	if ( 'primary' === $args->theme_location ) {
		$classes[] = 'nav-item';
	}
	return $classes;
}

add_filter( 'nav_menu_css_class', 'wordfest_nav_menu_css_class', 10, 4 );

function wordfest_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	if ( 'primary' === $args->theme_location ) {
		$class         = ! empty( $atts['class'] ) ? $atts['class'] : '';
		$class        .= ' nav-link';
		$atts['class'] = $class;
	}
	return $atts;
}

add_filter( 'nav_menu_link_attributes', 'wordfest_nav_menu_link_attributes', 10, 4 );

function wordfest_archive_description() {
	if ( is_archive() || is_search() || is_home() ) {
		echo '<div class="mb-5">';
		if ( is_archive() ) {
			the_archive_title( '<h1>', '</h1>' );
			the_archive_description();
		} elseif ( is_home() ) {
			$page_for_posts = get_option( 'page_for_posts' );
			if ( ! empty( $page_for_posts ) ) {
				printf(
					'<h1>%1$s</h1>',
					esc_html( get_the_title( $page_for_posts ) )
				);
				echo wp_kses_post( apply_filters( 'the_content', get_post_field( 'post_content', $page_for_posts ) ) );
			} else {
				echo '<h1>Posts</h1>';
			}
		} elseif ( is_search() ) {
			echo '<h1>Search Results</h1>';
		}
		echo '</div>';
	}
}

add_action( 'wordfest_before_loop', 'wordfest_archive_description' );

function wordfest_meta_tags() {
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php
}

/**
 * Remove semi colon and every prior from the archive title
 *
 * @link https://stackoverflow.com/a/22997249/1672694
 * @since 1.0.0
 * @param string $title The archive title.
 * @return string
 */
function wordfest_remove_archive_prefix( $title ) {
	$title = trim( substr( $title, strpos( $title, ':' ) + 1 ) );
	return $title;
}

add_filter( 'get_the_archive_title', 'wordfest_remove_archive_prefix' );

/**
 * Replace the default hellipsis with ellipsis
 *
 * @since 1.0.0
 * @link https://developer.wordpress.org/reference/functions/the_excerpt/#comment-326
 * @param string $more "Read more" excerpt string.
 * @return string
 */
function wordfest_excerpt_more_ellipsis( $more ) {
	$more = '...';
    return $more;
}

add_filter( 'excerpt_more', 'wordfest_excerpt_more_ellipsis' );

function wordfest_404_fix() {
	global $wp_query;
	if ( $wp_query->is_404 ) {
		$wp_query->posts        = array();
		$wp_query->current_post = 0;
		$wp_query->post         = null;
	}
}

add_action( 'template_redirect', 'wordfest_404_fix' );

function wordfest_archive_pagination() {
	if ( is_archive() || is_search() || is_home() ) {
		get_template_part( 'template-parts/content/pagination-archive' );
	}
}

add_action( 'wordfest_after_loop', 'wordfest_archive_pagination' );

function wordfest_paginate_links_output( $markup, $args ) {
	$markup = str_replace( 'page-numbers', 'page-link', $markup );
	return $markup;
}

add_filter( 'paginate_links_output', 'wordfest_paginate_links_output', 10, 2 );
