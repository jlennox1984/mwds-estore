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

include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/SugarBean.php');
require_once('data/CRMEntity.php');
require_once('include/utils.php');


class Product extends CRMEntity {
	var $log;
	var $db;


	// Stored fields
	var $id;
	var $mode;

	// These are related
	var $name;
	var $vendorid;
	var $contactname;
	var $contactid;

	var $tab_name = Array('crmentity','stockmaster','productcf','seproductsrel');
	var $tab_name_index = Array('crmentity'=>'crmid','stockmaster'=>'productid','productcf'=>'productid','seproductsrel'=>'productid');
	var $column_fields = Array();

	var $sortby_fields = Array('description','stockid','commissionrate');		  

        // This is the list of fields that are in the lists.
        var $list_fields = Array(
                                'Product Name'=>Array('stockmaster'=>'description'),
                                'Product Code'=>Array('stockmaster'=>'stockid'),
                                'Commission Rate'=>Array('stockmaster'=>'commissionrate'),
                                'Qty/Unit'=>Array('stockmaster'=>'qty_per_unit'),
                                'Unit Price'=>Array('stockmaster'=>'unit_price')
                                );
        var $list_fields_name = Array(
                                        'Product Name'=>'description',
                                        'Product Code'=>'stockid',
                                        'Commission Rate'=>'commissionrate',
                                        'Qty/Unit'=>'qty_per_unit',
                                        'Unit Price'=>'unit_price'
                                     );
        var $list_link_field= 'description';


	var $list_mode;
	var $popup_type;

	var $search_fields = Array(
                                'Product Name'=>Array('stockmaster'=>'description'),
                                'Product Code'=>Array('stockmaster'=>'stockid'),
                                'Unit Price'=>Array('stockmaster'=>'unit_price')
                                );
        var $search_fields_name = Array(
                                        'Product Name'=>'description',
                                        'Product Code'=>'stockid',
                                        'Unit Price'=>'unit_price'
                                     );
	
	var $combofieldNames = Array('manufacturer'=>'manufacturer_dom'
                      ,'stockcategory'=>'productcategory_dom');


	function Product() {
		$this->log =LoggerManager::getLogger('product');
		$this->db = new PearDatabase();
		$this->column_fields = getColumnFields('Products');
	}

  function get_summary_text()
        {
                return $this->name;
        }

  		
	function get_attachments($id)
        {
	
		$query = "select notes.title,'Notes      ' ActivityType, notes.filename, attachments.type  FileType,crm2.modifiedtime  lastmodified, seattachmentsrel.attachmentsid attachmentsid, notes.notesid crmid from notes inner join senotesrel on senotesrel.notesid= notes.notesid inner join crmentity on crmentity.crmid= senotesrel.crmid inner join crmentity crm2 on crm2.crmid=notes.notesid left join seattachmentsrel  on seattachmentsrel.crmid =notes.notesid left join attachments on seattachmentsrel.attachmentsid = attachments.attachmentsid where crmentity.crmid=".$id;
                $query .= ' union all ';
                $query .= "select attachments.description title ,'Attachments'  ActivityType, attachments.name  filename, attachments.type  FileType,crm2.modifiedtime  lastmodified, attachments.attachmentsid attachmentsid, seattachmentsrel.attachmentsid crmid from attachments inner join seattachmentsrel on seattachmentsrel.attachmentsid= attachments.attachmentsid inner join crmentity on crmentity.crmid= seattachmentsrel.crmid inner join crmentity crm2 on crm2.crmid=attachments.attachmentsid where crmentity.crmid=".$id;	
		renderRelatedAttachments($query,$id);
        }

	function get_opportunities($id)
        {
		$query = 'select potential.potentialid, potential.potentialname, potential.potentialtype,  stockmaster.productid, stockmaster.description, stockmaster.qty_per_unit, stockmaster.unit_price, stockmaster.expiry_date from potential inner join stockmaster on potential.productid = stockmaster.productid where stockmaster.productid='.$id;
          renderRelatedPotentials($query);
        }

	function get_tickets($id)
        {
		//$query = 'select users.user_name, users.id, stockmaster.productid,stockmaster.description, troubletickets.ticketid, troubletickets.parent_id, troubletickets.title, troubletickets.status, troubletickets.priority, crmentity.crmid, crmentity.smownerid, crmentity.modifiedtime from stockmaster  inner join seticketsrel on seticketsrel.crmid = stockmaster.productid inner join troubletickets on troubletickets.ticketid = seticketsrel.ticketid inner join crmentity on crmentity.crmid = troubletickets.ticketid left join users on users.id=crmentity.smownerid where stockmaster.productid= '.$id.' and crmentity.deleted=0';
		$query = "select users.user_name, users.id, stockmaster.productid,stockmaster.description, troubletickets.ticketid, troubletickets.parent_id, troubletickets.title, troubletickets.status, troubletickets.priority, crmentity.crmid, crmentity.smownerid, crmentity.modifiedtime from troubletickets inner join crmentity on crmentity.crmid = troubletickets.ticketid left join stockmaster on stockmaster.productid=troubletickets.product_id left join users on users.id=crmentity.smownerid where crmentity.deleted=0 and stockmaster.productid=".$id;
          renderRelatedTickets($query,$id);
        }

	function get_meetings($id)
	{
		$query = "SELECT meetings.name,meetings.location,meetings.date_start from meetings inner join seactivityrel on seactivityrel.activityid=meetings.meetingid and seactivityrel.crmid=".$id."";
		renderRelatedMeetings($query);
	}

	function get_activities($id)
	{
		//$query = "SELECT activity.*,seactivityrel.*,crmentity.crmid, crmentity.smownerid, crmentity.modifiedtime, users.user_name from activity inner join seactivityrel on seactivityrel.activityid=activity.activityid inner join crmentity on crmentity.crmid=activity.activityid left join users on users.id=crmentity.smownerid where seactivityrel.crmid=".$id." and (activitytype='Task' or activitytype='Call' or activitytype='Meeting')";
		$query = "SELECT contactdetails.lastname, contactdetails.firstname, contactdetails.contactid, activity.*,seactivityrel.*,crmentity.crmid, crmentity.smownerid, crmentity.modifiedtime, users.user_name,recurringevents.recurringtype from activity inner join seactivityrel on seactivityrel.activityid=activity.activityid inner join crmentity on crmentity.crmid=activity.activityid left join cntactivityrel on cntactivityrel.activityid= activity.activityid left join contactdetails on contactdetails.contactid = cntactivityrel.contactid left join users on users.id=crmentity.smownerid left outer join recurringevents on recurringevents.activityid=activity.activityid where seactivityrel.crmid=".$id." and (activitytype='Task' or activitytype='Call' or activitytype='Meeting')";
		renderRelatedActivities($query,$id);
	}
	function get_quotes($id)
 	{
		$query = "select crmentity.*, quotes.*,potential.potentialname,custbranch.brname,quotesproductrel.productid from quotes inner join crmentity on crmentity.crmid=quotes.quoteid inner join quotesproductrel on quotesproductrel.quoteid=quotes.quoteid left outer join custbranch on custbranch.accountid=quotes.accountid left outer join potential on potential.potentialid=quotes.potentialid where crmentity.deleted=0 and quotesproductrel.productid=".$id;
		renderRelatedQuotes($query,$id,$this->column_fields['contact_id'],$this->column_fields['parent_id']);
	}
	function get_purchase_orders($id)
	{
		$query = "select crmentity.*, purchaseorder.*,stockmaster.description,poproductrel.productid from purchaseorder inner join crmentity on crmentity.crmid=purchaseorder.purchaseorderid inner join poproductrel on poproductrel.purchaseorderid=purchaseorder.purchaseorderid inner join stockmaster on stockmaster.productid=poproductrel.productid where crmentity.deleted=0 and stockmaster.productid=".$id;
	      	renderProductPurchaseOrders($query,$id,$this->column_fields['vendor_id']);
        }
	function get_salesorder($id)
	{
		$query = "select crmentity.*, salesorder.*, stockmaster.description as description, custbranch.brname from salesorder inner join crmentity on crmentity.crmid=salesorder.salesorderid inner join salesordertails on salesordertails.salesorderid=salesorder.salesorderid inner join stockmaster on stockmaster.productid=salesorderdetails.productid left outer join custbranch on custbranch.accountid=salesorder.accountid where crmentity.deleted=0 and stockmaster.productid = ".$id;
		renderProductSalesOrders($query,$id,$this->column_fields['contact_id'],$this->column_fields['parent_id']);	
	}
	function get_invoices($id)
	{
		$query = "select crmentity.*, invoice.*, invoiceproductrel.quantity, custbranch.brname from invoice inner join crmentity on crmentity.crmid=invoice.invoiceid left outer join custbranch on custbranch.accountid=invoice.accountid inner join invoiceproductrel on invoiceproductrel.invoiceid=invoice.invoiceid where crmentity.deleted=0 and invoiceproductrel.productid=".$id;
		renderRelatedInvoices($query,$id,$this->column_fields['parent_id']);
	}
	function get_product_pricebooks($id)
        {                                                                                                                     
       	 	$query = 'select crmentity.crmid, pricebook.*,pricebookproductrel.productid as prodid from pricebook inner join crmentity on crmentity.crmid=pricebook.pricebookid inner join pricebookproductrel on pricebookproductrel.pricebookid=pricebook.pricebookid where crmentity.deleted=0 and pricebookproductrel.productid='.$id; 
	 	renderProductRelatedPriceBooks($query,$id);                                                                  
	}
	function product_novendor()
	{
		$query = "SELECT stockmaster.description,crmentity.deleted from stockmaster inner join crmentity on crmentity.crmid=stockmaster.productid where crmentity.deleted=0 and stockmaster.vendor_id=''";
		$result=$this->db->query($query);
		return $this->db->num_rows($result);
	}

}
?>
