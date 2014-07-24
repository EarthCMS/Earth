<?php namespace Admin;
/**
 * PanelResposne
 **
 * 
 * @package       ClanCats Earth Admin Panel
 * @author        
 * @version       1.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Panel
{
	/**
	 * Panel Response
	 * 
	 * @param string 			$body
	 * @return Panel
	 */
	public static function create( $body = null ) 
	{
		return new static( $body );
	}
	
	/**
	 * Panel close Response
	 * 
	 * @param string 			$body
	 * @return Panel
	 */
	public static function create_close() 
	{
		return static::create()->close( true );
	}
	
	/**
	 * The panel response structure
	 *
	 * @param array
	 */
	protected $response_json = array(
		'body' => '',
		'close' => false,
	);
	
	/**
	 * Panel constructor
	 *
	 * @param string 			$body
	 * @return void
	 */
	public function __construct( $body )
	{
		$this->body( $body );
	}
	
	/**
	 * Set the reponse body
	 *
	 * @param string			$body
	 * @return void
	 */
	public function body( $body )
	{
		$this->response_json['body'] = $body;
	}
	
	/**
	 * Set the reponse body
	 *
	 * @param bool			$tf
	 * @return void
	 */
	public function close( $tf = true )
	{
		$this->response_json['close'] = (bool) $tf;
	}
	
	/**
	 * Get the CCResponse for the panel
	 *
	 * @return CCResponse
	 */
	public function response()
	{
		return \CCResponse::json( $this->response_json );
	}
}