<?php
/**
 * @version		$Id: article.php 5379 2006-10-09 22:39:40Z Jinx $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

jimport('joomla.application.component.model');

/**
 * Weblinks Component Categories Model
 *
 * @author	Johan Janssens <johan.janssens@joomla.org>
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class WeblinksModelCategories extends JModel
{
	/**
	 * Categories data array
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * Categories total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */

	function __construct()
	{
		parent::__construct();

	}

	/**
	 * Method to get weblink item data for the category
	 *
	 * @access public
	 * @return array
	 */
	function getData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query);
		}

		return $this->_data;
	}

	/**
	 * Method to get the total number of weblink items for the category
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}

	function _buildQuery()
	{
		$user =& JFactory::getUser();
		$aid = $user->get('aid', 0);

		//Query to retrieve all categories that belong under the web links section and that are published.
		$query = "SELECT *, COUNT(a.id) AS numlinks FROM #__categories AS cc" .
			"\n LEFT JOIN #__weblinks AS a ON a.catid = cc.id" .
			"\n WHERE a.published = 1" .
			"\n AND section = 'com_weblinks'" .
			"\n AND cc.published = 1".
			"\n AND cc.access <= ".(int) $aid.
			"\n GROUP BY cc.id" .
			"\n ORDER BY cc.ordering";

		return $query;
	}
}
?>