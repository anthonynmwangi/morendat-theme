<footer class="text-xxs py-4">
  <div class="container">
    <div class="row">
      <div class="col-sm-2 col-6">
        <img class="w-100 mb-4" src="<?php bloginfo( 'template_directory' ); ?>/images/logo-morendat.svg" alt="">
      </div>
      <div class="col-sm-5">
        <div class="row no-gutters">
          <div class="col-sm-4 col-6">
            <ul class="list-unstyled">
              <li>Naivasha Meatery</li>
              <li>Buffalo Mall, Naivasha</li>
              <li>+254 707 716 775</li>
            </ul>
          </div>
          <div class="col-sm-4 col-6">
            <ul class="list-unstyled">
              <li>Nanyuki Meatery</li>
              <li>Cedar Mall, Nanyuki</li>
              <li>+254 722 371 018</li>
            </ul>
          </div>
          <div class="col-sm-4 col-6">
            <ul class="list-unstyled">
              <li>Sarit Meatery</li>
              <li>Sarit Centre, Nairobi</li>
              <li>+254 722 683 298</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-5 text-bold">
        <hr class="d-sm-none mt-0">
        <div class="row no-gutters">
          <div class="col-sm-1">
            <div class="border-left h-100"></div>
          </div>
          <div class="col-sm-3">
            <?php
              wp_nav_menu( array(
                  'theme_location' => 'footer-menu-1',
                  'container' => false,
                  'menu_id' => '',
                  'menu_class'=> 'list-unstyled',
              )); 
            ?>
          </div>
          <div class="col-sm-4">
            <?php
              wp_nav_menu( array(
                  'theme_location' => 'footer-menu-2',
                  'container' => false,
                  'menu_id' => '',
                  'menu_class'=> 'list-unstyled',
              )); 
            ?>
          </div>
          <div class="col-sm-4">
            <ul class="list-inline text-sm-right">
              <li class="list-inline-item"><a target="_blank" href="https://facebook.com/MorendatFarmNaivasha/"><img src="<?php bloginfo( 'template_directory' ); ?>/icons/icon-fb.png" alt=""></a></li>
              <li class="list-inline-item"><a target="_blank" href="https://instagram.com/morendatfarm//"><img src="<?php bloginfo( 'template_directory' ); ?>/icons/icon-ig.png" alt=""></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

  <!-- Jquery & Bootstrap JS -->    
  <?php wp_footer(); ?>
  
</body>
</html>