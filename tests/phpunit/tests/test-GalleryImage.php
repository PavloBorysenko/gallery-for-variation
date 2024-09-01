<?php

class Test_GalleryImage extends WP_UnitTestCase {
	public $gallery_image;

	public static $attachment_ids;
	public function setUp(): void {
		parent::setUp();
		$this->gallery_image = new \ParadigmaTools\Gfv\Items\Item\GalleryImage();
	}
	public static function wpSetUpBeforeClass( $factory ) {
		self::$attachment_ids[] = $factory->attachment->create_upload_object( GFV_TEST_PATH . '/files/wp-logo.png', 0 );
		self::$attachment_ids[] = $factory->attachment->create_upload_object( GFV_TEST_PATH . '/files/wp-logo.jpg', 0 );
		self::$attachment_ids[] = $factory->attachment->create_upload_object( GFV_TEST_PATH . '/files/clip.mp4', 0 );
	}
	public function tearDown(): void {
		parent::tearDown();
	}
}