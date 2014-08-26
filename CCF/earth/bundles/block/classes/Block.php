<?php namespace Earth\Block;
/**
 * Block
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Block extends \DB\Model
{
	/**
	 * The database table name
	 * 
	 * @var string
	 */
	protected static $_table = 'earth_blocks';
	
	/**
	 * Allow automatic timestamps
	 * 
	 * @var bool
	 */
	protected static $_timestamps = true;
	
	/**
	 * The  default properties
	 * 
	 * @var string
	 */
	protected static $_defaults = array(
		'id',
		'key' => array( 'string', '' ),
		'content' => array( 'string', '' ),
		'content_build' => array( 'string', '' ),
		'footer' => array( 'string', '' ),
		'modified_at' => array( 'int', 0 ),
		'created_at' => array( 'int', 0 )
	);
}
