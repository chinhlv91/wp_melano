<?php 
	if (!function_exists('ct_wp_path')) {
		function ct_wp_path() {
			if (strstr($_SERVER["SCRIPT_FILENAME"], "/wp-content/")) {
				return preg_replace("/\/wp-content\/.*/", "", $_SERVER["SCRIPT_FILENAME"]);
			} else {
			return preg_replace("/\/[^\/]+?\/themes\/.*/", "", $_SERVER["SCRIPT_FILENAME"]);
			}
		}
	}
	
	require_once( ct_wp_path() . '/wp-load.php' );
?>