<?php

/**
* @version		$Id: gmail.php 5509 2006-10-19 11:45:15Z pasamio $
* @package		Joomla
* @subpackage	JFramework
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

jimport('joomla.application.plugin.helper');

/**
 * OpenID JAuthenticate Plugin
 *
 * @author	Johan Janssens <johan.janssens@joomla.org>
 * @package		Joomla
 * @subpackage	openID
 * @since 1.5
 */

class JAuthenticateOpenID extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @since 1.5
	 */
	function JAuthenticateOpenID(& $subject) {
		parent::__construct($subject);
	}

	/**
	 * This method should handle any authentication and report back to the subject
	 *
	 * @access	public
	 * @param	string	$username	Username for authentication
	 * @param	string	$password	Password for authentication
	 * @return	object	JAuthenticateResponse
	 * @since 1.5
	 */
	function onAuthenticate( $username, $password )
	{
		global $mainframe;

		//OpenID plugin requires DOM xml module to be installed
		if(version_compare( phpversion(), '5.0' ) < 0) {
			return;
		}

	 	 // Require the OpenID consumer.
		jimport ('openid.consumer');

		// Access the session data
		$session =& JFactory::getSession();

		// load plugin parameters
		$plugin =& JPluginHelper::getPlugin('authentication', 'openid');
		$params = new JParameter( $plugin->params );

		// create response object
		$return = new JAuthenticateResponse('openid');

		// Need to check for bcmath or gmp - if not, use the dumb mode.
		// TODO: Should dump an error to debug saying we are dumb

		global $_Auth_OpenID_math_extensions;
		$ext = Auth_OpenID_detectMathLibrary($_Auth_OpenID_math_extensions);
		if (!isset($ext['extension']) || !isset($ext['class'])) {
			define ("Auth_OpenID_NO_MATH_SUPPORT", true);
		}

		// Create and/or start using the data store
		$store_path = JPATH_ROOT . '/tmp/_joomla_openid_store';
		if (!file_exists($store_path) && !mkdir($store_path)) {
			print "Could not create the FileStore directory '$store_path'. " . " Please check the effective permissions.";
			exit (0);
		}

		// Create store object
		$store = new Auth_OpenID_FileStore($store_path);

		// Create a consumer object
		$consumer = new Auth_OpenID_Consumer($store);

		if (!$session->get('_openid_consumer_last_token'))
		{
			// Begin the OpenID authentication process.
			if(!$request = $consumer->begin($username))
			{
				$return->type = JAUTHENTICATE_STATUS_FAILURE;
				$return->error_message = 'Authentication error : could not connect to the openid server';
				return $return;
			}

			// Request simple registration information
			$request->addExtensionArg('sreg', 'required' , 'email');
			$request->addExtensionArg('sreg', 'optional', 'fullname');
			$request->addExtensionArg('sreg', 'optional', 'language');
			$request->addExtensionArg('sreg', 'optional', 'timezone');

			$uri =& JFactory::getURI();
			$url = $uri->toString();

			$process_url = sprintf("index.php?option=com_login&task=login&username=%s&return=%s", $username, $url);
			$redirect_url = $request->redirectURL(JURI::base(), JURI::base().'/'.$process_url);

			$session->set('trust_url', JURI::base());
		
			// Redirect the user to the OpenID server for authentication.  Store
			// the token for this authentication so we can verify the response.
			$mainframe->redirect($redirect_url);
			return false;
		}

		$response = $consumer->complete(JRequest::get('get'));

		switch ($response->status)
		{
			case Auth_OpenID_SUCCESS :
			{
				$sreg = $response->extensionResponse('sreg');

				$return->status		= JAUTHENTICATE_STATUS_SUCCESS;
				$return->email		= isset($sreg['email'])	? $sreg['email']	: "";
				$return->fullname	= isset($sreg['fullname']) ? $sreg['fullname'] : "";
				$return->language	= isset($sreg['language']) ? $sreg['language'] : "";
				$return->timezone	= isset($sreg['timezone']) ? $sreg['timezone'] : "";

			} break;

			case Auth_OpenID_CANCEL :
			{
				$return->status = JAUTHENTICATE_STATUS_CANCEL;
				$return->error_message = 'Authentication failed';
			} break;

			case Auth_OpenID_FAILURE :
			{
				$return->status = JAUTHENTICATE_STATUS_FAILURE;
				$return->error_message = 'Authentication cancelled';
			} break;
		}

		return $return;
	}
}
?>
