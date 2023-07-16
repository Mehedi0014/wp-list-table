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

    $datas = $this->wp_list_table_data( $orderby, $order, $search_term); // Sokol data ja amara display korbo ta ekhane items variable e store kora holo.

    $per_page = 3;
    $current_page = $this->get_pagenum();
    $total_items = count($datas);
    $this->set_pagination_args(array(
      "total_items" => $total_items,
      "per_page"    => $per_page,

    ));

    $this->items = array_slice( $datas, ( ( $current_page - 1 ) * $per_page ), $per_page ); 
    /* 
      1st paramitter contain all values, 2nd are start section and 3rd are how many record we want to show. Sokol data ja amara display korbo ta ekhane items variable e store kora holo.
      ( ( $current_page - 1 ) * $per_page ) === details below
      1-1 = 0*3 => 0; so 1st page show 0,1 2 index data
      2-1 = 1*3 => 3; so 2ns page show 3,4,5 index data
      3-1 = 2*3 => 6; so 3ns page show 6,7,8 index data
    */

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
      'action'       => 'Action',
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
      case 'action':
        return "<a href='?page=" . $_GET['page'] . "&action=mmhs-edit&post_id=" . $item['id'] . " '>Edit</a> | <a href='?page=" . $_GET['page'] . "&action=mmhs-delete&post_id=" . $item['id'] . " '>Delete</a>" ;
      default:
        return 'No value found';
    }
  }

  /*
    Display action button like edit or delete etc.
    ai function er nam column_**** jekhane **** = jai column er upor amra edit or delete button dekhate chai.
  */
  public function column_title( $item ) {
    // 1st method
    /* 
      $action = array(
        "edit"      => "<a href='?page=" . $_GET['page'] . "&action=mmhs-edit&post_id=" . $item['id'] . " '>Edit</a>",
        "delete"    => "<a href='?page=" . $_GET['page'] . "&action=mmhs-delete&post_id=" . $item['id'] . " '>Delete</a>",
      ); 
    */

    // 2nd method - recommented
    $action = array(
      "edit"      => sprintf( '<a href="?page=%s&action=%s&post_id=%s">Edit</a>', $_GET['page'], 'mmhs-edit', $item['id'] ),
      "delete"    => sprintf( '<a href="?page=%s&action=%s&post_id=%s">Delete</a>', $_GET['page'], 'mmhs-delete', $item['id'] )
    );

    return sprintf( '%1$s %2$s', $item['title'], $this->row_actions( $action ) );
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