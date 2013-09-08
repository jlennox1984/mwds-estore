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
class WeblinksViewCategories extends JView
{
	function display( $tpl = null)
	{
		global $Itemid, $mainframe;

		// Initialize some variables
		$pathway	= & $mainframe->getPathWay();

		// Set the component name in the pathway
		$pathway->setItemName(1, JText::_('Links'));

		// Load the menu object and parameters
		$menu		=& JSiteHelper::getActiveMenuItem();

		$categories	=& $this->get('data');
		$total		=& $this->get('total');
		$state		=& $this->get('state');
		$params		= $state->get('parameters.menu');

		$weblinksConfig = &JComponentHelper::getParams( 'com_weblinks' );
		$params->def('header', $menu->name);
		$params->def('pageclass_sfx', '');
		$params->def('headings', 1);
		$params->def('hits', $weblinksConfig->get('hits'));
		$params->def('item_description', 1);
		$params->def('other_cat_section', 1);
		$params->def('other_cat', 1);
		$params->def('description', 1);
		$params->def('description_text', $weblinksConfig->get('description_text'));
		$params->def('image', -1);
		$params->def('weblink_icons', '');
		$params->def('image_align', 'right');

		// Define image tag attributes
		if ($params->get('image') != -1)
		{
			$attribs['align'] = '"'. $params->get('image_align').'"';
			$attribs['hspace'] = '"6"';

			// Use the static HTML library to build the image tag
			$image = JHTML::Image('/images/stories/'.$params->get('image'), JText::_('Web Links'), $attribs);
		}

		for($i = 0; $i < count($categories); $i++)
		{
			$category =& $categories[$i];
			$category->link = sefRelToAbs('index.php?option=com_weblinks&view=category&id='. $category->catid.'&Itemid='.$Itemid );
		}

		$this->assignRef('image',		$image);
		$this->assignRef('params',		$params);
		$this->assignRef('categories',	$categories);

		parent::display($tpl);
	}
}
?>