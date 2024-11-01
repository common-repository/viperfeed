<?php
/*
Plugin Name: ViperFeed
Plugin URI: http://www.viperchill.com/wordpress-plugins/
Description: Add custom elements to your posts on feeds. The graphical user interface makes this easy to do!
Version: 1.1
Author: ViperChill
Author URI: http://www.viperchill.com
License: GPL2
	Copyright 2011  Glen Allsopp  (email : hq@viperchill.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists("ViperFeed")) {
	class ViperFeed {
		var $options_name = "ViperFeed_options";
		
		function init() {
			$this->get_admin_options();
		}
		
		function ViperFeed() { //constructor
		}
		
		function addContent($content = '') {
			if (!is_feed()) return $content;
			
			$options = get_option($this->options_name);
			
			if($options['enabled'] == "true") {
				$content .= $this->footer();
			}
			return $content;
		}
		
		public function footer() {
			$options = get_option($this->options_name);
			
			$output = "";
		
			$plugin_dir = str_replace("/".basename(__FILE__),"",plugin_basename(__FILE__));
			
			$upload_dir = wp_upload_dir();
			
			if($options['comments_link'] == "true") {
				$output .= "<p><a href=\"".get_permalink()."#comments\">".$options['comments_link_text']."</a></p>";
			}
			
			if($options['breaker_image_style'] == "image") {
				$breaker = $upload_dir['baseurl']."/ViperFeed_custom.jpg";
			} else {
				$breaker = WP_PLUGIN_URL."/".$plugin_dir."/breaker.php?color=".$options['breaker_color']."&width=580";
			}
			
			if($options['breaker_link'] != "") {
				$link_start = "<a href=\"".$options['breaker_link']."\">";
				$link_stop = "</a>";
			} else {
				$link_start = "";
				$link_stop = "";
			}
			
			$output .= "<p>".$link_start."<img src=\"".$breaker."\" style=\"display: block;\" title=\"Breaker Image\" alt=\"Breaker Image\">".$link_stop."</p>";
			
			$output .= $options['footer_text'];
			
			if($options['attribution'] == "true") {
				$output .= "<p><a href=\"http://bit.ly/viperfeed\">Provided by ViperChill.</a></p>";
			}
			
			return $output;
		}
		
		function add_menu($content = '') {
			add_options_page(
				'ViperFeed Options',
				'ViperFeed',
				'manage_options',
				'ViperFeed',
				array(&$this, 'options_menu')
			);
		}
		
		function options_menu() {
			if (!current_user_can('manage_options'))  {
				wp_die( __('You do not have sufficient permissions to access this page.') );
			}
			
			if($_REQUEST['submit']) {
				if ($_FILES["file"]["error"] < 1) {
					$upload_dir = wp_upload_dir();
					
					move_uploaded_file($_FILES["file"]["tmp_name"],$upload_dir['basedir']."/ViperFeed_custom.jpg");
				}
			
				update_option($this->options_name,$_REQUEST);
			}
			
			require("options_menu.php");
		}
		
		function get_admin_options() {
			$default_options = array(
				'enabled' => 'true',
				'breaker' => '1',
				'footer_text' => 'ViperFeed',
				'comments_link' => 'false',
				'comments_link_text' => 'Leave a comment!',
				'attribution' => 'true',
				'breaker_image_style' => 'color',
				'breaker_color' => '555555',
				'breaker_link' => ''
			);
			
			$options = get_option($this->options_name);
			
			if (!empty($options)) {
				foreach ($options as $key => $value)
					$default_options[$key] = $value;
			}
			
			update_option($this->options_name, $default_options);
			
			return $default_options;
		}
	}
} //End Class ViperFeed

if (class_exists("ViperFeed")) {
	$ViperFeed = new ViperFeed();
}

//Actions and Filters
if (isset($ViperFeed)) {
	//Actions
		add_action('activate_ViperFeed/ViperFeed.php',  array(&$ViperFeed, 'init'));
		add_action('admin_menu', array(&$ViperFeed, 'add_menu'), 1);
	
	//Filters
		add_filter('the_content', array(&$ViperFeed, 'addContent'));
}
?>
