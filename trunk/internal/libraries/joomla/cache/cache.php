<?php
/**
 * @version		$Id: cache.php 6138 2007-01-02 03:44:18Z eddiea $
 * @package		Joomla.Framework
 * @subpackage	Cache
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

jimport('pear.cache.Lite');

/**
 * Abstract class for caching handlers
 *
 * @abstract
 * @package		Joomla.Framework
 * @subpackage	Cache
 * @since		1.5
 */
class JCache extends Cache_Lite
{
	var $_defaultGroup = 'JCache';

	var $_validateCache = false;

	/**
	* Constructor
	*
	* $options is an assoc. To have a look at availables options,
	* see the constructor of the Cache_Lite class in 'Cache_Lite.php'
	*
	* Comparing to Cache_Lite constructor, there is another option :
	* $options = array(
	*	 (...) see Cache_Lite constructor
	*	 'defaultGroup' => default cache group for function caching (string)
	* );
	*
	* @param array $options options
	* @access public
	*/
	function JCache($options = array (NULL))
	{
		$this->_construct($options);
	}

	/**
	 * Constructor
	 *
	 * @param array $options options
	 * @access protected
	 */
	function _construct($options)
	{
		// Set default group
		if (isset ($options['defaultGroup'])) {
			$this->_defaultGroup = $options['defaultGroup'];
		}

		// Build the cache directory if it exists
		if (isset ($options['cacheDir'])) {
			$this->_cacheDir = $options['cacheDir'];
		}

		$this->Cache_Lite($options);
	}

	/**
	 * Returns a reference to the global Cache object, only creating it
	 * if it doesn't already exist.
	 *
	 * @param handler $handler The cache handler to instantiate
	 * @param array $options options
	 * @return database A database object
	 * @since 1.5
	 */
	function &getInstance($handler = 'Function', $options)
	{
		static $instances;

		if (!isset ($instances))
		{
			$instances = array ();
		}

		$signature = serialize(array ($options));

		if (empty ($instances[$signature]))
		{
			jimport('joomla.cache.adapters.'.$handler);
			$adapter = 'JCache'.$handler;
			$instances[$signature] = new $adapter ($options);
		}

		return $instances[$signature];
	}

	/**
	* Enable/disbale caching
	*
	* @access public
	* @param	boolean	$enable If true enable caching.
	* @return	boolean The current setting (allows for a temporal change of the setting)
	*/
	function setCaching($enable = false)  {
		$oldValue = $this->_caching;
		$this->_caching = $enable;
		return $oldValue;
	}

	/**
	 * Enable/disbale cache validation
	 *
	 * @param boolean $validateCache If true enable cache validation.
	 * @access public
	 */
	function setCacheValidation($validateCache)
	{
		$this->_validateCache = $validateCache;
	}

	/**
	 * Make a control key with the string containing datas
	 *
	 * @param string $data data
	 * @param string $controlType type of control 'md5', 'crc32' or 'strlen'
	 * @return string control key
	 * @access public
	 */
	function generateId($data, $controlType = 'md5')
	{
		return $this->_hash($data, $controlType);
	}

	/**
	* Remove a cache file
	*
	* @param string $id cache id
	* @param string $group name of the cache group
	* @return boolean true if no problem
	* @access public
	*/
	function remove($id, $group = 'default')
	{
		$this->_setFileName($id, $group);
		if (file_exists($this->_file)) {
			if (!@unlink($this->_file)) {
				$this->raiseError('Cache_Lite : Unable to remove cache !', -3);
				return false;
			}
		}
		return true;
	}

	/**
	 * Cleans the cache
	 */
	function cleanCache($group = false, $mode = 'ingroup')
	{
		$cache = & JCache::getCache($group);
		$cache->clean($group, $mode);
	}

	/**
	 * Deprecated, use JFactory getCache instead
	 * @since 1.5
	 */
	function & getCache($group = '') {
		return JFactory::getCache($group);
	}
}
?>
