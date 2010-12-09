<?php
/**
* @version		$Id: helper.php 6138 2007-01-02 03:44:18Z eddiea $
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

class modBreadCrumbsHelper
{
	function getList(&$params)
	{
		global $mainframe, $option;

		// Initialize variables
		$showHome 		= true;
		$showComponent	= true;

		// Show the home link in the breadcrumbs
		if ($params->get('showHome') == false) {
			$showHome = false;
		}

		// Show the component link in the breadcrumbs
		if ($params->get('showComponent') == false) {
			$showComponent = false;
		}

		// Do not show the content component item in the BreadCrumbs list
		if ($option == 'com_content') {
			$showComponent = false;
		}

		// Get the PathWay object from the application
		$pathway = & $mainframe->getPathWay();
		$items = $pathway->getPathWay($showHome, $showComponent);

		$count = count($items);
		for ($i = 0; $i < $count; $i ++)
		{
			if (($showHome) && ($i == 0)) {
				$items[$i]->name = $params->get('homeText');
			}
			$items[$i]->name = stripslashes(ampReplace($items[$i]->name));

			// If a link is present create an html link, if not just use the name
			if (empty ($items[$i]->link) || $count == $i +1) {
				$items[$i]->link = $items[$i]->name;
			} else {
				$items[$i]->link = '<a href="'.JURI::resolve($items[$i]->link).'" class="pathway">'.$items[$i]->name.'</a>';
			}
		}

		return $items;
	}

	/**
 	 * Set the breadcrumbs separator for the breadcrumbs display.
 	 *
 	 * @param	string	$custom	Custom xhtml complient string to separate the
 	 * items of the breadcrumbs
 	 * @return	string	Separator string
 	 * @since	1.5
 	 */
	function setSeparator($custom = null)
	{
		global $mainframe;

		/**
	 	* If a custom separator has not been provided we try to load a template
	 	* specific one first, and if that is not present we load the default separator
	 	*/
		if ($custom == null)
		{
			// Set path for what would be a template specific separator
			$tSepPath = 'templates/'.$mainframe->getTemplate().'/images/arrow.png';

			// Check to see if the template specific separator exists and if so, set it
			if (is_file(JPATH_SITE."/$tSepPath")) {
				$_separator = '<img src="'.$tSepPath.'" border="0" alt="arrow" />';
			}
			else
			{
				// Template specific separator does not exist, use the default separator
				$dSepPath = '/images/M_images/arrow.png';

				// Check to make sure the default separator exists
				if (is_file(JPATH_SITE.$dSepPath)) {
					$_separator = '<img src="images/M_images/arrow.png" alt="arrow" />';
				}
				else {
					// The default separator does not exist either ... just use a bracket
					$_separator = '&gt;';
				}
			}
		}
		else
		{
			$_separator = $custom;
		}
		return $_separator;
	}
}