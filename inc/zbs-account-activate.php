<?php

class Zero_BS_AccountingPluginActivate
{
  public static function activate() {
    //if ( ! current_user_can( 'activate_plugins' ) ) return;

    global $wpdb;

//creating Table intially, if already not exists
        $table_name = $wpdb->prefix.'account_profiles';
        $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
                id INT NOT NULL AUTO_INCREMENT,
                account_name VARCHAR (250),
                user_id INT (10),
                PRIMARY KEY (id)
              );";
              require_once (ABSPATH."wp-admin/includes/upgrade.php");
              dbDelta($sql);

//Adding/Insert data into table while creating table initially, while there is no data on table
          $user = wp_get_current_user();
          $checkuser = $wpdb->get_var(
            $wpdb->prepare( "SELECT COUNT(*) from {$table_name} where user_id = %d", get_current_user_id() )
          );
          
          if(! $checkuser){
            $wpdb->insert($table_name,
                [
                  'account_name'=>$user->user_nicename,
                  'user_id'=>$user->ID
                ]);
          }


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
