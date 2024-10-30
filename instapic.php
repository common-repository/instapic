<?php
/*
Plugin Name: InstaPic
Plugin URI: http://phpwords.wordpress.com/
Description: A Plugin For Showing InstaGram Images on Your Site From Your Username, Hashtag(#) or Both
Version: 1.1
Author: Yatendra
Author URI: http://phpwords.wordpress.com/
*/
?>
<?php

class Instapics {
 

    public function __construct() 
	{
             
              add_action('admin_enqueue_scripts', array($this, 'inpic_js_css'));
              add_action('admin_menu',  array($this,'inpic_admin_menu'));
	      $plugin_file = plugin_basename(__FILE__); 
	       add_filter( "plugin_action_links_{$plugin_file}", array($this,'your_plugin_settings_link'));

          }


	


	public function inpic_js_css()
	{

		$css_url=WP_PLUGIN_URL.'/instapic/css/';
        	wp_enqueue_style('insta-style', $css_url.'admin.css');

	}



	public function inpic_admin_menu()
	{

		add_menu_page('InstaPics', 'InstaPics', 'manage_options', __FILE__, __FILE__);
		add_submenu_page(  __FILE__, 'Settings', 'Settings', 'manage_options', __FILE__, array($this, 'inpic_admin_tab') );
	
	}

	public function inpic_admin_tab()
	{
	
         	include('setting_insta.php');
		
	
	}

	public function your_plugin_settings_link($links)
	 { 
		  $settings_link = '<a href="admin.php?page=instapic/instapic.php">Settings</a>'; 
		  array_unshift($links, $settings_link); 
		  return $links; 
	}


}

$obj = new Instapics;
include( WP_PLUGIN_DIR.'/instapic/feeds/instagram/instagram-feed.php' );


?>
