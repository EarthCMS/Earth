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
		'block_id' => array( 'int', 0 ),
		'revision' => array( 'int', 0 ),
		'content' => array( 'json', '' ),
		'created_at' => array( 'int', 0 )
	);
	
	/**
	 * Before save hook
	 *
	 * @param array 			$data
	 * @return array
	 */
	protected function _before_save( $data ) 
	{	
		// check block id
		if ( $data['block_id'] < 1 ) 
		{
			throw new Exception( "Block_Revision - cannot save revision wihout a block id." );
		}
		
		// get revision
		$data['revision'] = \DB::select( 'earth_block_revisions' )
			->where( 'block_id', $data['block_id'] )
			->count();
			
		// add one
		$data['revision']++;
		
		// return that data
		return $data;
	}
}
