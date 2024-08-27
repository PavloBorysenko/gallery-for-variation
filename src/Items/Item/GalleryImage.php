<?php
namespace ParadigmaTools\Gfv\Items\Item;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class GalleryImage extends \ParadigmaTools\Gfv\Items\Abstract\Item{
	
	public function get_type(): string {
		return 'image';
	}
	public function get_icon_src(): string {
		 $img_data = wp_get_attachment_image_src($this->get_id());
		 return $img_data[0];
	}	

}
	

