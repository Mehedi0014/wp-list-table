<?php

if ( !class_exists('WP_List_Table') ) {
  require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}




class MmhsTableList extends WP_List_Table {  

  // prepare_items
  public function prepare_items() {
    $orderby = isset( $_GET['orderby'] ) ? trim( $_GET['orderby'] ) : ""; // come form query string
    $order = isset( $_GET['order'] ) ? trim( $_GET['order'] ) : ""; // come form query string
    $search_term = isset( $_POST['s'] ) ? trim( $_POST['s'] ) : "";       
    $this->items = $this->wp_list_table_data( $orderby, $order); // Sokol data ja amara display korbo ta ekhane items variable e store kora holo.

    $this->items = $this->wp_list_table_data( $orderby, $order, $search_term); // Sokol data ja amara display korbo ta ekhane items variable e store kora holo.
    $columns = $this->get_columns(); // Ai function dara j j kolam lagbe tar process kora hoy.
    $hidden = $this->get_hidden_columns(); // use to hide any coloumn. get_columns method e j column key diclare korechi just sei column key pass kore detay hobe: jemon name ba email.
    $sortable = $this->get_sortable_columns(); // table k shortable korar jonno use koar hoy. url er sese query string pass kore kaj ta kora hoy like: orderby=name&order=asc
    $this->_column_headers = array( $columns, $hidden, $sortable ); // Ekhane column er num table header e display kora hoyeche.
  }

  // This is custom method for shortable data
  public function wp_list_table_data($orderby = '', $order = '', $search_term = '' ) {
    global $wpdb;

    if( !empty( $search_term ) ) {
      $all_posts = $wpdb->get_results(
        "SELECT * FROM " . $wpdb->posts . " WHERE post_status = 'publish' AND post_type = 'post' AND ( post_title LIKE '%$search_term%' OR post_excerpt LIKE '%$search_term%' ) "
      );
    } else {
      if( $orderby == 'title' && $order == 'desc' ){
        $all_posts = $wpdb->get_results(
          "SELECT * FROM " . $wpdb->posts . " WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_title DESC"
        );
      } elseif( $orderby == 'title' && $order == 'asc' ) {
        $all_posts = $wpdb->get_results(
          "SELECT * FROM " . $wpdb->posts . " WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_title ASC"
        );
      } else {
        $all_posts = $wpdb->get_results(
          "SELECT * FROM " . $wpdb->posts . " WHERE post_status = 'publish' AND post_type = 'post' ORDER BY id DESC"
        );
      }
    }

    $posts_array = array();
    if( count($all_posts) > 0 ) {
      foreach( $all_posts as $index => $post ) {
        $posts_array[] = array(
          'id'            => $post->ID,
          'title'         => $post->post_title,
          'mmhs_excerpt'  => $post->post_excerpt,
          'slug'          => $post->post_name,
        );
      }
    }
    return $posts_array;
  }

  public function get_hidden_columns() {
    return array();
  }

  public function get_sortable_columns() {
    return array(
      'title' => array('title', false)
    );
  }


  // get_columns
  public function get_columns() {
    $columns = array(
      'id'           => 'ID',
      'title'        => 'Title',
      'mmhs_excerpt' => 'Excerpt',
      'slug'         => 'Post Slug',
    );
    return $columns;
  }

  // columns_default
  public function column_default( $item, $column_name ) {
    switch( $column_name ) {
      case 'id':
      case 'title':
      case 'mmhs_excerpt':
      case 'slug':
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
  echo '<form method="post" name="frm_search_post" action=" ' . $_SERVER["PHP_SELF"] . '?page=mmhs_list_table ">';
  $mmhs_table->search_box('Search post', 'search_post_id', );
  echo '</form>';
  $mmhs_table->display();
}
mmhs_show_data_list_table();