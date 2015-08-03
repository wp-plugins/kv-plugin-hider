<?php
/**
 * Plugin Name: KV Plugin Hider 
 * Plugin URI: http://wordpress.org/plugins/kv-plugin-hider/
 * Description: Generally all the plug-ins are allowed to see your logged in users, If you want to hide a particular plugin From your users, Just use this plugin to hide plugins from the plugins.php page.  But it will work if you activated the plugin. <a href="http://www.kvcodes.com" target="_blank" > Read more </a> 
 * Author: Kvvaradha
 * Author URI: http://profiles.wordpress.org/kvvaradha
 * Version: 1.0
 */
define('KV_PLUGIN_LIST_URL', plugin_dir_url( __FILE__ ));

################################################################################
// styles required for KV Plugin Hider
################################################################################
if(is_admin()) {
	$css_url = plugins_url(basename(dirname(__FILE__)) . '/css/kv_list_plugins.css');

	wp_register_style('kv_list_plugins', $css_url, array(), WPLISTPLUGINS_VERSION, 'screen');
	wp_enqueue_style('kv_list_plugins');
}

################################################################################
// plugin menu creation
################################################################################
/*if(!function_exists('kv_admin_pluginlist_menu')) {
	function kv_admin_pluginlist_menu() { 		
		add_menu_page('Kv Plugin Hider', 'Kv Plugin Hider', 'manage_options', 'kv_plugin_hider' , 'kv_list_plugins', KV_PLUGIN_LIST_URL.'/images/kv_logo.png', 66);	
	}
	add_action('admin_menu', 'kv_admin_pluginlist_menu');
}
*/
if(!function_exists('kv_admin_menu')) {
	function kv_admin_menu() { 		
		add_menu_page('Kvcodes', 'Kvcodes', 'manage_options', 'kvcodes' , 'kv_codes_plugins', KV_PLUGIN_LIST_URL.'/images/kv_logo.png', 66);	
		add_submenu_page( 'kvcodes', 'Kv Plugin Hider', 'Kv Plugin Hider', 'manage_options', 'kv_plugin_hider', 'kv_list_plugins' );
	}
add_action('admin_menu', 'kv_admin_menu');

function kv_codes_plugins() {

?>
 <div class="wrap">
        <div class="icon32" id="icon-tools"><br/></div>
        <h2><?php _e('KvCodes', 'kvcodes') ?></h2>		
		<div class="welcome-panel">
								<?php //kv_admin_thirty_day_chart () ; ?>
								Thank you for using Kvcodes Plugins . Here is my few Plugins work .MY plugins are very light weight and Simple.  <p>
								<a href="http://www.kvcodes.com/" target="_blank" ><h3> Visit My Blog</h3></a></p> 
								</div> 
		<div id="poststuff" > 
			<div id="post-body" class="metabox-holder columns-2" >
				<div id="post-body-content" > 
					<div class="meta-box-sortables"> 
						<div id="dashboard_right_now" class="postbox">
							<div class="handlediv" > <br> </div>
							<h3 class="hndle"  ><img src="<?php echo KV_PLUGIN_LIST_URL.'/images/kv_logo.png'; ?>" >  My plugins </h3> 
							<div class="inside" style="padding: 10px; "> 
								
								<?php 
									$kv_wp =  kv_get_web_page('http://profiles.wordpress.org/kvvaradha'); 
									
									 $kv_first_pos = strpos($kv_wp['content'], '<div id="content-plugins" class="info-group plugin-theme main-plugins inactive">');
									
									$kv_first_trim = substr($kv_wp['content'] , $kv_first_pos ); 
										
									$kv_sec_pos = strpos($kv_first_trim, '</div>');
									
									$kv_sec_trim = substr($kv_first_trim ,0, $kv_sec_pos );  
									
									echo $kv_sec_trim; 					?> 
								</div>
								</div>
							</div>
						</div>
					</div>
				</div> 
				
				<div id="postbox-container-1" class="postbox-container" > 
					<div class="meta-box-sortables"> 
						<div id="postbox-container-2" class="postbox-container" > 
						
						<div id="dashboard_right_now" class="postbox">
							<div class="handlediv" > <br> </div>
							<h3 class="hndle" ><img src="<?php echo KV_PLUGIN_LIST_URL.'/images/kv_logo.png'; ?>" >  Donate </h3> 
							<div class="inside" style="padding: 10px; " > 
							<b>If i helped you, you can buy me a coffee, just press the donation button :)</b> 
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
								<input type="hidden" name="cmd" value="_donations" />
								<input type="hidden" name="business" value="<?php echo 'kvvaradha@gmail.com'; ?>" />
								<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
								<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
							</form>
							</div> 
						</div> 
						</div>
						<div id="postbox-container-2" class="postbox-container" > 
						<div id="dashboard_quick_press" class="postbox">
							<div class="handlediv" > <br> </div>
							<h3 class="hndle" ><img src="<?php echo KV_PLUGIN_LIST_URL.'/images/kv_logo.png'; ?>" >  Support me from Facebook </h3> 
							<div class="inside" style="padding: 10px; "> 
							<p><iframe allowtransparency="true" frameborder="0" scrolling="no" src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fkvcodes&amp;width=180&amp;height=300&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false&amp;appId=117935585037426" style="border:none; overflow:hidden; width:250px; height:300px;"></iframe></p>
							</div> 
						</div> 
						</div>
					</div>
				</div> 
				
			</div>
			</div> 

</div> <!-- /wrap -->
<?php

}

function kv_get_web_page( $url )
{
	$options = array(
		CURLOPT_RETURNTRANSFER => true,     // return web page
		CURLOPT_HEADER         => false,    // don't return headers
		CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		CURLOPT_ENCODING       => "",       // handle compressed
		CURLOPT_USERAGENT      => "spider", // who am i
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		CURLOPT_TIMEOUT        => 120,      // timeout on response
		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	);

	$ch      = curl_init( $url );
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );

	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $header;
}

} else {
	function kv_admin_submenu_plugin() { 		
		add_submenu_page( 'kvcodes', 'Kv Plugin Hider', 'Kv Plugin Hider', 'manage_options', 'kv_plugin_hider', 'kv_list_plugins' );
	}
add_action('admin_menu', 'kv_admin_submenu_plugin');
	
}

	if(!function_exists('get_plugins')) {
		require_once (ABSPATH . 'wp-admin/includes/plugin.php');
	}else { 
		return '<p>' . __('Couldn&#8217;t open plugins directory. get_plugins() Function is in use.', 'kv_list_plugins') . '</p>';
	}


//add_shortcode('pluginlist', 'kv_list_plugins');
################################################################################
// list and count all the plugins from your plugin directory.
################################################################################
function kv_list_plugins() {
	
	$array_Plugins = get_plugins();

	if(empty($array_Plugins)) {
		return '<p>' . __('Couldn&#8217;t open plugins directory or there are no plugins available.', 'kv_list_plugins') . '</p>';
	}	

	return kv_retrieve_pluginlist($array_Plugins);
}
################################################################################
// function to perform the enable and disable operation 
################################################################################
function kv_retrieve_pluginlist($array_Plugins) {

	if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['kv_plugin_action'] ) &&  $_POST['kv_plugin_action'] == "change") {
		foreach($array_Plugins as $plugin_file => $plugin_data) {
			$kv_pl_title = str_replace(' ', '_', strtolower($plugin_data['Title']));
			$kv_plugin_saved_value = stripslashes(trim($_POST[$kv_pl_title]));	
			$kv_plugins_altered_list[$kv_pl_title] = $kv_plugin_saved_value ; 
		}
		update_option("kv_plugins_list", $kv_plugins_altered_list);
	}	
	
	$var_iPlugInNumber = 1;
	$kv_plugins_list = get_option('kv_plugins_list');	
	$plugins_allowedtags1 = array(
		'a' => array(		'href' => array(),		'title' => array()	),
		'abbr' => array(	'title' => array()	),
		'acronym' => array(		'title' => array()	),
		'code' => array(),
		'em' => array(),
		'strong' => array()
	);
	$plugins_allowedtags2 = array(
		'abbr' => array(	'title' => array()	),
		'acronym' => array(		'title' => array()	),
		'code' => array(),
		'em' => array(),
		'strong' => array()
	);	
	if(empty($kv_plugins_list) || $kv_plugins_list == ' ' ||  $kv_plugins_list == null ) {	
		foreach($array_Plugins as $plugin_file => $plugin_data) {		
			$kv_pl_title = str_replace(' ', '_', strtolower($plugin_data['Title']));	
				 $kv_plugins_list_new[$kv_pl_title] =   1 ;
		}	
		
	}	else { 		
		foreach($array_Plugins as $plugin_file => $plugin_data) {		
			$kv_pl_title = str_replace(' ', '_', strtolower($plugin_data['Title']));
			$kv_temp_name= $kv_plugins_list[$kv_pl_title]; 
			if(empty($kv_temp_name)){ 
				 $kv_plugins_list_new[$kv_pl_title] =  1 ; 
			} else if( $kv_temp_name == 1 ) {		
				 $kv_plugins_list_new[$kv_pl_title] =   1 ;
			} else if($kv_temp_name == 0 ) {		
				 $kv_plugins_list_new[$kv_pl_title] =   0 ;
			}			
		}	
	}
	if(empty($kv_plugins_list) || $kv_plugins_list == ' ' ||  $kv_plugins_list == null) {
		delete_option("kv_plugins_list");
		add_option("kv_plugins_list" , $kv_plugins_list_new, '', 'yes' );
	}else {
		update_option("kv_plugins_list", $kv_plugins_list_new);
	}
	
	$var_sHtml = '
 <div class="wrap">
        <div class="icon32" id="icon-tools"><br/></div>
        <h2>Kv Plugin Hider</h2>

		<div class="welcome-panel">		
		Thank you for using KV PluginPress This is a initial Version.  If you want to know my forth coming works , like my facebook page.<br>  <div class="fb-like" data-href="http://facebook.com/kvcodes" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div> <p>		 
		</div> 
			<div id="dashboard-widget-wrap" >
			<div id="dashboard-widgets" class="metabox-holder columns-1" >
				<div id="postbox-container-1" class="postbox-container" > 
					<div class="meta-box-sortables"> 
						<div id="dashboard_right_now" class="postbox">
							<div class="handlediv" > <br> </div>
							<h3 class="hndle" > List of Plugins to Hide</h3> 
							<div class="inside" style="padding: 5px; " > 							
							
			<div class="plugInListWrapper">
				<div class="plugInListLine plugInListHeadline">
					<div class="plugInListHeadDescription">' . $var_sHeadline . '</div>
					<div class="plugInListNumber">No.</div>
					<div class="plugInListName">' . __('Plugin', 'kv_list_plugins') . '</div>				
					<div class="plugInListName">' . __('Author', 'kv_list_plugins') . '</div>
					<div class="plugInListAction">' . __('Actions', 'kv_list_plugins') . '</div>					
				</div><form method="post" name="hide_plugins_from_list">';
	if(!empty($kv_plugins_list)) {
	foreach($array_Plugins as $plugin_file => $plugin_data) {
		
		$kv_pl_title = str_replace(' ', '_', strtolower($plugin_data['Title']));
		$kv_plugin_enable_or_disable = $kv_plugins_list[$kv_pl_title]; 
		if($kv_plugin_enable_or_disable == 1) { 
			$kv_select_pl_op_enable =  "Selected";
			$kv_select_pl_op_diable =''; 			
		} else { 
			$kv_select_pl_op_diable ='Selected';
			$kv_select_pl_op_enable =  "";
		} 
		// PlugIn-Daten sammeln
		$plugin_data['Title'] = wp_kses($plugin_data['Title'], $plugins_allowedtags1);
		$plugin_data['Title'] = ($plugin_data['PluginURI']) ? '<a href="' . $plugin_data['PluginURI'] . '">' . $plugin_data['Title'] . '</a>' : $plugin_data['Title'];			
		$plugin_data['Author'] = wp_kses($plugin_data['Author'], $plugins_allowedtags1);
		$plugin_data['Author'] = (empty($plugin_data['Author'])) ? '' : ' <cite>' . sprintf(__('By %s', 'kv_list_plugins'), ($plugin_data['AuthorURI']) ? '<a href="' . $plugin_data['AuthorURI'] . '">' . $plugin_data['Author'] . '</a>' : $plugin_data['Author']) . '.</cite>';
		$plugin_data['Action'] = '<select name="'.$kv_pl_title.'" >	<option value="1" '.$kv_select_pl_op_enable.' >Enable</option><option value="0" '.$kv_select_pl_op_diable.' >Disable</option></select> ' ; 
		$var_sHtml .= '
				<div class="plugInListLine ' . $plugin_data['active'] . '">
					<div class="plugInListNumber">
						<p>' . $var_iPlugInNumber . '</p>
					</div>
					<div class="plugInListName">
						<p>' . $plugin_data['Title'] . '</p>
					</div>					
					<div class="plugInListName">						
						<p>' . $plugin_data['Author'] . '</p>
					</div>
					<div class="plugInListAction">						
						<p>' . $plugin_data['Action'] . '</p>
					</div>
				</div>';
		$var_iPlugInNumber++;
	}

	$var_sHtml .= '<div class="plugInListAction">						
						<p><input type="hidden" name="kv_plugin_action" value="change" ><input type="submit" name="save_changes" value="Save Changes"  class="button button-primary" ></p>
					</div></form></div></div> </div> </div> </div> </div></div> ';

	echo $var_sHtml;
	
	
	} else { 
			$var_sHtml .= '<br> <p> <h3> Sorry,  your Plugins directory is empty..... </h3> </p> ' ; 
			
			echo $var_sHtml; 
	}
	
}
function kv_refresh_plugins_list() {

	$array_Plugins = get_plugins();
	$kv_plugins_list = get_option('kv_plugins_list');
	
	if(empty($kv_plugins_list) || $kv_plugins_list == ' ' ||  $kv_plugins_list == null ) {	
		foreach($array_Plugins as $plugin_file => $plugin_data) {		
			$kv_pl_title = str_replace(' ', '_', strtolower($plugin_data['Title']));	
				 $kv_plugins_list_new[$kv_pl_title] =   1 ;
		}	
		
	}	else { 		
		foreach($array_Plugins as $plugin_file => $plugin_data) {		
			$kv_pl_title = str_replace(' ', '_', strtolower($plugin_data['Title']));
			$kv_temp_name= $kv_plugins_list[$kv_pl_title]; 
			if(empty($kv_temp_name)){ 
				 $kv_plugins_list_new[$kv_pl_title] =  1 ; 
			} else if( $kv_temp_name == 1 ) {		
				 $kv_plugins_list_new[$kv_pl_title] =   1 ;
			} else if($kv_temp_name == 0 ) {		
				 $kv_plugins_list_new[$kv_pl_title] =   0 ;
			}			
		}	
	}
	if(empty($kv_plugins_list) || $kv_plugins_list == ' ' ||  $kv_plugins_list == null) {
		add_option("kv_plugins_list" , $kv_plugins_list_new, '', 'yes' );
	}else {
		update_option("kv_plugins_list", $kv_plugins_list_new);
	}
}
add_action('admin_init' , 'kv_refresh_plugins_list'); 

function kv_plugins_hide_work($plugins) {
	$kv_total_plugins_list = get_plugins(); 
	$kv_plugins_list = get_option('kv_plugins_list');
	 foreach($kv_total_plugins_list as $plugin_file => $plugin_data) {		
		$kv_pl_title = str_replace(' ', '_', strtolower($plugin_data['Title']));
		$kv_temp_name = $kv_plugins_list[$kv_pl_title]; 
		if( $kv_temp_name == 0 ) {
			unset( $plugins[$plugin_file] );
		}
	} 
	
	return $plugins;
}

add_action('all_plugins', 'kv_plugins_hide_work'); 

################################################################################
// facebook like button
################################################################################
function fb_like_code() {
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php  }

add_action('admin_footer', 'fb_like_code');



?>