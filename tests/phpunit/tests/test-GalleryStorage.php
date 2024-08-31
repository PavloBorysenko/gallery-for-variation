<?php

class Test_GalleryStorage extends WP_UnitTestCase {
	protected $storage;
	protected $key;

	protected static $post_id;

	public function setUp(): void {
		parent::setUp();
		$this->key = GFV_GALLERY_SLUG;
		$this->storage = new \ParadigmaTools\Gfv\Data\GalleryStorage( $this->key );
	}

	public static function wpSetUpBeforeClass( $factory ) {
		self::$post_id = $factory->post->create();
	}

	public function tearDown(): void {
		parent::tearDown();
		delete_post_meta( self::$post_id, $this->key );
	}

	public function test_class_name() {
		$this->assertTrue( is_a( $this->storage, 'ParadigmaTools\Gfv\Data\Abstract\Storage' ),
			"There is no interface ParadigmaTools\Gfv\Data\Abstract\Storage implemented to the gallery storage" );
	}

	public function test_has_save_hook() {
		$this->assertTrue(
			Util::has_action( 'woocommerce_save_product_variation', $this->storage,
				'update_data' ),
			"The hook for rendering the form on the variable product edit page is not registered" );
	}

	/**
	 * @dataProvider incorrect_data_provider
	 */
	public function test_save_data( $data, $expected_data ) {
		$this->storage->save( self::$post_id, $data );

		$actual_data = get_post_meta( self::$post_id, $this->key, true );
		$this->assertEqualSets( $expected_data, $actual_data,
			"The function save does not save data correctly." );
	}

	public function test_delete() {
		$this->storage->save( self::$post_id, array( 1, 2, 3 ) );
		$this->storage->delete( self::$post_id );
		$this->assertEmpty( get_post_meta( self::$post_id, $this->key, true ),
			"The function did not delete all data." );
	}
	public function test_update_data() {
		$expected_data = array( 1, 2, 3 );
		$this->storage->update_data( self::$post_id, 1 );
		$this->assertEmpty( get_post_meta( self::$post_id, $this->key, true ),
			"Without GFV_GALLERY_SLUG key in POST, the function should not update the data." );

		$_POST[ $this->key ][ self::$post_id ] = $expected_data;
		$this->storage->update_data( self::$post_id, 1 );
		$actual_data = get_post_meta( self::$post_id, $this->key, true );

		$this->assertEqualSets( $expected_data, $actual_data,
			"The function update_data did not update the data correctly." );

		unset( $_POST[ $this->key ][ self::$post_id ] );
		$this->storage->update_data( self::$post_id, 1 );
		$this->assertEmpty( get_post_meta( self::$post_id, $this->key, true ),
			"The function should delete the data if there is no post ID." );
	}

	public function test_get_items_by_nonexistent_id() {
		$null_data = $this->storage->get_items_by_id( -333 );
		$this->assertNull( $null_data,
			"If the post does not exist, the function should return NULL." );
	}

	/**
	 * @dataProvider get_items_data_provider
	 */
	public function test_get_items_by_id( $data, $expected_data ) {
		update_post_meta( self::$post_id, $this->key, $data );
		$actual_data = $this->storage->get_items_by_id( self::$post_id );
		$this->assertSame( $actual_data, $expected_data,
			"The function makes an incorrect selection of data" );
	}
	public function incorrect_data_provider(): array {
		return array(
			'null' => array( array( null ), array( 0 ) ),
			'string' => array( array( "0", "-1", "string" ), array( 0, 1, 0 ) ),
			'numbers' => array( array( -1, 3.34, 9999999 ), array( 1, 3, 9999999 ) ),
			'boolean' => array( array( false, true ), array( 0, 1 ) ),
			'correct data' => array( array( 1, 2, 3 ), array( 1, 2, 3 ) )
		);
	}

	public function get_items_data_provider(): array {
		return array(
			'null' => array( null, null ),
			'empty array' => array( array(), null ),
			'empty data' => array( '', null ),
			'string' => array( "wrong data!", null ),
			'boolean' => array( true, null ),
			'correct data' => array( array( 1, 2, 3 ), array( 1, 2, 3 ) )
		);
	}
}