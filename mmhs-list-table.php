<?php
/**
 * Plugin name: MMHS List Table
 * Description: Wp List Table
 * Author: Mehedi Hassan
 */

 add_action('admin_menu', 'mmhs_list_table_menu');
function mmhs_list_table_menu() {
    add_menu_page( 'MMHS List Table', 'MMHS List Table', 'manage_options', 'mmhs_list_table', 'wpl_mmhs_list_table_fn' );
}

function wpl_mmhs_list_table_fn() {
  $action = isset( $_GET['action'] ) ? trim( $_GET['action'] ) : "";

    if( $action == 'mmhs-edit' ) {
      $post_id = isset( $_GET['post_id'] ) ? intval( $_GET['post_id'] ) : "";
      ob_start();
      include_once plugin_dir_path(__FILE__) . 'views/mmhs-edit-fn.php';
      $template = ob_get_contents();
      ob_end_clean();
      echo $template;
    } elseif( $action == 'mmhs-delete' ) {
      $post_id = isset( $_GET['post_id'] ) ? intval( $_GET['post_id'] ) : "";
      ob_start();
      include_once plugin_dir_path(__FILE__) . 'views/mmhs-delete-fn.php';
      $template = ob_get_contents();
      ob_end_clean();
      echo $template;
    } else {
      ob_start();
      include_once plugin_dir_path(__FILE__) . 'views/mmhs-table-list.php';
      $template = ob_get_contents();
      ob_end_clean();
      echo $template;
    }
}