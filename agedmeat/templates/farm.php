<?php
/*
 * Template Name: Farm Page
*/

get_header();  ?>

<div id="wrapper-banner" class="banner-farm position-relative">
  <div class="position-absolute w-100">
    <div class="container">
      <h1 class="text-right pt-5 mt-5 text-black text-l">The <br>Farm</h1>
    </div>
  </div>
  <div id="spot-mountain" class="bloodshot">
    <div class=""><img src="<?php bloginfo( 'template_directory' ); ?>/images/bloodshot.png" alt=""></div>
    <div class="details"><img class="ml-5" width="400" src="<?php bloginfo( 'template_directory' ); ?>/images/popup-24-hours.jpg" alt=""></div>
  </div>
  <div id="spot-animals" class="bloodshot">
    <div class=""><img src="<?php bloginfo( 'template_directory' ); ?>/images/bloodshot.png" alt=""></div>
    <div class="details"><img class="ml-5" width="400" src="<?php bloginfo( 'template_directory' ); ?>/images/popup-breeds.jpg" alt=""></div>
  </div>
  <div id="spot-feed" class="bloodshot">
    <div class="text-right"><img src="<?php bloginfo( 'template_directory' ); ?>/images/bloodshot.png" alt=""></div>
    <div class="details"><img class="mr-5" width="400" src="<?php bloginfo( 'template_directory' ); ?>/images/popup-6-vets.jpg" alt=""></div>
  </div>

  <img class="w-100" src="<?php bloginfo( 'template_directory' ); ?>/images/banner-farm.jpg" alt="">
  <div id="banner-screen" class="position-absolute w-100 h-100 d-none d-lg-block"></div>
</div>
  <div id="wrapper-content" class="container py-5">
    <div class="row">
      <div class="offset-sm-2 col-sm-4">
        <div class="item bg-dark h-100">
          <img src="<?php bloginfo( 'template_directory' ); ?>/images/the-buchery.jpg" alt="">
          <div class="p-5 mx-2 desc">
              <div class="text-pre haviland h3">The</div>
            <div class="haviland text-l pl-3">Meatery</div>
            <p class="pb-3">We boast a staff of expert professionals trained in dry ageing traditions with a passion to bring you the worlds best beef</p>
            <a class="btn bg-red text-uppercase w-100 mt-4 py-2" href="<?php bloginfo('url'); ?>/butchery/beef">Purchase Cuts</a>
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

  <div class="py-5"></div>

  <?php get_footer(); ?>

  <script type="text/javascript">
  	jQuery(document).ready(function(){ 
      jQuery(".bloodshot img").click(function(){
        jQuery(".bloodshot .details").hide();
        jQuery(this).parent().siblings(".details").toggle();
      })
    });
  </script>