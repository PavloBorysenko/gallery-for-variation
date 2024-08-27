<?php
namespace ParadigmaTools\Gfv\Items\Item;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class GalleryVideo extends \ParadigmaTools\Gfv\Items\Abstract\Item{
	
	public function get_type(): string {
		return 'video';
	}
	public function get_icon_src(): string {
		return wp_mime_type_icon($this->get_id());
	}
}
	
