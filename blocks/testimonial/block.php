<?php
function wordfest_acf_init_testimonial_block() {
	// Check function exists.
	if ( function_exists('acf_register_block_type') ) {
		// register a testimonial block.
		acf_register_block_type(
			array(
				'name'        => 'testimonial',
				'title'       => __( 'Testimonial' ),
				'description' => __( 'A custom testimonial block.' ),
				'category'    => 'formatting',
				'icon'        => 'admin-comments',
				'keywords'    => array( 'testimonial', 'quote' ),
			)
		);
	}
}

add_action( 'acf/init', 'wordfest_acf_init_testimonial_block' );
