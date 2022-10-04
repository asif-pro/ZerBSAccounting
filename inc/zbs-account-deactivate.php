<?php

class Zero_BS_AccountingPluginDeactivate
{
  public static function deactivate() {
    $zbspage = get_option( 'zbs-accountpage' );
    if( $zbspage ) {
      wp_delete_post( $zbspage );   
    }
    delete_option( 'zbs-accountpage' ); 
  }
}
