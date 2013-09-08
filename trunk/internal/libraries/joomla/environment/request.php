<?php
/**
 * @version		$Id: request.php 6138 2007-01-02 03:44:18Z eddiea $
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

jimport('joomla.utilities.array');
jimport('joomla.utilities.functions');

/**
 * Create the request global object
 */
$GLOBALS['_JREQUEST'] = array();

/**
 * Set the available masks for cleaning variables
 */
define("JREQUEST_NOTRIM"   , 1);
define("JREQUEST_ALLOWRAW" , 2);
define("JREQUEST_ALLOWHTML", 4);

/**
 * JRequest Class
 *
 * This class serves to provide the Joomla Framework with a common interface to access
 * request variables.  This includes $_POST, $_GET, and naturally $_REQUEST.  Variables
 * can be passed through an input filter to avoid injection or returned raw.
 *
 * @static
 * @author		Louis Landry <louis.landry@joomla.org>
 * @package		Joomla.Framework
 * @subpackage	Environment
 * @since		1.5
 */
class JRequest
{
	/**
	 * Gets the full request path
	 * @return string
	 */
	function getURI()
	{
		$uri = &JFactory::getURI();
		return $uri->toString();
	}

	/**
	 * Fetches and returns a given variable.
	 *
	 * The default behaviour is fetching variables depending on the
	 * current request method: GET and HEAD will result in returning
	 * an entry from $_GET, POST and PUT will result in returning an
	 * entry from $_POST.
	 *
	 * You can force the source by setting the $hash parameter:
	 *
	 *   post		$_POST
	 *   get		$_GET
	 *   files		$_FILES
	 *   cookie		$_COOKIE
	 *   method		via current $_SERVER['REQUEST_METHOD']
	 *   default	$_REQUEST
	 *
	 * @static
	 * @param	string	$name		Variable name
	 * @param	string	$default	Default value if the variable does not exist
	 * @param	string	$hash		Where the var should come from (POST, GET, FILES, COOKIE, METHOD)
	 * @param	string	$type		Return type for the variable (INT, FLOAT, STRING, BOOLEAN, ARRAY)
	 * @param	int		$mask		Filter mask for the variable
	 * @return	mixed	Requested variable
	 * @since	1.5
	 */
	function getVar($name, $default = null, $hash = 'default', $type = 'none', $mask = 0)
	{
		// Ensure hash and type are uppercase
		$hash = strtoupper( $hash );
		if ($hash === 'METHOD') {
			$hash = strtoupper( $_SERVER['REQUEST_METHOD'] );
		}
		$type	= strtoupper( $type );
		$sig	= $hash.$mask;

		// Get the input hash
		switch ($hash)
		{
			case 'GET' :
				$input = &$_GET;
				break;
			case 'POST' :
				$input = &$_POST;
				break;
			case 'FILES' :
				$input = &$_FILES;
				break;
			case 'COOKIE' :
				$input = &$_COOKIE;
				break;
			default:
				$input = &$_REQUEST;
				break;
		}

		if (isset($GLOBALS['_JREQUEST'][$name]) && ($GLOBALS['_JREQUEST'][$name] == 'SET')) {
			// Get the variable from the input hash
			$var = (isset($input[$name]) && $input[$name] !== null) ? $input[$name] : $default;
		}
		elseif (!isset($GLOBALS['_JREQUEST'][$name][$sig]))
		{
			$var = (isset($input[$name]) && $input[$name] !== null) ? $input[$name] : $default;
			// Get the variable from the input hash
			$var = JRequest::_cleanVar($var, $mask, $type);

			// Handle magic quotes compatability
			if (get_magic_quotes_gpc() && ($var != $default))
			{
				if (!is_array($var) && is_string($var)) {
					$var = stripslashes($var);
				}
			}
			if ($var !== null) {
				$GLOBALS['_JREQUEST'][$name][$sig] = $var;
			} else {
				$var = $default;
			}
		} else {
			$var = $GLOBALS['_JREQUEST'][$name][$sig];
		}

		return $var;
	}

	function setVar($name, $value = null, $hash = 'default')
	{
		// Clean global request var
		$GLOBALS['_JREQUEST'][$name] = 'SET';

		// Get the request hash value
		$hash = strtoupper($hash);
		if ($hash === 'METHOD') {
			$hash = strtoupper($_SERVER['REQUEST_METHOD']);
		}
		switch ($hash)
		{
			case 'GET' :
				$_GET[$name] = $value;
				$_REQUEST[$name] = $value;
				break;
			case 'POST' :
				$_POST[$name] = $value;
				$_REQUEST[$name] = $value;
				break;
			case 'FILES' :
				$_FILES[$name] = $value;
				$_REQUEST[$name] = $value;
				break;
			case 'COOKIE' :
				$_COOKIE[$name] = $value;
				$_REQUEST[$name] = $value;
				break;
			default:
				$_GET[$name] = $value;
				$_POST[$name] = $value;
				$_REQUEST[$name] = $value;
				break;
		}

		return $value;
	}

	/**
	 * Fetches and returns a request array.
	 *
	 * The default behaviour is fetching variables depending on the
	 * current request method: GET and HEAD will result in returning
	 * $_GET, POST and PUT will result in returning $_POST.
	 *
	 * You can force the source by setting the $hash parameter:
	 *
	 *   post		$_POST
	 *   get		$_GET
	 *   files		$_FILES
	 *   cookie		$_COOKIE
	 *   method		via current $_SERVER['REQUEST_METHOD']
	 *   default	$_REQUEST
	 *
	 * @static
	 * @param	string	$hash	to get (POST, GET, FILES, METHOD)
	 * @param	int		$mask	Filter mask for the variable
	 * @return	mixed	Request hash
	 * @since	1.5
	 */
	function get($hash = 'default', $mask = 0)
	{
		static $hashes;

		if (!isset($hashes)) {
			$hashes = array();
		}

		$hash		= strtoupper( $hash );
		$signature	= $hash.$mask;
		if (!isset($hashes[$signature])) {
			$result		= null;
			$matches	= array();

			if ($hash === 'METHOD') {
				$hash = strtoupper( $_SERVER['REQUEST_METHOD'] );
			}

			switch ($hash)
			{
				case 'GET' :
					$input = $_GET;
					break;

				case 'POST' :
					$input = $_POST;
					break;

				case 'FILES' :
					$input = $_FILES;
					break;

				case 'COOKIE' :
					$input = $_COOKIE;
					break;

				default:
					$input = $_REQUEST;
					break;
			}

			$result = JRequest::_cleanVar($input, $mask);

			// Handle magic quotes compatability
			if (get_magic_quotes_gpc()) {
				$result = JRequest::_stripSlashesRecursive( $result );
			}
			$hashes[$signature] = &$result;
		}
		return $hashes[$signature];
	}

	/**
	 * Cleans the request from script injection.
	 *
	 * @static
	 * @return	void
	 * @since	1.5
	 */
	function clean()
	{
		JRequest::_cleanArray( $_FILES );
		JRequest::_cleanArray( $_ENV );
		JRequest::_cleanArray( $_GET );
		JRequest::_cleanArray( $_POST );
		JRequest::_cleanArray( $_COOKIE );
		JRequest::_cleanArray( $_SERVER );

		if (isset( $_SESSION )) {
			JRequest::_cleanArray( $_SESSION );
		}

		$REQUEST	= $_REQUEST;
		$GET		= $_GET;
		$POST		= $_POST;
		$COOKIE		= $_COOKIE;
		$FILES		= $_FILES;
		$ENV		= $_ENV;
		$SERVER		= $_SERVER;

		if (isset ( $_SESSION )) {
			$SESSION = $_SESSION;
		}

		foreach ($GLOBALS as $key => $value) {
			if ( $key != 'GLOBALS' ) {
				unset ( $GLOBALS [ $key ] );
			}
		}
		$_REQUEST	= $REQUEST;
		$_GET		= $GET;
		$_POST		= $POST;
		$_COOKIE	= $COOKIE;
		$_FILES		= $FILES;
		$_ENV 		= $ENV;
		$_SERVER 	= $SERVER;

		if (isset ( $SESSION )) {
			$_SESSION = $SESSION;
		}

		// Make sure the request hash is clean on file inclusion
		$GLOBALS['_JREQUEST'] = array();
	}

	/**
	 * Adds an array to the GLOBALS array and checks that the GLOBALS variable is not being attacked
	 *
	 * @access	protected
	 * @param	array	$array	Array to clean
	 * @param	boolean	True if the array is to be added to the GLOBALS
	 * @since	1.5
	 */
	function _cleanArray( &$array, $globalise=false )
	{
		static $banned = array( '_files', '_env', '_get', '_post', '_cookie', '_server', '_session', 'globals' );

		foreach ($array as $key => $value)
		{
			// PHP GLOBALS injection bug
			$failed = in_array( strtolower( $key ), $banned );

			// PHP Zend_Hash_Del_Key_Or_Index bug
			$failed |= is_numeric( $key );
			if ($failed) {
				die( 'Illegal variable <b>' . implode( '</b> or <b>', $banned ) . '</b> passed to script.' );
			}
			if ($globalise) {
				$GLOBALS[$key] = $value;
			}
		}
	}

	function _cleanVar($var, $mask=0, $type=null)
	{
		// Static input filters for specific settings
		static $noHtmlFilter	= null;
		static $safeHtmlFilter	= null;

		// If the no trim flag is not set, trim the variable
		if (!($mask & 1) && is_string($var)) {
			$var = trim($var);
		}

		// Now we handle input filtering
		if ($mask & 2)
		{
			// If the allow raw flag is set, do not modify the variable
			$var = $var;
		}
		elseif ($mask & 4)
		{
			// If the allow html flag is set, apply a safe html filter to the variable
			if (is_null($safeHtmlFilter)) {
				$safeHtmlFilter = & JInputFilter::getInstance(null, null, 1, 1);
			}
			$var = $safeHtmlFilter->clean($var, $type);
		}
		else
		{
			// Since no allow flags were set, we will apply the most strict filter to the variable
			if (is_null($noHtmlFilter)) {
				$noHtmlFilter = & JInputFilter::getInstance(/* $tags, $attr, $tag_method, $attr_method, $xss_auto */);
			}
			$var = $noHtmlFilter->clean($var, $type);
		}
		return $var;
	}

	/**
	 * Strips slashes recursively on an array
	 *
	 * @access	protected
	 * @param	array	$array		Array of (nested arrays of) strings
	 * @return	array	The input array with stripshlashes applied to it
	 */
	function _stripSlashesRecursive( $value )
	{
		$value = is_array( $value ) ? array_map( array( 'JRequest', '_stripSlashesRecursive' ), $value ) : stripslashes( $value );
		return $value;
	}
}
?>
