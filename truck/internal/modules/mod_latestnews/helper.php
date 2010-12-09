<?php
/**
* @version		$Id: helper.php 6233 2007-01-09 14:33:42Z Jinx $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE . '/components/com_content/helpers/content.php');

class modLatestNewsHelper
{
	function getList(&$params)
	{
		global $mainframe;

		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$userId		= (int) $user->get('id');

		$count		= (int) $params->get('count', 5);
		$catid		= trim( $params->get('catid') );
		$secid		= trim( $params->get('secid') );
		$show_front	= $params->get('show_front', 1);
		$aid		= $user->get('aid', 0);

		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('shownoauth');

		$nullDate	= $db->getNullDate();
		$now		= date('Y-m-d H:i:s', time());

		$where		= 'a.state = 1'
			. "\n AND ( a.publish_up = '$nullDate' OR a.publish_up <= '$now' )"
			. "\n AND ( a.publish_down = '$nullDate' OR a.publish_down >= '$now' )"
			;

		// User Filter
		switch ($params->get( 'user_id' ))
		{
			case 'by_me':
				$where .= ' AND (created_by = ' . $userId . ' OR modified_by = ' . $userId . ')';
				break;
			case 'not_me':
				$where .= ' AND (created_by <> ' . $userId . ' AND modified_by <> ' . $userId . ')';
				break;
		}

		// Ordering
		switch ($params->get( 'ordering' ))
		{
			case 'm_dsc':
				$ordering		= 'a.modified DESC, a.created DESC';
				break;
			case 'c_dsc':
			default:
				$ordering		= 'a.created DESC';
				break;
		}

		
		if ($catid)
		{
			$ids = explode( ',', $catid );
			JArrayHelper::toInteger( $ids );
			$catCondition = ' AND (a.catid=' . implode( ' OR a.catid=', $ids ) . ')';
		}
		if ($secid)
		{
			$ids = explode( ',', $secid );
			JArrayHelper::toInteger( $ids );
			$secCondition = ' AND (a.sectionid=' . implode( ' OR a.sectionid=', $ids ) . ')';
		}

		// Content Items only
		$query = "SELECT a.id, a.title, a.sectionid, a.catid" .
			"\n FROM #__content AS a" .
			($show_front == '0' ? "\n LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id" : '') .
			"\n INNER JOIN #__categories AS cc ON cc.id = a.catid" .
			"\n INNER JOIN #__sections AS s ON s.id = a.sectionid" .
			"\n WHERE $where AND a.sectionid > 0" .
			($access ? "\n AND a.access <= " .(int) $aid. " AND cc.access <= " .(int) $aid. " AND s.access <= " .(int) $aid : '').
			($catid ? "\n $catCondition" : '').
			($secid ? "\n $secCondition" : '').
			($show_front == '0' ? "\n AND f.content_id IS NULL" : '').
			"\n AND s.published = 1" .
			"\n AND cc.published = 1" .
			"\n ORDER BY $ordering";
		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();

		$i		= 0;
		$lists	= array();
		foreach ( $rows as $row ) 
		{
			$row->my_itemid = JContentHelper::getItemid($row->id, $row->catid, $row->sectionid);
		
			// & xhtml compliance conversion
			$row->title = ampReplace( $row->title );

			$link = sefRelToAbs( 'index.php?option=com_content&amp;view=article&amp;id='. $row->id . '&amp;Itemid='. $row->my_itemid );

			$lists[$i]->link	= $link;
			$lists[$i]->text	= $row->title;
			$i++;
		}

		return $lists;
	}
}