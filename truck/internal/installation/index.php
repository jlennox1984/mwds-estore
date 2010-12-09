<?php
/**
* @version		$Id: index.php 6215 2007-01-08 17:56:21Z louis $
* @package		Joomla
* @subpackage	Installation
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software and parts of it may contain or be derived from the
* GNU General Public License or other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

define( '_JEXEC', 1 );

define( 'JPATH_BASE', dirname( __FILE__ ) );

require_once( JPATH_BASE .'/includes/defines.php' );
require_once( JPATH_BASE .'/includes/application.php' );


// create the mainframe object
$mainframe = new JInstallation();

// create the session
$mainframe->loadSession('installation');

// get a recursively slash stripped version of post
$post		= (array) JRequest::get( 'post' );
$postVars	= JArrayHelper::getValue( $post, 'vars', array(), 'array' );

$session	=& JFactory::getSession();
$registry	=& $session->get('registry');
$registry->loadArray($postVars, 'application');

$configLang = $mainframe->getUserState('application.lang');

$mainframe->initialise(array('language' => $configLang));

// load the language
$lang =& JFactory::getLanguage();
$lang->_load( JPATH_BASE.DS.'language'.DS.$configLang.DS.$configLang.'.ini' );

$task	= JRequest::getVar( 'task' );
$vars	= $registry->toArray('application');
$result	= '';

switch ($task)
{
	case 'preinstall':
		$result = JInstallationController::preInstall($vars);
		break;

	case 'license':
		$result = JInstallationController::license($vars);
		break;

	case 'dbconfig':
		$result = JInstallationController::dbConfig($vars);
		break;

	case 'dbcollation':
		$result = JInstallationController::dbCollation($vars);
		break;

	case 'makedb':
		$result = JInstallationController::makeDB($vars);
		// continue to ftpConfig only on true token otherwise display messages
		if ($result === true) {
			// if on Windows OS skip ftpconfig
			if ( JUtility::isWinOS() ) {
				$vars['ftpEnable'] = '0';
				$result = JInstallationController::mainConfig($vars);
			} else {
				$result = JInstallationController::ftpConfig($vars, 1);
			}
		}
		break;

	case 'ftpconfig':
		$result = JInstallationController::ftpConfig($vars);
		break;

	case 'mainconfig':
		$result = JInstallationController::mainConfig($vars);
		break;

	case 'saveconfig':
		$buffer = JInstallationController::saveConfig($vars);
		$result = JInstallationController::finish( $vars, $buffer );
		break;

	case 'lang':
	default:
		$result = JInstallationController::chooseLanguage($vars);
		break;
}

$params = array(
	'template' 	=> 'template',
	'file'		=> 'index.php',
	'directory' => JPATH_BASE
);

$document =& JFactory::getDocument();
$document->setBuffer( $result, 'installation');
$document->setTitle(JText::_('PAGE_TITLE'));
$document->display( false, $params);

/**
 * RETURN THE RESPONSE
 */
echo JResponse::toString();
?>