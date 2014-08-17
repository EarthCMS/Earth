<?php
/**
 * User model
 ** 
 *
 * @package		ClanCatsFramework
 * @author		Mario Döring <mario@clancats.com>
 * @version		2.0
 * @copyright 	2010 - 2014 ClanCats GmbH
 *
 */
class User extends Auth\User
{	
	/**
	 * The users table
	 */
	protected static $_table = 'auth_users';
	
	/**
	 * The user model defaults
	 *
	 * @var array
	 */
	protected static $_defaults = array(
		'id'	,
		'active'			=> array( 'bool', true ),
		'group_id'		=> 0,
		'email'			=> '',
		'name'			=> '',
		'password'		=> null,
		'storage'		=> array( 'json', array() ),
		'last_login'		=> array( 'timestamp', 0 ),
		'created_at'		=> array( 'timestamp' ),
		'modified_at'	=> array( 'timestamp' ),
	);
	
	/**
	 * Create a fake user
	 *
	 * @param int 		$count
	 */
	public static function fake( $count = 1 )
	{
		if ( $count > 1 )
		{
			for( $i=0;$i<$count;$i++ )
			{
				static::fake(); 
			}
			
			return;
		}
		
		$user = new static;
		$faker = Faker\Factory::create();
		
		$user->email = $faker->email;
		$user->password = "password";
		
		$user->save();
		
		return $user;
	}
	
	/**
	 * Get the user group
	 *
	 * @return \Auth\Group
	 */
	public function group()
	{
		return $this->belongs_to( 'Group' );
	}
	
	/**
	 * Return the users avatar
	 *
	 * @param $size
	 * @return string
	 */
	public function avatar()
	{
		return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) ) . "?d=identicon&s=130";
	}
}