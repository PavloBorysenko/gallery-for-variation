<?php

class Test_Form extends WP_UnitTestCase {
	var $form;

	public function setUp(): void {
		parent::setUp();
		$this->form = new \ParadigmaTools\Gfv\Admin\Form( GFV_TEMPLATE_PATH, GFV_GALLERY_SLUG );
	}

	public function tearDown(): void {
		parent::tearDown();
		wp_deregister_script( 'gfv-admi' );
	}

	public function test_form_draw_variation_page() {
		$this->assertTrue(
			Util::has_action( 'woocommerce_product_after_variable_attributes', $this->form,
				'draw_gallery_form' ),
			"The hook for rendering the form on the variable product edit page is not registered" );
	}
	public function test_template_form_draw_variation_page() {
		$this->assertTrue(
			Util::has_action( 'woocommerce_variable_product_before_variations', $this->form,
				'draw_gallery_template' ),
			"The hook for rendering a template form on the variable product edit page is not registered" );
	}
	public function test_registration_scripts_styles() {
		$this->form->enqueue_script();

		$this->assertTrue( wp_style_is( 'gfv-admin-css', 'registered' ),
			"Form style is not connected." );
		$this->assertTrue( wp_script_is( 'gfv-admin', 'registered' ),
			"Form main sсript is not connected." );
		$this->assertTrue( wp_script_is( 'jquery', 'registered' ),
			"jQuery for Form is not connected." );
		$this->assertTrue( wp_script_is( 'jquery-ui-sortable', 'registered' ),
			"jquery-ui-sortable for Form is not connected." );
		$this->assertTrue( wp_script_is( 'wp-util', 'registered' ),
			"wp-util for Form is not connected." );
	}

	public function test_localized_script() {
		global $wp_scripts;

		$this->form->enqueue_script();
		$data = $wp_scripts->get_data( 'gfv-admin', 'data' );
		$data = Util::as_json_string( $data );

		$localized_data = json_decode( $data, true );

		$this->assertCount( 2, $localized_data );

		$this->assertarrayHasKey( 'title', $localized_data );
		$this->assertarrayHasKey( 'btn', $localized_data );
	}

	public function test_dofault_item_data() {
		$expected_data = array(
			'title' => '__TITLE__',
			'id' => '__ITEM_ID__',
			'type' => '__TYPE__',
			'src' => '__SRC__',
			'variation_id' => '__PRODUCT_ID__'
		);
		$actual_data = $this->form->get_gallery_item_data();
		$this->assertIsArray( $actual_data,
			"The function get_gallery_item_data must return an array." );
		$this->assertEqualSets( $expected_data, $actual_data,
			"The function generates incorrect data by default." );

		$expected_data['variation_id'] = 1;
		$actual_data = $this->form->get_gallery_item_data( null, 1 );
		$this->assertEqualSets( $expected_data, $actual_data,
			"The function generates incorrect data with variation_id." );
	}
}