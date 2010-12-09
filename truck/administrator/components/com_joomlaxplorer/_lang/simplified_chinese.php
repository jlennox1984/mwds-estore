<?php

// Simplified chinese Language Module for joomlaXplorer (translated by Baijianpeng http://www.tcmbook.net)
global $_VERSION;

$GLOBALS["charset"] = "utf-8";
$GLOBALS["text_dir"] = "ltr"; // ('ltr' for left to right, 'rtl' for right to left)
$GLOBALS["date_fmt"] = "Y/m/d H:i";
$GLOBALS["error_msg"] = array(
	// error
	"error"			=> "错误",
	"back"			=> "回上页",
	
	// root
	"home"			=> "未找到Joomla根目录，请检查您的设置.",
	"abovehome"		=> "当前目录可能并非Joomla根目录的上级目录.",
	"targetabovehome"	=> "目标目录可能并非Joomla根目录的上级目录.",
	
	// exist
	"direxist"		=> "这目录不存在.",
	//"filedoesexist"	=> "这目录已存在.",
	"fileexist"		=> "这文件不存在.",
	"itemdoesexist"		=> "这项目已存在.",
	"itemexist"		=> "这项目不存在.",
	"targetexist"		=> "这目标目录不存在.",
	"targetdoesexist"	=> "这目标项目已存在.",
	
	// open
	"opendir"		=> "无法打开目录.",
	"readdir"		=> "无法读取目录.",
	
	// access
	"accessdir"		=> "您不允许存取这个目录.",
	"accessfile"		=> "您不允许存取这个文件.",
	"accessitem"		=> "您不允许存取这个项目.",
	"accessfunc"		=> "您不允许使用这个功能.",
	"accesstarget"		=> "您不允许存取这个目标目录.",
	
	// actions
	"permread"		=> "取得权限失败.",
	"permchange"		=> "权限更改失败.",
	"openfile"		=> "打开文件失败.",
	"savefile"		=> "文件储存失败.",
	"createfile"		=> "新增文件失败.",
	"createdir"		=> "新增目录失败.",
	"uploadfile"		=> "文件上传失败.",
	"copyitem"		=> "复制失败.",
	"moveitem"		=> "移动失败.",
	"delitem"		=> "删除失败.",
	"chpass"		=> "更改密码失败.",
	"deluser"		=> "移除使用者失败.",
	"adduser"		=> "加入使用者失败.",
	"saveuser"		=> "储存使用者失败.",
	"searchnothing"		=> "您必须输入些什麽来搜寻.",
	
	// misc
	"miscnofunc"		=> "功能无效.",
	"miscfilesize"		=> "文件大小已达到最大.",
	"miscfilepart"		=> "文件只有部分已上传.",
	"miscnoname"		=> "您必须输入名称.",
	"miscselitems"		=> "您还未选择任何项目.",
	"miscdelitems"		=> "您确定要删除这些 \"+num+\" 项目?",
	"miscdeluser"		=> "您确定要删除使用者 '\"+user+\"'?",
	"miscnopassdiff"	=> "新密码跟旧密码相同.",
	"miscnopassmatch"	=> "密码不符.",
	"miscfieldmissed"	=> "您遗漏一个重要栏位.",
	"miscnouserpass"	=> "使用者名称或密码错误.",
	"miscselfremove"	=> "您无法移除您自己.",
	"miscuserexist"		=> "使用者已存在.",
	"miscnofinduser"	=> "无法找到使用者.",
	"extract_noarchive" => "该文件不可解压缩.",
	"extract_unknowntype" => "未知文件类型"
);
$GLOBALS["messages"] = array(
	// links
	"permlink"		=> "更改权限",
	"editlink"		=> "编辑",
	"downlink"		=> "下载",
	"uplink"		=> "上一层",
	"homelink"		=> "网站根目录",
	"reloadlink"		=> "重新载入",
	"copylink"		=> "复制",
	"movelink"		=> "移动",
	"dellink"		=> "删除",
	"comprlink"		=> "压缩",
	"adminlink"		=> "管理员",
	"logoutlink"		=> "登出",
	"uploadlink"		=> "上传",
	"searchlink"		=> "搜索",
	"extractlink"	=> "解压缩",
	'chmodlink'		=> '改变 (chmod) 权限 (目录/文件)', // new mic
	'mossysinfolink'	=> $_VERSION->PRODUCT.' 系统信息 ('.$_VERSION->PRODUCT.', 服务器, PHP, mySQL数据库)', // new mic
	'logolink'		=> '访问 joomlaXplorer 官方网站 (在新窗口打开)', // new mic
	
	// list
	"nameheader"		=> "名称",
	"sizeheader"		=> "大小",
	"typeheader"		=> "类型",
	"modifheader"		=> "最后更新",
	"permheader"		=> "权限",
	"actionheader"		=> "动作",
	"pathheader"		=> "路径",
	
	// buttons
	"btncancel"		=> "取消",
	"btnsave"		=> "储存",
	"btnchange"		=> "更改",
	"btnreset"		=> "重设",
	"btnclose"		=> "关闭",
	"btncreate"		=> "新增",
	"btnsearch"		=> "搜寻",
	"btnupload"		=> "上传",
	"btncopy"		=> "复制",
	"btnmove"		=> "移动",
	"btnlogin"		=> "登入",
	"btnlogout"		=> "登出",
	"btnadd"		=> "增加",
	"btnedit"		=> "编辑",
	"btnremove"		=> "移除",
	
	// user messages, new in joomlaXplorer 1.3.0
	'renamelink'	=> '重命名',
	'confirm_delete_file' => '你确定要删除这些文件吗？ \\n%s',
	'success_delete_file' => '项目删除成功！',
	'success_rename_file' => '文件夹/文件 %s 已被成功重新命名为 %s.',
	
	
	// actions
	"actdir"		=> "目录",
	"actperms"		=> "更改权限",
	"actedit"		=> "编辑文件",
	"actsearchresults"	=> "搜寻结果",
	"actcopyitems"		=> "复制项目",
	"actcopyfrom"		=> "从 /%s 复制到 /%s ",
	"actmoveitems"		=> "移动项目",
	"actmovefrom"		=> "从 /%s 移动到 /%s ",
	"actlogin"		=> "登入",
	"actloginheader"	=> "登入以使用 QuiXplorer",
	"actadmin"		=> "管理选单",
	"actchpwd"		=> "更改密码",
	"actusers"		=> "使用者",
	"actarchive"		=> "压缩项目",
	"actupload"		=> "上传文件",
	
	// misc
	"miscitems"		=> "个项目",
	"miscfree"		=> "服务器可用磁盘空间",
	"miscusername"		=> "使用者名称",
	"miscpassword"		=> "密码",
	"miscoldpass"		=> "旧密码",
	"miscnewpass"		=> "新密码",
	"miscconfpass"		=> "确认密码",
	"miscconfnewpass"	=> "确认新密码",
	"miscchpass"		=> "更改密码",
	"mischomedir"		=> "主页目录",
	"mischomeurl"		=> "主页 URL",
	"miscshowhidden"	=> "显示隐藏项目",
	"mischidepattern"	=> "隐藏样式",
	"miscperms"		=> "权限",
	"miscuseritems"		=> "(名称, 主页目录, 显示隐藏项目, 权限, 启用)",
	"miscadduser"		=> "增加使用者",
	"miscedituser"		=> "编辑使用者 '%s'",
	"miscactive"		=> "启用",
	"misclang"		=> "语言",
	"miscnoresult"		=> "无结果可用.",
	"miscsubdirs"		=> "搜寻子目录",
	"miscpermnames"		=> array("只能浏览","修改","更改密码","修改及更改密码",
					"管理员"),
	"miscyesno"		=> array("是的","否","Y","N"),
	"miscchmod"		=> array("所有人", "群组", "公开的"),
	// from here all new by mic
	'miscowner'			=> '所有者',
	'miscownerdesc'		=> '<strong>描述格式:</strong><br />用户 (UID) /<br />工作组 (GID)<br />当前权限:<br /><strong> %s ( %s ) </strong>/<br /><strong> %s ( %s )</strong>',

	// sysinfo (new by mic)
	'simamsysinfo'		=> $_VERSION->PRODUCT.' 系统信息',
	'sisysteminfo'		=> '系统信息',
	'sibuilton'			=> '操作系统',
	'sidbversion'		=> '数据库版本 (MySQL)',
	'siphpversion'		=> 'PHP 版本',
	'siphpupdate'		=> '信息: <span style="color: red;">您正在使用的PHP版本是 <strong>not</strong> actual!</span><br />为保证 '.$_VERSION->PRODUCT.' 及其插件的所有功能正常运行,<br />您必须最低使用 <strong>PHP. 4.3 版本</strong>!',
	'siwebserver'		=> '服务器',
	'siwebsphpif'		=> '服务器 - PHP 界面',
	'simamboversion'	=> $_VERSION->PRODUCT.' 版本',
	'siuseragent'		=> '浏览器版本',
	'sirelevantsettings' => '重要 PHP 设置',
	'sisafemode'		=> '安全模式',
	'sibasedir'			=> 'Open basedir',
	'sidisplayerrors'	=> 'PHP 错误信息',
	'sishortopentags'	=> 'Short Open Tags',
	'sifileuploads'		=> 'Datei Uploads',
	'simagicquotes'		=> 'Magic Quotes',
	'siregglobals'		=> 'Register Globals',
	'sioutputbuf'		=> '输出缓存',
	'sisesssavepath'	=> 'Session Savepath',
	'sisessautostart'	=> '线程自动启动',
	'sixmlenabled'		=> 'XML 已激活',
	'sizlibenabled'		=> 'ZLIB 已激活',
	'sidisabledfuncs'	=> 'Non enabled functions',
	'sieditor'			=> '所见即所得编辑器',
	'siconfigfile'		=> '配置文件',
	'siphpinfo'			=> 'PHP 信息',
	'siphpinformation'	=> 'PHP 信息',
	'sipermissions'		=> '允许',
	'sidirperms'		=> '文件夹允许',
	'sidirpermsmess'	=> '为了保证 '.$_VERSION->PRODUCT.'的所有功能都正常运行，下列目录必须被允许写入 [chmod 0777]，即您必须看到它们的状态在下面显示是绿色的 “<font color=green> Writeable </font>” ',
	'sionoff'			=> array( '开', '关' ),
	
	'extract_warning' => "您确定要解压缩该文件吗？在当前目录？\\n若使用不当，本操作将要覆盖现有同名文件!",
	'extract_success' => "解压缩成功完成！",
	'extract_failure' => "解压缩失败",
	
	'overwrite_files' => '覆盖现有同名文件？',
	"viewlink"		=> "查看",
	"actview"		=> "显示文件来源",
	
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
