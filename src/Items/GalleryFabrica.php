<?php
namespace ParadigmaTools\Gfv\Items;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class GalleryFabrica {

	public function get_item_by_id( int $id ): \ParadigmaTools\Gfv\Items\Abstract\Item|null {

		return $this->create_item( $id );
	}

	public function get_items_by_ids( array $ids ): array {

		$gallery_items = array();
		foreach ( $ids as $id ) {
			if ( $item = $this->create_item( $id ) ) {
				$gallery_items[ $id ] = $item;
			}
		}

		return $gallery_items;
	}

	private function create_item( int $id ): \ParadigmaTools\Gfv\Items\Abstract\Item|null {
		if ( ! $post = get_post( $id ) ) {
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
