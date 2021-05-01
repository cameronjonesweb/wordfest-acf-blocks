<header class="site-header bg-light mb-5">
	<div class="wrap py-3">
		<div>
			<div class="row align-items-center">
				<div class="col-4">
					<?php
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						?>
						<p><?php bloginfo( 'site-title' ); ?></p>
					<?php } ?>
					<p><small><?php bloginfo( 'description' ); ?></small></p>
				</div>
				<div class="col-8">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => 'none',
							'menu_class'     => 'nav menu justify-content-end',
							'fallback_cb'    => false,
						)
					);
					?>
				</div>
			</div>
		</div>
	</div>
</header>
