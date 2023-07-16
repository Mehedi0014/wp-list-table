<?php

if ( !class_exists('WP_List_Table') ) {
  require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}




class MmhsTableList extends WP_List_Table {  

  // prepare_items
  public function prepare_items() {
    $orderby = isset( $_GET['orderby'] ) ? trim( $_GET['orderby'] ) : ""; // come form query string
    $order = isset( $_GET['order'] ) ? trim( $_GET['order'] ) : ""; // come form query string       
    $this->items = $this->wp_list_table_data( $orderby, $order); // Sokol data ja amara display korbo ta ekhane items variable e store kora holo.

    $this->items = $this->wp_list_table_data( $orderby, $order); // Sokol data ja amara display korbo ta ekhane items variable e store kora holo.
    $columns = $this->get_columns(); // Ai function dara j j kolam lagbe tar process kora hoy.
    $hidden = $this->get_hidden_columns(); // use to hide any coloumn. get_columns method e j column key diclare korechi just sei column key pass kore detay hobe: jemon name ba email.
    $sortable = $this->get_sortable_columns(); // table k shortable korar jonno use koar hoy. url er sese query string pass kore kaj ta kora hoy like: orderby=name&order=asc
    $this->_column_headers = array( $columns, $hidden, $sortable ); // Ekhane column er num table header e display kora hoyeche.
  }

  // This is custom method for shortable data
  public function wp_list_table_data($orderby = '', $order = '') {    
    if( $orderby == 'name' && $order == 'desc' ) {
      $data = array(
        array('id' => 4, 'name' => 'Shirso', 'email' => 'Shirso@gmail.com'),
        array('id' => 2, 'name' => 'Pranto', 'email' => 'pranto@gmail.com'),
        array('id' => 1, 'name' => 'Mehedi', 'email' => 'mehedi@gmail.com'),
        array('id' => 3, 'name' => 'Hassan', 'email' => 'hassan@gmail.com'),
      );
    } elseif( $orderby == 'name' && $order == 'asc' ) {
      $data = array(
        array('id' => 3, 'name' => 'Hassan', 'email' => 'hassan@gmail.com'),
        array('id' => 1, 'name' => 'Mehedi', 'email' => 'mehedi@gmail.com'),
        array('id' => 2, 'name' => 'Pranto', 'email' => 'pranto@gmail.com'),
        array('id' => 4, 'name' => 'Shirso', 'email' => 'Shirso@gmail.com'),
      );
    } else {
      $data = array(
        array('id' => 3, 'name' => 'Hassan', 'email' => 'hassan@gmail.com'),
        array('id' => 1, 'name' => 'Mehedi', 'email' => 'mehedi@gmail.com'),
        array('id' => 2, 'name' => 'Pranto', 'email' => 'pranto@gmail.com'),
        array('id' => 4, 'name' => 'Shirso', 'email' => 'Shirso@gmail.com'),
      );
    }        
    return $data;
  }

  public function get_hidden_columns() {
    return array('email');
  }

  public function get_sortable_columns() {
    return array(
      'name' => array('name', true) // default false (asc order) -> following the url you find its pass a query string.
    );
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