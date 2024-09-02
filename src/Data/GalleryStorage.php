<?php
/**
 * Saving, deleting, retrieving  ids of gallery item.
 *
 * @class   GalleryStorage
 * @package ParadigmaTools\Gfv
 */

namespace ParadigmaTools\Gfv\Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * GalleryStorage
 */
class GalleryStorage implements \ParadigmaTools\Gfv\Data\Abstract\Storage {


	/**
	 * __construct
	 * @param string $slug Meta key
	 */
	public function __construct( private string $slug ) {
		add_action( 'woocommerce_save_product_variation', array( $this, 'update_data' ), 10, 2 );
	}


	/**
	 * update_data
	 * @param int $id variation ID
	 * @param int $loop variation loop
	 * @return void
	 */
	public function update_data( int $id, int $loop ): void {

		if ( isset( $_POST[ $this->slug ] ) ) {

			if ( isset( $_POST[ $this->slug ][ $id ] ) ) {

				$items = array_map( 'absint', $_POST[ $this->slug ][ $id ] );
				$this->save( $id, $items );
			} else {
				$this->delete( $id );
			}
		} else {
			$this->delete( $id );
		}
	}

	/**
	 * Summary of save.
	 *
	 * @param int   $id  variation ID
	 * @param array<int> $items ids of images or videos
	 * @return void
	 */
	public function save( int $id, array $items ): void {
		$items = array_map( 'absint', $items );
		update_post_meta( $id, $this->slug, $items );
		// update cache TODO.
	}

	/**
	 * Summary of delete.
	 *
	 * @param int $id variation ID
	 * @return void
	 */
	public function delete( int $id ): void {
		delete_post_meta( $id, $this->slug );
		// update cache TODO.
	}

	/**
	 * Get gallery items by variation ID.
	 *
	 * @param int $id variation ID
	 * @return array<int>|null
	 */
	public function get_items_by_id( int $id ): array|null {
		// check cache TODO.
		$item = get_post_meta( $id, $this->slug, true );
		return is_array( $item ) && ! empty( $item ) ? $item : null;
	}

	/**
	 * Get  all gallery items by product ID.
	 *
	 * @param int $id product ID
	 * @return array<int, array<int>>|null
	 */
	public function get_items_by_parent_id( int $id ): array|null {
		$product = wc_get_product( $id ); // @phpstan-ignore function.notFound (woocommerce) 
		// check cache TODO.
		if ( $product->is_type( 'variable' ) && $product->has_child() ) {
			$items = array();
			$variations = $product->get_available_variations();
			$variations_id = wp_list_pluck( $variations, 'variation_id' );
			foreach ( $variations_id as $variation_id ) {
				if ( $item = $this->get_items_by_id( $variation_id ) ) {
					$items[ $variation_id ] = $item;
				}
			}

			return ! empty( $items ) ? $items : null;
		} else {
			return null;
		}
	}
}
