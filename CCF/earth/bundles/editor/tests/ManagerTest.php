<?php namespace Earth\Editor;
/**
 * CCF Earth Page Tests
 ** 
 *
 * @package		ClanCatsFramework
 * @author		Mario Döring <mario@clancats.com>
 * @version		2.0
 * @copyright 	2010 - 2014 ClanCats GmbH
 *
 * @group Earth
 * @group Earth_Editor
 * @group Earth_Editor_Manager
 */
class ManagerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Manager::create tests
	 */
	public function test_create()
	{
		$editor = Manager::create();
		
		$this->assertTrue( $editor instanceof Manager );
	}
}