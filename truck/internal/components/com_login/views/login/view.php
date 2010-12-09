<?php
/**
* @version		$Id: view.php 6138 2007-01-02 03:44:18Z eddiea $
* @package		Joomla
* @subpackage	Login
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

jimport( 'joomla.application.component.view');

/**
 * Login component HTML view class
 *
 * @package		Joomla
 * @subpackage	Users
 * @since	1.0
 */
class LoginViewLogin extends JView
{
	function display($tpl = null)
	{
		$errors =& JError::getErrors();

		// Build login image if enabled
		if ( $this->params->get( 'image_'.$this->type ) != -1 ) {
			$image = 'images/stories/'. $this->params->get( 'image_'.$this->type );
			$this->image = '<img src="'. $image  .'" align="'. $this->params->get( 'image_'.$this->type.'_align' ) .'" hspace="10" alt="" />';
		}

		parent::display($tpl);
	}
}
?>