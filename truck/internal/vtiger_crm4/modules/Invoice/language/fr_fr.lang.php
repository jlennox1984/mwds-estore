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
 * Contributor(s): Abos (contact@abonlinesolutions.com), Jay, Ivan Stankovic.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /cvsroot/vtigercrm/vtiger_crm/modules/Facture/language/en_us.lang.php,v 1.13 2005/07/13 08:49:52 saraj Exp $
 * Description:  Defines the English language pack 
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): Abos (contact@abonlinesolutions.com), Jay, Ivan Stankovic.
 ********************************************************************************/
 
$mod_strings = Array(
'LBL_MODULE_NAME'=>'Facture',
'LBL_SO_MODULE_NAME'=>'Facture',
'LBL_RELATED_PRODUCTS'=>'Line Items',
'LBL_MODULE_TITLE'=>'Facture: Accueil',
'LBL_SEARCH_FORM_TITLE'=>'Chercher facture',
'LBL_LIST_FORM_TITLE'=>'Liste des factures',
'LBL_LIST_SO_FORM_TITLE'=>'Liste des commandes',
'LBL_NEW_FORM_TITLE'=>'Créer facture',
'LBL_NEW_FORM_SO_TITLE'=>'Créer commande',
'LBL_MEMBER_ORG_FORM_TITLE'=>'Entreprises membre',

'LBL_LIST_ACCOUNT_NAME'=>'Nom du compte',
'LBL_LIST_CITY'=>'Ville',
'LBL_LIST_WEBSITE'=>'Site web',
'LBL_LIST_STATE'=>'Etat/province',
'LBL_LIST_PHONE'=>'Téléphone',
'LBL_LIST_EMAIL_ADDRESS'=>'Email',
'LBL_LIST_CONTACT_NAME'=>'Nom du contact',

//DON'T CONVERT THESE THEY ARE MAPPINGS
'db_name'=>'LBL_LIST_ACCOUNT_NAME',
'db_website'=>'LBL_LIST_WEBSITE',
'db_billing_address_city'=>'LBL_LIST_CITY',

//END DON'T CONVERT

'LBL_ACCOUNT'=>'Compte:',
'LBL_ACCOUNT_NAME'=>'Nom du compte:',
'LBL_PHONE'=>'Téléphone:',
'LBL_WEBSITE'=>'Site web:',
'LBL_FAX'=>'Fax:',
'LBL_TICKER_SYMBOL'=>'Symbole boursier:',
'LBL_OTHER_PHONE'=>'Autre téléphone:',
'LBL_ANY_PHONE'=>'Téléphone alternatif:',
'LBL_MEMBER_OF'=>'Membre de:',
'LBL_EMAIL'=>'Email:',
'LBL_EMPLOYEES'=>'Employés:',
'LBL_OTHER_EMAIL_ADDRESS'=>'Autre Email:',
'LBL_ANY_EMAIL'=>'Email alternatif:',
'LBL_OWNERSHIP'=>'Propriétaire:',
'LBL_RATING'=>'Etat:',
'LBL_INDUSTRY'=>'Secteur:',
'LBL_SIC_CODE'=>'Code NAF:',
'LBL_TYPE'=>'Type:',
'LBL_ANNUAL_REVENUE'=>'Chiffre d\'affaire annuel:',
'LBL_ADDRESS_INFORMATION'=>'Adresse',
'LBL_Quote_INFORMATION'=>'Information compte',
'LBL_CUSTOM_INFORMATION'=>'Informations personnalisés',
'LBL_BILLING_ADDRESS'=>'Adresse de facturation:',
'LBL_SHIPPING_ADDRESS'=>'Adresse de livraison:',
'LBL_ANY_ADDRESS'=>'Adresse alternative:',
'LBL_CITY'=>'Ville:',
'LBL_STATE'=>'Etat:',
'LBL_POSTAL_CODE'=>'Code postal:',
'LBL_COUNTRY'=>'Pays:',
'LBL_DESCRIPTION_INFORMATION'=>'Information description',
'LBL_DESCRIPTION'=>'Description:',
'LBL_TERMS_INFORMATION'=>'Conditions générale de vente',
'NTC_COPY_BILLING_ADDRESS'=>'Utiliser adresse de facturation comme adresse de livraison',
'NTC_COPY_SHIPPING_ADDRESS'=>'Utiliser adresse de livraison comme adresse de facturation',
'NTC_REMOVE_MEMBER_ORG_CONFIRMATION'=>'Etes-vous certain de vouloir retirer cet enregistrement des membres de cette organisation?',
'LBL_DUPLICATE'=>'Compte en doublon probable',
'MSG_DUPLICATE'=>'Créer ce compte engendrera probablement un doublon. Vous pouvez au choix, forcer la création de ce compte, ou en sélectionner un dans la liste ci-dessous',

'LBL_INVITEE'=>'Contacts',
'ERR_DELETE_RECORD'=>"Une référence doit être spécifiée pour supprimer l\'enregistrement.",

'LBL_SELECT_ACCOUNT'=>'Sélectionner un compte',
'LBL_GENERAL_INFORMATION'=>'Information générale',

//for v4 release added
'LBL_NEW_POTENTIAL'=>'Ajouter Affaire',
'LBL_POTENTIAL_TITLE'=>'Affaires',

'LBL_NEW_TASK'=>'Ajouter Tâche',
'LBL_TASK_TITLE'=>'Tâches',
'LBL_NEW_CALL'=>'Ajouter appel',
'LBL_CALL_TITLE'=>'Appels',
'LBL_NEW_MEETING'=>'Ajouter réunion',
'LBL_MEETING_TITLE'=>'Réunion',
'LBL_NEW_EMAIL'=>'Ajouter Email',
'LBL_EMAIL_TITLE'=>'Emails',
'LBL_NEW_CONTACT'=>'Ajouter contact',
'LBL_CONTACT_TITLE'=>'Contacts',

//Added fields after RC1 - Release
'LBL_ALL'=>'Tout',
'LBL_PROSPECT'=>'Prospect',
'LBL_INVESTOR'=>'Investisseur',
'LBL_RESELLER'=>'Revendeur',
'LBL_PARTNER'=>'Partenaire',

// Added for 4GA
'LBL_TOOL_FORM_TITLE'=>'Outils',
//Added for 4GA
'Subject'=>'Objet',
'Quote Name'=>'Nom du devis',
'Vendor Name'=>'Nom du vendeur',
'Invoice Terms'=>'Conditions',
'Invoice Date'=>'Date de facturation',
'Sub Total'=>'Sous Total',
'Due Date'=>'Due le',
'Carrier'=>'Carrier',
'Type'=>'Type',
'Sales Tax'=>'GST',
'Sales Commission'=>'Commission',
'Excise Duty'=>'Remise',
'Total'=>'Total',
'Product Name'=>'Nom du produit',
'Assigned To'=>'Assigné à',
'Billing Address'=>'Adresse de facturation',
'Shipping Address'=>'Adresse de livraison',
'Billing City'=>'Ville',
'Billing State'=>'Etat/Province',
'Billing Code'=>'Code postal',
'Billing Country'=>'Pays',
'Shipping City'=>'Ville',
'Shipping State'=>'Etat/Province',
'Shipping Code'=>'Code postal',
'Shipping Country'=>'Pays',
'City'=>'Ville',
'State'=>'Etat/Province',
'Code'=>'Code postal',
'Country'=>'Pays',
'Created Time'=>'Créé le',
'Modified Time'=>'Modifié le',
'Description'=>'Description',
'Potential Name'=>'Nom de l\'affaire',
'Customer No'=>'Ref Client',
'Sales Order'=>'Vente',
'Notes'=>'Notes',
'Pending'=>'En attente',
'Account Name'=>'Nom du compte',
'Terms & Conditions'=>'Conditions Générales de Vente',
//Quote Info
'LBL_INVOICE_INFORMATION'=>'Facture Information',
'LBL_INVOICE'=>'Facture:',
'LBL_SO_INFORMATION'=>'Information vente',
'LBL_SO'=>'Vente:',

//Added in release 4.2
'LBL_SUBJECT'=>'Objet:',
'LBL_SALES_ORDER'=>'Vente:',
'Facture Id'=>'Ref Facture',
'LBL_MY_TOP_INVOICE'=>'Top Factures',
'LBL_INVOICE_NAME'=>'Nom de Facture:',
'Purchase Order'=>'Commande',
'Status'=>'Status',

);

?>
