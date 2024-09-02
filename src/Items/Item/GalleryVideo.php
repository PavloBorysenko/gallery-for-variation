<?php
/**
 * Class for Video type gallery element.
 *
 * @class   GalleryVideo
 * @package ParadigmaTools\Gfv
 */

namespace ParadigmaTools\Gfv\Items\Item;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * GalleryVideo
 */
class GalleryVideo extends \ParadigmaTools\Gfv\Items\Abstract\Item {

	/**
	 * Gallery Item Type.
	 *
	 * @return string
	 */
	public function get_type(): string {
		return 'video';
	}

	/**
	 * Link to get thumbnail.
	 *
	 * @return string
	 */
	public function get_icon_src(): string {
		return wp_mime_type_icon( $this->get_id() );
	}
}
