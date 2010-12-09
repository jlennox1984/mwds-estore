<?php
/**
* @version		$Id: html.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Installation
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

/**
 * @package		Joomla
 * @subpackage	Installation
 */
class JInstallationView
{
	/**
	 * Static method to create the template object
	 * @param string The name of the body html file
	 * @return patTemplate
	 */
	function &createTemplate( $bodyHtml = null )
	{
		jimport('joomla.template.template');

		$tmpl = new JTemplate();
		$tmpl->applyInputFilter('ShortModifiers');

		// load the wrapper and common templates
		$tmpl->setRoot( JPATH_BASE . DS . 'template' . DS. 'tmpl' );
		$tmpl->readTemplatesFromFile( 'page.html' );

		if ($bodyHtml) {
			$tmpl->setAttribute( 'body', 'src', $bodyHtml );
		}

		return $tmpl;
	}

	/**
	 * Shows an error message and back link
	 * @param array Vars to add to the error form
	 * @param mixed A string or array of messages
	 * @param string The name of the step to go back to
	 * @param string An extra message to display in a text area
	 */
	function error( &$vars, $msg, $back, $xmsg='' )
	{
		global $steps;

		$lang =& JFactory::getLanguage();

		$tmpl =& JInstallationView::createTemplate( 'error.html' );

		$tmpl->addVars( 'stepbar', $steps, 		'step_' );
		$tmpl->addVar( 'messages', 'message', 	$msg );

		if ($xmsg) {
			$tmpl->addVar( 'xmessages', 'xmessage', $xmsg );
		}

		$tmpl->addVar( 'buttons', 'back', $back );
		$tmpl->addVars( 'body', $vars, 'var_' );

		$tmpl->addVar( 'buttons', 'direction', $lang->isRTL() ? 'rtl' : 'ltr');

		$retval = $tmpl->fetch( 'page' );
		return $retval;
	}

	/**
	 * The language selection page
	 * @param array An array of lists
	 */
	function chooseLanguage( &$lists )
	{
		global $steps;

		$lang	=& JFactory::getLanguage();
		$tmpl	=& JInstallationView::createTemplate( 'language.html' );

		$steps['lang'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );
		$tmpl->addRows( 'lang-options', $lists['langs'] );

		$tmpl->addVar( 'buttons', 'direction', $lang->isRTL() ? 'rtl' : 'ltr');

		return $tmpl->fetch( 'page' );
	}

	/**
	 * The the pre-install info page
	 * @param array An array of lists
	 */
	function preInstall( $vars, &$lists )
	{
		global $steps;

		$lang		=& JFactory::getLanguage();
		$version	= new JVersion();
		$tmpl		=& JInstallationView::createTemplate( 'preinstall.html' );

		$steps['preinstall'] = 'on';

		$tmpl->addVars( 'stepbar', 	$steps, 	'step_' );
		$tmpl->addVar( 'body', 		'version', 	$version->getLongVersion() );
		$tmpl->addVars( 'body', 	$vars, 		'var_' );

		$tmpl->addVar( 'php-options', 'align', $lang->isRTL() ? 'right' : 'left');
		$tmpl->addRows( 'php-options', 	$lists['phpOptions'] );
		$tmpl->addRows( 'php-settings', $lists['phpSettings'] );

		$tmpl->addVar( 'buttons', 'direction', $lang->isRTL() ? 'rtl' : 'ltr');

		return $tmpl->fetch( 'page' );
	}

	/**
	 * The license page
	 * @param array An array of lists
	 */
	function license( &$vars )
	{
		global $steps;

		$lang =& JFactory::getLanguage();

		$tmpl =& JInstallationView::createTemplate( 'license.html' );

		$steps['license'] = 'on';

		$tmpl->addVars( 'stepbar', 	$steps, 'step_' );
		$tmpl->addVars( 'body', 	$vars, 	'var_' );
		$tmpl->addVar( 'buttons', 'direction', $lang->isRTL() ? 'rtl' : 'ltr');

		return $tmpl->fetch( 'page' );
	}

	/**
	 * The database configuration page
	 * @param array An array of lists
	 */
	function dbConfig( &$vars, &$lists )
	{
		global $steps;

		$lang =& JFactory::getLanguage();

		$tmpl =& JInstallationView::createTemplate( 'dbconfig.html' );

		$steps['dbconfig'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );
		$tmpl->addVars( 'body', 	$vars, 'var_' );
		$tmpl->addVar( 'buttons', 'direction', $lang->isRTL() ? 'rtl' : 'ltr');
		$tmpl->addRows( 'dbtype-options', $lists['dbTypes'] );

		return $tmpl->fetch( 'page' );
	}


	/**
	 * The ftp configuration page
	 * @param array An array of lists
	 */
	function ftpConfig( &$vars )
	{
		global $steps;

		$lang =& JFactory::getLanguage();

		$tmpl =& JInstallationView::createTemplate( 'ftpconfig.html' );

		$steps['ftpconfig'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );
		$tmpl->addVars( 'body', 	$vars, 'var_' );
		$tmpl->addVar( 'buttons', 'direction', $lang->isRTL() ? 'rtl' : 'ltr');

		return $tmpl->fetch( 'page' );
	}

	/**
	 * The main configuration page
	 * @param array An array of lists
	 */
	function mainConfig( &$vars )
	{
		global $steps;

		$lang =& JFactory::getLanguage();

		$tmpl =& JInstallationView::createTemplate( 'mainconfig.html' );

		$steps['mainconfig'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );
		$tmpl->addVars( 'body', 	$vars, 'var_' );
		$tmpl->addVar( 'buttons', 'direction', $lang->isRTL() ? 'rtl' : 'ltr');
		$tmpl->addVar( 'buttons', 'previous', JUtility::isWinOS() ? 'dbconfig' : 'ftpconfig');
//		$tmpl->addRows( 'folder-perms', $lists['folderPerms'] );

		/*
		 * prepare migration encoding selection
		 */
		$encodings = array( 'iso-8859-1','iso-8859-2','iso-8859-3','iso-8859-4','iso-8859-5','iso-8859-6','iso-8859-7','iso-8859-8','iso-8859-9','iso-8859-10','iso-8859-13','iso-8859-14','iso-8859-15','cp874','windows-1250','windows-1251','windows-1252','windows-1253','windows-1254','windows-1255','windows-1256','windows-1257','windows-1258','utf-8','big5','euc-jp','euc-kr','euc-tw','iso-2022-cn','iso-2022-jp-2','iso-2022-jp','iso-2022-kr','iso-10646-ucs-2','iso-10646-ucs-4','koi8-r','koi8-ru','ucs2-internal','ucs4-internal','unicode-1-1-utf-7','us-ascii','utf-16' );
		$tmpl->addVar( 'encoding_options', 'value', $encodings );
		return $tmpl->fetch( 'page' );
	}

	/**
	 * The finish page for the installer
	 * @param array An array of lists
	 * @param string The configuration file if it could not be saved
	 */
	function finish( &$vars, $buffer )
	{
		global $steps;

		$lang	=& JFactory::getLanguage();
		$tmpl	=& JInstallationView::createTemplate( 'finish.html' );

		$steps['finish'] = 'on';

		$tmpl->addVars( 'stepbar', $steps, 'step_' );
		$tmpl->addVars( 'body', 	$vars, 'var_' );
		$tmpl->addVar( 'buttons', 'direction', $lang->isRTL() ? 'rtl' : 'ltr');

		if ($buffer) {
			$tmpl->addVar( 'configuration-error', 'buffer', $buffer );
		}

		return $tmpl->fetch( 'page' );
	}
}
?>