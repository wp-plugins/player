<?php 

/*
Plugin Name: Spider Video Player 
Plugin URI: http://web-dorado.com/
Version: 1.4.2
Author: http://web-dorado.com/
License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

$many_players=0;
add_action('wp_head','askofen_1',0);
function askofen_1($id)
{
	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery-ui",plugins_url('js/jquery-ui.min.js', __FILE__));
	wp_enqueue_script("transit",plugins_url('js/jquery.transit.js', __FILE__));
	wp_enqueue_style( "jqueri_ui", plugins_url('js/jquery-ui.css', __FILE__));
	wp_enqueue_script("flsh_detect",plugins_url('js/flash_detect.js', __FILE__));
}
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
	 $find_priority=$wpdb->get_row("SELECT priority FROM ".$wpdb->prefix."Spider_Video_Player_player WHERE id=".$id);
	$priority=$find_priority->priority;
	
	

	  
	 $row=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_player WHERE id=".$id);
	$params=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_theme WHERE id=".$row->theme);
	if($priority==0){ 
	 $scripttt='    <script type="text/javascript"> 
var html5_'.$id.' = document.getElementById("spidervideoplayerhtml5_'.$id.'");
var flash_'.$id.' = document.getElementById("spidervideoplayerflash_'.$id.'");
if(!FlashDetect.installed){
flash_'.$id.'.parentNode.removeChild(flash_'.$id.');
spidervideoplayerhtml5_'.$id.'.style.display=\'\';
}
else{
html5_'.$id.'.parentNode.removeChild(html5_'.$id.');
spidervideoplayerflash_'.$id.'.style.display=\'\';
}
</script>';
   
	}
	else
	{
		 $scripttt='';
	}

	 if($priority ==0){
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
			
		global $many_players;
		
		
		
				?>
		

        <?php		
        $Spider_Video_Player_front_end="<script type=\"text/javascript\" src=\"".plugins_url("swfobject.js",__FILE__)."\"></script>
		<div id=\"spidervideoplayerflash_".$id."\" style=\"display:none\">		
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
			</script>
			</div>
			";
			
			$many_players++;
			?>
            
         
     
            
            
            <?php
			return $Spider_Video_Player_front_end.Spider_Video_Player_front_end($id).$scripttt;
			
	 }
	 else
	 {
		 return Spider_Video_Player_front_end($id).'<script>document.getElementById("spidervideoplayerhtml5_'.$id.'").style.display=\'\'</script>';
	 }
	 
	 
}

function Spider_Video_Player_front_end($id){
ob_start();
?>	
<div id="spidervideoplayerhtml5_<?php echo $id?>" style="display:none">	
<?php	
	
	global $wpdb; 
	$theme_id=$wpdb->get_row("SELECT theme FROM ".$wpdb->prefix."Spider_Video_Player_player WHERE id=".$id);
	$playlist=$wpdb->get_row("SELECT playlist FROM ".$wpdb->prefix."Spider_Video_Player_player WHERE id=".$id);
	$playlist_array=explode(',',$playlist->playlist);
	
	
	global $many_players;

	if(isset($_POST['playlist_id'])){
	$playlistID	= $_POST['playlist_id'];
	}
	else $playlistID = 1;
	$key=$playlistID-1;
	


if(isset($playlist->playlist)){
$playlistID	= $playlist->playlist;
}
else $playlistID=1;
$key=$playlistID-1;
$row=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_playlist WHERE id=".$playlist_array[$key]);

$theme=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_theme WHERE id=".$theme_id->theme);
	
	$row1=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_player WHERE id=".$id);
	$params1=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_theme WHERE id=".$row1->theme);
	$themeid=$row1->theme;

$display=$_POST['display'];

$video_ids=substr($row->videos,0,-1);


	$videos = $wpdb->get_results("SELECT urlHtml5,type,title FROM ".$wpdb->prefix."Spider_Video_Player_video WHERE id IN ($video_ids)");

	
	$video_urls='';
	for($i=0;$i<count($videos);$i++)
	{
		if($videos[$i]->urlHtml5 !=""){
		
	$video_urls.="'".$videos[$i]->urlHtml5."'".',';
		}
		else $video_urls.="'".$videos[$i]->url."'".',';
	}
	
	 $video_urls=substr($video_urls,0,-1);
	 
	$playlists = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_playlist");
	
	$libRows=$theme->libRows;
	$libCols=$theme->libCols;
	
	$cellWidth=($theme->appWidth)/$libCols.'px';
	$cellHeight=($theme->appHeight)/$libRows.'px';
	
	$play = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_playlist");
				// load the row from the db table
	$k=$libRows*$libCols;
	
	if(isset($_POST['play'])){	
$p=$_POST['play'];
	}
	
	else $p=0;
$display='style="width:100%;height:100% !important;border-collapse: collapse; margin-left:8px !important;"';
$table_count=1;
$itemBgHoverColor ='#'.$theme->itemBgHoverColor;


$vds=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_video");
	
$ctrlsStack=$theme->ctrlsStack;
if($theme->ctrlsPos==2)
$ctrl_top='-35px';
else
$ctrl_top='-'.$theme->appHeight.'px';

$AlbumId=$_POST['AlbumId'];
$TrackId=$_POST['TrackId'];
?>

<style>

#album_table_<?php  echo $id?> td, 
#album_table_<?php  echo $id?> tr,
#album_table_<?php  echo $id?> img{
	padding: 3px 9px 0px 0px !important;
	line-height: 1em !important;
	}


#share_buttons_<?php echo $id;?> img{	
	display:inline !important;
}

#album_div_<?php  echo $id?> table{
	margin:0px !important;}
	
#album_table_<?php  echo $id?>{	
margin: -1 0 1.625em !important;
}


table
{
	
margin:0em;	
}
#global_body_<?php echo $id;?> .control_<?php  echo $id?>
{
position:relative;

background-color: rgba(<?php echo HEXDEC(SUBSTR($theme->framesBgColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->framesBgColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->framesBgColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>);

top:<?php echo $ctrl_top?>;
width:<?php echo $theme->appWidth; ?>px;
height:40px;
z-index:7;
margin-top: -5px;

}

#global_body_<?php echo $id;?> .control_<?php  echo $id?> td
{
	padding: 0px !important;
	margin: 0px !important;

}


#global_body_<?php echo $id;?> .control_<?php  echo $id?> td img{
	padding: 0px !important;
	margin: 0px !important;
	
	}

#global_body_<?php echo $id;?> .progressBar_<?php  echo $id?>
{
   position: relative;
   width: 100%;
   height:6px;
   z-index:5;
   cursor:pointer;
   border-top:1px solid rgba(<?php echo HEXDEC(SUBSTR($theme->slideColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->slideColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->slideColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>);
   border-bottom:1px solid rgba(<?php echo HEXDEC(SUBSTR($theme->slideColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->slideColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->slideColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>);
   
}
#global_body_<?php echo $id;?> .timeBar_<?php  echo $id?>
{
   position: absolute;
   top: 0;
   left: 0;
   width: 0;
   height: 100%;
   background-color: <?php echo '#'.$theme->slideColor; ?>;
   z-index:5;
   
}

#global_body_<?php echo $id;?>  .bufferBar_<?php  echo $id?> {
   position: absolute;
   top: 0;
   left: 0;
   width: 0;
   height: 100%;
   background-color: <?php echo '#'.$theme->slideColor; ?>;
   opacity:0.3;
  
   }
   
 #global_body_<?php echo $id;?> .volumeBar_<?php echo $id;?>
	{
   position: relative;
   overflow: hidden;
   width: 0px;
   height:4px;
   background-color: rgba(<?php echo HEXDEC(SUBSTR($theme->framesBgColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->framesBgColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->framesBgColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>);
   border:1px solid rgba(<?php echo HEXDEC(SUBSTR($theme->slideColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->slideColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->slideColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>);
   

	}
#global_body_<?php echo $id;?> .volume_<?php echo $id;?>
	{
   position: absolute;
   top: 0;
   left: 0;
   width: 0;
   height: 100%;
   background-color: <?php echo '#'.$theme->slideColor; ?>;

	}
	
	
	
	#kukla_<?php  echo $id?>
	{
	height:<?php echo $theme->appHeight; ?>px;
	width:0px;
	float:left;
	position:absolute; 
	background-color: rgba(<?php echo HEXDEC(SUBSTR($theme->framesBgColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->framesBgColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->framesBgColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>);
	color:white;
	z-index:100;
	padding: 0px !important;
	margin: 0px !important;
	}
   
   #kukla_<?php  echo $id?> img, 
   #kukla_<?php  echo $id?> td{
	background-color:transparent !important;
	color:white;
	padding: 0px !important;
	margin: 0px !important;
	
	
	   }
  
   .control_btns_<?php  echo $id?>
   {
   opacity:<?php echo $theme->ctrlsMainAlpha/100; ?>;
   
   }
	
	#control_btns_<?php  echo $id?>,
	#volumeTD_<?php echo $id;?>
   {
	margin: 0px;
	  }
  
  img{
	  box-shadow:none !important;  
	 
	  } 
	  
	#td_ik_<?php echo $id;?>{
			border:0px;
			
			
		}
	 
</style>
<?php 
$player_id=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."Spider_Video_Player_player WHERE id=".$id);

?>
<div id="global_body_<?php echo $id;?>" style="width:<?php echo $theme->appWidth; ?>px;height:<?php echo $theme->appHeight; ?>px; position:relative;">

<?php
$row1=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_theme WHERE id=".$id);
$start_lib = $row1->startWithLib; 
?>
<div id="video_div_<?php echo $id;?>"  style="display:<?php if($start_lib == 1) echo 'none'; else echo 'block'?>;width:<?php echo $theme->appWidth; ?>px;height:<?php echo $theme->appHeight; ?>px;background-color:<?php echo "#".$theme->vidBgColor;  ?>">


<div id="kukla_<?php  echo $id?>" >

<input type='hidden' value='0' id="track_list_<?php echo $id;?>" />
<div style="height:90%" id="divulya_<?php echo $id;?>">
<div id="dvvv_<?php echo $id?>" onmousedown="scrolltp2=setInterval('scrollTop2_<?php echo $id;?>()', 30)" onmouseup="clearInterval(scrolltp2)" style="overflow:hidden; text-align:center;width:<?php echo $theme->playlistWidth; ?>px; height:20px"><img  src="<?php echo plugins_url('',__FILE__)?>/images/top.png" style="cursor:pointer;  border:none;" id="button20_<?php  echo $id?>" />
</div>
<div style="height:<?php echo $theme->appHeight-40; ?>px;overflow:hidden;" id="divikya_<?php echo $id;?>">
<?php
//echo '<p onclick="document.getElementById("videoID").src="'.$videos[$i]["url"].'" ">'.$videos[$i]['title'].'</p>';

for($i=0;$i<count($playlist_array)-1;$i++)
{

$playy = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_playlist WHERE id=".$playlist_array[$i]);

$v_ids=explode(',',$playy->videos);
$vi_ids=substr($playy->videos,0,-1);

	if($i!=0)
		echo '<table id="track_list_'.$id.'_'.$i.'"  style="display:none;height:100%;width:100%;border-spacing:0px;border:none;border-collapse: inherit;" >';
	else
		echo '<table id="track_list_'.$id.'_'.$i.'"  style="display:block;height:100%;width:100%;border-spacing:0px;border:none;border-collapse: inherit;" > ';

echo '<tr style="background:transparent ">
<td id="td_ik_'.$id.'" style="text-align:left;border:0px solid grey;width:100%;vertical-align:top;">
<div id="scroll_div2_'.$i.'_'.$id.'" class="playlist_values_'.$id.'" style="position:relative">';
$jj=0;
for($j=0;$j<count($v_ids)-1;$j++)
{
$vdss=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_video WHERE id=".$v_ids[$j]);


	if($vdss->type=="http")
		{
		if($vdss->urlHtml5!=""){	
		$html5Url=$vdss->urlHtml5;
		}
		else $html5Url=$vdss->url;
		$vidsTHUMB=$vdss->thumb;
		if($vdss->urlHDHtml5!=""){
		$html5UrlHD=$vdss->urlHDHtml5;
		}
		else $html5UrlHD=$vdss->urlHD;
			echo '<div id="thumb_'.$jj.'_'.$id.'"  onclick="jQuery(\'#HD_on_'.$id.'\').val(0);document.getElementById(\'videoID_'.$id.'\').src=\''.$html5Url.'\';play_'.$id.'();vid_select_'.$id.'(this);vid_num='.$jj.';jQuery(\'#current_track_'.$id.'\').val('.$jj.');" class="vid_thumb_'.$id.'" style="color:#'.$theme->textColor .';cursor:pointer;width:'.$theme->playlistWidth.'px;text-align:center; "  >';
			if($vdss->thumb)
			echo '<img   src="'.$vidsTHUMB.'" width="90px" style="display:none;  border:none;"  />';
			echo '<p style="font-size:14px;line-height:30px;cursor:pointer;" >'.($jj+1).'-'.$vdss->title.'</p></div>';

			echo '<input type="hidden" id="urlHD_'.$jj.'_'.$id.'" value="'.$html5UrlHD.'" />';
			echo '<input type="hidden" id="vid_type_'.$jj.'_'.$id.'" value="'.$vdss->type.'" />';
			$jj=$jj+1;
		}
}
echo '</div></td>
</tr></table>';



}



?> 


</div>

<div onmousedown="scrollBot2=setInterval('scrollBottom2_<?php echo $id;?>()', 30)" onmouseup="clearInterval(scrollBot2)" style="position:absolute;overflow:hidden; text-align:center;width:<?php echo $theme->playlistWidth; ?>px; height:20px" id="divulushka_<?php echo $id;?>"><img  src="<?php echo plugins_url('',__FILE__)?>/images/bot.png" style="cursor:pointer;  border:none;" id="button21_<?php  echo $id?>" /></div>

</div>
</div>

<video  ontimeupdate="timeUpdate_<?php  echo $id?>()"  ondurationchange="durationChange_<?php  echo $id?>();" id="videoID_<?php  echo $id?>" src="<?php echo $videos[0]->urlHtml5; ?>"   style="width:100%; height:100% !important;margin:0px !important;" >

 
  
<p>Your browser does not support the video tag.</p>
   
</video>


<a href="http://web-dorado.com/" target="_blank" id="dorado_mark_<?php echo $id;?>" style="bottom: 105px;position: relative;">
<img src="<?php echo plugins_url('',__FILE__)?>/images/wd_logo.png" style="width: 140px;height: 73px;"/></a>  

<div class="control_<?php echo $id;?>" id="control_<?php echo $id;?>" style="overflow:hidden;top: -122px;">




<div class="progressBar_<?php echo $id;?>">
   <div class="timeBar_<?php echo $id;?>"></div>
   <div class="bufferBar_<?php echo $id;?>"></div>
</div>



<?php

$ctrls=explode(',',$ctrlsStack);
$y=1;
echo '<table id="control_btns_'.$id.'" style="width: 100%; border:none;border-collapse: inherit; background: transparent; margin-top: -0.5px;"><tr style="background: transparent;">';
for($i=0;$i<count($ctrls);$i++)
{
	$ctrl=explode(':',$ctrls[$i]);
	if($ctrl[1]==1)
		{
			echo '<td style="border:none;background: transparent;">';
			if($ctrl[0]=='playPause')
				{
					if($theme->appWidth > 400){
						echo '<img id="button'.$y.'_'.$id.'"  class="btnPlay" width="16" style="top:6px;position: relative;vertical-align: middle;cursor:pointer;  border:none;background: transparent; height:19px"   src="'.plugins_url('',__FILE__).'/images/play.png" />';
						echo '<img id="button'.($y+1).'_'.$id.'" width="16"  class="btnPause" style="top:6px;position: relative;vertical-align: middle;display:none;cursor:pointer;  border:none;background: transparent;height:18px"  src="'.plugins_url('',__FILE__).'/images/pause.png" />';	
					}
					
					else {
						echo '<img id="button'.$y.'_'.$id.'"  class="btnPlay" style="vertical-align: middle;cursor:pointer;max-width:7px;  border:none;background: transparent;"   src="'.plugins_url('',__FILE__).'/images/play.png" />';
						echo '<img id="button'.($y+1).'_'.$id.'" width="16"  class="btnPause" style="vertical-align: middle;height: 18px !important;display:none;cursor:pointer;max-width:7px;  border:none;background: transparent;"  src="'.plugins_url('',__FILE__).'/images/pause.png" />';	
					}
			$y=$y+2;
				}
			else
				if($ctrl[0]=='+')
					{
						echo '<span id="space" style="position: relative;vertical-align: middle;padding-left:'.(($theme->appWidth*20)/100).'px"></span>';
					}
			else
				if($ctrl[0]=='time')
					{
						
					echo '
						
						  <span style="color:#'.$theme->ctrlsMainColor.'; position:relative; vertical-align: middle; " id="time_'.$id.'">00:00 </span>
						  <span style="color:#'.$theme->ctrlsMainColor.'; position:relative; vertical-align: middle;">/</span> 
						  <span style="color:#'.$theme->ctrlsMainColor.';position:relative; vertical-align: middle;" id="duration_'.$id.'">00:00</span>
						 
				     ';
						
						
						
					}
			else
				if($ctrl[0]=='vol')
				{
					if($theme->appWidth > 400){
				$img_button='<img  style="position: relative;cursor:pointer; border:none;background: transparent;vertical-align: middle;"  id="button'.$y.'_'.$id.'"    src="'.plugins_url('',__FILE__).'/images/vol.png"  />';
					}
					else {
						$img_button='<img  style="vertical-align: middle;cursor:pointer;max-width:7px; border:none;background: transparent;"  id="button'.$y.'_'.$id.'"    src="'.plugins_url('',__FILE__).'/images/vol.png"  />';
						}
				echo '<table  id="volumeTD_'.$id.'" style="border:none;border-collapse: inherit; min-width: 0;background: transparent;" >
						<tr style="background: transparent;">
							<td id="voulume_img_'.$id.'" style="top:5px;border:none;min-width:13px;  background: transparent; width:20px;" >'.$img_button.'
							</td>
							<td id="volumeTD2_'.$id.'" style="width:0px; border:none; position:relative;background: transparent; ">
									<span id="volumebar_player_'.$id.'" class="volumeBar_'.$id.'" style="vertical-align: middle;">
								    <span class="volume_'.$id.'" style="vertical-align: middle;"></span>
									</span>
							 </td>
						</tr>
						</table> ';
				
						$y=$y+1;
				}
			else
				if($ctrl[0]=='shuffle')
				{
					if($theme->appWidth > 400){
				echo '<img  id="button'.$y.'_'.$id.'" class="shuffle_'.$id.'" style="position: relative;vertical-align: middle;cursor:pointer; border:none;background: transparent;"   src="'.plugins_url('',__FILE__).'/images/shuffle.png" />';
				echo '<img  id="button'.($y+1).'_'.$id.'"  class="shuffle_'.$id.'" style="position: relative;vertical-align: middle;display:none;cursor:pointer; border:none;background: transparent;"  src="'.plugins_url('',__FILE__).'/images/shuffleoff.png" />';
					
					}
					
					else {
						echo '<img  id="button'.$y.'_'.$id.'" class="shuffle_'.$id.'" style="vertical-align: middle;cursor:pointer;max-width:7px;  border:none;background: transparent;"   src="'.plugins_url('',__FILE__).'/images/shuffle.png" />';
						echo '<img  id="button'.($y+1).'_'.$id.'"  class="shuffle_'.$id.'" style="vertical-align: middle;display:none;cursor:pointer;max-width:7px; border:none;background: transparent;"  src="'.plugins_url('',__FILE__).'/images/shuffleoff.png" />';
					
						}
			$y=$y+2;
				}
			else	
				if($ctrl[0]=='repeat')
				{
					
				if($theme->appWidth > 400){	
					echo '
					<img  id="button'.$y.'_'.$id.'" class="repeat_'.$id.'" style="position: relative;vertical-align: middle;cursor:pointer; border:none;background: transparent;"   src="'.plugins_url('',__FILE__).'/images/repeat.png" />
					<img  id="button'.($y+1).'_'.$id.'"  class="repeat_'.$id.'" style="position: relative;vertical-align: middle;display:none;cursor:pointer; border:none;background: transparent;"   src="'.plugins_url('',__FILE__).'/images/repeatOff.png" />
					<img  id="button'.($y+2).'_'.$id.'"  class="repeat_'.$id.'" style="osition: relative;vertical-align: middle;display:none;cursor:pointer; border:none;background: transparent;"  src="'.plugins_url('',__FILE__).'/images/repeatOne.png" />
					';
				}
				else{
					echo '
				<img  id="button'.$y.'_'.$id.'" class="repeat_'.$id.'" style="vertical-align: middle;cursor:pointer;max-width:7px; border:none;background: transparent;"   src="'.plugins_url('',__FILE__).'/images/repeat.png" />
				<img  id="button'.($y+1).'_'.$id.'"  class="repeat_'.$id.'" style="vertical-align: middle;display:none;cursor:pointer;max-width:7px; border:none;background: transparent;"   src="'.plugins_url('',__FILE__).'/images/repeatOff.png" />
				<img  id="button'.($y+2).'_'.$id.'"  class="repeat_'.$id.'" style="vertical-align: middle;display:none;cursor:pointer;max-width:7px; border:none;background: transparent;"  src="'.plugins_url('',__FILE__).'/images/repeatOne.png" />
				';					
					}
					
			$y=$y+3;
				}
				else
				{
					if($theme->appWidth > 400){
						echo '<img  style="position: relative;vertical-align: middle;cursor:pointer; border:none;background: transparent;" id="button'.$y.'_'.$id.'" class="'.$ctrl[0].'_'.$id.'"  src="'.plugins_url('',__FILE__).'/images/'.$ctrl[0].'.png" />';
					}
					else{
						echo '<img  style="vertical-align: middle;cursor:pointer;max-width:7px; border:none;background: transparent;" id="button'.$y.'_'.$id.'" class="'.$ctrl[0].'_'.$id.'"  src="'.plugins_url('',__FILE__).'/images/'.$ctrl[0].'.png" />';
						
						}
				$y=$y+1;
				}
			echo '</td>';	
		}
}
echo '</tr></table>';

?>

   </div>
</div>

<div id="album_div_<?php echo $id;?>" style="display:<?php if($start_lib == 0) echo 'none' ?>;background-color:<?php echo "#".$theme->appBgColor;?>;height:100%; overflow:hidden;position:relative;">


<table width="<?php echo $theme->appWidth ?>px " height="<?php echo $theme->appHeight ?>px" style="border:none;border-collapse: inherit;" id="album_table_<?php  echo $id?>">


<tr id="tracklist_up_<?php  echo $id?>" style="display:none; background: transparent;">
<td height="12px" colspan="2" style="text-align:right; border:none;background: transparent;">
<div onmouseover="this.style.background='rgba(<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 0, 2))?>,<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 2, 2))?>,<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 4, 2))?>,0.4)'" onmouseout="this.style.background='none'" id="scroll" style="overflow:hidden;width:50%;height:100%;text-align:center;float:right;cursor:pointer;" onmousedown="scrolltp=setInterval('scrollTop_<?php echo $id;?>()', 30)" onmouseup="clearInterval(scrolltp)">
<img   src="<?php echo plugins_url('',__FILE__)?>/images/top.png" style="cursor:pointer; margin: 0px !important; padding: 0px !important; border:none;background: transparent;" id="button25_<?php echo $id;?>" />
<div>
</td>
</tr>


<tr>
<td style="vertical-align:middle; border:none;background: transparent; ">
<img src="<?php echo plugins_url('',__FILE__)?>/images/prev.png" style="cursor:pointer; margin: 0px !important; padding: 0px !important; background: transparent;border:none;min-width: 16px;" id="button28_<?php  echo $id?>" onclick="prevPage_<?php  echo $id?>();" />
</td>
<td style="border:none;background: transparent;" id="lib_td_<?php echo $id;?>">

<?php
for($l=0;$l<$table_count;$l++)
{
echo '<table class="lib_tbl_'.$id.'" id="lib_table_'.$l.'_'.$id.'" '.$display.'> ';
for($i=0;$i<$libRows;$i++)
{


	echo '<tr style="background: transparent;">';
	for($j=0;$j<$libCols;$j++)
	{
			
		if($p<count($playlist_array)-1)
		{
		$playyy= $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_playlist WHERE id=".$playlist_array[$p]);
		$playTHUMB=$playyy->thumb;
if($playTHUMB!=""){
			$image_nk == '<img src="'.$playTHUMB.'" style="border:none; width:35%;background: transparent;"/>';
			}
			else $image_nk == "";		


echo '<td  class="playlist_td_'.$id.'" id="playlist_'.$p.'_'.$id.'"  onclick="openPlaylist_'.$id.'('.$p.','.$l.')" onmouseover="this.style.color=\'#'.$theme->textHoverColor .'\';this.style.background=\'rgba('.HEXDEC(SUBSTR($theme->itemBgHoverColor, 0, 2)).','.HEXDEC(SUBSTR($theme->itemBgHoverColor, 2, 2)).','.HEXDEC(SUBSTR($theme->itemBgHoverColor, 4, 2)).',0.4)\'" onmouseout="this.style.color=\'#'.$theme->textColor .'\';this.style.background=\' none\'" onclick="" style="color:#'.$theme->textColor .';border:1px solid white;background: transparent;vertical-align:center; text-align:center;width:'.$cellWidth.';height:'.$cellHeight.';cursor:pointer; ">'.$image_nk.'

		<p style="">'.$playyy->title.'</p>

		</td>';
		
		
		$p=$p+1;
		
		
		}
		else
			{
			echo '<td style="border:1px solid white;vertical-align:top;background: transparent; align:center;width:'.$cellWidth.';height:'.$cellHeight.'">
			</td>';
			}
			
		
		
		
		}
		
	echo '</tr>';

}


if($p<count($playlist_array)-1)
		{
		$table_count=$table_count+1;
		$display='style="display:none;width:100%;height:100%;border-collapse: collapse; margin-left: 8px !important;"';
		}

echo '</table>';
}

for($i=0;$i<$p;$i++)
{

$play1= $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_playlist WHERE id=".$playlist_array[$i]);

$v_ids=explode(',',$play1->videos);
$vi_ids=substr($play1->videos,0,-1);

		$playTHUMB=$play1->thumb;
		
		if($playTHUMB!=""){
			$image_nkar == '<img src="'.$playTHUMB.'" width="50%" style="border:none;background: transparent;" /><br /><br />';
			}
			else $image_nkar == "";
	
	echo '<table playlist_id="'.$i.'" id="playlist_table_'.$i.'_'.$id.'"  style="border:none;border-collapse: inherit;display:none;height:100%;width:100%" >

</tr>
<tr style="background: transparent;">
<td style="text-align:center;vertical-align:top;background: transparent;border:none;background: transparent;">';

echo $image_nkar;
echo '<p style="color:#'.$theme->textColor .'">'.$play->title.'</p>';
echo '</td>
<td style="width:50%;border:none; background: transparent;">

<div style="width:100%;text-align:left;border:1px solid white;height:'.($theme->appHeight-55).'px;vertical-align:top;position:relative;overflow:hidden; min-width: 130px;">
<div id="scroll_div_'.$i.'_'.$id.'" style="position:relative;">';

$jj=0;
for($j=0;$j<count($v_ids)-1;$j++)
{
	$vds1=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_video WHERE id=".$v_ids[$j]);
			if($vds1[0]->type=='http')
			{
				echo '<p class="vid_title_'.$id.'" ondblclick="jQuery(\'.show_vid_'.$id.'\').click()" onmouseover="this.style.color=\'#'.$theme->textHoverColor .'\';this.style.background=\'rgba('.HEXDEC(SUBSTR($theme->itemBgHoverColor, 0, 2)).','.HEXDEC(SUBSTR($theme->itemBgHoverColor, 2, 2)).','.HEXDEC(SUBSTR($theme->itemBgHoverColor, 4, 2)).',0.4)\'" onmouseout="this.style.color=\'#'.$theme->textColor .'\';this.style.background=\' none\'" style="color:#'.$theme->textColor .';font-size:20px;line-height:30px;cursor:pointer; margin: 0px;" onclick="jQuery(\'#HD_on_'.$id.'\').val(0);jQuery(\'#track_list_'.$id.'_'.$i.'\').find(\'.vid_thumb_'.$id.'\')['.$jj.'].click();playBTN_'.$id.'();current_playlist_videos_'.$id.'();vid_num='.$jj.';jQuery(\'#current_track_'.$id.'\').val('.$jj.');vid_select2_'.$id.'(this);playlist_select_'.$id.'('.$i.') ">'.($jj+1).' - '.$vds1[0]->title.'</p>';
				$jj=$jj+1;
			}
		
}


echo '</div></div>

</td>
</tr>

</table>';



}
?>

</td>
<td style="vertical-align:bottom; border:none;background: transparent; top: -13px;position: relative;width: 6%;">
<table style='height:<?php echo $theme->appHeight-46 ?>px; border:none;border-collapse: inherit;'>
<tr style="background: transparent;">
<td height='100%' style="border:none;background: transparent; vertical-align: middle;">

<img  src="<?php echo plugins_url('',__FILE__)?>/images/next.png" style="cursor:pointer;border:none;background: transparent;display:inline !important; " id="button27_<?php  echo $id?>" onclick="nextPage_<?php  echo $id?>()" />

</td>
</tr>
<tr style="background: transparent;">
<td style="border:none;background: transparent;">
  <img  src="<?php echo plugins_url('',__FILE__)?>/images/back.png" style="cursor:pointer; display:none; border:none;background: transparent;" id="button29_<?php  echo $id?>" onclick="openLibTable_<?php  echo $id?>()" />
</td>
</tr>
<tr style="background: transparent;">
<td style="border:none;background: transparent;"> 
 <img style="cursor:pointer;border:none;background: transparent; position:relative; top:-5px;"  id="button19_<?php  echo $id?>"  class="show_vid_<?php  echo $id?>"  src="<?php echo plugins_url('',__FILE__)?>/images/lib.png"  />
</td>
</tr>
</table>
 </td>
</tr>


<tr id="tracklist_down_<?php  echo $id?>" style="display:none;background: transparent" >
<td height="12px" colspan="2" style="text-align:right;border:none;background: transparent;">
<div  onmouseover="this.style.background='rgba(<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 0, 2))?>,<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 2, 2))?>,<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 4, 2))?>,0.4)'" onmouseout="this.style.background='none'" id="scroll" style="overflow:hidden;width:50%;height:100%;text-align:center;float:right;cursor:pointer;" onmousedown="scrollBot=setInterval('scrollBottom_<?php echo $id;?>()', 30)" onmouseup="clearInterval(scrollBot)">
<img src="<?php echo plugins_url('',__FILE__)?>/images/bot.png" style="cursor:pointer;border:none;background: transparent;" id="button26_<?php  echo $id?>"  />
</div>

</td>
</tr>

</table>

 </div>
<script type="text/javascript">
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
		window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u+'AlbumId='+b+'&TrackId='+c)+'&t='+encodeURIComponent(t), "Facebook","menubar=1,resizable=1,width=350,height=250");
		break;
	case 'g':
		window.open('http://plus.google.com/share?url='+encodeURIComponent(u+'AlbumId='+b+'&TrackId='+c)+'&t='+encodeURIComponent(t), "Google","menubar=1,resizable=1,width=350,height=250");
		break;		
	case 'tw':
		window.open('http://twitter.com/home/?status='+encodeURIComponent(u+'AlbumId='+b+'&TrackId='+c), "Twitter","menubar=1,resizable=1,width=350,height=250");
		break;
	}
}		
</script>

<div id="embed_Url_div_<?php echo $id;?>" style="display:none;text-align:center;background-color:rgba(0,0,0,0.5); height:160px;width:300px;position:relative;left:<?php echo ($theme->appWidth/2)-150 ?>px;top:-<?php echo ($theme->appHeight/2)+75 ?>px">
<textarea  onclick="jQuery('#embed_Url_<?php  echo $id?>').focus(); jQuery('#embed_Url_<?php  echo $id?>').select();"  id="embed_Url_<?php  echo $id?>" readonly="readonly" style="font-size:11px;width:285px;overflow-y:scroll;resize:none;height:100px;position:relative;top:5px;"></textarea>
<span style="position:relative;top:10px;"><button onclick="jQuery('#embed_Url_div_<?php  echo $id?>').css('display','none')" style="border:0px">Close</button><p style="color:white">Press Ctrl+C to copy the embed code to clipboard</p></span>
</div>


<?php if($theme->ctrlsPos==2){ ?>
<div id="share_buttons_<?php echo $id;?>" style="text-align:center;height:113px;width:30px;background-color:rgba(0,0,0,0.5);position:relative;z-index:20000;top:-140px;display:none;" >
<img onclick="flashShare('fb',document.getElementById('current_playlist_table_<?php echo $id;?>').value,document.getElementById('current_track_<?php echo $id;?>').value)" style="cursor:pointer;  border:none;background: transparent;padding:0px;max-width: auto;"  src="<?php echo plugins_url('',__FILE__)?>/images/facebook.png" /><br>
<img onclick="flashShare('tw',document.getElementById('current_playlist_table_<?php echo $id;?>').value,document.getElementById('current_track_<?php echo $id;?>').value)" style="cursor:pointer; border:none;background: transparent;padding:0px;max-width: auto;" src="<?php echo plugins_url('',__FILE__)?>/images/twitter.png" /><br>
<img onclick="flashShare('g',document.getElementById('current_playlist_table_<?php echo $id;?>').value,document.getElementById('current_track_<?php echo $id;?>').value)" style="cursor:pointer; border:none;background: transparent;padding:0px;max-width: auto;" src="<?php echo plugins_url('',__FILE__)?>/images/googleplus.png" /><br>
<img onclick="jQuery('#embed_Url_div_<?php echo $id;?>').css('display','');embed_url_<?php echo $id;?>(document.getElementById('current_playlist_table_<?php echo $id;?>').value,document.getElementById('current_track_<?php echo $id;?>').value)" style="cursor:pointer; border:none; background: transparent;padding:0px;max-width: auto;" src="<?php echo plugins_url('',__FILE__)?>/images/embed.png" />
</div>
<?php } else {?>
<div id="share_buttons_<?php echo $id;?>" style="text-align:center;height:113px;width:30px;background-color:rgba(0,0,0,0.5);position:relative;z-index:200;top:-320px;display:none;" >
<img onclick="jQuery('#embed_Url_div_<?php echo $id;?>').css('display','');embed_url_<?php echo $id;?>(document.getElementById('current_playlist_table_<?php echo $id;?>').value,document.getElementById('current_track_<?php echo $id;?>').value)" style="cursor:pointer; border:none;background: transparent;padding:0px;max-width: auto;" src="<?php echo plugins_url('',__FILE__)?>/images/embed.png" />
<img onclick="flashShare('g',document.getElementById('current_playlist_table_<?php echo $id;?>').value,document.getElementById('current_track_<?php echo $id;?>').value)" style="cursor:pointer;  border:none;background: transparent;padding:0px;max-width: auto;" src="<?php echo plugins_url('',__FILE__)?>/images/googleplus.png" /><br>
<img onclick="flashShare('tw',document.getElementById('current_playlist_table_<?php echo $id;?>').value,document.getElementById('current_track_<?php echo $id;?>').value)" style="cursor:pointer;  border:none;background: transparent;padding:0px;max-width: auto;" src="<?php echo plugins_url('',__FILE__)?>/images/twitter.png" /><br>
<img onclick="flashShare('fb',document.getElementById('current_playlist_table_<?php echo $id;?>').value,document.getElementById('current_track_<?php echo $id;?>').value)" style="cursor:pointer;  border:none;background: transparent;padding:0px;max-width: auto;"  src="<?php echo plugins_url('',__FILE__)?>/images/facebook.png" /><br>
</div>
<?php } ?>



</div>



<?php 
$sufffle=str_replace ('Shuffle', 'shuffle', $theme->defaultShuffle);

if($sufffle=='shuffleOff')
$shuffle=0;
else
$shuffle=1;

?>
<input type="hidden" id="color_<?php echo $id;?>" value="<?php echo "#".$theme->ctrlsMainColor ?>" />
<input type="hidden" id="support_<?php echo $id;?>" value="1" />
<input type="hidden" id="event_type_<?php echo $id;?>" value="mouseenter" />
<input type="hidden" id="current_track_<?php echo $id;?>" value="0" />
<input type="hidden" id="shuffle_<?php echo $id;?>" value="<?php echo $shuffle ?>" />
<input type="hidden" id="scroll_height_<?php  echo $id?>" value="0" />
<input type="hidden" id="scroll_height2_<?php echo $id;?>" value="0" />
<input type="hidden" value="<?php echo $l ?>" id="lib_table_count_<?php  echo $id?>"/>
<input type="hidden" value="" id="current_lib_table_<?php  echo $id?>"/>
<input type="hidden" value="0" id="current_playlist_table_<?php echo $id;?>"/>
<input type="hidden" value="<?php echo $theme->defaultRepeat ?>" id="repeat_<?php  echo $id?>"/>
<input type="hidden" value="0" id="HD_on_<?php  echo $id?>"/>
<input type="hidden" value="" id="volumeBar_width_<?php  echo $id?>"/>


<script>
var video_<?php echo $id;?> = jQuery('#videoID_<?php  echo $id?>');
var paly_<?php echo $id;?> = jQuery('#global_body_<?php echo $id;?> .btnPlay');
var pause_<?php echo $id;?> = jQuery('#global_body_<?php echo $id;?> .btnPause');
function embed_url_<?php echo $id;?>(a,b)
	{
	jQuery('#embed_Url_<?php  echo $id?>').html('<iframe allowFullScreen allowTransparency="true" frameborder="0" width="<?php echo $theme->appWidth ?>" height="<?php echo $theme->appHeight ?>" src="'+location.href+'&AlbumId='+a+'&TrackId='+b+'&tmpl=component" type="text/html" ></iframe>')
	jQuery('#embed_Url_<?php  echo $id?>').focus(); jQuery('#embed_Url_<?php  echo $id?>').select();	
	}
jQuery('#global_body_<?php echo $id;?> .share_<?php echo $id;?>, #global_body_<?php echo $id;?> #share_buttons_<?php echo $id;?>').on('mouseenter',function(){
left=jQuery('#global_body_<?php echo $id;?> .share_<?php echo $id;?>').position().left
if(parseInt(jQuery('#global_body_<?php echo $id;?> #kukla_<?php  echo $id?>').css('width'))==0) 
jQuery('#global_body_<?php echo $id;?> #share_buttons_<?php echo $id;?>').css('left',left)
else
jQuery('#global_body_<?php echo $id;?> #share_buttons_<?php echo $id;?>').css('left',left+<?php echo $theme->playlistWidth ?>)
jQuery('#global_body_<?php echo $id;?> #share_buttons_<?php echo $id;?>').css('display','')



})
jQuery('#global_body_<?php echo $id;?> .share_<?php echo $id;?>,#global_body_<?php echo $id;?> #share_buttons_<?php echo $id;?>').on('mouseleave',function(){
jQuery('#global_body_<?php echo $id;?> #share_buttons_<?php echo $id;?>').css('display','none')
})
	if(<?php echo $theme->autoPlay ?>==1)
		{
		setTimeout(function(){jQuery('#thumb_0_<?php echo $id?>').click()},500);
		}
	<?php if($sufffle=='shuffleOff') {?>
		if(jQuery('#global_body_<?php echo $id;?> .shuffle_<?php  echo $id?>')[0])
			{
				jQuery('#global_body_<?php echo $id;?> .shuffle_<?php  echo $id?>')[0].style.display="none";
				jQuery('#global_body_<?php echo $id;?> .shuffle_<?php  echo $id?>')[1].style.display="";
			}
		<?php
		}
		else
		{
		?>
	if(jQuery('#global_body_<?php echo $id;?> .shuffle_<?php  echo $id?>')[0])
		{
			jQuery('#global_body_<?php echo $id;?> .shuffle_<?php  echo $id?>')[1].style.display="none";
			jQuery('#global_body_<?php echo $id;?> .shuffle_<?php  echo $id?>')[0].style.display="";
		}
		<?php } ?>
jQuery('#global_body_<?php echo $id;?> .fullScreen_<?php echo $id;?>').on('click',function(){
if(video_<?php echo $id;?>[0].mozRequestFullScreen)
video_<?php echo $id;?>[0].mozRequestFullScreen();
if(video_<?php echo $id;?>[0].webkitEnterFullscreen)
video_<?php echo $id;?>[0].webkitEnterFullscreen()
})
jQuery('#global_body_<?php echo $id;?> .stop').on('click',function(){
video_<?php echo $id;?>[0].currentTime=0;
video_<?php echo $id;?>[0].pause();
paly_<?php echo $id;?>.css('display',"block");
pause_<?php echo $id;?>.css('display',"none");
})
<?php if($theme->defaultRepeat=='repeatOff'){ ?>
if(jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[0])
{
jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[0].style.display="none";
jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[1].style.display="";
jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[2].style.display="none";
}
<?php }?>
<?php if($theme->defaultRepeat=='repeatOne'){ ?>
if(jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[0])
{
jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[0].style.display="none";
jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[1].style.display="none";
jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[2].style.display="";
}
<?php }?>
<?php if($theme->defaultRepeat=='repeatAll'){ ?>
if(jQuery('.repeat_<?php  echo $id?>')[0])
{
jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[0].style.display="";
jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[1].style.display="none";
jQuery('#global_body_<?php echo $id;?> .repeat_<?php  echo $id?>')[2].style.display="none";
}
<?php }?>
jQuery('.repeat_<?php  echo $id?>').on('click',function(){
repeat_<?php  echo $id?>=jQuery('#repeat_<?php  echo $id?>').val();
switch (repeat_<?php  echo $id?>)
{
case 'repeatOff':
jQuery('#repeat_<?php  echo $id?>').val('repeatOne');
jQuery('.repeat_<?php  echo $id?>')[0].style.display="none";
jQuery('.repeat_<?php  echo $id?>')[1].style.display="none";
jQuery('.repeat_<?php  echo $id?>')[2].style.display="";
break;
case 'repeatOne':
jQuery('#repeat_<?php  echo $id?>').val('repeatAll');
jQuery('.repeat_<?php  echo $id?>')[0].style.display="";
jQuery('.repeat_<?php  echo $id?>')[1].style.display="none";
jQuery('.repeat_<?php  echo $id?>')[2].style.display="none";
break;
case 'repeatAll':
jQuery('#repeat_<?php  echo $id?>').val('repeatOff');
jQuery('.repeat_<?php  echo $id?>')[0].style.display="none";
jQuery('.repeat_<?php  echo $id?>')[1].style.display="";
jQuery('.repeat_<?php  echo $id?>')[2].style.display="none";
break;
}
})
jQuery('#global_body_<?php echo $id;?> #voulume_img_<?php echo $id;?>').on('click',function(){
if(jQuery('#global_body_<?php echo $id;?> .volume_<?php echo $id;?>')[0].style.width!='0%')
{
video_<?php echo $id;?>[0].volume=0;
jQuery('#global_body_<?php echo $id;?> #volumeBar_width_<?php  echo $id?>').val(jQuery('#global_body_<?php echo $id;?> .volume_<?php echo $id;?>')[0].style.width)
jQuery('#global_body_<?php echo $id;?> .volume_<?php echo $id;?>').css('width','0%')
}
else
{
video_<?php echo $id;?>[0].volume=parseInt(jQuery('#global_body_<?php echo $id;?> #volumeBar_width_<?php  echo $id?>').val())/100;
jQuery('#global_body_<?php echo $id;?> .volume_<?php echo $id;?>').css('width',jQuery('#global_body_<?php echo $id;?> #volumeBar_width_<?php  echo $id?>').val())
}
})
jQuery('.hd_<?php echo $id;?>').on('click',function(){
current_time_<?php  echo $id?>=video_<?php echo $id;?>[0].currentTime;
HD_on_<?php  echo $id?>=jQuery('#HD_on_<?php  echo $id?>').val();
current_playlist_table_<?php echo $id;?>=jQuery('#current_playlist_table_<?php echo $id;?>').val();
current_track_<?php echo $id;?>=jQuery('#current_track_<?php echo $id;?>').val();



if(jQuery('#track_list_<?php  echo $id?>_'+current_playlist_table_<?php echo $id;?>).find('#urlHD_'+current_track_<?php echo $id?>+'_'+<?php echo $id?>).val() && HD_on_<?php  echo $id?>==0)
{
document.getElementById('videoID_<?php  echo $id?>').src=jQuery('#track_list_<?php  echo $id?>_'+current_playlist_table_<?php  echo $id?>).find('#urlHD_'+current_track_<?php echo $id?>+'_'+<?php echo $id?>).val();
play_<?php  echo $id?>();
setTimeout('video_<?php echo $id;?>[0].currentTime=current_time_<?php echo $id?>',500)
jQuery('#HD_on_<?php  echo $id?>').val(1);
}
if(jQuery('#track_list_<?php  echo $id?>_'+current_playlist_table_<?php  echo $id?>).find('#urlHD_'+current_track_<?php echo $id?>+'_'+<?php echo $id?>).val() && HD_on_<?php echo $id?>==1)
{
jQuery('#track_list_<?php  echo $id?>_'+current_playlist_table_<?php  echo $id?>).find('#thumb_'+current_track_<?php echo $id?>+'_'+<?php echo $id?>).click();
setTimeout('video_<?php echo $id;?>[0].currentTime=current_time_<?php echo $id?>',500)
jQuery('#HD_on_<?php  echo $id?>').val(0);
}
})
function support_<?php echo $id;?>(i,j)
{
if(jQuery('#track_list_<?php  echo $id?>_'+i).find('#vid_type_'+j+'_<?php echo $id?>').val()!='http')
{
jQuery('#not_supported_<?php  echo $id?>').css('display','');
jQuery('#support_<?php echo $id;?>').val(0);
}
else
{
jQuery('#not_supported_<?php  echo $id?>').css('display','none');
jQuery('#support_<?php echo $id;?>').val(1);
}
}
jQuery('.play_<?php echo $id;?>').on('click',function(){video_<?php echo $id;?>[0].play();})
jQuery('.pause_<?php echo $id;?>').on('click',function(){video_<?php echo $id;?>[0].pause();})
function vid_select_<?php echo $id?>(x)
{
jQuery("div.vid_thumb_<?php echo $id?>").each(function(){
if(jQuery(this).find("img"))
{
jQuery(this).find("img").hide(20);
		if(jQuery(this).find("img")[0])
		jQuery(this).find("img")[0].style.display="none";
	}	
		jQuery(this).css('background','none');
  }) 
  jQuery("div.vid_thumb_<?php echo $id?>").each(function(){
        jQuery(this).mouseenter(function() {
if(jQuery(this).find("img"))
jQuery(this).find("img").slideDown(100);
jQuery(this).css('background','rgba(<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>)')
  jQuery(this).css('color','#<?php echo $theme->textHoverColor  ?>')  
  })  
    jQuery(this).mouseleave(function() {
	if(jQuery(this).find("img"))
	jQuery(this).find("img").slideUp(300);		
		jQuery(this).css('background','none');
		jQuery(this).css('color','#<?php echo $theme->textColor  ?>')
  });
jQuery(this).css('color','#<?php echo $theme->textColor  ?>')
  })
jQuery(x).unbind('mouseleave mouseenter'); 
if(jQuery(x).find("img"))
jQuery(x).find("img").show(10); 
jQuery(x).css('background','rgba(<?php echo HEXDEC(SUBSTR($theme->itemBgSelectedColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgSelectedColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgSelectedColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>)')
jQuery(x).css('color','#<?php echo $theme->textSelectedColor  ?>')
}
function vid_select2_<?php echo $id?>(x)
{
jQuery("p.vid_title_<?php echo $id?>").each(function(){
		this.onmouseover=function(){this.style.color='#'+'<?php echo $theme->textHoverColor?>' ;this.style.background='rgba(<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 0, 2)) ?>,<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 2, 2))?>,<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 4, 2)) ?>,0.4)'}
		this.onmouseout=function(){this.style.color='<?php echo '#'.$theme->textColor ?>';this.style.background=" none"}
		jQuery(this).css('background','none');
		jQuery(this).css('color','#<?php echo $theme->textColor  ?>');
  })
jQuery(x).css('background','rgba(<?php echo HEXDEC(SUBSTR($theme->itemBgSelectedColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgSelectedColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgSelectedColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>)')
jQuery(x).css('color','#<?php echo $theme->textSelectedColor  ?>')
x.onmouseover=null;  
x.onmouseout=null;
}
function playlist_select_<?php echo $id;?>(x)
{
jQuery("#global_body_<?php echo $id;?> td.playlist_td_<?php echo $id;?>").each(function(){
		jQuery(this).css('background','none');
		jQuery(this).css('color','#<?php echo $theme->textColor  ?>');
		this.onmouseover=function(){this.style.color='#'+'<?php echo $theme->textHoverColor?>' ;this.style.background='rgba(<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 0, 2)) ?>,<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 2, 2))?>,<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 4, 2)) ?>,0.4)'}
		this.onmouseout=function(){this.style.color='<?php echo '#'.$theme->textColor ?>';this.style.background=" none"}		
		})
jQuery('#playlist_'+x+'_<?php  echo $id?>').css('background','rgba(<?php echo HEXDEC(SUBSTR($theme->itemBgSelectedColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgSelectedColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgSelectedColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>)')
jQuery('#playlist_'+x+'_<?php  echo $id?>').css('color','#<?php echo $theme->textSelectedColor  ?>')
jQuery('#playlist_'+x+'_<?php  echo $id?>')[0].onmouseover=null
jQuery('#playlist_'+x+'_<?php  echo $id?>')[0].onmouseout=null
}
jQuery('.shuffle_<?php  echo $id?>').on('click', function() {
if(jQuery('#shuffle_<?php  echo $id?>').val()==0)
{
jQuery('#shuffle_<?php  echo $id?>').val(1);
jQuery('.shuffle_<?php  echo $id?>')[1].style.display="none";
jQuery('.shuffle_<?php  echo $id?>')[0].style.display="";
}
else
{
jQuery('#shuffle_<?php  echo $id?>').val(0);
jQuery('.shuffle_<?php  echo $id?>')[0].style.display="none";
jQuery('.shuffle_<?php  echo $id?>')[1].style.display="";
}
});
jQuery("div.vid_thumb_<?php echo $id?>").each(function(){
        jQuery(this).mouseenter(function() {
if(jQuery(this).find("img"))
jQuery(this).find("img").slideToggle(100);
jQuery(this).css('background','rgba(<?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 0, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 2, 2)) ?>, <?php echo HEXDEC(SUBSTR($theme->itemBgHoverColor, 4, 2)) ?>, <?php echo $theme->framesBgAlpha/100; ?>)')
   jQuery(this).css('color','#<?php echo $theme->textHoverColor  ?>')
  })
    jQuery(this).mouseleave(function() {
		if(jQuery(this).find("img"))
		jQuery(this).find("img").slideToggle(300);
		jQuery(this).css('background','none');
		jQuery(this).css('color','#<?php echo $theme->textColor  ?>')
  });
  })
function timeUpdate_<?php  echo $id?>()
{
if(parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime/60)<10 && parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime % 60<10))
    document.getElementById('time_<?php  echo $id?>').innerHTML = '0'+parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime/60)+':0'+parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime % 60);
if(parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime/60)<10)
    document.getElementById('time_<?php  echo $id?>').innerHTML = '0'+parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime/60)+':'+parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime % 60);
	if(parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime % 60)<10)
    document.getElementById('time_<?php  echo $id?>').innerHTML = '0'+parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime/60)+':0'+parseInt(document.getElementById('videoID_<?php  echo $id?>').currentTime % 60);	
}
function durationChange_<?php  echo $id?>()
{
if(parseInt(document.getElementById('videoID_<?php  echo $id?>').duration/60)<10 && parseInt(document.getElementById('videoID_<?php  echo $id?>').duration % 60<10))
    document.getElementById('duration_<?php  echo $id?>').innerHTML = '0'+parseInt(document.getElementById('videoID_<?php  echo $id?>').duration/60)+':0'+parseInt(document.getElementById('videoID_<?php  echo $id?>').duration % 60);
	if(parseInt(document.getElementById('videoID_<?php  echo $id?>').duration/60)<10)
    document.getElementById('duration_<?php  echo $id?>').innerHTML = '0'+parseInt(document.getElementById('videoID_<?php  echo $id?>').duration/60)+':'+parseInt(document.getElementById('videoID_<?php  echo $id?>').duration % 60);
		if(parseInt(document.getElementById('videoID_<?php  echo $id?>').duration % 60)<10)
    document.getElementById('duration_<?php  echo $id?>').innerHTML = parseInt(document.getElementById('videoID_<?php  echo $id?>').duration/60)+':0'+parseInt(document.getElementById('videoID_<?php  echo $id?>').duration % 60);
	}
function scrollBottom_<?php echo $id;?>(){
current_playlist_table_<?php echo $id;?>=document.getElementById('current_playlist_table_<?php echo $id;?>').value;
if(document.getElementById('scroll_div_'+current_playlist_table_<?php  echo $id?>+'_<?php echo $id?>').offsetHeight+parseInt(document.getElementById("scroll_div_"+current_playlist_table_<?php  echo $id?>+'_<?php echo $id?>').style.top)+55<=document.getElementById('global_body_<?php  echo $id?>').offsetHeight)
return false;
document.getElementById('scroll_height_<?php  echo $id?>').value=parseInt(document.getElementById('scroll_height_<?php  echo $id?>').value)+5
document.getElementById("scroll_div_"+current_playlist_table_<?php echo $id;?>+'_<?php echo $id?>').style.top="-"+document.getElementById('scroll_height_<?php  echo $id?>').value+"px";
};
function scrollTop_<?php echo $id;?>(){
current_playlist_table_<?php  echo $id?>=document.getElementById('current_playlist_table_<?php echo $id;?>').value;
if(document.getElementById('scroll_height_<?php  echo $id?>').value<=0)
return false;
document.getElementById('scroll_height_<?php  echo $id?>').value=parseInt(document.getElementById('scroll_height_<?php  echo $id?>').value)-5
document.getElementById("scroll_div_"+current_playlist_table_<?php  echo $id?>+'_<?php echo $id?>').style.top="-"+document.getElementById('scroll_height_<?php  echo $id?>').value+"px";
};
function scrollBottom2_<?php echo $id;?>(){
current_playlist_table_<?php  echo $id?>=document.getElementById('current_playlist_table_<?php echo $id;?>').value;
if(!current_playlist_table_<?php  echo $id?>)
{
current_playlist_table_<?php  echo $id?>=0;
}
if(document.getElementById('scroll_div2_'+current_playlist_table_<?php  echo $id?>+'_<?php  echo $id?>').offsetHeight+parseInt(document.getElementById("scroll_div2_"+current_playlist_table_<?php  echo $id?>+"_<?php  echo $id?>").style.top)+150<=document.getElementById('global_body_<?php  echo $id?>').offsetHeight)
return false;
document.getElementById('scroll_height2_<?php echo $id;?>').value=parseInt(document.getElementById('scroll_height2_<?php echo $id;?>').value)+5
document.getElementById("scroll_div2_"+current_playlist_table_<?php  echo $id?>+"_<?php  echo $id?>").style.top="-"+document.getElementById('scroll_height2_<?php echo $id;?>').value+"px";
};
function scrollTop2_<?php echo $id;?>(){
current_playlist_table_<?php  echo $id?>=document.getElementById('current_playlist_table_<?php echo $id;?>').value;
if(document.getElementById('scroll_height2_<?php echo $id;?>').value<=0)
return false;
document.getElementById('scroll_height2_<?php echo $id;?>').value=parseInt(document.getElementById('scroll_height2_<?php echo $id;?>').value)-5
document.getElementById("scroll_div2_"+current_playlist_table_<?php  echo $id?>+"_<?php  echo $id?>").style.top="-"+document.getElementById('scroll_height2_<?php echo $id;?>').value+"px";
};
function openPlaylist_<?php  echo $id?>(i,j)
{
document.getElementById('scroll_height_<?php  echo $id?>').value=0;
lib_table_count_<?php  echo $id?>=document.getElementById('lib_table_count_<?php  echo $id?>').value;
for(lib_table=0;lib_table<lib_table_count_<?php  echo $id?>;lib_table++)
{
document.getElementById('lib_table_'+lib_table+'_<?php  echo $id?>').style.display="none";
}
jQuery("#playlist_table_"+i+"_<?php  echo $id?>").fadeIn(700);
document.getElementById('current_lib_table_<?php  echo $id?>').value=j;
document.getElementById('current_playlist_table_<?php echo $id;?>').value=i;
document.getElementById('tracklist_down_<?php  echo $id?>').style.display="" ;
document.getElementById('tracklist_up_<?php  echo $id?>').style.display="";
document.getElementById('button29_<?php  echo $id?>').style.display="block";
document.getElementById('button27_<?php  echo $id?>').onclick=function(){nextPlaylist_<?php echo $id;?>()};
document.getElementById('button28_<?php  echo $id?>').onclick=function(){prevPlaylist_<?php echo $id;?>()};
}
function nextPlaylist_<?php echo $id;?>()
{
document.getElementById('scroll_height_<?php  echo $id?>').value=0;
lib_table_count_<?php  echo $id?>=document.getElementById('lib_table_count_<?php  echo $id?>').value;
for(lib_table=0;lib_table<lib_table_count_<?php  echo $id?>;lib_table++)
{
document.getElementById('lib_table_'+lib_table+'_<?php  echo $id?>').style.display="none";
}
current_lib_table_<?php  echo $id?>=document.getElementById('current_lib_table_<?php  echo $id?>').value;
next_playlist_table_<?php  echo $id?>=parseInt(document.getElementById('current_playlist_table_<?php echo $id;?>').value)+1;
current_playlist_table_<?php  echo $id?>=parseInt(document.getElementById('current_playlist_table_<?php echo $id;?>').value);
if(next_playlist_table_<?php  echo $id?>><?php echo count($playlist_array)-2 ?>)
return false;
jQuery("#playlist_table_"+current_playlist_table_<?php  echo $id?>+"_<?php  echo $id?>").css('display','none');
jQuery("#playlist_table_"+next_playlist_table_<?php  echo $id?>+"_<?php  echo $id?>").fadeIn(700);
document.getElementById('current_playlist_table_<?php echo $id;?>').value=next_playlist_table_<?php  echo $id?>;
document.getElementById('tracklist_down_<?php  echo $id?>').style.display="" ;
document.getElementById('tracklist_up_<?php  echo $id?>').style.display="";
document.getElementById('button29_<?php  echo $id?>').style.display="block";
}
function prevPlaylist_<?php echo $id;?>()
{
document.getElementById('scroll_height_<?php  echo $id?>').value=0;
lib_table_count_<?php  echo $id?>=document.getElementById('lib_table_count_<?php  echo $id?>').value;
for(lib_table=0;lib_table<lib_table_count_<?php  echo $id?>;lib_table++)
{
document.getElementById('lib_table_'+lib_table+'_<?php  echo $id?>').style.display="none";
}
current_lib_table_<?php  echo $id?>=document.getElementById('current_lib_table_<?php  echo $id?>').value;
prev_playlist_table_<?php  echo $id?>=parseInt(document.getElementById('current_playlist_table_<?php echo $id;?>').value)-1;
current_playlist_table_<?php  echo $id?>=parseInt(document.getElementById('current_playlist_table_<?php echo $id;?>').value);
if(prev_playlist_table_<?php  echo $id?><0)
return false;
jQuery("#playlist_table_"+current_playlist_table_<?php  echo $id?>+"_<?php  echo $id?>").css('display','none');
jQuery("#playlist_table_"+prev_playlist_table_<?php  echo $id?>+"_<?php  echo $id?>").fadeIn(700);
document.getElementById('current_playlist_table_<?php echo $id;?>').value=prev_playlist_table_<?php  echo $id?>;
document.getElementById('tracklist_down_<?php  echo $id?>').style.display="" ;
document.getElementById('tracklist_up_<?php  echo $id?>').style.display="";
document.getElementById('button29_<?php  echo $id?>').style.display="block";
}
function openLibTable_<?php  echo $id?>()
{
current_lib_table_<?php  echo $id?>=document.getElementById('current_lib_table_<?php  echo $id?>').value;
document.getElementById('scroll_height_<?php  echo $id?>').value=0;
current_playlist_table_<?php  echo $id?>=document.getElementById('current_playlist_table_<?php echo $id;?>').value;
jQuery("#lib_table_"+current_lib_table_<?php  echo $id?>+"_<?php  echo $id?>").fadeIn(700);
document.getElementById('playlist_table_'+current_playlist_table_<?php  echo $id?>+'_<?php  echo $id?>').style.display="none";
document.getElementById('tracklist_down_<?php  echo $id?>').style.display="none" ;
document.getElementById('tracklist_up_<?php  echo $id?>').style.display="none";
document.getElementById('button29_<?php  echo $id?>').style.display="none";
document.getElementById('button27_<?php  echo $id?>').onclick=function(){nextPage_<?php  echo $id?>()};
document.getElementById('button28_<?php  echo $id?>').onclick=function(){prevPage_<?php  echo $id?>()};
}
var next_page_<?php  echo $id?>=0;
function nextPage_<?php  echo $id?>()
{
if(next_page_<?php  echo $id?>==document.getElementById('lib_table_count_<?php  echo $id?>').value-1)
return false;
next_page_<?php  echo $id?>=next_page_<?php  echo $id?>+1;
for(g=0; g<document.getElementById('lib_table_count_<?php  echo $id?>').value; g++)
{
document.getElementById('lib_table_'+g+'_<?php  echo $id?>').style.display="none";
if(g==next_page_<?php  echo $id?>)
{
jQuery("#lib_table_"+g+"_<?php  echo $id?>").fadeIn(900);
}
}
}
function prevPage_<?php  echo $id?>()
{
if(next_page_<?php  echo $id?>==0)
return false;
next_page_<?php  echo $id?>=next_page_<?php  echo $id?>-1;
for(g=0; g<document.getElementById('lib_table_count_<?php  echo $id?>').value; g++)
{
document.getElementById('lib_table_'+g+'_<?php  echo $id?>').style.display="none";
if(g==next_page_<?php  echo $id?>)
{
jQuery("#lib_table_"+g+"_<?php  echo $id?>").fadeIn(900);
}
}
}
function playBTN_<?php echo $id;?>()
{
current_playlist_table_<?php  echo $id?>=document.getElementById('current_playlist_table_<?php echo $id;?>').value;
track_list_<?php  echo $id?>=document.getElementById('track_list_<?php echo $id;?>').value;
document.getElementById('track_list_<?php echo $id;?>_'+current_playlist_table_<?php  echo $id?>).style.display="block";
if(current_playlist_table_<?php  echo $id?>!=track_list_<?php  echo $id?>)
document.getElementById('track_list_<?php echo $id;?>_'+track_list_<?php  echo $id?>).style.display="none";
document.getElementById('track_list_<?php echo $id;?>').value=current_playlist_table_<?php  echo $id?>;
video_<?php echo $id;?>[0].play();
paly_<?php echo $id;?>.css('display',"none");
pause_<?php echo $id;?>.css('display',"block");
}
function play_<?php echo $id;?>()
{
video_<?php echo $id;?>[0].play();
paly_<?php echo $id;?>.css('display',"none");
pause_<?php echo $id;?>.css('display',"block");
}
jQuery('#global_body_<?php echo $id;?> .btnPlay <?php if($theme->clickOnVid==1) echo ',#videoID_'.$id.'' ?>, #global_body_<?php echo $id;?> .btnPause').on('click', function() {
   if(video_<?php echo $id;?>[0].paused) {
      video_<?php echo $id;?>[0].play();
	 paly_<?php echo $id;?>.css('display',"none");
	  pause_<?php echo $id;?>.css('display',"block");
   }
   else {
      video_<?php echo $id;?>[0].pause();
	  paly_<?php echo $id;?>.css('display',"block");
	  pause_<?php echo $id;?>.css('display',"none");  
   }
   return false;
});
function check_volume_<?php echo $id;?>()
{
percentage_<?php echo $id;?> = video_<?php echo $id;?>[0].volume * 100;
jQuery('#global_body_<?php echo $id;?> .volume_<?php echo $id;?>').css('width', percentage_<?php echo $id;?> +'%');
   document.getElementById("kukla_<?php  echo $id?>").style.width='0px';
   document.getElementById("kukla_<?php  echo $id?>").style.display='none';
}
window.onload= check_volume_<?php echo $id;?>();
video_<?php echo $id;?>.on('loadedmetadata', function() {
   jQuery('.duration_<?php echo $id?>').text(video_<?php echo $id;?>[0].duration);
});
video_<?php echo $id;?>.on('timeupdate', function() {
   var progress_<?php  echo $id?> = jQuery('#global_body_<?php echo $id;?> .progressBar_<?php  echo $id?>');
   var currentPos_<?php  echo $id?> = video_<?php echo $id;?>[0].currentTime; //Get currenttime
   var maxduration_<?php  echo $id?> = video_<?php echo $id;?>[0].duration; //Get video duration  
   var percentage_<?php  echo $id?> = 100 * currentPos_<?php  echo $id?> / maxduration_<?php echo $id;?>; //in %
   var position_<?php  echo $id?> = (<?php echo $theme->appWidth; ?> * percentage_<?php  echo $id?> / 100)-progress_<?php  echo $id?>.offset().left; 
   jQuery('#global_body_<?php echo $id;?> .timeBar_<?php  echo $id?>').css('width', percentage_<?php  echo $id?>+'%'); 
});
video_<?php echo $id;?>.on('ended',function(){
  if(jQuery('#repeat_<?php  echo $id?>').val()=="repeatOne") 
	  {
			video_<?php echo $id;?>[0].currentTime=0;
			video_<?php echo $id;?>[0].play();
			paly_<?php echo $id;?>.css('display',"none");
			pause_<?php echo $id;?>.css('display',"block");  
	  }
  if(jQuery('#repeat_<?php  echo $id?>').val()=="repeatAll") 
	  {
			jQuery('#global_body_<?php echo $id;?> .playNext_<?php  echo $id?>').click();
	  }  
if(jQuery('#repeat_<?php  echo $id?>').val()=="repeatOff") 
	  {
			if(vid_num_<?php  echo $id?>==video_urls_<?php  echo $id?>.length-1)
			{
			video_<?php echo $id;?>[0].currentTime=0;
			video_<?php echo $id;?>[0].pause();
			paly_<?php echo $id;?>.css('display',"block");
			pause_<?php echo $id;?>.css('display',"none");
			}
		  }
<?php if($theme->autoNext==1) { ?>
  if(jQuery('#repeat_<?php  echo $id?>').val()=="repeatOff") 
  if(vid_num_<?php  echo $id?>==video_urls_<?php  echo $id?>.length-1)
			{
			video_<?php echo $id;?>[0].currentTime=0;
			video_<?php echo $id;?>[0].pause();
			paly_<?php echo $id;?>.css('display',"block");
			pause_<?php echo $id;?>.css('display',"none");
			}
	else
		{	
	  jQuery('#global_body_<?php echo $id;?> .playNext_<?php echo $id;?>').click();
	   }
   <?php }?>		  
})

var timeDrag_<?php echo $id;?> = false;   /* Drag status */
jQuery('#global_body_<?php echo $id;?> .progressBar_<?php  echo $id?>').mousedown(function(e) {
   timeDrag_<?php echo $id;?> = true;
   updatebar_<?php  echo $id?>(e.pageX);
});
jQuery('#global_body_<?php echo $id;?> .progressBar_<?php  echo $id?>').select(function(){
})
 jQuery(document).mouseup(function(e) {
   if(timeDrag_<?php echo $id;?>) {
      timeDrag_<?php echo $id;?> = false;
      updatebar_<?php  echo $id?>(e.pageX);
   }
});
jQuery(document).mousemove(function(e) {
   if(timeDrag_<?php echo $id;?>) {
      updatebar_<?php  echo $id?>(e.pageX); 
   }
});
var updatebar_<?php  echo $id?> = function(x) {
   var progress_<?php  echo $id?> = jQuery('#global_body_<?php echo $id;?> .progressBar_<?php  echo $id?>');
   var maxduration_<?php  echo $id?> = video_<?php echo $id;?>[0].duration; //Video duraiton
   var position_<?php  echo $id?> = x - progress_<?php  echo $id?>.offset().left; //Click pos
   var percentage_<?php  echo $id?> = 100 * position_<?php  echo $id?> / progress_<?php  echo $id?>.width();

   if(percentage_<?php  echo $id?> > 100) {
      percentage_<?php  echo $id?> = 100;
   }
   if(percentage_<?php  echo $id?> < 0) {
      percentage_<?php  echo $id?> = 0;
   }
   jQuery('#global_body_<?php echo $id;?> .timeBar_<?php  echo $id?>').css('width', percentage_<?php  echo $id?>+'%');
   jQuery('.spanA').css('left', position_<?php  echo $id?>+'px');
   video_<?php echo $id;?>[0].currentTime = maxduration_<?php  echo $id?> * percentage_<?php  echo $id?> / 100;
};
function startBuffer_<?php echo $id;?>() {
setTimeout(function(){
   var maxduration_<?php echo $id;?> = video_<?php echo $id;?>[0].duration;
   var currentBuffer_<?php echo $id;?> = video_<?php echo $id;?>[0].buffered.end(0);
   var percentage_<?php echo $id;?> = 100 * currentBuffer_<?php echo $id;?> / maxduration_<?php echo $id;?>;
   jQuery('#global_body_<?php echo $id;?> .bufferBar_<?php  echo $id?>').css('width', percentage_<?php echo $id;?> +'%');
   if(currentBuffer_<?php echo $id;?> < maxduration_<?php echo $id;?>) {
      setTimeout(startBuffer_<?php echo $id;?>, 500);
   }
  },800)
};
checkVideoLoad=setInterval(function(){
if(video_<?php echo $id;?>[0].duration)
{
setTimeout(startBuffer_<?php echo $id;?>(), 500);
clearInterval(checkVideoLoad)
}
}, 1000)
var volume_<?php echo $id;?> = jQuery('#global_body_<?php echo $id;?> .volumeBar_<?php echo $id;?>');
jQuery('#global_body_<?php echo $id;?> .muted').click(function() {
   video_<?php echo $id;?>[0].muted = !video_<?php echo $id;?>[0].muted;
   return false;
});
jQuery('#global_body_<?php echo $id;?> .volumeBar_<?php echo $id;?>').on('mousedown', function(e) {
   var position_<?php echo $id;?> = e.pageX - volume_<?php echo $id;?>.offset().left;
   var percentage_<?php  echo $id?> = 100 * position_<?php echo $id;?> / volume_<?php echo $id;?>.width();
   jQuery('#global_body_<?php echo $id;?> .volume_<?php echo $id;?>').css('width', percentage_<?php  echo $id?>+'%');
   video_<?php echo $id;?>[0].volume = percentage_<?php  echo $id?> / 100;
});
var volumeDrag_<?php  echo $id?> = false;   /* Drag status */
jQuery('#global_body_<?php echo $id;?> .volumeBar_<?php echo $id;?>').mousedown(function(e) {
   volumeDrag_<?php  echo $id?> = true;
   updateVolumeBar_<?php  echo $id?>(e.pageX);
});
jQuery(document).mouseup(function(e) {
   if(volumeDrag_<?php  echo $id?>) {
      volumeDrag_<?php  echo $id?> = false;
      updateVolumeBar_<?php  echo $id?>(e.pageX);
   }
});
jQuery(document).mousemove(function(e) {
   if(volumeDrag_<?php  echo $id?>) {
      updateVolumeBar_<?php  echo $id?>(e.pageX);
   }
});
var updateVolumeBar_<?php  echo $id?> = function(x) {
   var progress_<?php  echo $id?> = jQuery('#global_body_<?php echo $id;?> .volumeBar_<?php echo $id;?>');
   var position_<?php echo $id;?> = x - progress_<?php  echo $id?>.offset().left; //Click pos
   var percentage_<?php  echo $id?> = 100 * position_<?php echo $id;?> / progress_<?php  echo $id?>.width();
   if(percentage_<?php  echo $id?> > 100) {
      percentage_<?php  echo $id?> = 100;
   }
   if(percentage_<?php  echo $id?> < 0) {
      percentage_<?php  echo $id?> = 0;
   }
   jQuery('#global_body_<?php echo $id;?> .volume_<?php echo $id;?>').css('width', percentage_<?php  echo $id?>+'%');
   video_<?php echo $id;?>[0].volume =  percentage_<?php  echo $id?> / 100;
};
var yy=1;
controlHideTime_<?php  echo $id?>='';
jQuery("#global_body_<?php  echo $id?>").each(function(){
	jQuery(this).mouseleave(function() {
controlHideTime_<?php  echo $id?>=setInterval(function(){
yy=yy+1;
	if(yy<<?php echo $theme->autohideTime ?>)
		{
			return false
		}
	else
		{
						clearInterval(controlHideTime_<?php  echo $id?>);
						 yy=1;
					jQuery("#event_type_<?php echo $id;?>").val('mouseleave');
					jQuery("#kukla_<?php  echo $id?>").animate({
						width: "0px",
					  },300 );
					  setTimeout(function(){ jQuery("#kukla_<?php  echo $id?>").css('display','none');},300)
					  jQuery("#global_body_<?php echo $id;?> .control_<?php  echo $id?>").animate({
						width: <?php echo $theme->appWidth; ?>+"px",
						marginLeft:'0px'
					  }, 300 );
					  jQuery("#global_body_<?php echo $id;?> #control_btns_<?php  echo $id?>").animate({
					width: <?php echo $theme->appWidth?>+"px",
					}, 300 );/*jQuery("#space").animate({
	paddingLeft:<?php echo (($theme->appWidth*20)/100) ?>+"px"},300)*/  

					jQuery('#global_body_<?php echo $id;?> .control_<?php  echo $id?>').hide("slide", { direction: "<?php if($theme->ctrlsPos==1) echo 'up'; else echo 'down'; ?>" }, 1000);		
		 }
 },1000);
  });
jQuery(this).mouseenter(function() {
if(controlHideTime_<?php  echo $id?>)
{
clearInterval(controlHideTime_<?php  echo $id?>)
yy=1;
}	 
	if(document.getElementById('control_<?php  echo $id?>').style.display=="none")
		{
				jQuery('#global_body_<?php echo $id;?> .control_<?php  echo $id?>').show("slide", { direction: "<?php if($theme->ctrlsPos==1) echo 'up'; else echo 'down'; ?>" }, 450);
		 }
})
  })
var xx=1;
volumeHideTime_<?php echo $id;?>='';
jQuery("#volumeTD_<?php echo $id;?>").each(function(){
jQuery('#volumeTD_<?php echo $id;?>').mouseleave(function() {
volumeHideTime_<?php echo $id;?>=setInterval(function(){
xx=xx+1;
	if(xx<2)
		{
			return false
		}
	else
		{
clearInterval(volumeHideTime_<?php echo $id;?>);
						 xx=1;
jQuery("#global_body_<?php echo $id;?> #space").animate({ 
paddingLeft:<?php echo (($theme->appWidth*20)/100)+'px' ?>,
},1000);
jQuery("#global_body_<?php echo $id;?> #volumebar_player_<?php echo $id;?>").animate({ 
	width:'0px',
},1000);
percentage_<?php  echo $id?> = video_<?php echo $id;?>[0].volume * 100;
jQuery('#global_body_<?php echo $id;?> .volume_<?php echo $id;?>').css('width', percentage_<?php  echo $id?>+'%');
}
},1000)
})
jQuery('#volumeTD_<?php echo $id;?>').mouseenter(function() {
if(volumeHideTime_<?php echo $id;?>)
{
clearInterval(volumeHideTime_<?php echo $id;?>)
xx=1;
}
jQuery("#global_body_<?php echo $id;?> #space").animate({ 
paddingLeft:<?php echo (($theme->appWidth*20)/100)-100+'px' ?>,
},500);
jQuery("#global_body_<?php echo $id;?> #volumebar_player_<?php echo $id;?>").animate({ 
<?php if($theme->appWidth > 400){ ?>
width:'100px',
<?php } 
else { ?>
width:'50px',
<?php } ?>
},500);
});
})
jQuery('#global_body_<?php echo $id;?> .playlist_<?php  echo $id?>').on('click', function() {
  if(document.getElementById("kukla_<?php  echo $id?>").style.width=="0px")
 { 
  jQuery("#kukla_<?php  echo $id?>").css('display','')
 jQuery("#kukla_<?php  echo $id?>").animate({
    width: <?php echo $theme->playlistWidth; ?>+"px",
  }, 500 );
  jQuery("#global_body_<?php echo $id;?> .control_<?php  echo $id?>").animate({
    width: <?php echo $theme->appWidth-$theme->playlistWidth; ?>+"px",
    marginLeft:<?php echo $theme->playlistWidth; ?>+'px'
  }, 500 );
  /*jQuery("#space").animate({paddingLeft:<?php echo (($theme->appWidth*20)/100)-$theme->playlistWidth ?>+"px"},500)*/ 
   jQuery("#global_body_<?php echo $id;?> #control_btns_<?php  echo $id?>").animate({
  width: <?php echo $theme->appWidth-$theme->playlistWidth; ?>+"px",  
  }, 500 );
 }  
  else  
  { 
  jQuery("#global_body_<?php echo $id;?> #kukla_<?php  echo $id?>").animate({
    width: "0px",    
  }, 1500 );
     setTimeout(function(){ jQuery("#kukla_<?php  echo $id?>").css('display','none');},1500)
  jQuery("#global_body_<?php echo $id;?> .control_<?php  echo $id?>").animate({
    width: <?php echo $theme->appWidth; ?>+"px",
    marginLeft:'0px'
  }, 1500 );
     jQuery("#global_body_<?php echo $id;?> #control_btns_<?php  echo $id?>").animate({
  width: <?php echo $theme->appWidth?>+"px",
  }, 1500 );
 /*jQuery("#space").animate({paddingLeft:<?php echo (($theme->appWidth*20)/100)?>+'px'},1500)*/
  }
});
current_playlist_table_<?php  echo $id?>=document.getElementById('current_playlist_table_<?php echo $id;?>').value;
video_urls_<?php echo $id;?>=jQuery('#track_list_<?php  echo $id?>_'+current_playlist_table_<?php  echo $id?>).find('.vid_thumb_<?php echo $id?>');
function current_playlist_videos_<?php  echo $id?>(){
current_playlist_table_<?php  echo $id?>=document.getElementById('current_playlist_table_<?php echo $id;?>').value;
video_urls_<?php  echo $id?>=jQuery('#track_list_<?php  echo $id?>_'+current_playlist_table_<?php  echo $id?>).find('.vid_thumb_<?php echo $id?>');
}
var vid_num_<?php  echo $id?>=0;
jQuery('.playPrev_<?php  echo $id?>').on('click', function() {
vid_num_<?php  echo $id?>--;
if(jQuery('#shuffle_<?php  echo $id?>').val()==1)
vid_num=parseInt(Math.random() * (video_urls_<?php  echo $id?>.length+1 - 0) + 0);
if(vid_num_<?php  echo $id?><0)
{
vid_num_<?php  echo $id?>=video_urls_<?php  echo $id?>.length-1;
}
video_urls_<?php  echo $id?>[vid_num_<?php  echo $id?>].click()
});
jQuery('#global_body_<?php echo $id;?> .playNext_<?php echo $id;?>').on('click', function() {
vid_num_<?php  echo $id?>++;
if(jQuery('#shuffle_<?php  echo $id?>').val()==1)
vid_num_<?php  echo $id?>=parseInt(Math.random() * (video_urls_<?php  echo $id?>.length+1 - 0) + 0);
jQuery('#global_body_<?php echo $id;?> .timeBar_<?php  echo $id?>').css('width', '0%');
if(vid_num_<?php  echo $id?>==video_urls_<?php  echo $id?>.length)
{
vid_num_<?php  echo $id?>=0;
}
video_urls_<?php  echo $id?>[vid_num_<?php  echo $id?>].click()
});
jQuery(".lib_<?php  echo $id?>").click(function () {
jQuery('#album_div_<?php  echo $id?>').css('transform','');
jQuery('#global_body_<?php  echo $id?>').css('transform','');
jQuery('#global_body_<?php  echo $id?>').transition({
perspective: '700px',
    rotateY: '180deg',		
	},1000);
setTimeout(function(){
jQuery('#album_div_<?php  echo $id?>').css('-ms-transform','rotateY(180deg)')
jQuery('#album_div_<?php  echo $id?>').css('transform','rotateY(180deg)')
jQuery('#album_div_<?php  echo $id?>').css('-o-transform','rotateY(180deg)')
document.getElementById('album_div_<?php  echo $id?>').style.display='block'
document.getElementById('video_div_<?php  echo $id?>').style.display='none'
},300);
setTimeout(function(){
jQuery('#album_div_<?php  echo $id?>').css('-ms-transform','');
jQuery('#global_body_<?php  echo $id?>').css('-ms-transform','');
jQuery('#album_div_<?php  echo $id?>').css('transform','');
jQuery('#global_body_<?php  echo $id?>').css('transform','');
jQuery('#album_div_<?php  echo $id?>').css('-o-transform','');
jQuery('#global_body_<?php  echo $id?>').css('-o-transform','');
},1100);
})
  jQuery(".show_vid_<?php  echo $id?>").click(function () {
jQuery('#global_body_<?php  echo $id?>').transition({
perspective: '700px',
    rotateY: '180deg',
    	},1000);
setTimeout(function(){
jQuery('#video_div_<?php  echo $id?>').css('-ms-transform','rotateY(180deg)')
jQuery('#video_div_<?php  echo $id?>').css('transform','rotateY(180deg)')
jQuery('#video_div_<?php  echo $id?>').css('-o-transform','rotateY(180deg)')
document.getElementById('album_div_<?php  echo $id?>').style.display='none'
document.getElementById('video_div_<?php  echo $id?>').style.display='block'
},300);		
setTimeout(function(){
jQuery('#video_div_<?php  echo $id?>').css('-ms-transform','');
jQuery('#global_body_<?php  echo $id?>').css('-ms-transform','');
jQuery('#video_div_<?php  echo $id?>').css('transform','');
jQuery('#global_body_<?php  echo $id?>').css('transform',''); 
jQuery('#video_div_<?php  echo $id?>').css('-o-transform','');
jQuery('#global_body_<?php  echo $id?>').css('-o-transform','');
},1100);
})
var canvas_<?php  echo $id?>=[]
var ctx_<?php  echo $id?>=[]
var originalPixels_<?php  echo $id?>=[]
var currentPixels_<?php  echo $id?>=[]
	for(i=1;i<30;i++)
		if(document.getElementById('button'+i+'_<?php  echo $id?>'))
		{
			canvas_<?php  echo $id?>[i] = document.createElement("canvas");
			ctx_<?php  echo $id?>[i] = canvas_<?php  echo $id?>[i].getContext("2d");
			originalPixels_<?php  echo $id?>[i] = null;
			currentPixels_<?php  echo $id?>[i] = null;
		}
function getPixels_<?php  echo $id?>()
		{
			for(i=1;i<30;i++)
				if(document.getElementById('button'+i+'_<?php  echo $id?>'))
				{
					img=document.getElementById('button'+i+'_<?php  echo $id?>');	
					canvas_<?php  echo $id?>[i].width = img.width;
					canvas_<?php  echo $id?>[i].height = img.height;
					ctx_<?php  echo $id?>[i].drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight, 0, 0, img.width, img.height);
					originalPixels_<?php  echo $id?>[i] = ctx_<?php  echo $id?>[i].getImageData(0, 0, img.width, img.height);
					currentPixels_<?php  echo $id?>[i] = ctx_<?php  echo $id?>[i].getImageData(0, 0, img.width, img.height);
					img.onload = null;
				}
		}
		function HexToRGB_<?php  echo $id?>(Hex)
		{
			var Long = parseInt(Hex.replace(/^#/, ""), 16);
			return {
				R: (Long >>> 16) & 0xff,
				G: (Long >>> 8) & 0xff,
				B: Long & 0xff
			};
		}
		function changeColor_<?php  echo $id?>()
		{
			
			for(i=1;i<30;i++)
			if(document.getElementById('button'+i+'_<?php  echo $id?>'))
			{		
			if(!originalPixels_<?php  echo $id?>[i]) return; // Check if image has loaded
			var newColor = HexToRGB_<?php  echo $id?>(document.getElementById("color_<?php echo $id;?>").value);
			for(var I = 0, L = originalPixels_<?php  echo $id?>[i].data.length; I < L; I += 4)
			{
				if(currentPixels_<?php  echo $id?>[i].data[I + 3] > 0)
				{
					currentPixels_<?php  echo $id?>[i].data[I] = originalPixels_<?php  echo $id?>[i].data[I] / 255 * newColor.R;
					currentPixels_<?php  echo $id?>[i].data[I + 1] = originalPixels_<?php  echo $id?>[i].data[I + 1] / 255 * newColor.G;
					currentPixels_<?php  echo $id?>[i].data[I + 2] = originalPixels_<?php  echo $id?>[i].data[I + 2] / 255 * newColor.B;
				}
			}
					ctx_<?php  echo $id?>[i].putImageData(currentPixels_<?php  echo $id?>[i], 0, 0);
					img=document.getElementById('button'+i+'_<?php  echo $id?>');	
					img.src = canvas_<?php  echo $id?>[i].toDataURL("image/png");
				}
		}		
<?php if($theme->spaceOnVid==1) { ?>
var video_focus;
jQuery('#global_body_<?php  echo $id?> ,#videoID_<?php  echo $id?>').each(function(){
jQuery(this).on('click',function() { 
setTimeout("video_focus=1",100) 
})
})
jQuery('body').on('click',function(){video_focus=0})
jQuery(window).keypress(function(event) {
  if ( event.which == 13 ) {
     event.preventDefault();
   }
  if(event.keyCode==32 && video_focus==1)
  {
  vidOnSpace_<?php echo $id;?>()
  return false;
  }
});
<?php }?>
function vidOnSpace_<?php echo $id;?>()
{
if(video_<?php echo $id;?>[0].paused) {
      video_<?php echo $id;?>[0].play();
	 paly_<?php echo $id;?>.css('display',"none");
	  pause_<?php echo $id;?>.css('display',"block");
   }
   else {
      video_<?php echo $id;?>[0].pause();
	  paly_<?php echo $id;?>.css('display',"block");
	  pause_<?php echo $id;?>.css('display',"none");
   }
}
jQuery('#track_list_<?php  echo $id?>_0').find('#thumb_0_<?php echo $id?>').click();
video_<?php echo $id;?>[0].pause();
if(paly_<?php echo $id;?> && pause_<?php echo $id;?>)
{
paly_<?php echo $id;?>.css('display',"block");
pause_<?php echo $id;?>.css('display',"none");
}
<?php if($AlbumId!=''){ ?>
jQuery('#track_list_<?php  echo $id?>_<?php echo $AlbumId ?>').find('#thumb_<?php echo $TrackId ?>_<?php echo $id?>').click();
<?php } ?>
jQuery(window).load(function(){getPixels_<?php  echo $id?>();changeColor_<?php  echo $id?>()})
</script>


</div><br />
</div>
<?php 

$many_players++;

 $content=ob_get_contents();
                ob_end_clean();
				return $content;
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





add_action('admin_menu', 'Spider_Video_Player_options_panel');
function Spider_Video_Player_options_panel(){
  add_menu_page(	'Theme page title', 'Video Player', 'manage_options', 'Spider_Video_Player', 'Spider_Video_Player_player')  ;
  add_submenu_page( 'Spider_Video_Player', 'Player', 'Video Player', 'manage_options', 'Spider_Video_Player', 'Spider_Video_Player_player');
  add_submenu_page( 'Spider_Video_Player', 'Tags', 'Tags', 'manage_options', 'Tags_Spider_Video_Player', 'Tags_Spider_Video_Player');
  add_submenu_page( 'Spider_Video_Player', 'Videos', 'Videos', 'manage_options', 'Spider_Video_Player_Videos', 'Spider_Video_Player_Videos');
  add_submenu_page( 'Spider_Video_Player', 'Playlists', 'Playlists', 'manage_options', 'Spider_Video_Player_Playlists', 'Spider_Video_Player_Playlists');
  $page_theme=add_submenu_page( 'Spider_Video_Player', 'Themes', 'Themes', 'manage_options', 'Spider_Video_Player_Themes', 'Spider_Video_Player_Themes');

  add_submenu_page( 'Spider_Video_Player', 'Uninstall Spider_Video_Player ', 'Uninstall  Video Player', 'manage_options', 'Uninstall_Spider_Video_Player', 'Uninstall_Spider_Video_Player');
	add_action('admin_print_styles-' . $page_theme, 'sp_video_player_admin_styles_scripts');
	
  }
   function sp_video_player_admin_styles_scripts($id)
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
function ShowTinyMCE($id) {
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
	
	global $wpdb;
	$url = $wpdb->get_results("SELECT urlHdHtml5,urlHtml5 FROM ".$wpdb->prefix."Spider_Video_Player_video");
	
	
	
	if(!$url)
	{
	
	$wpdb->query("ALTER TABLE ".$wpdb->prefix."Spider_Video_Player_video  ADD urlHdHtml5 varchar(255) AFTER thumb, ADD urlHtml5 varchar(255) AFTER urlHD;");
	$wpdb->query("ALTER TABLE ".$wpdb->prefix."Spider_Video_Player_player  ADD priority varchar(255) AFTER title;");

	}
	
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
  `urlHtml5` varchar(200) NOT NULL,
  `urlHD` varchar(200) NOT NULL,
  `urlHDHtml5` varchar(200) NOT NULL,
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
  `priority` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;


$table_name=$wpdb->prefix."Spider_Video_Player_theme";
$sql_theme1="INSERT INTO `".$table_name."` VALUES(1, 1, 'Theme 1', 650, 400, 100, 0, 1, 0, 0, 50, 'repeatOff', 'shuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playlist:1,playPrev:1,playPause:1,playNext:1,lib:1,stop:0,time:1,vol:1,+:1,hd:1,repeat:1,shuffle:1,play:0,pause:0,share:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 12, 3, 3, 16, 20, '001326', '001326', '3665A3', 'C0B8F2', '000000', '00A2FF', 'DAE858', '0C8A58', 'DEDEDE', '000000', 'FFFFFF', 50, 79, 50, 1)";
$sql_theme2="INSERT INTO `".$table_name."` VALUES(2, 0, 'Theme 2', 650, 400, 60, 0, 0, 0, 0, 50, 'repeatOff', 'shuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPrev:1,playPause:1,playNext:1,stop:0,playlist:1,lib:1,play:0,vol:1,+:1,time:1,hd:1,repeat:1,shuffle:1,pause:0,share:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 0, 1, 6, 3, 3, 6, 8, 'FFBB00', '001326', 'FFA200', '030000', '595959', 'FF0000', 'E8E84D', 'FF5500', 'EBEBEB', '000000', 'FFFFFF', 82, 79, 0, 1)";
$sql_theme3="INSERT INTO `".$table_name."` VALUES(3, 0, 'Theme 3', 650, 400, 100, 0, 0, 0, 0, 50, 'repeatOff', 'shuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPause:1,play:0,playlist:1,lib:1,playPrev:1,playNext:1,stop:0,vol:1,+:1,time:1,hd:1,repeat:1,shuffle:0,pause:0,share:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 0, 12, 3, 3, 16, 20, 'FF0000', '070801', 'D10000', 'FFFFFF', '00A2FF', '00A2FF', 'F0FF61', '00A2FF', 'DEDEDE', '000000', 'FFFFFF', 65, 99, 0, 1)";
$sql_theme4="INSERT INTO `".$table_name."` VALUES(4, 0, 'Theme 4', 650, 400, 60, 0, 0, 0, 0, 50, 'repeatOff', 'shuffleOff', 5, 60, 2, 1, 1, 1, 1, 2, 'playPause:1,playlist:1,lib:1,vol:1,playPrev:0,playNext:0,stop:0,+:1,hd:1,repeat:1,shuffle:0,play:0,pause:0,share:1,time:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 6, 4, 4, 6, 8, '239DC2', '000000', '2E6DFF', 'F5DA51', 'FFA64D', 'BFBA73', 'FF8800', 'FFF700', 'FFFFFF', 'FFFFFF', '000000', 71, 82, 0, 1)";
$sql_theme5="INSERT INTO `".$table_name."` VALUES(5, 0, 'Theme 5', 650, 400, 100, 1, 0, 0, 0, 50, 'repeatOff', 'shuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPrev:0,playPause:1,playlist:1,lib:1,playNext:0,stop:0,time:1,vol:1,+:1,hd:1,repeat:1,shuffle:1,play:0,pause:0,share:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 14, 4, 4, 14, 16, '878787', '001326', 'FFFFFF', '000000', '525252', '14B1FF', 'CCCCCC', '14B1FF', '030303', '000000', 'FFFFFF', 100, 75, 0, 1)";
$sql_theme6="INSERT INTO `".$table_name."` VALUES(6, 0, 'Theme 6', 650, 400, 100, 0, 0, 0, 0, 50, 'repeatOff', 'shuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPause:1,playlist:1,lib:1,vol:1,playPrev:0,playNext:0,stop:0,+:1,repeat:0,shuffle:0,play:0,pause:0,hd:1,share:1,time:1,fullScreen:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 14, 3, 3, 16, 16, '080808', '000000', '1C1C1C', 'FFFFFF', '40C6FF', '00A2FF', 'E8E8E8', '40C6FF', 'DEDEDE', '2E2E2E', 'FFFFFF', 61, 79, 0, 1)";
$sql_theme7="INSERT INTO `".$table_name."` VALUES(7, 0, 'Theme  7', 650, 400, 100, 0, 0, 0, 0, 50, 'repeatOff', 'shuffleOff', 5, 50, 2, 1, 1, 1, 1, 2, 'playPause:1,playlist:1,lib:1,playPrev:0,playNext:0,stop:0,vol:1,+:1,hd:0,repeat:0,shuffle:0,play:0,pause:0,share:1,fullScreen:1,time:1', 1, 0, '', 1, 0, 0, 50, 1, 1, 1, 12, 3, 3, 16, 16, '212121', '000000', '222424', 'FFCC00', 'FFFFFF', 'ABABAB', 'B8B8B8', 'EEFF00', 'DEDEDE', '000000', '000000', 90, 78, 0, 1)";

$table_name=$wpdb->prefix."Spider_Video_Player_video";

$sql_video_insert_row1="INSERT INTO `".$table_name."` (`id`, `url`,  `urlHtml5`, `urlHD`, `urlHDHtml5`, `thumb`, `title`, `published`, `type`, `fmsUrl`, `params`) VALUES
(1, 'http://www.youtube.com/watch?v=eaE8N6alY0Y', 'http://www.youtube.com/watch?v=eaE8N6alY0Y', '', '', '".plugins_url("images_for_start/red-sunset-casey1.jpg",__FILE__)."', 'Sunset 1', 1, 'youtube', '', '2#===#Nature#***#1#===#2012#***#'),
(2, 'http://www.youtube.com/watch?v=y3eFdvDdXx0', 'http://www.youtube.com/watch?v=y3eFdvDdXx0', '', '', '".plugins_url("images_for_start/sunset10.jpg",__FILE__)."', 'Sunset 2', 1, 'youtube', '', '2#===#Nature#***#1#===#2012#***#');";



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