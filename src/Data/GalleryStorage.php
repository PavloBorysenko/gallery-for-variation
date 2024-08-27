<?php
namespace ParadigmaTools\Gfv\Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class GalleryStorage implements \ParadigmaTools\Gfv\Data\Abstract\Storage{
	
	public function __construct(private string $slug) {
		add_action( 'woocommerce_save_product_variation', array($this, 'update_data'), 10, 2);
	}
	
	public function update_data(int $id, int $loop) : void {
		
		if ( isset( $_POST[$this->slug] ) ) {

			if ( isset( $_POST[$this->slug][ $id ] ) ) {

				$items = array_map( 'absint', $_POST[$this->slug][ $id ] );			
				$this->save($id, $items);
			} else {
				$this->delete($id);
			}
		} else {
			$this->delete($id);
		}		
	}

	public function save(int $id, array $item): void{
		$items = array_map( 'absint', $item );
		update_post_meta( $id, $this->slug, $items );
		// update cache TODO
	}
	
	public function get_items_by_id(int $id): array|null {
		// check cache TODO
		$item = get_post_meta( $id, $this->slug , true );
		return is_array($item) && !empty($item)? $item : null;
	}
	
	public function get_items_by_parent_id(int $id): array|null {
		$product = wc_get_product( $id );
		// check cache TODO
		if ($product->is_type( 'variable' ) && $product->has_child() ) {
			$items = array();
			$variations = $product->get_available_variations();
			$variations_id = wp_list_pluck( $variations, 'variation_id' );	
			foreach ($variations_id as $variation_id) {
				if ($item = $this->get_items_by_id($variation_id)) {
					$items[$variation_id] = $item; 
				}
			}
			
			return !empty($items)?$items:null;
		}else {
			return null;
		}
	}
	
	public function delete (int $id): void{
		delete_post_meta( $id, $this->slug );
		// update cache TODO
	}
	
}

