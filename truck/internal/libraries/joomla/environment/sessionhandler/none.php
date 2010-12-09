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
* File session handler for PHP 
*
* @abstract
* @author		Johan Janssens <johan.janssens@joomla.org>
* @package		Joomla.Framework
* @subpackage	Environment
* @since		1.5
* @see http://www.php.net/manual/en/function.session-set-save-handler.php
*/
class JSessionHandlerNone extends JSessionHandler
{
	/**
	* Register the functions of this class with PHP's session handler
	*
	* @access public
	* @param array $options optional parameters
	*/
	function register()
	{
		//let php handle the session storage
	}
}
?>