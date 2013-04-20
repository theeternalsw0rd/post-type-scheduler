<?php
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	if(!wp_verify_nonce($_POST['post_schedule_noncename'], 'post-schedule-metabox')) return $post_id;
	if(!current_user_can('edit_'.$_POST['post_type'], $post_id)) return $post_id;
	// underscore at beginning of name hides it from custom fields
	$new_data = array_key_exists('_post_schedule', $_POST) ? $_POST['_post_schedule'] : "";
	delete_post_meta($post_id, '_post_schedule');
	if(!empty($new_data)) {
		update_post_meta($post_id, '_post_schedule', $new_data, TRUE);
	}
	return $post_id;
?>
