<?php
/**
 * @version		$Id: jajax.php 6256 2007-01-11 17:30:32Z louis $
 * @package		Joomla
 * @subpackage	Installation
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

define( '_JEXEC', 1 );

define( 'JXPATH_BASE', dirname( __FILE__ ) );

//Global definitions
define( 'DS', DIRECTORY_SEPARATOR );

//Joomla framework path definitions
$parts = explode( DS, JXPATH_BASE );
array_pop( $parts );
define( 'JPATH_BASE',			implode( DS, $parts )  );
array_pop( $parts );

define( 'JPATH_ROOT',			implode( DS, $parts ) );
define( 'JPATH_SITE',			JPATH_ROOT );
define( 'JPATH_CONFIGURATION',	JPATH_ROOT );
define( 'JPATH_LIBRARIES',		JPATH_ROOT . DS . 'libraries' );

// Require the library loader
require_once( JPATH_LIBRARIES . DS .'loader.php' );
// Require the xajax library
require_once (JXPATH_BASE.DS.'xajax'.DS.'xajax.inc.php');
$xajax = new xajax();
$xajax->errorHandlerOn();

$xajax->registerFunction(array('getCollations', 'JAJAXHandler', 'dbcollate'));
//$xajax->registerFunction(array('getPrivileges', 'JAJAXHandler', 'dbpriv'));
$xajax->registerFunction(array('getFtpRoot', 'JAJAXHandler', 'ftproot'));
$xajax->registerFunction(array('FTPVerify', 'JAJAXHandler', 'ftpverify'));
$xajax->registerFunction(array('instDefault', 'JAJAXHandler', 'sampledata'));

jimport( 'joomla.common.abstract.object' );
jimport( 'joomla.utilities.error' );
JError::setErrorHandling(E_ERROR, 'callback', array('JAJAXHandler','handleError'));
JError::setErrorHandling(E_WARNING, 'callback', array('JAJAXHandler','handleError'));
JError::setErrorHandling(E_NOTICE, 'callback', array('JAJAXHandler','handleError'));
jimport( 'joomla.filesystem.*' );

/**
 * AJAX Task handler class
 *
 * @static
 * @package		Joomla
 * @subpackage	Installer
 * @since 1.5
 */
class JAJAXHandler
{
	/**
	 * Method to get the database collations
	 */
	function dbcollate($args) {

		jimport( 'joomla.application.application' );
		jimport( 'joomla.database.database' );
		jimport( 'joomla.registry.registry' );

		$objResponse = new xajaxResponse();
		$args = $args['vars'];

		$lang = new JAJAXLang($args['lang']);
//		$lang->setDebug(true);

		/*
		 * Get a database connection instance
		 */
		$db = & JDatabase::getInstance($args['DBtype'], $args['DBhostname'], $args['DBuserName'], $args['DBpassword'] );

		if ($err = $db->getErrorNum()) {
			if ($err != 3) {
				$objResponse->addAlert($lang->_('CONNECTION FAIL'));
				return $objResponse;
			}
		}
		/*
		 * This needs to be rewritten for output to a javascript method...
		 */
		$collations = array();

		// determine db version, utf support and available collations
		$vars['DBversion'] = $db->getVersion();
		$verParts = explode( '.', $vars['DBversion'] );
		$vars['DButfSupport'] = ($verParts[0] == 5 || ($verParts[0] == 4 && $verParts[1] == 1 && (int) $verParts[2] >= 2));
		if ($vars['DButfSupport']) {
			$query = "SHOW COLLATION LIKE 'utf8%'";
			$db->setQuery( $query );
			$collations = $db->loadAssocList();
			// Tell javascript we have UTF support
			$objResponse->addAssign('utfsupport', 'value', '1');
		} else {
			// backward compatibility - utf-8 data in non-utf database
			// collation does not really have effect so default charset and collation is set
			$collations[0]['Collation'] = 'latin1';
			// Tell javascript we do not have UTF support
			$objResponse->addAssign('utfsupport', 'value', '0');
		}
		$txt = '<select id="vars_dbcollation" name="vars[DBcollation]" class="inputbox" size="1">';

		foreach ($collations as $collation) {
			$txt .= '<option value="'.$collation["Collation"].'">'.$collation["Collation"].'</option>';
		}
		$txt .=	'</select>';

		$objResponse->addAssign("theCollation","innerHTML",$txt);
		return $objResponse;
	}

	/**
	 * Method to get the database privileges
	 */
//	function dbpriv($args) {
//
//		jimport( 'joomla.application.application' );
//		jimport( 'joomla.database.database' );
//		jimport( 'joomla.registry.registry' );
//
//		$objResponse = new xajaxResponse();
//		$args = $args['vars'];
//
//		$lang = new JAJAXLang($args['lang']);
////		$lang->setDebug(true);
//
//		/*
//		 * Get a database connection instance
//		 */
//		$db = & JDatabase::getInstance($args['DBtype'], $args['DBhostname'], $args['DBuserName'], $args['DBpassword'], "mysql" );
//
//		if ($err = $db->getErrorNum()) {
//			if ($err != 3) {
//				$objResponse->addAlert($lang->_('CONNECTION FAIL'));
//				return $objResponse;
//			}
//		}
//		/*
//		 * establish the privileges of the given user
//		 */
//		$query = "FLUSH PRVILEGES";
//		$db->setQuery( $query );
//
//		$query = "SHOW GRANTS FOR '".$args['DBuserName']."'@'".$args['DBhostname']."'";
//		$db->setQuery( $query );
//		$privs = $db->loadResultArray();
//		$errMsg = $db->getErrorMsg();
//
//		$privNotes = array();
//		if ( strpos($privs[0], '*.*') && ( strpos($privs[0], 'ALL') || strpos($privs[0], 'CREATE')) ) {
//			$privNotes[] = $lang->_('PRIVGLOBALCREATEOK');
//		} else {
//			$privNotes[] = $lang->_('PRIVGLOBALCREATENONE');
//		}
//		$privNotes[] = '------ Actual DB Report -----';
//		$outmsgs = array_merge($privNotes, $privs);
//		if ($errMsg == '') {
//			$objResponse->addAlert(implode(chr(10).chr(13), $outmsgs));
//		} else {
//			$objResponse->addAlert($errMsg);
//
//		}
//		return $objResponse;
//	}

	/**
	 * Method to get the path from the FTP root to the Joomla root directory
	 */
	function ftproot($args) {

		jimport( 'joomla.application.application' );

		$objResponse = new xajaxResponse();
		$args = $args['vars'];
		require_once(JXPATH_BASE.DS."classes.php");
		$root =  JInstallationHelper::findFtpRoot($args['ftpUser'], $args['ftpPassword'], $args['ftpHost'], $args['ftpPort']);
		$objResponse->addAssign('ftproot', 'value', $root);
		$objResponse->addAssign('rootPath', 'style.display', '');
		return $objResponse;
	}

	/**
	 * Method to verify the ftp values are valid
	 */
	function ftpverify($args) {

		jimport( 'joomla.application.application' );

		$objResponse = new xajaxResponse();
		$args = $args['vars'];

		require_once(JXPATH_BASE.DS."classes.php");
		$status =  JInstallationHelper::FTPVerify($args['ftpUser'], $args['ftpPassword'], $args['ftpRoot'], $args['ftpHost'], $args['ftpPort']);
		if (JError::isError($status)) {
			$objResponse->addAlert($status->get('message'));
		} else {
			$objResponse->addAlert('VALID');
		}
		return $objResponse;
	}

	/**
	 * Method to load and execute a sql script
	 */
	function sampledata($args)
	{
		jimport( 'joomla.database.database');
		jimport( 'joomla.i18n.language');
		jimport( 'joomla.registry.registry');

		require_once(JXPATH_BASE.DS."classes.php");

		$errors = null;
		$msg = '';
		$objResponse = new xajaxResponse();
		$lang = new JAJAXLang($args['lang']);
//		$lang->setDebug(true);

		/*
		 * execute the default sample data file
		 */
		$dbsample = '../sql/sample_data.sql';
		$db = & JDatabase::getInstance($args['DBtype'], $args['DBhostname'], $args['DBuserName'], $args['DBpassword'], $args['DBname'], $args['DBPrefix']);
		$result = JInstallationHelper::populateDatabase($db, $dbsample, $errors);

		/*
		 * prepare sql error messages if returned from populate
		 */
		if (!is_null($errors)){
			foreach($errors as $error){
				$msg .= stripslashes( $error['msg'] );
				$msg .= chr(13)."-------------".chr(13);
				$txt = '<textarea cols="35" rows="5" name="instDefault" readonly="readonly" >'.$lang->_('Database Errors Reported').chr(13).$msg.'</textarea>';
			}
		} else {
			// consider other possible errors from populate
			$msg = $result == 0 ? $lang->_("Sample data installed successfully") : $lang->_("Error installing SQL script") ;
			$txt = '<input size="35" name="instDefault" value="'.$msg.'" readonly="readonly" />';
		}

		$objResponse->addAssign("theDefault", "innerHTML", $txt);
		return $objResponse;
	}

	/**
	 * Handle a raised error : for now just silently return
	 *
	 * @access	private
	 * @param	object	$error	JError object
	 * @return	object	$error	JError object
	 * @since	1.5
	 */
	function & handleError(& $error)
	{
		return $error;
	}
}


/**
 * Languages/translation handler class
 *
 * @package 	Joomla.Framework
 * @subpackage	I18N
 * @since		1.5
 */
class JAJAXLang extends JObject
{
	/**
	 * Debug language, If true, highlights if string isn't found
	 *
	 * @var boolean
	 * @access protected
	 */
	var $_debug 	= false;


	/**
	 * Identifying string of the language
	 *
	 * @var string
	 * @access protected
	 */
	var $_identifyer = null;

	/**
	 * The language to load
	 *
	 * @var string
	 * @access protected
	 */
	var $_lang = null;

	/**
	 * Transaltions
	 *
	 * @var array
	 * @access protected
	 */
	var $_strings = null;

	/**
	* Constructor activating the default information of the language
	*
	* @access protected
	*/
	function __construct($lang = null)
	{
		$this->_strings = array ();

		if ($lang == null) {
			$lang = 'en-GB';
		}

		$this->_lang= $lang;

		$this->load();
	}


	/**
	* Translator function, mimics the php gettext (alias _) function
	*
	* @access public
	* @param string		$string 	The string to translate
	* @param boolean	$jsSafe		Make the result javascript safe
	* @return string	The translation of the string
	*/
	function _($string, $jsSafe = false)
	{
		//$key = str_replace( ' ', '_', strtoupper( trim( $string ) ) );echo '<br>'.$key;
		$key = strtoupper($string);
		$key = substr($key, 0, 1) == '_' ? substr($key, 1) : $key;
		if (isset ($this->_strings[$key])) {
			$string = $this->_debug ? "&bull;".$this->_strings[$key]."&bull;" : $this->_strings[$key];
		} else {
			if (defined($string)) {
				$string = $this->_debug ? "!!".constant($string)."!!" : constant($string);
			} else {
				$string = $this->_debug ? "??".$string."??" : $string;
			}
		}
		if ($jsSafe) {
			$string = addslashes($string);
		}
		return $string;
	}

	/**
	 * Loads a single langauge file and appends the results to the existing strings
	 *
	 * @access public
	 * @param string 	$prefix 	The prefix
	 * @param string 	$basePath  	The basepath to use
	 * $return boolean	True, if the file has successfully loaded.
	 */
	function load( $prefix = '', $basePath = JPATH_BASE )
	{
		$path = JAJAXLang::getLanguagePath( $basePath, $this->_lang);

		$filename = empty( $prefix ) ?  $this->_lang : $this->_lang . '.' . $prefix ;

		$result = false;

		$newStrings = $this->_load( $path . $filename .'.ini' );

		if (is_array($newStrings)) {
			$this->_strings = array_merge( $this->_strings, $newStrings);
			$result = true;
		}

		return $result;

	}

	/**
	* Loads a language file and returns the parsed values
	*
	* @access private
	* @param string The name of the file
	* @return mixed Array of parsed values if successful, boolean False if failed
	*/
	function _load( $filename )
	{
		if ($content = @file_get_contents( $filename )) {
			if( $this->_identifyer === null ) {
				$this->_identifyer = basename( $filename, '.ini' );
			}

			$registry = new JRegistry();
			$registry->loadINI($content);
			return $registry->toArray( );
		}

		return false;
	}


	/**
	* Set the Debug property
	*
	* @access public
	*/
	function setDebug($debug) {
		$this->_debug = $debug;
	}


	/**
	 * Determines is a key exists
	 *
	 * @access public
	 * @param key $key	The key to check
	 * @return boolean True, if the key exists
	 */
	function hasKey($key) {
		return isset ($this->_strings[strtoupper($key)]);
	}


	/**
	 * Get the path to a language
	 *
	 * @access public
	 * @param string $basePath  The basepath to use
	 * @param string $language	The language tag
	 * @return string	language related path or null
	 */
	function getLanguagePath($basePath = JPATH_BASE, $language = null )
	{
		$dir = $basePath.DS.'language'.DS;
		if (isset ($language)) {
			$dir .= $language.DS;
		}
		return $dir;
	}



	/**
	 * Parses XML files for language information
	 *
	 * @access public
	 * @param string	$dir	 Directory of files
	 * @return array	Array holding the found languages as filename => metadata array
	 */
	function _parseXMLLanguageFiles($dir = null)
	{
		if ($dir == null) {
			return null;
		}

		$languages = array ();
		jimport('joomla.filesystem.folder');
		$files = JFolder::files($dir, '^([-_A-Za-z]*)\.xml$');
		foreach ($files as $file) {
			if ($content = file_get_contents($dir.$file)) {
				if ($metadata = JAJAXLang::_parseXMLLanguageFile($dir.$file)) {
					$lang = str_replace('.xml', '', $file);
					$languages[$lang] = $metadata;
				}
			}
		}
		return $languages;
	}

	/**
	 * Parse XML file for language information
	 *
	 * @access public
	 * @param string	$path	 Path to the xml files
	 * @return array	Array holding the found metadat as a key => value pair
	 */
	function _parseXMLLanguageFile($path)
	{
		jimport('joomla.utilities.simplexml');
		$xml = new JSimpleXML();

		if (!$xml->loadFile($path)) {
			return null;
		}

		// Check that it's am metadata file
		if ($xml->document->name() != 'metafile') {
			return null;
		}

		$metadata = array ();

			foreach ($xml->document->metadata[0]->children() as $child) {
				$metadata[$child->name()] = $child->data();
			}
		//}
		return $metadata;
	}
}



/*
 * Process the AJAX requests
 */
$xajax->cleanBufferOff(); //Needed for suPHP compilance
$xajax->processRequests();
?>
