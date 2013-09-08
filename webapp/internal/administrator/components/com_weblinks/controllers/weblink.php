<?php
/**
 * @version		$Id: weblink.php 6246 2007-01-10 21:58:24Z hackwar $
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

/**
 * Weblinks Weblink Controller
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class WeblinksControllerWeblink extends WeblinksController
{
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
		$this->registerTask( 'apply', 	'save' );
		$this->registerTask( 'apply_new', 'save' );
	}

	function edit()
	{
		JRequest::setVar( 'view', 'weblink' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();

		// Checkin the weblink
		$model = $this->getModel('weblink');
		$model->checkout();
	}

	function save()
	{
		$post	= JRequest::get('post');
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = $cid[0];

		$model = $this->getModel('weblink');

		if ($model->store($post)) {
			$msg = JText::_( 'Weblink Saved' );
		} else {
			$msg = JText::_( 'Error Saving Weblink' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();

		switch (JRequest::getVar('task'))
		{
			case 'apply':
				$link = 'index.php?option=com_weblinks&controller=weblink&task=edit&cid[]='. $post['id'];
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_weblinks';
				break;
		}

		$this->setRedirect($link, $msg);
	}

	function remove()
	{
		global $mainframe;

		$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel('weblink');
		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_weblinks' );
	}


	function publish()
	{
		global $mainframe;

		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('weblink');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_weblinks' );
	}


	function unpublish()
	{
		global $mainframe;

		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );

		if (!is_array( $cid ) || count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('weblink');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_weblinks' );
	}

	function cancel()
	{
		// Checkin the weblink
		$model = $this->getModel('weblink');
		$model->checkin();

		$this->setRedirect( 'index.php?option=com_weblinks' );
	}


	function orderup()
	{
		$model = $this->getModel('weblink');
		$model->move(-1);

		$this->setRedirect( 'index.php?option=com_weblinks');
	}

	function orderdown()
	{
		$model = $this->getModel('weblink');
		$model->move(1);

		$this->setRedirect( 'index.php?option=com_weblinks');
	}

	function saveorder()
	{
		$cid 	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(0), 'post', 'array' );

		$model = $this->getModel('weblink');
		$model->saveorder($cid, $order);

		$msg = 'New ordering saved';
		$this->setRedirect( 'index.php?option=com_weblinks', $msg );
	}
}
?>