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
$id_theme=$_GET["theme"];

function change_to_str($x)
{
	if($x)
		return 'true';
	return 'false';
}
$params=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_theme WHERE id=".$id_theme);
//$new	=str_replace("#", "0x", $params->textColor'));
$new="";
if($params->ctrlsStack)
{
	$ctrls = explode(",", $params->ctrlsStack);
		foreach($ctrls as $key =>  $x) 
		 {
			$y = explode(":", $x);
			$ctrl	=$y[0];
			$active	=$y[1];
			if($active==1)
			if($new=="")
				$new=$y[0];
			else
				$new=$new.','.$y[0];
		 }
};
$playlist=$_GET["playlist"];
$theme=$_GET["theme"];
	echo '<settings>
	<appWidth>'.$params->appWidth.'</appWidth>
	<appHeight>'.$params->appHeight.'</appHeight>
	<playlistWidth>'.$params->playlistWidth.'</playlistWidth>
	<startWithLib>'.change_to_str($params->startWithLib).'</startWithLib>
	<autoPlay>'.change_to_str($params->autoPlay).'</autoPlay>
	<autoNext>'.change_to_str($params->autoNext).'</autoNext>
	<autoNextAlbum>'.change_to_str($params->autoNextAlbum).'</autoNextAlbum>
	<defaultVol>'.(($params->defaultVol+0)/100).'</defaultVol>
	<defaultRepeat>'.$params->defaultRepeat.'</defaultRepeat>
	<defaultShuffle>'.$params->defaultShuffle.'</defaultShuffle>
	<autohideTime>'.$params->autohideTime.'</autohideTime>
	<centerBtnAlpha>'.(($params->centerBtnAlpha+0)/100).'</centerBtnAlpha>
	<loadinAnimType>'.$params->loadinAnimType.'</loadinAnimType>
	<keepAspectRatio>'.change_to_str($params->keepAspectRatio).'</keepAspectRatio>
	<clickOnVid>'.change_to_str($params->clickOnVid).'</clickOnVid>
	<spaceOnVid>'.change_to_str($params->spaceOnVid).'</spaceOnVid>
	<mouseWheel>'.change_to_str($params->mouseWheel).'</mouseWheel>
	<ctrlsPos>'.$params->ctrlsPos.'</ctrlsPos>
	<ctrlsStack>'.$new.'</ctrlsStack>
	<ctrlsOverVid>'.change_to_str($params->ctrlsOverVid).'</ctrlsOverVid>
	<ctrlsAutoHide>'.change_to_str($params->ctrlsSlideOut).'</ctrlsAutoHide>
	<watermarkUrl>'.$params->watermarkUrl.'</watermarkUrl>
	<watermarkPos>'.$params->watermarkPos.'</watermarkPos>
	<watermarkSize>'.$params->watermarkSize.'</watermarkSize>
	<watermarkSpacing>'.$params->watermarkSpacing.'</watermarkSpacing>
	<watermarkAlpha>'.(($params->watermarkAlpha+0)/100).'</watermarkAlpha>
	<playlistPos>'.$params->playlistPos.'</playlistPos>
	<playlistOverVid>'.change_to_str($params->playlistOverVid).'</playlistOverVid>
	<playlistAutoHide>'.change_to_str($params->playlistAutoHide).'</playlistAutoHide>
	<playlistTextSize>'.$params->playlistTextSize.'</playlistTextSize>
	<libCols>'.$params->libCols.'</libCols>
	<libRows>'.$params->libRows.'</libRows>
	<libListTextSize>'.$params->libListTextSize.'</libListTextSize>
	<libDetailsTextSize>'.$params->libDetailsTextSize.'</libDetailsTextSize>
	<playBtnHint>'.__('play','Player').'</playBtnHint>
	<pauseBtnHint>'.__('pause','Player').'</pauseBtnHint>
	<playPauseBtnHint>'.__('toggle pause','Player').'</playPauseBtnHint>
	<stopBtnHint>'.__('stop','Player').'</stopBtnHint>
	<playPrevBtnHint>'.__('play previous','Player').'</playPrevBtnHint>
	<playNextBtnHint>'.__('play next','Player').'</playNextBtnHint>
	<volBtnHint>'.__('volume','Player').'</volBtnHint>
	<repeatBtnHint>'.__('repeat','Player').'</repeatBtnHint>
	<shuffleBtnHint>'.__('shuffle','Player').'</shuffleBtnHint>
	<hdBtnHint>'.__('HD','Player').'</hdBtnHint>
	<playlistBtnHint>'.__('open/close playlist','Player').'</playlistBtnHint>
	<libOnBtnHint>'.__('open library','Player').'</libOnBtnHint>
	<libOffBtnHint>'.__('close library','Player').'</libOffBtnHint>
	<fullScreenBtnHint>'.__('switch full screen','Player').'</fullScreenBtnHint>
	<backBtnHint>'.__('back to list','Player').'</backBtnHint>
	<replayBtnHint>'.__('Replay','Player').'</replayBtnHint>
	<nextBtnHint>'.__('Next','Player').'</nextBtnHint>
	<appBgColor>'."0x".$params->appBgColor.'</appBgColor>
	<vidBgColor>'."0x".$params->vidBgColor.'</vidBgColor>
	<framesBgColor>'."0x".$params->framesBgColor.'</framesBgColor>
	<framesBgAlpha>'.(($params->framesBgAlpha+0)/100).'</framesBgAlpha>
	<ctrlsMainColor>'."0x".$params->ctrlsMainColor.'</ctrlsMainColor>
	<ctrlsMainHoverColor>'."0x".$params->ctrlsMainHoverColor.'</ctrlsMainHoverColor>
	<ctrlsMainAlpha>'.(($params->ctrlsMainAlpha+0)/100).'</ctrlsMainAlpha>
	<slideColor>'."0x".$params->slideColor.'</slideColor>
	<itemBgHoverColor>'."0x".$params->itemBgHoverColor.'</itemBgHoverColor>
	<itemBgSelectedColor>'."0x".$params->itemBgSelectedColor.'</itemBgSelectedColor>
	<itemBgAlpha>'.(($params->itemBgAlpha+0)/100).'</itemBgAlpha>
	<textColor>'."0x".$params->textColor.'</textColor>
	<textHoverColor>'."0x".$params->textHoverColor.'</textHoverColor>
	<textSelectedColor>'."0x".$params->textSelectedColor.'</textSelectedColor>
	<embed>'.plugins_url("spider_video_player_viewe.php",__FILE__).'?id_player='.$_GET['s_v_player_id'].'</embed>

	</settings>';
?>