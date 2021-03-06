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
* APC session handler for PHP 
*
* @abstract
* @author		Johan Janssens <johan.janssens@joomla.org>
* @package		Joomla.Framework
* @subpackage	Environment
* @since		1.5
* @see http://www.php.net/manual/en/function.session-set-save-handler.php
*/
class JSessionHandlerAPC extends JSessionHandler
{
	/**
	* Constructor
	*
	* @access protected
	* @param array $options optional parameters
	*/
	function __construct( $options = array() )
	{
		if (!$this->test()) {
            return JError::raiseError(404, "The apc extension isn't available");
        }
		
		parent::__construct($options);
	}
	
	/**      
	 * Open the SessionHandler backend.      
	 *      
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
 	 * @access public     
 	 * @param string $id  The session identifier.      
 	 * @return string  The session data.      
 	 */
	function read($id)
	{
		$sess_id = 'sess_'.$id; 	
		return (string) apc_fetch($sess_id);
	}
	
	/**      
	 * Write session data to the SessionHandler backend.      
	 *      
	 * @access public       
	 * @param string $id            The session identifier.      
	 * @param string $session_data  The session data.      
	 * @return boolean  True on success, false otherwise.      
	 */
	function write($id, $session_data)
	{
		$sess_id = 'sess_'.$id;
		return apc_store($sess_id, $session_data, ini_get("session.gc_maxlifetime"));
	}
	
	/**      
	  * Destroy the data for a particular session identifier in the      
	  * SessionHandler backend.     
	  *  
	  * @access public    
	  * @param string $id  The session identifier.      
	  * @return boolean  True on success, false otherwise.      
	  */
	function destroy($id)     
	{         
		$sess_id = 'sess_'.$id;
		return apc_delete($sess_id);
	}
	
	/**      
	 * Garbage collect stale sessions from the SessionHandler backend.      
	 *      
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
	 * @static
	 * @access public           
	 * @return boolean  True on success, false otherwise.      
	 */
	function test() {
		return extension_loaded('apc');
	}
}
?>