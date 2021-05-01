<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<?php
		wp_body_open();
		get_header();
		?>
		<main>
			<?php
			do_action( 'wordfest_before_loop' );
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					?>
					<article <?php post_class(); ?>>
						<?php
						do_action( 'wordfest_before_post' );
						if ( is_singular() ) {
							get_template_part( 'template-parts/content/single', get_post_type() );
						} else {
							get_template_part( 'template-parts/content/archive', get_post_type() );
						}
						do_action( 'wordfest_after_post' );
						?>
					</article>
					<?php
				}
			} else {
				if ( is_404() ) {
					get_template_part( 'template-parts/global/404' );
				} else {
					get_template_part( 'template-parts/content/no-posts', get_post_type() );
				}
			}
			do_action( 'wordfest_after_loop' );
			?>
		</main>
		<?php
		get_footer();
		wp_footer();
		?>
	</body>
</html>
