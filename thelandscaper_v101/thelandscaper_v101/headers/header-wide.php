<?php
/**
 * Header Wide Layout
 *
 * @package The Landscaper 
 */
?>

<header class="header header-wide">

	<?php if ( 'hide' !== get_theme_mod( 'qt_topbar', 'show' ) && 'hide' !== get_field( 'topbar' ) ) : ?>
		<div class="topbar">
			<div class="container">
				<span class="tagline"><?php bloginfo( 'description' ); ?></span>
				<?php if ( is_active_sidebar( 'topbar-widgets' ) ) : ?>
					<div class="widgets">
						<?php dynamic_sidebar( 'topbar-widgets' ); ?>
					</div>
				<?php endif; ?>
		    </div>
		</div>
	<?php endif; ?>
			
	<nav class="navigation" aria-label="Main Menu">
		<div class="container">
			
			<div class="navbar-header">

				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="navbar-toggle-text"><?php esc_html_e( 'MENU', 'the-landscaper-wp' ); ?></span>
					<span class="navbar-toggle-icon">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</span>
				</button>

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="navbar-brand">
					<?php
						$logo = esc_url( get_theme_mod( 'qt_logo', false ) );
						$logo_retina = esc_url( get_theme_mod( 'qt_logo_retina', false ) );
						
						if ( ! empty( $logo ) ) : ?>
							<img src="<?php echo esc_url( $logo ); ?>" srcset="<?php echo esc_html( $logo ); ?><?php echo empty ( $logo_retina ) ? '' : ', ' . $logo_retina . ' 2x'; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
						<?php else : ?>
							<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
						<?php 
						endif;
					?>
				</a>
			</div>

			<div id="navbar" class="collapse navbar-collapse">
				<?php
					if ( has_nav_menu( 'primary' ) ) :
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'main-navigation',
							'walker'         => new Aria_Walker_Nav_Menu(),
							'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
						) );
					endif;
				?>
			</div>
		</div>
	</nav>

</header>

<!-- Sticky-offset for the sticky navigation -->
<div class="sticky-offset"></div>