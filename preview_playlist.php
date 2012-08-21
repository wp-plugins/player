
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
	
	
	$show_trackid=$_GET['show_trackid'];
	echo '


<library>



	<albumFree title="Nature" thumb="'.plugins_url("images_for_start/sunset4.jpg",__FILE__).'" id="1">



<track id="1" type="youtube" url="http://www.youtube.com/watch?v=eaE8N6alY0Y" thumb="'.plugins_url("images_for_start/red-sunset-casey1.jpg",__FILE__).'"  trackId="1"  >Sunset 1</track>



<track id="2" type="youtube" url="http://www.youtube.com/watch?v=y3eFdvDdXx0" thumb="'.plugins_url("images_for_start/sunset10.jpg",__FILE__).'"   trackId="2"  >Sunset 2</track>



	</albumFree>



</library>';
exit;
?>