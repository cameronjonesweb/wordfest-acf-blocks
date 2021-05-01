<div class="wrap mt-5">
	<nav>
		<?php
		$links = paginate_links(
			array(
				'prev_text' => 'Previous',
				'next_text' => 'Next',
			)
		);
		$links = explode( "\n", $links );
		if ( ! empty( $links ) ) {
			echo '<ul class="pagination justify-content-center">';
			foreach ( $links as $link ) {
				printf(
					'<li class="page-item %2$s">%1$s</li>',
					$link,
					is_numeric( strpos( $link, 'current' ) ) ? 'active' : ''
				);
			}
			echo '</ul>';
		}
		?>
	</nav>
</div>
