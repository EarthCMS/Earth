<?php namespace Earth\Block;
/**
 * Block_Revision
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Block_Revision extends \DB\Model
{
	/**
	 * The database table name
	 * 
	 * @var string
	 */
	protected static $_table = 'earth_block_revisions';
	
	/**
	 * The  default properties
	 * 
	 * @var string
	 */
	protected static $_defaults = array(
		'id',
		'block_id' => array( 'int', 0 ),
		'revision' => array( 'int', 0 ),
		'content' => array( 'string', '' ),
		'created_at' => array( 'int', 0 )
	);
}
