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
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Users/language/en_us.lang.php,v 1.17 2005/03/28 03:56:00 rank Exp $
 * Description:  Defines the English language pack for the Account module.
 ********************************************************************************/
 
$mod_strings = Array(
'LBL_MODULE_NAME'=>'Utilisateurs',
'LBL_MODULE_TITLE'=>'Utilisateur: Accueil',
'LBL_SEARCH_FORM_TITLE'=>'Rechercher Utilisateurs',
'LBL_LIST_FORM_TITLE'=>'Liste des Utilisateurs',
'LBL_NEW_FORM_TITLE'=>'Cr�er Utilisateur',
'LBL_USER'=>'Utilisateurs:',
'LBL_LOGIN'=>'Login',
'LBL_USER_ROLE'=>'R�le',
'LBL_LIST_NAME'=>'Nom',
'LBL_LIST_LAST_NAME'=>'Nom de Famille',
'LBL_LIST_USER_NAME'=>'Nom d\'Utilisateur',
'LBL_LIST_DEPARTMENT'=>'D�partement',
'LBL_LIST_EMAIL'=>'Email',
'LBL_LIST_PRIMARY_PHONE'=>'T�l. Principal',
'LBL_LIST_ADMIN'=>'Admin',
//added for patch2
'LBL_GROUP_NAME'=>'Groupe',
'LBL_COLOR'=>'Couleur dans l\'agenda',

'LBL_NEW_USER_BUTTON_TITLE'=>'New Utilisateur [Alt+N]',
'LBL_NEW_USER_BUTTON_LABEL'=>'New Utilisateur',
'LBL_NEW_USER_BUTTON_KEY'=>'N',
'LBL_DATE_FORMAT'=>'Format des dates',

'LBL_ERROR'=>'Erreur:',
'LBL_PASSWORD'=>'Mot de passe:',
'LBL_USER_NAME'=>'Nom d\'Utilisateur:',
'LBL_FIRST_NAME'=>'Pr�nom:',
'LBL_LAST_NAME'=>'Nom de Famille:',
'LBL_YAHOO_ID'=>'Yahoo ID:',
'LBL_USER_SETTINGS'=>'Param�tres Utilisateur',
'LBL_THEME'=>'Th�me:',
'LBL_LANGUAGE'=>'Langue:',
'LBL_ADMIN'=>'Admin:',
'LBL_USER_INFORMATION'=>'Information sur l\'Utilisateur',
'LBL_OFFICE_PHONE'=>'T�l�phone Bureau:',
'LBL_REPORTS_TO'=>'Rend compte �:',
'LBL_OTHER_PHONE'=>'Autre:',
'LBL_OTHER_EMAIL'=>'Autre Email:',
'LBL_NOTES'=>'Notes:',
'LBL_DEPARTMENT'=>'D�partement:',
'LBL_STATUS'=>'Statut:',
'LBL_TITLE'=>'Fonction:',
'LBL_ANY_PHONE'=>'Un autre T�l�phone:',
'LBL_ANY_EMAIL'=>'Un autre Email:',
'LBL_ADDRESS'=>'Adresse:',
'LBL_CITY'=>'Ville:',
'LBL_STATE'=>'Etat:',
'LBL_POSTAL_CODE'=>'Code Postal:',
'LBL_COUNTRY'=>'Pays:',
'LBL_NAME'=>'Nom:',
'LBL_USER_SETTINGS'=>'Param�tres Utilisateur',
'LBL_USER_INFORMATION'=>'Information Utilisateur',
'LBL_MOBILE_PHONE'=>'Mobile:',
'LBL_OTHER'=>'Autre:',
'LBL_FAX'=>'Fax:',
'LBL_EMAIL'=>'Email:',
'LBL_HOME_PHONE'=>'T�l�phone Domicile:',
'LBL_ADDRESS_INFORMATION'=>'Information sur Adresse',
'LBL_PRIMARY_ADDRESS'=>'Adresse principale:',

'LBL_CHANGE_PASSWORD_BUTTON_TITLE'=>'Changer Mot de Passe [Alt+P]',
'LBL_CHANGE_PASSWORD_BUTTON_KEY'=>'P',
'LBL_CHANGE_PASSWORD_BUTTON_LABEL'=>'Changer Mot de Passe',
'LBL_LOGIN_BUTTON_TITLE'=>'Login [Alt+L]',
'LBL_LOGIN_BUTTON_KEY'=>'L',
'LBL_LOGIN_BUTTON_LABEL'=>'Login',
'LBL_LOGIN_HISTORY_BUTTON_TITLE'=>'Historique du Login [Alt+H]',
'LBL_LOGIN_HISTORY_BUTTON_KEY'=>'H',
'LBL_LOGIN_HISTORY_BUTTON_LABEL'=>'Historique Login',
'LBL_LOGIN_HISTORY_TITLE'=>'Utilisateurs: Historique du Login',
'LBL_RESET_PREFERENCES'=>'Remise � z�ro Pr�ferences',

'LBL_CHANGE_PASSWORD'=>'Changer le Mot de Passe',
'LBL_OLD_PASSWORD'=>'Ancien Mot de Passe:',
'LBL_NEW_PASSWORD'=>'New Mot de Passe:',
'LBL_CONFIRM_PASSWORD'=>'Confirmer Mot de Passe:',
'ERR_ENTER_OLD_PASSWORD'=>'Veuillez entrer votre ancien Mot de Passe.',
'ERR_ENTER_NEW_PASSWORD'=>'Veuillez entrer votre nouveau Mot de Passe.',
'ERR_ENTER_CONFIRMATION_PASSWORD'=>'Veuillez entrer votre confirmation de Mot de Passe.',
'ERR_REENTER_PASSWORDS'=>'Veuillez retaper vos Mots de Passe.  Le \"new Mot de Passe\" et \"Mot de Passe de confirmation\" ne sont pas identiques.',
'ERR_INVALID_PASSWORD'=>'Vous devez sp�cifier un nom Utilisateur et mot de passe valide.',
'ERR_PASSWORD_CHANGE_FAILED_1'=>'Echec du changement de mot de passe pour ',
'ERR_PASSWORD_CHANGE_FAILED_2'=>' �chec.  Le nouveau mot de passe doit �tre �tabli.',
'ERR_PASSWORD_INCORRECT_OLD'=>'Ancient mot de passe incorect pour Utilisateur $this->user_name. Retapez l\'information du mot de passe.',
'ERR_USER_NAME_EXISTS_1'=>'Le nom Utilisateur ',
'ERR_USER_NAME_EXISTS_2'=>' existe d�j�.  Les doublons de nom Utilisateur ne sont pas autoris�s.<br>Changez le nom de mani�re � le rendre unique.',
'ERR_LAST_ADMIN_1'=>'Le nom Utilisateur ',
'ERR_LAST_ADMIN_2'=>' est le dernier utilisateur Admin.  Au moins un utilisateur doit rester en Admin.<br>V�rifier les param�tres Utilisateur Admin.',

'ERR_DELETE_RECORD'=>"Un num�ro d\'enregistrement doit �tre sp�cifi� pour supprimer ce compte.",

// Additional Fields for i18n --- Release vtigerCRM 3.2 Patch 2
// Users--listroles.php , createrole.php , ListPermissions.php , editpermissions.php

'LBL_ROLES'=>'R�les',
'LBL_ROLE_NAME'=>'Nom du R�le',
'LBL_CREATE_NEW_ROLE'=>'Cr�er New R�le',

'LBL_CREATE_NEW_ROLE'=>'Cr�er New Role',
'LBL_INDICATES_REQUIRED_FIELD'=>'Indique un champ Requis',
'LBL_NEW_ROLE'=>'New R�le',
'LBL_PARENT_ROLE'=>'R�le Parent',

'LBL_LIST_ROLES'=>'Liste des R�les',
'LBL_ENTITY_LEVEL_PERMISSIONS'=>'Permissions au Niveau des Entit�s',
'LBL_ENTITY'=>'Entit�',
'LBL_CREATE_EDIT'=>'Cr�er/Editer',
'LBL_DELETE'=>'Supprimer',
'LBL_ALLOW'=>'Autoriser',
'LBL_LEADS'=>'Prospects',
'LBL_ACCOUNTS'=>'Comptes',
'LBL_CONTACTS'=>'Contacts',
'LBL_OPPURTUNITIES'=>'Affaires',
'LBL_TASKS'=>'T�ches',
'LBL_CASES'=>'Cas',
'LBL_EMAILS'=>'Emails',
'LBL_NOTES'=>'Notes',
'LBL_MEETINGS'=>'R�union',
'LBL_CALLS'=>'Appels',
'LBL_IMPORT_PERMISSIONS'=>'Permissions Imports',
'LBL_IMPORT_LEADS'=>'Importer Prospects',
'LBL_IMPORT_ACCOUNTS'=>'Importer Comptes',
'LBL_IMPORT_CONTACTS'=>'Importer Contacts',
'LBL_IMPORT_OPPURTUNITIES'=>'Importer Affaires',

'LBL_ROLE_DETAILS'=>'D�tails du R�le',
//added for vtigercrm4 rc
'LBL_FILE'=> 'Nom du Fichier',
'LBL_UPLOAD'=>'Upload Fichier',
'LBL_ATTACH_FILE'=>'Attacher Mod�le Mail',
'LBL_EMAIL_TEMPLATES'=>'Mod�les Emails',
'LBL_TEMPLATE_NAME'=>'Nom du Mod�le',
'LBL_DESCRIPTION'=>'Description',
'LBL_EMAIL_TEMPLATES_LIST'=>'Liste des Mod�les Email',

'LBL_COLON'=>':',
'LBL_EMAIL_TEMPLATE'=>'Mod�le de Email',
'LBL_NEW_TEMPLATE'=>'Cr�er Mod�le',
'LBL_USE_MERGE_FIELDS_TO_EMAIL_CONTENT'=>'Utiliser les champs de fusion pour personnaliser le contenu de votre Email. Les valeurs de fusions serons remplac�es par leurs �quivalents dans la base de donn�e.<br />(ex: $contacts_email sera remplac� par l\'adresse email de vos contact lors du publipostage.)',
'LBL_AVAILABLE_MERGE_FIELDS'=>'Champs de Fusion Disponibles',
'LBL_SELECT_FIELD_TYPE'=>'Choisir le Type de Champs',
'LBL_SELECT_FIELD'=>'Choisir le Champs',
'LBL_MERGE_FIELD_VALUE'=>'Copier la Valeur des Champs de fusion',
'LBL_CONTACT_FIELDS'=>'Champs Contact',
'LBL_LEAD_FIELDS'=>'Champs Prospect',
'LBL_COPY_AND_PASTE_MERGE_FIELD'=>'Copier et coller la valeur des champs de fusion dans le mod�le ci-dessous.',
'LBL_EMAIL_TEMPLATE_INFORMATION'=>'Information sur le Mod�le Email:',
'LBL_FOLDER'=>'R�pertoire:',
'LBL_PERSONAL'=>'Personnel',
'LBL_PUBLIC'=>'Public',
'LBL_TEMPLATE_NAME'=>'Nom du Mod�le:',
'LBL_SUBJECT'=>'Objet',
'LBL_BODY'=>'Contenu du Email',

// Added fields in createnewgroup.php
'LBL_CREATE_NEW_GROUP'=>'Cr�er Groupe',
'LBL_NEW_GROUP'=>'Cr�er Groupe',
'LBL_GROUP_NAME'=>'Nom du Groupe',
'LBL_DESCRIPTION'=>'Description',

// Added fields in detailViewmailtemplate.html,listgroupmembers.php,listgroups.php
'LBL_DETAIL_VIEW_OF_EMAIL_TEMPLATE'=>'Vue d�taill�e du Mod�le Email',
'LBL_GROUP_MEMBERS_LIST'=>'Liste des membres du Groupe',
'LBL_GROUPS'=>'Groupes',
'LBL_WORD_TEMPLATES'=>'Mod�les pour fusion',
'LBL_NEW_WORD_TEMPLATE'=>'Cr�er Mod�le',

// Added fields in TabCustomise.php,html and UpdateTab.php,html
'LBL_CUSTOMISE_TABS'=>'Personnaliser les onglets',
'LBL_CHOOSE_TABS'=>'S�lectionner onglets',
'LBL_AVAILABLE_TABS'=>'Onglets Disponibles',
'LBL_SELECTED_TABS'=>'Onglets s�lectionn�s',
'LBL_USER'=>'Utilisateur',
'LBL_TAB_MENU_UPDATED'=>'Vos onglets ont �t� mis � jour! veuillez cliquer sur ',
'LBL_TO_VIEW_CHANGES'=>' pour voir les changements',

// Added fields in binaryfilelist.php
'LBL_OERATION'=>'Op�ration',

// Added fields in CreateProfile.php
'LBL_PROFILE_NAME'=>'Cr�er Profil:',
'LBL_NEW_PROFILE'=>'Cr�er Profil',
'LBL_NEW_PROFILE_NAME'=>'Nom du Profil',
'LBL_PARENT_PROFILE'=>'Profil Parent',

//Added fields in createrole.php
'LBL_HDR_ROLE_NAME'=>'Cr�er Cr�er R�le:',
'LBL_TITLE_ROLE_NAME'=>'Cr�er R�le',
'LBL_ROLE_NAME'=>'Nom du R�le',
'LBL_ROLE_PROFILE_NAME'=>'Associer � ce Profile',

//Added fields in OrgSharingDetailsView.php
'LBL_ORG_SHARING_PRIVILEGES'=>'Permissions par d�faut',
'LBL_EDIT_PERMISSIONS'=>'Editer les Permissions',
'LBL_SAVE_PERMISSIONS'=>'Sauvegarder les Permissions',
'LBL_READ_ONLY'=>'Public: Lecture Seule',
'LBL_EDIT_CREATE_ONLY'=>'Public: Lecture, Cr�er/Editer',
'LBL_READ_CREATE_EDIT_DEL'=>'Public: Lecture, Cr�er/Editer, Supprimer',
'LBL_PRIVATE'=>'Priv�',

//Added fields in listnotificationschedulers.php
'LBL_HDR_EMAIL_SCHDS'=>'Utilisateurs : Alertes Email',
'LBL_EMAIL_SCHDS_DESC'=>'Vous trouverez ici la liste des Alertes activ�es automatiquement lorsque un �v�nement correspondant se produit.',
'LBL_ACTIVE'=>'Active',
'LBL_NOTIFICATION'=>'Alerte',
'LBL_DESCRIPTION'=>'Description',
'LBL_TASK_NOTIFICATION'=>'Alerte T�che Retard�e',
'LBL_TASK_NOTIFICATION_DESCRITPION'=>'Alerter quand une t�che est retard�e de plus de 24 heures',
'LBL_MANY_TICKETS'=>'Trop d\'Alertes Tickets',
'LBL_MANY_TICKETS_DESCRIPTION'=>'Alerte si un utilisateur re&ccedil;ois trop de tickets, risques sur votre engagement de service',
'LBL_PENDING_TICKETS'=>'Alerte Tickets en Attente',
'LBL_TICKETS_DESCRIPTION'=>'Alerte pour le statut des tickets en attente',
'LBL_START_NOTIFICATION'=>'Alerte d�but de Support',
'LBL_START_DESCRIPTION'=>'Alerte de d�but de p�riode de support/service',
'LBL_BIG_DEAL'=>'Alerte "Grosse Affaire"',
'LBL_BIG_DEAL_DESCRIPTION'=>'Alerter pour une grosse Affaire',
'LBL_SUPPORT_NOTICIATION'=>'Alerte Fin de Support',
'LBL_SUPPORT_DESCRIPTION'=>'Alerte quand le support vient � expirer',
'LBL_BUTTON_UPDATE'=>'Mettre � jour',
'LBL_MODULENAMES'=>'Module',

//Added fields in ListFieldPermissions.html
'LBL_FIELD_PERMISSION_FIELD_NAME'=>'Nom du Champs',
'LBL_FIELD_PERMISSION_VISIBLE'=>'Visible',
'LBL_FIELD_PERMISSIOM_TABLE_HEADER'=>'Champs Standard',
'LBL_FIELD_LEVEL_ACCESS'=>'Niveau Acc�s aux Champs',
 
//Added fields after 4.0.1
'LBL_SIGNATURE'=>'Signature',

//Added for Event Reminder 4.2 Alpha release
'LBL_ACTIVITY_NOTIFICATION'=>'Rappels',
'LBL_ACTIVITY_REMINDER_DESCRIPTION'=>'recevez une notification avant qu\'un �v�nement ai lieu',
'LBL_MESSAGE'=>'Message',


//Added for 4.2GA support for mail server integration
'LBL_ADD_MAILSERVER_BUTTON_TITLE'=>'Ajouter serveur de mail',
'LBL_ADD_MAILSERVER_BUTTON_KEY'=>'M',
'LBL_ADD_MAILSERVER_BUTTON_LABEL'=>'Ajouter serveur de mail',

'LBL_LIST_MAILSERVER_BUTTON_TITLE'=>'Liste serveur de mail',
'LBL_LIST_MAILSERVER_BUTTON_KEY'=>'L',
'LBL_LIST_MAILSERVER_BUTTON_LABEL'=>'Liste serveur de mail',




'INVENTORYNOTIFICATION'=>'Notifications inventaire',
'LBL_INVENTORY_NOTIFICATIONS'=>'Editer les emails de notification d\'inventaire',
'LBL_INV_NOT_DESC'=>'La liste des notifications qui peuvent �tre envoy�s au gestionnaire de produit concernant la demande et la quantit� courante disponibles pendant la cr�ation d\'un devis, d\'une commande ou d\'une facture.',

'InvoiceNotification'=>'Notification des produits en stock pendant la cr�ation d\'une facture',
'InvoiceNotificationDescription'=>'Lorsque le niveau du stock arrive au seuil de r�-approvisionnement , une notification est envoy�e au gestionnaire',

'QuoteNotification'=>'Notification des produits en stock pendant la cr�ation d\'un devis',
'QuoteNotificationDescription'=>'Durant la cr�ation d\'un devis, si la quantit� en stock est insuffisante une notification est envoy�e au gestionnaire',

'SalesOrderNotification'=>'Notification des produits en stock pendant la cr�ation d\'une commande',
'SalesOrderNotificationDescription'=>'Durant la cr�ation d\'une commande si le niveau du stock est insuffisante une notification est envoy�e au gestionnaire',

//New addition for 4.2 GA
'LBL_USER_FIELDS'=>'Champs utilisateur',
'LBL_NOTE_DO_NOT_REMOVE_INFO'=>'Note: Vous ne devez ni modifier, ni effacer les valeurs entre {  }',

//Added for patch2
'LBL_FILE_INFORMATION'=>'Information fichier',
);

?>