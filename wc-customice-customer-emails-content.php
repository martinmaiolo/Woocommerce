// Personaliza el mensaje por defecto de los emails de pedido del cliente
if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) ){
	add_action( 'init', 'create_custom_wc_emails_dir' );
	function create_custom_wc_emails_dir(){
	
		$processing_entry_content = 'Hola {{nombre}}. ¡Eres genial!<br><br>Gracias por comprar en nuestra tienda.<br><br>Ya hemos recibido tu pedido y estamos preparándolo para enviártelo. En cuanto salga del nuestros almacenes te avisaremos ;-)'; //Escribe aquí tu mensaje personalizado para el email de procesando pedido
		$completed_entry_content = 'Hola {{nombre}}!<br><br> Tu pedido ya está listo y acaba de salir de nuestros almacenes. En 24h hábiles lo tendrás en tu dirección.<br><br>Te recordamos los detalles de tu compra a continuación:'; //Escribe aquí tu mensaje personalizado para el email de pedido completado
	
		// Crea la carpeta /woocommerce/emails/ dentro del tema
		$my_theme_emails_dir = get_stylesheet_directory();
		$my_theme_emails_dir .= '/woocommerce/emails/';
	
		if ( !is_dir( $my_theme_emails_dir ) ) {
	
			wp_mkdir_p( $my_theme_emails_dir );
		}
	
		// Crea la nueva plantilla del email de "Procesando tu pedido"
		$processing_email_content = get_email_content( $processing_entry_content, 'processing' );
		$new_processing_email = fopen( $my_theme_emails_dir . '/customer-processing-order.php' , 'w+');
		fwrite( $new_processing_email , $processing_email_content );
		fclose( $new_processing_email );
	
		// Crea la nueva plantilla del email de "Pedido completado"
		$completed_email_content = get_email_content( $completed_entry_content, 'completed' );
		$new_completed_email = fopen( $my_theme_emails_dir . '/customer-completed-order.php' , 'w+');
		fwrite( $new_completed_email , $completed_email_content );
		fclose( $new_completed_email );
	}
	
	function get_email_content( $entry_content = '', $type = 'processing' ){
	
		$new_entry_content = str_replace( '{{nombre}}' , '<?php echo isset( $first_name )? $first_name : ""; ?>', $entry_content );
	
		if ( 'processing' == $type ) {
	
			$email_content = '
		<?php 
		/**
		 * Customer processing order email
		 *
		 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.';
		}elseif( 'completed' == $type ){
	
			$email_content = '<?php
		/**
		 * Customer completed order email
		 *
		 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.';
		}
		
		$email_content .= '
		 *
		 * HOWEVER, on occasion WooCommerce will need to update template files and you
		 * (the theme developer) will need to copy the new files to your theme to
		 * maintain compatibility. We try to do this as little as possible, but it does
		 * happen. When this occurs the version of the template file will be bumped and
		 * the readme will list any important changes.
		 *
		 * @see 	    https://docs.woocommerce.com/document/template-structure/
		 * @author 		WooThemes
		 * @package 	WooCommerce/Templates/Emails
		 * @version     2.5.0
		 */
		
		if ( ! defined( \'ABSPATH\' ) ) {
			exit;
		}
		
		// Get billing first name
		$first_name = $order->get_address();
		$first_name = $first_name[ \'first_name\' ];
	
		/**
		 * @hooked WC_Emails::email_header() Output the email header
		 */
		do_action( \'woocommerce_email_header\', $email_heading, $email ); ?>
	
		';
	
		if ( empty( $new_entry_content ) && 'processing' == $type ) {
	
			$email_content .= '<p><?php _e( "Your order has been received and is now being processed. Your order details are shown below for your reference:", \'woocommerce\' ); ?></p>';
		}elseif( empty( $new_entry_content ) && 'completed' == $type ){
	
			$email_content .= '<p><?php printf( __( "Hi there. Your recent order on %s has been completed. Your order details are shown below for your reference:", \'woocommerce\' ), get_option( \'blogname\' ) ); ?></p>';
		}elseif( !empty( $new_entry_content ) ){
	
			$email_content .= '<p>'. $new_entry_content .'</p>';
		}
	
		$email_content .= '
	
		<?php
		
		/**
		 * @hooked WC_Emails::order_details() Shows the order details table.
		 * @hooked WC_Emails::order_schema_markup() Adds Schema.org markup.
		 * @since 2.5.0
		 */
		do_action( \'woocommerce_email_order_details\', $order, $sent_to_admin, $plain_text, $email );
		
		/**
		 * @hooked WC_Emails::order_meta() Shows order meta data.
		 */
		do_action( \'woocommerce_email_order_meta\', $order, $sent_to_admin, $plain_text, $email );
		
		/**
		 * @hooked WC_Emails::customer_details() Shows customer details
		 * @hooked WC_Emails::email_address() Shows email address
		 */
		do_action( \'woocommerce_email_customer_details\', $order, $sent_to_admin, $plain_text, $email );
		
		/**
		 * @hooked WC_Emails::email_footer() Output the email footer
		 */
		do_action( \'woocommerce_email_footer\', $email );';
	
		return $email_content;
	}
}
