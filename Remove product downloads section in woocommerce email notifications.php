add_action( 'woocommerce_email', 'remove_email_order_downloads', 10, 1 );
function remove_email_order_downloads( $emails ){
    remove_action( 'woocommerce_email_order_details', array( $emails, 'order_downloads' ), 10 );
    add_action( 'woocommerce_email_order_details', 'custom_order_downloads', 9, 4 );
}

function custom_order_downloads( $order, $sent_to_admin = false, $plain_text = false, $email = '' ) {
    $show_downloads = $order->has_downloadable_item() && $order->is_download_permitted() && ! $sent_to_admin && $order->has_status('completed');

    if ( ! $show_downloads ) {
        return;
    }

    $downloads = $order->get_downloadable_items();
    $columns   = apply_filters( 'woocommerce_email_downloads_columns', array(
        'download-product' => __( 'Product', 'woocommerce' ),
        'download-expires' => __( 'Expires', 'woocommerce' ),
        'download-file'    => __( 'Download', 'woocommerce' ),
    ) );

    if ( $plain_text ) {
        wc_get_template( 'emails/plain/email-downloads.php', array( 'order' => $order, 'sent_to_admin' => $sent_to_admin, 'plain_text' => $plain_text, 'email' => $email, 'downloads' => $downloads, 'columns' => $columns ) );
    } else {
        wc_get_template( 'emails/email-downloads.php', array( 'order' => $order, 'sent_to_admin' => $sent_to_admin, 'plain_text' => $plain_text, 'email' => $email, 'downloads' => $downloads, 'columns' => $columns ) );
    }
}
