<?php 
/**
 * Upload Media 
 *
 * @package s7design
 */

add_action(
	'add_meta_boxes',
	function(){
	  add_meta_box(
		's7design-metaboxx1', // ID
		'Upload Image test - 1', // Title
		's7_metabox_upload_image', // Callback (Construct function)
		get_post_types(), //screen (This adds metabox to all post types)
		'normal' // Context
	  );
   },
   9
  );
  function s7_metabox_upload_image($post){
	$url = get_post_meta($post->ID, 'my-image-for-post', true); ?>
	<input id="my_image_URL" name="my_image_URL" type="text"
		   value="<?php echo $url;?>" style="width:400px;" />
	<input id="my_upl_button" type="button" value="Upload Image" /><br/>
	<img src="<?php echo $url;?>" style="width:200px;" id="picsrc" />
	<script>
	jQuery(document).ready( function($) {
	  jQuery('#my_upl_button').click(function() {
		window.send_to_editor = function(html) {
		  imgurl = jQuery(html).attr('src')
		  jQuery('#my_image_URL').val(imgurl);
		  jQuery('#picsrc').attr("src", imgurl);
		  tb_remove();
		}
  
		formfield = jQuery('#my_image_URL').attr('name');
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true' );
		return false;
	  }); // End on click
	});
	</script>
  <?php
  }
  
  add_action('save_post', function ($post_id) {
	if (isset($_POST['my_image_URL'])){
	  update_post_meta($post_id, 'my-image-for-post', $_POST['my_image_URL']);
	}
  }); 
