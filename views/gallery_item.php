<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
	<li class="gfv_item gfv_item_<?php echo esc_attr($data['variation_id']) ?>  gfv_item_<?php echo esc_attr($data['type']) ?>">
		<input class="gfv_item_input" 
			   type="hidden" 
			   name="<?php echo esc_attr($this->slug); ?>[<?php echo esc_attr($data['variation_id']) ?>][]"
			   value="<?php echo esc_attr($data['id']) ?>">
		
		<img alt="<?php echo esc_html($data['title']) ?>" 
			 data-id="<?php echo esc_attr($data['id']) ?>" 
			 src="<?php echo esc_attr($data['src']) ?>">
		<span class="gfv_item_title"><?php echo esc_html($data['title']) ?></span>
		<span  class="gfv_delete_item">
			<span class="dashicons dashicons-dismiss"></span>
		</span>
	</li>

