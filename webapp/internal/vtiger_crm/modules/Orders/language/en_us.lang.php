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
 * $Header: /cvsroot/vtigercrm/vtiger_crm/modules/Orders/language/en_us.lang.php,v 1.11 2005/07/12 19:34:55 crouchingtiger Exp $
 * Description:  Defines the English language pack 
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
$mod_strings = Array(
'LBL_MODULE_NAME'=>'Orders',
'LBL_SO_MODULE_NAME'=>'Sales Order',
'LBL_RELATED_PRODUCTS'=>'Line Items',
'LBL_MODULE_TITLE'=>'Orders: Home',
'LBL_SEARCH_FORM_TITLE'=>'Orders Search',
'LBL_LIST_FORM_TITLE'=>'Purchase Order List',
'LBL_LIST_SO_FORM_TITLE'=>'Sales Order List',
'LBL_NEW_FORM_TITLE'=>'New Purchase Order',
'LBL_NEW_FORM_SO_TITLE'=>'New Sales Order',
'LBL_MEMBER_ORG_FORM_TITLE'=>'Member Organizations',

'LBL_LIST_ACCOUNT_NAME'=>'Account Name',
'LBL_LIST_CITY'=>'City',
'LBL_LIST_WEBSITE'=>'Website',
'LBL_LIST_STATE'=>'State',
'LBL_LIST_PHONE'=>'Phone',
'LBL_LIST_EMAIL_ADDRESS'=>'Email Address',
'LBL_LIST_CONTACT_NAME'=>'Contact Name',

//DON'T CONVERT THESE THEY ARE MAPPINGS
'db_name' => 'LBL_LIST_ACCOUNT_NAME',
'db_website' => 'LBL_LIST_WEBSITE',
'db_billing_address_city' => 'LBL_LIST_CITY',

//END DON'T CONVERT

'LBL_ACCOUNT'=>'Account:',
'LBL_ACCOUNT_NAME'=>'Account Name:',
'LBL_PHONE'=>'Phone:',
'LBL_WEBSITE'=>'Website:',
'LBL_FAX'=>'Fax:',
'LBL_TICKER_SYMBOL'=>'Ticker Symbol:',
'LBL_OTHER_PHONE'=>'Other Phone:',
'LBL_ANY_PHONE'=>'Any Phone:',
'LBL_MEMBER_OF'=>'Member of:',
'LBL_EMAIL'=>'Email:',
'LBL_EMPLOYEES'=>'Employees:',
'LBL_OTHER_EMAIL_ADDRESS'=>'Other Email:',
'LBL_ANY_EMAIL'=>'Any Email:',
'LBL_OWNERSHIP'=>'Ownership:',
'LBL_RATING'=>'Rating:',
'LBL_INDUSTRY'=>'Industry:',
'LBL_SIC_CODE'=>'SIC Code:',
'LBL_TYPE'=>'Type:',
'LBL_ANNUAL_REVENUE'=>'Annual Revenue:',
'LBL_ADDRESS_INFORMATION'=>'Address Information',
'LBL_Quote_INFORMATION'=>'Account Information',
'LBL_CUSTOM_INFORMATION'=>'Custom Information',
'LBL_BILLING_ADDRESS'=>'Billing Address:',
'LBL_SHIPPING_ADDRESS'=>'Shipping Address:',
'LBL_ANY_ADDRESS'=>'Any Address:',
'LBL_CITY'=>'City:',
'LBL_STATE'=>'State:',
'LBL_POSTAL_CODE'=>'Postal Code:',
'LBL_COUNTRY'=>'Country:',
'LBL_DESCRIPTION_INFORMATION'=>'Description Information',
'LBL_TERMS_INFORMATION'=>'Terms & Conditions',
'LBL_DESCRIPTION'=>'Description:',
'NTC_COPY_BILLING_ADDRESS'=>'Copy billing address to shipping address',
'NTC_COPY_SHIPPING_ADDRESS'=>'Copy shipping address to billing address',
'NTC_REMOVE_MEMBER_ORG_CONFIRMATION'=>'Are you sure you want to remove this record as a member organization?',
'LBL_DUPLICATE'=>'Potential Duplicate Accounts',
'MSG_DUPLICATE' => 'Creating this account may potentialy create a duplicate account. You may either select an account from the list below or you may click on Create New Account to continue creating a new account with the previously entered data.',

'LBL_INVITEE'=>'Contacts',
'ERR_DELETE_RECORD'=>"A record number must be specified to delete the account.",

'LBL_SELECT_ACCOUNT'=>'Select Account',
'LBL_GENERAL_INFORMATION'=>'General Information',

//for v4 release added
'LBL_NEW_POTENTIAL'=>'New Potential',
'LBL_POTENTIAL_TITLE'=>'Potentials',

'LBL_NEW_TASK'=>'New Task',
'LBL_TASK_TITLE'=>'Tasks',
'LBL_NEW_CALL'=>'New Call',
'LBL_CALL_TITLE'=>'Calls',
'LBL_NEW_MEETING'=>'New Meeting',
'LBL_MEETING_TITLE'=>'Meetings',
'LBL_NEW_EMAIL'=>'New Email',
'LBL_EMAIL_TITLE'=>'Emails',
'LBL_NEW_CONTACT'=>'New Contact',
'LBL_CONTACT_TITLE'=>'Contacts',

//Added fields after RC1 - Release
'LBL_ALL'=>'All',
'LBL_PROSPECT'=>'Prospect',
'LBL_INVESTOR'=>'Investor',
'LBL_RESELLER'=>'Reseller',
'LBL_PARTNER'=>'Partner',

// Added for 4GA
'LBL_TOOL_FORM_TITLE'=>'Account Tools',
//Added for 4GA
'PO Number'=>'PO Number',
'Quote Name'=>'Quote Name',
'Vendor Name'=>'Vendor Name',
'Requisition No'=>'Requisition No',
'Tracking Number'=>'Tracking Number',
'Contact Name'=>'Contact Name',
'Due Date'=>'Due Date',
'Carrier'=>'Carrier',
'Freight Charge'=>'Freight Charge',
'Deliver from'=>'Deliver from',
'Packlist Type'=>'Packlist Type',
'Type'=>'Type',
'Sales Tax'=>'GST',
'Sales Commission'=>'Sales Commission',
'Excise Duty'=>'Excise Duty',
'Total'=>'Total',
'Product Name'=>'Product Name',
'Assigned To'=>'Assigned To',
'Billing Address'=>'Billing Address',
'Shipping Address'=>'Shipping Address',
'Billing City'=>'Billing City',
'Billing State'=>'Billing State',
'Billing Code'=>'Billing Code',
'Billing Country'=>'Billing Country',
'Shipping City'=>'Shipping City',
'Shipping State'=>'Shipping State',
'Shipping Code'=>'Shipping Code',
'Shipping Country'=>'Shipping Country',
'City'=>'City',
'State'=>'State',
'Code'=>'Code',
'Country'=>'Country',
'Created Time'=>'Created Time',
'Modified Time'=>'Modified Time',
'Description'=>'Description',
'Potential Name'=>'Potential Name',
'Customer No'=>'Customer No',
'Purchase Order'=>'Purchase Order',
'Vendor Terms'=>'Vendor Terms',
'Pending'=>'Pending',
'Account Name'=>'Account Name',
'Terms & Conditions'=>'Terms & Conditions',
//Quote Info
'LBL_PO_INFORMATION'=>'Purchase Order Information',
'LBL_PO'=>'Purchase Order:',
'LBL_SO_INFORMATION'=>'Sales Order Information',
'LBL_SO'=>'Sales Order:',

 //Added for 4.2 GA
'LBL_SO_FORM_TITLE'=>'Sales',
'LBL_PO_FORM_TITLE'=>'Purchase',
'LBL_SUBJECT_TITLE'=>'PO Number',
'LBL_VENDOR_NAME_TITLE'=>'Vendor Name',
'LBL_TRACKING_NO_TITLE'=>'Tracking No:',
'LBL_PO_SEARCH_TITLE'=>'Purchase Order Search',
'LBL_SO_SEARCH_TITLE'=>'Sales Order Search',
'LBL_QUOTE_NAME_TITLE'=>'Quote Name',
'Order Id'=>'Order Id',
'LBL_MY_TOP_SO'=>'My Top Open Sales Orders',
'Status'=>'Status'
);
?>
