<?php // compatibility
require_once( dirname(__FILE__)  .'/../libraries/loader.php' );

/**
* Legacy class, derive from JTable instead
* @deprecated As of version 1.5
*/
jimport( 'joomla.database.database' );
jimport( 'joomla.database.database.mysqli' );
/**
 * @package		Joomla
 * @deprecated As of version 1.5
 */
class database extends JDatabase {
	function __construct ($host='localhost', $user, $pass, $db='', $table_prefix='', $offline = true) {
		parent::__construct( 'mysqli', $host, $user, $pass, $db, $table_prefix );
	}
}
?>