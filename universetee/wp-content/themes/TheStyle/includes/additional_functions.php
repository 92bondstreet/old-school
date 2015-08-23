<?php 

/* Meta boxes */

function admin_init(){
	add_meta_box("et_post_meta", "ET Settings", "et_post_meta", "post", "normal", "high");
}
add_action("admin_init", "admin_init");

function et_post_meta($callback_args) {
	global $post;

	$custom = get_post_custom($post->ID);
	
	$et_bigpost = isset($custom["et_bigpost"][0]) ? (bool) $custom["et_bigpost"][0] : (bool) $custom["et_bigpost"][0]; ?>
	
	<div style="margin: 13px 0 11px 4px;">
		<label class="selectit" for="et_bigpost">
			<input type="checkbox" name="et_bigpost" id="et_bigpost" value=""<?php checked( $et_bigpost ); ?> /> Big Post</label><br/>
	</div>

	<?php
}

function save_details($post_id){
	global $post;
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;
		
	if (isset($_POST["et_bigpost"])) update_post_meta($post->ID, "et_bigpost", 1);
	else update_post_meta($post->ID, "et_bigpost", 0);	
}
add_action('save_post', 'save_details'); ?>