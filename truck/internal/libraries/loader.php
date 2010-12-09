<?php
/**
* @version $Id: loader.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage Libraries
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

if(!defined('DS')) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

/**
 * @package		Joomla
 * @subpackage	Libraries
 */
class JLoader
{
	 /**
	 * Loads a class from specified directories.
	 *
	 * @param string $name The class name to look for.
	 * @param string|array $dirs Search these directories for the class.
	 * @return void
	 * @since 1.5
	 */
	function import( $filePath )
	{
		static $paths;

		if (!isset($paths))
		{
			$paths = array();
		}

		if (!isset($paths[$filePath]))
		{
			$paths[$filePath] = true;

			$parts = explode( '.', $filePath );

			$base =  dirname( __FILE__ );

			if(array_pop( $parts ) == '*')
			{
				$path = $base . DS . implode( DS, $parts );

				if (!is_dir( $path )) {
					return false;
				}

				$dir = dir( $path );
				while ($file = $dir->read()) {
					if (preg_match( '#(.*?)\.php$#', $file, $m )) {
						$nPath = str_replace( '*', $m[1], $filePath );
						// we need to check each file again incase one has a jimport
						if (!isset($paths[$nPath]))
						{
							require $path . DS . $file;
							$paths[$nPath] = true;
						}
					}
				}
				$dir->close();
			} else {
				$path = str_replace( '.', DS, $filePath );
				require $base . DS . $path . '.php';
			}
		}
		return true;
	}

	/**
	 * A common object factory.
	 *
	 * Assumes that the class constructor takes only one parameter, an associative array of
	 * construction options. Attempts to load the class automatically.
	 *
	 * @access public
	 * @param string $class The class name to instantiate.
	 * @param array $options An associative array of options (default null).
	 * @return object An object instance.
	 */
	function &factory($class, $options = null)
	{
		JLoader::import($class);
		$obj = new $class($options);
		return $obj;
	}

	/**
	 * Custom require_once function to improve preformance
	 *
	 * @access private
	 * @param string $file The path to the file to include
	 * @since 1.5
	 * @see require_once
	 *
	 */
	function _requireOnce( $file )
	{
		static $paths;

		if (!isset($paths)) {
			$paths = array();
		}

		if(!isset($paths[$file])) {
				require($file);
			$paths[$file] = true;
		}
	}
}

/**
 * Intelligent file importer
 *
 * @access public
 * @param string $$path A dot syntax path
 * @since 1.5
 */
function jimport( $path ) {
	return JLoader::import($path);
}
?>
