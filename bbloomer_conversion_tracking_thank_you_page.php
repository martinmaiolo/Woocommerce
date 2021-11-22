add_action( 'woocommerce_thankyou', 'bbloomer_conversion_tracking_thank_you_page' );
 
function bbloomer_conversion_tracking_thank_you_page() {
?>
   <!-- Event snippet for Venta conversion page -->
    <script>
       gtag('event', 'conversion', {
        'send_to': 'AW-709286940/BRF8CJmLgssBEJy4m9IC',
        'value': 6.0,
       'currency': 'MXN',
       'transaction_id': ''
     });
    </script>
<?php
}
