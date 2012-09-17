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
require_once("nav_function/nav_html_func.php");
if(get_bloginfo( 'version' )>3.3)
echo '<link rel="stylesheet" href="http://web-dorado.com/narek/wp/wp-admin/load-styles.php?c=0&amp;dir=ltr&amp;load=admin-bar,wp-admin&amp;ver=7f0753feec257518ac1fec83d5bced6a" type="text/css" media="all">';
else
echo '<link rel="stylesheet" href="http://localhost/wordpress3/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=global,wp-admin&amp;ver=aba7495e395713976b6073d5d07d3b17" type="text/css" media="all">';

 ?>
<link rel="stylesheet" id="thickbox-css" href="<?php echo bloginfo('url')?>/wp-includes/js/thickbox/thickbox.css?ver=20111117" type="text/css" media="all">
<link rel="stylesheet" id="colors-css" href="<?php echo bloginfo('url')?>/wp-admin/css/colors-classic.css?ver=20111206" type="text/css" media="all">


<?php
	////////////////////////////////////////////////////////////////////////
	
	
	
	
	
	
		global $wpdb;
	$sort["default_style"]="manage-column column-autor sortable desc";
	if(isset($_POST['page_number']))
	{
			
			if($_POST['asc_or_desc'])
			{
				$sort["sortid_by"]=$_POST['order_by'];
				if($_POST['asc_or_desc']==1)
				{
					$sort["custom_style"]="manage-column column-title sorted asc";
					$sort["1_or_2"]="2";
					$order="ORDER BY ".$sort["sortid_by"]." ASC";
				}
				else
				{
					$sort["custom_style"]="manage-column column-title sorted desc";
					$sort["1_or_2"]="1";
					$order="ORDER BY ".$sort["sortid_by"]." DESC";
				}
			}
			
	if($_POST['page_number'])
		{
			$limit=($_POST['page_number']-1)*20; 
		}
		else
		{
			$limit=0;
		}
	}
	else
		{
			$limit=0;
		}
	if(isset($_POST['search_events_by_title'])){
		$search_tag=$_POST['search_events_by_title'];
		}
		
		else
		{
		$search_tag="";
		}

	if ( $search_tag ) {
		$whereee= ' WHERE published=1 AND title LIKE "%'.$search_tag.'%"';
	}
	else
	{
		$whereee=' WHERE published=1';
	}
	
	
	
	// get the total number of records
	$query = "SELECT COUNT(*) FROM ".$wpdb->prefix."Spider_Video_Player_playlist ". $whereee;
	$total = $wpdb->get_var($query);
	$pageNav['total'] =$total;
	$pageNav['limit'] =	 $limit/20+1;
	
	$query = "SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_playlist ".$whereee." ". $order." "." LIMIT ".$limit.",20";
	if($sort["sortid_by"] == 'videos')
	{
		if($_POST['asc_or_desc'])
			{
				$sort["sortid_by"]=$_POST['order_by'];
				if($_POST['asc_or_desc']==1)
				{
					$order=" ASC";
				}
				else
				{
					$order=" DESC";
				}
			}
	$query = 'SELECT *, (LENGTH(  `videos` ) - LENGTH( REPLACE(  `videos` ,  ",",  "" ) )) AS video_count FROM '.$wpdb->prefix.'Spider_Video_Player_playlist '. $whereee. ' ORDER BY  `video_count` '.$order." LIMIT ".$limit.",20";
	
	}
	$rows = $wpdb->get_results($query);
	html_select_video($rows, $pageNav,$sort);










function html_select_video($rows, $pageNav, $sort)
{
	?>
<script type="text/javascript">

function submitbutton(pressbutton) {

var form = document.adminForm;

if (pressbutton == 'cancel') 

{

submitform( pressbutton );

return;

}

submitform( pressbutton );

}
function xxx()
{
	var VIDS =[];
	var title =[];
	var thumb =[];
	var number_of_vids =[];
	for(i=0; i<<?php echo count($rows) ?>; i++)
		if(document.getElementById("v"+i))
			if(document.getElementById("v"+i).checked)
			{
				VIDS.push(document.getElementById("v"+i).value);
				title.push(document.getElementById("title_"+i).value);
				thumb.push(document.getElementById("thumb_"+i).value);
				number_of_vids.push(document.getElementById("number_of_vids_"+i).value);
			}
	window.parent.jSelectVideoS(VIDS, title, thumb, number_of_vids);
}
function ordering(name,as_or_desc)
	{
		document.getElementById('asc_or_desc').value=as_or_desc;		
		document.getElementById('order_by').value=name;
		document.getElementById('admin_form').submit();
	}
function checkAll( n, fldName ) {
  if (!fldName) {
     fldName = 'cb';
  }
	var f = document.adminForm;
	var c = f.toggle.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.adminForm.boxchecked.value = n2;
	} else {
		document.adminForm.boxchecked.value = 0;
	}
}
</script>

	<form action="<?php echo plugins_url("select_playlist.php",__FILE__)?>" method="post" id="admin_form" name="adminForm">
    
		<table width="95%">
           <td align="right" width="100%">
            <button onclick="xxx();">+ Add Playlist +</button>           
             </td>

       </tr>
		</table>    
    
        <?php 
        if(isset($_POST['serch_or_not'])) {if($_POST['serch_or_not']=="search"){ $serch_value=$_POST['search_events_by_title']; }else{$serch_value="";}} 
	$serch_fields='<div class="alignleft actions" style="width:180px;">
    	<label for="search_events_by_title" style="font-size:14px">Title: </label>
        <input type="text" name="search_events_by_title" value="'.$serch_value.'" id="search_events_by_title" onchange="clear_serch_texts()">
    </div>
	<div class="alignleft actions">
   		<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
		 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
		 <input type="button" value="Reset" onclick="window.location.href=\''. plugins_url("select_playlist.php",__FILE__).'\'" class="button-secondary action">
    </div>';
	 print_html_nav($pageNav['total'],$pageNav['limit'],$serch_fields);	
	 ?>
    <table class="wp-list-table widefat plugins" >
    <thead>
    	<tr>
            <th width="30"><?php echo '#'; ?></th>
            <th width="20" class="manage-column column-cb check-column">
            <input  type="checkbox" name="toggle" id="toggle" value="" onclick="checkAll(<?php echo count($rows)?>, 'v')">
            </th>
           <th scope="col" id="id" class="<?php if($sort["sortid_by"]=="id") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:110px" ><a href="javascript:ordering('id',<?php if($sort["sortid_by"]=="id") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>ID</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="title" class="<?php if($sort["sortid_by"]=="title") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" ><a href="javascript:ordering('title',<?php if($sort["sortid_by"]=="title") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Title</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="videos" class="<?php if($sort["sortid_by"]=="videos") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:110px" ><a href="javascript:ordering('videos',<?php if($sort["sortid_by"]=="videos") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>The number of Videos</span><span class="sorting-indicator"></span></a></th>
  <th scope="col" id="published" class="<?php if($sort["sortid_by"]=="published") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:80px" ><a href="javascript:ordering('published',<?php if($sort["sortid_by"]=="published") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Published</span><span class="sorting-indicator"></span></a></th>
       </tr>
    </thead>
                
    <?php
    $k = 0;
	for($i=0, $n=count($rows); $i < $n ; $i++)
	{
		$row = &$rows[$i];
		$published 	= $row->published;
		
		$number_of_vids=substr_count($row->videos, ',');
?>
        <tr class="<?php echo "row$k"; ?>">
        	<td align="center"><?php echo $i+1?></td>
        	<td>
            <input type="checkbox" id="v<?php echo $i?>" value="<?php echo $row->id;?>" />
            <input type="hidden" id="title_<?php echo $i?>" value="<?php echo  htmlspecialchars($row->title);?>" />
            <input type="hidden" id="thumb_<?php echo $i?>" value="<?php echo  htmlspecialchars($row->thumb);?>" />
            <input type="hidden" id="number_of_vids_<?php echo $i?>" value="<?php echo  $number_of_vids;?>" />
            </td>
        	<td align="center"><?php echo $row->id?></td>
        	<td><a style="cursor: pointer;" onclick="window.parent.jSelectVideoS(['<?php echo $row->id?>'],['<?php echo htmlspecialchars(addslashes($row->title));?>'],['<?php echo htmlspecialchars(addslashes($row->thumb));?>'],['<?php echo $number_of_vids;?>'])"><?php echo $row->title?></a></td>            
         	<td align="center"><?php echo $number_of_vids?></td>            
        	<td align="center"><?php echo $published?></td>            
        </tr>
        <?php
		$k = 1 - $k;
	}
	?>
    </table>
    <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php echo $_POST['asc_or_desc'] ?>"  />
 	<input type="hidden" name="order_by" id="order_by" value="<?php echo $_POST['order_by'] ?>"  />
    <input type="hidden" name="option" value="com_Spider_Video_Player">
    <input type="hidden" name="task" value="select_playlist">    
    <input type="hidden" name="boxchecked" value="0"> 
    <input type="hidden" name="filter_order_playlist" value="<?php echo $lists['order']; ?>" />
    <input type="hidden" name="filter_order_Dir_playlist" value="<?php echo $lists['order_Dir']; ?>" />       
    </form>
    <?php
}

?>