<?php
/**
* @version		$Id: view.php 6268 2007-01-12 23:22:44Z louis $
* @package		Joomla
* @subpackage	Config
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
* @subpackage	Config
*/
class ConfigApplicationView
{
	function showConfig( &$row, &$lists )
	{
		global $mainframe;

		// Load tooltips behavior
		jimport('joomla.html.tooltips');

		$table =& JTable::getInstance('component');
		$table->loadByOption( 'com_users' );
		$userparams = new JParameter( $table->params, JPATH_ADMINISTRATOR . '/components/com_users/config.xml' );

		$table->loadByOption( 'com_media' );
		$mediaparams = new JParameter( $table->params, JPATH_ADMINISTRATOR . '/components/com_media/config.xml' );
		$contents = '';
		ob_start();
			require_once(dirname(__FILE__).DS.'tmpl'.DS.'navigation.php');
		$contents = ob_get_contents();
		ob_end_clean();

		// Set document data
		$document =& JFactory::getDocument();
		$document->addScript(JURI::base().'components/com_config/assets/switcher.js');

		$document->setBuffer($contents, 'module', 'submenu');
		?>
		<form action="index.php" method="post" name="adminForm">

		<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'writeable.php'); ?>

		<div id="config-document">
			<div id="page-site">
				<table class="noshow">
					<tr>
						<td with="65%">
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_site.php'); ?>
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_metadata.php'); ?>
						</td>
						<td width="35%">

							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_seo.php'); ?>
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_feeds.php'); ?>
						</td>
					</tr>
				</table>
			</div>
			<div id="page-system">
				<table class="noshow">
					<tr>
						<td with="60%">
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_system.php'); ?>
							<fieldset class="adminform">
								<legend><?php echo JText::_( 'User Settings' ); ?></legend>
								<?php echo $userparams->render('userparams'); ?>
							</fieldset>
							<fieldset class="adminform">
								<legend><?php echo JText::_( 'Media Settings' ); ?></legend>
								<?php echo $mediaparams->render('mediaparams'); ?>
							</fieldset>
						</td>
						<td with="40%">
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_debug.php'); ?>
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_statistics.php'); ?>
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_cache.php'); ?>
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_session.php'); ?>
						</td>
					</td>
					</tr>
				</table>
			</div>
			<div id="page-server">
				<table class="noshow">
					<tr>
						<td with="60%">
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_server.php'); ?>
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_locale.php'); ?>
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS. (JUtility::isWinOS() ? 'config_noftp.php':'config_ftp.php')); ?>
						</td>
						<td width="40%">
							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_database.php'); ?>

							<?php require_once(dirname(__FILE__).DS.'tmpl'.DS.'config_mail.php'); ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="clr"></div>

		<input type="hidden" name="c" value="global" />
		<input type="hidden" name="option" value="com_config" />
		<input type="hidden" name="secret" value="<?php echo $row->secret; ?>" />
		<input type="hidden" name="lang_site" value="<?php echo $row->lang_site; ?>" />
		<input type="hidden" name="lang_administrator" value="<?php echo $row->lang_administrator; ?>" />
		<input type="hidden" name="task" value="" />
		</form>
		<?php
	}

	function WarningIcon()
	{
		global $mainframe;

		$url = $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();
		$tip = '<img src="'.$url.'includes/js/ThemeOffice/warning.png" border="0"  alt="" />';

		return $tip;
	}
}
?>
