<?php
/**
 * @version		$Id: view.php 4854 2006-08-31 11:29:11Z Jinx $
 * @package		Joomla
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

jimport('joomla.application.component.view');

/**
 * @pacakge Joomla
 * @subpackage	Contacts
 */
class ContactViewCategory extends JView
{
	function display()
	{
		global $mainframe, $Itemid;

		$db			=& JFactory::getDBO();
		$document	=& JFactory::getDocument();

		$limit 		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		$catid  	= JRequest::getVar('catid', 0);

		$where		= "\n WHERE a.published = 1";

		if ( $catid ) {
			$where .= "\n AND a.catid = $catid";
		}

		$query = "SELECT"
		. "\n a.name AS title,"
		. "\n CONCAT( '$link', a.catid, '&id=', a.id ) AS link,"
		. "\n CONCAT( a.con_position, ' - ',a.misc ) AS description,"
		. "\n '' AS date,"
		. "\n c.title AS category,"
		. "\n a.id AS id"
		. "\n FROM #__contact_details AS a"
		. "\n LEFT JOIN #__categories AS c ON c.id = a.catid"
		. $where
		. "\n ORDER BY a.catid, a.ordering"
		;
		$db->setQuery( $query, 0, $limit );
		$rows = $db->loadObjectList();

		foreach ( $rows as $row )
		{
			// strip html from feed item title
			$title = htmlspecialchars( $row->title );
			$title = html_entity_decode( $title );

			// url link to article
			// & used instead of &amp; as this is converted by feed creator
			$link = 'index.php?option=com_contact&view=contact&id='. $row->id . '&catid='.$row->catid. '&Itemid='. $Itemid;;
			$link = sefRelToAbs( $link );

			// strip html from feed item description text
			$description = $row->description;
			$date = ( $row->date ? date( 'r', strtotime($row->date) ) : '' );

			// load individual item creator class
			$item = new JFeedItem();
			$item->title 		= $title;
			$item->link 		= $link;
			$item->description 	= $description;
			$item->date			= $date;
			$item->category   	= $row->category;

			// loads item info into rss array
			$document->addItem( $item );
		}
	}
}
?>