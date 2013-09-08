<?php
/**
* @version		$Id: newsfeed.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Newsfeeds
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
* @package		Joomla
* @subpackage	Newsfeeds
*/
class TableNewsFeed extends JTable
{
	/** @var int Primary key */
	var $id					= null;
	/** @var int */
	var $catid				= null;
	/** @var string */
	var $name				= null;
	/** @var string */
	var $link				= null;
	/** @var string */
	var $filename			= null;
	/** @var int */
	var $published			= null;
	/** @var int */
	var $numarticles		= null;
	/** @var int */
	var $cache_time			= null;
	/** @var int */
	var $checked_out		= null;
	/** @var time */
	var $checked_out_time	= null;
	/** @var int */
	var $ordering			= null;
	/** @var int */
	var $rtl				= 0;

	/**
	 * @param database A database connector object
	 */
	function __construct( &$db ) {
		parent::__construct( '#__newsfeeds', 'id', $db );
	}
}
?>