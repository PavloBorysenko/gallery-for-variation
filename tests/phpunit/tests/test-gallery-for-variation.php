<?php

class Test_Gallery_For_Variation extends WP_UnitTestCase {

	public function test_include_class() {
		$included_files = get_included_files();
		$form_class_path = str_replace( DIRECTORY_SEPARATOR .
			'tests' . DIRECTORY_SEPARATOR .
			'phpunit' . DIRECTORY_SEPARATOR .
			'tests/', '',
			plugin_dir_path( __FILE__ ) . DIRECTORY_SEPARATOR .
			'src' . DIRECTORY_SEPARATOR .
			'Admin' . DIRECTORY_SEPARATOR .
			'Form.php' );

		$this->assertContains( $form_class_path, $included_files );
	}
	public function test_init_action() {
		$this->assertTrue(
			has_action( 'init', 'gfv_init_plugin' ) == true );
	}
	public function test_slug_constant() {
		$this->assertSame( 'gfv_gallery_items', GFV_GALLERY_SLUG );

	}
	public function test_url_constant() {
		$url = str_replace( 'tests/phpunit/tests/', '',
			trailingslashit( plugin_dir_url( __FILE__ ) ) );
		$this->assertSame( $url, GFV_LINK );
	}

	public function test_path_views_constant() {
		$path = str_replace( DIRECTORY_SEPARATOR .
			'tests' . DIRECTORY_SEPARATOR .
			'phpunit' . DIRECTORY_SEPARATOR .
			'tests', '',
			plugin_dir_path( __FILE__ ) . "views" );
		$this->assertSame( $path, GFV_TEMPLATE_PATH );
	}
}