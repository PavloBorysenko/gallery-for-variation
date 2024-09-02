<?php
/*
	Plugin Name: Gallery for variations
	Plugin URI: https://#
	Description: Gallery for variations
	Author: Pablo
	Version: 1.0.0
	Requires at least: WP 6.0.0
	Tested up to: WP 6.6
	Requires PHP: 8.1
	Text Domain: gallery-for-variation
	Domain Path: /languages
	WC requires at least: 8.0
	WC tested up to: 9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require 'vendor/autoload.php';

define( 'GFV_LINK', plugin_dir_url( __FILE__ ) );
define( 'GFV_TEMPLATE_PATH', plugin_dir_path( __FILE__ ) . 'views' );
define( 'GFV_GALLERY_SLUG', 'gfv_gallery_items' );

add_action( 'init', 'gfv_init_plugin' );

function gfv_init_plugin(): void {
	new \ParadigmaTools\Gfv\Admin\Form( GFV_TEMPLATE_PATH, GFV_GALLERY_SLUG );
}

//Docs
//new \ParadigmaTools\Gfv\Data\GalleryStorage('galerry_meta_field_key')
//to get gallery by  variation  id \ParadigmaTools\Gfv\Data\GalleryStorage::get_items_by_id($variation_id)
//to get  all galleries by  parent  id \ParadigmaTools\Gfv\Data\GalleryStorage::get_items_by_parent_id($parent_id)

// new \ParadigmaTools\Gfv\Items\GalleryFabrica()
//to get gallery item  by  media  id \ParadigmaTools\Gfv\Items\GalleryFabrica::get_item_by_id($media_id)
//to get all gallery items by array of  media  ids \ParadigmaTools\Gfv\Items\GalleryFabrica::get_items_by_ids($media_ids)

//to get real  link to  source of  gallery item ParadigmaTools\Gfv\Items\Abstract\Item::get_origin_src()
//to get type [video|image] of  gallery item ParadigmaTools\Gfv\Items\Abstract\Item::get_type()
//to get title of  gallery item ParadigmaTools\Gfv\Items\Abstract\Item::get_title()