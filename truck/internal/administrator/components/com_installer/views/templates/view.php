<?php
/**
 * @version		$Id: view.php 6138 2007-01-02 03:44:18Z eddiea $
 * @package		Joomla
 * @subpackage	Menus
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

jimport('joomla.application.component.view');

/**
 * Extension Manager Templates View
 *
 * @author		Louis Landry <louis.landry@joomla.org>
 * @package		Joomla
 * @subpackage	Installer
 * @since		1.5
 */
class InstallerViewTemplates extends JView
{
	function display($tpl=null)
	{
		/*
		 * Set toolbar items for the page
		 */
		JMenuBar::title( JText::_( 'Extension Manager'), 'install.png' );
		JMenuBar::deleteList( '', 'remove', 'Uninstall' );
		JMenuBar::help( 'screen.installer2' );

		// Document
		$document = & JFactory::getDocument();
		$document->setTitle(JText::_('Extension Manager').' : '.JText::_('Templates'));

		// Get data from the model
		$state		= &$this->get('State');
		$items		= &$this->get('Items');
		$pagination	= &$this->get('Pagination');

		$lists = new stdClass();
		$select[] = JHTMLSelect::option('-1', JText::_('All'));
		$select[] = JHTMLSelect::option('0', JText::_('Site Templates'));
		$select[] = JHTMLSelect::option('1', JText::_('Admin Templates'));
		$lists->client = JHTMLSelect::genericList($select, 'client', 'class="inputbox" size="1" onchange="document.adminForm.submit();"', 'value', 'text', $state->get('filter.client'));

		$this->assignRef('state',		$state);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);
		$this->assignRef('lists',		$lists);

		JCommonHTML::loadOverlib();
		parent::display($tpl);
	}

	function loadItem($index=0)
	{
		$item =& $this->items[$index];
		$item->id		= $item->directory;
		$item->index	= $index;

		if ($item->active) {
			$item->cbd		= 'disabled';
			$item->style	= 'style="color:#999999;"';
		} else {
			$item->cbd		= null;
			$item->style	= null;
		}
		$item->author_info = @$item->authorEmail .'<br />'. @$item->authorUrl;

		$this->assignRef('item', $item);
	}
}
?>