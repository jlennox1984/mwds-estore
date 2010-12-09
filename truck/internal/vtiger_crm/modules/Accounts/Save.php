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
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Accounts/Save.php,v 1.7 2005/03/15 09:55:31 shaw Exp $
 * Description:  Saves an Account record and then redirects the browser to the 
 * defined return URL.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Accounts/Account.php');
require_once('include/logging.php');
//require_once('database/DatabaseConnection.php');
require_once('include/database/PearDatabase.php');

$local_log =& LoggerManager::getLogger('index');
global $vtlog;
$focus = new Account();
if(isset($_REQUEST['record']))
{
	$focus->id = $_REQUEST['record'];
$vtlog->logthis("id is ".$focus->id,'info'); 
}
if(isset($_REQUEST['mode']))
{
	$focus->mode = $_REQUEST['mode'];
}

//$focus->retrieve($_REQUEST['record']);

foreach($focus->column_fields as $fieldname => $val)
{
	if(isset($_REQUEST[$fieldname]))
	{
		$value = $_REQUEST[$fieldname];
		//echo '<BR>';
		//echo $fieldname."         ".$value;
		//echo '<BR>';
		$focus->column_fields[$fieldname] = $value;
	}
		
}
$vtlog->logthis("branchcode is ".$focus->column_fields["branchcode"],'info'); 
if (!isset($focus->column_fields["branchcode"]) || $focus->column_fields["branchcode"] == '')
{

//$branchname = $focus->column_fields["brname"];
//$crmseqname = $focus->column_fields["crmseq"];
				

$tmp0 = strtoupper($focus->column_fields["brname"]);
$tmp0 = stripslashes($tmp0);
$special = array('/','!','&','*',' ','%','@','#','$','^','(',')','+','|','}','{','[',']',':',';','"','<','>','.','?',',');
$tmp0 = str_replace($special,'',$tmp0);
$tmp1 = str_replace("'","",$tmp0);
$vtlog->logthis("tmp0 is ".$tmp0,'info'); 
$vtlog->logthis("tmp1 is ".$tmp1,'info'); 

$tmp2 = substr($tmp1, 0, 3);
$tmp3 = $_REQUEST['crmseq'];
$vtlog->logthis("crmseq is ".$focus->column_fields["crmseq"],'info'); 
$vtlog->logthis("crmseq is ".$_REQUEST['crmseq'],'info'); 
$vtlog->logthis("crmseq is ".$focus->id,'info'); 

$tmp4 = "00000" . $tmp3;
$tmp5 = substr($tmp4,-4,4);
$tmp6 = $tmp2 . $tmp5;
$focus->column_fields["branchcode"] = $tmp6;
$vtlog->logthis("revised branchcode is ".$focus->column_fields["branchcode"],'info'); 
$vtlog->logthis("request branchcode is ".$_REQUEST['branchcode'],'info'); 

}
$vtlog->logthis("branchname is ".$focus->column_fields["brname"],'info'); 
$vtlog->logthis("request branchcode is ".$_REQUEST['branchcode'],'info'); 
$vtlog->logthis("branchcode is ".$focus->column_fields["branchcode"],'info'); 
//echo '<BR>';
//print_r($focus->column_fields);
//echo '<BR>';

/* foreach($focus->additional_column_fields as $field)
{
	if(isset($_REQUEST[$field]))
	{
		$value = $_REQUEST[$field];
		$focus->$field = $value;
		
	}
}*/

//$focus->saveentity("Accounts");
/* $focus->id1 = $_POST[['self'];
$focus->id2 = $_REQUEST['self'];
$vtlog->logthis("id1 is ".$focus->id1,'info'); 
$vtlog->logthis("id2 is ".$focus->id2,'info'); */
$focus->save("Accounts"); 
/*
$sqlq = "UPDATE custbranch set branchcode='".$tmp6."' where accountid='".$tmp3."'";
$vtlog->logthis("branchcode query is ".$sqlq,'info'); 
*/
$adb->query($sqlq);

 
        $debtorno = $focus->column_fields["debtorno"];
		$debtorname = $focus->column_fields["brname"];
		$address1 = $focus->column_fields["bill_street"];
		$address2 = $focus->column_fields["bill_street2"];
		$address3 = $focus->column_fields["bill_city"];
		$address4 = $focus->column_fields["bill_state"];
		$address5 = $focus->column_fields["bill_country"];
		$address6 = $focus->column_fields["bill_code"];
		$currcode = $focus->column_fields["currcode"];
		$clientsince = date("Y-m-d");
		$holdreason  = 20;
		$paymentterms = '7';
		$discount = 0;
		$discountcode = '';
		$pymtdiscount = 0;
		$creditlimit = '';
		$salestype = $focus->column_fields["area"];
		$invaddrbranch = 0;
		$taxref = '';
		
		
 		
$debtorname = mysql_real_escape_string($debtorname);

$address1 = mysql_real_escape_string($address1);
$address2 = mysql_real_escape_string($address2);
$address3 = mysql_real_escape_string($address3);
$address4 = mysql_real_escape_string($address4);
$address5 = mysql_real_escape_string($address5);
$address6 = mysql_real_escape_string($address6);
$vtlog->logthis("id is ".$focus->id,'info'); 
$vtlog->logthis("stipped debtor name is ".$debtorname,'info'); 

$vtlog->logthis("mode is ".$_REQUEST['mode'],'info'); 
if ($_REQUEST['mode']=='edit')

	{
		
        $query1 = "UPDATE debtorsmaster set
							currcode='" . $currcode . "',
							paymentterms='" . $paymentterms . "',
							salestype='" . $salestype . "',
							invaddrbranch='" . $addrinvbranch . "',
							taxref='" . $taxref . "'
					WHERE debtorno='" . $debtorno ."'
				";
					
					$adb->query($query1);
}


	
	else {

		
        $query1 = "INSERT INTO debtorsmaster (
							debtorno,
							name,
							address1,
							address2,
							address3,
							address4,
							address5,
							address6,
							currcode,
							clientsince,
							holdreason,
							paymentterms,
							discount,
							discountcode,
							pymtdiscount,
							creditlimit,
							salestype,
							invaddrbranch,
							taxref)
				VALUES ('" . $debtorno ."',
					'" . $debtorname ."',
					'" . $address1 ."',
					'" . $address2 ."',
					'" . $address3 ."',
					'" . $address4 . "',
					'" . $address5 . "',
					'" . $address6 . "',
					'" . $currcode . "',
					'" . $clientsince . "',
					" . $holdreason . ",
					'" . $paymentterms . "',
					" . $discount . ",
					'" . $discountcode . "',
					" . $pymtdiscount. ",
					'" . $creditlimit . "',
					'" . $salestype . "',
					'" . $addrinvbranch . "',
					'" . $taxref . "'
					)";
					
					$adb->query($query1);
}




//echo '<BR>';
//echo $focus->id;
$return_id = $focus->id;
//save_customfields($focus->id);

if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "Accounts";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
else $return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = $_REQUEST['return_id'];

$local_log->debug("Saved record with id of ".$return_id);

header("Location: index.php?action=$return_action&module=$return_module&record=$return_id");
//Code to save the custom field info into database


function stripslashes_checkstrings($value){
                 return stripslashes($value);
       }

function save_customfields($entity_id)
{
$vtlog->logthis("save customfields invoked",'info');
	global $adb;
	$dbquery="select * from customfields where module='Accounts'";
        /*
	$result = mysql_query($dbquery);
	$custquery = 'select * from accountcf where accountid="'.$entity_id.'"';
        $cust_result = mysql_query($custquery);
	if(mysql_num_rows($result) != 0)
        */
	$result = $adb->query($dbquery);
	$custquery = "select * from accountcf where accountid='".$entity_id."'";
        $cust_result = $adb->query($custquery);
	if($adb->num_rows($result) != 0)
	{
		
		$columns='';
		$values='';
		$update='';
                //	$noofrows = mysql_num_rows($result);
                $noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
                  //$fldName=mysql_result($result,$i,"fieldlabel");
                  //$colName=mysql_result($result,$i,"column_name");
	$fldName=$adb->query_result($result,$i,"fieldlabel");
			$colName=$adb->query_result($result,$i,"column_name");
			if(isset($_REQUEST[$colName]))
			{
				$fldvalue=$_REQUEST[$colName];
				if(get_magic_quotes_gpc() == 1)
                		{
                        		$fldvalue = stripslashes($fldvalue);
                		}
			}
			else
			{
				$fldvalue = '';
			}
			//if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && mysql_num_rows($cust_result) !=0)
                          if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && $adb->num_rows($cust_result) !=0)
			{
				//Update Block
				if($i == 0)
				{
                                  //$update = $colName.'="'.$fldvalue.'"';
                                        $update = $colName."='".$fldvalue."'";
				}
				else
				{
                                  //$update .= ', '.$colName.'="'.$fldvalue.'"';
                                        $update .= ', '.$colName."='".$fldvalue."'";
				}
			}
			else
			{
				//Insert Block
				if($i == 0)
				{
					$columns='accountid, '.$colName;
					//$values='"'.$entity_id.'", "'.$fldvalue.'"';
                                        $values="'".$entity_id."', '".$fldvalue."'";
				}
				else
				{
					$columns .= ', '.$colName;
					//$values .= ', "'.$fldvalue.'"';
                                        $values .= ", '".$fldvalue."'";
				}
			}
			
				
		}
		//if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && mysql_num_rows($cust_result) !=0)
                  if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && $adb->num_rows($cust_result) !=0)
		{
			//Update Block
                  //$query = 'update accountcf SET '.$update.' where accountid="'.$entity_id.'"'; 
                  //mysql_query($query);
                        $query = 'update accountcf SET '.$update." where accountid='".$entity_id."'"; 
			$adb->query($query);
		}
		else
		{
			//Insert Block
			$query = 'insert into accountcf ('.$columns.') values('.$values.')';
			//mysql_query($query);
                        $adb->query($query);
		}
		
	}
	// commented by srini - PATCH for saving accounts
	/*else
	{
          //if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && mysql_num_rows($cust_result) !=0)
                  if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && $adb->num_rows($cust_result) !=0)
		{
			//Update Block
		}
		else
		{
			//Insert Block
			$query = 'insert into accountcf ('.$columns.') values('.$values.')';
                        $adb->query($query);
			//mysql_query($query);
		}
	}*/	
}
?>
