<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/**
*
* @version $Id: ps_linkpoint.cfg.php 687 2007-02-20 07:37:34Z soeren_nb $
* @package VirtueMart
* @subpackage payment
* @copyright Copyright (C) 2007 Soeren Eberhardt. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/
define ('LP_TEST_REQUEST', 'YES');
define ('LP_LOGIN', 'xxxx');
define ('LP_TYPE', '');
define ('LP_KEYFILE', '/etc/linkpoint/linkpoint.pem');
define ('LP_CHECK_CARD_CODE', 'YES');
define ('LP_RECURRING', 'NO');
define ('LP_PREAUTH', 'YES');
?>