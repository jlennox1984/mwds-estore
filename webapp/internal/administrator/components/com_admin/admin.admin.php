<?php
/**
* @version		$Id: admin.admin.php 6239 2007-01-10 10:30:39Z louis $
* @package		Joomla
* @subpackage	Admin
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
require_once( JApplicationHelper::getPath( 'admin_html' ) );

switch ($task) {

	case 'redirect':
		$goto = trim( JString::strtolower( JRequest::getVar( 'link' ) ) );
		if ($goto == 'null') {
			$msg = JText::_( 'There is no link associated with this item' );
			$mainframe->redirect( 'index.php?option=com_admin&task=listcomponents', $msg );
			$mainframe->close();
		}
		$goto = str_replace( "'", '', $goto );
		$mainframe->redirect( $goto );
		break;

	case 'listcomponents':
		HTML_admin_misc::ListComponents();
		break;

	case 'sysinfo':
		HTML_admin_misc::system_info( );
		break;

	case 'changelog':
		HTML_admin_misc::changelog();
		break;

	case 'help':
		HTML_admin_misc::help();
		break;

	case 'version':
		HTML_admin_misc::version();
		break;

	case 'preview':
		HTML_admin_misc::preview();
		break;

	case 'preview2':
		HTML_admin_misc::preview( 1 );
		break;

	case 'keepalive':
		return;
		break;

	case 'cpanel':
	default:
		HTML_admin_misc::controlPanel();
		break;
}
?>