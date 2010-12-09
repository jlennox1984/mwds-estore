<?php
/**
 * @version		$Id: controller.php 6138 2007-01-02 03:44:18Z eddiea $
 * @package  Joomla
 * @subpackage	Banners
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights
 * reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

jimport( 'joomla.application.component.controller' );

class BannersController extends JController
{
	function click()
	{
		$bid = JRequest::getVar( 'bid', 0, '', 'int' );
		if ($bid)
		{
			$model = &$this->getModel( 'Banner' );
			$model->click( $bid );
			$this->setRedirect( $model->getUrl( $bid ) );
		}
	}
}
?>