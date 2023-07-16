<?php

if ( !class_exists('WP_List_Table') ) {
  require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}




class MmhsTableList extends WP_List_Table {
  // Define data set for WP_List_Table => Data
  var $data = array(
    array('id' => 1, 'name' => 'Mehedi', 'email' => 'mehedi@gmail.com'),
    array('id' => 2, 'name' => 'Pranto', 'email' => 'pranto@gmail.com'),
    array('id' => 3, 'name' => 'Hassan', 'email' => 'hassan@gmail.com'),
    array('id' => 4, 'name' => 'Shirso', 'email' => 'shirso@gmail.com'),
  );
  

  // prepare_items
  public function prepare_items() { 
    $this->items = $this->data; // Sokol data ja amara display korbo ta ekhane items variable e store kora holo.
    $columns = $this->get_columns(); // Ai function dara j j kolam lagbe tar process kora hoy.
    $this->_column_headers = array( $columns ); // Ekhane column er num table header e display kora hoyeche.
  }

  // get_columns
  public function get_columns() {
    $columns = array(
      'id' => 'ID',
      'name' => 'Name',
      'email' => 'Email',
    );
    return $columns;
  }

  // columns_default
  public function column_default( $item, $column_name ) {
    switch( $column_name ) {
      case 'id':
      case 'name':
      case 'email':
      return $item[$column_name];
      default:
      return 'No value found';
    }
  }
  
  

} // End MmhsTableList class


function mmhs_show_data_list_table() {
  $mmhs_table = new MmhsTableList();
  $mmhs_table->prepare_items();
  echo '<h3>This is list table</h3>';
  $mmhs_table->display();
}
mmhs_show_data_list_table();