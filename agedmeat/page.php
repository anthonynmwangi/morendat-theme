<?php
/*
* The main template file.
*/

get_header();  ?>

<?php if(has_post_thumbnail()): ?>
  <div id="wrapper-banner" class="position-relative">
    <img class="w-100" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="banner">
    <div id="banner-screen" class="position-absolute w-100 h-100 d-none d-lg-block"></div>
  </div>
<?php endif; ?>

<div class="container">
<?php if(!is_cart()) echo '<h2 class="text-center"><?php the_title(); ?></h2>'; ?>
  
  <?php the_content(); ?>	
</div>

<?php get_footer(); ?>


