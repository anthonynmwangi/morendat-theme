<?php
/*
 * Template Name: Contact Page
*/

get_header();  ?>

<!-- Checkout Info -->
<div class="py-5 container">
  <div class="row align-items-end">
    <div class="offset-sm-2 col-sm-8">
      <?php echo do_shortcode( '[contact-form-7 id="158" title="Contact form"]' ); ?>
    </div>
    
  </div>
</div>

<?php get_footer(); ?>


[submit "Submit" class:btn class:p-1 class:text-center class:bg-red class:mt-3 class:mb-3 class:text-uppercase]
[submit "Submit" class:btn class:p-1 class:text-center class:bg-red class:mt-3 class:mb-3 class:text-uppercase id:form-submit ]