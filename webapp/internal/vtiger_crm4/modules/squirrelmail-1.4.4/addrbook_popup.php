<?php

/**
 * addrbook_popup.php
 *
 * Copyright (c) 1999-2005 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * Frameset for the JavaScript version of the address book.
 *
 * @version $Id: addrbook_popup.php,v 1.1 2005/06/14 13:34:57 indigoleopard Exp $
 * @package squirrelmail
 */

/**
 * Path for SquirrelMail required files.
 * @ignore
 */
//define('SM_PATH','../');
define('SM_PATH','modules/squirrelmail-1.4.4/');
/** SquirrelMail required files. */
require_once(SM_PATH . 'include/validate.php');
require_once(SM_PATH . 'functions/addressbook.php');
   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">

<html>
    <head>
        <title><?php echo "$org_title: " . _("Address Book"); ?></title>
    </head>
    <frameset rows="60,*" border="0">
        <frame name="abookmain"
               marginwidth="0"
               scrolling="no"
               border="0"
               src="addrbook_search.php?show=form" />
        <frame name="abookres"
               marginwidth="0"
               border="0"
               src="addrbook_search.php?show=blank" />
    </frameset>
</html>
