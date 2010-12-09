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
jimport('joomla.html.pane');

/**
 * @package		Joomla
 * @subpackage	Menus
 * @since 1.5
 */
class MenusViewItem extends JView
{
	var $_name = 'item';

	function edit($tpl = null)
	{
		global $mainframe;

		$lang =& JFactory::getLanguage();
		$this->_layout = 'form';

		$item = &$this->get('Item');

		// Set toolbar items for the page
		if (!$item->id) {
			JMenuBar::title( JText::_( 'New Menu Item' ), 'menu.png' );
		} else {
			JMenuBar::title( JText::_( 'Edit Menu Item' ), 'menu.png' );
		}
		JMenuBar::save();
		JMenuBar::apply();
		if ($item->id) {
			// for existing items the button is renamed `close`
			JMenuBar::cancel( 'cancelItem', 'Close' );
		} else {
			JMenuBar::cancel('cancelItem');
		}
		JMenuBar::help( 'screen.menus.edit' );

		// Load component language files
		$component		= &$this->get('Component');
		$lang->load($component->option, JPATH_ADMINISTRATOR);

		// Initialize variables
		$urlparams		= $this->get( 'UrlParams' );
		$params			= $this->get( 'StateParams' );
		$advanced		= $this->get( 'AdvancedParams' );
		$name			= $this->get( 'StateName' );
		$description	= $this->get( 'StateDescription' );
		$menuTypes 		= JMenuHelper::getMenuTypeList();
		$components		= JMenuHelper::getComponentList();

		JCommonHTML::loadOverlib();

		$document = & JFactory::getDocument();
		if ($item->id) {
			$document->setTitle('Edit Menu Item');
		} else {
			$document->setTitle('New Menu Item');
		}

		// Was showing up null in some cases....
		if (!$item->published) {
			$item->published = 0;
		}
		$lists = new stdClass();
		$lists->published = JMenuHelper::Published($item);
		$lists->disabled = ($item->type != 'url' ? 'disabled="true"' : '');

		$item->expansion = null;
		if ($item->type != 'url') {
			$lists->disabled = 'disabled="true"';
			$item->linkfield = '<input type="hidden" name="link" value="'.$item->link.'" />';
			if (($item->id) && ($item->type == 'component')) {
				$item->expansion = '&amp;expand='.trim(str_replace('com_', '', $item->linkparts['option']));
			}
		} else {
			$lists->disabled = null;
			$item->linkfield = null;
		}

		$this->assignRef('lists'	, $lists);
		$this->assignRef('item'		, $item);
		$this->assignRef('urlparams', $urlparams);
		$this->assignRef('params'	, $params);
		$this->assignRef('advanced'	, $advanced);
		$this->assignRef('menutypes', $menuTypes);
		$this->assignRef('name'		, $name);
		$this->assignRef('description', $description);

		// Add slider pane
		$pane =& JPane::getInstance('sliders');
		$this->assignRef('pane', $pane);

		parent::display($tpl);
	}

	function type($tpl = null)
	{
		global $mainframe;

		$lang =& JFactory::getLanguage();
		$this->_layout = 'type';

		$item = &$this->get('Item');

		// Set toolbar items for the page
		if (!$item->id) {
			JMenuBar::title(  JText::_( 'Add Menu Item' ), 'menu.png' );
		} else {
			JMenuBar::title(  JText::_( 'Change Menu Item' ), 'menu.png' );
		}

		// Set toolbar items for the page
		JMenuBar::cancel('view');
		JMenuBar::help( 'screen.menus.type' );

		// Add scripts and stylesheets to the document
		$document	= & JFactory::getDocument();
		$url		= $mainframe->getSiteURL();
		$document->addScript($url.'includes/js/joomla/common.js');
		$document->addScript($url.'includes/js/joomla/cookie.js');
		$document->addScript('components/com_menus/assets/tree.js');
		$document->addScript('components/com_menus/assets/description.js');
		if($lang->isRTL()){
			$document->addStyleSheet('components/com_menus/assets/type_rtl.css');
		} else {
			$document->addStyleSheet('components/com_menus/assets/type.css');
		}
		JCommonHTML::loadOverlib();

		// Load component language files
		$components	= JMenuHelper::getComponentList();
		$n = count($components);
		for($i = 0; $i < $n; $i++)
		{
			$path = JPATH_SITE.DS.'components'.DS.$components[$i]->option.DS.'views';
			$components[$i]->legacy = !is_dir($path);

			$lang->load($components[$i]->option, JPATH_ADMINISTRATOR);
		}

		// Initialize variables
		$item			= &$this->get('Item');
		$expansion		= &$this->get('Expansion');
		$component		= &$this->get('Component');
		$name			= $this->get( 'StateName' );
		$description	= $this->get( 'StateDescription' );
		$menuTypes 		= JMenuHelper::getMenuTypeList();

		// Set document title
		if ($item->id) {
			$document->setTitle('Edit Menu Item Type');
		} else {
			$document->setTitle('New Menu Item Type');
		}

		$this->assignRef('item',		$item);
		$this->assignRef('components',	$components);
		$this->assignRef('expansion',	$expansion);
		parent::display($tpl);
	}
}
?>