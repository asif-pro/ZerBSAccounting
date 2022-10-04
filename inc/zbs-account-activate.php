<?php

class Zero_BS_AccountingPluginActivate
{
  public static function activate() {
    if ( ! current_user_can( 'activate_plugins' ) ) return;

    global $wpdb;  
    if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'zero-bs-accounting'", 'ARRAY_A' ) ) {   
      
      // create zbs-account page
      $current_user = wp_get_current_user();
      $page = array(
        'post_title'  => __( 'Zero BS Accounting' ),
        'post-slug'   => 'zero-bs-accounting',
        'post_status' => 'publish',
        'post_author' => $current_user->ID,
        'post_type'   => 'page',
      );
      
      // save zbs-account page as option
      $zbspage = wp_insert_post( $page );
      update_option( 'zbs-accountpage', $zbspage ); 
    }
    add_option('zbs_accounting_do_activation_redirect', true);
  }
}
