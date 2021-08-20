<?php
/**
 * Single Post
**/
get_header();
if (have_posts()) : while (have_posts()) : the_post();
?>

<?php if(has_post_thumbnail()): ?>
  <div id="wrapper-banner" class="position-relative">
    <img class="w-100" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="banner">
    <div id="banner-screen" class="position-absolute w-100 h-100 d-none d-lg-block"></div>
  </div>
<?php endif; ?>

<div id="recipe" class="container">
  <h2 class="mb-5"><?php the_title(); ?></h2>
  <?php the_content(); ?>	
</div>

<?php endwhile; endif; get_footer(); ?>