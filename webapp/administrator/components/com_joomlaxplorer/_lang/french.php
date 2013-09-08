<?php

// French Language Module for joomlaXplorer (translated by Olivier Pariseau)

$GLOBALS["charset"] = "iso-8859-1";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "d/m/Y H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "ERREUR(S)",
	"back"			=> "Page précédente",
	
	// root
	"home"			=> "Le répertoire home n'existe pas, vérifiez vos préférences.",
	"abovehome"		=> "Le répertoire courant n'a pas l'air d'etre au-dessus du répertoire home.",
	"targetabovehome"	=> "Le répertoire cible n'a pas l'air d'etre au-dessus du répertoire home.",
	
	// exist
	"direxist"		=> "Ce répertoire n'existe pas.",
	//"filedoesexist"	=> "Ce fichier existe deja.",
	"fileexist"		=> "Ce fichier n'existe pas.",
	"itemdoesexist"		=> "Cet item existe deja.",
	"itemexist"		=> "Cet item n'existe pas.",
	"targetexist"		=> "Le répertoire cible n'existe pas.",
	"targetdoesexist"	=> "L'item cible existe deja.",
	
	// open
	"opendir"		=> "Impossible d'ouvrir le répertoire.",
	"readdir"		=> "Impossible de lire le répertoire.",
	
	// access
	"accessdir"		=> "Vous n'etes pas autorisé a acceder a ce répertoire.",
	"accessfile"		=> "Vous n'etes pas autorisé a accéder a ce fichier.",
	"accessitem"		=> "Vous n'etes pas autorisé a accéder a cet item.",
	"accessfunc"		=> "Vous ne pouvez pas utiliser cette fonction.",
	"accesstarget"		=> "Vous n'etes pas autorisé a accéder au repertoire cible.",
	
	// actions
	"permread"		=> "Lecture des permissions échouée.",
	"permchange"		=> "Changement des permissions échoué.",
	"openfile"		=> "Ouverture du fichier échouée.",
	"savefile"		=> "Sauvegarde du fichier échouée.",
	"createfile"		=> "Création du fichier échouée.",
	"createdir"		=> "Création du répertoire échouée.",
	"uploadfile"		=> "Envoie du fichier échoué.",
	"copyitem"		=> "La copie a échouée.",
	"moveitem"		=> "Le déplacement a échoué.",
	"delitem"		=> "La supression a échouée.",
	"chpass"		=> "Le changement de mot de passe a échoué.",
	"deluser"		=> "La supression de l'usager a échouée.",
	"adduser"		=> "L'ajout de l'usager a échouée.",
	"saveuser"		=> "La sauvegarde de l'usager a échouée.",
	"searchnothing"		=> "Vous devez entrez quelquechose à chercher.",
	
	// misc
	"miscnofunc"		=> "Fonctionalité non disponible.",
	"miscfilesize"		=> "La taille du fichier excède la taille maximale autorisée.",
	"miscfilepart"		=> "L'envoi du fichier n'a pas été complété.",
	"miscnoname"		=> "Vous devez entrer un nom.",
	"miscselitems"		=> "Vous n'avez sélectionné aucuns item(s).",
	"miscdelitems"		=> "Êtes-vous certain de vouloir supprimer ces \"+num+\" item(s)?",
	"miscdeluser"		=> "Êtes-vous certain de vouloir supprimer l'usager '\"+user+\"'?",
	"miscnopassdiff"	=> "Le nouveau mot de passe est indentique au précédent.",
	"miscnopassmatch"	=> "Les mots de passe diffèrent.",
	"miscfieldmissed"	=> "Un champs requis n'a pas été rempli.",
	"miscnouserpass"	=> "Nom d'usager ou mot de passe invalide.",
	"miscselfremove"	=> "Vous ne pouvez pas supprimer votre compte.",
	"miscuserexist"		=> "Ce nom d'usager existe déjà.",
	"miscnofinduser"	=> "Usager non trouvé.",
	"extract_noarchive" => "The File is no extractable Archive.",
	"extract_unknowntype" => "Unknown Archive Type"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "CHANGER LES PERMISSIONS",
	"editlink"		=> "ÉDITER",
	"downlink"		=> "TÉLÉCHARGER",
	"uplink"		=> "PARENT",
	"homelink"		=> "HOME",
	"reloadlink"		=> "RAFRAÎCHIR",
	"copylink"		=> "COPIER",
	"movelink"		=> "DÉPLACER",
	"dellink"		=> "SUPPRIMER",
	"comprlink"		=> "ARCHIVER",
	"adminlink"		=> "ADMINISTRATION",
	"logoutlink"		=> "DÉCONNECTER",
	"uploadlink"		=> "ENVOYER",
	"searchlink"		=> "RECHERCHER",
	"extractlink"	=> "Extract Archive",
	'chmodlink'		=> 'Change (chmod) Rights (Folder/File(s))', // new mic
	'mossysinfolink'	=> $_VERSION->PRODUCT.' System Information ('.$_VERSION->PRODUCT.', Server, PHP, mySQL)', // new mic
	'logolink'		=> 'Go to the joomlaXplorer Website (new window)', // new mic
	
	// list
	"nameheader"		=> "Nom",
	"sizeheader"		=> "Taille",
	"typeheader"		=> "Type",
	"modifheader"		=> "Modifié",
	"permheader"		=> "Perm's",
	"actionheader"		=> "Actions",
	"pathheader"		=> "Chemin",
	
	// buttons
	"btncancel"		=> "Annuler",
	"btnsave"		=> "Sauver",
	"btnchange"		=> "Changer",
	"btnreset"		=> "Réinitialiser",
	"btnclose"		=> "Fermer",
	"btncreate"		=> "Créer",
	"btnsearch"		=> "Chercher",
	"btnupload"		=> "Envoyer",
	"btncopy"		=> "Copier",
	"btnmove"		=> "Déplacer",
	"btnlogin"		=> "Connecter",
	"btnlogout"		=> "Déconnecter",
	"btnadd"		=> "Ajouter",
	"btnedit"		=> "Éditer",
	"btnremove"		=> "Supprimer",
	
	// user messages, new in joomlaXplorer 1.3.0
	'renamelink'	=> 'RENAME',
	'confirm_delete_file' => 'Are you sure you want to delete this file? \\n%s',
	'success_delete_file' => 'Item(s) successfully deleted.',
	'success_rename_file' => 'The directory/file %s was successfully renamed to %s.',
	
	
	// actions
	"actdir"		=> "Répertoire",
	"actperms"		=> "Changer les permissions",
	"actedit"		=> "Éditer le fichier",
	"actsearchresults"	=> "Résultats de la recherche",
	"actcopyitems"		=> "Copier le(s) item(s)",
	"actcopyfrom"		=> "Copier de /%s à /%s ",
	"actmoveitems"		=> "Déplacer le(s) item(s)",
	"actmovefrom"		=> "Déplacer de /%s à /%s ",
	"actlogin"		=> "Connecter",
	"actloginheader"	=> "Connecter pour utiliser QuiXplorer",
	"actadmin"		=> "Administration",
	"actchpwd"		=> "Changer le mot de passe",
	"actusers"		=> "Usagers",
	"actarchive"		=> "Archiver le(s) item(s)",
	"actupload"		=> "Envoyer le(s) fichier(s)",
	
	// misc
	"miscitems"		=> "Item(s)",
	"miscfree"		=> "Disponible",
	"miscusername"		=> "Usager",
	"miscpassword"		=> "Mot de passe",
	"miscoldpass"		=> "Ancien mot de passe",
	"miscnewpass"		=> "Nouveau mot de passe",
	"miscconfpass"		=> "Confirmer le mot de passe",
	"miscconfnewpass"	=> "Confirmer le nouveau mot de passe",
	"miscchpass"		=> "Changer le mot de passe",
	"mischomedir"		=> "Répertoire home",
	"mischomeurl"		=> "URL home",
	"miscshowhidden"	=> "Voir les items cachés",
	"mischidepattern"	=> "Cacher pattern",
	"miscperms"		=> "Permissions",
	"miscuseritems"		=> "(nom, répertoire home, Voir les items cachés, permissions, actif)",
	"miscadduser"		=> "ajouter un usager",
	"miscedituser"		=> "editer l'usager '%s'",
	"miscactive"		=> "Actif",
	"misclang"		=> "Langage",
	"miscnoresult"		=> "Aucun résultats.",
	"miscsubdirs"		=> "Rechercher dans les sous-répertoires",
	"miscpermnames"		=> array("Lecture seulement","Modifier","Changement le mot de passe","Modifier & Changer le mot de passe",
					"Administrateur"),
	"miscyesno"		=> array("Oui","Non","O","N"),
	"miscchmod"		=> array("Propriétaire", "Groupe", "Publique"),
	// from here all new by mic
	'miscowner'			=> 'Owner',
	'miscownerdesc'		=> '<strong>Description:</strong><br />User (UID) /<br />Group (GID)<br />Current rights:<br /><strong> %s ( %s ) </strong>/<br /><strong> %s ( %s )</strong>',

	// sysinfo (new by mic)
	'simamsysinfo'		=> $_VERSION->PRODUCT.' System Info',
	'sisysteminfo'		=> 'System Info',
	'sibuilton'			=> 'Operating System',
	'sidbversion'		=> 'Database Version (MySQL)',
	'siphpversion'		=> 'PHP Version',
	'siphpupdate'		=> 'INFORMATION: <span style="color: red;">The PHP version you use is <strong>not</strong> actual!</span><br />To guarantee all functions and features of '.$_VERSION->PRODUCT.' and addons,<br />you should use as minimum <strong>PHP.Version 4.3</strong>!',
	'siwebserver'		=> 'Webserver',
	'siwebsphpif'		=> 'WebServer - PHP Interface',
	'simamboversion'	=> $_VERSION->PRODUCT.' Version',
	'siuseragent'		=> 'Browser Version',
	'sirelevantsettings' => 'Important PHP Settings',
	'sisafemode'		=> 'Safe Mode',
	'sibasedir'			=> 'Open basedir',
	'sidisplayerrors'	=> 'PHP Errors',
	'sishortopentags'	=> 'Short Open Tags',
	'sifileuploads'		=> 'Datei Uploads',
	'simagicquotes'		=> 'Magic Quotes',
	'siregglobals'		=> 'Register Globals',
	'sioutputbuf'		=> 'Output Buffer',
	'sisesssavepath'	=> 'Session Savepath',
	'sisessautostart'	=> 'Session auto start',
	'sixmlenabled'		=> 'XML enabled',
	'sizlibenabled'		=> 'ZLIB enabled',
	'sidisabledfuncs'	=> 'Non enabled functions',
	'sieditor'			=> 'WYSIWYG Editor',
	'siconfigfile'		=> 'Config file',
	'siphpinfo'			=> 'PHP Info',
	'siphpinformation'	=> 'PHP Information',
	'sipermissions'		=> 'Permissions',
	'sidirperms'		=> 'Directory permissions',
	'sidirpermsmess'	=> 'To be shure that all functions and features of '.$_VERSION->PRODUCT.' are working correct, following folders should have permission to write [chmod 0777]',
	'sionoff'			=> array( 'On', 'Off' ),
	
	'extract_warning' => "Do you really want to extract this file? Here?\\nThis will overwrite existing files when not used carefully!",
	'extract_success' => "Extraction was successful",
	'extract_failure' => "Extraction failed",
	
	'overwrite_files' => 'Overwrite existing file(s)?',
	"viewlink"		=> "VIEW",
	"actview"		=> "Showing source of file",
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to fun_chmod.php file
	'recurse_subdirs'	=> 'Recurse into subdirectories?',
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to footer.php file
	'check_version'	=> 'Check for latest version',
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to fun_rename.php file
	'rename_file'	=>	'Rename a directory or file...',
	'newname'		=>	'New Name',
	
	// added by Paulino Michelazzo (paulino@michelazzo.com.br) to fun_edit.php file
	'returndir'	=>	'Return to directory after saving?',
	'line'		=> 	'Line',
	'column'	=>	'Column',
	'wordwrap'	=>	'Wordwrap: (IE only)',
	'copyfile'	=>	'Copy file into this filename',
	
	// Bookmarks
	'quick_jump' => 'Quick Jump To',
	'already_bookmarked' => 'This directory is already bookmarked',
	'bookmark_was_added' => 'This directory was added to the bookmark list.',
	'not_a_bookmark' => 'This directory is not a bookmark.',
	'bookmark_was_removed' => 'This directory was removed from the bookmark list.',
	'bookmarkfile_not_writable' => "Failed to %s the bookmark.\n The Bookmark File '%s' \nis not writable.",
	
	'lbl_add_bookmark' => 'Add this Directory as Bookmark',
	'lbl_remove_bookmark' => 'Remove this Directory from the Bookmark List',
	
	'enter_alias_name' => 'Please enter the alias name for this bookmark',
	
	'normal_compression' => 'normal compression',
	'good_compression' => 'good compression',
	'best_compression' => 'best compression',
	'no_compression' => 'no compression',
	
	'creating_archive' => 'Creating Archive File...',
	'processed_x_files' => 'Processed %s of %s Files',
	
	'ftp_login_lbl' => 'Please enter the login credentials for the FTP server',
	'ftp_login_name' => 'FTP User Name',
	'ftp_login_pass' => 'FTP Password',
	'ftp_login_check' => 'Checking FTP connection...',
	'ftp_connection_failed' => "The FTP server could not be contacted. \nPlease check that the FTP server is running on your server.",
	'ftp_login_failed' => "The FTP login failed. Please check the username and password and try again.",
		
	'switch_file_mode' => 'Current mode: <strong>%s</strong>. You could switch to %s mode.',
	'symlink_target' => 'Target of the Symbolic Link',
);
?>
