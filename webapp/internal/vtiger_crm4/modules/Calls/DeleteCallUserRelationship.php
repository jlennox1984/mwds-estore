<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header:  vtiger_crm/sugarcrm/modules/Calls/DeleteCallUserRelationship.php,v 1.1 2004/08/17 15:03:41 gjayakrishnan Exp $
 * Description:  TODO: To be written.
 ********************************************************************************/

require_once('modules/Calls/Call.php');

require_once('include/logging.php');
$log = LoggerManager::getLogger('call user relationship delete');

$focus = new Call();

if(!isset($_REQUEST['user_id']) || !isset($_REQUEST['call_id']))
	die("A record number must be specified to delete the contact to call relationship.");

$focus->mark_call_user_relationship_deleted($_REQUEST['user_id'],$_REQUEST['call_id']);

header("Location: index.php?module=".$_REQUEST['return_module']."&action=".$_REQUEST['return_action']."&record=".$_REQUEST['return_id']);
?>
