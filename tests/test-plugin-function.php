<?php
/**
 * Class PluginFunctionTest
 *
 * @package Display_Third_Party_Users
 */

/**
 * Plugin function test case.
 */
class PluginFunctionTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	public function test_sample() {
		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}

	public function test_sample_string() {
		// Replace this with some actual testing code.
		$string = 'Unit tests are sweet';
		$this->assertEquals( 'Unit tests are sweet', $string );
	}
}
