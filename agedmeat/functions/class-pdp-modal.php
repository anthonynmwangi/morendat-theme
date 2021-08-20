<?php 
/**
 * PDP popup modal
 *
 * This class is used to create a custom popup that is used to display product information
 * in an aim to replace the PDP page. Allowing customer to easily interact with the product
 * without having to open the PDP.
 *
 */
class Class_Pdp_Modal {

    private $cartitems;
    private $product;
    private $getProductDetail;
    private $price;

	function __construct() {
		
        /* Add modal popup for Mini cart while clicking addtocart button  */
        add_action( 'wp_footer', array($this, 'pdp_modal_HTML') );

        /* ajax functions for opening cart popup modal */
        add_action('wp_ajax_ajax_pdp_modal_open', array($this,'ajax_pdp_modal_open_func'));
        add_action('wp_ajax_nopriv_ajax_pdp_modal_open', array($this,'ajax_pdp_modal_open_func'));

        /* ajax functions for update cart data */
        add_action('wp_ajax_pdp_modal_update', array($this,'pdp_modal_update_func'));
        add_action('wp_ajax_nopriv_pdp_modal_update', array($this,'pdp_modal_update_func'));

        /* ajax functions for calculating cart qty */
        add_action('wp_ajax_ajax_pdp_cart_update', array($this,'ajax_pdp_cart_update_func'));
         add_action('wp_ajax_nopriv_ajax_pdp_cart_update', array($this,'ajax_pdp_cart_update_func'));

        /* ajax functions for remove cart item  */
        add_action('wp_ajax_ajax_mini_cart_remove', array($this,'ajax_mini_cart_remove_func'));
        add_action('wp_ajax_nopriv_ajax_mini_cart_remove', array($this,'ajax_mini_cart_remove_func'));
	}


    /* HTML for Minicart popup */
    function pdp_modal_HTML(){
       
         global $woocommerce;
         $this->cartitems = $woocommerce->cart->get_cart();
        ?>

      <!-- START Mini Cart Popup -->
      <div class="modal fade" id="pdpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content bg-black px-3 pb-4">
            <div class="modal-header border-0 pb-0">
              <button type="button" class="bg-black close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mb-4">
              <div class="mini-cart-div"></div>
            </div>
            
          </div>
        </div>
      </div>
      <!-- END Mini Cart Popup -->
        <?php 
    }

    // display all cart item onminicart popup modal
    function ajax_pdp_modal_open_func() {
      $in_cart = false;
      if (isset($_POST['action']) && $_POST['action'] == "ajax_pdp_modal_open") {
        $productID = $_POST['productID'];
        ob_start();
        global $woocommerce;
        $cartItems = $woocommerce->cart->get_cart();
        $product = wc_get_product( $productID ); ?>
        <div class="wrapper-image position-relative mb-4">
          <?php 
            product_tags($product);
            if($product->get_image_id()){
              echo '<img class="w-100 mb-0" src="'.wp_get_attachment_thumb_url( $product->get_image_id() ).'" alt="">';
            }else{
              echo '<img class="w-100 mb-0" src="'.wc_placeholder_img_src().'" alt="">';
            }
          ?>
          
        </div>
        <h5 class="mb-0"><?php echo $product->get_name(); ?></h5>
        <p class="text-xs"><?php echo wc_price($product->get_price()); ?></p>
        <?php
          $desc = $product->get_description();
          if(!$desc) $desc = $product->get_short_description();
          echo '<p class="text-s">'.$desc.'</p>';

          if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {

            $product_quantity = woocommerce_quantity_input( array(
              'max_value'    => $product->get_max_purchase_quantity(),
              'min_value'    => '1',
              'product_name' => $product->get_name(),
              'product_id' => $product->get_id(),
            ), $product, false );

            $html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" id="modal-form" class="wcb2b-quantity" method="post" enctype="multipart/form-data">';
            $html .= $product_quantity;
            $html .= '<button type="submit" class="button add_to_cart_button mt-3">' . esc_html( $product->add_to_cart_text() ) . '</button>';
            $html .= '</form>';

            echo $html;
          }
        // }
        echo ob_get_clean();
        die();
      } 
    }

    // quantity update for cart item
    function pdp_modal_update_func() {
      if (isset($_POST['action']) && $_POST['action'] == "pdp_modal_update") {
        global $woocommerce;
        echo $woocommerce->cart->set_quantity($_POST['cartkey'], $_POST['quantity']);
        die();
      }
    }

    // remove product from cart
    function ajax_mini_cart_remove_func() {
      if (isset($_POST['action']) && $_POST['action'] == "ajax_mini_cart_remove") {
        global $woocommerce;
        echo $woocommerce->cart->remove_cart_item( $_POST['cartkey'] );
        die();
      } 
    }

    //Update cart according to max stock and already existing number of items
    function ajax_pdp_cart_update_func() {
      if (isset($_POST['action']) && $_POST['action'] == "ajax_pdp_cart_update") {
         global $woocommerce;
         $calculated_qty = 0;
         $list = array();
         $this->cartitems = $woocommerce->cart->get_cart();
         if(!empty($this->cartitems)) {
          $flag=0; //indicator to check if the product is present in cart
           foreach($this->cartitems as $item => $values) { 
                
              if($_POST['product_id']==$values['product_id'])
              {
                $flag++;
                $stock_qty = get_post_meta($values['product_id'] , '_stock', true); //number of stock
                $total_qty = $_POST['quantity'] + $values['quantity']; //newly added qty+already added qty

                $max_qty_allowed = apply_filters( 'woocommerce_quantity_input_max', null, $values['data'] );
                $max_value = ($max_qty_allowed) ? $max_qty_allowed : $stock_qty;

                if($max_value && $total_qty >= $max_value)
                {
                  $calculated_qty = $max_value - $values['quantity'];
                  $calculated_qty = ($calculated_qty < 1)? -1 : $calculated_qty;
                  // if status parameter is 1 it indicates that max stock qty reached
                  $list[] = array('qty' => $calculated_qty , 'status' => 1, 'total' => $total_qty, 'max_qty_allowed' => $max_qty_allowed, 'stock' => $stock_qty, 'max_value' => $max_value, 'alread_added' => $values['quantity'], 'newly_added' => $_POST['quantity'] );
                  echo json_encode($list);
                }else{
                  $calculated_qty = $_POST['quantity'];
                  $list[] = array('qty' => $calculated_qty , 'status' => 0);
                  echo json_encode($list);
                }
                

               // echo $calculated_qty;
              }
              
            }
            if($flag==0) 
            {
              //echo $_POST['quantity'];
              $list[] = array('qty' => $_POST['quantity'] , 'status' => 0);
              echo json_encode($list);
            }
          }else{
            //echo $_POST['quantity'];
            $list[] = array('qty' => $_POST['quantity'] , 'status' => 0);
            echo json_encode($list);
          }
          die();
      }

    }
 

}

new Class_Pdp_Modal();