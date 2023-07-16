<?php

if ( !class_exists('WP_List_Table') ) {
  require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}




class MmhsTableList extends WP_List_Table {

  // Require method list
    /* 
      Prepare_items
      get_columns
      Get_sortable_columns
      get_bulk_actions
      search_box
      display
    */

  // prepare_items
  public function prepare_items() {    
      
  }

} // End MmhsTableList class


function mmhs_show_data_list_table() {
  $mmhs_table = new MmhsTableList();
  $mmhs_table->prepare_items();
  $mmhs_table->display();
}
mmhs_show_data_list_table();