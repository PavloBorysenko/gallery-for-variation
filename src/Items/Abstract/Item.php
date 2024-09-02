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
	 *
	 * @param \WP_Post $post  attachment obj.
	 */
	public function __construct( private \WP_Post $post ) {
	}

	/**
	 * Original url.
	 *
	 * @return string
	 */
	public function get_origin_src(): string {
		return $this->post->guid;
	}

	/**
	 * Thumbnail.
	 *
	 * @return string
	 */
	abstract public function get_icon_src(): string;

	/**
	 * Summary of get_type.
	 *
	 * @return string
	 */
	abstract public function get_type(): string;

	/**
	 * Summary of get_title.
	 *
	 * @return string
	 */
	public function get_title(): string {
		return $this->post->post_title;
	}
	/**
	 * Summary of get_id
	 *
	 * @return int
	 */
	public function get_id(): int {
		return $this->post->ID;
	}
}
