<?php

// Javascript Files
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts');
function enqueue_theme_scripts(){
  wp_enqueue_script('bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array('jquery'), false, true);  
  wp_enqueue_script('bootstrap-scripts', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery','bootstrap-popper'), false, true);  
  wp_enqueue_script('action_scripts', get_template_directory_uri() . '/js/actions.js', array('jquery', 'bootstrap-scripts','bootstrap-popper'), false, true);
  wp_localize_script('action_scripts', 'ajax_url', admin_url('admin-ajax.php'));
}


// CSS Files
add_action('wp_enqueue_scripts', 'enqueue_theme_styles');
function enqueue_theme_styles()
{
  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Mr+De+Haviland&display=swap', array(), '1.0');
  wp_enqueue_style('bootstrap-style', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '1.0');
  wp_enqueue_style('default-style', get_template_directory_uri() . '/style.css', array(), false);
  wp_enqueue_style('typography-style', get_template_directory_uri() . '/css/typography.css', array(), false);
  wp_enqueue_style('theme-style', get_template_directory_uri() . '/css/theme.css', array(), false);
}

add_action( 'login_enqueue_scripts', 'custom_login_stylesheet' );
function custom_login_stylesheet() {
  wp_enqueue_style( 'login-style', get_stylesheet_directory_uri() . '/css/login.css' );
}


// Remove Woocommerce Styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

 // Support Custom Menus
add_action( 'init', 'my_custom_menus' );
function my_custom_menus() {
    register_nav_menus(
        array(
            'main-menu' => __( 'Main Menu' ),
            'footer-menu-1' => __( 'Footer Menu 1' ),
            'footer-menu-2' => __( 'Footer Menu 2' ),
        )
    );
}

add_action('woocommerce_before_cart_table', 'cart_title');
function cart_title(){
  echo '<h3 class="mb-5">Your List</h3>';
}

require_once('custom/post-types.php'); // PDP Popup
require_once('functions/class-pdp-modal.php'); // PDP Popup
require_once('functions/custom-checkout.php'); // Checkout Customized
require_once('functions/class-display-products.php'); // Display Products

add_action( 'after_setup_theme', 'add_woocommerce_support' );
function add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

add_filter( 'woocommerce_product_loop_title_classes', 'custom_woocommerce_product_loop_title_classes' );
/**
 * Append custom class(es) to the default WooCommerce product title class.
 *
 * @param string $class Existing class(es).
 * @return string Modified class(es).
 */
function custom_woocommerce_product_loop_title_classes( $class ) {
	return $class . ' h5'; // set your additional class(es) here.
}

/**
 * Add the product's short description (excerpt) to the WooCommerce shop/category pages. The description displays after the product's name, but before the product's price.
 *
 * Ref: https://gist.github.com/om4james/9883140
 *
 * Put this snippet into a child theme's functions.php file
 */
function woocommerce_after_shop_loop_item_title_short_description() {
	global $product;

	if ( ! $product->post->post_excerpt ) return;
	?>
	<div itemprop="description">
		<?php echo apply_filters( 'woocommerce_short_description', $product->post->post_excerpt ) ?>
	</div>
	<?php
}
add_action('woocommerce_after_shop_loop_item', 'woocommerce_after_shop_loop_item_title_short_description', 5);

// Remove Sidebar
function disable_woo_commerce_sidebar() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10); 
}
add_action('init', 'disable_woo_commerce_sidebar');

// Update picture size on archieve
add_filter( 'single_product_archive_thumbnail_size', function( $size ) {
  return array( '400', '400', true );
} );

// Change Proceed To Checkout Text in WooCommerce
function woocommerce_button_proceed_to_checkout() {
  $checkout_url = WC()->cart->get_checkout_url();
  ?>
  <a href="<?php echo $checkout_url; ?>" class="checkout-button alt wc-forward btn p-1 text-center bg-red mt-3 text-uppercase"><?php _e( 'Confirm', 'woocommerce' ); ?></a>
  <?php
  }

// On cart change update
add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
function iconic_cart_count_fragments( $fragments ) {
    $fragments['span#cart-count'] = '<span id="cart-count" class="badge badge-pill bg-red">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;    
}

add_filter( 'woocommerce_add_to_cart_fragments', 'cart_total_fragments', 10, 1 );
function cart_total_fragments( $fragments ) {
  ob_start();
  echo '<span id="cart_total_leo" class="text-bold">'.WC()->cart->get_cart_total().'</span>';
  $fragments['span#cart_total_leo'] = ob_get_clean();
  return $fragments;   
}


// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Add to list', 'woocommerce' );
}

// Alter WooCommerce View Cart Text
add_filter( 'gettext', function( $translated_text ) {
  if ( 'View cart' === $translated_text ) {
      $translated_text = 'View Basket';
  }
  return $translated_text;
} );


add_filter( 'pdp_modal_qty_filter', function( $product ) {
  if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
      $html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" id="modal-form" class="wcb2b-quantity" method="post" enctype="multipart/form-data">';
      $html .= woocommerce_quantity_input( array(), $product, false );
      $html .= '<button type="submit" class="button add_to_cart_button mt-3">' . esc_html( $product->add_to_cart_text() ) . '</button>';
      $html .= '</form>';
  }
  return $html;
}, 10, 2 );


// Add step value to the quantity field (default = 1)
add_filter('woocommerce_quantity_input_step', 'nsk_allow_decimal');
function nsk_allow_decimal($val) {
    return 0.5;
}
 
// Removes the WooCommerce filter, that is validating the quantity to be an int
remove_filter('woocommerce_stock_amount', 'intval');
 
// Add a filter, that validates the quantity to be a float
add_filter('woocommerce_stock_amount', 'floatval');

// Add unit price fix when showing the unit price on processed orders
add_filter('woocommerce_order_amount_item_total', 'unit_price_fix', 10, 5);
function unit_price_fix($price, $order, $item, $inc_tax = false, $round = true) {
    $qty = (!empty($item['qty']) && $item['qty'] != 0) ? $item['qty'] : 1;
    if($inc_tax) {
        $price = ($item['line_total'] + $item['line_tax']) / $qty;
    } else {
        $price = $item['line_total'] / $qty;
    }
    $price = $round ? round( $price, 2 ) : $price;
    return $price;
}

add_filter('woocommerce_sale_flash', 'woocommerce_custom_sale_text', 10, 3);
function woocommerce_custom_sale_text($text, $post, $_product)
{
    return '<span class="onsale">Offer!</span>';
}


add_filter( 'woocommerce_form_field', 'checkout_fields_in_label_error', 10, 4 );
function checkout_fields_in_label_error( $field, $key, $args, $value ) {
   if ( strpos( $field, '</span>' ) !== false && $args['required'] ) {
      $error = '<span class="error text-s mt-1" style="display:none">';
      $error .= sprintf( __( '%s is a required field.', 'woocommerce' ), $args['label'] );
      $error .= '</span>';
      $field = substr_replace( $field, $error, strpos( $field, '</span>' ), 0);
   }
   return $field;
}

// add_action( 'woocommerce_after_checkout_validation', 'misha_one_err', 9999, 2);
 
function misha_one_err( $fields, $errors ){
 
	// if any validation errors
	if( !empty( $errors->get_error_codes() ) ) {
 
		// remove all of them
		foreach( $errors->get_error_codes() as $code ) {
			$errors->remove( $code );
		}
 
		// add our custom one
		$errors->add( 'validation', 'Please fill the fields!' );
 
	}
 
}


/**
 * @snippet       Min, Max, Increment & Start Value Add to Cart Quantity | WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 4.5
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
add_filter( 'woocommerce_quantity_input_args', 'bloomer_woocommerce_quantity_changes', 10, 2 );
   
function bloomer_woocommerce_quantity_changes( $args, $product ) {
   
   if ( ! is_cart() ) {
  
      // $args['input_value'] = 4; // Start from this value (default = 1) 
      // $args['max_value'] = 10; // Max quantity (default = -1)
      $args['min_value'] = 1.0; // Min quantity (default = 0)
      $args['step'] = 0.5; // Increment/decrement by this value (default = 1)
  
   } else {
  
      // Cart's "min_value" is already 0 and we don't need "input_value"
      // $args['max_value'] = 10; // Max quantity (default = -1)
      $args['step'] = 0.5; // Increment/decrement by this value (default = 0)
      // COMMENT OUT FOLLOWING IF STEP < MIN_VALUE
      $args['min_value'] = 1.0; // Min quantity (default = 0)
  
   }
   
   return $args;
   
}


function product_tags($product = NULL){
  if(!$product) global $product;
  $terms = wp_get_post_terms( $product->get_id(), 'product_tag' );

  // Loop through each product tag for the current product
  if( count($terms) > 0 ){
    foreach($terms as $term){
        $term_id = $term->term_id; // Product tag Id
        $term_name = $term->name; // Product tag Name
        $term_slug = $term->slug; // Product tag slug
        $term_link = get_term_link( $term, 'product_tag' ); // Product tag link

        // Set the product tag names in an array
        $output[] = '<img class="tag-badge position-absolute m-0 p-2" src="'.get_template_directory_uri().'/icons/badge-'.$term_slug.'.png">';

    }
    // Set the array in a coma separated string of product tags for example
    $output = implode( ', ', $output );

    // Display the coma separated string of the product tags
    echo $output;
  }
}

/** 
 * 
 * Customize Category Page
 * 
**/

// Remove add to cart button
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

// Introduce custom button to launch modal
add_action('woocommerce_after_shop_loop_item','add_view_product_button');
function add_view_product_button(){
  global $product;
  $id = $product->get_id();
  echo '<a href="#pdpModal" data-toggle="modal" data-quantity="1" class="button add_to_cart_button" data-product_id="'.$product->get_id().'" data-product_sku="" aria-label="Add '.$product->get_name().' to your cart" rel="nofollow">View Product</a>';
}

// Remove links to PDP
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// Wrap product image
add_action('woocommerce_before_shop_loop_item_title', 'add_open_product_image_wrapper', 5);
function add_open_product_image_wrapper(){
  echo '<div class="wrapper-image mb-3 position-relative">';
  product_tags();
}
add_action('woocommerce_before_shop_loop_item_title', 'add_close_product_image_wrapper', 50);
function add_close_product_image_wrapper(){
  echo '</div>';
}


/** Manage Tab access by user types */
function meatery_posts_menu() {
  if (current_user_can('shop_manager') ) {
    remove_menu_page( 'edit.php?post_type=page' ); // Pages
    remove_menu_page( 'edit.php' );  // Posts
    remove_menu_page( 'edit-comments.php' );  // Comments
    remove_menu_page( 'tools.php' );  // Tools
    remove_menu_page( 'users.php' );  // Users
    remove_menu_page( 'plugins.php' );  // Plugins
    remove_menu_page( 'themes.php' ); // Appearance
    remove_menu_page( 'upload.php' ); // Appearance
    remove_menu_page( 'edit.php?post_type=elementor_library' ); // Pages
    remove_menu_page( 'edit.php?post_type=recipe' );
    remove_menu_page( 'edit.php?post_type=feedback' );
    remove_menu_page('wpcf7');
    remove_menu_page('jetpack');
    remove_submenu_page('woocommerce', 'wc-settings');
    remove_submenu_page('woocommerce', 'wc-addons');
    remove_submenu_page('woocommerce', 'wc-status');
    remove_submenu_page('woocommerce', 'wc-admin');
  }
}
add_action( 'admin_menu', 'meatery_posts_menu', 999 );

function editor_posts_menu() {
  if (current_user_can('editor') ) {
    remove_menu_page( 'edit.php' );  // Posts
    remove_menu_page( 'edit-comments.php' );  // Posts
    remove_menu_page( 'tools.php' );  // Tools
    remove_menu_page( 'users.php' );  // Users
    remove_menu_page( 'plugins.php' );  // Plugins
    remove_menu_page( 'themes.php' ); // Appearance
    remove_menu_page( 'upload.php' ); // Appearance
    remove_menu_page( 'edit.php?post_type=elementor_library' ); // Pages
    remove_menu_page( 'edit.php?post_type=feedback' );
    remove_menu_page('wpcf7');
    remove_menu_page('jetpack');
    remove_menu_page('woocommerce');
  }
}
add_action( 'admin_init', 'editor_posts_menu' );


/** Add a column to order list */
/**
 * Adds 'Profit' column header to 'Orders' page immediately after 'Total' column.
 *
 * @param string[] $columns
 * @return string[] $new_columns
 */
function sv_wc_cogs_add_order_profit_column_header( $columns ) {

  $new_columns = array();

  foreach ( $columns as $column_name => $column_info ) {

      $new_columns[ $column_name ] = $column_info;

      if ( 'order_status' === $column_name ) {
          $new_columns['branch_column'] = __( 'Branch', 'my-textdomain' );
      }
  }

  return $new_columns;
}
add_filter( 'manage_edit-shop_order_columns', 'sv_wc_cogs_add_order_profit_column_header', 20 );

// Adding custom fields meta data for each new column (example)
add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 20, 2 );
function custom_orders_list_column_content( $column, $post_id )
{
    switch ( $column )
    {
        case 'branch_column' :
            // Get custom post meta data
            $my_var_one = get_post_meta( $post_id, 'billing_branch', true );
            if(!empty($my_var_one))
                echo $my_var_one;

            // Testing (to be removed) - Empty value case
            else
                echo 'N/A';

            break;
    }
}

add_filter( 'manage_edit-shop_order_sortable_columns', 'wc_branch_column_sort' );
function wc_branch_column_sort( $columns ) {
  $columns['branch_column'] = 'branch_column';
  return $columns;
}


// Save custom meta fields
add_action('woocommerce_checkout_update_order_meta', 'update_custom_order_meta');
function update_custom_order_meta($order_id){
  $billing_branch = $_POST['billing_pickup'];
  $billing_communication = $_POST['billing_communication'];

  if (!empty($billing_branch)) update_post_meta($order_id, 'billing_branch', sanitize_text_field($billing_branch));
  if (!empty($billing_communication)) update_post_meta($order_id, 'billing_communication', sanitize_text_field($billing_communication));

}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
  echo '<p><strong>'.__('Delivery Location').':</strong> <br/>' . get_post_meta( $order->get_id(), 'billing_branch', true ) . '</p>';
  echo '<p><strong>'.__('Communication Preferred').':</strong> <br/>' . get_post_meta( $order->get_id(), 'billing_communication', true ) . '</p>';
}


add_action('woocommerce_checkout_before_order_review_heading', 'back_to_cart_button');
function back_to_cart_button(){
  echo '<div class="mb-4"><a href="'.wc_get_cart_url().'" class="pb-1 text-left bg-dark mt-3 mb-3 border-bottom small"><< Review your order</a></div>';
}

/**
 * Change number of related products output
 */ 
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 1; // arranged in 2 columns
	return $args;
}

add_action('woocommerce_before_single_product_summary', 'open_pdp_row');
function open_pdp_row(){
  echo '<div class="row py-5">';
}

add_action('woocommerce_after_single_product_summary', 'close_pdp_row',5);
function close_pdp_row(){
  echo '</div>';
}
remove_action('woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs');