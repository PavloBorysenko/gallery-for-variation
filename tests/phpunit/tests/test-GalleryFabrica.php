<?php

class Test_GalleryFabrica extends WP_UnitTestCase {
	public $gallery_fabrica;

	public static $attachment_ids;
	public function setUp(): void {
		parent::setUp();
		$this->gallery_fabrica = new \ParadigmaTools\Gfv\Items\GalleryFabrica();
	}
	public static function wpSetUpBeforeClass( $factory ) {
		self::$attachment_ids[] = $factory->attachment->create_upload_object( GFV_TEST_PATH . '/files/wp-logo.png', 0 );
		self::$attachment_ids[] = $factory->attachment->create_upload_object( GFV_TEST_PATH . '/files/wp-logo.jpg', 0 );
		self::$attachment_ids[] = $factory->attachment->create_upload_object( GFV_TEST_PATH . '/files/clip.mp4', 0 );
	}
	public function tearDown(): void {
		parent::tearDown();
	}
	public function test_create_item_by_nonexistent_id() {
		$actual_data = $this->gallery_fabrica->get_item_by_id( -333 );
		$this->assertNull( $actual_data );
	}

	/**
	 * @dataProvider gallery_item_provider
	 */
	public function test_create_item( $index, $expected_class ) {
		$actual_obj = $this->gallery_fabrica->get_item_by_id( self::$attachment_ids[ $index ] );
		$this->assertInstanceOf( $expected_class, $actual_obj );
	}
	public function test_get_items_by_ids() {
		$ids = array_merge( self::$attachment_ids, array( -11, -111, -1111 ) );
		$actual_objs = $this->gallery_fabrica->get_items_by_ids( $ids );
		$this->assertCount( count( self::$attachment_ids ), $actual_objs );
	}
	public function gallery_item_provider(): array {

		return array(
			array( 0, 'ParadigmaTools\Gfv\Items\Item\GalleryImage' ),
			array( 1, 'ParadigmaTools\Gfv\Items\Item\GalleryImage' ),
			array( 2, 'ParadigmaTools\Gfv\Items\Item\GalleryVideo' ),
		);
	}
}