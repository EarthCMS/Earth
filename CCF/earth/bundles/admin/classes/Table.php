<?php namespace Admin;
/**
 * Table
 **
 * 
 * @package       ClanCats Earth Admin Panel
 * @author        
 * @version       1.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */

use CCIn;

class Table
{
	/** 
	 * The model used 
	 *
	 * @var string
	 */ 
	protected $model = null;
	
	/**
	 * The columns that should be queried
	 *
	 * @var array
	 */
	protected $columns = array();
	
	/** 
	 * Create new data table handler
	 *
	 * @param string 		$model
	 * @return array
	 */ 
	public function __construct( $model )
	{
		if ( !class_exists( $model ) )
		{
			throw new Exception( 'Invalid model "'.$model.'" given for Admin Table.' );
		}
		
		$this->model = $model;
	}
	
	/**
	 * Add a column to the tabale
	 *
	 * @param string 		$name
	 * @param bool 			$sortable
	 * @param bool			$searchable
	 * @param callback		$formattor
	 *
	 * @return void
	 */
	public function column( $name, $sortable = false, $searchable = false, $formattor = null )
	{
		$column = new Table_Column( $name, $sortable, $searchable );
		
		if ( !is_null( $formattor ) )
		{
			$column->formattor( $formattor );
		}
		
		$this->columns[] = $column;
	}
	
	/**
	 * Generate the js init view for the datatable
	 *
	 * @param string 		$target	
	 * @param string 		$datasource
	 * @return string
	 */
	public function jsinit( $target, $datasource )
	{
		return \CCView::create( 'Admin::tablejs.view', array(
			'target' => $target,
			'remote' => $datasource,
			'columns' => $this->columns,
			'searchfield' => false,
		));
	}
	
	/**
	 * Recive the results based on the current  
	 * datable parameters recived via HTTP GET
	 *
	 * @param callback		$callback
	 * @param array 			$with
	 *
	 * @return array
	 */
	public function results( $callback = null, $with = array() )
	{		
		$columns = $this->collumns;
		$model = $this->model;
		
		return $model::with( $with, function( $q ) use( $columns, $callback ) 
		{	
			// limit
			$q->limit( (int) CCIn::get( 'start', 0 ), (int) CCIn::get( 'length', 10 ) );
			
			// filter the rest
			$this->filter_query( $q, $callback );
		});
		
		
	}
	
	/** 
	 * Filters the query on the get parameters
	 *
	 * @param DB\Query			$query
	 * @return void
	 */
	private function filter_query( &$q, $callback )
	{
		$order_params = CCIn::get( 'order' );
		
		$search = CCIn::get( 'search' );
		$search_term = trim( $search['value'] );
		
		if ( !is_null( $callback ) ) 
		{
			call_user_func_array( $callback, array( &$q ) );
		}
		
		$columns = $this->columns;
		
		$q->where( function($q) use( $columns, $search_term, $order_params )
		{
			// searchable
			foreach( $columns as $key => $column )
			{			
				// searchable
				if ( $column->searchable() )
				{
					$q->or_where( $column->name(), 'like', '%'.$search_term.'%' );
				}
			}
		});
		
		// sortable
		foreach( $order_params as $order )
		{
			if ( isset( $columns[$order['column']] ) )
			{
				$column = $columns[$order['column']];
				
				if ( $column->sortable() )
				{
					$q->order_by( $column->name(), $order['dir'] === 'asc' ? 'asc' : 'desc' );
				}
			}
		}
	}
	
	/**
	 * Generate a datatable response of the current table
	 *
	 * @param callback		$callback
	 * @param array 			$with
	 *
	 * @return array
	 */
	public function response( $callback = null, $with = array() )
	{	
		$results = $this->results( $callback, $with );
		
		$json = array( 'data' => array() );
		
		// we need the model
		$model = $this->model;
		
		// count total records
		$count = \DB::select( $model::_model( 'table' ) );
		if ( !is_null( $callback ) ) 
		{
			call_user_func_array( $callback, array( &$count ) );
		}
		
		$json['recordsTotal'] = $count->count();
		
		// count the filtered records
		$count = \DB::select( $model::_model( 'table' ) );
		$this->filter_query( $count, $callback );
		
		$json['recordsFiltered'] = $count->count();
		
		// work with the results
		foreach( $results as $result )
		{
			$record = array();
			
			foreach( $this->columns as $column )
			{
				if ( $result->__isset( $column->name() ) )
				{
					$record[$column->name()] = $column->format( $result->__get( $column->name() ), $result );
				}
				else
				{
					$record[$column->name()] =  $column->format( null, $result );
				}
			}
			
			$json['data'][] = $record;
		}
		
		return \CCResponse::json( $json );
	}
}
