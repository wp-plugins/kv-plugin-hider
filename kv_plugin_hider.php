<?php
/**
 * Plugin Name: KV Plugin Hider 
 * Plugin URI: http://kvcodes.com/
 * Description: Generally all the plug-ins are allowed to see your logged in users, If you want to hide a particular plugin From your users, Just use this plugin to hide it from the plugins.php page.  But it will work if you activated the plugin.
 * Author: Kvvaradha
 * Author URI: http://kvcodes.com/
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
if(!function_exists('kv_admin_pluginlist_menu')) {
	function kv_admin_pluginlist_menu() { 		
		add_menu_page('Kv Plugin Hider', 'Kv Plugin Hider', 'manage_options', 'kv_plugin_hider' , 'kv_list_plugins', KV_PLUGIN_LIST_URL.'/images/kv_logo.png', 66);	
	}
	add_action('admin_menu', 'kv_admin_pluginlist_menu');
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
	if(empty($kv_plugins_list) || $kv_plugins_list == '' ) {	
		foreach($array_Plugins as $plugin_file => $plugin_data) {		
			$kv_pl_title = str_replace(' ', '_', strtolower($plugin_data['Title']));	
				 $kv_plugins_list_new[$kv_pl_title] =   1 ;
		}	
		
	}	else { 
		
		foreach($array_Plugins as $plugin_file => $plugin_data) {		
			$kv_pl_title = str_replace(' ', '_', strtolower($plugin_data['Title']));
			$kv_temp_name= $kv_plugins_list[$kv_pl_title]; 
			if( $kv_temp_name == 1 ) {		
				 $kv_plugins_list_new[$kv_pl_title] =   1 ;
			} else {
				 $kv_plugins_list_new[$kv_pl_title] =   0 ; 
			}
		}	
	}
	if(empty($kv_plugins_list)) {
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