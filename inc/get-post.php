<?php
add_action( 'pre_get_posts', function($query) {
  if ( is_admin() || ! $query->is_main_query() ){
    return;
  }else{
    $query->set( 'meta_query',
        array(
            'key'     => 'on_off',
            'compare' =>  '=',
            'value'   => 'OK'
        ) 
    );
  }
});