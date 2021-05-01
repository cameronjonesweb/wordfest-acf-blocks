<?php
if ( has_post_thumbnail() ) {
	printf( '<a class="entry-thumbnail mb-3" href="%1$s">', esc_url( get_the_permalink() ) );
	the_post_thumbnail();
	echo '</a>';
}
?>
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php the_excerpt(); ?>
<p><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">View Post</a></p>
