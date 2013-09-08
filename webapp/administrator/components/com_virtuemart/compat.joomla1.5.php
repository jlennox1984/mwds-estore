<?php 
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) {
	die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
}
/**
* This file provides compatibility for VirtueMart on Joomla! 1.0.x and Joomla! 1.5
*
*
* @version $Id: compat.joomla1.5.php 694 2007-02-21 11:42:48Z soeren_nb $
* @package VirtueMart
* @subpackage core
* @copyright Copyright (C) 2004-2005 Soeren Eberhardt. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/
if( class_exists('jconfig')) {
	$usersConfig = &JComponentHelper::getParams( 'com_users' );
	$contentConfig = &JComponentHelper::getParams( 'com_content' );	
	
	$jconfig = new jconfig();
	$mosConfig_live_site = $jconfig->live_site;
	$mosConfig_absolute_path = $jconfig->absolute_path;
	$mosConfig_host = $jconfig->host;
	$mosConfig_user = $jconfig->user;
	$mosConfig_password = $jconfig->password;
	$mosConfig_db = $jconfig->db;
	$mosConfig_dbprefix = $jconfig->dbprefix;
	$mosConfig_mailer = $jconfig->mailer;
	$mosConfig_mailfrom = $jconfig->mailfrom;
	$mosConfig_fromname = $jconfig->fromname;
	$mosConfig_sendmail = $jconfig->sendmail;
	$mosConfig_smtpauth = $jconfig->smtpauth;
	$mosConfig_smtpuser = $jconfig->smtpuser;
	$mosConfig_smtppass = $jconfig->smtppass;
	$mosConfig_smtphost = $jconfig->smtphost;
	$mosConfig_debug = $jconfig->debug;
	$mosConfig_caching = $jconfig->caching;
	$mosConfig_cachepath = $mosConfig_absolute_path.'/cache';
	$mosConfig_cachetime = $jconfig->cachetime;
	$mosConfig_secret = $jconfig->secret;
	$mosConfig_editor = $jconfig->editor;
	$mosConfig_offset = $jconfig->offset;
	$mosConfig_lifetime = $jconfig->lifetime;
	$mosConfig_sitename = $jconfig->sitename;
	$mosConfig_list_limit = $jconfig->list_limit;
	$mosConfig_gzip = $jconfig->gzip;
	$mosConfig_lang = $jconfig->lang;
	$mosConfig_allowUserRegistration = $usersConfig->get('allowUserRegistration');
	$mosConfig_useractivation = $usersConfig->get('useractivation');
	$mosConfig_sef = $jconfig->sef;
	$mosConfig_hidePdf = $contentConfig->get('hidePdf');
	$mosConfig_hidePrint = $contentConfig->get('hidePrint');
	$mosConfig_hideEmail = $contentConfig->get('hideEmail');
	$mosConfig_icons = $contentConfig->get('icons');
	if( class_exists( 'jversion' )) {
		$_VERSION = $GLOBALS['_VERSION'] = new JVersion();
	}
}
?>