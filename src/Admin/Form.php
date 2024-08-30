<?php
namespace ParadigmaTools\Gfv\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Form {

	private \ParadigmaTools\Gfv\Items\GalleryFabrica $gallery_fabrica;
	private \ParadigmaTools\Gfv\Data\GalleryStorage $gallery_storage;

	public function __construct( private string $views_path, private string $slug ) {
		$this->gallery_fabrica = new \ParadigmaTools\Gfv\Items\GalleryFabrica();
		$this->gallery_storage = new \ParadigmaTools\Gfv\Data\GalleryStorage( $this->slug );

		add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'draw_gallery_form' ), 10, 3 );
		add_action( 'woocommerce_variable_product_before_variations', array( $this, 'draw_gallery_template' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );

	}
	public function enqueue_script(): void {
		wp_enqueue_style( 'gfv-admin-css', GFV_LINK . '/assets/admin/css/variation.css' );
		wp_enqueue_script( 'gfv-admin', GFV_LINK . '/assets/admin/js/variation.js', array(
			'jquery',
			'jquery-ui-sortable',
			'wp-util'
		) );
		wp_localize_script( 'gfv-admin', 'gfv_localize', array(
			'title' => esc_html__( 'Add images', 'gallery-for-variation' ),
			'btn' => esc_html__( 'Save', 'gallery-for-variation' ),
		) );
	}

	public function draw_gallery_form( $loop, $variation_data, $variation ): void {
		$variation_id = (int) $variation->ID;

		$gallery_items = $this->get_gallery_items( $variation_id );

		include $this->views_path . '/gallery_form.php';

	}

	public function draw_gallery_item( \ParadigmaTools\Gfv\Items\Abstract\Item $item, int $variation_id ): void {
		$data = $this->get_gallery_item_data( $item, $variation_id );
		$this->print_item( $data );
	}
	public function draw_gallery_template(): void {
		$data = $this->get_gallery_item_data();
		include $this->views_path . '/gallery_item_template.php';
	}

	public function print_item( array $data ): void {
		include $this->views_path . '/gallery_item.php';
	}

	public function get_gallery_items( int $variation_id ): array {
		$gallery_items = array();

		if ( $gallery_ids = $this->gallery_storage->get_items_by_id( $variation_id ) ) {
			$gallery_items = $this->gallery_fabrica->get_items_by_ids( $gallery_ids );
		}

		return $gallery_items;
	}
	public function get_gallery_item_data( null|\ParadigmaTools\Gfv\Items\Abstract\Item $item = null, int $variation_id = 0 ): array {
		$data = array(
			'title' => '__TITLE__',
			'id' => '__ITEM_ID__',
			'type' => '__TYPE__',
			'src' => '__SRC__',
			'variation_id' => '__PRODUCT_ID__'
		);

		if ( $item ) {
			$data = array(
				'title' => $item->get_title(),
				'id' => $item->get_id(),
				'type' => $item->get_type(),
				'src' => $item->get_icon_src()
			);
		}

		if ( $variation_id ) {
			$data['variation_id'] = $variation_id;
		}

		return $data;
	}

}
