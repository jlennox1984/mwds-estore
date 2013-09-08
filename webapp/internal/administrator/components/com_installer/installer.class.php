<?php
/**
* @version		$Id: installer.class.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Installer
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

jimport('joomla.installer.installer');

/**
 * Legacy class, use JInstaller instead
 * @deprecated As of version 1.5
 */
class mosInstaller extends JInstaller
{
	function __construct() {
		parent::__construct();
	}
}

/**
 * Legacy function, use JFolder::delete($path)
 *
 * @deprecated	As of version 1.5
 */
function deldir( $dir )
{
	$current_dir = opendir( $dir );
	$old_umask = umask(0);
	while ($entryname = readdir( $current_dir )) {
		if ($entryname != '.' and $entryname != '..') {
			if (is_dir( $dir . $entryname )) {
				deldir( mosPathName( $dir . $entryname ) );
			} else {
				@chmod($dir . $entryname, 0777);
				unlink( $dir . $entryname );
			}
		}
	}
	umask($old_umask);
	closedir( $current_dir );
	return rmdir( $dir );
}
?>