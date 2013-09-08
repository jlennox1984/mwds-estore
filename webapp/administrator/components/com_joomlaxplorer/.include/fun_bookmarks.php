<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/**
 * @copyright The contents of this file are subject to the Mozilla Public License
     Version 1.1 (the "License"); you may not use this file except in
     compliance with the License. You may obtain a copy of the License at
     http://www.mozilla.org/MPL/

     Software distributed under the License is distributed on an "AS IS"
     basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
     License for the specific language governing rights and limitations
     under the License.

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

* @author: soeren
* @package joomlaXplorer
* Bookmark Functions
* 
*/
/**
 * reads all bookmarks from the bookmark ini file
 *
 * @return array
 */
function read_bookmarks() {
	global $my;
	$bookmarkfile = _QUIXPLORER_PATH.'/.config/bookmarks_'.$GLOBALS['file_mode'].'_'.$my->id.'.php';
	if( file_exists( $bookmarkfile )) {
		return parse_ini_file( $bookmarkfile );
    }
	else {
		if( !is_writable( dirname( $bookmarkfile ) )) {
		    return;
		} else {
			file_put_contents( $bookmarkfile, "; <?php defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>\n{$GLOBALS['messages']['homelink']}=\n" );
			return array( $GLOBALS['messages']['homelink'] => '' );
		}
    }
}
/**
 * Adds a new bookmark to the bookmark ini file
 *
 * @param string $dir
 */
function modify_bookmark( $task, $dir ) {
    global $my;
    $alias = substr( mosGetParam($_REQUEST,'alias'), 0, 150 );
	$bookmarks = read_bookmarks();
	$bookmarkfile = _QUIXPLORER_PATH.'/.config/bookmarks_'.$GLOBALS['file_mode'].'_'.$my->id.'.php';
	while( @ob_end_clean() );
	
	header( "Status: 200 OK" );
	
	switch ( $task ) {
		case 'add':

			if( in_array( $dir, $bookmarks )) {
				echo jx_alertBox( $GLOBALS['messages']['already_bookmarked'] ); exit;
			}
			
			$bookmarks[$dir] = preg_replace('~[^\w-.\/\\\]~','', $alias ); // Make the alias ini-safe by removing all non-word characters
			$msg = jx_alertBox( $GLOBALS['messages']['bookmark_was_added'] );
			break;
		
		case 'remove':
			
			if( !in_array( $dir, $bookmarks )) {
				echo jx_alertBox( $GLOBALS['messages']['not_a_bookmark'] ); exit;
			}
			$bookmarks = array_flip( $bookmarks );
			unset( $bookmarks[$dir] );
			$bookmarks = array_flip( $bookmarks );
			$msg = jx_alertBox( $GLOBALS['messages']['bookmark_was_removed'] );
	}
	
	$inifile = "; <?php defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>\n";
			
			
	foreach( $bookmarks as $directory => $alias ) {
	    if( empty( $directory ) || empty( $alias ) ) continue;
		$inifile .= "$alias=$directory\n";
	}
	if( !is_writable( $bookmarkfile )) {
	    echo jx_alertBox( sprintf( $GLOBALS['messages']['bookmarkfile_not_writable'], $task, $bookmarkfile ) ); exit;
    }
	file_put_contents( $bookmarkfile, $inifile );
	
	echo $msg; 
	echo list_bookmarks($dir);
	exit;
}

/**
 * Lists all bookmarked directories in a dropdown list.
 *
 * @param string $dir
 */
function list_bookmarks( $dir ) {
	
	$bookmarks = read_bookmarks();
	$bookmarks = array_flip($bookmarks);
	
	foreach( $bookmarks as $bookmark ) {
		$len = strlen( $bookmark );
	    if( $len > 40 ) {
		    $first_part = substr( $bookmark, 0, 20 );
			$last_part = substr( $bookmark, -20 );
			$bookmarks[$bookmark] = $first_part . '...' . $last_part;
		}
	}
	
	
	$html = $GLOBALS['messages']['quick_jump'].': ';
	$html .= jx_selectList( 'dirselector', $dir, $bookmarks, 1, '', 'onchange="document.location=\''.make_link( 'list', null ).'&dir=\' + this.options[this.options.selectedIndex].value;" style="max-width: 100px;"');
	
	
	
	$img_add = '<img src="'._QUIXPLORER_URL.'/_img/bookmark_add.gif" border="0" alt="'.$GLOBALS['messages']['lbl_add_bookmark'].'" align="absmiddle" />';
	$img_remove = '<img src="'._QUIXPLORER_URL.'/_img/publish_x.png" border="0" alt="'.$GLOBALS['messages']['lbl_remove_bookmark'].'" align="absmiddle" />';
	
	$addlink=$removelink='';
	
	if( !isset( $bookmarks[$dir] ) && $dir != '' && $dir != '/' ) {
		$addlink = '<a href="'.make_link('modify_bookmark', $dir ).'&task=add" onclick="var alias = prompt(\''.$GLOBALS['messages']['enter_alias_name'].':\', \''.$dir.'\');if( alias==\'\' || alias == null )return false; adder = new ajax(\''.make_link('modify_bookmark', $dir ).'&task=add&alias=\' + alias, { method: \'get\', postBody: \'action=modify_bookmark&task=add&dir='.$dir.'&alias=\' + alias + \'&option=com_joomlaxplorer\', evalScripts:true, update: \'quick_jumpto\' } );adder.request(); return false;" title="'.$GLOBALS['messages']['lbl_add_bookmark'].'" >'.$img_add.'</a>';
	}
	elseif( $dir != '' && $dir != '/' ) {
		$removelink = '<a href="'.make_link('modify_bookmark', $dir ).'&task=remove" onclick="remover = new ajax(\''.make_link('modify_bookmark', $dir ).'&task=remove\', { method: \'get\', update: \'quick_jumpto\', postBody: \'action=modify_bookmark&task=remove&dir='.$dir.'&option=com_joomlaxplorer\', evalScripts:true } );remover.request(); return false;"  title="'.$GLOBALS['messages']['lbl_remove_bookmark'].'">'.$img_remove.'</a>';
	}
	
	$html .= $addlink .'&nbsp;'.$removelink;
	
	return $html;
}

?>