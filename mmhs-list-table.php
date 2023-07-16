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
  ob_start();
  include_once plugin_dir_path(__FILE__) . 'views/mmhs-table-list.php';
  $template = ob_get_contents();
  ob_end_clean();
  echo $template;
}