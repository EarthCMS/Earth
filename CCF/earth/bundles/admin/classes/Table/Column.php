<?php namespace Admin;
/**
 * Data Table Column
 **
 * 
 * @package       ClanCats Earth Admin Panel
 * @author        
 * @version       1.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Table_Column
{
	/** 
	 * The column name
	 *
	 * @var string
	 */ 
	protected $name = null;

	/**
	 * Is this column sortable
	 *
	 * @var array
	 */
	protected $sortable = false;
	
	/**
	 * Is this column searchable
	 *
	 * @var array
	 */
	protected $searchable = false;
	
	/**
	 * Is this column searchable
	 *
	 * @var array
	 */
	protected $formattor = null;

	/** 
	 * Create new data table column
	 *
	 * @param string 		$name
	 * @param array 			$columns
	 * @return void
	 */ 
	public function __construct( $name, $sortable = false, $searchable = false )
	{
		$this->name = $name;
		$this->sortable = $sortable;
		$this->searchable = $searchable;
	}
	
	/**
	 * Set the formattor 
	 *
	 * @param callback 		$callback
	 * @return void
	 */
	public function formattor( $callback )
	{
		$this->formattor = $callback;
	}
	
	/**
	 * Display the column
	 *
	 * @param string 			$value
	 * @return string
	 */
	public function format( $value )
	{
		if ( !is_null( $this->formattor ) )
		{
			return call_user_func( $this->formattor, $value );
		}
		return $value;
	}
	
	/**
	 * Get the colums name
	 *
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}
	
	/**
	 * Is the column searchable?
	 *
	 * @param bool			$string
	 * @return string
	 */
	public function searchable( $string = false )
	{
		if ( $string )
		{
			return $this->searchable ? 'true' : 'false';
		}
		return $this->searchable;
	}
	
	/**
	* Is the column sortable?
	*
	* @param bool			$string
	* @return string
	*/
	public function sortable( $string = false )
	{
		if ( $string )
		{
			return $this->sortable ? 'true' : 'false';
		}
		return $this->sortable;
	}
}
