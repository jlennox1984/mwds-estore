<?php
/**
 * @version		$Id: components.php 6138 2007-01-02 03:44:18Z eddiea $
 * @package		Joomla
 * @subpackage	Menus
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights
 * reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Import library dependencies
require_once(dirname(__FILE__).DS.'extension.php');

/**
 * Installer Components Model
 *
 * @author		Louis Landry <louis.landry@joomla.org>
 * @package		Joomla
 * @subpackage	Installer
 * @since		1.5
 */
class InstallerModelComponents extends InstallerModel
{
	/**
	 * Extension Type
	 * @var	string
	 */
	var $_type = 'component';

	/**
	 * Enable a component
	 *
	 * @static
	 * @return boolean True on success
	 * @since 1.0
	 */
	function enable($eid=array())
	{
		// Initialize variables
		$result	= false;

		/*
		 * Ensure eid is an array of extension ids
		 * TODO: If it isn't an array do we want to set an error and fail?
		 */
		if (!is_array($eid)) {
			$eid = array ($eid);
		}

		// Get a database connector
		$db =& JFactory::getDBO();

		// Get a table object for the extension type
		$table = & JTable::getInstance($this->_type);

		// Enable the extension in the table and store it in the database
		foreach ($eid as $id)
		{
			$table->load($id);
			$table->enabled = '1';
			$result |= $table->store();
		}

		return $result;
	}

	/**
	 * Disable a component
	 *
	 * @return boolean True on success
	 * @since 1.5
	 */
	function disable($eid=array())
	{
		// Initialize variables
		$result		= false;

		/*
		 * Ensure eid is an array of extension ids
		 * TODO: If it isn't an array do we want to set an error and fail?
		 */
		if (!is_array($eid)) {
			$eid = array ($eid);
		}

		// Get a database connector
		$db =& JFactory::getDBO();

		// Get a table object for the extension type
		$table = & JTable::getInstance($this->_type);

		// Disable the extension in the table and store it in the database
		foreach ($eid as $id)
		{
			$table->load($id);
			$table->enabled = '0';
			$result |= $table->store();
		}

		return $result;
	}

	function _loadItems()
	{
		global $mainframe, $option;

		/* Get a database connector */
		$db =& JFactory::getDBO();

		$query = "SELECT *" .
				"\n FROM #__components" .
				"\n WHERE parent = 0" .
				"\n ORDER BY iscore, name";
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		/* Get the component base directory */
		$baseDir = JPATH_ADMINISTRATOR .DS. 'components';

		$numRows = count($rows);
		for($i=0;$i < $numRows; $i++)
		{
			$row =& $rows[$i];

			 /* Get the component folder and list of xml files in folder */
			jimport('joomla.filesystem.folder');
			$folder = $baseDir.DS.$row->option;
			if (JFolder::exists($folder)) {
				$xmlFilesInDir = JFolder::files($folder, '.xml$');
			} else {
				$xmlFilesInDir = null;
			}

			if (count($xmlFilesInDir)) {
				foreach ($xmlFilesInDir as $xmlfile)
				{
					if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
						foreach($data as $key => $value) {
							$row->$key = $value;
						}
					}
					$row->jname = JString::strtolower(str_replace(" ", "_", $row->name));
				}
			}
		}
		$this->setState('pagination.total', $numRows);
		$this->_items = array_slice( $rows, $this->_state->get('pagination.offset'), $this->_state->get('pagination.limit') );
	}
}
?>