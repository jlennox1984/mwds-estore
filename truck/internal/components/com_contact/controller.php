<?php
/**
 * @version		$Id: default.php 4724 2006-08-24 11:40:06Z eddiea $
 * @package		Joomla
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

jimport( 'joomla.application.component.controller' );

/**
 * Contact Component Controller
 *
 * @static
 * @package		Joomla
 * @subpackage	Contact
 * @since 1.5
 */
class ContactController extends JController
{
	/**
	 * Display the view
	 */
	function display()
	{

		$document =& JFactory::getDocument();

		$viewName	= JRequest::getVar('view', 'category');
		$viewType	= $document->getType();

		// interceptors to support legacy urls
		switch( $this->getTask())
		{
			//index.php?option=com_content&task=category&id=0&Itemid=4
			case 'category':
				$viewName	= 'category';
				$layout = 'default';
				break;
			case 'view':
				$viewName	= 'contact';
				$layout = 'default';
				break;
		}

		// Set the default view name from the Request
		$view = &$this->getView($viewName, $viewType);

		// Push a model into the view
		$model	= &$this->getModel( $viewName );
		if (!JError::isError( $model )) {
			$view->setModel( $model, true );
		}

		// Workaround for the item view
		if ($viewName == 'contact')
		{
			$modelCat	= &$this->getModel( 'category' );
			$view->setModel( $modelCat );
		}

		// Display the view
		$view->assign('error', $this->getError());
		$view->display();
	}

	/**
	 * Method to send an email to a contact
	 *
	 * @static
	 * @since 1.0
	 */
	function sendmail()
	{
		global $mainframe, $Itemid;
		
		//check the token before we do anything else
		$token	= JUtility::getToken();
		if(!JRequest::getVar( $token, 0, 'post' )) {
			JError::raiseError(403, 'Request Forbidden');
		} 

		// Initialize some variables
		$db			= & JFactory::getDBO();

		$SiteName 	= $mainframe->getCfg('sitename');
		$MailFrom 	= $mainframe->getCfg('mailfrom');
		$FromName 	= $mainframe->getCfg('fromname');

		$default 	= JText::sprintf('MAILENQUIRY', $SiteName);
		$contactId 	= JRequest::getVar('id', 			0, 			'post', 'int');
		$name 		= JRequest::getVar('name', 			'', 		'post');
		$email 		= JRequest::getVar('email', 		'', 		'post');
		$subject 	= JRequest::getVar('subject', 		$default, 	'post');
		$body 		= JRequest::getVar('text', 			'', 		'post');
		$emailCopy 	= JRequest::getVar('email_copy', 	0, 			'post', 'int');

		 // load the contact details
		$model		= &$this->getModel('contact');

		// query options
		$qOptions['id']	= $contactId;
		$contact		= $model->getContact( $qOptions );

		/*
		 * If there is no valid email address or message body then we throw an
		 * error and return false.
		 */
		jimport('joomla.utilities.mail');
		if (!$email || !$body || (JMailHelper::isEmailAddress($email) == false))
		{
			$this->setError(JText::_('CONTACT_FORM_NC'));
			$this->display();
			return false;
		}

		// input validation
		if  (!$this->_validateInputs( $email, $subject, $body ) ) {
			JError::raiseWarning( 0, $this->getError() );
			return false;
		}

		// Prepare email body
		$prefix = JText::sprintf('ENQUIRY_TEXT', JURI::base());
		$body 	= $prefix."\n".$name.' <'.$email.'>'."\r\n\r\n".stripslashes($body);

		$mail = new JMail();

		$mail->addRecipient( $contact->email_to );
		$mail->setSender( array( $email, $name ) );
		$mail->setSubject( $FromName.': '.$subject );
		$mail->setBody( $body );

		$sent = $mail->Send();

		/*
		 * If we are supposed to copy the admin, do so.
		 */
		// parameter check
		$menuParams 		= new JParameter( $contact->params );
		$emailcopyCheck = $menuParams->get( 'email_copy', 0 );

		// check whether email copy function activated
		if ( $emailCopy && $emailcopyCheck )
		{
			$copyText 		= JText::sprintf('Copy of:', $contact->name, $SiteName);
			$copyText 		.= "\r\n\r\n".$body;
			$copySubject 	= JText::_('Copy of:')." ".$subject;

			$mail = new JMail();

			$mail->addRecipient( $email );
			$mail->setSender( array( $MailFrom, $FromName ) );
			$mail->setSubject( $copySubject );
			$mail->setBody( $copyText );

			$sent = $mail->Send();
		}

		$this->setError( JText::_( 'Thank you for your e-mail'));
		$this->display();
	}

	/**
	 * Method to output a vCard
	 *
	 * @static
	 * @since 1.0
	 */
	function vcard()
	{
		global $mainframe;

		// Initialize some variables
		$db = & JFactory::getDBO();

		$SiteName = $mainframe->getCfg('sitename');
		$contactId = JRequest::getVar('contact_id', 0, '', 'int');

		// Get a Contact table object and load the selected contact details
		$contact =& JTable::getInstance('contact', 'Table');
		$contact->load($contactId);

		// Get the contact detail parameters
		$menuParams = new JParameter($contact->params);
		$show 	= $menuParams->get('vcard', 0);

		// Should we show the vcard?
		if ($show)
		{
			// Parse the contact name field and build the nam information for the vcard.
			$firstname 	= null;
			$middlename = null;
			$surname 	= null;

			// How many parts do we have?
			$parts = explode(' ', $contact->name);
			$count = count($parts);

			switch ($count) {
				case 1 :
					// only a first name
					$firstname = $parts[0];
					break;

				case 2 :
					// first and last name
					$firstname = $parts[0];
					$surname = $parts[1];
					break;

				default :
					// we have full name info
					$firstname = $parts[0];
					$surname = $parts[$count -1];
					for ($i = 1; $i < $count -1; $i ++) {
						$middlename .= $parts[$i].' ';
					}
					break;
			}
			// quick cleanup for the middlename value
			$middlename = trim($middlename);

			// Create a new vcard object and populate the fields
			require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_contact'.DS.'helpers'.DS.'vcard.php');
			$v = new JvCard();

			$v->setPhoneNumber($contact->telephone, 'PREF;WORK;VOICE');
			$v->setPhoneNumber($contact->fax, 'WORK;FAX');
			$v->setName($surname, $firstname, $middlename, '');
			$v->setAddress('', '', $contact->address, $contact->suburb, $contact->state, $contact->postcode, $contact->country, 'WORK;POSTAL');
			$v->setEmail($contact->email_to);
			$v->setNote($contact->misc);
			$v->setURL( JURI::base(), 'WORK');
			$v->setTitle($contact->con_position);
			$v->setOrg($SiteName);

			$filename = str_replace(' ', '_', $contact->name);
			$v->setFilename($filename);

			$output = $v->getVCard($SiteName);
			$filename = $v->getFileName();

			// Send vCard file headers
			header('Content-Disposition: attachment; filename='.$filename);
			header('Content-Length: '.strlen($output));
			header('Connection: close');
			header('Content-Type: text/x-vCard; name='.$filename);
			header('Cache-Control: store, cache');
			header('Pragma: cache');

			print $output;
		} else {
			JError::raiseWarning('SOME_ERROR_CODE', 'ContactController::vCard: '.JText::_('NOTAUTH'));
			return false;
		}
	}

	/**
	 * Validates some inputs based on component configuration
	 *
	 * @return boolean
	 */
	function _validateInputs( $email, $subject, $body )
	{
		$session =& JFactory::getSession();

		$model		= $this->getModel('contact');
		$options['category_id']	= $contact->catid;
		$options['order by']	= 'a.default_con DESC, a.ordering ASC';

		$contact 		= $model->getContact( $options );
		$contactParams	= new JParameter($contact->params);
		$config 		= &JComponentHelper::getParams( 'com_contact' );
		$bannedEmail 	= $config->get( 'bannedEmail', 	'' ).';'.$contactParams->get( 'bannedEmail', 	'' );
		$bannedSubject 	= $config->get( 'bannedSubject', 	'' ).';'.$contactParams->get( 'bannedSubject', 	'' );;
		$bannedText 	= $config->get( 'bannedText', 	'' ).';'.$contactParams->get( 'bannedText', 	'' );;
		$sessionCheck 	= $config->get( 'session', 	1 );
		$sessionName	= $session->getName();

		// check for session cookie
		if  ( $sessionCheck ) {
			if ( !isset($_COOKIE[$sessionName]) ) {
				$this->setError( _NOT_AUTH );
				return false;
			}
		}

		// Prevent form submission if one of the banned text is discovered in the email field
		if ( $bannedEmail ) {
			$bannedEmail = explode( ';', $bannedEmail );
			foreach ($bannedEmail as $value) {
				if ( JString::stristr($email, $value) ) {
					$this->setError( _NOT_AUTH );
					return false;
				}
			}
		}
		// Prevent form submission if one of the banned text is discovered in the subject field
		if ( $bannedSubject ) {
			$bannedSubject = explode( ';', $bannedSubject );
			foreach ($bannedSubject as $value) {
				if ( JString::stristr($subject, $value) ) {
					$this->setError( _NOT_AUTH );
					return false;
				}
			}
		}
		// Prevent form submission if one of the banned text is discovered in the text field
		if ( $bannedText ) {
			$bannedText = explode( ';', $bannedText );
			foreach ($bannedText as $value) {
				if ( JString::stristr($body, $value) ) {
					$this->setError( _NOT_AUTH );
					return false;
				}
			}
		}

		// test to ensure that only one email address is entered
		$check = explode( '@', $email );
		if ( strpos( $email, ';' ) || strpos( $email, ',' ) || strpos( $email, ' ' ) || count( $check ) > 2 ) {
			$this->setError( JText::_( 'You cannot enter more than one email address', true ) );
			return false;
		}


		return true;
	}
}
?>