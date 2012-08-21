<?php 
$path  = ''; // It should be end with a trailing slash  
if ( !defined('WP_LOAD_PATH') ) {

	/** classic root path if wp-content and plugins is below wp-config.php */
	$classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;
	
	if (file_exists( $classic_root . 'wp-load.php') )
		define( 'WP_LOAD_PATH', $classic_root);
	else
		if (file_exists( $path . 'wp-load.php') )
			define( 'WP_LOAD_PATH', $path);
		else
			exit("Could not find wp-load.php");
}

// let's load WordPress
require_once( WP_LOAD_PATH . 'wp-load.php');
	 global $wpdb;
	 global $post;
	 $id=$_GET['id_player'];
	 $id_for_posts = $post->ID;
	 $all_player_ids=$wpdb->get_col("SELECT id FROM ".$wpdb->prefix."Spider_Video_Player_player");
				$b=false;
				foreach($all_player_ids as $all_player_id)
				{
					if($all_player_id==$id)
					$b=true;
				}
				if(!$b){
				echo "<h2>Error svpv_31</h2>";
				return "";
				}
				
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
		  <div id=\"".$id_for_posts."_".$many_players."_flashcontent\"  style=\"width: ".($width+20)."px; height:".($height+20)."px; margin-top:-40px; margin-left:-40px;\"></div>
			<script type=\"text/javascript\">
function flashShare(type,b,c)	
{

	u=location.href;
	u=u.replace('/?','/index.php?');
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
		window.open('http://twitter.com/home/?status='+encodeURIComponent(u+'&AlbumId='+b+'&TrackId='+c), \"Twitter\",\"menubar=1,resizable=1,width=350,height=250\");
		break;
	}
}		
  
		   var so = new SWFObject(\"".plugins_url("videoSpider_Video_Player.swf",__FILE__)."?wdrand=".mt_rand() ."\", \"Spider_Video_Player\", \"100%\", \"100%\", \"8\", \"#000000\");
	
		   so.addParam(\"FlashVars\", \"settingsUrl=".str_replace("&","@",  str_replace("&amp;","@",plugins_url("settings.php",__FILE__)."?playlist=".$playlist."&theme=".$theme."&s_v_player_id=".$id))."&playlistUrl=".str_replace("&","@",str_replace("&amp;","@",plugins_url("playlist.php",__FILE__)."?playlist=".$playlist."&show_trackid=".$show_trackid))."&defaultAlbumId=".$_GET['AlbumId']."&defaultTrackId=".$_GET['TrackId']."\");
		   so.addParam(\"quality\", \"high\");
		   so.addParam(\"menu\", \"false\");
		   so.addParam(\"wmode\", \"transparent\");
		   so.addParam(\"loop\", \"false\");
		   so.addParam(\"allowfullscreen\", \"true\");
		   so.write(\"".$id_for_posts."_".$many_players."_flashcontent\");
			</script>";
			echo $Spider_Video_Player_front_end;
			 

 ?>