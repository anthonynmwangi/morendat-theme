(function ($) {

  // ajax call for opening pdp popup html
  $('#pdpModal').on('show.bs.modal', function (e) {
    var product_id = $(e.relatedTarget).data('product_id');
    var modal = $(this)
    modal.find('#popup-title').text('New message to ' + product_id)
    
   $(".mini-cart-div").html('<div class="text-center"><div class="spinner-border"></div></div>');
    $.ajax({
        type: "POST",
        url: ajax_url,
        data: {
            action: 'ajax_pdp_modal_open',
            productID: product_id
         },
        success: function(data){
          $(".mini-cart-div").html(data);
        }
    });
  });

  /**
   * On Product Details Page (PDP) and Cart Page we have an add or remove
   product quantities
    * While adding and removing it ensure it remains within the min max limits
    * set for the said product as it move incrementaly based on the step variable
    provided
    */
  $(document).on('click', '.qty-plus, .qty-minus', function (e) {
    e.preventDefault();
    
    if (!String.prototype.getDecimals) {
      String.prototype.getDecimals = function () {
          var num = this,
              match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
          if (!match) {
              return 0;
          }
          return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
      }
    }

    var $qty = $(this).closest('.quantity').find('.qty'),
        currentVal = parseFloat($qty.val()),
        max = parseFloat($qty.attr('max')),
        min = parseFloat($qty.attr('min')),
        step = $qty.attr('step');

        

    // Format values
    if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
    if (max === '' || max === 'NaN') max = '';
    if (min === '' || min === 'NaN') min = 0;
    if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 0.5;

    // Change the value
    var updateCart = false;
    if ($(this).is('.qty-plus')) {
      newQuanty = (currentVal + parseFloat(step)).toFixed(step.getDecimals());
      if(!(newQuanty % 1)) newQuanty = Math.trunc(newQuanty);
        if (max && (currentVal >= max)) {
            $qty.val(max);
        } else {
          // if('10.0' % 1)
            $qty.val(newQuanty);
            updateCart = true;
        }
    } else {
      newQuanty = (currentVal - parseFloat(step)).toFixed(step.getDecimals());
      if(!(newQuanty % 1)) newQuanty = Math.trunc(newQuanty);
        if (min && (currentVal <= min)) {
            $qty.val(min);
        } else if (currentVal > 0) {
            $qty.val(newQuanty);
            updateCart = true;
        }
    }
    // Trigger change event
    $qty.trigger('change');

    /**
     * On Cart Page allow automatically update cart
     * This is done by calling a trigger each time
     a user add or removes an item
      */
    if ($('.woocommerce-cart-form').length && updateCart) {
        $("[name='update_cart']").trigger("click");
    }else if(updateCart){
      // addToCartCustom($qty);
    }

  });

function addToCartCustom($field){
  let qty = $field.val()
  let cartkey = $field.data('cart-key');
  let id = $field.data('product-id');

  if(cartkey){
  
    jQuery.ajax({
      type: "POST",
      url: ajax_url,
      data: {
          action: 'pdp_modal_update',
          cartkey : cartkey,
          quantity : qty
        },
      success: function(data){
        if(data.trim()==1) {
            jQuery(document.body).trigger('wc_fragment_refresh');
        }
      }
    });
  }else{
    $.get('http://ark.ke/projects/morendat/wp/?post_type=product&quantity='+qty+'&add-to-cart=' + id, function() {
      // call back
      jQuery(document.body).trigger('wc_fragment_refresh');
      $("#pdpModal").modal('hide');
      console.log('with luv qty:'+qty+' id:'+id);
   });
    
  }
}

$(document).on('submit', 'form#modal-form', function (e) {
  e.preventDefault();

  $qty = $(this).closest('.quantity').find('.qty')

  addToCartCustom($("[id^='quantity_']" ));

});

$('.breaker').each(function(i, obj) {
  let text_orginal = $( this ).html();
  let text_before_space = text_orginal.substr(0,text_orginal.indexOf(' '));
  let text_after_space = text_orginal.substr(text_orginal.indexOf(' ')+1);
  $( this ).html( text_before_space+'<br>'+text_after_space );
});

$('#cat_list .sub_cat').on('click', function () {
  let cat_slug = $(this).data('slug');
  let cat_id = $(this).data('cat');
  $('.sub_cat').removeClass('text-red');
  $('.cuts').removeClass('active');
  $("#beef-cuts").find("[data-cat='"+cat_slug+"']").addClass("active");
  $(this).addClass('text-red');
  $("."+cat_slug).addClass('active');

  display_products_action(cat_slug);

});

$(document).on('click', '.cuts',function(){ 
  let cat_slug = $(this).data('cat');
  $('.cuts').removeClass('active');
  $('.sub_cat').removeClass('text-red');
  $("#beef-cuts").find("[data-cat='"+cat_slug+"']").addClass("active");
  $("#cat_list").find("[data-slug='"+cat_slug+"']").addClass("text-red");
  display_products_action(cat_slug);

});

function display_products_action(slug){

  $("#product-display").html(`<div class="text-center"><div class="spinner-grow text-red mr-2"></div><div class="spinner-grow text-red mr-2"></div><div class="spinner-grow text-red mr-2"></div></div>`);

  $.ajax({
    type: "POST",
    url: ajax_url,
    data: {
        action: 'display_products_update',
        catSlug : slug,
      },
    success: function(data){
      $('#product-display').html(data);
    }
  });

}

$(document).on('click','.wrapper-img',function(){
  if ($(this).find('.checkbox').hasClass('bg-red')){
    $(this).find('.checkbox').removeClass('bg-red').html('');
  }else{
    $(this).find('.checkbox').addClass('bg-red').html('&#10004;');  
  }
});



})(jQuery);