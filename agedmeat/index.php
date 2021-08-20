<?php
/*
* The main template file.
*/

get_header();  ?>


  <div id="wrapper-banner" class="position-relative">

    <img class="w-100" src="<?php bloginfo( 'template_directory' ); ?>/images/banner-home.jpg" alt="">
    <div id="banner-screen" class="position-absolute w-100 h-100 d-none d-lg-block"></div>

    <div id="banner-text" class="position-absolute h-100 w-100">
      <div class="container h-100">
        <div class="row h-100 align-items-end">
          <div class="col-sm-6">
            <h2 class="text-l">Kenya’s finest, <br>premium, <br>aged beef.</h2>
            <p>From our world-class farm to you.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div id="wrapper-content" class="container py-5">
    <div class="row">
      <div class="col-sm-4">
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