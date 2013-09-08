<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/*------------------------------------------------------------------------------
     The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

     The Original Code is fun_archive.php, released on 2003-03-31.

     The Initial Developer of the Original Code is The QuiX project.

     Alternatively, the contents of this file may be used under the terms
     of the GNU General Public License Version 2 or later (the "GPL"), in
     which case the provisions of the GPL are applicable instead of
     those above. If you wish to allow use of your version of this file only
     under the terms of the GPL and not to allow others to use
     your version of this file under the MPL, indicate your decision by
     deleting  the provisions above and replace  them with the notice and
     other provisions required by the GPL.  If you do not delete
     the provisions above, a recipient may use your version of this file
     under either the MPL or the GPL."
------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------
Author: The QuiX project
	quix@free.fr
	http://www.quix.tk
	http://quixplorer.sourceforge.net

Comment:
	QuiXplorer Version 2.3
	Zip & TarGzip Functions
	
	Have Fun...
------------------------------------------------------------------------------*/


function archive_items( $dir ) {
	global $mosConfig_absolute_path;
	if(($GLOBALS["permissions"]&01)!=01) show_error($GLOBALS["error_msg"]["accessfunc"]);
	if(!$GLOBALS["zip"] && !$GLOBALS["tgz"]) show_error($GLOBALS["error_msg"]["miscnofunc"]);
	
	$allowed_types = array( 'zip', 'tgz', 'tbz', 'tar' );
	$actionURL = str_replace("index2.php", "index3.php", make_link("arch",$dir,NULL));
	
	// If we have something to archive, let's do it now
	if(isset($GLOBALS['__POST']["name"])) {
		
		require_once( _QUIXPLORER_PATH .'/_lib/Archive.php' );
		
		if( !in_array(strtolower( $GLOBALS['__POST']["type"] ), $allowed_types )) {
			echo('Unknown Archive Format: '.htmlspecialchars($GLOBALS['__POST']["type"]));
			die();
		}
		while( @ob_end_clean() );
		header('Status: 200 OK');
		echo '<?xml version="1.0" ?>'."\n";
		
		$files_per_step = 500;		
		
		$cnt=count($GLOBALS['__POST']["selitems"]);
		$abs_dir=get_abs_dir($dir);
		$name=basename(stripslashes($GLOBALS['__POST']["name"]));
		if($name=="") show_error($GLOBALS["error_msg"]["miscnoname"]);
		
		$download = mosGetParam( $_REQUEST, 'download', "n" );
		$startfrom = mosGetParam( $_REQUEST, 'startfrom', 0 );
		
		$archive_name = get_abs_item($dir,$name);
		$fileinfo = pathinfo( $archive_name );
		if( empty( $fileinfo['extension'] )) {
			$archive_name .= ".".$GLOBALS['__POST']["type"];
			$fileinfo['extension'] = $GLOBALS['__POST']["type"];
		}
		foreach( $allowed_types as $ext ) {
			if( $GLOBALS['__POST']["type"] == $ext && @$fileinfo['extension'] != $ext ) {
				$archive_name .= ".".$ext;
			}
		}
		// Tar/Gz and Tar/Bzip2 Archives must be treated as Tar first, after adding files has been finished we pack the files
		if( $GLOBALS['__POST']["type"] == 'tgz' || $GLOBALS['__POST']["type"] == 'tbz') {
			$archive_name = $fileinfo['dirname'].$GLOBALS["separator"].$fileinfo['basename'] . '.tar';
		}
		
		for($i=0;$i<$cnt;$i++) {
			
			$selitem=stripslashes($GLOBALS['__POST']["selitems"][$i]);
			
			if( is_dir( $abs_dir ."/". $selitem )) {
				$items = mosReadDirectory($abs_dir ."/".  $selitem, '.', true, true );
				foreach ( $items as $item ) {
					if( is_dir( $item ) || !is_readable( $item )) continue;
					$v_list[] = $item;
				}
			}
			else {
				$v_list[] = $abs_dir ."/". $selitem;
			}
		}
		$cnt_filelist = count( $v_list );
		$remove_path = $GLOBALS["home_dir"].$GLOBALS['separator'];
		if( $dir ) {
			$remove_path .= $dir.$GLOBALS['separator'];
		}
		for( $i=$startfrom;$i < $cnt_filelist && $i < ($startfrom + $files_per_step); $i++ ) {
			
			$filelist[] = File_Archive::read( $v_list[$i], str_replace($remove_path, '', dirname( $v_list[$i] ) ).'/'.basename($v_list[$i]) );

		}
		//echo '<strong>Starting from: '.$startfrom.'</strong><br />';
		//echo '<strong>Files to process: '.$cnt_filelist.'</strong><br />';
		//print_r( $filelist );exit;
		
		// Do some setup stuff
		ini_set('memory_limit', '128M');
		@set_time_limit( 0 );
		error_reporting( E_ERROR | E_PARSE );		
		
		$result = File_Archive::extract( $filelist, $archive_name );
		
		if( PEAR::isError( $result ) ) {
			echo $name.": Failed saving Archive File. Error: ".$result->getMessage();
			die();
		}
		
		if( $cnt_filelist > $startfrom+$files_per_step ) {
			echo "\n <script type=\"text/javascript\">document.archform.startfrom.value = '".( $startfrom + $files_per_step )."';</script>\n";
			echo '<script type="text/javascript"> doArchiving( \''.$actionURL.'\' );</script>';
			printf( $GLOBALS['messages']['processed_x_files'], $startfrom + $files_per_step, $cnt_filelist );
		}
		else {
			if( $GLOBALS['__POST']["type"] == 'tgz' || $GLOBALS['__POST']["type"] == 'tbz') {
				$compressed_archive_name = $fileinfo['dirname'].$GLOBALS["separator"].$fileinfo['basename'] .'.'. $GLOBALS['__POST']["type"];
				$source = File_Archive::read($archive_name . '/' );
				File_Archive::extract( $source, $compressed_archive_name );
				unlink( $archive_name );
			}
		  	if( $download=="y" ) {
				echo '<script type="text/javascript">document.location=\''.make_link( 'download', dirname($archive_name), basename($archive_name) ).'\';</script>';
		  	}
		  	else {
		  		echo '<script type="text/javascript">document.location=\''.str_replace("index3.php", "index2.php", make_link("list",$dir,NULL)).'&mosmsg=The%20Archive%20File%20has%20been%20created\';</script>';
		  	}
		}
		die();
	}
	?>
	<script type="text/javascript" src="components/com_joomlaxplorer/_js/mootools.ajax.js"></script>
	<script type="text/javascript" src="components/com_joomlaxplorer/_js/functions.js"></script>
	<script type="text/javascript">
	function doArchiving( url ) {
		showLoadingIndicator( $('loadingindicator'), true );
		$('loadingindicator').innerHTML += ' <strong><?php echo $GLOBALS['messages']['creating_archive'] ?></strong>';
		
		var controller = new ajax( url, { 	postBody: $('adminform'),
											evalScripts: true,
											update: 'statustext' 
											} 
								);
		controller.request();
		return false;
	}</script>
	<?php
	show_header($GLOBALS["messages"]["actarchive"]);
	?><br/>
	
	<form name="archform" method="post" action="<?php echo $actionURL ?>" onsubmit="return doArchiving(this.action);" id="adminform">
	
	<input type="hidden" name="no_html" value="1" />
	<input type="hidden" name="startfrom" value="0" />
	<?php
	$cnt=count($GLOBALS['__POST']["selitems"]);
	for($i=0;$i<$cnt;++$i) {
		echo '<input type="hidden" name="selitems[]" value="'.stripslashes($GLOBALS['__POST']["selitems"][$i]).'">';
	}
	
	?>
	<table class="adminform" style="width:400px;">
		<tr><td colspan="2" style="text-align:center;" id="loadingindicator"></td></tr>
		<tr><td colspan="2" style="font-weight:bold;text-align:center" id="statustext">&nbsp;</td></tr>
		<tr><td><?php echo $GLOBALS["messages"]["nameheader"] ?>:</td>
			<td align="left">
				<input type="text" name="name" size="25" value="<?php echo ( $dir != '' ? basename($dir) : $GLOBALS['__POST']["selitems"][0] ) ?>" />
			</td>
		</tr>
		<tr><td><?php echo $GLOBALS["messages"]["typeheader"] ?>:</td>
			<td align="left">
				<select name="type">
				<?php
				if(extension_loaded("zlib")) {
				  echo '<option value="zip">Zip ('.$GLOBALS["messages"]['normal_compression'].')</option>'."\n";
				  echo '<option value="tgz">Tar/Gz ('.$GLOBALS["messages"]['good_compression'].')</option>'."\n";
				}
				if(extension_loaded("bz2")) {
					echo '<option value="tbz">Tar/Bzip2 ('.$GLOBALS["messages"]['best_compression'].')</option>'."\n";
				}
				echo '<option value="" disabled="disabled"> - - - - - - -</option>'."\n";
				echo '<option value="tar">Tar ('.$GLOBALS["messages"]['no_compression'].')</option>'."\n";
				?>
				</select>
			</td>
		</tr>
		<tr><td><?php echo $GLOBALS["messages"]["downlink"] ?>?:</td>
			<td align="left">
				<input type="checkbox" checked="checked" name="download" value="y" />
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<input type="submit" value="<?php echo $GLOBALS["messages"]["btncreate"] ?>">
				<input type="button" value="<?php echo $GLOBALS["messages"]["btncancel"] ?>" onclick="javascript:location='<?php echo make_link("list",$dir,NULL) ?>';">
			</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
	</table>
	</form>
	<br/>
	<script type="text/javascript">if(document.archform) document.archform.name.focus();</script>
	<?php
}

function extract_item( $dir, $item ) {
  global $mosConfig_absolute_path;
  
  if( !jx_isArchive( $item )) {
	show_error($GLOBALS["error_msg"]["extract_noarchive"]);
  }
  else {
	  
	  $archive_name = realpath(get_abs_item($dir,$item));
	  
	  $file_info = pathinfo($archive_name);
	  
	  if( empty( $dir )) {
	  	$extract_dir = realpath($GLOBALS['home_dir']);
	  }
	  else {
	  	$extract_dir = realpath( $GLOBALS['home_dir']."/".$dir );
	  }
		
	  $ext = $file_info["extension"];
	  
	  switch( $ext ) {
		case "zip":
		
		  require_once( $mosConfig_absolute_path."/administrator/includes/pcl/pclzip.lib.php" );
		  require_once( $mosConfig_absolute_path . "/administrator/includes/pcl/pclerror.lib.php" );
		  $zip = new PclZip($archive_name);
		  $res = $zip->extract( PCLZIP_OPT_PATH, $extract_dir );
		  if( $res < 1 ) {
			show_error( $GLOBALS["messages"]["extract_failure"]." (". $zip->error_string.")" );
		  }
		  else
			$_REQUEST['mosmsg'] = $GLOBALS["messages"]["extract_success"];
		  
		break;
		
		case "gz":  // a
		case "bz": // lot
		case "bz2": // of
		case "bzip2": // fallthroughs,
		case "tbz": // don't
		case "tar": // wonder
		  require_once(_QUIXPLORER_PATH . "/_lib/Tar.php");
		  $archive = new Archive_Tar($archive_name, $type);
		  if( $archive->extract( $extract_dir ) )
			$_REQUEST['mosmsg'] = $GLOBALS["messages"]["extract_success"];
		  else
			show_error($GLOBALS["error_msg"]["extract_failure"]);
		break;
		
		default: 
			show_error($GLOBALS["error_msg"]["extract_unknowntype"]);
		
		break;
	  }
  
	  mosRedirect( make_link("list", $dir, null), $_REQUEST['mosmsg'] );
  }
}
//------------------------------------------------------------------------------
?>
