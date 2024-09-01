<?php

class Test_GalleryVideo extends WP_UnitTestCase {

	public static $attachment_ids;
	public function setUp(): void {
		parent::setUp();
	}
	public static function wpSetUpBeforeClass( $factory ) {
		self::$attachment_ids[] = $factory->attachment->create_upload_object( GFV_TEST_PATH . '/files/clip.mp4', 0 );
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
		$expected_src = wp_get_attachment_url( self::$attachment_ids[ $index ] );
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$gallery_video = new \ParadigmaTools\Gfv\Items\Item\GalleryVideo( $post );

		$this->assertSame( $expected_src, $gallery_video->get_origin_src(),
			"Expected URL of original video." );

	}
	/**
	 * @dataProvider index_data_provider
	 */
	public function test_get_icon_src( $index ) {
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$expected_src = wp_mime_type_icon( self::$attachment_ids[ $index ] );
		$gallery_video = new \ParadigmaTools\Gfv\Items\Item\GalleryVideo( $post );

		$this->assertSame( $expected_src, $gallery_video->get_icon_src(),
			"Expected video icon." );
	}
	/**
	 * @dataProvider index_data_provider
	 */
	public function test_get_title( $index ) {
		$expected_title = get_the_title( self::$attachment_ids[ $index ] );
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$gallery_video = new \ParadigmaTools\Gfv\Items\Item\GalleryVideo( $post );

		$this->assertSame( $expected_title, $gallery_video->get_title(),
			"Incorrect Video title." );
	}
	/**
	 * @dataProvider index_data_provider
	 */
	public function test_get_id( $index ) {
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$gallery_video = new \ParadigmaTools\Gfv\Items\Item\GalleryVideo( $post );

		$this->assertSame( self::$attachment_ids[ $index ], $gallery_video->get_id(),
			"Incorrect attachment ID." );
	}
	/**
	 * @dataProvider index_data_provider
	 */
	public function test_get_type( $index ) {
		$post = $this->factory->post->get_object_by_id( self::$attachment_ids[ $index ] );
		$gallery_video = new \ParadigmaTools\Gfv\Items\Item\GalleryVideo( $post );

		$this->assertSame( 'video', $gallery_video->get_type(),
			"Gallery item type must be video" );
	}
	public function index_data_provider(): array {
		return array(
			'mp4' => array( 0 ),
		);
	}
}