<?php
/**
* @version		$Id: database.php 4350 2006-07-28 03:34:45Z eddiea $
* @package		Joomla.Framework
* @subpackage	Database
* @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * Database connector class
 *
 * @abstract
 * @package		Joomla.Framework
 * @subpackage	Database
 * @since		1.0
 */
class JDatabase extends JObject
{
	/** @var string The database driver name */
	var $name			= '';
	/** @var string Internal variable to hold the query sql */
	var $_sql			= '';
	/** @var int Internal variable to hold the database error number */
	var $_errorNum		= 0;
	/** @var string Internal variable to hold the database error message */
	var $_errorMsg		= '';
	/** @var string Internal variable to hold the prefix used on all database tables */
	var $_table_prefix	= '';
	/** @var Internal variable to hold the connector resource */
	var $_resource		= '';
	/** @var Internal variable to hold the last query cursor */
	var $_cursor		= null;
	/** @var boolean Debug option */
	var $_debug			= 0;
	/** @var int The limit for the query */
	var $_limit			= 0;
	/** @var int The for offset for the limit */
	var $_offset		= 0;
	/** @var int A counter for the number of queries performed by the object instance */
	var $_ticker		= 0;
	/** @var array A log of queries */
	var $_log			= null;
	/** @var string The null/zero date string */
	var $_nullDate		= null;
	/** @var string Quote for named objects */
	var $_nameQuote		= null;
	/**
	 * @var boolean UTF-8 support
	 * @since	1.5
	 */
	var $_utf			= 0;
	/**
	 * @var array The fields that are to be quote
	 * @since	1.5
	 */
	var $_quoted	= null;
	/**
	 * @var bool Legacy compatibility
	 * @since	1.5
	 */
	var $_hasQuoted	= null;

	/**
	* Database object constructor
	*
	* @param string Database host
	* @param string Database user name
	* @param string Database user password
	* @param string Database name
	* @param string Common prefix for all tables
	*/
	function __construct( $host='localhost', $user, $pass, $db='', $table_prefix='')
	{
		// Determine utf-8 support
		$this->_utf = $this->hasUTF();

		//Set charactersets (needed for MySQL 4.1.2+)
		if ($this->_utf){
			$this->setUTF();
		}

		$this->_table_prefix	= $table_prefix;
		$this->_ticker			= 0;
		$this->_errorNum		= 0;
		$this->_log				= array();
		$this->_quoted			= array();
		$this->_hasQuoted		= false;

		// If we opened the connection lets make sure we close it
		register_shutdown_function(array(&$this,'__destruct'));
	}

	/**
	 * Returns a reference to the global Database object, only creating it
	 * if it doesn't already exist.
	 *
	 * @param string  Database driver
	 * @param string Database host
	 * @param string Database user name
	 * @param string Database user password
	 * @param string Database name
	 * @param string Common prefix for all tables
	 * @return JDatabase A database object
	 * @since 1.5
	*/
	function &getInstance( $driver='mysql', $host='localhost', $user, $pass, $db='', $table_prefix='' )
	{
		static $instances;

		if (!isset( $instances )) {
			$instances = array();
		}

		$signature = serialize(array($driver, $host, $user, $pass, $db, $table_prefix));

		if (empty($instances[$signature])) {
			jimport('joomla.database.database.'.$driver);
			$adapter = 'JDatabase'.$driver;
			$instances[$signature] = new $adapter($host, $user, $pass, $db, $table_prefix);
		}

		return $instances[$signature];
	}


	/**
	 * Database object destructor
	 *
	 * @abstract
	 * @access private
	 * @return boolean
	 * @since 1.5
	 */
	function __destruct()
	{
		return true;
	}

	/**
	 * Determines UTF support
	 *
	 * @abstract
	 * @access public
	 * @return boolean
	 * @since 1.5
	 */
	function hasUTF() {
		return false;
	}

	/**
	 * Custom settings for UTF support
	 *
	 * @abstract
	 * @access public
	 * @since 1.5
	 */
	function setUTF() {
	}

	/**
	 * Adds a field or array of field names to the list that are to be quoted
	 *
	 * @access public
	 * @param mixed Field name or array of names
	 * @since 1.5
	 */
	function addQuoted( $quoted )
	{
		if (is_string( $quoted )) {
			$this->_quoted[] = $quoted;
		} else {
			$this->_quoted = array_merge( $this->_quoted, (array)$quoted );
		}
		$this->_hasQuoted = true;
	}

	/**
	 * Checks if field name needs to be quoted
	 *
	 * @access public
	 * @param string The field name
	 * @return bool
	 */
	function isQuoted( $fieldName )
	{
		if ($this->_hasQuoted) {
			return in_array( $fieldName, $this->_quoted );
		} else {
			return true;
		}
	}

	/**
	 * Sets the debug level on or off
	 *
	 * @access public
	 * @param int 0 = off, 1 = on
	 */
	function debug( $level ) {
		$this->_debug = intval( $level );
	}

	/**
	 * Get the database UTF-8 support
	 *
	 * @access public
	 * @return boolean
	 * @since 1.5
	 */
	function getUTFSupport() {
		return $this->_utf;
	}

	/**
	 * Get the error number
	 *
	 * @access public
	 * @return int The error number for the most recent query
	 */
	function getErrorNum() {
		return $this->_errorNum;
	}


	/**
	 * Get the error message
	 *
	 * @access public
	 * @return string The error message for the most recent query
	 */
	function getErrorMsg() {
		return $this->_errorMsg;
	}

	/**
	 * Get a database escaped string
	 *
	 * @abstract
	 * @access public
	 * @return string
	 */
	function getEscaped( $text ) {
		return;
	}

	/**
	 * Quote an identifier name (field, table, etc)
	 *
	 * @access public
	 * @param string The name
	 * @return string The quoted name
	 */
	function nameQuote( $s )
	{
		$q = $this->_nameQuote;
		if (strlen( $q ) == 1) {
			return $q . $s . $q;
		} else {
			return $q{0} . $s . $q{1};
		}
	}
	/**
	 * Get the database table prefix
	 *
	 * @access public
	 * @return string The database prefix
	 */
	function getPrefix() {
		return $this->_table_prefix;
	}

	/**
	 * Get the database null date
	 *
	 * @access public
	 * @return string Quoted null/zero date string
	 */
	function getNullDate() {
		return $this->_nullDate;
	}

	/**
	 * Sets the SQL query string for later execution.
	 *
	 * This function replaces a string identifier <var>$prefix</var> with the
	 * string held is the <var>_table_prefix</var> class variable.
	 *
	 * @access public
	 * @param string The SQL query
	 * @param string The offset to start selection
	 * @param string The number of results to return
	 * @param string The common table prefix
	 */
	function setQuery( $sql, $offset = 0, $limit = 0, $prefix='#__' )
	{
		$this->_sql		= $this->replacePrefix( $sql, $prefix );
		$this->_limit	= (int) $limit;
		$this->_offset	= (int) $offset;
	}

	/**
	 * This function replaces a string identifier <var>$prefix</var> with the
	 * string held is the <var>_table_prefix</var> class variable.
	 *
	 * @access public
	 * @param string The SQL query
	 * @param string The common table prefix
	 */
	function replacePrefix( $sql, $prefix='#__' )
	{
		$sql = trim( $sql );

		$escaped = false;
		$quoteChar = '';

		$n = strlen( $sql );

		$startPos = 0;
		$literal = '';
		while ($startPos < $n) {
			$ip = strpos($sql, $prefix, $startPos);
			if ($ip === false) {
				break;
			}

			$j = strpos( $sql, "'", $startPos );
			$k = strpos( $sql, '"', $startPos );
			if (($k !== FALSE) && (($k < $j) || ($j === FALSE))) {
				$quoteChar	= '"';
				$j			= $k;
			} else {
				$quoteChar	= "'";
			}

			if ($j === false) {
				$j = $n;
			}

			$literal .= str_replace( $prefix, $this->_table_prefix,substr( $sql, $startPos, $j - $startPos ) );
			$startPos = $j;

			$j = $startPos + 1;

			if ($j >= $n) {
				break;
			}

			// quote comes first, find end of quote
			while (TRUE) {
				$k = strpos( $sql, $quoteChar, $j );
				$escaped = false;
				if ($k === false) {
					break;
				}
				$l = $k - 1;
				while ($l >= 0 && $sql{$l} == '\\') {
					$l--;
					$escaped = !$escaped;
				}
				if ($escaped) {
					$j	= $k+1;
					continue;
				}
				break;
			}
			if ($k === FALSE) {
				// error in the query - no end quote; ignore it
				break;
			}
			$literal .= substr( $sql, $startPos, $k - $startPos + 1 );
			$startPos = $k+1;
		}
		if ($startPos < $n) {
			$literal .= substr( $sql, $startPos, $n - $startPos );
		}
		return $literal;
	}

	/**
	 * Get the active query
	 *
	 * @access public
	 * @return string The current value of the internal SQL vairable
	 */
	function getQuery() {
		return "<pre>" . htmlspecialchars( $this->_sql ) . "</pre>";
	}

	/**
	 * Execute the query
	 *
	 * @abstract
	 * @access public
	 * @return mixed A database resource if successful, FALSE if not.
	 */
	function query() {
		return;
	}

	/**
	 * Get the affected rows by the most recent query
	 *
	 * @abstract
	 * @access public
	 * @return int The number of affected rows in the previous operation
	 * @since 1.0.5
	 */
	function getAffectedRows() {
		return;
	}

   /**
	* Execute a batch query
	*
	* @abstract
	* @access public
	* @return mixed A database resource if successful, FALSE if not.
	*/
	function queryBatch( $abort_on_error=true, $p_transaction_safe = false) {
		return false;
	}

	/**
	 * Diagnostic function
	 *
	 * @abstract
	 * @access public
	 */
	function explain() {
		return;
	}

	/**
	 * Get the number of rows returned by the most recent query
	 *
	 * @abstract
	 * @access public
	 * @param object Database resource
	 * @return int The number of rows
	 */
	function getNumRows( $cur=null ) {
		return;
	}

	/**
	 * This method loads the first field of the first row returned by the query.
	 *
	 * @abstract
	 * @access public
	 * @return The value returned in the query or null if the query failed.
	 */
	function loadResult() {
		return;
	}

	/**
	 * Load an array of single field results into an array
	 *
	 * @abstract
	 */
	function loadResultArray($numinarray = 0) {
		return;
	}

	/**
	* Fetch a result row as an associative array
	*
	* @abstract
	*/
	function loadAssoc() {
		return;
	}

	/**
	 * Load a associactive list of database rows
	 *
	 * @abstract
	 * @access public
	 * @param string The field name of a primary key
	 * @return array If key is empty as sequential list of returned records.
	 */
	function loadAssocList( $key='' ) {
		return;
	}

	/**
	 * This global function loads the first row of a query into an object
	 *
	 *
	 * @abstract
	 * @access public
	 * @param object
	 */
	function loadObject( ) {
		return;
	}

	/**
	* Load a list of database objects
	*
	* @abstract
	* @access public
	* @param string The field name of a primary key
	* @return array If <var>key</var> is empty as sequential list of returned records.

	* If <var>key</var> is not empty then the returned array is indexed by the value
	* the database key.  Returns <var>null</var> if the query fails.
	*/
	function loadObjectList( $key='' ) {
		return;
	}

	/**
	 * Load the first row returned by the query
	 *
	 * @abstract
	 * @access public
	 * @return The first row of the query.
	 */
	function loadRow() {
		return;
	}

	/**
	* Load a list of database rows (numeric column indexing)
	*
	* If <var>key</var> is not empty then the returned array is indexed by the value
	* the database key.  Returns <var>null</var> if the query fails.
	*
	* @abstract
	* @access public
	* @param string The field name of a primary key
	* @return array
	*/
	function loadRowList( $key='' ) {
		return;
	}

	/**
	 * Insert an object in the database
	 *
	 * @abstract
	 * @access public
	 * @param string The table name
	 * @param object
	 * @param string
	 * @param boolean
	 */
	function insertObject( $table, &$object, $keyName = NULL, $verbose=false ) {
		return;
	}

	/**
	 * Update ab object in the database
	 *
	 * @abstract
	 * @access public
	 * @param string
	 * @param object
	 * @param string
	 * @param boolean
	 */
	function updateObject( $table, &$object, $keyName, $updateNulls=true ) {
		return;
	}

	/**
	 * Print out an error statement
	 *
	 * @param boolean If TRUE, displays the last SQL statement sent to the database
	 * @return string A standised error message
	 */
	function stderr( $showSQL = false ) {
		if ( $this->_errorNum != 0 ) {
			return "DB function failed with error number $this->_errorNum"
			."<br /><font color=\"red\">$this->_errorMsg</font>"
			.($showSQL ? "<br />SQL = <pre>$this->_sql</pre>" : '');
		} else {
			return "DB function reports no errors";
		}
	}

	/**
	 * Get the ID generated from the previous INSERT operation
	 *
	 * @abstract
	 * @access public
	 * @return mixed
	 */
	function insertid() {
		return;
	}

	/**
	 * Get the database collation
	 *
	 * @abstract
	 * @access public
	 * @return string Collation in use
	 */
	function getCollation() {
		return;
	}

	/**
	 * Get the version of the database connector
	 *
	 * @abstract
	 */
	function getVersion() {
		return 'Not available for this connector';
	}

	/**
	 * List tables in a database
	 *
	 * @abstract
	 * @access public
	 * @return array A list of all the tables in the database
	 */
	function getTableList() {
		return;
	}

	/**
	 *
	 *
	 * @abstract
	 * @access public
	 * @param array A list of table names
	 * @return array A list the create SQL for the tables
	 */
	function getTableCreate( $tables ) {
		return;
	}

	/**
	 * List database table fields
	 *
	 * @abstract
	 * @access public
	 * @param array A list of table names
	 * @return array An array of fields by table
	 */
	function getTableFields( $tables ) {
		return;
	}

	// ----
	// ADODB Compatibility Functions
	// ----

	/**
	* Get a quoted database escaped string
	*
	* @access public
	* @return string
	*/
	function Quote( $text ) {
		return '\'' . $this->getEscaped( $text ) . '\'';
	}

	/**
	 * ADODB compatability function
	 *
	 * @access public
	 * @param string SQL
	 * @since 1.5
	 */
	function GetCol( $query )
	{
		$this->setQuery( $query );
		return $this->loadResultArray();
	}

	/**
	 * ADODB compatability function
	 *
	 * @access public
	 * @param string SQL
	 * @return object
	 * @since 1.5
	 */
	function Execute( $query )
	{
		jimport( 'joomla.database.recordset' );

		$query = trim( $query );
		$this->setQuery( $query );
		if (eregi( '^select', $query )) {
			$result = $this->loadRowList();
			return new JRecordSet( $result );
		} else {
			$result = $this->query();
			if ($result === false) {
				return false;
			} else {
				return new JRecordSet( array() );
			}
		}
	}

	/**
	 * ADODB compatability function
	 *
	 * @access public
	 * @since 1.5
	 */
	function SelectLimit( $query, $count, $offset=0 )
	{
		jimport( 'joomla.database.recordset' );

		$this->setQuery( $query, $offset, $count );
		$result = $this->loadRowList();
		return new JRecordSet( $result );
	}

	/**
	 * ADODB compatability function
	 *
	 * @access public
	 * @since 1.5
	 */
	function PageExecute( $sql, $nrows, $page, $inputarr=false, $secs2cache=0 )
	{
		jimport( 'joomla.database.recordset' );

		$this->setQuery( $sql, $page*$nrows, $nrows );
		$result = $this->loadRowList();
		return new JRecordSet( $result );
	}
	/**
	 * ADODB compatability function
	 *
	 * @access public
	 * @param string SQL
	 * @return array
	 * @since 1.5
	 */
	function GetRow( $query )
	{
		$this->setQuery( $query );
		$result = $this->loadRowList();
		return $result[0];
	}

	/**
	 * ADODB compatability function
	 *
	 * @access public
	 * @param string SQL
	 * @return mixed
	 * @since 1.5
	 */
	function GetOne( $query )
	{
		$this->setQuery( $query );
		$result = $this->loadResult();
		return $result;
	}

	/**
	 * ADODB compatability function
	 *
	 * @since 1.5
	 */
	function BeginTrans() {
	}

	/**
	 * ADODB compatability function
	 *
	 * @since 1.5
	 */
	function RollbackTrans() {
	}

	/**
	 * ADODB compatability function
	 *
	 * @since 1.5
	 */
	function CommitTrans() {
	}

	/**
	 * ADODB compatability function
	 *
	 * @since 1.5
	 */
	function ErrorMsg() {
		return $this->getErrorMsg();
	}

	/**
	 * ADODB compatability function
	 *
	 * @since 1.5
	 */
	function ErrorNo() {
		return $this->getErrorNum();
	}

	/**
	 * ADODB compatability function
	 *
	 * @since 1.5
	 */
	function GenID( $foo1=null, $foo2=null ) {
		return '0';
	}
}

?>
