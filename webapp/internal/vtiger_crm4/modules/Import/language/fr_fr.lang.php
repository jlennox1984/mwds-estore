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
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Import/language/en_us.lang.php,v 1.8 2005/03/24 11:42:42 gjay Exp $
 * Description:  Defines the English language pack for the Account module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): Abos (contact@abonlinesolutions.com), Jay, Ivan Stankovic.
 ********************************************************************************/


$mod_strings = Array(
'LBL_IMPORT_MODULE_NO_DIRECTORY'=>'Le répertoire',
'LBL_IMPORT_MODULE_NO_DIRECTORY_END'=>' n\'existe pas ou est en lecture seule',
'LBL_IMPORT_MODULE_ERROR_NO_UPLOAD'=>'Erreur lors de l\'importation du fichier, veuillez réessayez.',
'LBL_IMPORT_MODULE_ERROR_LARGE_FILE'=>'Fichier trop volumineux. Taille Max:',
'LBL_IMPORT_MODULE_ERROR_LARGE_FILE_END'=>'Bytes. Vous pouvez modifier la variable $upload_maxsize dans le fichier config.php',
'LBL_MODULE_NAME'=>'Importer',
'LBL_TRY_AGAIN'=>'Réessayez',
'LBL_ERROR'=>'Erreur:',
'ERR_MULTIPLE'=>'Plusieurs colonnes portant le même nom existent.',
'ERR_MISSING_REQUIRED_FIELDS'=>'Champs requis manquants:',
'ERR_SELECT_FULL_NAME'=>'Vous ne pouvez pas choisir Nom Complet quand Prénom et Nom de Famille sont sélectionnés.',
'ERR_SELECT_FILE'=>'Choisir le fichier a uploader.',
'LBL_SELECT_FILE'=>'Choisir Fichier:',
'LBL_CUSTOM'=>'Personnaliser',
'LBL_DONT_MAP'=>'|-- Ne pas mapper ce champs --|',
'LBL_STEP_1_TITLE'=>'Etape 1: Sélectionner une source de données',
'LBL_WHAT_IS'=>'Veuillez sélectionner une méthode d\'importation :',
'LBL_MICROSOFT_OUTLOOK'=>'Microsoft Outlook',
'LBL_ACT'=>'Act!',
'LBL_SALESFORCE'=>'Salesforce.com',
'LBL_MY_SAVED'=>'Mes Sources Sauvegardées:',
'LBL_PUBLISH'=>'publier',
'LBL_DELETE'=>'supprimer',
'LBL_PUBLISHED_SOURCES'=>'Sources Publiées:',
'LBL_UNPUBLISH'=>'dépublier',
'LBL_NEXT'=>'suivant >',
'LBL_BACK'=>'< précédent',
'LBL_STEP_2_TITLE'=>'Etape 2: Uploader le fichier Export',
'LBL_HAS_HEADER'=>'A une ligne d\'entête:',

'LBL_NUM_1'=>'1.',
'LBL_NUM_2'=>'2.',
'LBL_NUM_3'=>'3.',
'LBL_NUM_4'=>'4.',
'LBL_NUM_5'=>'5.',
'LBL_NUM_6'=>'6.',
'LBL_NUM_7'=>'7.',
'LBL_NUM_8'=>'8.',
'LBL_NUM_9'=>'9.',
'LBL_NUM_10'=>'10.',
'LBL_NUM_11'=>'11.',
'LBL_NUM_12'=>'12.',
'LBL_NOW_CHOOSE'=>'Sélectionnez le fichier à importer:',
'LBL_IMPORT_OUTLOOK_TITLE'=>'Microsoft Outlook 98 et 2000 peuvent exporter les données au format <b>CSV</b> ou valeur séparée d\'une virgule, qui peuvent servir à importer des données dans le système. Pour exporter les données d\'Outlook, suivre les étapes suivantes:',
'LBL_OUTLOOK_NUM_1'=>'Démarrer <b>Outlook</b>',
'LBL_OUTLOOK_NUM_2'=>'Sélectionnez <b>Fichier</b>, puis l\'option <b>Importer et Exporter ...</b>',
'LBL_OUTLOOK_NUM_3'=>'Sélectionnez <b>Exporter vers un fichier</b> et cliquer Suivant',
'LBL_OUTLOOK_NUM_4'=>'Sélectionnez le format <b>CSV (Windows)</b> et cliquer <b>Suivant</b>.<br>  Note: le cdrom d\'installation pourra vous être demandé pour installer la fonction',
'LBL_OUTLOOK_NUM_5'=>'Sélectionner le répertoire <b>Contacts</b> et cliquer <b>Suivant</b>. Puis selectionner des répertoires différents si vos contacts sont stockés dans des répertoires multiples',
'LBL_OUTLOOK_NUM_6'=>'Sélectionnez un nom de fichier et cliquer <b>Suivant</b>',
'LBL_OUTLOOK_NUM_7'=>'Cliquer sur <b>Finir</b>',
'LBL_IMPORT_ACT_TITLE'=>'Act! peut exporter les données dans un format <b>CSV</b> qui peut servir à importer les données dans le système. Pour exporter les données d\'Act!, suivre les étapes suivantes:',
'LBL_ACT_NUM_1'=>'Lancer <b>ACT!</b>',
'LBL_ACT_NUM_2'=>'Choisir le menu <b>Fichier</b>, l\'option <b>Data Exchange</b>, et l\'option <b>Exporter...</b>',
'LBL_ACT_NUM_3'=>'Choisir le type de fichier <b>Texte-Delimité</b>',
'LBL_ACT_NUM_4'=>'Choisir un nom de fichier et un répertoire pour l\'export des données et cliquer <b>Suivant</b>',
'LBL_ACT_NUM_5'=>'Choisir <b>Enregistrement Contacts seulement</b>',
'LBL_ACT_NUM_6'=>'Cliquer sur le bouton <b>Options...</b>',
'LBL_ACT_NUM_7'=>'Choisir <b>Comma</b> comme charactère de séparation des champs',
'LBL_ACT_NUM_8'=>'Cocher la checkbox <b>Oui, exporter les noms de champs</b> et cliquer <b>OK</b>',
'LBL_ACT_NUM_9'=>'Cliquer <b>Suivant</b>',
'LBL_ACT_NUM_10'=>'Choisir <b>Tous les enregistrements</b> et puis cliquer <b>Finir</b>',

'LBL_IMPORT_SF_TITLE'=>'Salesforce.com peut exporter les données au format <b>Comma Separated Values</b> qui peut alors être utilisé pour importer les données dans votre système. Pour exporter vos données de Salesforce.com, suivre les étapes suivantes:',
'LBL_SF_NUM_1'=>'Ouvrir votre browser, aller à http://www.salesforce.com, et connectez-vous avec votre Email et mot de passe',
'LBL_SF_NUM_2'=>'Cliquer sur <b>Rapports</b> sur le menu en haut',
'LBL_SF_NUM_3'=>'Pour exporter les Comptes:</b> Cliquer sur le lien <b>Comptes Actifs</b><br><b>Pour exporter les contacts:</b> Cliquer sur le lien <b>Mailing Liste</b>',
'LBL_SF_NUM_4'=>'Dans <b>Etape 1: Choisir le type de rapport</b>, choisir <b>Rapport Tabulaire</b> cliquer <b>Suivant</b>',
'LBL_SF_NUM_5'=>'Dans <b>Etape 2: Choisir les colonnes du rapport</b>, sélectionner les colonnes que vous voulez exporter et cliquer <b>Suivant</b>',
'LBL_SF_NUM_6'=>'Dans <b>Etape 3: Choisir les informations à résumer</b>, cliquer <b>Suivant</b>',
'LBL_SF_NUM_7'=>'Dans <b>Etape 4: Ordonner les colonnes du rapport</b>, cliquer <b>Suivant</b>',
'LBL_SF_NUM_8'=>'Dans <b>Etape 5: Choisir les critères du rapport</b>, sous <b>Date de début</b>, choisir une date suffisament dans le passé pour inclure tous vos Comptes. Vous pouvez aussi exporter une partie des Comptes en définissant des critères plus avancés. Quand vous avez finit, cliquer <b>Exécuter le Rapport</b>',
'LBL_SF_NUM_9'=>'Un rapport sera généré, et la page devrait montrer <b>Statut de Génération Rapport: Complet.</b> Cliquer <b>Export sur Excel</b>',
'LBL_SF_NUM_10'=>'Dans <b>Export Report:</b>, pour <b>Export File Format:</b>, choisir <b>Comma Delimited .csv</b>. Cliquer <b>Export</b>.',
'LBL_SF_NUM_11'=>'Une fenêtre de dialogue va s\'ouvrir pour sauvegarder le fichier d\'export sur votre PC.',
'LBL_IMPORT_CUSTOM_TITLE'=>'De nombreuses applications permettent l\'export de données au format <b>Comma Delimited text file (.csv)</b>. En général cette méthode d\'export des données est très simple :',
'LBL_CUSTOM_NUM_1'=>'Lancer l\'application depuis laquelle vous désirez récupérer les données et Ouvrez le fichier de données',
'LBL_CUSTOM_NUM_2'=>'Sélectionner <b>Enregistrer-sous...</b> ou l\'option du menu <b>Exporter...</b>',
'LBL_CUSTOM_NUM_3'=>'Sauvegarder le fichier dans un format <b>CSV</b> ou <b>Comma Separated Values</b>',

'LBL_STEP_3_TITLE'=>'Etape 3: Confirmation des champs et import',

'LBL_SELECT_FIELDS_TO_MAP'=>'Dans la liste ci-dessous, sélectionnez les chmaps de votre fichier importé qui doivent être injecté dans le système. Une fois terminé, veuillez cliquer sur <b>Importer maintenant</b>',

'LBL_DATABASE_FIELD'=>'Champs de base de données',
'LBL_HEADER_ROW'=>'Ligne d\'entête',
'LBL_ROW'=>'Ligne',
'LBL_SAVE_AS_CUSTOM'=>'Sauvegarder comme Mappage personnalisé:',
'LBL_CONTACTS_NOTE_1'=>'Nom de Famille ou Nom Complet doivent être mappés.',
'LBL_CONTACTS_NOTE_2'=>'Si le Nom Complet est mappé, alors Prénom et Nom de Famille sont ignorés.',
'LBL_CONTACTS_NOTE_3'=>'Si le mapping à Nom Complet est choisi, alors les données de Nom Complet seront divisées en Prénom et Nom pour être insérées dans la base de données.',
'LBL_CONTACTS_NOTE_4'=>'Les champs Adresse Rue 2 et Adresse Rue 3 sont concatenés à l\'Adresse Rue avant d\'être insérés dans la base de données.',
'LBL_ACCOUNTS_NOTE_1'=>'Le Nom du Compte doit être mappé.',
'LBL_ACCOUNTS_NOTE_2'=>'Les champs Adresse Rue 2 et Adresse Rue 3 sont concatenés à l\'Adresse Rue avant d\'être insérés dans la base de données.',
'LBL_POTENTIAL_NOTE_1'=>'Nom de Affaire, Nom du Compte, Date de Clôture, et Etape de Vente sont des champs requis.',
'LBL_LEADS_NOTE_1'=>'Le nom de famille doit être mappé.',
'LBL_LEADS_NOTE_2'=>'Le nom de société doit être mappé.',
'LBL_IMPORT_NOW'=>'Importer maintenant',
'LBL_'=>'',
'LBL_'=>'',
'LBL_CANNOT_OPEN'=>'Ne peut ouvrir le fichier en lecture',
'LBL_NOT_SAME_NUMBER'=>'Il n\'y avait pas le même nombre de champs par ligne sur votre fichier',
'LBL_NO_LINES'=>'Il n\'y a aucune ligne dans le fichier à importer',
'LBL_FILE_ALREADY_BEEN_OR'=>'Le fichier a déjà été traité ou n\'existe pas',
'LBL_SUCCESS'=>'Succès:',
'LBL_SUCCESSFULLY'=>'Import réussi',
'LBL_LAST_IMPORT_UNDONE'=>'Votre dernier import a été annulé',
'LBL_NO_IMPORT_TO_UNDO'=>'Pas d\'import à annuler.',
'LBL_FAIL'=>'Echec:',
'LBL_RECORDS_SKIPPED'=>'enregistrements sautés car un ou plusieurs champs requis manquaient',
'LBL_IDS_EXISTED_OR_LONGER'=>'id fait plus de 36 charactères ou existe déjà, enregistrements sautés',
'LBL_RESULTS'=>'Résultats',
'LBL_IMPORT_MORE'=>'Importe encore',
'LBL_FINISHED'=>'Fait',
'LBL_UNDO_LAST_IMPORT'=>'Annuler Import',



);

/*$mod_list_strings = Array(
'contacts_import_fields' => Array(
	"id"=>"Contact ID"
	,"first_name"=>"Prénom"
	,"last_name"=>"Nom de Famille"
	,"salutation"=>"Salutation"
	,"lead_source"=>"Source Prospect"
	,"birthdate"=>"Source Prospect"
	,"do_not_call"=>"Ne pas Appeler"
	,"email_opt_out"=>"Email Opt Out"
	,"primary_address_street_2"=>"Adresse Principale Rue 2"
	,"primary_address_street_3"=>"Adresse Principale Rue 3"
	,"alt_address_street_2"=>"Autre Adresse Rue 2"
	,"alt_address_street_3"=>"Autre Adresse Rue 3"
	,"full_name"=>"Nom Complet"
	,"account_name"=>"Nom du Compte"
	,"account_id"=>"Compte ID"
	,"title"=>"Fonction"
	,"department"=>"Département"
	,"birthdate"=>"Date de Naissance"
	,"do_not_call"=>"Ne pas Appeler"
	,"phone_home"=>"Téléphone (Domicile)"
	,"phone_mobile"=>"Téléphone (Mobile)"
	,"phone_work"=>"Téléphone (Bureau)"
	,"phone_other"=>"Téléphone (Autre)"
	,"phone_fax"=>"Fax"
	,"email1"=>"Email"
	,"email2"=>"Email (Autre)"
	,"yahoo_id"=>"Yahoo! ID"
	,"assistant"=>"Assistant"
	,"assistant_phone"=>"Téléphone Assistant"
	,"primary_address_street"=>"Adresse Principale Rue"
	,"primary_address_city"=>"Adresse Principale Ville"
	,"primary_address_state"=>"Adresse Principale Etat"
	,"primary_address_postalcode"=>"Adresse Principale Code Postal"
	,"primary_address_country"=>"Adresse Principale Pays"
	,"alt_address_street"=>"Autre Adresse Rue"
	,"alt_address_city"=>"Autre Adresse Ville"
	,"alt_address_state"=>"Autre Adresse Etat"
	,"alt_address_postalcode"=>"Autre Adresse Code Postal"
	,"alt_address_country"=>"Autre Adresse Pays"
	,"description"=>"Description"

	),*/
$mod_list_strings = Array(
'contacts_import_fields' => Array(
	//"id"=>"Contact ID"
	"firstname"=>"Prénom"
	,"lastname"=>"Nom de Famille"
	,"salutation"=>"Salutation"
	,"leadsource"=>"Source Prospect"
	,"birthday"=>"Date de Naissance"
	,"donotcall"=>"Ne pas appeler"
	,"emailoptout"=>"Email Opt Out"
	//,"primary_address_street_2"=>"Primary Address Street 2"
	//,"primary_address_street_3"=>"Primary Address Street 3"
	//,"alt_address_street_2"=>"Other Address Street 2"
	//,"alt_address_street_3"=>"Other Address Street 3"
	//,"full_name"=>"Full Name"
	//,"account_name"=>"Account Name"
	,"account_id"=>"Nom du Compte"
	,"title"=>"Fonction"
	,"department"=>"Département"
	//,"birthdate"=>"Birthdate"
	//,"do_not_call"=>"Do Not Call"
	,"homephone"=>"Téléphone (Domicile)"
	,"mobile"=>"Téléphone (Mobile)"
	,"phone"=>"Téléphone (Bureau)"
	,"otherphone"=>"Téléphone (Autre)"
	,"fax"=>"Fax"
	,"email"=>"Email"
	,"otheremail"=>"Email (Autre)"
	,"yahooid"=>"Yahoo! ID"
	,"assistant"=>"Assistant"
	,"assistantphone"=>"Téléphone Assistant"
	,"mailingstreet"=>"Mailing Adresse Rue"
	,"mailingcity"=>"Mailing Adresse Ville"
	,"mailingstate"=>"Mailing Adresse Etat"
	,"mailingzip"=>"Mailing Adresse Code Postal"
	,"mailingcountry"=>"Mailing Adresse Pays"
	,"otherstreet"=>"Autre Adresse Rue"
	,"othercity"=>"Autre Adresse Ville"
	,"otherstate"=>"Autre Adresse Etat"
	,"otherzip"=>"Autre Adresse Code Postal"
	,"othercountry"=>"Autre Adresse Pays"
	,"description"=>"Description"

	),

'accounts_import_fields' => Array(
	//"id"=>"Account ID",
	"accountname"=>"Nom du Compte",
	"website"=>"Site web",
	"industry"=>"Secteur",
	"accounttype"=>"Type",
	"tickersymbol"=>"Symbole Boursier",
	"parent_name"=>"Membre de",
	"employees"=>"Employés",
	"ownership"=>"Propriétaire",
	"phone"=>"Téléphone",
	"fax"=>"Fax",
	"otherphone"=>"Autre Téléphone",
	"email1"=>"Email",
	"email2"=>"Autre Email",
	"rating"=>"Score",
	"siccode"=>"Code NAF",
	"annual_revenue"=>"Chiffre d'affaire",
	"bill_street"=>"Facturation Adresse Rue",
	//"billing_address_street_2"=>"Facturation Address Street 2",
	//"billing_address_street_3"=>"Facturation Address Street 3",
	//"billing_address_street_4"=>"Facturation Address Street 4",
	"bill_city"=>"Facturation Ville",
	"bill_state"=>"Facturation Etat",
	"bill_code"=>"Facturation Code Postal",
	"bill_country"=>"Facturation Pays",
	"ship_street"=>"Shipping Rue",
	//"shipping_address_street_2"=>"Shipping Address Street 2",
	//"shipping_address_street_3"=>"Shipping Address Street 3",
	//"shipping_address_street_4"=>"Shipping Address Street 4",
	"ship_city"=>"Livraison Ville",
	"ship_state"=>"Livraison Etat",
	"ship_code"=>"Livraison Code Postal",
	"ship_country"=>"Livraison Pays",
	"description"=>"Description"
	),

'potentials_import_fields' => Array(
		//"id"=>"Account ID"
                 "potentialname"=>"Nom de l'affaire"
                , "account_id"=>"Nom du Compte"
                , "opportunity_type"=>"Type Affaire"
                , "leadsource"=>"Source Prospect"
                , "amount"=>"Montant"
                , "closingdate"=>"Date Clôture"
                , "nextstep"=>"Suivant"
                , "sales_stage"=>"Etape de Vente"
                , "probability"=>"Probabilité"
                , "description"=>"Description"
                ,"assigned_user_id"=>"Assigné à"
                ),

'leads_import_fields' => Array(
		"salutation"=>"Salutation",
		"firstname"=>"Prénom",
		"phone"=>"Téléphone",
		"lastname"=>"Nom de Famille",
		"mobile"=>"Mobile",
		"company"=>"Société",
		"fax"=>"Fax",
		"designation"=>"Désignation",
		"email"=>"Email",
		"leadsource"=>"Source Prospect",
		"website"=>"Site web",
		"industry"=>"Secteur",
		"leadstatus"=>"Statut Prospect",
		"annualrevenue"=>"Chiffre d'affaire",
		"rating"=>"Score",
		"licencekeystatus"=>"Clef de License",
		"noofemployees"=>"Nombre d'employés",
		"assigned_user_id"=>"Assigné à",
		"yahooid"=>"Yahoo Id",		
		"lane"=>"Rue",
		"code"=>"Code Postal",
		"city"=>"Ville",
		"country"=>"Pays",
		"state"=>"Etat",
		"description"=>"Description"
        ,"assigned_user_id"=>"Assigné à"
    ),
 
 'products_import_fields' => Array(
 	'productname'=>'Nom produit',
 	'productcode'=>'Ref produit',
 	'productcategory'=>'Catégorie produit',
 	'manufacturer'=>'Fabricant',
 	'product_description'=>'Description produit',
 	'qty_per_unit'=>'Quantité Pièce/Unité',
 	'unit_price'=>'Prix unitaire',
 	'weight'=>'Poid',
 	'pack_size'=>'Taille',
 	'start_date'=>'Date départ',
 	'expiry_date'=>'Date Expiration',
 	'cost_factor'=>'Facteur de coût',
 	'commissionmethod'=>'Commission Method',
 	'discontinued'=>'Discontinued',
 	'commissionrate'=>'Taux de Commission',
	'sales_start_date'=>'Départ mise en vente',
	'sales_end_date'=>'Fin mise en vente',
	'usageunit'=>'Unité d\'usage',
	'serialno'=>'No de Série',
	'currency'=>'Devise',
	'reorderlevel'=>'Reorder Level',
	'website'=>'Site web',
	'taxclass'=>'GST',
	'mfr_part_no'=>'Manufacture Part No',
	'vendor_part_no'=>'Vendor Part No',
	'qtyinstock'=>'Quantity in Stock',
	'productsheet'=>'Product Sheet',
	'qtyindemand'=>'Quantity in Demand',
	'glacct'=>'GL Account',
	'assigned_user_id'=>'Assigné à'
	 )

);

?>