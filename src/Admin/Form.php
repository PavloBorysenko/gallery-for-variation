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
		$this->gallery_storage = new \ParadigmaTools\Gfv\Data\GalleryStorage($this->slug);
		
		add_action( 'woocommerce_product_after_variable_attributes' , array($this, 'draw_gallery_form'), 10, 3);
		add_action( 'woocommerce_variable_product_before_variations', array($this, 'draw_gallery_template'));
		wp_enqueue_style('gfv-admin-css', GFV_LINK . '/assets/admin/css/variation.css');
		wp_enqueue_script( 'gfv-admin', GFV_LINK . '/assets/admin/js/variation.js', array(
				'jquery',
				'jquery-ui-sortable',
				'wp-util'
			));
		wp_localize_script('gfv-admin', 'gfv_localize', array(
			'title' => __('Add images', 'gallery-for-variation'),
			'btn' => __('Save', 'gallery-for-variation'),
		));
	}
	
	public function draw_gallery_form($loop, $variation_data, $variation) {
		$variation_id = (int) $variation->ID;
		if ($gallery_ids = $this->gallery_storage->get_items_by_id($variation_id) ){
			$gallery_items = $this->gallery_fabrica->get_items_by_ids($gallery_ids);
		} else {
			$gallery_items = array();
		}
		
		include $this->views_path . '/gallery_form.php';
		
	}
	
	public function draw_gallery_item(\ParadigmaTools\Gfv\Items\Abstract\Item $item, int $variation_id) : void {
		
		$data['title'] = $item->get_title();
		$data['id'] = $item->get_id();
		$data['type'] = $item->get_type();
		$data['src'] = $item->get_icon_src();
		$data['variation_id'] = $variation_id;
		
		$this->print_item($data); 
	}
	
	public function print_item(array $data) : void {
		include $this->views_path . '/gallery_item.php';
	}


	public function draw_gallery_template() : void {
		$data['title'] = '__TITLE__';
		$data['id'] = '__ITEM_ID__';
		$data['type'] = '__TYPE__';
		$data['src'] = '__SRC__';
		$data['variation_id'] = '__PRODUCT_ID__';
		include $this->views_path . '/gallery_item_template.php';
	}
}
