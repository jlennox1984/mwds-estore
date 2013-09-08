<?php
/**
* @version		$Id: session.php 6157 2007-01-03 00:22:09Z Jinx $
* @package		Joomla.Framework
* @subpackage	Environment
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
* Custom session handler for PHP 
*
* @abstract
* @author		Johan Janssens <johan.janssens@joomla.org>
* @package		Joomla.Framework
* @subpackage	Environment
* @since		1.5
* @see http://www.php.net/manual/en/function.session-set-save-handler.php
*/
class JSessionHandler extends JObject
{
	/**
	* Constructor
	*
	* @access protected
	* @param array $options optional parameters
	*/
	function __construct( $options = array() )
	{
		$this->register($options);
	}
	
	/**
	 * Returns a reference to a session hanlder object, only creating it
	 * if it doesn't already exist.
	 *
	 * @access public
	 * @param handler 	$handler The session handler to instantiate
	 * @return database A JSessionHandler object
	 * @since 1.5
	 */
	function &getInstance($handler = 'none', $options = array())
	{
		static $instances;

		if (!isset ($instances)) {
			$instances = array ();
		}

		if (empty ($instances[$handler]))
		{
			jimport('joomla.environment.sessionhandler.'.$handler);
			$handler = 'JSessionHandler'.$handler;
			$instances[$handler] = new $handler ($options);
		}

		return $instances[$handler];
	}

	/**
	* Register the functions of this class with PHP's session handler
	*
	* @access public
	* @param array $options optional parameters
	*/
	function register( $options = array() )
	{
		// use this object as the session handler
		session_set_save_handler(
			array($this, 'open'),
			array($this, 'close'),
			array($this, 'read'),
			array($this, 'write'),
			array($this, 'destroy'),
			array($this, 'gc')
		);
	}

	/**      
	 * Open the SessionHandler backend.      
	 *      
	 * @abstract
	 * @access public      
	 * @param string $save_path     The path to the session object.      
	 * @param string $session_name  The name of the session.      
	 * @return boolean  True on success, false otherwise.      
	 */
	function open($save_path, $session_name)
	{
		return true;
	}

	/**      
	 * Close the SessionHandler backend.      
	 *      
	 * @abstract  
	 * @access public          
	 * @return boolean  True on success, false otherwise.      
	 */
	function close()
	{
		return true;
	}
	
 	/**      
 	 * Read the data for a particular session identifier from the      
 	 * SessionHandler backend.      
 	 *      
 	 * @abstract
 	 * @access public           
 	 * @param string $id  The session identifier.      
 	 * @return string  The session data.      
 	 */
	function read($id)
	{
		return;
	}
	
	/**      
	 * Write session data to the SessionHandler backend.      
	 *      
	 * @abstract
	 * @access public            
	 * @param string $id            The session identifier.      
	 * @param string $session_data  The session data.      
	 * @return boolean  True on success, false otherwise.      
	 */
	function write($id, $session_data)
	{
		return true;
	}
	
	/**      
	  * Destroy the data for a particular session identifier in the      
	  * SessionHandler backend.     
	  *  
	  * @abstract
	  * @access public            
	  * @param string $id  The session identifier.      
	  * @return boolean  True on success, false otherwise.      
	  */
	function destroy($id)     
	{         
		return true;
	}
	
	/**      
	 * Garbage collect stale sessions from the SessionHandler backend.      
	 *      
	 * @abstract
	 * @access public           
	 * @param integer $maxlifetime  The maximum age of a session.      
	 * @return boolean  True on success, false otherwise.      
	 */
	function gc($maxlifetime)
	{
		return true;
	}
	
	/**      
	 * Test to see if the SessionHandler is available.      
	 *      
	 * @abstract
	 * @static
	 * @access public           
	 * @return boolean  True on success, false otherwise.      
	 */
	function test()
	{
		return true;
	}
}
?>