<h3>Post Data</h3>
<?php
  $post_details = get_post($post_id);

  global $wpdb;
  // Update Post
  $wpdb->update( $wpdb->posts, array(
    "post_title" => "",
    "post_excerpt" => "",
    "post_name" => "",
  ), array(
    "id" => $post_id
  ));
?>
<form action="" method="post" name="frm_post_data">
  <p>
    <label for="mmhs_edit_title">Title</label>
    <input type="text" name="txt_name" value="<?php echo $post_details->post_title; ?>" />
  </p>
  <p>
    <label for="mmhs_edit_content">Post Excerpt</label>
    <textarea name="txt_content" id="mmhs_edit_content"><?php echo $post_details->post_excerpt; ?></textarea>
  </p>
  <p>
    <label for="mmhs_edit_post_slug">Post Slug</label>
    <input type="text" name="txt_slug" value="<?php echo $post_details->post_name; ?>" />
  </p>
  <p>
    <button type="submit" name="btnsubmit"> Submit Details</button>
  </p>
</form>