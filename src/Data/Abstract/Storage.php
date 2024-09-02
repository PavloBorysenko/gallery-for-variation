<?php
/**
 * Saving, deleting, retrieving data.
 *
 * @class   Storage
 * @package ParadigmaTools\Gfv
 */

namespace ParadigmaTools\Gfv\Data\Abstract;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Storage
 */
interface Storage {
	/**
	 * Summary of save
	 *
	 * @param int   $id post ID
	 * @param array<int> $items data
	 * @return void
	 */
	public function save( int $id, array $items ): void;

	/**
	 * Summary of get_items_by_id
	 *
	 * @param int $id post ID
	 * @return array<int>|null
	 */
	public function get_items_by_id( int $id ): array|null;

	/**
	 * Summary of get_items_by_parent_id
	 *
	 * @param int $id post ID
	 * @return array<int, array<int>>|null
	 */
	public function get_items_by_parent_id( int $id ): array|null;

	/**
	 * Summary of delete
	 *
	 * @param int $id post ID
	 * @return void
	 */
	public function delete( int $id ): void;
}
