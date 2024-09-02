<?php
/**
 * Creating Gallery Item Objects.
 *
 * @class   GalleryFabrica
 * @package ParadigmaTools\Gfv
 */

namespace ParadigmaTools\Gfv\Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * GalleryFabrica
 */
class GalleryFabrica {

	/**
	 * Public method for creating an object by attachment ID
	 *
	 * @param int $id attachment ID.
	 * @return \ParadigmaTools\Gfv\Items\Abstract\Item|null
	 */
	public function get_item_by_id( int $id ): \ParadigmaTools\Gfv\Items\Abstract\Item|null {

		return $this->create_item( $id );
	}

	/**
	 * Public method for creating  array of objects by array of attachment IDs.
	 *
	 * @param array<int> $ids attachment IDs.
	 * @return array<int, \ParadigmaTools\Gfv\Items\Abstract\Item>
	 */
	public function get_items_by_ids( array $ids ): array {

		$gallery_items = array();
		foreach ( $ids as $id ) {
			$item = $this->create_item( $id );
			if ( $item ) {
				$gallery_items[ $id ] = $item;
			}
		}

		return $gallery_items;
	}

	/**
	 * Checking the attachment type and creating the corresponding object.
	 *
	 * @param int $id attachment ID.
	 * @return \ParadigmaTools\Gfv\Items\Abstract\Item|null
	 */
	private function create_item( int $id ): \ParadigmaTools\Gfv\Items\Abstract\Item|null {
		$post = get_post( $id );
		if ( ! $post ) {
			return null;
		}
		$type = get_post_mime_type( $post );

		if ( str_starts_with( $type, 'image/' ) ) {
			return new \ParadigmaTools\Gfv\Items\Item\GalleryImage( $post );
		} elseif ( str_starts_with( $type, 'video/' ) ) {
			return new \ParadigmaTools\Gfv\Items\Item\GalleryVideo( $post );
		}

		return null;
	}
}
