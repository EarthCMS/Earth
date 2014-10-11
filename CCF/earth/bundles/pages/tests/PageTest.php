<?php namespace Earth\Pages;
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
 * @group Earth_Pages
 * @group Earth_Pages_Page
 */
class PageTest extends \DB\Test_Case
{
	/**
	 * Page->type tests
	 */
	public function test_type()
	{
		$page = new Page;
		
		$page->type = 'content';
		
		$this->assertEquals( 'content', $page->type );
		$this->assertEquals( 1, $page->raw( 'type' ) );
		
		$page->type = 'controller';
		
		$this->assertEquals( 'controller', $page->type );
		$this->assertEquals( 3, $page->raw( 'type' ) );
	}
	
	/**
	 * Page->type wrong type test
	 *
	 * @expectedException Earth\Pages\Exception
	 */
	public function test_type_invalid()
	{
		$page = new Page;
		$page->type = "ThisIsInvalid";
	}
}