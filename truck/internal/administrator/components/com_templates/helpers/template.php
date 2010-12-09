<?php
/**
 * @version		$Id: helper.php 5369 2006-10-08 00:36:33Z Jinx $
 * @package		Joomla
 * @subpackage	Templates
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

/**
 *
 */
class TemplatesHelper
{
	function isTemplateDefault($template, $clientId)
	{
		$db =& JFactory::getDBO();

		// Get the current default template
		$query = "SELECT template" .
				"\n FROM #__templates_menu" .
				"\n WHERE client_id = $clientId" .
				"\n AND menuid = 0";
		$db->setQuery($query);
		$defaultemplate = $db->loadResult();

		return $defaultemplate == $template ? 1 : 0;
	}

	function isTemplateAssigned($template)
	{
		$db =& JFactory::getDBO();

		// check if template is assigned
		$query = "SELECT COUNT(*)" .
				"\n FROM #__templates_menu" .
				"\n WHERE client_id = 0" .
				"\n AND template = '$template'" .
				"\n AND menuid <> 0";
		$db->setQuery($query);
		return $db->loadResult() ? 1 : 0;
	}

	function parseXMLTemplateFiles($templateBaseDir)
	{
		// Read the template folder to find templates
		jimport('joomla.filesystem.folder');
		$templateDirs = JFolder::folders($templateBaseDir);

		$rows = array();

		// Check that the directory contains an xml file
		foreach ($templateDirs as $templateDir)
		{
			if(!$data = TemplatesHelper::parseXMLTemplateFile($templateBaseDir, $templateDir)){
				continue;
			} else {
				$rows[] = $data;
			}
		}

		return $rows;
	}

	function parseXMLTemplateFile($templateBaseDir, $templateDir)
	{
		// Check of the xml file exists
		if(!is_file($templateBaseDir.DS.$templateDir.DS.'templateDetails.xml')) {
			return false;
		}

		$xml = JApplicationHelper::parseXMLInstallFile($templateBaseDir.DS.$templateDir.DS.'templateDetails.xml');

		if ($xml['type'] != 'template') {
			return false;
		}

		$data = new StdClass();
		$data->directory = $templateDir;

		foreach($xml as $key => $value) {
			$data->$key = $value;
		}

		$data->checked_out = 0;
		$data->mosname = JString::strtolower(str_replace(' ', '_', $data->name));

		return $data;
	}

	function createMenuList($template)
	{
		$db =& JFactory::getDBO();

		// get selected pages for $menulist
		$query = "SELECT menuid AS value" .
				"\n FROM #__templates_menu" .
				"\n WHERE client_id = 0" .
				"\n AND template = '$template'";
		$db->setQuery($query);
		$lookup = $db->loadObjectList();
		if (empty( $lookup )) {
			$lookup = array( JHTMLSelect::option( '-1' ) );
		}

		// build the html select list
		$options	= JAdminMenus::MenuLinkOptions();
		$result		= JHTMLSelect::genericList( $options, 'selections[]', 'class="inputbox" size="15" multiple="multiple"', 'value', 'text', $lookup, 'selections' );
		return $result;
	}
}
?>