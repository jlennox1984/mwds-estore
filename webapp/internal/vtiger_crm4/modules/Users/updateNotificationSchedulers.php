<?php


/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/




/**
 *
 *  File to update the notification schedulers in the db
 *
 */


global $adb;
$flag=0;
//pass the table id as a parameter and then update directly instead of using the name field 
for ($i=1;$i<10;$i++)
{
  if($_POST[$i] == 'on')
  {
    $flag=1;
  }
  else
  {
    $flag=0;
  }
 $sql = "update notificationscheduler set active=".$flag."  where schedulednotificationid=".$i;
 
 $adb->query($sql);
}

header("Location:index.php?module=Users&action=listnotificationschedulers");





?>