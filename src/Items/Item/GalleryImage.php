<?php
/**
 * Class for image type gallery element.
 *
 * @class   GalleryImage
 * @package ParadigmaTools\Gfv
 */

namespace ParadigmaTools\Gfv\Items\Item;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * GalleryImage
 */
class GalleryImage extends \ParadigmaTools\Gfv\Items\Abstract\Item {


	/**
	 * Gallery Item Type.
	 *
	 * @return string
	 */
	public function get_type(): string {
		return 'image';
	}

	/**
	 * Link to get thumbnail.
	 *
	 * @return string
	 */
	public function get_icon_src(): string {
		$img_data = wp_get_attachment_image_src( $this->get_id() );
		return $img_data[0];
	}
}
