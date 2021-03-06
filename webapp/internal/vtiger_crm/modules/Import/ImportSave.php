<?php

$count = 0;
$skip_required_count = 0;

function InsertImportRecords($rows,$rows1,$focus,$ret_field_count,$col_pos_to_field,$start,$recordcount,$module,$totalnoofrows,$skip_required_count)
{
	global $current_user;

if($start == 0)
{
	$_SESSION['totalrows'] = $rows;
	$_SESSION['return_field_count'] = $ret_field_count;
	$_SESSION['column_position_to_field'] = $col_pos_to_field;
}
$ii = $start;
// go thru each row, process and save()
foreach ($rows1 as $row)
{
	global $adb;
	global $mod_strings;

	$do_save = 1;

	for($field_count = 0; $field_count < $ret_field_count; $field_count++)
	{
		p("col_pos[".$field_count."]=".$col_pos_to_field[$field_count]);

		if ( isset( $col_pos_to_field[$field_count]) )
		{
			p("set =".$field_count);
			if (! isset( $row[$field_count]) )
			{
				continue;
			}

			p("setting");

			// TODO: add check for user input
			// addslashes, striptags, etc..
			$field = $col_pos_to_field[$field_count];
			if (substr(trim($field), 0, 3) == "CF_") 
        		{
				p("setting custfld".$field."=".$row[$field_count]);
				$resCustFldArray[$field] = $row[$field_count]; 
        		}
			else
			{
				//$focus->$field = $row[$field_count];
				$focus->column_fields[$field] = $row[$field_count];
				p("Setting ".$field."=".$row[$field_count]);
			}
			
		}

	}

	p("setting done");
	
	p("do save before req fields=".$do_save);

	$adb->println($focus->required_fields);

	foreach ($focus->required_fields as $field=>$notused) 
	{ 
		$fv = $focus->column_fields[$field];
		if (! isset($fv) || $fv == '') 
		{
		       p("fv ".$field." not set");	
			$do_save = 0; 
			$skip_required_count++; 
			break; 
		} 
	}

	p("do save=".$do_save);

	if ($do_save)
	{
		p("saving..");

	
		if ( ! isset($focus->column_fields["assigned_user_id"]) || $focus->column_fields["assigned_user_id"]=='')
		{
			$focus->column_fields["assigned_user_id"] = $current_user->id;
		}	

		// now do any special processing
		$focus->process_special_fields(); 

		$focus->save($module);
		//$focus->saveentity($module);
		$return_id = $focus->id;

		if(count($resCustFldArray)>0)
		{

			if($_REQUEST['module'] == 'Contacts')
			{
				$_REQUEST['module']='contactdetails';
			}
			$dbquery="select * from field where tablename='".$_REQUEST['module']."'";
			$custresult = $adb->query($dbquery);
			if($adb->num_rows($custresult) != 0)
			{
				if (! isset( $_REQUEST['module'] ) || $_REQUEST['module'] == 'Contacts')
				{
					$columns = 'contactid';
					$custTabName = 'contactscf';
				}
				else if ( $_REQUEST['module'] == 'Accounts')
				{
					$columns = 'accountid';
					$custTabName = 'accountscf';	
				}
				else if ( $_REQUEST['module'] == 'Potentials')
				{
					$columns = 'potentialid';
					$custTabName = 'potentialscf';
				}

				$noofrows = $adb->num_rows($custresult);
				$values='"'.$focus->id.'"';
				for($j=0; $j<$noofrows; $j++)
				{
					$colName=$adb->query_result($custresult,$j,"columnname");
					if(array_key_exists($colName, $resCustFldArray))
					{
						$value_colName = $resCustFldArray[$colName];

						$columns .= ', '.$colName;
						$values .= ', "'.$value_colName.'"';
					}
				}
				
				$insert_custfld_query = 'insert into '.$custTabName.' ('.$columns.') values('.$values.')';
				$adb->query($insert_custfld_query);

			}
		}	
		
		$last_import = new UsersLastImport();		
		$last_import->assigned_user_id = $current_user->id;
		$last_import->bean_type = $_REQUEST['module'];
		$last_import->bean_id = $focus->id;
		$last_import->save();
		array_push($saved_ids,$focus->id);
		$count++;
	}
$ii++;	
}

$_REQUEST['count'] = $ii;
if(isset($_REQUEST['module']))
	$modulename = $_REQUEST['module'];

$end = $start+$recordcount;
$START = $start + $recordcount;
$RECORDCOUNT = $recordcount;

if($end >= $totalnoofrows)
{
	$module = 'Import';//$_REQUEST['module'];
	$action = 'ImportSteplast';
	//exit;
	$imported_records = $ii - $skip_required_count;
	if($imported_records == $ii)
		$skip_required_count = 0;
	$message= urlencode($mod_strings['LBL_SUCCESS']."<BR>$imported_records ". $_REQUEST['return_module']." ".$mod_strings['LBL_SUCCESSFULLY']."<br>$skip_required_count " .  $mod_strings['LBL_RECORDS_SKIPPED'] );
}
else
{
	$module = 'Import';
	$action = 'ImportStep4';
}
?>

<script>
setTimeout("b()",1000);
function b()
{
        document.location.href="index.php?action=<?php echo $action?>&module=<?php echo $module?>&modulename=<?php echo $modulename?>&startval=<?php echo $end?>&recordcount=<?php echo $RECORDCOUNT?>&noofrows=<?php echo $totalnoofrows?>&message=<?php echo $message?>&skipped_record_count=<?php echo $skip_required_count?>";
}
</script>

<?php
return '<br>'.$start.' to '.$end.' of '.$totalnoofrows.' are imported successfully';
}
?>

