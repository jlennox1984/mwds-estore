<?php
/**
 * @version		$Id: element.php 6138 2007-01-02 03:44:18Z eddiea $
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

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.helper');
jimport( 'joomla.application.component.model');

/**
 * Content Component Article Model
 *
 * @author	Louis Landry <louis.landry@joomla.org>
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class ContentModelElement extends JModel
{
	/**
	 * Content data in category array
	 *
	 * @var array
	 */
	var $_list = null;

	var $_page = null;

	/**
	 * Method to get content article data for the frontpage
	 *
	 * @since 1.5
	 */
	function getList()
	{
		global $mainframe;

		if (!empty($this->_list)) {
			return $this->_list;
		}

		// Initialize variables
		$db		=& $this->getDBO();
		$filter	= null;

		// Get some variables from the request
		$sectionid			= JRequest::getVar( 'sectionid', -1, '', 'int' );
		$redirect			= $sectionid;
		$option				= JRequest::getVar( 'option' );
		$filter_order		= $mainframe->getUserStateFromRequest("articleelement.filter_order", 'filter_order', '');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest("articleelement.filter_order_Dir", 'filter_order_Dir', '');
		$filter_state		= $mainframe->getUserStateFromRequest("articleelement.filter_state", 'filter_state', '*');
		$catid				= $mainframe->getUserStateFromRequest("articleelement.catid", 'catid', 0);
		$filter_authorid	= $mainframe->getUserStateFromRequest("articleelement.filter_authorid", 'filter_authorid', 0);
		$filter_sectionid	= $mainframe->getUserStateFromRequest("articleelement.filter_sectionid", 'filter_sectionid', -1);
		$limit				= $mainframe->getUserStateFromRequest('limit', 'limit', $mainframe->getCfg('list_limit'));
		$limitstart			= $mainframe->getUserStateFromRequest("articleelement.limitstart", 'limitstart', 0);
		$search				= $mainframe->getUserStateFromRequest("articleelement.search", 'search', '');
		$search				= $db->getEscaped(trim(JString::strtolower($search)));


		//$where[] = "c.state >= 0";
		$where[] = "c.state != -2";

		if (!$filter_order) {
			$filter_order = 'section_name';
		}
		$order = "\n ORDER BY $filter_order $filter_order_Dir, section_name, cc.name, c.ordering";
		$all = 1;

		if ($filter_sectionid >= 0) {
			$filter = "\n WHERE cc.section = $filter_sectionid";
		}
		$section->title = 'All Articles';
		$section->id = 0;

		/*
		 * Add the filter specific information to the where clause
		 */
		// Section filter
		if ($filter_sectionid >= 0) {
			$where[] = "c.sectionid = $filter_sectionid";
		}
		// Category filter
		if ($catid > 0) {
			$where[] = "c.catid = $catid";
		}
		// Author filter
		if ($filter_authorid > 0) {
			$where[] = "c.created_by = $filter_authorid";
		}
		// Content state filter
		if ($filter_state) {
			if ($filter_state == 'P') {
				$where[] = "c.state = 1";
			} else {
				if ($filter_state == 'U') {
					$where[] = "c.state = 0";
				} else if ($filter_state == 'A') {
					$where[] = "c.state = -1";
				} else {
					$where[] = "c.state != -2";
				}
			}
		}
		// Keyword filter
		if ($search) {
			$where[] = "LOWER( c.title ) LIKE '%$search%'";
		}

		// Build the where clause of the content record query
		$where = (count($where) ? "\n WHERE ".implode(' AND ', $where) : '');

		// Get the total number of records
		$query = "SELECT COUNT(*)" .
				"\n FROM #__content AS c" .
				"\n LEFT JOIN #__categories AS cc ON cc.id = c.catid" .
				"\n LEFT JOIN #__sections AS s ON s.id = c.sectionid" .
				$where;
		$db->setQuery($query);
		$total = $db->loadResult();

		// Create the pagination object
		jimport('joomla.html.pagination');
		$this->_page = new JPagination($total, $limitstart, $limit);

		// Get the articles
		$query = "SELECT c.*, g.name AS groupname, cc.name, u.name AS editor, f.content_id AS frontpage, s.title AS section_name, v.name AS author" .
				"\n FROM #__content AS c" .
				"\n LEFT JOIN #__categories AS cc ON cc.id = c.catid" .
				"\n LEFT JOIN #__sections AS s ON s.id = c.sectionid" .
				"\n LEFT JOIN #__groups AS g ON g.id = c.access" .
				"\n LEFT JOIN #__users AS u ON u.id = c.checked_out" .
				"\n LEFT JOIN #__users AS v ON v.id = c.created_by" .
				"\n LEFT JOIN #__content_frontpage AS f ON f.content_id = c.id" .
				$where .
				$order;
		$db->setQuery($query, $this->_page->limitstart, $this->_page->limit);
		$this->_list = $db->loadObjectList();

		// If there is a db query error, throw a HTTP 500 and exit
		if ($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr() );
			return false;
		}

		return $this->_list;
	}

	function getPagination()
	{
		if (is_null($this->_list) || is_null($this->_page)) {
			$this->getList();
		}
		return $this->_page;
	}
}
?>