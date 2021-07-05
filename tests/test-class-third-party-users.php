<?php
/**
 * Class ThirdPartyUsersTest
 *
 * @package Display_Third_Party_Users
 */

/**
 * Plugin function test case.
 */
class ThirdPartyUsersTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */	

	protected static $instance = null;

	public function setUp()
    {
        parent::setUp();

        $this->class_instance = new ThirdPartyUsers();
    }

	public function test___construct() {
		//$data = has_action(add_action( 'init', array( $this->class_instance, 'wpdtpu_rewrite' ) ));
		$data = has_action('init', [ $this->class_instance, 'wpdtpu_rewrite' ]);
		//if()
		if( has_action('init', [ $this->class_instance, 'wpdtpu_rewrite' ]) > 0 ) {
			$this->assertTrue( True );
		} else {
			$this->assertTrue( False );
		}

		if( has_filter('query_vars', [ $this->class_instance, 'wpdtpu_query_vars' ]) > 0 ) {
			$this->assertTrue( True );
		} else {
			$this->assertTrue( False );
		}

		if( has_action('template_include', [ $this->class_instance, 'wpdtpu_change_template' ]) > 0 ) {
			$this->assertTrue( True );
		} else {
			$this->assertTrue( False );
		}

		if( has_action('wp_enqueue_scripts', [ $this->class_instance, 'wpdtpu_load_plugin_js' ]) > 0 ) {
			$this->assertTrue( True );
		} else {
			$this->assertTrue( False );
		}

		if( has_action('wp_footer', [ $this->class_instance, 'wpdtpu_load_datatable' ]) > 0 ) {
			$this->assertTrue( True );
		} else {
			$this->assertTrue( False );
		}		
	}

	public function test_get_instance() {
		$this->assertEquals( $this->class_instance, $this->class_instance->get_instance() );
	}

	public function test_activate() {
		$this->assertTrue( set_transient( 'vpt_flush', 1, 60 ) );
	}

	public function test_wpdtpu_rewrite() {
		$this->assertTrue( set_transient( 'vpt_flush', 1, 60 ) );
		$this->assertTrue( get_transient( 'vpt_flush' ) == 1 ? True : False );
		$this->assertTrue( delete_transient( 'vpt_flush' ) );		
	}

	public function test_wpdtpu_query_vars() {
		$vars = [];
		$this->assertEmpty($vars);
		$this->assertNotEmpty( $this->class_instance->wpdtpu_query_vars($vars) );
	}

}
