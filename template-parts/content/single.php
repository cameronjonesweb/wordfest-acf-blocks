<?php
if ( has_post_thumbnail() ) {
	echo '<div class="entry-thumbnail mb-3">';
	the_post_thumbnail();
	echo '</div>';
}
?>
<h1 class="mb-4"><?php the_title(); ?></h1>
<?php the_content(); ?>
