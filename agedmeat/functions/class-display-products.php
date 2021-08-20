<?php 
/**
 * 
 * Display Products
 *
 */
class Class_Display_Products {

    private $cartitems;
    private $product;
    private $getProductDetail;
    private $price;

	function __construct() {

    /* Add modal popup for Mini cart while clicking addtocart button  */
    add_action( 'display_products', array($this, 'dislay_products_HTML') );

    /* ajax functions for update cart data */
    add_action('wp_ajax_display_products_update', array($this,'display_products_update_func'));
    add_action('wp_ajax_nopriv_display_products_update', array($this,'display_products_update_func'));
  
  }

  function dislay_products_HTML($term_slug){
    $termObj = get_term_by('slug', $term_slug, 'product_cat'); ?>

    <div class="row">
      <div class="offset-sm-3 col-sm-6">
        <div id="cat_desc" class="text-center mb-5"><?php echo wpautop($termObj->description); ?></div>
      </div>
    </div>

    <?php if($term_slug == 'signature-center-cuts'): 
      // $column_size = 'col-sm-6';
      // $request = true;
      // echo '<div class="row"><div class="col-sm-8">';
      // echo '<p class="container text-s mb-5 text-center">These are the finest cuts available and as such are in very high demand. To ensure we fulfil your request up to our very high standards we assign your order to one of our qualified ____ who will let you if the product you are looking for is available in what quantitites and if not when you can expect it,</p>';
    endif;  ?>
      
    <!-- Cuts available -->
    <ul class="row list-unstyled">

      <?php  
        $args = array(
          'post_type'      => 'product',
          'posts_per_page' => -1,
          'product_cat'    => $term_slug
        );

        $loop = new WP_Query( $args );

        while ( $loop->have_posts() ) : $loop->the_post(); global $product;
        wc_get_template_part( 'content', 'product' );
        endwhile; wp_reset_query(); ?>

    </ul>
    <!--sdsd 
    <?php if($term_slug == 'signature-center-cuts'): ?>
    
        </div>
        <div class="col-sm-4">
          <p>Select the cuts you are interested in ordering by clicking on the products in the menu on the left.</p>
          <p>Fill in your details and someone will be in touch confirming their availability.</p>

          <form action="" class="my-5">
            <div class="form-group">
              <label class="text-s" for="">Full Name</label>
              <input type="text" class="input-text form-control">
            </div>
            <div class="form-group">
              <label class="text-s" for="">Email Address</label>
              <input type="text" class="input-text form-control">
            </div>
            <div class="form-group">
              <label class="text-s" for="">Phone Number</label>
              <input type="text" class="input-text form-control">
            </div>
            <button class="btn bg-red w-100 text-uppercase mt-4">Request</button>
          </form>

          <p class="text-s">These are the finest cuts of beef available and as such are in very high demand. To ensure we fulfil your request up to our very high standards we assign your order to one of our qualified ____ who will let you if the product you are looking for is available in what quantitites and if not when you can expect it,</p>
        </div>
    
      </div>

    <?php endif; ?>
     -->


  <?php echo ob_get_clean(); 
  
  }

 

  function display_products_update_func(){
    if (isset($_POST['action']) && $_POST['action'] == "display_products_update") {
      $this->dislay_products_HTML($_POST['catSlug']);
    }
    echo ob_get_clean();
    die();
  }

}

new Class_Display_Products();