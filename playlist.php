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
$id_for_playlist=$_GET["playlist"];
$playerr=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_player WHERE id=".$id_for_playlist);
$playlists=array();
$playlists_id=array();
$show_trackid=$_GET['show_trackid'];

				$playlists_id=explode(',',$playerr->playlist);
				$playlists_id= array_slice($playlists_id,0, count($playlists_id)-1); 
				foreach($playlists_id as $playlist_id)
				{
					$query ="SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_playlist WHERE published='1' AND id=".$playlist_id ;
					$playlists[] = $wpdb->get_row($query);
				}
foreach($playlists as $playlist)
				{
					if($playlist)
					{
						$viedos_temp=array();
						$videos_id=explode(',',$playlist->videos);
						$videos_id= array_slice($videos_id,0, count($videos_id)-1);   
						foreach($videos_id as $video_id)
						{
							$query ="SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_video WHERE id =".$video_id ;
							$viedos_temp[] = $wpdb->get_row($query);
						}
			
						$videos[$playlist->id] = $viedos_temp;
					}
				}

	echo '<library>
';
		foreach($playlists as $playlist)

		{
			
			if($playlist)
			{
echo	'	<albumFree title="'.htmlspecialchars($playlist->title).'" thumb="'.$playlist->thumb.'" id="'.$playlist->id.'">
';
$i=0;
				foreach($videos[$playlist->id] as $video)
		
				{
					$i++;
				echo '<track  id="'.$video->id.'" type="'.$video->type.'"';
				if($video->type=="rtmp")
					echo ' fmsUrl="'.htmlspecialchars($video->fmsUrl).'"';
				if($video->type=="http")
					echo ' url="'.htmlspecialchars($video->url).'"';
				else
					echo ' url="'.htmlspecialchars($video->url).'"';
				if($video->type=="http")
					echo ' urlHD="'.htmlspecialchars($video->urlHD).'"';
				else
				if($video->type=="rtmp")
					echo ' urlHD="'.htmlspecialchars($video->urlHD).'"';
				echo ' thumb="';
				if($video->thumb)
					if(is_file(htmlspecialchars($video->thumb)))
						echo htmlspecialchars($video->thumb);
					else
						echo htmlspecialchars($video->thumb);
				echo '"';
				if($show_trackid)
				echo ' trackId="'.$i.'" ';
				echo '>'.$video->title.'</track>
';
				}
				
				
echo '	</albumFree>
';
			}
		}





echo '</library>' ;

?>
