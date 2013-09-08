<?php

// Bulgarian Language Module for v2.3 (translated by the Ivo Apostolov)
global $_VERSION;

$GLOBALS["charset"] = "windows-1251";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y/m/d H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "ГРЕШКА",
	"back"			=> "Назад",

	// root
	"home"			=> "Няма главна директория.",
	"abovehome"		=> "Настоящата директория не може да бъде над основната.",
	"targetabovehome"	=> "Избраната директория не може да бъде над основната.",

	// exist
	"direxist"		=> "Директорията не съществува.",
	//"filedoesexist"	=> "This file already exists.",
	"fileexist"		=> "Файла не съществува.",
	"itemdoesexist"		=> "Вече има такъв обект.",
	"itemexist"		=> "Обекта не съществува.",
	"targetexist"		=> "Директорията не съществува.",
	"targetdoesexist"	=> "Избрания обект вече съществува.",

	// open
	"opendir"		=> "Не е възможно да бъде отворена директорията.",
	"readdir"		=> "Не е възможно да бъде прочетена директорията.",

	// access
	"accessdir"		=> "Нямате достъп до тази директория.",
	"accessfile"		=> "Нямате достъп до този файл.",
	"accessitem"		=> "Нямате достъп до този обект.",
	"accessfunc"		=> "Нямате достъп да използвате тази функция.",
	"accesstarget"		=> "Нямате достъп до избраната директория.",

	// actions
	"permread"		=> "Грешка при прочита на правата.",
	"permchange"	=> "Грешка при смяна на правата.",
	"openfile"		=> "Грешка при отварянето на файла.",
	"savefile"		=> "Грешка при записа на файла.",
	"createfile"	=> "Грешка при създаването на файл.",
	"createdir"		=> "Грешка при създаването на директория.",
	"uploadfile"	=> "Грешка при качването на файл.",
	"copyitem"		=> "Грешка при копиране.",
	"moveitem"		=> "Грешка при преместване.",
	"delitem"		=> "Грешка при изтриване.",
	"chpass"		=> "Грешка при смяна на парола.",
	"deluser"		=> "Грешка при изтриване на потребител.",
	"adduser"		=> "Грешка при добавяне на потребител.",
	"saveuser"		=> "Грешка при записа на потребител.",
	"searchnothing"	=> "Въведете критерий за търсене.",

	// misc
	"miscnofunc"		=> "Функцията не е налична.",
	"miscfilesize"		=> "Файлът е над максималния обем.",
	"miscfilepart"		=> "Файлът бе качен частично.",
	"miscnoname"		=> "Трябва да въведете име.",
	"miscselitems"		=> "Не сте избрали нищо.",
	"miscdelitems"		=> "Сигурни ли сте в изтриването на тези \"+num+\" обекта?",
	"miscdeluser"		=> "Сигурни ли сте в изтриването на потребителя '\"+user+\"'?",
	"miscnopassdiff"	=> "Новата парола не се различава от старата.",
	"miscnopassmatch"	=> "Паролите не съвпадат.",
	"miscfieldmissed"	=> "Пропуснали сте задължително поле.",
	"miscnouserpass"	=> "Потребителското име или паролата са грешни.",
	"miscselfremove"	=> "Не можете да изтриете себе си.",
	"miscuserexist"		=> "Вече има такъв потребител.",
	"miscnofinduser"	=> "Не може да бъде открит потребител.",
	"extract_noarchive" => "Файлът не може да бъде разархивиран.",
	"extract_unknowntype" => "Неизвестен вид на архива"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "СМЯНА НА ПРАВА",
	"editlink"		=> "РЕДАКЦИЯ",
	"downlink"		=> "СВАЛЯНЕ",
	"uplink"		=> "НАГОРЕ",
	"homelink"		=> "НАЧАЛО",
	"reloadlink"		=> "ПРЕЗАРЕЖДАНЕ",
	"copylink"		=> "КОПИРАНЕ",
	"movelink"		=> "ПРЕМЕСТВАНЕ",
	"dellink"		=> "ИЗТРИВАНЕ",
	"comprlink"		=> "АРХИВИРАНЕ",
	"adminlink"		=> "АДМИНИСТРИРАНЕ",
	"logoutlink"		=> "ИЗХОД",
	"uploadlink"		=> "КАЧВАНЕ",
	"searchlink"		=> "ТЪРСЕНЕ",
	"extractlink"	=> "РАЗАРХИВИРАНЕ",
	'chmodlink'		=> 'Смяна на правата', // new mic
	'mossysinfolink'	=> $_VERSION->PRODUCT.' Системна информация ('.$_VERSION->PRODUCT.', Сървър, PHP, MySQL)', // new mic
	'logolink'		=> 'Отидете в сайта на joomlaXplorer', // new mic

	// list
	"nameheader"		=> "Име",
	"sizeheader"		=> "Размер",
	"typeheader"		=> "Вид",
	"modifheader"		=> "Модифициран",
	"permheader"		=> "Права",
	"actionheader"		=> "Действия",
	"pathheader"		=> "Път",

	// buttons
	"btncancel"		=> "Отказ",
	"btnsave"		=> "Запис",
	"btnchange"		=> "Промяна",
	"btnreset"		=> "Изчисти",
	"btnclose"		=> "Затвори",
	"btncreate"		=> "Създай",
	"btnsearch"		=> "Търси",
	"btnupload"		=> "Качи",
	"btncopy"		=> "Копирай",
	"btnmove"		=> "Премести",
	"btnlogin"		=> "Вход",
	"btnlogout"		=> "Изход",
	"btnadd"		=> "Добави",
	"btnedit"		=> "Редактирай",
	"btnremove"		=> "Изтрий",
	
	// user messages, new in joomlaXplorer 1.3.0
	'renamelink'	=> 'ПРЕИМЕНУВАЙ',
	'confirm_delete_file' => 'Сигурни ли сте в изтриването на този файл? \\n%s',
	'success_delete_file' => 'Обекта са успешно изтрити.',
	'success_rename_file' => 'Директорията/Файла %s са преименувани на %s.',
	
	// actions
	"actdir"		=> "Директория",
	"actperms"		=> "Смяна на правата",
	"actedit"		=> "Редакция на файл",
	"actsearchresults"	=> "Резултати от търсене",
	"actcopyitems"		=> "Копиране на обекти",
	"actcopyfrom"		=> "Копирай от /%s в /%s ",
	"actmoveitems"		=> "Преместване на обекти",
	"actmovefrom"		=> "Премести от /%s в /%s ",
	"actlogin"		=> "Вход",
	"actloginheader"	=> "Вход за използване на файловия браузър",
	"actadmin"		=> "Администрация",
	"actchpwd"		=> "Смяна на парола",
	"actusers"		=> "Потребители",
	"actarchive"		=> "Архивиране на обектите",
	"actupload"		=> "Качване на файлове",

	// misc
	"miscitems"		=> "Обекта",
	"miscfree"		=> "Свободно",
	"miscusername"		=> "Потребител",
	"miscpassword"		=> "Парола",
	"miscoldpass"		=> "Стара парола",
	"miscnewpass"		=> "Нова парола",
	"miscconfpass"		=> "Потвърди парола",
	"miscconfnewpass"	=> "Потвърди новата парола",
	"miscchpass"		=> "Смени парола",
	"mischomedir"		=> "Основна директория",
	"mischomeurl"		=> "Основен адрес",
	"miscshowhidden"	=> "Покажи скритите обекти",
	"mischidepattern"	=> "Скрий примерите",
	"miscperms"		=> "Права",
	"miscuseritems"		=> "(име, основна директория, покажи скритите обекти, права, актиране)",
	"miscadduser"		=> "добави потребител",
	"miscedituser"		=> "редактирай потребителя '%s'",
	"miscactive"		=> "Активирай",
	"misclang"		=> "Език",
	"miscnoresult"		=> "Няма резултати.",
	"miscsubdirs"		=> "Търсене в поддиректориите",
	"miscpermnames"		=> array("Само преглед","Модифициране","Смяна на парола","Модифициране & смяна на парола",
					"Администратор"),
	"miscyesno"		=> array("Да","Не","Д","Н"),
	"miscchmod"		=> array("Собственик", "Група", "Публичност"),

	// from here all new by mic
	'miscowner'			=> 'Собственик',
	'miscownerdesc'		=> '<strong>Описание:</strong><br />Потребиел (UID) /<br />Група (GID)<br />Настоящи права:<br /><strong> %s ( %s ) </strong>/<br /><strong> %s ( %s )</strong>',

	// sysinfo (new by mic)
	'simamsysinfo'		=> $_VERSION->PRODUCT." Систмна информация",
	'sisysteminfo'		=> 'Системна информация',
	'sibuilton'			=> 'Операционна система',
	'sidbversion'		=> 'Версия на MySQL',
	'siphpversion'		=> 'Версия на PHP',
	'siphpupdate'		=> 'Информация: <span style="color: red;">Версията на PHP която ползвате <strong>не е</strong> актуална!</span><br />За да гарантирате цялата функционалност на Joomla! трябва да ползвате,<br /> минимум <strong>Версия на PHP 4.3</strong>!',
	'siwebserver'		=> 'Уеб сървър',
	'siwebsphpif'		=> 'Уеб сървър - PHP интерфейс',
	'simamboversion'	=> $_VERSION->PRODUCT.' версия',
	'siuseragent'		=> 'Версия на браузъра',
	'sirelevantsettings' => 'Важни PHP настройки',
	'sisafemode'		=> 'Сигурна метод',
	'sibasedir'			=> 'Отворена основна директория',
	'sidisplayerrors'	=> 'PHP грешки',
	'sishortopentags'	=> 'Къси отворени команди',
	'sifileuploads'		=> 'Качване на файлове',
	'simagicquotes'		=> 'Магически цитати',
	'siregglobals'		=> 'Регистриране на глобални',
	'sioutputbuf'		=> 'Излизащ буфер',
	'sisesssavepath'	=> 'Запис на пътя на сесията',
	'sisessautostart'	=> 'Автоматично започване на сесията',
	'sixmlenabled'		=> 'Състояние на XML',
	'sizlibenabled'		=> 'Състояние на ZLIB',
	'sidisabledfuncs'	=> 'Изключени функции',
	'sieditor'			=> 'WYSIWYG Редактор',
	'siconfigfile'		=> 'Файл с настройки',
	'siphpinfo'			=> 'PHP информация',
	'siphpinformation'	=> 'PHP информация',
	'sipermissions'		=> 'Права',
	'sidirperms'		=> 'Права върху директории',
	'sidirpermsmess'	=> 'За да сте сигурни, че всички функции на '.$_VERSION->PRODUCT.' работят правилно, следните директории трябва да са с права [chmod 0777]',
	'sionoff'			=> array( 'Включен', 'Изключен' ),
	
	'extract_warning' => "Сигурни ли сте в разархивирането на този файл? Тук?\\nДействието би презаписало нови файлове върху сегашните, ако имената им съвпадат!",
	'extract_success' => "Разархиврането е успешно",
	'extract_failure' => "Грешка при разархивирането",
	
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
	'processed_x_files' => 'Processed %s of %s Files'
	
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
