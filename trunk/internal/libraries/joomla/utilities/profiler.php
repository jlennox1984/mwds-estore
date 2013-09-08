<?php

/**
* @version		$Id: profiler.php 6158 2007-01-03 00:39:59Z chrisdavenport $
* @package		Joomla.Framework
* @subpackage	Utilities
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/


/**
 * Utility class to assist in the process of benchmarking the execution
 * of sections of code to understand where time is being spent.
 *
 * @package 	Joomla.Framework
 * @subpackage	Utilities
 * @since 1.0
 */
class JProfiler extends JObject
{
	/**
	 *
	 * @var int
	 */
	var $_start = 0;

	/**
	 *
	 * @var string
	 */
	var $_prefix = '';

	/**
	 *
	 * @var array
	 */
	var $_buffer= null;

	/**
	 * Constructor
	 *
	 * @access protected
	 * @param string Prefix for mark messages
	 */
	function __construct( $prefix = '' )
	{
		$this->_start = $this->getmicrotime();
		$this->_prefix = $prefix;
		$this->_buffer = array();
	}

	/**
	 * Returns a reference to the global Profiler object, only creating it
	 * if it doesn't already exist.
	 *
	 * This method must be invoked as:
	 * 		<pre>  $browser = & JProfiler::getInstance( $prefix );</pre>
	 *
	 * @access public
	 * @param string Prefix used to distinguish profiler objects.
	 * @return JProfiler  The Profiler object.
	 */
	function &getInstance($prefix = '')
	{
		static $instances;

		if (!isset($instances)) {
			$instances = array();
		}

		if (empty($instances[$prefix])) {
			$instances[$prefix] = new JProfiler($prefix);
		}

		return $instances[$prefix];
	}

	/**
	 * Output a time mark
	 *
	 * The mark is returned as text enclosed in <div> tags
	 * with a CSS class of 'profiler'.
	 *
	 * @access public
	 * @param string A label for the time mark
	 * @return string Mark enclosed in <div> tags
	 */
	function mark( $label )
	{
		$mark = sprintf ( "\n<div class=\"profiler\">$this->_prefix %.3f $label</div>", $this->getmicrotime() - $this->_start );
		$this->_buffer[] = $mark;
		return $mark;
	}

	/**
	 * Get the current time.
	 *
	 * @access public
	 * @return float The current time
	 */
	function getmicrotime()
	{
		list( $usec, $sec ) = explode( ' ', microtime() );
		return ((float)$usec + (float)$sec);
	}

	/**
	 * Get information about current memory usage.
	 *
	 * @access public
	 * @return int The memory usage
	 * @link PHP_MANUAL#memory_get_usage
	 */
	function getMemory()
	{
		static $isWin;

		if (function_exists( 'memory_get_usage' )) {
			return memory_get_usage();
		}
		else
		{
			if (is_null( $isWin )) {
				$isWin = (substr(PHP_OS, 0, 3) == 'WIN');
			}
			if ($isWin) {
				// Windows workaround
				$output = array();
				$pid = getmypid();
				@exec( 'tasklist /FI "PID eq ' . $pid . '" /FO LIST', $output );
				if (!isset($output[5])) {
					$output[5] = null;
				}
				return substr( $output[5], strpos( $output[5], ':' ) + 1 );
			} else {
				return 0;
			}
		}
	}

	/**
	 * Get all profiler marks.
	 *
	 * Returns an array of all marks created since the Profiler object
	 * was instantiated.  Marks are strings as per {@link JProfiler::mark()}.
	 *
	 * @access public
	 * @return array Array of profiler marks
	 */
	function getBuffer() {
		return $this->_buffer;
	}
}

?>
