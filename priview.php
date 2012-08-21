<?php

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

 /**
 * @package SpiderFC
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
if(isset($_GET["appWidth"])){
	if($_GET["appWidth"])
	$width=$_GET["appWidth"];
}
else
{
	$width='700';
}
if(isset($_GET["appHeight"])){
	if($_GET["appHeight"])
	$height=$_GET["appHeight"];
}
else
{
	$height='400';
}
	
	
?>
<script type="text/javascript" src="<?php echo plugins_url("js/swfobject.js",__FILE__) ?>"></script>
  <div id="flashcontent"  style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px"></div>


<script>

function get_radio_value(name)
{
	for (var i=0; i < window.parent.document.getElementsByName(name).length; i++)   
	{   
		if (window.parent.document.getElementsByName(name)[i].checked)      
		{      
			var rad_val = window.parent.document.getElementsByName(name)[i].value;      
			return rad_val;      
		}   
	}
}


	appWidth			=parseInt(window.parent.document.getElementById('appWidth').value);
	appHeight			=parseInt(window.parent.document.getElementById('appHeight').value);
	playlistWidth		=window.parent.document.getElementById('playlistWidth').value;
	startWithLib		=get_radio_value('startWithLib');
	show_trackid		=get_radio_value('show_trackid');

	autoPlay			=get_radio_value('autoPlay');
	autoNext			=get_radio_value('autoNext');
	autoNextAlbum		=get_radio_value('autoNextAlbum');
	defaultVol			=window.parent.document.getElementById('defaultVol').value;
	defaultRepeat		=get_radio_value('defaultRepeat');
	defaultShuffle		=get_radio_value('defaultShuffle');
	autohideTime		=window.parent.document.getElementById('autohideTime').value;
	centerBtnAlpha		=window.parent.document.getElementById('centerBtnAlpha').value;
	loadinAnimType		=get_radio_value('loadinAnimType');
	keepAspectRatio		=get_radio_value('keepAspectRatio');
	clickOnVid			=get_radio_value('clickOnVid');
	spaceOnVid			=get_radio_value('spaceOnVid');
	mouseWheel			=get_radio_value('mouseWheel');
	ctrlsPos			=get_radio_value('ctrlsPos');
	ctrlsStack			=window.parent.document.getElementById('ctrlsStack').value;
	ctrlsOverVid		=get_radio_value('ctrlsOverVid');
	ctrlsSlideOut		=get_radio_value('ctrlsSlideOut');
	watermarkUrl		=window.parent.document.getElementById('post_image').value;
	watermarkPos		=get_radio_value('watermarkPos');
	watermarkSize		=window.parent.document.getElementById('watermarkSize').value;
	watermarkSpacing	=window.parent.document.getElementById('watermarkSpacing').value;
	watermarkAlpha		=window.parent.document.getElementById('watermarkAlpha').value;
	playlistPos			=get_radio_value('playlistPos');
	playlistOverVid		=get_radio_value('playlistOverVid');
	playlistAutoHide	=get_radio_value('playlistAutoHide');
	playlistTextSize	=window.parent.document.getElementById('playlistTextSize').value;
	libCols				=window.parent.document.getElementById('libCols').value;
	libRows				=window.parent.document.getElementById('libRows').value;
	libListTextSize		=window.parent.document.getElementById('libListTextSize').value;
	libDetailsTextSize	=window.parent.document.getElementById('libDetailsTextSize').value;
	appBgColor			=window.parent.document.getElementById('appBgColor').value;
	vidBgColor			=window.parent.document.getElementById('vidBgColor').value;
	framesBgColor		=window.parent.document.getElementById('framesBgColor').value;
	ctrlsMainColor		=window.parent.document.getElementById('ctrlsMainColor').value;
	ctrlsMainHoverColor	=window.parent.document.getElementById('ctrlsMainHoverColor').value;
	slideColor			=window.parent.document.getElementById('slideColor').value;
	itemBgHoverColor	=window.parent.document.getElementById('itemBgHoverColor').value;
	itemBgSelectedColor	=window.parent.document.getElementById('itemBgSelectedColor').value;
	textColor			=window.parent.document.getElementById('textColor').value;
	textHoverColor		=window.parent.document.getElementById('textHoverColor').value;
	textSelectedColor	=window.parent.document.getElementById('textSelectedColor').value;
	framesBgAlpha		=window.parent.document.getElementById('framesBgAlpha').value;
	ctrlsMainAlpha		=window.parent.document.getElementById('ctrlsMainAlpha').value;
	
	str='@appWidth='+appWidth
	+'@appHeight='+appHeight
	+'@playlistWidth='+playlistWidth
	+'@startWithLib='+startWithLib
	+'@show_trackid='+show_trackid
	+'@autoPlay='+autoPlay
	+'@autoNext='+appHeight
	+'@autoNextAlbum='+autoNextAlbum
	+'@defaultVol='+defaultVol
	+'@defaultRepeat='+defaultRepeat
	+'@defaultShuffle='+defaultShuffle
	+'@autohideTime='+autohideTime
	+'@centerBtnAlpha='+centerBtnAlpha
	+'@loadinAnimType='+loadinAnimType
	+'@keepAspectRatio='+keepAspectRatio
	+'@clickOnVid='+clickOnVid
	+'@spaceOnVid='+spaceOnVid
	+'@mouseWheel='+mouseWheel
	+'@ctrlsPos='+ctrlsPos
	+'@ctrlsStack=['+ctrlsStack
	+']@ctrlsOverVid='+ctrlsOverVid
	+'@ctrlsSlideOut='+ctrlsSlideOut
	+'@watermarkUrl='+watermarkUrl
	+'@watermarkPos='+watermarkPos
	+'@watermarkSize='+watermarkSize
	+'@watermarkSpacing='+watermarkSpacing
	+'@watermarkAlpha='+watermarkAlpha
	+'@playlistPos='+playlistPos
	+'@playlistOverVid='+playlistOverVid
	+'@playlistAutoHide='+playlistAutoHide
	+'@playlistTextSize='+playlistTextSize
	+'@libCols='+libCols
	+'@libRows='+libRows
	+'@libListTextSize='+libListTextSize
	+'@libDetailsTextSize='+libDetailsTextSize
	+'@appBgColor='+appBgColor
	+'@vidBgColor='+vidBgColor
	+'@framesBgColor='+framesBgColor
	+'@ctrlsMainColor='+ctrlsMainColor
	+'@ctrlsMainHoverColor='+ctrlsMainHoverColor
	+'@slideColor='+slideColor
	+'@itemBgHoverColor='+itemBgHoverColor
	+'@itemBgSelectedColor='+itemBgSelectedColor
	+'@textColor='+textColor
	+'@textHoverColor='+textHoverColor
	+'@textSelectedColor='+textSelectedColor
	+'@framesBgAlpha='+framesBgAlpha
	+'@ctrlsMainAlpha='+ctrlsMainAlpha;
    var so = new SWFObject("<?php echo  plugins_url("videoSpider_Video_Player.swf",__FILE__) ?>?wdrand=<?php echo mt_rand() ?>", "Spider_Video_Player", "100%", "100%", "8", "#000000");   
   so.addParam("FlashVars", "settingsUrl=<?php echo plugins_url("preview_settings.php",__FILE__) ?>?gago=77"+str+"&playlistUrl=<?php echo str_replace("&","@",str_replace("&amp;","@",plugins_url("preview_playlist.php",__FILE__)));?>?option=com_spidervideoplayer@task=preview_playlist@show_trackid="+show_trackid);
   so.addParam("quality", "high");
   so.addParam("menu", "false");
   so.addParam("wmode", "transparent");
   so.addParam("loop", "false");
   so.addParam("allowfullscreen", "true");
   so.write("flashcontent");
	</script>

    