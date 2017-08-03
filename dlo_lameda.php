<?php

/*
Plugin Name: Lameda
Plugin URI: http://didier.lorphelin.free.fr/blog/index.php/wordpress/lameda
Description: List attachment metadata
Version: 0.1.5
Author: Didier Lorphelin
Author URI: http://didier.lorphelin.free.fr
*/

define('LAMEDADIR', dirname(plugin_basename(__FILE__)));

function dlo_lameda_init() {

	load_plugin_textdomain('lameda', PLUGINDIR . '/' . LAMEDADIR . '/languages');
}

add_action('init', 'dlo_lameda_init');

function dlo_lameda($id, $info) {

	$metadata = wp_get_attachment_metadata($id);
	if (!empty($metadata) && is_array($metadata)) {
		if ($info != 'all') {
			while (list($key, $val) = each($metadata)) {
				if ($key == $info) {
					if (is_array($val))
						$newmetadata = $val;
					else
						$newmetadata = array($key => $val);
					}
				}
			if (!empty($newmetadata))
				$metadata = $newmetadata;
			}

		$result = '<table class="dlo_lameda">';
		$result .= dlo_extract_meta($metadata);
     		$result .= '</table>';
		}
	return $result;
}

function dlo_extract_meta($meta) {
	foreach ($meta as $key => $value) {
		if (!is_array($value))
			$out .= "<tr><th>" . __($key, 'lameda') . "</th><td>$value</td></tr>";
		else
			$out .= "<tr><th>" . __($key, 'lameda') . "</th><td><table>" . dlo_extract_meta($value) . "</table></td></tr>";
            }
	return $out;
}

// Image metadata 
function dlo_exif_lameda($id, $info) {
	
	$metadata = wp_get_attachment_metadata($id);
		if (!empty($metadata) && is_array($metadata)) {
			while (list($key, $val) = each($metadata)) {
				if ($key == 'image_meta')
					$newmetadata = $val;
				}
			if (!empty($newmetadata)) {
				if ($info != 'all') {
					$subinfo = explode(',', $info);
					foreach($subinfo as $s)
						$subdata[$s] = $newmetadata[$s];
					}
				else
					$subdata = $newmetadata;
				$result = '<table class="dlo_lameda">';
				$result .= dlo_extract_meta($subdata);
     				$result .= '</table>';
				return $result;
				}
			}
}

// The attachment template tag version
function lameda($info = 'all', $id = '') {
	global $post;
	if ($id = '')
		$id = $post->ID;
	echo dlo_lameda($id, $info);
}

// The exif template tag version
function lameda_exif($info = 'all', $id = '') {
	global $post;
	if ($id = '')
		$id = $post->ID;
	echo dlo_exif_lameda($id, $info);
}


// The shortcode version
if (function_exists('add_shortcode')) {

	function dlo_shortcode_lameda($atts) {
		global $post;
		extract(shortcode_atts(array(
			'id' => $post->ID,
			'info' => 'all')
			, $atts));
		$id = intval($id);
		return dlo_lameda($id, $info);
	}

	add_shortcode('lameda', 'dlo_shortcode_lameda');

	function dlo_shortcode_exif_lameda($atts) {
		global $post;
		extract(shortcode_atts(array(
			'id' => $post->ID,
			'info' => 'all')
			, $atts));
		$id = intval($id);
		return dlo_exif_lameda($id, $info);
	}

	add_shortcode('lameda_exif', 'dlo_shortcode_exif_lameda');


}

?>