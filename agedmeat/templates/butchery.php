<?php
/*
 * Template Name: Meatery Page
 * For 500gms increament use - https://codeontrack.com/use-decimal-in-quantity-fields-in-woocommerce-wordpress/
*/

get_header();  
if (have_posts()) : while (have_posts()) : the_post();
?>
  
  <!-- Banner -->
  <div id="wrapper-banner" class="position-relative">
    <img class="w-100" src="<?php bloginfo( 'template_directory' ); ?>/images/banner-butchery.jpg" alt="">
    <div id="banner-screen" class="position-absolute w-100 h-100 d-none d-lg-block"></div>
  </div>

  <div id="wrapper-content" class="py-5">
    <div class="container">
      <div class="text-center">
        <div class="text-pre haviland h3">The</div>
        <div class="haviland text-l">Meatery</div>
      </div>

      <!-- Select type of carcass -->
      <div>
        <nav class="nav nav-pills nav-justified py-5 my-5">
          <?php
            $pageArray = get_children(array('post_parent' => $post->post_parent,'order' => 'ASC'));
            $currentID = $post->ID;
            foreach($pageArray as $key => $page){
              $active = ($page->ID == $currentID) ? 'active' : '';
              echo '<a class="nav-item nav-link '.$active.'" href="'.get_permalink($page->ID).'">'.$page->post_title.'</a>';
              $first = false;
            }
          ?>

        </nav>
        <?php the_content(); ?>

        <?php

          $taxObj = get_term_by('slug', $post->post_name, 'product_cat' );
          $terms_children = get_term_children($taxObj->term_id, 'product_cat');

          if ( !empty( $terms_children ) && !is_wp_error( $terms_children ) ){

          // Get subcategories of the current category
          $terms    = get_terms([
            'taxonomy'    => 'product_cat',
            'hide_empty'  => true,
            'parent'      => $taxObj->term_id
        ]);

        $output = '<div id="cat_list" class="row text-center align-items-center my-5">';
        $output .= '<div class="col-sm-3"></div>';

        // Loop through product subcategories WP_Term Objects
        foreach ( $terms as $term ) {
          $term_link = get_term_link( $term, $taxonomy );
          $active = ($terms[0]->term_id == $term->term_id )? 'text-red': '';
          $output .= '<div class="col-sm-2">';
          $output .= '<div data-cat="'.$term->term_id.'" class="sub_cat cursor-pointer text-uppercase text-bold breaker '.$active.'" data-slug="'.$term->slug.'">'. $term->name .'</div>';
          $output .= '</div>';
        }

        echo $output . '</div>';

        ?>

        <?php get_template_part( 'partials/beef-cuts' ); ?>

        <div id="product-display">
          <?php do_action( 'display_products', $terms[0]->slug); ?>
        </div>


      <?php  } // If there are sub categories 


      else{ ?>
        <div id="product-display">
          <?php do_action( 'display_products', $taxObj->slug); ?>
        </div>
      <?php
        
      }
      ?>
      
        
        
        <div class="py-5"></div>

      </div>

      <!-- Link to Recipes -->
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <div class="item bg-dark h-100">
          <img src="<?php bloginfo( 'template_directory' ); ?>/images/the-farm.jpg" alt="">
          <div class="p-5 mx-2 desc">
            <div class="text-pre haviland h3">The</div>
            <div class="haviland text-l pl-3">Farm</div>
            <p class="pb-3">The crystal clear waters and fertile soils of the Great Rift Valley make Morendat the perfect home for our cattle</p>
            <a class="btn bg-red text-uppercase w-100 mt-4 py-2" href="<?php bloginfo('url'); ?>/farm">Learn More</a>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="item bg-dark h-100">
          <img src="<?php bloginfo( 'template_directory' ); ?>/images/the-recipe.jpg" alt="">
          <div class="p-5 mx-2 desc">
              <div class="text-pre haviland h3">Signature</div>
            <div class="haviland text-l pl-3">Recipes</div>
            <p class="pb-3">To ensure you get the most out of our delectable steaks we offer our signature recipes perfect for any occasion</p>
            <a class="btn bg-red text-uppercase w-100 mt-4 py-2" href="<?php bloginfo('url'); ?>/recipes">View Recipes</a>
          </div>
        </div>
      </div>
    </div>


    </div>
  </div>

  <div class="py-5"></div>

  <?php endwhile; endif; get_footer(); ?>
