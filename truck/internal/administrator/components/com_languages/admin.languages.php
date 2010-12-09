<?php
/**
* @version		$Id: admin.languages.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Languages
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

/*
 * Make sure the user is authorized to view this page
 */
$user = & JFactory::getUser();
if (!$user->authorize( 'com_languages', 'manage' )) {
	$mainframe->redirect( 'index.php', JText::_('ALERTNOTAUTH') );
}

require_once( JApplicationHelper::getPath( 'admin_html' ) );

$task 	= trim( strtolower( JRequest::getVar( 'task' ) ) );
$cid 	= JRequest::getVar( 'cid', array(0), '', 'array' );

if (!is_array( $cid )) {
	$cid = array(0);
}

switch ($task)
{
	case 'publish':
		publishLanguage( $cid[0]);
		break;

	default:
		viewLanguages();
		break;
}

/**
* Compiles a list of installed languages
*/
function viewLanguages()
{
	global $mainframe, $option;

	// Initialize some variables
	$db		= & JFactory::getDBO();
	$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
	$rows	= array ();

	$limit		= $mainframe->getUserStateFromRequest("$option.limit", 'limit', $mainframe->getCfg('list_limit'), 0);
	$limitstart = $mainframe->getUserStateFromRequest( $option.'limitstart', 'limitstart', 0 );

	$rowid = 0;

	//load folder filesystem class
	jimport('joomla.filesystem.folder');
	$path = JLanguage::getLanguagePath($client->path);
	$dirs = JFolder::folders( $path );

	foreach ($dirs as $dir)
	{
		$files = JFolder::files( $path . $dir, '^([-_A-Za-z]*)\.xml$' );
		foreach ($files as $file)
		{
			$data = JApplicationHelper::parseXMLLangMetaFile($path.$dir.DS.$file);


			$row 			= new StdClass();
			$row->id 		= $rowid;
			$row->language 	= substr($file,0,-4);

			if (!is_array($data)) {
				continue;
			}
			foreach($data as $key => $value) {
				$row->$key = $value;
			}

			$lang = ($client->name == 'site') ? 'lang_site' : 'lang_'.$client->name;

			// if current than set published
			if ( $mainframe->getCfg($lang) == $row->language) {
				$row->published	= 1;
			} else {
				$row->published = 0;
			}

			$row->checked_out = 0;
			$row->mosname = JString::strtolower( str_replace( " ", "_", $row->name ) );
			$rows[] = $row;
			$rowid++;
		}
	}


	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $rowid, $limitstart, $limit );

	$rows = array_slice( $rows, $pageNav->limitstart, $pageNav->limit );

	HTML_languages::showLanguages( $rows, $pageNav, $option, $client );
}

/**
* Publish, or make current, the selected language
*/
//function publishLanguage( $language, $option )
function publishLanguage( $language )
{
	global $mainframe;

	/*
	 * Initialize some variables
	 */
	$client	= JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

	$varname = ($client->id == 0) ? 'lang_site' : 'lang_administrator';

	$config =& JFactory::getConfig();
	$config->setValue('config.'.$varname, $language);

	// Get the path of the configuration file
	$fname = JPATH_CONFIGURATION.'/configuration.php';

	/*
	 * Now we get the config registry in PHP class format and write it to
	 * configuation.php then redirect appropriately.
	 */
	jimport('joomla.filesystem.file');
	if (JFile::write($fname, $config->toString('PHP', 'config',  array('class' => 'JConfig')))) {
		$mainframe->redirect("index.php?option=com_languages&amp;client=".$client->id,JText::_( 'Configuration successfully updated!' ) );
	} else {
		$mainframe->redirect("index.php?option=com_languages&amp;client=".$client->id,JText::_( 'ERRORCONFIGWRITEABLE' ) );
	}
}
?>
