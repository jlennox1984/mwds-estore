<?php
/**
* @version		$Id: toolbar.templates.html.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Templates
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
* @subpackage	Templates
*/
class TOOLBAR_templates
{
	function _DEFAULT(&$client)
	{
		JMenuBar::title( JText::_( 'Template Manager' ), 'thememanager' );

		if ($client->id == '1') {
			JMenuBar::makeDefault('publish');
		} else {
			JMenuBar::makeDefault();
		}
		JMenuBar::editListX( 'edit', 'Edit' );
		//JMenuBar::addNew();
		JMenuBar::help( 'screen.templates' );
	}
 	function _VIEW(&$client){

		JMenuBar::title( JText::_( 'Template Manager' ), 'thememanager' );
		JMenuBar::back();
	}

	function _EDIT_SOURCE(&$client){

		JMenuBar::title( JText::_( 'Template HTML Editor' ), 'thememanager' );
		JMenuBar::save( 'save_source' );
		JMenuBar::apply( 'apply_source' );
		JMenuBar::cancel();
		JMenuBar::help( 'screen.templates' );
	}

	function _EDIT(&$client){

		JMenuBar::title( JText::_( 'Template Parameters' ), 'thememanager' );
		JMenuBar::custom('preview', 'preview.png', 'preview_f2.png', 'Preview', false, false);
		JMenuBar::custom( 'edit_source', 'html.png', 'html_f2.png', 'Edit HTML', false, false );
		JMenuBar::custom( 'choose_css', 'css.png', 'css_f2.png', 'Edit CSS', false, false );
		JMenuBar::save( 'save' );
		JMenuBar::apply();
		JMenuBar::cancel( 'cancel', 'Close' );
		JMenuBar::help( 'screen.templates' );
	}

	function _CHOOSE_CSS(&$client){
		JMenuBar::title( JText::_( 'Template CSS Editor' ), 'thememanager' );
		JMenuBar::custom( 'edit_css', 'edit.png', 'edit_f2.png', 'Edit', true );
		JMenuBar::cancel();
		JMenuBar::help( 'screen.templates' );
	}

	function _EDIT_CSS(&$client){
		JMenuBar::title( JText::_( 'Template Manager' ), 'thememanager' );
		JMenuBar::save( 'save_css' );
		JMenuBar::apply( 'apply_css');
		JMenuBar::cancel();
		JMenuBar::help( 'screen.templates' );
	}

	function _POSITIONS(){
		JMenuBar::title( JText::_( 'Module Positions' ), 'thememanager' );
		JMenuBar::save( 'save_positions' );
		JMenuBar::cancel();
		JMenuBar::help( 'screen.templates.modules' );
	}
}
?>