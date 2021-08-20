<?php
/**
 * Recipe Post
**/
get_header();
if (have_posts()) : while (have_posts()) : the_post();
?>

<?php if(has_post_thumbnail()): ?>
  <div id="wrapper-banner" class="position-relative">
    <img class="w-100 mb-3 mb-md-0" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="banner">
    <div id="banner-screen" class="position-absolute w-100 h-100 d-none d-lg-block"></div>
  </div>
<?php endif; ?>

<div id="recipe" class="container">
  <h2 class="mb-md-5 mb-3 pl-2"><?php the_title(); ?></h2>
  <?php the_content(); ?>	
</div>

<?php endwhile; endif; get_footer(); ?>