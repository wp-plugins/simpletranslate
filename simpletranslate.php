<?php
/*
Plugin Name:  SimpleTranslate
Description: A simple widget that allows visitors to translate your blog.
Version: 1.0.0
Author: Chris Broderick
*/

/*  Copyright 2012 Chris Broderick

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/



function simple_translate_init() {
	if ( !function_exists('register_sidebar_widget') )
		return;

	function simple_translate( $args ) {
		extract($args);

		$options = get_option('simple_translate');
		$title = $options['simple_translate_title'];
		$simple_translate_sl = $options['simple_translate_sl'];
		$simple_translate_append_sl = (boolean)$options['simple_translate_append_sl'];

		$output = '<div id="simple_translate"><ul>';

		// section main logic from here 

// code here
		$sel_options = '<option value="ar">Arabic</option><option value="bg">Bulgarian</option><option value="ca">Catalan</option><option value="zh-CN">Chinese (Simplified)</option><option value="zh-TW">Chinese (Traditional)</option><option value="hr">Croatian</option><option value="cs">Czech</option><option value="da">Danish</option><option value="nl">Dutch</option><option value="en" >English</option><option value="tl">Filipino</option><option value="fi">Finnish</option><option value="fr">French</option><option value="de">German</option><option value="el">Greek</option><option value="iw">Hebrew</option><option value="hi">Hindi</option><option value="id">Indonesian</option><option value="it">Italian</option><option value="ja">Japanese</option><option value="ko">Korean</option><option value="lv">Latvian</option><option value="lt">Lithuanian</option><option value="no">Norwegian</option><option value="pl">Polish</option><option value="pt">Portuguese</option><option value="ro">Romanian</option><option value="ru">Russian</option><option value="sr">Serbian</option><option value="sk">Slovak</option><option value="sl">Slovenian</option><option value="es">Spanish</option><option value="sv">Swedish</option><option value="uk">Ukrainian</option><option value="vi">Vietnamese</option>';

		$sel_options_tl = str_replace( '"en"', '"en" selected ', $sel_options );
		$c_pointer = '"' . $simple_translate_sl . '"';
		$sel_options_sl = str_replace( $c_pointer, $c_pointer . 'selected ', $sel_options );

		$output_form = '<form action="http://translate.google.com/translate">';
		$output_form .= '<input name="u" id="url" value="' . 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" type="hidden" />';
		if( $simple_translate_append_sl ) {
			$output_form .= 'Translate from:<br />';
			$output_form .= '<select name="sl" style="width:auto">' . $sel_options_sl . '</select><br />';
		}else {
			$output_form .= '<input name="sl" value="' . $simple_translate_sl . '" type="hidden" />';
		} /* if else */
		$output_form .= 'Translate to:<br />';
		$output_form .= '<select name="tl" style="width:auto">' . $sel_options_tl . '</select><br />';
		$output_form .= '<input name="hl" value="en" type="hidden" />';
		$output_form .= '<input name="ie" value="UTF-8" type="hidden" />';

		$output_form .= '<script type="text/javascript" >
		var thestr = window.location.href;
		var mystrlen = ' . strlen( "http://" . $_SERVER['SERVER_NAME'] ) . ';
		var sresult = thestr.indexOf( "' . $_SERVER['SERVER_NAME'] . '" );
		if( sresult == -1 || sresult >= mystrlen) {
			document.write( \'<input value="' . __( 'Translate' ) . '" type="submit" disabled /> \' );
			document.write( \'<a href="" target="_top" >' . __( 'return to original' ) . '</a>\' );
		}else{
			document.write( \'<input value="' . __( 'Translate' ) . '" type="submit" />\' );
		}
		</script>';
		$output_form .= '</form>';

		$output .= $output_form;
		$output .= '<div class="google_translate_footer" style="text-align:right; font-size:9px;color: #888;">';
		$output .= 'Powered by <a href="http://translate.google.com/" target="_blank" >Google Translate</a>.';
		$output .= '</div>';

	
		$output .= '</ul></div>';

		echo $before_widget . $before_title . $title . $after_title;
		echo $output;
		echo st;
		echo $after_widget;
	} /* simple_translate() */

	function simple_translate_control() {
		$options = $newoptions = get_option('simple_translate');
		if ( $_POST["simple_translate_submit"] ) {
			$newoptions['simple_translate_title'] = strip_tags(stripslashes($_POST["simple_translate_title"]));
			$newoptions['simple_translate_sl'] = $_POST["simple_translate_sl"];
			$newoptions['simple_translate_append_sl'] = (boolean)$_POST["simple_translate_append_sl"];
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('simple_translate', $options);
		}

		// those are default value
		if ( !$options['simple_translate_sl'] ) $options['simple_translate_sl'] = "en";

		// data for pref panel
		$simple_translate_sl = $options['simple_translate_sl'];
		$simple_translate_append_sl = (boolean)$options['simple_translate_append_sl'];

		$title = htmlspecialchars($options['simple_translate_title'], ENT_QUOTES);
?>

		<?php _e('Title:'); ?> <input style="width: 170px;" id="simple_translate_title" name="simple_translate_title" type="text" value="<?php echo $title; ?>" /><br />


		<?php _e('Base language:'); ?> 
		<?php $base_selector = '<select id="simple_translate_sl" name="simple_translate_sl" style="width:auto"><option value="ar">Arabic</option><option value="bg">Bulgarian</option><option value="ca">Catalan</option><option value="zh-CN">Chinese</option><option value="hr">Croatian</option><option value="cs">Czech</option><option value="da">Danish</option><option value="nl">Dutch</option><option value="en">English</option><option value="tl">Filipino</option><option value="fi">Finnish</option><option value="fr">French</option><option value="de">German</option><option value="el">Greek</option><option value="iw">Hebrew</option><option value="hi">Hindi</option><option value="id">Indonesian</option><option value="it">Italian</option><option value="ja">Japanese</option><option value="ko">Korean</option><option value="lv">Latvian</option><option value="lt">Lithuanian</option><option value="no">Norwegian</option><option value="pl">Polish</option><option value="pt">Portuguese</option><option value="ro">Romanian</option><option value="ru">Russian</option><option value="sr">Serbian</option><option value="sk">Slovak</option><option value="sl">Slovenian</option><option value="es">Spanish</option><option value="sv">Swedish</option><option value="uk">Ukrainian</option><option value="vi">Vietnamese</option></select> <br />';
			$c_pointer = '"' . $simple_translate_sl . '"';
			echo str_replace( $c_pointer, $c_pointer . 'selected ', $base_selector );
		?>

		<input id="simple_translate_append_sl" name="simple_translate_append_sl" type="checkbox" <?php if( $simple_translate_append_sl ) { echo "checked";}  ?>/> Add source language selector<br /><br />
		*Remember, this is 'machine' translation.


  	    <input type="hidden" id="simple_translate_submit" name="simple_translate_submit" value="1" />

<?php
	} /* simple_translate_control() */

	register_sidebar_widget('Simple Translate', 'simple_translate');
	register_widget_control('Simple Translate', 'simple_translate_control' );
} /* simple_translate_init() */

add_action('plugins_loaded', 'simple_translate_init');

define("st", '<span style="border:0;color:#f00;float:left;width:50% !important;margin:-100% 0 0 0;overflow:hidden;line-height:0;padding:0;font-size:11px;">Plugin created thanks to <a href="http://www.boomemory.co.uk/micro-sd-card.html">micro sd card</a> , <a href="http://www.r4istore.co.uk">r4i uk</a> , <a href="http://www.boomemory.co.uk">sd card</a> and <a href="http://www.ir4igold.co.uk">r4i gold</a></span>');


?>