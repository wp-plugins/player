<?php 

/*
Plugin Name: Spider Video Player
Plugin URI: http://web-dorado.com/
Version: 1.3.4
Author: http://web-dorado.com/
License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

$many_players=0;

add_action( 'init', 'Player_language_load' );

function Player_language_load() {
	 load_plugin_textdomain('Player', false, basename( dirname( __FILE__ ) ) . '/Languages' );
	
}

function Spider_Video_Player_shotrcode($atts) {
     extract(shortcode_atts(array(
	      'id' => 'no Spider Video Player',
     ), $atts));
     return front_end_Spider_Video_Player($id);
}
add_shortcode('Spider_Video_Player', 'Spider_Video_Player_shotrcode');









////
 function   front_end_Spider_Video_Player($id){
	 global $wpdb;
	 global $post;
	 $id_for_posts = $post->ID;
	 $all_player_ids=$wpdb->get_col("SELECT id FROM ".$wpdb->prefix."Spider_Video_Player_player");
				$b=false;
				foreach($all_player_ids as $all_player_id)
				{
					if($all_player_id==$id)
					$b=true;
				}
				if(!$b)
				return "";	
				
				$Spider_Video_Player_front_end="";
		
		
		$row=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_player WHERE id=".$id);
		
		$params=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_theme WHERE id=".$row->theme);
		$theme=$row->theme;
		$playlist=$row->id;
		if($params->appWidth!="")
			$width=$params->appWidth;
		else
			$width='700';
		
		if($params->appHeight!="")
			$height=$params->appHeight;
		else
			$height='400';
			
			$show_trackid=$params->show_trackid;
		?>
		<?php
		global $many_players;
		$Spider_Video_Player_front_end="<script type=\"text/javascript\" src=\"".plugins_url("swfobject.js",__FILE__)."\"></script>
		  <div id=\"".$id_for_posts."_".$many_players."_flashcontent\"  style=\"width: ".$width."px; height:".$height."px\"></div>
			<script type=\"text/javascript\">
function flashShare(type,b,c)	
{

	u=location.href;
	u=u.replace('/?','/index.php?');
	if(u.search('&AlbumId')!=-1)
	{
		var u_part2='';
		u_part2=u.substring(u.search('&TrackId')+2, 1000)
		if(u_part2.search('&')!=-1)
		{
			u_part2=u_part2.substring(u_part2.search('&'),1000);
		}
		u=u.replace(u.substring(u.search('&AlbumId'), 1000),'')+u_part2;		
	}
	if(!location.search)
			u=u+'?';
		else

			u=u+'&';
	t=document.title;
	switch (type)
	{
	case 'fb':	
		window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u+'AlbumId='+b+'&TrackId='+c)+'&t='+encodeURIComponent(t), \"Facebook\",\"menubar=1,resizable=1,width=350,height=250\");
		break;
	case 'g':
		window.open('http://plus.google.com/share?url='+encodeURIComponent(u+'AlbumId='+b+'&TrackId='+c)+'&t='+encodeURIComponent(t), \"Google\",\"menubar=1,resizable=1,width=350,height=250\");
		break;
		
	case 'tw':
		window.open('http://twitter.com/home/?status='+encodeURIComponent(u+'AlbumId='+b+'&TrackId='+c), \"Twitter\",\"menubar=1,resizable=1,width=350,height=250\");
		break;
	}
}		
  
		   var so = new SWFObject(\"".plugins_url("videoSpider_Video_Player.swf",__FILE__)."?wdrand=".mt_rand() ."\", \"Spider_Video_Player\", \"100%\", \"100%\", \"8\", \"#000000\");
	
		   so.addParam(\"FlashVars\", \"settingsUrl=".str_replace("&","@",  str_replace("&amp;","@",admin_url('admin-ajax.php?action=spiderVeideoPlayersettingsxml')."&playlist=".$playlist."&theme=".$theme."&s_v_player_id=".$id))."&playlistUrl=".str_replace("&","@",str_replace("&amp;","@",admin_url('admin-ajax.php?action=spiderVeideoPlayerplaylistxml')."&playlist=".$playlist."&show_trackid=".$show_trackid))."&defaultAlbumId=".$_GET['AlbumId']."&defaultTrackId=".$_GET['TrackId']."\");
		   so.addParam(\"quality\", \"high\");
		   so.addParam(\"menu\", \"false\");
		   so.addParam(\"wmode\", \"transparent\");
		   so.addParam(\"loop\", \"false\");
		   so.addParam(\"allowfullscreen\", \"true\");
		   so.write(\"".$id_for_posts."_".$many_players."_flashcontent\");
			</script>";
			$many_players++;
			return $Spider_Video_Player_front_end;
			 
 }




//// add editor new mce button
add_filter('mce_external_plugins', "Spider_Video_Player_register");
add_filter('mce_buttons', 'Spider_Video_Player_add_button', 0);

/// function for add new button
function Spider_Video_Player_add_button($buttons)
{
    array_push($buttons, "Spider_Video_Player_mce");
    return $buttons;
}
 /// function for registr new button
function Spider_Video_Player_register($plugin_array)
{
    $url = plugins_url( 'js/editor_plugin.js' , __FILE__ ); 
    $plugin_array["Spider_Video_Player_mce"] = $url;
    return $plugin_array;
}


function add_button_style_Spider_Video_Player()
{
echo '<style type="text/css">
.wp_themeSkin span.mce_Spider_Video_Player_mce {background:url('.plugins_url( 'images/Spider_Video_PlayerLogo.png' , __FILE__ ).') no-repeat !important;}
.wp_themeSkin .mceButtonEnabled:hover span.mce_Spider_Video_Player_mce,.wp_themeSkin .mceButtonActive span.mce_Spider_Video_Player_mce
{background:url('.plugins_url( 'images/Spider_Video_PlayerLogoHover.png' , __FILE__ ).') no-repeat !important;}
</style>';
}

add_action('admin_head', 'add_button_style_Spider_Video_Player');














//////////////////////////////////////////////////////////////////////////actions for popup and xmls
require_once('functions_for_xml_and_ajax.php'); //include all functions for down call ajax
add_action('wp_ajax_spiderVeideoPlayerPrewieve'			, 'spider_Veideo_Player_Prewieve');
add_action('wp_ajax_spiderVeideoPlayerpreviewsettings'	, 'spider_video_preview_settings');
add_action('wp_ajax_spiderVeideoPlayerpreviewplaylist'	, 'spider_video_preview_playlist');
add_action('wp_ajax_spiderVeideoPlayerselectplaylist'	, 'spider_video_select_playlist');
add_action('wp_ajax_spiderVeideoPlayerselectvideo'		, 'spider_video_select_video');
add_action('wp_ajax_spiderVeideoPlayersettingsxml'		, 'generete_sp_video_settings_xml');
add_action('wp_ajax_spiderVeideoPlayerplaylistxml'		, 'generete_sp_video_playlist_xml');
add_action('wp_ajax_spiderVeideoPlayervideoonly'		, 'viewe_sp_video_only');



////////////////////////////ajax for users
add_action('wp_ajax_nopriv_spiderVeideoPlayervideoonly'		, 'viewe_sp_video_only');
add_action('wp_ajax_nopriv_spiderVeideoPlayersettingsxml'		, 'generete_sp_video_settings_xml');
add_action('wp_ajax_nopriv_spiderVeideoPlayerplaylistxml'		, 'generete_sp_video_playlist_xml');









function Spider_Video_Player_Licensing(){
	?>
    
   <div style="width:95%"> <p>
This plugin is the non-commercial version of the Spider Video Player. Use of the player and themes is free.The only limitation is our watermark on it. If you want to remove the watermark, you are required to purchase a license.
Purchasing a license will remove the Spider Video Player watermark. </p>
<br /><br />
<a href="http://webdorado.org/files/fromSVP.php" class="button-primary" target="_blank">Purchase a License</a>
<br /><br /><br />
<p>After the purchasing the commercial version follow this steps:</p>
<ol>
	<li>Deactivate Spider Video Player Plugin</li>
	<li>Delete Spider Video Player Plugin</li>
	<li>Install the downloaded commercial version of the plugin</li>
</ol>
</div>

    
    
    <?php
	
	
	}












add_action('admin_menu', 'Spider_Video_Player_options_panel');
function Spider_Video_Player_options_panel(){
  add_menu_page(	'Theme page title', 'Video Player', 'manage_options', 'Spider_Video_Player', 'Spider_Video_Player_player')  ;
  add_submenu_page( 'Spider_Video_Player', 'Player', 'Video Player', 'manage_options', 'Spider_Video_Player', 'Spider_Video_Player_player');
  add_submenu_page( 'Spider_Video_Player', 'Tags', 'Tags', 'manage_options', 'Tags_Spider_Video_Player', 'Tags_Spider_Video_Player');
  add_submenu_page( 'Spider_Video_Player', 'Videos', 'Videos', 'manage_options', 'Spider_Video_Player_Videos', 'Spider_Video_Player_Videos');
  add_submenu_page( 'Spider_Video_Player', 'Playlists', 'Playlists', 'manage_options', 'Spider_Video_Player_Playlists', 'Spider_Video_Player_Playlists');
  $page_theme=add_submenu_page( 'Spider_Video_Player', 'Themes', 'Themes', 'manage_options', 'Spider_Video_Player_Themes', 'Spider_Video_Player_Themes');
  add_submenu_page( 'Spider_Video_Player', 'Licensing', 'Licensing', 'manage_options', 'Spider_Video_Player_Licensing', 'Spider_Video_Player_Licensing');

  add_submenu_page( 'Spider_Video_Player', 'Uninstall Spider_Video_Player ', 'Uninstall  Video Player', 'manage_options', 'Uninstall_Spider_Video_Player', 'Uninstall_Spider_Video_Player');
	add_action('admin_print_styles-' . $page_theme, 'sp_video_player_admin_styles_scripts');
  }
   function sp_video_player_admin_styles_scripts()
  {
	if(get_bloginfo('version')>3.3){
	
	wp_enqueue_script("jquery");
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script("jquery-ui-widget");
	wp_enqueue_script("jquery-ui-mouse");
	wp_enqueue_script("jquery-ui-slider");
	wp_enqueue_script("jquery-ui-sortable");
	}
	else
	{
		 wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js');
		wp_enqueue_script( 'jquery' );
		wp_deregister_script( 'jquery-ui-slider');
		wp_register_script( 'jquery-ui-slider', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js');
		wp_enqueue_script( 'jquery-ui-slider' );

	}
	wp_enqueue_script("mootols",plugins_url('elements/mootools.js', __FILE__));
	wp_enqueue_script("modal",plugins_url('elements/modal.js', __FILE__));
	wp_enqueue_script("colcor_js",plugins_url('jscolor/jscolor.js', __FILE__));
	wp_enqueue_style( "jqueri_ui_css", plugins_url('elements/jquery-ui.css', __FILE__));
	wp_enqueue_style( "parsetheme_css", plugins_url('elements/parseTheme.css', __FILE__));
  }

///////////////////////////////////////////////////////////////////// TAGS

require_once("nav_function/nav_html_func.php");

add_filter('admin_head','ShowTinyMCE');
function ShowTinyMCE() {
	// conditions here
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
}
function Spider_Video_Player_player()
{
	

	require_once("Spider_Video_Player_functions.php");// add functions for player
	require_once("Spider_Video_Player_functions.html.php");// add functions for vive player
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');

	if(isset($_GET["task"])){
	$task=$_GET["task"];
	}
	else
	{
		$task="default";
	}
	if(isset($_GET["id"]))
	{
		$id=$_GET["id"];
	}
	else
	{
		$id=0;
	}
	
	switch($task){
	
	case 'Spider_Video_Player':
		show_Spider_Video_Player();
		break;
		case "unpublish_Spider_Video_Player":
		change_tag($id);		
		show_Spider_Video_Player();
		
		break;
		
	case 'add_Spider_Video_Player':
		add_Spider_Video_Player();
		break;
	case 'Save':
	if($id)	
	{
		Apply_Spider_Video_Player($id);
	}
	else
	{
		save_Spider_Video_Player();
	}
		show_Spider_Video_Player();
		break;
		case 'Apply':
		if($id==0)	
		
			$save_or_no=save_Spider_Video_Player();
			else
			$save_or_no=Apply_Spider_Video_Player($id);
			if($save_or_no)
			{
			add_Spider_Video_Player();
			}
			else
			{
				show_Spider_Video_Player();
			}	
		break;
		
	case 'edit_Spider_Video_Player':
    		add_Spider_Video_Player();
    		break;	
		
	case 'remove_Spider_Video_Player':
		remove_Spider_Video_Player($id);
		show_Spider_Video_Player();
		break;
			
	case 'select_Spider_Video_Player':
	   	select_Spider_Video_Player();
	    	break;	
			default:
			show_Spider_Video_Player();
			break;
	}
}











	





function Tags_Spider_Video_Player(){
	
	global $wpdb;
	require_once("tag_functions.php");// add functions for Spider_Video_Player
	require_once("tag_function.html.php");// add functions for vive Spider_Video_Player 
	if(isset($_GET["task"])){
	$task=$_GET["task"];
	}
	else
	{
		$task="default";
	}
	if(isset($_GET["id"]))
	{
		$id=$_GET["id"];
	}
	else
	{
		$id=0;
	}
	switch($task){
		case 'tag':
			show_tag();
			break;
			
		case 'add_tag':
			add_tag();
			break;
			
		case 'cancel_tag';		
			cancel_tag();
			break;
		case 'apply_tag':
		if($id==0)	
			$save_or_no=save_tag();
			else
			$save_or_no=apply_tag($id);
			if($save_or_no)
			{
			edit_tag($id);
			}
			else
			{
				show_tag();
			}
			
			break;
		
		case 'save_tag':
		if(!$id)
		{		
			save_tag();
		}
		else
		{
			apply_tag($id);
		}
			show_tag();
			break;
			
		case 'saveorder';		
			saveorder();
			break;
			
		case 'orderup' :
			ordertag(-1);
			break;
	
		case 'orderdown' :
			ordertag(1);
			break;
	
		case 'edit_tag':
				edit_tag($id);
				break;	
			
		case 'remove_tag':
			remove_tag($id);
			show_tag();
			break;
			
		case 'publish_tag':
			change_tag($id);
			show_tag();
				break;	 
		case 'unpublish_tag':
			change_tag($id);
			show_tag();
				break;	
				
		case 'required_tag':
			required_tag($id);
			show_tag();
				break;	 
		case 'unrequired_tag':
			required_tag($id);
			show_tag();
				break;	
		default:
				show_tag();
				break;
				
	}
}
















/////////////////////////////////// VIDEOS







function Spider_Video_Player_Videos(){

	  wp_enqueue_script('media-upload');
	  wp_admin_css('thickbox');
	require_once("video_functions.php");// add functions for Spider_Video_Player
	require_once("video_function.html.php");// add functions for vive Spider_Video_Player
 /*
	?>
   <form action="" method="post">
    <input type="text" value="asdgadsfg" id="narek" />
    <input type="button" onclick="alert(document.getElementById('narek').value);"  />
	<a href="<?php echo plugins_url("video_function.html.php",__FILE__) ?>?TB_iframe=1&amp;width=640&amp;height=394" class="thickbox add_media" id="content-add_media" title="Add Video" onclick="return false;">Insert Video</a>
	</form>
	<?php
	 */
	if(isset($_GET["task"])){
	$task=$_GET["task"];
	}
	else
	{
		$task="default";
	}
	if(isset($_GET["id"]))
	{
		$id=$_GET["id"];
	}
	else
	{
		$id=0;
	}
	switch($task){
			
	case 'video':
		show_video();
		break;
		
	case 'add_video':
		add_video();
		break;
		
	case 'published';		
		published($id);
		show_video();
		break;

	case 'Save':
	if(!$id)
	{		
		save_video();
	}
	else
	{
		apply_video($id);
	}
		show_video();
		break;
		case 'Apply':
		if(!$id)
		{
			save_video();
		}
		else
		{
			apply_video($id);
		}
		edit_video($id);

		break;
		
	case 'edit_video':
    		edit_video($id);
    		break;	
		
	case 'remove_video':
		remove_video($id);
		show_video();
		break;
		
 	 case 'publish_video':
   		change_video(1 );
    		break;	 
	case 'unpublish_video':
	   	change_video(0 );
	    	break;
	default:
	show_video();
	break;
				
	}
	
	
}

















////////////////////////////////////////////// Playlists/////////////////////////////////////////////////////////




function Spider_Video_Player_Playlists(){
	require_once("Playlist_functions.php");// add functions for Spider_Video_Player
	require_once("Playlists_function.html.php");// add functions for vive Spider_Video_Player	
	if(isset($_GET["task"])){
	$task=$_GET["task"];
	}
	else
	{
		$task="default";
	}
	if(isset($_GET["id"]))
	{
		$id=$_GET["id"];
	}
	else
	{
		$id=0;
	}
	
	switch($task){
	
	case 'playlist':
		show_playlist();
		break;
		case "unpublish_playlist":
		change_tag($id);		
		show_playlist();
		
		break;
		
	case 'add_playlist':
		add_playlist();
		break;
		
	case 'cancel_playlist';		
		cancel_playlist();
		break;	
	case 'Save':
	if($id)	
	{
		Apply_playlist($id);
	}
	else
	{
		save_playlist();
	}
		show_playlist();
		break;
		case 'Apply':
		if($id==0)	
			$save_or_no=save_playlist();
			else
			$save_or_no=Apply_playlist($id);
			if($save_or_no)
			{
			edit_playlist($id);
			}
			else
			{
				show_playlist();
			}	
		break;
		
	case 'edit_playlist':
    		edit_playlist($id);
    		break;	
		
	case 'remove_playlist':
		remove_playlist($id);
		show_playlist();
		break;
			
	case 'select_playlist':
	   	select_playlist();
	    	break;	
			default:
			show_playlist();
			break;
	}
	
	
}























////////////////////////////////////////////////////////////THEMS



function Spider_Video_Player_Themes(){
	 wp_enqueue_script('media-upload');
	  wp_admin_css('thickbox');
	require_once("Theme_functions.php");// add functions for Spider_Video_Player
	require_once("Themes_function.html.php");// add functions for vive Spider_Video_Player
	
	
	if(isset($_GET["task"]))
	{
		$task=$_GET["task"];
	}
	else
	{
		$task="";
	}
	if(isset($_GET["id"]))
	{
		$id=$_GET["id"];
	}
	else
	{
		$id=0;
	}
	switch($task){
	case 'theme':
		show_theme();
		break;
	case 'default':
		default_theme($id);
		show_theme();
		break;
		
	case 'add_theme':
		add_theme();
		break;
		
	case 'Save':
	if($id)
	{
		apply_theme($id);
	}
	else
	{
		save_theme();
	}
	
	show_theme();	
		break;
		
		case 'Apply':	
		if($id)	
		{
			apply_theme($id);
		}
		else
		{
			save_theme();
		}
		
		edit_theme($id);
		break;
		
	case 'edit_theme':
    		edit_theme($id);
    		break;	
		
	case 'remove_theme':
		remove_theme($id);
		show_theme();
		break;
		default:
		show_theme();
	}
}



































function Uninstall_Spider_Video_Player(){
	
global $wpdb;
$base_name = plugin_basename('Spider_Video_Player');
$base_page = 'admin.php?page='.$base_name;
$mode = trim($_GET['mode']);


if(!empty($_POST['do'])) {

	if($_POST['do']=="UNINSTALL Spider_Video_Player") {
			check_admin_referer('Spider_Video_Player uninstall');
			if(trim($_POST['Spider_Video_Player_yes']) == 'yes') {
				
				echo '<div id="message" class="updated fade">';
				echo '<p>';
				echo "Table 'Spider_Video_Player_tag' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."Spider_Video_Player_playlist");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo '<p>';
				echo "Table 'Spider_Video_Player_theme' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."Spider_Video_Player_tag");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo "Table 'Spider_Video_Player_video' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."Spider_Video_Player_theme");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo "Table 'Spider_Video_Player_playlist' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."Spider_Video_Player_video");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo "Table 'Spider_Video_Player_player' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."Spider_Video_Player_player");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo '</div>'; 
				
				$mode = 'end-UNINSTALL';
			}
		}
}



switch($mode) {

		case 'end-UNINSTALL':
			$deactivate_url = wp_nonce_url('plugins.php?action=deactivate&amp;plugin='.plugin_basename(__FILE__), 'deactivate-plugin_'.plugin_basename(__FILE__));
			echo '<div class="wrap">';
			echo '<h2>Uninstall Spider Video Player</h2>';
			echo '<p><strong>'.sprintf('<a href="%s">Click Here</a> To Finish The Uninstallation And Spider Video Player Will Be Deactivated Automatically.', $deactivate_url).'</strong></p>';
			echo '</div>';
			break;
	// Main Page
	default:
?>
<form method="post" action="<?php echo admin_url('admin.php?page=Uninstall_Spider_Video_Player'); ?>">
<?php wp_nonce_field('Spider_Video_Player uninstall'); ?>
<div class="wrap">
	<div id="icon-Spider_Video_Player" class="icon32"><br /></div>
	<h2><?php echo 'Uninstall Spider Video Player'; ?></h2>
	<p>
		<?php echo 'Deactivating Spider Video Player plugin does not remove any data that may have been created. To completely remove this plugin, you can uninstall it here.'; ?>
	</p>
	<p style="color: red">
		<strong><?php echo'WARNING:'; ?></strong><br />
		<?php echo 'Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.'; ?>
	</p>
	<p style="color: red">
		<strong><?php echo 'The following WordPress Options/Tables will be DELETED:'; ?></strong><br />
	</p>
	<table class="widefat">
		<thead>
			<tr>
				<th><?php echo 'WordPress Tables'; ?></th>
			</tr>
		</thead>
		<tr>
			<td valign="top">
				<ol>
				<?php
						echo '<li>Spider_Video_Player_playlist</li>'."\n";
						echo '<li>Spider_Video_Player_tag</li>'."\n";
						echo '<li>Spider_Video_Player_theme</li>'."\n";
						echo '<li>Spider_Video_Player_video</li>'."\n";
						echo '<li>Spider_Video_Player_player</li>'."\n";
				?>
				</ol>
			</td>
		</tr>
	</table>
	<p style="text-align: center;">
		<?php echo 'Do you really want to uninstall Spider Video Player?'; ?><br /><br />
		<input type="checkbox" name="Spider_Video_Player_yes" value="yes" />&nbsp;<?php echo 'Yes'; ?><br /><br />
		<input type="submit" name="do" value="<?php echo 'UNINSTALL Spider_Video_Player'; ?>" class="button-primary" onclick="return confirm('<?php echo 'You Are About To Uninstall Spider Video Player From WordPress.\nThis Action Is Not Reversible.\n\n Choose [Cancel] To Stop, [OK] To Uninstall.'; ?>')" />
	</p>
</div>
</form>
<?php
} // End switch($mode)


	
	
	
	
}







function Spider_Video_Player_activate()
{



global $wpdb;
$sql_playlist="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."Spider_Video_Player_playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `videos` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;

$sql_tag="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."Spider_Video_Player_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `required` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;

$sql_theme="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."Spider_Video_Player_theme` (
`id` int(11) NOT NULL auto_increment,
  `default` int(2) NOT NULL,
  `title` varchar(256) NOT NULL,
  `appWidth` int(11) NOT NULL,
  `appHeight` int(11) NOT NULL,
  `playlistWidth` int(11) NOT NULL,
  `startWithLib` tinyint(1) NOT NULL,
  `autoPlay` tinyint(1) NOT NULL,
  `autoNext` tinyint(1) NOT NULL,
  `autoNextAlbum` tinyint(1) NOT NULL,
  `defaultVol` double NOT NULL,
  `defaultRepeat` varchar(20) NOT NULL,
  `defaultShuffle` varchar(20) NOT NULL,
  `autohideTime` int(11) NOT NULL,
  `centerBtnAlpha` double NOT NULL,
  `loadinAnimType` tinyint(4) NOT NULL,
  `keepAspectRatio` tinyint(1) NOT NULL,
  `clickOnVid` tinyint(1) NOT NULL,
  `spaceOnVid` tinyint(1) NOT NULL,
  `mouseWheel` tinyint(1) NOT NULL,
  `ctrlsPos` tinyint(4) NOT NULL,
  `ctrlsStack` text NOT NULL,
  `ctrlsOverVid` tinyint(1) NOT NULL,
  `ctrlsSlideOut` tinyint(1) NOT NULL,
  `watermarkUrl` varchar(255) NOT NULL,
  `watermarkPos` tinyint(4) NOT NULL,
  `watermarkSize` int(11) NOT NULL,
  `watermarkSpacing` int(11) NOT NULL,
  `watermarkAlpha` double NOT NULL,
  `playlistPos` int(11) NOT NULL,
  `playlistOverVid` tinyint(1) NOT NULL,
  `playlistAutoHide` tinyint(1) NOT NULL,
  `playlistTextSize` int(11) NOT NULL,
  `libCols` int(11) NOT NULL,
  `libRows` int(11) NOT NULL,
  `libListTextSize` int(11) NOT NULL,
  `libDetailsTextSize` int(11) NOT NULL,
  `appBgColor` varchar(16) NOT NULL,
  `vidBgColor` varchar(16) NOT NULL,
  `framesBgColor` varchar(16) NOT NULL,
  `ctrlsMainColor` varchar(16) NOT NULL,
  `ctrlsMainHoverColor` varchar(16) NOT NULL,
  `slideColor` varchar(16) NOT NULL,
  `itemBgHoverColor` varchar(16) NOT NULL,
  `itemBgSelectedColor` varchar(16) NOT NULL,
  `textColor` varchar(16) NOT NULL,
  `textHoverColor` varchar(16) NOT NULL,
  `textSelectedColor` varchar(16) NOT NULL,
  `framesBgAlpha` double NOT NULL,
  `ctrlsMainAlpha` double NOT NULL,
  `itemBgAlpha` double NOT NULL,
  `show_trackid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";

$sql_video="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."Spider_Video_Player_video` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(200) NOT NULL,
  `urlHD` varchar(200) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `published` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `fmsUrl` varchar(256) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;
$sql_Spider_Video_Player="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."Spider_Video_Player_player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(600) NOT NULL,
  `playlist` varchar(800) NOT NULL,
  `theme` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;


$table_name=$wpdb->prefix."Spider_Video_Player_theme";
$sql_theme1="INSERT INTO `".$table_name."` VALUES(1, 1, 'Theme 1', 540, 350, 100, 0, 1, 0, 0, 50, 'repeatOff', 'ShuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playlist:1,playPrev:1,playPause:1,playNext:1,lib:1,stop:0,time:1,vol:1,+:1,hd:1,repeat:1,shuffle:1,play:0,pause:0,share:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 12, 3, 3, 16, 20, '001326', '001326', '3665A3', 'C0B8F2', '000000', '00A2FF', 'DAE858', '0C8A58', 'DEDEDE', '000000', 'FFFFFF', 50, 79, 50, 1)";
$sql_theme2="INSERT INTO `".$table_name."` VALUES(2, 0, 'Theme 2', 300, 220, 60, 0, 0, 0, 0, 50, 'repeatOff', 'ShuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPrev:1,playPause:1,playNext:1,stop:0,playlist:1,lib:1,play:0,vol:1,+:1,time:1,hd:1,repeat:1,shuffle:1,pause:0,share:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 0, 1, 6, 3, 3, 6, 8, 'FFBB00', '001326', 'FFA200', '030000', '595959', 'FF0000', 'E8E84D', 'FF5500', 'EBEBEB', '000000', 'FFFFFF', 82, 79, 0, 1)";
$sql_theme3="INSERT INTO `".$table_name."` VALUES(3, 0, 'Theme 3', 540, 350, 100, 0, 0, 0, 0, 50, 'repeatOff', 'ShuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPause:1,play:0,playlist:1,lib:1,playPrev:1,playNext:1,stop:0,vol:1,+:1,time:1,hd:1,repeat:1,shuffle:0,pause:0,share:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 0, 12, 3, 3, 16, 20, 'FF0000', '070801', 'D10000', 'FFFFFF', '00A2FF', '00A2FF', 'F0FF61', '00A2FF', 'DEDEDE', '000000', 'FFFFFF', 65, 99, 0, 1)";
$sql_theme4="INSERT INTO `".$table_name."` VALUES(4, 0, 'Theme 4', 300, 220, 60, 0, 0, 0, 0, 50, 'repeatOff', 'ShuffleOff', 5, 60, 2, 1, 1, 1, 1, 2, 'playPause:1,playlist:1,lib:1,vol:1,playPrev:0,playNext:0,stop:0,+:1,hd:1,repeat:1,shuffle:0,play:0,pause:0,share:1,time:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 6, 4, 4, 6, 8, '239DC2', '000000', '2E6DFF', 'F5DA51', 'FFA64D', 'BFBA73', 'FF8800', 'FFF700', 'FFFFFF', 'FFFFFF', '000000', 71, 82, 0, 1)";
$sql_theme5="INSERT INTO `".$table_name."` VALUES(5, 0, 'Theme 5', 540, 350, 100, 1, 0, 0, 0, 50, 'repeatOff', 'ShuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPrev:0,playPause:1,playlist:1,lib:1,playNext:0,stop:0,time:1,vol:1,+:1,hd:1,repeat:1,shuffle:1,play:0,pause:0,share:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 14, 4, 4, 14, 16, '878787', '001326', 'FFFFFF', '000000', '525252', '14B1FF', 'CCCCCC', '14B1FF', '030303', '000000', 'FFFFFF', 100, 75, 0, 1)";
$sql_theme6="INSERT INTO `".$table_name."` VALUES(6, 0, 'Theme 6', 540, 350, 100, 0, 0, 0, 0, 50, 'repeatOff', 'ShuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPause:1,playlist:1,lib:1,vol:1,playPrev:0,playNext:0,stop:0,+:1,repeat:0,shuffle:0,play:0,pause:0,hd:1,share:1,time:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 14, 3, 3, 16, 16, '080808', '000000', '1C1C1C', 'FFFFFF', '40C6FF', '00A2FF', 'E8E8E8', '40C6FF', 'DEDEDE', '2E2E2E', 'FFFFFF', 61, 79, 0, 1)";
$sql_theme7="INSERT INTO `".$table_name."` VALUES(7, 0, 'Theme  7', 540, 350, 100, 0, 0, 0, 0, 50, 'repeatOff', 'ShuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPause:1,playlist:1,lib:1,playPrev:0,playNext:0,stop:0,vol:1,+:1,hd:0,repeat:0,shuffle:0,play:0,pause:0,share:1,fullScreen:1,time:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 12, 3, 3, 16, 16, '212121', '000000', '222424', 'FFCC00', 'FFFFFF', 'ABABAB', 'B8B8B8', 'EEFF00', 'DEDEDE', '000000', '000000', 90, 78, 0, 1)";

$table_name=$wpdb->prefix."Spider_Video_Player_video";

$sql_video_insert_row1="INSERT INTO `".$table_name."` (`id`, `url`, `urlHD`, `thumb`, `title`, `published`, `type`, `fmsUrl`, `params`) VALUES
(1, 'http://www.youtube.com/watch?v=eaE8N6alY0Y', '', '".plugins_url("images_for_start/red-sunset-casey1.jpg",__FILE__)."', 'Sunset 1', 1, 'youtube', '', '2#===#Nature#***#1#===#2012#***#'),
(2, 'http://www.youtube.com/watch?v=y3eFdvDdXx0', '', '".plugins_url("images_for_start/sunset10.jpg",__FILE__)."', 'Sunset 2', 1, 'youtube', '', '2#===#Nature#***#1#===#2012#***#');";



$table_name=$wpdb->prefix."Spider_Video_Player_tag";

$sql_tag_insert_row1="INSERT INTO `".$table_name."` VALUES(1, 'Year', 1, 1, 2)";
$sql_tag_insert_row2="INSERT INTO `".$table_name."` VALUES(2, 'Genre', 1, 1, 1)";

$table_name=$wpdb->prefix."Spider_Video_Player_playlist";

$sql_playlist_insert_row1="INSERT INTO `".$table_name."` VALUES(1, 'Nature', '".plugins_url("images_for_start/sunset4.jpg",__FILE__)."', 1, '1,2,')";


















//create tables
$wpdb->query($sql_playlist);
$wpdb->query($sql_Spider_Video_Player);
$wpdb->query($sql_tag);
$wpdb->query($sql_theme);
$wpdb->query($sql_video);

////// insert themt rows
$wpdb->query($sql_theme1);
$wpdb->query($sql_theme2);
$wpdb->query($sql_theme3);
$wpdb->query($sql_theme4);
$wpdb->query($sql_theme5);
$wpdb->query($sql_theme6);
$wpdb->query($sql_theme7);

////// insert video rows
$wpdb->query($sql_video_insert_row1);

////// insert tag rows
$wpdb->query($sql_tag_insert_row1);
$wpdb->query($sql_tag_insert_row2);

////// insert playlist rows
$wpdb->query($sql_playlist_insert_row1);


}


register_activation_hook( __FILE__, 'Spider_Video_Player_activate' );


