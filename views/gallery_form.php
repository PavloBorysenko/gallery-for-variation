<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
	<div data-product_variation_id="<?php echo esc_attr( $variation_id ) ?>" class="form-row form-row-full">
		<div class="gfv-form">
			<div class="gfv-header postbox-header">
				<h2><?php esc_html_e( 'Gallery for variation', 'woo-variation-gallery' ) ?></h2>
			</div>

			<div class="gfv-wrapper">
				<div class="gfv-container">
					<ul class="gfv-items-list  gfv-items-list-<?php echo esc_attr($variation_id ) ?>">
						
						<?php
							foreach ($gallery_items as $item){
								$this->draw_gallery_item($item, $variation_id);
							}
						
						?>
					</ul>
				</div>
				<div class="gfv-add-items-wrapper">
					<a href="#"
						data-loop="<?php echo absint( $loop ) ?>"
						data-id="<?php echo esc_attr( $variation_id ) ?>"
						class="button-primary gfv-add-items"><?php esc_html_e( 'Add Variation Gallery Image', 'gallery-for-variation' ) ?></a>
				</div>
			</div>
		</div>
	</div>

