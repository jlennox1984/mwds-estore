<?php
/**
* @version		$Id: view.html.php 6220 2007-01-09 00:59:19Z hackwar $
* @package		Joomla
* @subpackage	Weblinks
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the WebLinks component
 *
 * @static
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.0
 */
class WeblinksViewWeblinks extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $option;

		// Set toolbar items for the page
		JMenuBar::title(   JText::_( 'Weblink Manager' ), 'generic.png' );
		JMenuBar::publishList();
		JMenuBar::unpublishList();
		JMenuBar::deleteList();
		JMenuBar::editListX();
		JMenuBar::addNewX();
		JMenuBar::configuration('com_weblinks', '450');
		JMenuBar::help( 'screen.weblink' );

		$db		=& JFactory::getDBO();
		$uri	=& JFactory::getURI();

		$filter_state 		= $mainframe->getUserStateFromRequest( "$option.filter_state", 		'filter_state', 	'*' );
		$filter_catid 		= $mainframe->getUserStateFromRequest( "$option.filter_catid", 		'filter_catid', 	0 );
		$filter_order		= $mainframe->getUserStateFromRequest( "$option.filter_order", 		'filter_order', 	'a.ordering' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "$option.filter_order_Dir",	'filter_order_Dir',	'' );
		$search 			= $mainframe->getUserStateFromRequest( "$option.search", 			'search', 			'' );
		$search 			= $db->getEscaped( trim( JString::strtolower( $search ) ) );

		// Get data from the model
		$items		= & $this->get( 'Data');
		$total		= & $this->get( 'Total');
		$pagination = & $this->get( 'Pagination' );

		// build list of categories
		$javascript 	= 'onchange="document.adminForm.submit();"';
		$lists['catid'] = JAdminMenus::ComponentCategory( 'filter_catid', $option, intval( $filter_catid ), $javascript );

		// state filter
		$lists['state']	= JCommonHTML::selectState( $filter_state );

		// table ordering
		if ( $filter_order_Dir == 'DESC' ) {
			$lists['order_Dir'] = 'ASC';
		} else {
			$lists['order_Dir'] = 'DESC';
		}
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;

		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('request_url',	$uri->toString());

		parent::display($tpl);
	}
}
?>