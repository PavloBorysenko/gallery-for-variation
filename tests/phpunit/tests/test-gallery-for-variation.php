<?php

class Test_Gallery_For_Variation extends WP_UnitTestCase {

	public function test_constants() {
		$this->assertSame( 'gfv_gallery_items-', GFV_GALLERY_SLUG );

		$url = str_replace( 'tests/phpunit/tests/', '',
			trailingslashit( plugin_dir_url( __FILE__ ) ) );
		$this->assertSame( $url, GFV_LINK );
	}
}