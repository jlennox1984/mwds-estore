<?php


/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

global $adb;	
global $vtlog;
require_once('include/database/PearDatabase.php');
$idlist = $_POST['idlist'];
$returnmodule=$_REQUEST['return_module'];
$pricebook_id=$_REQUEST['pricebook_id'];
$productid=$_REQUEST['product_id'];
//$typeabbrev=getType($pricebook_id);
		

if(isset($_REQUEST['pricebook_id']) && $_REQUEST['pricebook_id']!='')
{
	//split the string and store in an array
	$storearray = explode(";",$idlist);
	foreach($storearray as $id)
	{
		$lp_name = $id.'_listprice';
		$list_price = $_REQUEST[$lp_name];
		$vtlog->logthis("id1 is ".$id,'info');
 
				if (isset($id) && $id !='')
	{	$stockid=getStockId($id);
		$currabrev=getCurrency($pricebook_id);
		$currabrev3=getCurrency3($pricebook_id);
		
		//Updating the pricebook product rel table
		$vtlog->logthis("Products :: Inserting products to price book","info");
		$query= "insert into prices (stockid,typeabbrev,currabrev,price,pricebookid,productid) values('".$stockid."','".$currabrev3."','".$currabrev."',".$list_price.",".$pricebook_id.",".$id.")";
		$adb->query($query);
	}
		
	}
	header("Location: index.php?module=Products&action=PriceBookDetailView&record=".$pricebook_id);
}
elseif(isset($_REQUEST['product_id']) && $_REQUEST['product_id']!='')
{
	//split the string and store in an array
	$storearray = explode(";",$idlist);
	foreach($storearray as $id)
	{
		$lp_name = $id.'_listprice';
		$list_price = $_REQUEST[$lp_name];
		 
 $vtlog->logthis("productid is ".$productid,'info'); 
 	if (isset($productid) && $productid !='')
	{	$stockid=getStockId($productid);
		$currabrev=getCurrency($pricebook_id);
		$currabrev3=getCurrency3($pricebook_id);
		//Updating the pricebook product rel table
		$vtlog->logthis("Products :: Inserting PriceBooks to Product","info");
		$query= "insert into prices (stockid,typeabbrev,currabrev,price,pricebookid,productid) values('".$stockid."','".$currabrev3."','".$currabrev."',".$list_price.",".$id.",".$productid.")";
		
		$adb->query($query);
	}	

		
	}
	header("Location: index.php?module=Products&action=DetailView&record=".$productid);
}


function getStockId($productid)
{
global $adb,$noof_group_rows;
global $vtlog;

	$sql2 = "SELECT stockmaster.stockid
		FROM stockmaster 
		WHERE stockmaster.productid=" . $productid ;
	$result2 = $adb->query($sql2);
	$noof_group_rows=$adb->num_rows($result2);
	$stockid=$adb->query_result($result2,0,"stockid");
	return $stockid;


}



function getType($pricebook_id)
{
	global $adb;
	global $vtlog;

	$query1 = "SELECT pricebook.pbcode 
		FROM pricebook 
		WHERE pricebook.pricebookid=" . $pricebook_id;
	$result1=$adb->query($query1);
	$typeabbrev= $adb->query_result($result1,0,"pbcode");
	return $typeabbrev;
	
	
}




function getCurrency($pricebook_id)
{
global $adb,$noof_group_rows;
global $vtlog;

	$sql = "SELECT pricebook.currcode 
		FROM pricebook 
		WHERE pricebook.pricebookid=" . $pricebook_id ;
	$result = $adb->query($sql);
	$noof_group_rows=$adb->num_rows($result);
	$currabrev=$adb->query_result($result,0,"currcode");
	return $currabrev;

}

function getCurrency3($pricebook_id)
{
global $adb,$noof_group_rows;
global $vtlog;

	$sql3 = "SELECT pricebook.pbcode 
		FROM pricebook 
		WHERE pricebook.pricebookid=" . $pricebook_id ;
	$result3 = $adb->query($sql3);
	$noof_group_rows=$adb->num_rows($result3);
	$currabrev3=$adb->query_result($result3,0,"pbcode");
	return $currabrev3;

}


?>

