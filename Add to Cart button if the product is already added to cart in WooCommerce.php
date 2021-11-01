//Rename the button on the Product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'ts_product_add_cart_button' );
 
function ts_product_add_cart_button( $label ) {
    
   foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
      $product = $values['data'];
      if( get_the_ID() == $product->get_id() ) {
         $label = __('Already added to Cart. Add again?', 'woocommerce');
      }
   }
    
   return $label;
 
}
 
//Rename the button on the Shop page 
add_filter( 'woocommerce_product_add_to_cart_text', 'ts_shop_add_cart_button', 99, 2 );
 
function ts_shop_add_cart_button( $label, $product ) {
    
   if ( $product->get_type() == 'simple' && $product->is_purchasable() && $product->is_in_stock() ) 
   {
       
      foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
         $_product = $values['data'];
         if( get_the_ID() == $_product->get_id() ) {
            $label = __('Already added to Cart. Add again?', 'woocommerce');
         }
       }    
   }
    return $label;    
}
