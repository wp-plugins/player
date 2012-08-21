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
$ctrlsStack	=str_replace("[", "", $_GET['ctrlsStack']);
$ctrlsStack	=str_replace(", :", ", +:", $ctrlsStack);
$new="";
function change_to_str($x)
{
	if($x)
		return 'true';
	return 'false';
}
if($ctrlsStack)
{
	$ctrls = explode(",", $ctrlsStack);
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
	echo '<settings>
	<appWidth>'.$_GET["appWidth"].'</appWidth>
	<appHeight>'.$_GET["appHeight"].'</appHeight>
	<playlistWidth>'.$_GET["playlistWidth"].'</playlistWidth>
	<startWithLib>'.change_to_str($_GET["startWithLib"]).'</startWithLib>
	<autoPlay>'.change_to_str($_GET["autoPlay"]).'</autoPlay>
	<autoNext>'.change_to_str($_GET["autoNext"]).'</autoNext>
	<autoNextAlbum>'.change_to_str($_GET["autoNextAlbum"]).'</autoNextAlbum>
	<defaultVol>'.(($_GET["defaultVol"]+0)/100).'</defaultVol>
	<defaultRepeat>'.$_GET["defaultRepeat"].'</defaultRepeat>
	<defaultShuffle>'.$_GET["defaultShuffle"].'</defaultShuffle>
	<autohideTime>'.$_GET["autohideTime"].'</autohideTime>
	<centerBtnAlpha>'.(($_GET["centerBtnAlpha"]+0)/100).'</centerBtnAlpha>
	<loadinAnimType>'.$_GET["loadinAnimType"].'</loadinAnimType>
	<keepAspectRatio>'.change_to_str($_GET["keepAspectRatio"]).'</keepAspectRatio>
	<clickOnVid>'.change_to_str($_GET["clickOnVid"]).'</clickOnVid>
	<spaceOnVid>'.change_to_str($_GET["spaceOnVid"]).'</spaceOnVid>
	<mouseWheel>'.change_to_str($_GET["mouseWheel"]).'</mouseWheel>
	<ctrlsPos>'.$_GET["ctrlsPos"].'</ctrlsPos>
	<ctrlsStack>'.$new.'</ctrlsStack>
	<ctrlsOverVid>'.change_to_str($_GET["ctrlsOverVid"]).'</ctrlsOverVid>
	<ctrlsAutoHide>'.change_to_str($_GET["ctrlsSlideOut"]).'</ctrlsAutoHide>
	<watermarkUrl>'.$_GET["watermarkUrl"].'</watermarkUrl>
	<watermarkPos>'.$_GET["watermarkPos"].'</watermarkPos>
	<watermarkSize>'.$_GET["watermarkSize"].'</watermarkSize>
	<watermarkSpacing>'.$_GET["watermarkSpacing"].'</watermarkSpacing>
	<watermarkAlpha>'.(($_GET["watermarkAlpha"]+0)/100).'</watermarkAlpha>
	<playlistPos>'.$_GET["playlistPos"].'</playlistPos>
	<playlistOverVid>'.change_to_str($_GET["playlistOverVid"]).'</playlistOverVid>
	<playlistAutoHide>'.change_to_str($_GET["playlistAutoHide"]).'</playlistAutoHide>
	<playlistTextSize>'.$_GET["playlistTextSize"].'</playlistTextSize>
	<libCols>'.$_GET["libCols"].'</libCols>
	<libRows>'.$_GET["libRows"].'</libRows>
	<libListTextSize>'.$_GET["libListTextSize"].'</libListTextSize>
	<libDetailsTextSize>'.$_GET["libDetailsTextSize"].'</libDetailsTextSize>
	<playBtnHint>'. __('play','Player').'</playBtnHint>
	<pauseBtnHint>'. __('pause','Player').'</pauseBtnHint>
	<playPauseBtnHint>'. __('toggle pause','Player').'</playPauseBtnHint>
	<stopBtnHint>'. __('stop','Player').'</stopBtnHint>
	<playPrevBtnHint>'. __('play previous','Player').'</playPrevBtnHint>
	<playNextBtnHint>'. __('play next','Player').'</playNextBtnHint>
	<volBtnHint>'. __('volume','Player').'</volBtnHint>
	<repeatBtnHint>'. __('repeat','Player').'</repeatBtnHint>
	<shuffleBtnHint>'. __('shuffle','Player').'</shuffleBtnHint>
	<hdBtnHint>'. __('HD','Player').'</hdBtnHint>
	<playlistBtnHint>'. __('open/close playlist','Player').'</playlistBtnHint>
	<libOnBtnHint>'. __('open library','Player').'</libOnBtnHint>
	<libOffBtnHint>'. __('close library','Player').'</libOffBtnHint>
	<fullScreenBtnHint>'. __('switch full screen','Player').'</fullScreenBtnHint>
	<backBtnHint>'. __('back to list','Player').'</backBtnHint>
	<replayBtnHint>'. __('Replay','Player').'</replayBtnHint>
	<nextBtnHint>'.__('Next','Player').'</nextBtnHint>
	<appBgColor>'."0x".$_GET["appBgColor"].'</appBgColor>
	<vidBgColor>'."0x".$_GET["vidBgColor"].'</vidBgColor>
	<framesBgColor>'."0x".$_GET["framesBgColor"].'</framesBgColor>
	<framesBgAlpha>'.(($_GET["framesBgAlpha"]+0)/100).'</framesBgAlpha>
	<ctrlsMainColor>'."0x".$_GET["ctrlsMainColor"].'</ctrlsMainColor>
	<ctrlsMainHoverColor>'."0x".$_GET["ctrlsMainHoverColor"].'</ctrlsMainHoverColor>
	<ctrlsMainAlpha>'.(($_GET["ctrlsMainAlpha"]+0)/100).'</ctrlsMainAlpha>
	<slideColor>'."0x".$_GET["slideColor"].'</slideColor>
	<itemBgHoverColor>'."0x".$_GET["itemBgHoverColor"].'</itemBgHoverColor>
	<itemBgSelectedColor>'."0x".$_GET["itemBgSelectedColor"].'</itemBgSelectedColor>
	<itemBgAlpha>'.(($_GET["framesBgAlpha"]+0)/100).'</itemBgAlpha>
	<textColor>'."0x".$_GET["textColor"].'</textColor>
	<textHoverColor>'."0x".$_GET["textHoverColor"].'</textHoverColor>
	<textSelectedColor>'."0x".$_GET["textSelectedColor"].'</textSelectedColor>
	<embed></embed>

	</settings>';
	?>
	
    

    
    
    
    