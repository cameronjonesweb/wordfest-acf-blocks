<?php
function wordfest_register_acf_blocks() {
	$files = glob( get_template_directory() . '/blocks/{**/block.php}', GLOB_BRACE );
	if ( ! empty( $files ) ) {
		foreach ( $files as $f ) {
			require_once $f;
		}
	}
}

add_action( 'acf/init', 'wordfest_register_acf_blocks', 0 );

function wordfest_block_args( $args ) {
	if ( empty( $args['enqueue_assets'] ) ) {
		$args['enqueue_assets'] = 'wordfest_enqueue_block_assets';
	}
	if ( empty( $args['render_callback'] ) ) {
		$args['render_callback'] = 'wordfest_render_callback';
	}
	return $args;
}

add_filter( 'acf/register_block_type_args', 'wordfest_block_args' );

function wordfest_enqueue_block_assets( $block ) {
	$name = wordfest_get_block_name( $block );
	if ( file_exists( get_template_directory() . '/blocks/' . $name . '/block.css' ) ) {
		wp_enqueue_style( $name . '-block-style', get_template_directory_uri() . '/blocks/' . $name . '/block.css', array(), '' );
	}
	if ( file_exists( get_template_directory() . '/blocks/' . $name . '/block.js' ) ) {
		wp_enqueue_script( $name . '-block-script', get_template_directory_uri() . '/blocks/' . $name . '/block.js', array(), '', true );
	}
}

function wordfest_render_callback( $block, $content = '', $is_preview = false, $post_id = 0 ) {
	$name = wordfest_get_block_name( $block );
	$attr = array(
		'class' => array(
			'wp-block-' . $name,
		),
	);
	if ( isset( $block['anchor'] ) && ! empty( $block['anchor'] ) ) {
		$attr['id'] = $block['anchor'];
	}
	if ( isset( $block['className'] ) && ! empty( $block['className'] ) ) {
		$attr['class'][] = $block['className'];
	}
	if ( isset( $block['align'] ) && ! empty( $block['align'] ) ) {
		$attr['class'][] = 'align' . $block['align'];
	}
	$attr['class'] = implode( ' ', $attr['class'] );
	echo '<div';
	foreach ( $attr as $att => $val ) {
		printf(
			' %1$s="%2$s"',
			esc_attr( $att ),
			esc_attr( $val )
		);
	}
	echo '>';
	get_template_part(
		'blocks/' . $name . '/template',
		$is_preview ? 'preview' : '',
		array(
			'block'      => $block,
			'content'    => $content,
			'is_preview' => $is_preview,
			'post_id'    => $post_id,
		)
	);
	echo '</div>';
}

function wordfest_get_block_name( $block ) {
	return substr( $block['name'], 4 );
}
