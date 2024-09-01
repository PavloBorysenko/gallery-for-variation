<?php

class Test_GalleryImage extends WP_UnitTestCase {
	public $gallery_image;

	public static $attachment_ids;
	public function setUp(): void {
		parent::setUp();
	}
	public static function wpSetUpBeforeClass( $factory ) {
		self::$attachment_ids[] = $factory->attachment->create_upload_object( GFV_TEST_PATH . '/files/wp-logo.png', 0 );
		self::$attachment_ids[] = $factory->attachment->create_upload_object( GFV_TEST_PATH . '/files/wp-logo.jpg', 0 );
	}
	public static function wpTearDownAfterClass() {
		foreach ( self::$attachment_ids as $id ) {
			wp_delete_attachment( $id );
		}

	}

	public function tearDown(): void {
		parent::tearDown();
	}
	/**
	 * @dataProvider index_data_provider
	 */
	public function test_get_origin_src( $index ) {
		$expected_src = wp_get_attachment_image_url( self::$attachment_ids[ $index ] );
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$gallery_image = new \ParadigmaTools\Gfv\Items\Item\GalleryImage( $post );

		$this->assertSame( $expected_src, $gallery_image->get_origin_src(),
			"Expected URL of original image." );

	}
	/**
	 * @dataProvider index_data_provider
	 */
	public function test_get_icon_src( $index ) {
		$expected_src = wp_get_attachment_image_url( self::$attachment_ids[ $index ], 'thumbnail' );
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$gallery_image = new \ParadigmaTools\Gfv\Items\Item\GalleryImage( $post );

		$this->assertSame( $expected_src, $gallery_image->get_icon_src(),
			"Expected image thumbnail URL." );
	}
	/**
	 * @dataProvider index_data_provider
	 */
	public function test_get_title( $index ) {
		$expected_title = get_the_title( self::$attachment_ids[ $index ] );
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$gallery_image = new \ParadigmaTools\Gfv\Items\Item\GalleryImage( $post );

		$this->assertSame( $expected_title, $gallery_image->get_title(),
			"Incorrect image title." );
	}
	/**
	 * @dataProvider index_data_provider
	 */
	public function test_get_id( $index ) {
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$gallery_image = new \ParadigmaTools\Gfv\Items\Item\GalleryImage( $post );

		$this->assertSame( self::$attachment_ids[ $index ], $gallery_image->get_id(),
			"Incorrect attachment ID." );
	}
	/**
	 * @dataProvider index_data_provider
	 */
	public function test_get_type( $index ) {
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$gallery_image = new \ParadigmaTools\Gfv\Items\Item\GalleryImage( $post );

		$this->assertSame( 'image', $gallery_image->get_type(),
			"Gallery item type must be image" );
	}
	public function index_data_provider(): array {
		return array(
			'png' => array( 0 ),
			'jpg' => array( 1 ),
		);
	}
}