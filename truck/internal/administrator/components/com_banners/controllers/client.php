<?php
/**
 * @version		$Id: client.php 6138 2007-01-02 03:44:18Z eddiea $
 * @package		Joomla
 * @subpackage	Banners
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

/**
 * @package		Joomla
 * @subpackage	Banners
 */
class BannerControllerClient extends JController
{
	/**
	 * Constructor
	 */
	function __construct( $config = array() )
	{
		parent::__construct( $config );
		// Register Extra tasks
		$this->registerTask( 'add', 			'edit' );
		$this->registerTask( 'apply', 			'save' );
	}

	function display()
	{
		global $mainframe;

		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();
		$context			= 'com_banners.bannerclient.list.';
		$filter_order		= $mainframe->getUserStateFromRequest( $context.'filter_order',		'filter_order', 	'a.name' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',	'filter_order_Dir',	'' );
		$search 			= $mainframe->getUserStateFromRequest( $context.'search', 			'search', 			'' );
		$search 			= $db->getEscaped( JString::strtolower( $search ) );

		$limit		= (int) $mainframe->getUserStateFromRequest( $context.'limit',		'limit',		$mainframe->getCfg('list_limit'), 0);
		$limitstart	= (int) $mainframe->getUserStateFromRequest( $context.'limitstart',	'limitstart',	0);

		$where = array();

		if ($search) {
			$where[] = "LOWER(a.name) LIKE '%$search%'";
		}

		$where 		= ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : '' );
		$orderby = "\n ORDER BY $filter_order $filter_order_Dir, a.cid";

		// get the total number of records
		$query = "SELECT a.*, count(b.bid) AS nbanners, u.name AS editor"
		. "\n FROM #__bannerclient AS a"
		. "\n LEFT JOIN #__banner AS b ON a.cid = b.cid"
		. "\n LEFT JOIN #__users AS u ON u.id = a.checked_out"
		. $where
		. "\n GROUP BY a.cid"
		. $orderby
		;

		$db->setQuery( $query );
		$db->query();
		$total = $db->getNumRows();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();

		// table ordering
		if ( $filter_order_Dir == 'DESC' ) {
			$lists['order_Dir'] = 'ASC';
		} else {
			$lists['order_Dir'] = 'DESC';
		}
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		require_once(JPATH_COMPONENT.DS.'views'.DS.'client.php');
		BannersViewClients::clients( $rows, $pageNav, $lists );
	}

	/**
	 * Edit a banner client record
	 */
	function edit()
	{
		// Initialize variables
		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();

		$userId	= $user->get ( 'id' );
		$cid 	= JRequest::getVar( 'cid', array(0), 'method', 'array' );

		$row =& JTable::getInstance('bannerclient', 'Table');
		$row->load( (int) $cid[0] );

		// fail if checked out not by 'me'
		if ($row->isCheckedOut( $userId )) {
			$this->setRedirect( 'index.php?option=com_banners&c=client' );
			return JError::raiseWarning( JText::sprintf( 'WARNEDITEDBYPERSON', $row->name ) );
		}

		if ($row->cid) {
			// do stuff for existing record
			$row->checkout( $userId );
		} else {
			// do stuff for new record
			$row->published = 0;
			$row->approved = 0;
		}

		require_once(JPATH_COMPONENT.DS.'views'.DS.'client.php');
		BannersViewClients::client( $row );
	}

	function save()
	{
		$this->setRedirect( 'index.php?option=com_banners&c=client' );

		// Initialize variables
		$db		=& JFactory::getDBO();
		$table	=& JTable::getInstance('bannerclient', 'Table');

		if (!$table->bind( JRequest::get( 'post' ) )) {
			return JError::raiseWarning( 500, $table->getError() );
		}
		if (!$table->check()) {
			return JError::raiseWarning( 500, $table->getError() );
		}
		if (!$table->store()) {
			return JError::raiseWarning( 500, $table->getError() );
		}
		$table->checkin();

		switch (JRequest::getVar( 'task' ))
		{
			case 'apply':
				$this->setRedirect( 'index.php?option=com_banners&c=client&task=edit&cid[]='. $table->cid );
				break;
		}

		$this->setMessage( JText::_( 'Item Saved' ) );
	}

	function cancel()
	{
		$this->setRedirect( 'index.php?option=com_banners&c=client' );

		// Initialize variables
		$db			=& JFactory::getDBO();
		$table		=& JTable::getInstance('bannerclient', 'Table');
		$table->cid	= JRequest::getVar( 'cid', 0, 'post', 'int' );
		$table->checkin();
	}

	function remove()
	{
		$this->setRedirect( 'index.php?option=com_banners&c=client' );

		// Initialize variables
		$db		=& JFactory::getDBO();
		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$table	=& JTable::getInstance('bannerclient', 'Table');
		$n		= count( $cid );

		for ($i = 0; $i < $n; $i++)
		{
			$query = "SELECT COUNT( bid )"
			. "\n FROM #__banner"
			. "\n WHERE cid = ". (int) $cid[$i]
			;
			$db->setQuery($query);
			$count = $db->loadResult();
			if ($count === null) {
				return JError::raiseWarning( 500, $db->getErrorMsg() );
			}
			else if ($count > 0) {
				return JError::raiseWarning( 500, JText::_( 'WARNCANNOTDELCLIENTBANNER' ) );
			}
			else {
				if (!$table->delete( (int) $cid[$i] )) {
					return JError::raiseWarning( 500, $table->getError() );
				}
			}
		}

		$this->setMessage( JText::sprintf( 'Items removed', $n ) );
	}
}
?>