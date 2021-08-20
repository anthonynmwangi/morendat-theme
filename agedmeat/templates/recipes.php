<?php
/*
 * Template Name: Recipes Page
*/

get_header();  ?>

<?php if(has_post_thumbnail()): ?>
  <div id="wrapper-banner" class="position-relative">
    <img class="w-100" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="banner">
    <div id="banner-screen" class="position-absolute w-100 h-100 d-none d-lg-block"></div>
  </div>
<?php endif; ?>

<div class="container py-5">
  <div class="text-center">
    <div class="text-pre haviland h3">The</div>
    <div class="haviland text-l">Signature Recipes</div>
  </div>
  <?php the_content(); ?>	

  <ul id="wrapper-recipes" class=" my-5 list-unstyled">
    <?php
        $args = array(
          'post_type' => 'recipe',
          'posts_per_page' => -1
        );
          $portfolio = new WP_Query( $args );
          while ( $portfolio->have_posts() ) : $portfolio->the_post();
        ?>
    <li class="row align-items-center py-5">
      <div class="col-sm-5">
        <?php if ( has_post_thumbnail()) the_post_thumbnail('large', array('class' => 'mb-3 mb-md-0')); ?>
      </div>
      <div class="col-sm-7">
        <h3><?php the_title(); ?></h3>
        <p><?php echo get_the_excerpt(); ?></p>
        <a class="btn py-2 px-5 text-center bg-red d-sm-inline-block mt-2" href="<?php the_permalink(); ?>">View Recipe</a>
      </div>
    </li>
    <?php endwhile; wp_reset_query(); ?>
  </ul>
  <div class="py-5">
    <h5 class="text-center"><a href="#">Load More</a></h4>
  </div>

</div>

<?php get_footer(); ?>


