<?php
if ( has_post_thumbnail() ) {
	echo '<div class="entry-thumbnail mb-3">';
	the_post_thumbnail();
	echo '</div>';
}
?>
<h1 class="mb-3"><?php the_title(); ?></h1>
<p><?php echo get_the_date(); ?> by <?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></p>
<?php the_content(); ?>
