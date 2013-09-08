<?php
/**
 * @version		$Id: tinymce.php 6257 2007-01-11 22:03:46Z friesengeist $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Do not allow direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.plugin.helper' );

/**
 * TinyMCE WYSIWYG Editor Plugin
 *
 * @author Louis Landry <louis.landry@joomla.org>
 * @package Editors
 * @since 1.5
 */
class JEditor_tinymce extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @since 1.5
	 */
	function JEditor_tinymce(& $subject) {
		parent::__construct($subject);
	}

	/**
	 * Method to handle the onInit event.
	 *  - Initializes the TinyMCE WYSIWYG Editor
	 *
	 * @access public
	 * @return string JavaScript Initialization string
	 * @since 1.5
	 */
	function onInit()
	{
		global $mainframe;

		$db			=& JFactory::getDBO();
		$language	=& JFactory::getLanguage();
		$url		= $mainframe->isAdmin() ? $mainframe->getSiteURL() : JURI::base();
		$plugin		=& JPluginHelper::getPlugin('editors', 'tinymce');
		$id			= $plugin->id;
		$params 	= new JParameter( $plugin->params );

		$theme = $params->get( 'theme', 'advanced' );
		// handling for former default option
		if ($theme == 'default' ) {
			$theme = 'advanced';
		}

		$toolbar 			= $params->def( 'toolbar', 'top' );
		$html_height		= $params->def( 'html_height', '550' );
		$html_width			= $params->def( 'html_width', '750' );
		$content_css		= $params->def( 'content_css', 1 );
		$content_css_custom	= $params->def( 'content_css_custom', '' );
		$invalid_elements	= $params->def( 'invalid_elements', 'script,applet,iframe' );
		$newlines			= $params->def( 'newlines', 0 );
		$cleanup			= $params->def( 'cleanup', 1 );
		$cleanup_startup	= $params->def( 'cleanup_startup', 0 );
		$compressed			= $params->def( 'compressed', 0 );
		$langPrefix			= $params->def( 'lang_code', 'en' );
		$langMode			= $params->def( 'lang_mode', 0 );
		$relative_urls		= $params->def( 'relative_urls', 		0 );

		// Plugins
		// insert date
		$insertdate			= $params->def( 'insertdate', 1 );
		$format_date		= $params->def( 'format_date', '%Y-%m-%d' );
		// insert time
		$inserttime			= $params->def( 'inserttime', 1 );
		$format_time		= $params->def( 'format_time', '%H:%M:%S' );
		// search & replace
		$searchreplace		=  $params->def( 'searchreplace', 1 );
		// emotions
		$smilies			=  $params->def( 'smilies', 0 );
		// flash
		$flash				=  $params->def( 'flash', 1 );
		// table
		$table				=  $params->def( 'table', 1 );
		// horizontal line
		$hr					=  $params->def( 'hr', 1 );
		// fullscreen
		$fullscreen			=  $params->def( 'fullscreen', 1 );
		// autosave
		$autosave			= $params->def( 'autosave', 0 );
		// layer
		$layer				= $params->def( 'layer', 1 );
		// style
		$style				= $params->def( 'style', 1 );

		if ($language->isRTL()) {
			$text_direction = 'rtl';
		} else {
			$text_direction = 'ltr';
		}

		if ( $langMode ) {
			$langPrefix = substr( $language->getTag(), 0, strpos( $language->getTag(), '-' ) );
		}
		// loading of css file for `styles` dropdown
		if ( $content_css_custom ) {
			$content_css = 'content_css : "'. $content_css_custom .'", ';
		} else {

			/*
			 * Lets get the default template for the site application
			 */
			$query = "SELECT template"
			. "\n FROM #__templates_menu"
			. "\n WHERE client_id = 0"
			. "\n AND menuid = 0"
			;
			$db->setQuery( $query );
			$template = $db->loadResult();


			if($content_css)
			{
				$content_css = 'content_css : "'. $url .'templates/'. $template .'/css/';

				$file_path = JPATH_SITE .'/templates/'. $template .'/css/';
				if ( file_exists( $file_path .DS. 'editor.css' ) ) {
					$content_css = $content_css . 'editor.css' .'", ';
				} else {
					$content_css = $content_css . 'template_css.css", ';
				}
			} else {
				$content_css = '';
			}
		}

		$plugins 	= array();
		$buttons2	= array();
		$buttons3	= array();
		$elements	= array();

		if ( $cleanup ) {
			$cleanup	= 'true';
		} else {
			$cleanup	= 'false';
		}

		if ( $cleanup_startup ) {
			$cleanup_startup = 'true';
		} else {
			$cleanup_startup = 'false';
		}

		if ( $newlines ) {
			$br_newlines	= 'true';
			$p_newlines		= 'false';
		} else {
			$br_newlines	= 'false';
			$p_newlines		= 'true';
		}

		// Tiny Compressed mode
		if ( $compressed ) {
			$load = "\t<script type=\"text/javascript\" src=\"".$url."plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce_gzip.php\"></script>\n";
		} else {
			$load = "\t<script type=\"text/javascript\" src=\"".$url."plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js\"></script>\n";
		}

		// search & replace
		if ( $searchreplace ) {
			$plugins[]	= 'searchreplace';
			$buttons2[]	= 'search,replace';
		}
		$plugins[]	= 'insertdatetime';
		// insert date
		if ( $insertdate ) {
			$buttons2[]	= 'insertdate';
		}
		// insert time
		if ( $inserttime ) {
			$buttons2[]	= 'inserttime';
		}
		// emotions
		if ( $smilies ) {
			$plugins[]	= 'emotions';
			$buttons2[]	= 'emotions';
		}

		// horizontal line
		if ( $hr ) {
			$plugins[]	= 'advhr';
			$elements[] = 'hr[class|width|size|noshade]';
			$buttons3[]	= 'advhr';
		}
		// flash
		if ( $flash ) {
			$plugins[]	= 'flash';
			$buttons3[]	= 'flash';
		}
		// table
		if ( $table ) {
			$plugins[]	= 'table';
			$buttons3[]	= 'tablecontrols';
		}
		// fullscreen
		if ( $fullscreen ) {
			$plugins[]	= 'fullscreen';
			$buttons3[]	= 'fullscreen';
		}
		// rtl/ltr buttons
		$plugins[] = 'directionality';
		$buttons2[] = 'ltr,rtl';
		// autosave
		if ( $autosave ) {
			$plugins[]	= 'autosave';
		}
		// layer
		if ( $layer ) {
			$plugins[]	= 'layer';
			$buttons2[]	= 'insertlayer';
			$buttons2[]	= 'moveforward';
			$buttons2[]	= 'movebackward';
			$buttons2[]	= 'absolute';
		}
		// style
		if ( $style ) {
			$plugins[]	= 'style';
			$buttons3[]	= 'styleprops';
		}

		$buttons2 	= implode( ', ', $buttons2 );
		$buttons3 	= implode( ', ', $buttons3 );
		$plugins 	= implode( ', ', $plugins );
		$elements 	= implode( ', ', $elements );

		$return = $load .
			"\t<script type=\"text/javascript\">
			tinyMCE.init({
			theme : \"$theme\",
			language : \"". $langPrefix . "\",
			mode : \"specific_textareas\",
			document_base_url : \"". $url ."\",
			entities : \"60,lt,62,gt\",
			relative_urls : $relative_urls,
			remove_script_host : false,
			save_callback : \"TinyMCE_Save\",
			invalid_elements : \"$invalid_elements\",
			theme_advanced_toolbar_location : \"$toolbar\",
			theme_advanced_source_editor_height : \"$html_height\",
			theme_advanced_source_editor_width : \"$html_width\",
			directionality: \"$text_direction\",
			force_br_newlines : \"$br_newlines\",
			force_p_newlines : \"$p_newlines\",
			$content_css
			debug : false,
			cleanup : $cleanup,
			cleanup_on_startup : $cleanup_startup,
			safari_warning : false,
			plugins : \"advlink, advimage, $plugins\",
			theme_advanced_buttons2_add : \"$buttons2\",
			theme_advanced_buttons3_add : \"$buttons3\",
			theme_advanced_disable : \"help\",
			plugin_insertdate_dateFormat : \"$format_date\",
			plugin_insertdate_timeFormat : \"$format_time\",
			extended_valid_elements : \"hr[id|class|title], a[class|name|href|target|title|onclick], img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name], $elements\",
			fullscreen_settings : {
				theme_advanced_path_location : \"top\"
			}
		});
		function TinyMCE_Save(editor_id, content, node)
		{
			base_url = tinyMCE.settings['document_base_url'];
			var vHTML = content;
			if (true == true){
				vHTML = tinyMCE.regexpReplace(vHTML, 'href\s*=\s*\"?'+base_url+'', 'href=\"', 'gi');
				vHTML = tinyMCE.regexpReplace(vHTML, 'src\s*=\s*\"?'+base_url+'', 'src=\"', 'gi');
				vHTML = tinyMCE.regexpReplace(vHTML, 'mce_real_src\s*=\s*\"?', '', 'gi');
				vHTML = tinyMCE.regexpReplace(vHTML, 'mce_real_href\s*=\s*\"?', '', 'gi');
			}
			return vHTML;
		}
	</script>";

		return $return;
	}

	/**
	 * TinyMCE WYSIWYG Editor - get the editor content
	 *
	 * @param string 	The name of the editor
	 */
	function onGetContent( $editor ) {
		return "tinyMCE.getContent();";
	}

	/**
	 * TinyMCE WYSIWYG Editor - set the editor content
	 *
	 * @param string 	The name of the editor
	 */
	function onSetContent( $editor, $html ) {
		return "tinyMCE.setContent(".$html.");";
	}

	/**
	 * TinyMCE WYSIWYG Editor - copy editor content to form field
	 *
	 * @param string 	The name of the editor
	 */
	function onSave( $editor ) {
		return "tinyMCE.triggerSave();";
	}

	/**
	 * TinyMCE WYSIWYG Editor - display the editor
	 *
	 * @param string The name of the editor area
	 * @param string The content of the field
	 * @param string The width of the editor area
	 * @param string The height of the editor area
	 * @param int The number of columns for the editor area
	 * @param int The number of rows for the editor area
	 */
	function onDisplay( $name, $content, $width, $height, $col, $row )
	{
		// Only add "px" to width and height if they are not given as a percentage
		if (is_numeric( $width )) {
			$width .= 'px';
		}
		if (is_numeric( $height )) {
			$height .= 'px';
		}

		return "<textarea id=\"$name\" name=\"$name\" cols=\"$col\" rows=\"$row\" style=\"width:{$width}; height:{$height};\" mce_editable=\"true\">$content</textarea>";
	}

	function onGetInsertMethod($name)
	{
		$doc = & JFactory::getDocument();

		$js= "function jInsertEditorText( text ) {
			tinyMCE.execCommand('mceInsertContent',false,text);
		}";
		$doc->addScriptDeclaration($js);

		return true;
	}
}
?>
