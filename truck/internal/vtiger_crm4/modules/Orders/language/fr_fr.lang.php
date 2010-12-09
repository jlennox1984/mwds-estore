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
 * $Header: /cvsroot/vtigercrm/vtiger_crm/modules/Orders/language/en_us.lang.php,v 1.11 2005/07/12 19:34:55 crouchingtiger Exp $
 * Description:  Defines the English language pack 
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): Abos (contact@abonlinesolutions.com), Jay, Ivan Stankovic.
 ********************************************************************************/
 
$mod_strings = Array(
'LBL_MODULE_NAME'=>'Ventes',
'LBL_SO_MODULE_NAME'=>'Ventes & commandes',
'LBL_RELATED_PRODUCTS'=>'Relatif à',
'LBL_MODULE_TITLE'=>'Ventes: Accueil',
'LBL_SEARCH_FORM_TITLE'=>'Rechercher ventes',
'LBL_LIST_FORM_TITLE'=>'Liste de commande',
'LBL_LIST_SO_FORM_TITLE'=>'Liste de vente',
'LBL_NEW_FORM_TITLE'=>'Nouvelle commande',
'LBL_NEW_FORM_SO_TITLE'=>'Nouvelle vente',
'LBL_MEMBER_ORG_FORM_TITLE'=>'Membre de l\'organisation',

'LBL_LIST_ACCOUNT_NAME'=>'Nom du compte',
'LBL_LIST_CITY'=>'Ville',
'LBL_LIST_WEBSITE'=>'Site web',
'LBL_LIST_STATE'=>'Etat/Province',
'LBL_LIST_PHONE'=>'Téléphone',
'LBL_LIST_EMAIL_ADDRESS'=>'Email',
'LBL_LIST_CONTACT_NAME'=>'Nom du Contact',

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
'LBL_ANY_PHONE'=>'Téléphone Alternatif:',
'LBL_MEMBER_OF'=>'Membre de:',
'LBL_EMAIL'=>'Email:',
'LBL_EMPLOYEES'=>'Employés:',
'LBL_OTHER_EMAIL_ADDRESS'=>'Autre email:',
'LBL_ANY_EMAIL'=>'Email alternatif:',
'LBL_OWNERSHIP'=>'Propriétaire:',
'LBL_RATING'=>'Note:',
'LBL_INDUSTRY'=>'Secteur:',
'LBL_SIC_CODE'=>'Code NAF:',
'LBL_TYPE'=>'Type:',
'LBL_ANNUAL_REVENUE'=>'Chiffre d\'affaire:',
'LBL_ADDRESS_INFORMATION'=>'Adresse',
'LBL_Quote_INFORMATION'=>'Information du compte',
'LBL_CUSTOM_INFORMATION'=>'Information personnalisée',
'LBL_BILLING_ADDRESS'=>'Adresse de facturation:',
'LBL_SHIPPING_ADDRESS'=>'Adresse de livraison:',
'LBL_ANY_ADDRESS'=>'Adresse alternative',
'LBL_CITY'=>'Ville:',
'LBL_STATE'=>'Etat/Province:',
'LBL_POSTAL_CODE'=>'Code postal:',
'LBL_COUNTRY'=>'Pays:',
'LBL_DESCRIPTION_INFORMATION'=>'Description Information',
'LBL_TERMS_INFORMATION'=>'Conditions Générale de Vente',
'LBL_DESCRIPTION'=>'Description:',
'NTC_COPY_BILLING_ADDRESS'=>'Copier adresse de facturation vers adresse de livraison',
'NTC_COPY_SHIPPING_ADDRESS'=>'Copier adresse de facturation vers adresse de livraison',
'NTC_REMOVE_MEMBER_ORG_CONFIRMATION'=>'Etes vous sur de vouloir retirer cet enregistrement en tant que lien hiérarchique?',
'LBL_DUPLICATE'=>'Doublon affaire',
'MSG_DUPLICATE'=>'Créer ce compte engeandrera probablement un doublon. Vous pouvez au choix, forcer la création de ce compte, ou en sélectionner un dans la liste ci-dessous',

'LBL_INVITEE'=>'Contacts',
'ERR_DELETE_RECORD'=>"Une référence doit être spécifiée pour supprimer ce compte.",

'LBL_SELECT_ACCOUNT'=>'Sélectionner compte',
'LBL_GENERAL_INFORMATION'=>'Information générale',

//for v4 release added
'LBL_NEW_POTENTIAL'=>'Créer Affaire',
'LBL_POTENTIAL_TITLE'=>'Affaires',

'LBL_NEW_TASK'=>'Créer tâche',
'LBL_TASK_TITLE'=>'Tâche',
'LBL_NEW_CALL'=>'Créer appel',
'LBL_CALL_TITLE'=>'Appels',
'LBL_NEW_MEETING'=>'Créer réunion',
'LBL_MEETING_TITLE'=>'Réunions',
'LBL_NEW_EMAIL'=>'Créer Email',
'LBL_EMAIL_TITLE'=>'Emails',
'LBL_NEW_CONTACT'=>'Créer contact',
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
'Quote Name'=>'Facture',
'Vendor Name'=>'Fournisseur',
'Requisition No'=>'Ref Demande',
'Tracking Number'=>'Ref suivi',
'Contact Name'=>'Nom du contact',
'Due Date'=>'Date due',
'Carrier'=>'Transporteur',
'Type'=>'Type',
'Sales Tax'=>'GST',
'Sales Commission'=>'Commission',
'Excise Duty'=>'Avoir',
'Total'=>'Total',
'Product Name'=>'Nom du produit',
'Assigned To'=>'Assigné à',
'Billing Address'=>'Adresse de facturation',
'Shipping Address'=>'Adresse de livraison',
'Billing City'=>'Ville de facturation',
'Billing State'=>'Pays de facturation',
'Billing Code'=>'Ref facture',
'Billing Country'=>'Pays de facturation',
'Shipping City'=>'Ville de livraison',
'Shipping State'=>'Etat / province de livraison',
'Shipping Code'=>'Code livraison',
'Shipping Country'=>'Pays de livraison',
'City'=>'Ville',
'State'=>'Etat / Province',
'Code'=>'Code',
'Country'=>'Pays',
'Created Time'=>'Créé le',
'Modified Time'=>'Modifié le',
'Description'=>'Description',
'Potential Name'=>'Nom de l\'affaire',
'Customer No'=>'Ref Client',
'Purchase Order'=>'Commande',
'Vendor Terms'=>'Conditions fournisseur',
'Pending'=>'En attente',
'Account Name'=>'Nom du compte',
'LBL_TERMS_INFORMATION'=>'Conditions Générale de Vente',
//Quote Info
'LBL_PO_INFORMATION'=>'Information commande',
'LBL_PO'=>'Commande:',
'LBL_SO_INFORMATION'=>'Information vente',
'LBL_SO'=>'Vente:',

 //Added for 4.2 GA
'LBL_SO_FORM_TITLE'=>'Ventes',
'LBL_PO_FORM_TITLE'=>'Commandes',
'LBL_SUBJECT_TITLE'=>'Objet',
'LBL_VENDOR_NAME_TITLE'=>'Nom du fournisseur',
'LBL_TRACKING_NO_TITLE'=>'Ref suivi:',
'LBL_PO_SEARCH_TITLE'=>'Recherche commande',
'LBL_SO_SEARCH_TITLE'=>'Recherche vente',
'LBL_QUOTE_NAME_TITLE'=>'Nom facture',
'Order Id'=>'Ref de commande',
'LBL_MY_TOP_SO'=>'Top vente',
'Status'=>'Status',

);

?>
