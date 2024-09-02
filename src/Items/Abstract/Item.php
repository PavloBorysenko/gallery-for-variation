<?php
/**
 * Common interface for all types of gallery items
 *
 * @class   Item
 * @package ParadigmaTools\Gfv
 */
namespace ParadigmaTools\Gfv\Items\Abstract;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Item
 */
abstract class Item {

	/**
	 * __construct  
	 * @param \WP_Post $post  attachment obj
	 */
	public function __construct( private \WP_Post $post ) {
	}

	/**
	 * original url.
	 * @return string
	 */
	public function get_origin_src(): string {
		return $this->post->guid;
	}

	/**
	 * thumbnail.
	 * @return string
	 */
	abstract public function get_icon_src(): string;
	abstract public function get_type(): string;
	public function get_title(): string {
		return $this->post->post_title;
	}
	/**
	 * Summary of get_id
	 * @return int
	 */
	public function get_id(): int {
		return $this->post->ID;
	}
}
