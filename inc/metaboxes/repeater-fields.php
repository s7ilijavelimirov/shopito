<?php 

/* 
   EXAMPLE OF  REGISTER META BOX WITH REPEATER FIELDS
*/

function s7design_meta_boxes_add_meta_box() {
	add_meta_box(
		's7design_meta_boxes-s7design-meta-boxes',
		__( 'Repeater Custom Fields', 's7design_meta_boxes' ),
		's7design_meta_boxes_html',
		'post',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 's7design_meta_boxes_add_meta_box' );

function s7design_meta_boxes_html( $post) {
	wp_nonce_field( '_s7design_meta_boxes_nonce', 's7design_meta_boxes_nonce' ); ?>

	<?php  
	
	$users =  s7_get_serialized_fields('s7design_meta_users');

	// Settings that we'll pass to wp_editor
	$args = array (
		  'tinymce' => false,
		  'quicktags' => true,
	);

	?>
		<div class="form-apend">
	<?php 
	if(is_array($users) && count($users) !== 0)  {
		foreach($users as $key => $user) {
			?>
			<div class="s7design-item-fields">
                <p>
                    <label for="s7design_meta_boxes_add_name"><?php _e( 'Add Name', 's7design_meta_boxes' ); ?></label><br>
                    <input style="min-width:300px; margin-right:10px;" type="text" name="s7design_meta_users[<?php echo $key; ?>][name]" value="<?php echo $users[$key]['name']; ?>">
                </p>
                    <p>
                    <label for="s7design_meta_boxes_add_description"><?php _e( 'Add Description', 's7design_meta_boxes' ); ?></label><br>
                    <?php // wp_editor( $user[$key]['description'], "s7design_meta_users[]['description']", $args ); ?>
					<textarea  name="s7design_meta_users[<?php echo $key; ?>][description]" ><?php echo $user['description']; ?> </textarea>
                </p>
            
                <span onclick="removeItem(this)" data-remove="<?php echo  $key; ?>" style="padding:6px 9px; border:1px solid #ccc; height:20px; margin-left:6px; margin-top:32px;" >X</span>
			</div>
		<?php
		}
		}  else {
			?> 
			<div class="s7design-item-fields">
			<p>
				<label for="s7design_meta_boxes_add_name"><?php _e( 'Add Name', 's7design_meta_boxes' ); ?></label><br>
				<input type="text" name="s7design_meta_users[0][name]"  value="">
			</p>	<p>
				<label for="s7design_meta_boxes_add_description"><?php _e( 'Add Description', 's7design_meta_boxes' ); ?></label><br>
				
				<textarea   name="s7design_meta_users[0][description]" > </textarea >
			</p>
            <span class="remove-item" onclick="removeItem(this)" style="padding:6px 9px; border:1px solid #ccc; height:20px; margin-left:6px; margin-top:26px;" >X</span>
			</div>
			<?php
			
	}
	?>
	</div>
	
	 <button id="append-fields">Add new</button>

	 <script>
		
	  jQuery('#append-fields').click(function(e) {
		  e.preventDefault()
		//window.send_to_editor = function(html) {
			const resForm = jQuery('.form-apend');
			const itemFields = document.querySelectorAll('.s7design-item-fields');
			console.log(itemFields.length);

			let nextfield =  itemFields.length;
			const res = jQuery('.empty-name-form').css({display:'block'});
			resForm.append(`	
			<div class="s7design-item-fields">
			<p>
		  <label for="s7design_meta_boxes_add_name"><?php _e( 'Add Name', 's7design_meta_boxes' ); ?></label><br>
		  <input type="text" name="s7design_meta_users[${nextfield}][name]"  value="">
        </p>
      	<p>
		  <label for="s7design_meta_boxes_add_description"><?php _e( 'Add Description', 's7design_meta_boxes' ); ?></label><br>
		  <textarea name="s7design_meta_users[${nextfield}][description]" > </textarea >
	     </p>
	  
	 
	  <span class="remove-item" onclick="removeItem(this)" style="padding:6px 9px; border:1px solid #ccc; height:20px; margin-left:6px; margin-top:26px;" >X</span>
		
		</div> 
	  `);

	  }); // End on click
	 
	  function removeItem(e) {
		  e.parentNode.remove();
	  }
	
	 </script>
	<?php
	
}

function s7design_meta_boxes_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['s7design_meta_boxes_nonce'] ) || ! wp_verify_nonce( $_POST['s7design_meta_boxes_nonce'], '_s7design_meta_boxes_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
   

	$users = serialize($_POST['s7design_meta_users'] );

	update_post_meta( $post_id, 's7design_meta_users',  $users  );

}
add_action( 'save_post', 's7design_meta_boxes_save' );