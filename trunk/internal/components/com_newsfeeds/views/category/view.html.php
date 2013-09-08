<?php
/**
* version $Id: view.html.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Newsfeeds
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Newsfeeds component
 *
 * @static
 * @package		Joomla
 * @subpackage	Newsfeeds
 * @since 1.0
 */
class NewsfeedsViewCategory extends JView
{
	function display($tpl = null)
	{
		global $mainframe, $Itemid, $option;

		$pathway 	= & $mainframe->getPathWay();
		$document	= & JFactory::getDocument();

		// Get the paramaters of the active menu item
		$menu	=& JSiteHelper::getActiveMenuItem();
		$params	=& JSiteHelper::getMenuParams();

		$limit 			= JRequest::getVar('limit', $params->get('display_num'), '', 'int');
		$limitstart 	= JRequest::getVar('limitstart', 0, '', 'int');
		$catid 			= JRequest::getVar( 'catid', 0, '', 'int' );

		$category	= $this->get('category');
		$items		= $this->get('data');
		$total		= $this->get('total');

		// Parameters
		$params->def( 'page_title', 		1 );
		$params->def( 'header', 			$menu->name );
		$params->def( 'pageclass_sfx', 		'' );
		$params->def( 'headings', 			1 );
		$params->def( 'back_button', 		$mainframe->getCfg( 'back_button' ) );
		$params->def( 'description_text', 	'' );
		$params->def( 'image', 				-1 );
		$params->def( 'image_align', 		'right' );
		$params->def( 'other_cat_section', 	1 );
		// Category List Display control
		$params->def( 'other_cat', 			1 );
		$params->def( 'cat_description', 	1 );
		$params->def( 'cat_items', 			1 );
		// Table Display control
		$params->def( 'headings', 			1 );
		$params->def( 'name',				1 );
		$params->def( 'articles', 			1 );
		$params->def( 'link', 				1 );
		// pagination parameters
		$params->def('display', 			1 );
		$params->def('display_num', 		$mainframe->getCfg('list_limit'));

		// Set page title per category
		$document->setTitle( $menu->name. ' - ' .$category->name );

		// Add breadcrumb item per category
		$pathway->addItem($category->name, '');

		//create pagination
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);

		$k = 0;
		for($i = 0; $i <  count($items); $i++)
		{
			$item =& $items[$i];

			$item->link =  sefRelToAbs('index.php?option=com_newsfeeds&amp;view=newsfeed&amp;feedid='. $item->id .'&amp;Itemid='. $Itemid);

			$item->odd		= $k;
			$item->count	= $i;
			$k = 1 - $k;
		}

		// Define image tag attributes
		if (!empty ($category->image))
		{
			$attribs['align'] = '"'.$category->image_position.'"';
			$attribs['hspace'] = '"6"';

			// Use the static HTML library to build the image tag
			$image = JHTML::Image('/images/stories/'.$category->image, JText::_('NEWS_FEEDS'), $attribs);
		}

		$this->assignRef('image',		$image);
		$this->assignRef('params',		$params);
		$this->assignRef('items',		$items);
		$this->assignRef('category',	$category);
		$this->assignRef('pagination',	$pagination);

		parent::display($tpl);
	}
}
?>