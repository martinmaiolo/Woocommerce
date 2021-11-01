<?php

/**
 * Quantity buttons
 */
add_action( 'woocommerce_after_quantity_input_field', 'arendelle_quantity_plus_sign' ); 
function arendelle_quantity_plus_sign() {
	echo '<span class="quantity__button quantity__plus"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>';
}
 
add_action( 'woocommerce_before_quantity_input_field', 'arendelle_quantity_minus_sign' );
function arendelle_quantity_minus_sign() {
	echo '<span class="quantity__button quantity__minus"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg></span>';
}

add_action( 'wp_footer', 'arendelle_quantity_plus_minus' ); 
function arendelle_quantity_plus_minus() {

   ?>
		<script type="text/javascript">
						
			jQuery(document).ready(function($) {   
					
				var forms = jQuery('.woocommerce-cart-form, form.cart');
						forms.find('.quantity.hidden').prev( '.quantity__button' ).hide();
						forms.find('.quantity.hidden').next( '.quantity__button' ).hide();

				$(document).on( 'click', 'form.cart .quantity__button, .woocommerce-cart-form .quantity__button', function() {

					var $this = $(this);					

					// Get current quantity values
					var qty = $this.closest( '.quantity' ).find( '.qty' );
					var val = ( qty.val() == '' ) ? 0 : parseFloat(qty.val());
					var max = parseFloat(qty.attr( 'max' ));
					var min = parseFloat(qty.attr( 'min' ));
					var step = parseFloat(qty.attr( 'step' ));

					// Change the value if plus or minus
					if ( $this.is( '.quantity__plus' ) ) {
						if ( max && ( max <= val ) ) {
							qty.val( max ).change();
						} 
						else {
							qty.val( val + step ).change();
						}
					} 
					else {
						if ( min && ( min >= val ) ) {
							qty.val( min ).change();
						} 
						else if ( val >= 1 ) {
							qty.val( val - step ).change();
						}
					}							
				});          
			});
						
		</script>
   <?php
}
