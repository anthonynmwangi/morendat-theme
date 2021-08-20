<?php
/**
 * Customized checkout page
 *
 * This template is used to cater for how Morendat handles checkout page from 
 * layout, style and custom animations required to make customer experience
 * fast, clear and easier with minumum distruction.
 *
 */

global $woocommerce;

class custom_checkout {

  private $price;
  

  function __construct() {
    // Remove unused checkout fields.
    add_filter( 'woocommerce_checkout_fields' , array($this,'remove_checkout_fields' ) );

    // Change layout of checkout fields
    add_filter( 'woocommerce_checkout_fields' , array($this,'layout_checkout_fields') );

    // Add custom checkout fields
    add_filter( 'woocommerce_checkout_fields' , array($this,'custom_checkout_fields') );

    // Remove the order review feature
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
    // add_action( 'woocommerce_before_checkout_billing_form', 'woocommerce_order_review', 10 );

    // Add Cart total
    add_action('woocommerce_review_order_before_submit', array($this, 'include_order_total'));

    // Thank you messaging
    add_filter('woocommerce_thankyou_order_received_text', array($this, 'thank_you_message'));

    //
    remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );

    // Style Updates
    add_action( 'wp_head' , array($this,'style_checkout_fields') );

    // Javascript Actions
    add_action( 'wp_footer' , array($this,'js_checkout_actions'), 30 );

    
  }

  function remove_checkout_fields( $fields ) {
    unset( $fields['billing']['billing_last_name']);
    unset( $fields['billing']['billing_company']);
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_postcode'] );
    unset( $fields['billing']['billing_neighbourhood'] );
    unset( $fields['billing']['billing_landmark'] );
    unset( $fields['billing']['billing_address_2'] );
    return $fields;
  }

  function layout_checkout_fields( $fields ) {

    // First name field customizations
    $fields['billing']['billing_first_name'] = array(
        'class' => array('form-group', 'mb-3'),
        'label' => 'Full Name',
        'required' => true,
        'priority' => 1,
        'input_class' => array('form-control'),
        'label_class' => array('text-s'),
    );

    // Email field customizations
    $fields['billing']['billing_email'] = array(
        'class' => array('form-group', 'mb-3'),
        'type' => 'email',
        'label' => 'Email Address',
        'required' => true,
        'priority' => 2,
        'input_class' => array('form-control'),
        'label_class' => array('text-s'),
    );

    // Hide default phone number field
    $fields['billing']['billing_phone'] = array(
      'class' => array('form-group', 'mb-3'),
      'type' => 'text',
      'label' => 'Phone Number',
      'required' => true,
      'priority' => 3,
      'input_class' => array('form-control'),
      'label_class' => array('text-s'),
    );


    // Hide Billing Address 1 Field
    $fields['billing']['billing_address_1'] = array(
      'class' => array('form-group', 'mb-3', 'd-none'),
      'type' => 'textarea',
      'label' => 'Delivery Address',
      'required' => true,
      'priority' => 4,
      'input_class' => array('form-control'),
      'label_class' => array('text-s'),
    );

    // Hide Billing Address 1 Field
    $fields['order']['order_comments'] = array(
      'class' => array('form-group', 'mb-3'),
      'type' => 'textarea',
      'label' => 'Additional Notes',
      'required' => false,
      'priority' => 4,
      'input_class' => array('form-control'),
      'label_class' => array('text-s'),
      'placeholder' => __('How would you like your meat packed?') ,
    );

    // Country delployed to
    $fields['billing']['billing_country'] = array(
      'class' => array('d-none'),
      'input_class' => array('d-none'),
    );

    return $fields;
  }

  function include_order_total(){
    echo '<div class="text-right mt-5">Total ';
    wc_cart_totals_order_total_html();
    echo '</div>';
    echo ob_get_clean();
  }

  function thank_you_message(){
    echo '<!-- Basket summary -->
    <div class="row">
      <div class="offset-sm-3 col-sm-6">
        <h3 class="mb-4">Thank you for submitting your order list!</h3>
        <p>Our concierge will be in contact within 24 hours to confirm how you would like to process payment.</p>
        <p>Thank you for your patience!</p>
        <div class="py-5"></div>
      </div>
    </div>';
  }

  function style_checkout_fields() {
    if(is_checkout()){ ?>
    <style id="agedmeat-style-checkout" type="text/css">
      .woocommerce form .form-row{ display:block;   }
      .woocommerce form .form-row textarea{ height:220px; }
      .woocommerce-checkout #payment div.form-row{ padding:0;}
      .woocommerce-checkout #payment{ background: none; border-radius: 0; }
      .woocommerce-privacy-policy-text{ font-size: 14px;}

      .woocommerce form .form-control[readonly]{ background-color: #000; color: #FFF; border: none; padding: 0; height: auto !important; }

      .woocommerce-checkout p.woocommerce-invalid-required-field span.error {
        color: #e2401c;
        display: block !important;
      }

      .woocommerce-invalid .form-control{ border:solid 1px #e2401c; }

      .woocommerce-error{ padding-left: 0; list-style: none;}
      .woocommerce-error li{ font-size: 14px; color: #e2401c; }


    </style>

    <?php }
  }

  function js_checkout_actions(){
    if(is_checkout()){ ?>
      <script>
        // When Delivery / Shipping option changes
        jQuery('#billing_pickup').on('change', function() {
          console.log(jQuery(this).val());
          jQuery('#billing_address_1_field').removeClass('woocommerce-invalid');
          jQuery('#billing_address_1_field').removeClass('woocommerce-invalid-required-field');
          if(jQuery(this).val() == 'Sarit Meatery'){
            jQuery('#billing_address_1').val('Our Sarit branch is located in Sarit Centre  \nPick up hours are 9am - 6pm');
            jQuery('#billing_address_1').prop("readonly", true);
            jQuery("label[for='billing_address_1']").text("Pick up details");
            jQuery('#billing_address_1_field').removeClass('d-none');
          }else if(jQuery(this).val() == 'Naivasha Meatery') {
            jQuery('#billing_address_1').val('Our Naivasha branch is located in Buffallo Mall  \nPick up hours 8:00am - 6:00pm');
            jQuery('#billing_address_1').prop("readonly", true);
            jQuery("label[for='billing_address_1']").text("Pick up details");
            jQuery('#billing_address_1_field').removeClass('d-none');
          }else if(jQuery(this).val() == 'Nanyuki Meatery') {
            jQuery('#billing_address_1').val('Our Nanyuki branch is located in Cedar Mall  \nPick up hours 8:00am - 6:00pm')
            jQuery('#billing_address_1').prop("readonly", true);
            jQuery("label[for='billing_address_1']").text("Pick up details");
            jQuery('#billing_address_1_field').removeClass('d-none');
          }else if(jQuery(this).val() == 'Delivery Order') {
            jQuery('#billing_address_1').val('')
            jQuery('#billing_address_1').prop("readonly", false);
            jQuery("label[for='billing_address_1']").text("Delivery Address");
            jQuery('#billing_address_1_field').removeClass('d-none');
          }else{
            jQuery('#billing_address_1').val('')
            jQuery('#billing_address_1_field').addClass('d-none');
            jQuery('#billing_address_1_field').addClass('woocommerce-invalid');
            jQuery('#billing_address_1_field').addClass('woocommerce-invalid-required-field');
          }
        });

        /** Validate before placing the order
        jQuery('.woocommerce-checkout').submit(function( e ) {
          e.preventDefault();
          jQuery('#billing_address_1').prop('disabled', false);
          
        }); */

        
      
      </script>
    <?php }
  }

  function custom_checkout_fields( $fields ){
    // Age field customizations
    $fields['billing']['billing_communication'] = array(
        'type' => 'select',
        'class' => array('form-group', 'mb-3'),
        'label' => 'Prefered mode of communication',
        'required' => true,
        'priority' => 3,
        'options' => array(
          '' => __( 'Please select'),
          'email' => __( 'Email'),
          'phone' => __( 'Phone Call')
        ),
        'input_class' => array('form-control'),
    ); 

    // Gender field customizations
    $fields['billing']['billing_pickup'] = array(
        'type' => 'select',
        'class' => array('form-group', 'mb-3'),
        'label' => 'Pickup from our collection points or have it delivered',
        'required' => true,
        'priority' => 3,
        'options' => array(
          '' => __( 'Please select'),
          'Sarit Meatery'   => __( 'Pick up from Sarit Centre Meatery, Nairobi'),
          'Naivasha Meatery'     => __( 'Pick up from Buffallo Mall Meatery, Naivasha'),
          'Nanyuki Meatery'     => __( 'Pick up from Cedar Mall Meatery, Nanyuki'),
          'Delivery Order'     => __( 'Delivery to my location'),
        ),
        'input_class' => array('form-control'),
    );   
   
    return $fields;
  }



}
new custom_checkout();