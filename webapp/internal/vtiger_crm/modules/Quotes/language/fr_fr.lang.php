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
 * $Header: /cvsroot/vtigercrm/vtiger_crm/modules/Devis/language/en_us.lang.php,v 1.8 2005/07/07 14:43:53 saraj Exp $
 * Description:  Defines the English language pack 
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): Abos (contact@abonlinesolutions.com), Jay, Ivan Stankovic.
 ********************************************************************************/
 
$mod_strings = Array(
'LBL_MODULE_NAME'=>'Devis',
'LBL_MODULE_TITLE'=>'Devis: Accueil',
'LBL_SEARCH_FORM_TITLE'=>'Recherche Devis',
'LBL_LIST_FORM_TITLE'=>'Liste Devis',
'LBL_NEW_FORM_TITLE'=>'Créer devis',
'LBL_MEMBER_ORG_FORM_TITLE'=>'Membre de l\'organisation',

'LBL_LIST_ACCOUNT_NAME'=>'Nom du compte',
'LBL_RELATED_PRODUCTS'=>'Line Items',
'LBL_LIST_CITY'=>'Ville',
'LBL_LIST_WEBSITE'=>'Site web',
'LBL_LIST_STATE'=>'Etat / province',
'LBL_LIST_PHONE'=>'Téléphone',
'LBL_LIST_EMAIL_ADDRESS'=>'Adresse email',
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
'LBL_POTENTIAL_TITLE'=>'Potentials',

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
'Potential Name'=>'Nom de l\'affaire',
'Quote Stage'=>'Etape devis',
'Valid Till'=>'Valide jusqu\'a',
'Team'=>'Equipe',
'Contact Name'=>'Nom du contact',
'Currency'=>'Devise',
'Carrier'=>'Transporteur',
'Sub Total'=>'Sous Total',
'Shipping'=>'Livraison',
'Inventory Manager'=>'Gestion d\'inventaire',
'Type'=>'Type',
'Tax'=>'GST',
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
'Shipping Code'=>'Ref livraison',
'Shipping Country'=>'Pays de livraison',
'Created Time'=>'Créé le',
'Modified Time'=>'Modifié le',
'Description'=>'Description',
'Account Name'=>'Nom du compte',
'LBL_TERMS_INFORMATION'=>'Conditions Générale de Vente',
//Quote Info
'LBL_QUOTE_INFORMATION'=>'Information devis',
'LBL_TERMS_INFORMATION'=>'Conditions Générale de Vente',
'LBL_QUOTE'=>'Devis:',

//Added during 4.2 release
'LBL_SUBJECT'=>'Objet:',
'LBL_POTENTIAL_NAME'=>'Nom de l\'affaire:',
'LBL_ACCOUNT_NAME'=>'Nom du compte:',
'LBL_QUOTE_STAGE'=>'Etape du devis:',
'LBL_MY_TOP_QUOTE'=>'Top Devis',
'Quote Id'=>'Ref devis',

);

?>
