<?php
/**
 * Rendering a gallery form in a variable product.
 *
 * @class   Form
 * @package ParadigmaTools\Gfv
 */

namespace ParadigmaTools\Gfv\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Form
 */
class Form {

	/**
	 * Creating gallery objects.
	 *
	 * @var \ParadigmaTools\Gfv\Items\GalleryFabrica
	 */
	private \ParadigmaTools\Gfv\Items\GalleryFabrica $gallery_fabrica;
	/**
	 * Update, Delete, Get, Save Gallery Item ids.
	 *
	 * @var \ParadigmaTools\Gfv\Data\GalleryStorage
	 */
	private \ParadigmaTools\Gfv\Data\GalleryStorage $gallery_storage;

	/**
	 * __construct
	 *
	 * @param  string $views_path   Path to form templates.
	 * @param  string $slug  Meta  data  key.
	 * @return void
	 */
	public function __construct( private string $views_path, private string $slug ) {
		$this->gallery_fabrica = new \ParadigmaTools\Gfv\Items\GalleryFabrica();
		$this->gallery_storage = new \ParadigmaTools\Gfv\Data\GalleryStorage( $this->slug );

		add_action( 'woocommerce_product_after_variable_attributes', array( $this, 'draw_gallery_form' ), 10, 3 );
		add_action( 'woocommerce_variable_product_before_variations', array( $this, 'draw_gallery_template' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_script' ) );
	}

	/**
	 * Connecting styles and js.
	 *
	 * @return void
	 */
	public function enqueue_script(): void {

		wp_enqueue_style( 'gfv-admin-css', GFV_LINK . '/assets/admin/css/variation.css' );// @phpstan-ignore constant.notFound (difined in another file)
		wp_enqueue_script(
			'gfv-admin',
			GFV_LINK . '/assets/admin/js/variation.js', // @phpstan-ignore constant.notFound (difined in another file)
			array(
				'jquery',
				'jquery-ui-sortable',
				'wp-util',
			)
		);
		wp_localize_script(
			'gfv-admin',
			'gfv_localize',
			array(
				'title' => esc_html__( 'Add images', 'gallery-for-variation' ),
				'btn' => esc_html__( 'Save', 'gallery-for-variation' ),
			)
		);
	}

	/**
	 * Drawing the form.
	 *
	 * @param  int                  $loop variant number.
	 * @param  array<string, string>                $variation_data data.
	 * @param  \WC_Product_Variation $variation  Variation object.
	 * @return void
	 */
	public function draw_gallery_form( $loop, $variation_data, $variation ): void { // @phpstan-ignore class.notFound (woocommerce)
		$variation_id = (int) $variation->ID; // @phpstan-ignore class.notFound (woocommerce)

		$gallery_items = $this->get_gallery_items( $variation_id );

		include $this->views_path . '/gallery_form.php';
	}

	/**
	 * Rendering a gallery item.
	 *
	 * @param  \ParadigmaTools\Gfv\Items\Abstract\Item $item  Gallery item obj.
	 * @param  int                                     $variation_id  ID.
	 * @return void
	 */
	public function draw_gallery_item( \ParadigmaTools\Gfv\Items\Abstract\Item $item, int $variation_id ): void {
		$data = $this->get_gallery_item_data( $item, $variation_id );
		$this->print_item( $data );
	}

	/**
	 * Rendering a gallery item templete to use it in JS.
	 *
	 * @return void
	 */
	public function draw_gallery_template(): void {
		$data = $this->get_gallery_item_data();
		include $this->views_path . '/gallery_item_template.php';
	}

	/**
	 * Rendering image or video item.
	 *
	 * @param  array<string, int|string> $data  Contains link, title, type, file ID.
	 * @return void
	 */
	public function print_item( array $data ): void {
		include $this->views_path . '/gallery_item.php';
	}

	/**
	 * Get all gallery items by product ID as an array of objects.
	 *
	 * @param  int $variation_id  ID.
	 * @return array<int, \ParadigmaTools\Gfv\Items\Abstract\Item>
	 */
	public function get_gallery_items( int $variation_id ): array {
		$gallery_items = array();

		$gallery_ids = $this->gallery_storage->get_items_by_id( $variation_id );
		if ( $gallery_ids ) {
			$gallery_items = $this->gallery_fabrica->get_items_by_ids( $gallery_ids );
		}

		return $gallery_items;
	}

	/**
	 * Preparing data for rendering a gallery element.
	 *
	 * @param  null|\ParadigmaTools\Gfv\Items\Abstract\Item $item  File object (gallery element).
	 * @param  int                                          $variation_id  ID.
	 * @return array<string, int|string>
	 */
	public function get_gallery_item_data( null|\ParadigmaTools\Gfv\Items\Abstract\Item $item = null, int $variation_id = 0 ): array {
		$data = array(
			'title' => '__TITLE__',
			'id' => '__ITEM_ID__',
			'type' => '__TYPE__',
			'src' => '__SRC__',
			'variation_id' => '__PRODUCT_ID__',
		);

		if ( $item ) {
			$data = array(
				'title' => $item->get_title(),
				'id' => $item->get_id(),
				'type' => $item->get_type(),
				'src' => $item->get_icon_src(),
			);
		}

		if ( $variation_id ) {
			$data['variation_id'] = $variation_id;
		}

		return $data;
	}
}
