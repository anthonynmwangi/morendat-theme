<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
		<?php
			global $page, $paged;
			wp_title( '|', true, 'right' );
			bloginfo( 'name' );
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " - $site_description";
			if ( $paged >= 2 || $page >= 2 )
				echo ' - ' . sprintf( __( 'Page %s', 'satonite' ), max( $paged, $page ) );
		?>
    </title>
    <?php wp_head(); ?>
</head>
<body class="bg-black">
  <header class="sticky-top bg-black py-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-3">
          <nav class="navbar navbar-dark">
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          </nav>
        </div>
        <div class="col-6">
          <div class="text-center">
              <a href="<?php bloginfo('url'); ?>"><img style="max-width: 150px;" src="<?php bloginfo( 'template_directory' ); ?>/images/logo-morendat.svg" alt=""></a>
          </div>
        </div>
        <div class="col-3">
          <div class="text-right">
            <a href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>">
              <img style="max-width: 75px;" src="<?php bloginfo( 'template_directory' ); ?>/icons/icon-order.svg" alt="">
              <span id="cart-count" class="badge badge-pill bg-red"><?php echo WC()->cart->get_cart_contents_count() ?></span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Menu -->
  <div style="z-index: 100; top:100px;" class="position-fixed w-100">
    <div class="container">
      <div class="collapse navbar-collapse" id="navbarToggleExternalContent">
        <?php
          wp_nav_menu( array(
              'theme_location' => 'main-menu',
              'container' => false,
              'menu_id' => 'main-menu',
              'menu_class'=> 'navbar-nav mr-auto bg-black d-md-inline-block px-4 pb-4',
          )); 
        ?>
      </div>
    </div>
  </div>
  <!-- Main Menu -->