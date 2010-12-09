<?php

/**
 * printer_friendly frameset
 *
 * @copyright (c) 1999-2005 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: printer_friendly_main.php,v 1.1 2005/06/14 13:34:58 indigoleopard Exp $
 * @package squirrelmail
 */

/**
 * Path for SquirrelMail required files.
 * @ignore
 */
//define('SM_PATH','../');
define('SM_PATH','modules/squirrelmail-1.4.4/');
/* SquirrelMail required files. */
require_once(SM_PATH . 'include/validate.php');

/* get those globals into gear */
global $color;
if ( ! sqgetGlobalVar('passed_ent_id',$passed_ent_id,SQ_GET))
    $passed_ent_id = 0;
if ( ! sqgetGlobalVar('mailbox',$mailbox,SQ_GET) ||
     ! sqgetGlobalVar('passed_id',$passed_id,SQ_GET)) {
    error_box(_("Invalid URL"),$color);
} else {
    $passed_id= (int) $passed_id;
/* end globals */
    displayHtmlHeader( _("Printer Friendly"), '', false, true );
    echo '<frameset rows="60, *">' . "\n";
    echo '<frame src="printer_friendly_top.php" name="top_frame" '
        . 'scrolling="no" noresize="noresize" frameborder="0" />' . "\n";
    echo '<frame src="printer_friendly_bottom.php?passed_ent_id='
        . urlencode($passed_ent_id) . '&amp;mailbox=' . urlencode($mailbox) 
        . '&amp;passed_id=' . $passed_id
        . '" name="bottom_frame" frameborder="0" />' . "\n";
    echo "</frameset>\n";
}
?>
</html>
