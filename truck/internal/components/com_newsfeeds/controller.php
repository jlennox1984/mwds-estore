<?php
/**
 * @version		$Id: controller.php 5379 2006-10-09 22:39:40Z Jinx $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

jimport('joomla.application.component.controller');

/**
 * Newsfeeds Component Controller
 *
 * @package		Joomla
 * @subpackage	Newsfeeds
 * @since 1.5
 */
class NewsfeedsController extends JController
{
	/**
	 * Method to show a newsfeeds view
	 *
	 * @access	public
	 * @since	1.5
	 */
	function display()
	{
		$viewName	= JRequest::getVar( 'view', 'categories' );

		// interceptors to support legacy urls
		switch( $this->getTask())
		{
			//index.php?option=com_newsfeeds&task=x&catid=xid=x&Itemid=x
			case 'view':
			{
				$viewName	= 'newsfeed';
			} break;

			default:
			{
				if(JRequest::getVar( 'catid', 0)) {
					$viewName = 'category';
				}
			}
		}

		JRequest::setVar('view', $viewName);

		parent::display();

	}
}

?>