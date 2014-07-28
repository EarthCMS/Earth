<?php
/**
 * Group
 **
 * 
 * @package		ClanCatsFramework
 * @author		Mario Döring <mario@clancats.com>
 * @version		2.0
 * @copyright 	2010 - 2014 ClanCats GmbH
 *
 */
class Group extends Auth\Group
{
	/**
	 * The  default properties
	 * 
	 * @var string
	 */
	protected static $_defaults = array(
		'id',
		'name' => array( 'string', '' ),
		'created_at' => array( 'int', 0 ),
		'modified_at' => array( 'int', 0 )
	);
}
