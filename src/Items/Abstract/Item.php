<?php
namespace ParadigmaTools\Gfv\Items\Abstract;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

abstract class Item{

	public function __construct(private \WP_Post $post) {
		
	}
	public function get_origin_src(): string{
		return $this->post->guid;
	}
	abstract function get_icon_src() : string;
	abstract public function get_type(): string;
	public function get_title() {
		return $this->post->post_title;
	}
	public function get_id() : int {
		return $this->post->ID;
	}

}

