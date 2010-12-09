<?php
/**
* @version		$Id: language.php 6235 2007-01-10 08:04:47Z friesengeist $
* @package		Joomla.Framework
* @subpackage	I18N
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * Text  handling class
 *
 * @static
 * @package 	Joomla.Framework
 * @subpackage	I18N
 * @since		1.5
 */
class JText
{
	/**
	 * Translates a string into the current language
	 *
	 * @access public
	 * @param string $string The string to translate
	 * @param boolean	$jsSafe		Make the result javascript safe
	 *
	 */
	function _($string, $jsSafe = false)
	{
		$lang =& JFactory::getLanguage();
		return $lang->_($string, $jsSafe);
	}

	/**
	 * Passes a string thru an sprintf
	 *
	 * @access public
	 * @param format The format string
	 * @param mixed Mixed number of arguments for the sprintf function
	 */
	function sprintf($string)
	{
		$lang =& JFactory::getLanguage();
		$args = func_get_args();
		if (count($args) > 0) {
			$args[0] = $lang->_($args[0]);
			return call_user_func_array('sprintf', $args);
		}
		return '';
	}
	/**
	 * Passes a string thru an printf
	 *
	 * @access public
	 * @param format The format string
	 * @param mixed Mixed number of arguments for the sprintf function
	 */
	function printf($string)
	{
		$lang =& JFactory::getLanguage();
		$args = func_get_args();
		if (count($args) > 0) {
			$args[0] = $lang->_($args[0]);
			return call_user_func_array('printf', $args);
		}
		return '';
	}

}

/**
 * Languages/translation handler class
 *
 * @package 	Joomla.Framework
 * @subpackage	I18N
 * @since		1.5
 */
class JLanguage extends JObject
{
	/**
	 * Debug language, If true, highlights if string isn't found
	 *
	 * @var boolean
	 * @access protected
	 */
	var $_debug 	= false;

	/**
	 * Array holding the language metadata
	 *
	 * @var array
	 * @access protected
	 */
	var $_metadata 	= null;

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

		$this->_metadata = $this->getMetadata($this->_lang);

		//set locale based on the language tag
		//TODO : add function to display locale setting in configuration
		$locale = setlocale(LC_ALL, $this->getLocale());

		$this->load();
	}

	/**
	 * Returns a reference to a language object
	 *
	 * This method must be invoked as:
	 * 		<pre>  $browser = &JLanguage::getInstance([$lang);</pre>
	 *
	 * @access public
	 * @param string $lang  The language to use.
	 * @return JLanguage  The Language object.
	 */
	function & getInstance($lang)
	{
		$instance = new JLanguage($lang);
		$reference = & $instance;
		return $reference;
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
	 * Loads a single language file and appends the results to the existing strings
	 *
	 * @access public
	 * @param string 	$prefix 	The prefix
	 * @param string 	$basePath  	The basepath to use
	 * $return boolean	True, if the file has successfully loaded.
	 */
	function load( $prefix = '', $basePath = JPATH_BASE )
	{
		static $paths;

		if (!isset($paths))
		{
			$paths = array();
		}

		$path = JLanguage::getLanguagePath( $basePath, $this->_lang);

		$filename = empty( $prefix ) ?  $this->_lang : $this->_lang . '.' . $prefix ;
		$filename = $path . $filename .'.ini';

		$result = false;
		if (isset( $paths[$filename] ))
		{
			$result = true;
		}
		else
		{
			$paths[$filename] = true;
			$newStrings = $this->_load( $filename );

			if (is_array($newStrings)) {
				$this->_strings = array_merge( $this->_strings, $newStrings);
				$result = true;
			}
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
	 * Get a matadata language property
	 *
	 * @access public
	 * @param string $property	The name of the property
	 * @param mixed  $default	The default value
	 * @return mixed The value of the property
	 */
	function get($property, $default = null)
	{
		if (isset ($this->_metadata[$property])) {
			return $this->_metadata[$property];
		}
		return $default;
	}

	/**
	* Getter for Name
	*
	* @access public
	* @param string  $value 	An optional value
	* @return string Official name element of the language
	*/
	function getName($value = null) {
		return $this->_metadata['name'];
	}

	/**
	* Getter for PDF Font Name
	*
	* @access public
	* @return string name of pdf font to be used
	*/
	function getPdfFontName() {
		return $this->_metadata['pdffontname'];
	}

	/**
	* Getter for Windows locale code page
	*
	* @access public
	* @return string windows locale encoding
	*/
	function getWinCP() {
		return $this->_metadata['wincodepage'];
	}

	/**
	* Getter for backward compatible language name
	*
	* @access public
	* @return string backward compatible name
	*/
	function getBackwardLang() {
		return $this->_metadata['backwardlang'];
	}

	/**
	* Get for the language tag (as defined in RFC 3066)
	*
	* @access public
	* @return string The language tag
	*/
	function getTag() {
		return $this->_metadata['tag'];
	}

	/**
	* Get locale property
	*
	* @access public
	* @return string The locale property
	*/
	function getLocale()
	{
		$locales = explode(',', $this->_metadata['locale']);

		for($i = 0; $i < count($locales); $i++ ) {
			$locale = $locales[$i];
			$locale = trim($locale);
			$locales[$i] = $locale;
		}

		//return implode(',', $locales);
		return $locales;
	}

	/**
	* Get the RTL property
	*
	* @access public
	* @return boolean True is it an RTL language
	*/
	function isRTL($value = null) {
		return $this->_metadata['rtl'];
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
	* Get the Debug property
	*
	* @access public
	* @return boolean True is in debug mode
	*/
	function getDebug() {
		return $this->_debug;
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
	 * Returns a associative array holding the metadata
	 *
	 * @access public
	 * @param string	The name of the language
	 * @return mixed	If $lang exists return key/value pair with the language metadata,
	 *  				otherwise return NULL
	 */

	function getMetadata($lang)
	{
		$path = JLanguage::getLanguagePath(JPATH_BASE, $lang);
		$file = $lang.'.xml';

		$result = null;
		if(is_file($path.$file)) {
			$result = JLanguage::_parseXMLLanguageFile($path.$file);
		}

		return $result;
	}

	/**
	 * Returns a list of known languages for an area
	 *
	 * @access public
	 * @param string	$basePath 	The basepath to use
	 * @return array	key/value pair with the language file and real name
	 */
	function getKnownLanguages($basePath = JPATH_BASE)
	{
		$dir = JLanguage::getLanguagePath($basePath);
		$knownLanguages = JLanguage::_parseLanguageFiles($dir);

		return $knownLanguages;
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
	 * Searches for language directories within a certain base dir
	 *
	 * @access public
	 * @param string 	$dir 	directory of files
	 * @return array	Array holding the found languages as filename => real name pairs
	 */
	function _parseLanguageFiles($dir = null)
	{
		jimport('joomla.filesystem.folder');

		$languages = array ();

		$subdirs = JFolder::folders($dir);
		foreach ($subdirs as $path) {
			$langs = JLanguage::_parseXMLLanguageFiles($dir.$path.DIRECTORY_SEPARATOR);
			$languages = array_merge($languages, $langs);
		}

		return $languages;
	}

	/**
	 * Parses INI type of files for language information
	 *
	 * @access public
	 * @param string	$dir 	Directory of files
	 * @return array	Array holding the found languages as filename => real name pairs
	 */
	function _parseINILanguageFiles($dir = null)
	{
		if ($dir == null)
			return null;

		$languages = array ();
		jimport('joomla.filesystem.folder');
		$files = JFolder::files($dir, '^([_A-Za-z]*)\.ini$');
		foreach ($files as $file) {
			if ($content = file_get_contents($dir.$file)) {
				$langContent = JParameter::parse($content, false, true);
				$lang = str_replace('.ini', '', $file);
				$name = $lang;
				if (isset ($langContent['__NAME'])) {
					$name = $langContent['__NAME'];
				}

				$languages[$lang] = $name;
			}
		}
		return $languages;
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
				if ($metadata = JLanguage::_parseXMLLanguageFile($dir.$file)) {
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
	 * @return array	Array holding the found metadata as a key => value pair
	 */
	function _parseXMLLanguageFile($path)
	{
		jimport('joomla.factory');
		$xml = & JFactory::getXMLParser('Simple');
		if (!$xml->loadFile($path)) {
			return null;
		}

		// Check that it's am metadata file
		if ($xml->document->name() != 'metafile') {
			return null;
		}

		$metadata = array ();

		//if ($xml->document->attributes('type') == 'language') {

			foreach ($xml->document->metadata[0]->children() as $child) {
				$metadata[$child->name()] = $child->data();
			}
		//}
		return $metadata;
	}
}

/**
 * @package 	Joomla.Framework
 * @subpackage		I18N
 * @static
 * @since 1.5
 */
class JLanguageHelper
{
	/**
	 * Builds a list of the system languages which can be used in a select option
	 *
	 * @access public
	 * @param string	Client key for the area
	 * @param string	Base path to use
	 * @param array	An array of arrays ( text, value, selected )
	 */
	function createLanguageList($actualLanguage, $basePath = JPATH_BASE) {

		$list = array ();

		// cache activation
		$cache = & JFactory::getCache('JLanguage');
		$langs = $cache->call('JLanguage::getKnownLanguages', $basePath);

		foreach ($langs as $lang => $metadata) {
			$option = array ();

			$option['text'] = $metadata['name'];
			$option['value'] = $lang;
			if ($lang == $actualLanguage) {
				$option['selected'] = 'selected="selected"';
			}
			$list[] = $option;
		}

		return $list;
	}

	/**
 	 * Tries to detect the language
 	 *
 	 * @access public
 	 */
	function detectLanguage()
	{
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			$systemLangs	= JLanguage::getKnownLanguages();
			$browserLangs	= explode( ',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] );

			foreach ($browserLangs as $browserLang)
			{
				// slice out the part before ; on first step, the part before - on second, place into array
				$browserLang = substr( $browserLang, 0, strcspn( $browserLang, ';' ) );
				$primary_browserLang = substr( $browserLang, 0, 2 );

				foreach($systemLangs as $systemLang => $metadata)
				{
					if($primary_browserLang == substr( $metadata['tag'], 0, 2 )) {
						return $systemLang;
					}
				}
			}
		}

		return 'en-GB';
	}
}
?>
