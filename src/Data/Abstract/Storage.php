<?php
namespace ParadigmaTools\Gfv\Data\Abstract;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

interface Storage{
	public function save(int $id, array $items): void;
	public function get_items_by_id( int $id): array|null;
	public function get_items_by_parent_id( int $id): array|null;
	public function delete(int $id): void;
}

