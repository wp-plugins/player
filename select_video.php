

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
	if(isset($_POST['search_video'])){
		$where=' WHERE title LIKE "%'.$_POST['search_video'].'%"';
		
		}
		
		else
		{
		$$where="";
		}
		
	$query = "SELECT COUNT(*) FROM ".$wpdb->prefix."Spider_Video_Player_video". $where;
	$total = $wpdb->get_var($query);
	$pageNav['total'] =$total;
	$pageNav['limit'] =	 $limit/20+1;
	
	$query = "SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_video".$where." ". $order." "." LIMIT ".$limit.",20";
	$rows = $wpdb->get_results($query);	    
		
	// table ordering
		// get list of Playlists for dropdown filter
	
	///////////////tags
	$query = "SELECT * FROM ".$wpdb->prefix."Spider_Video_Player_tag WHERE published=1 ORDER BY ordering";
	$tags =$wpdb->get_results($query);
	$search_tags=array();
	foreach($tags as $tag)
	{
		if(isset($_POST['param_'.$tag->id]))
		{
		
		$search_tags[$tag->id] = $_POST['param_'.$tag->id];
		$search_tags[$tag->id] = strtolower( $search_tags[$tag->id] );	
		}

	}
	
	$param= array( array ());
	foreach($rows as $row)
	{
		$params=explode('#***#', $row->params);
		$params= array_slice($params,0, count($params)-1);   
		foreach ($params as $param_temp)
		{
			$param_temp							= explode('#===#', $param_temp);
			$param[$row->id][$param_temp[0]]	= strtolower($param_temp[1]);
		}
	}
	$new_rows=array();
	foreach($rows as $row)
	{
		$t=true;
		foreach($search_tags as $key =>$search_tag)
		{
			if($search_tag)
			if(isset($param[$row->id][$key]))
			{
				if(!is_numeric(strpos($param[$row->id][$key], $search_tag)))
					$t=false;
			}
			else
					$t=false;
		}
		
		if($t)
			$new_rows[]=$row;
	}

	//$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
	 
    // display function
	html_select_video($new_rows, $pageNav,$sort,$tags);





















function html_select_video($rows, $pageNav, $sort,$tags)
{
	echo $_POST["order_by"];
	?>
<script type="text/javascript">

	function ordering(name,as_or_desc)
	{
		document.getElementById('asc_or_desc').value=as_or_desc;		
		document.getElementById('order_by').value=name;
		document.getElementById('admin_form').submit();
	}
	
function submitbutton(pressbutton) {

var form = document.admin_form;

if (pressbutton == 'cancel') 

{

submitform( pressbutton );

return;

}

submitform( pressbutton );

}

function tableOrdering( order, dir, task ) {

    var form = document.admin_form;

    form.filter_order_video.value     = order;

    form.filter_order_Dir_video.value = dir;

    submitform( task );

}

function xxx()
{
	var VIDS =[];
	var title =[];
	var type =[];
	var url =[];
	var thumb =[];
	var trackid =[];
	for(i=0; i<<?php echo count($rows) ?>; i++)
		if(document.getElementById("v"+i))
			if(document.getElementById("v"+i).checked)
			{
				VIDS.push(document.getElementById("v"+i).value);
				title.push(document.getElementById("title_"+i).value);
				type.push(document.getElementById("type_"+i).value);
				url.push(document.getElementById("url_"+i).value);
				thumb.push(document.getElementById("thumb_"+i).value);
				trackid.push(document.getElementById("trackId_"+i).value);
			}
	window.parent.jSelectVideoS(VIDS, title, type, url, thumb, trackid);
}
function reset_all()
{
	document.getElementById('search_video').value='';
<?php  if($tags)   foreach($tags as $tag) {?>
	document.getElementById('param_<?php echo $tag->id; ?>').value='';
<?php }?>
	this.form.submit();
}
function checkAll( n, fldName ) {
  if (!fldName) {
     fldName = 'cb';
  }
	var f = document.admin_form;
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

	<form action="<?php echo plugins_url("select_video.php",__FILE__); ?>" method="post" name="admin_form" id="admin_form">
    
		<table>
		<tr>
			<td align="left">
				<?php echo  'Title' ; ?>:
            </td>
            <td>
				<input type="text" name="search_video" id="search_video" value="<?php if(isset($_POST["search_video"])){echo $_POST["search_video"];} ?>" class="text_area" />
            </td>
            <td rowspan="50">
                <button ><?php echo  'Go' ; ?></button>
            </td>
            <td rowspan="50">
				<button onclick="reset_all()"><?php echo  'Reset' ; ?></button>
			</td>
           <td align="right" width="100%">
                <button onclick="xxx();">+ Add VIDEO +</button>           
           </td>

       </tr>
       
       <?php
	   if($tags)
	   foreach($tags as $tag)
	   {?>
       <tr>
		 <td align="left">
		<?php echo $tag->name ; ?>:
         </td>
		 <td align="left">
             <input type="text" name="param_<?php echo $tag->id;?>" id="param_<?php echo $tag->id; ?>" value="<?php if(isset($_POST["param_".$tag->id])){echo $_POST["param_".$tag->id];} ?>" class="text_area" />
         </td>
        </tr> 
		<?php 
        }
	  	?>
      
		</table>    
    
     <?php    print_html_nav($pageNav['total'],$pageNav['limit']); ?>
    <table class="wp-list-table widefat fixed pages" style="width:95% !important"  align="center">
    <thead>
    	<tr>
            <th width="50px"><?php echo '#'; ?></th>
            <th scope="col" name="toggle" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows)?>, 'v')"></th>
<th scope="col"  id="id" class="<?php if($sort["sortid_by"]=="id") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:50px" ><a href="javascript:ordering('id',<?php if($sort["sortid_by"]=="id") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>ID</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="title" class="<?php if($sort["sortid_by"]=="title") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:120px" ><a href="javascript:ordering('title',<?php if($sort["sortid_by"]=="title") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Title</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="type" class="<?php if($sort["sortid_by"]=="type") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:80px" ><a href="javascript:ordering('type',<?php if($sort["sortid_by"]=="type") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Type</span><span class="sorting-indicator"></span></a></th>
  <th scope="col" id="URL" class="<?php if($sort["sortid_by"]=="url") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" ><a href="javascript:ordering('url',<?php if($sort["sortid_by"]=="url") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>URL</span><span class="sorting-indicator"></span></a></th>
  <th scope="col" id="UrlHD" class="<?php if($sort["sortid_by"]=="urlHD") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" ><a href="javascript:ordering('urlHD',<?php if($sort["sortid_by"]=="urlHD") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>UrlHD</span><span class="sorting-indicator"></span></a></th><th scope="col" id="thumb" class="<?php if($sort["sortid_by"]=="thumb") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:120px" ><a href="javascript:ordering('thumb',<?php if($sort["sortid_by"]=="thumb") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Thumb</span><span class="sorting-indicator"></span></a></th>
  <th scope="col" id="TrackId" class="<?php if($sort["sortid_by"]=="trackId") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:80px" ><a href="javascript:ordering('trackId',<?php if($sort["sortid_by"]=="trackId") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>TrackId</span><span class="sorting-indicator"></span></a></th>
  <th scope="col" id="published" class="<?php if($sort["sortid_by"]=="published") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:120px" ><a href="javascript:ordering('published',<?php if($sort["sortid_by"]=="published") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Published</span><span class="sorting-indicator"></span></a></th>
        </tr>
    </thead>
	
    <?php
    $k = 0;
	for($i=0, $n=count($rows); $i < $n ; $i++)
	{
		$row = $rows[$i];
?>
        <tr class="<?php echo "row$k"; ?>">
        	<td class="check-column" align="center"><?php echo $i+1?></td>
        	<th class="check-column">
            <input type="checkbox" name="post[]" class="checkbox" id="v<?php echo $i?>" value="<?php echo $row->id;?>" />
            <input type="hidden" id="title_<?php echo $i?>" value="<?php echo  htmlspecialchars($row->title);?>" />
            <input type="hidden" id="type_<?php echo $i?>" value="<?php echo  $row->type?>" />
            <input type="hidden" id="url_<?php echo $i?>" value="<?php echo  htmlspecialchars($row->url);?>" />
            <input type="hidden" id="thumb_<?php echo $i?>" value="<?php echo  htmlspecialchars($row->thumb);?>" />
            <input type="hidden" id="trackId_<?php echo $i?>" value="<?php echo  $row->trackId?>" />

            </th>
        	<td align="center"><?php echo $row->id?></td>
        	<td><a style="cursor: pointer;" onclick="window.parent.jSelectVideoS(['<?php echo $row->id?>'],['<?php echo htmlspecialchars(addslashes($row->title))?>'],['<?php echo $row->type?>'],['<?php echo htmlspecialchars(addslashes($row->url))?>'],['<?php echo htmlspecialchars(addslashes($row->thumb))?>'],['<?php echo $row->trackId?>'])"><?php echo $row->title?></a></td>            
        	<td><?php echo $row->type ?></td>    
        	<td><?php echo $row->url ?></td>    
        	<td><?php echo $row->urlHD ?></td>
        	<td><img style="max-height:60px; max-width:60px" src="<?php echo $row->thumb ?>"  /></td>            
        	<td><?php echo $row->trackId ?></td>            
        	<td align="center"><?php echo  $row->published?></td>            
        </tr>
        <?php
		$k = 1 - $k;
	}
	?>
    </table>
    <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo $_POST['asc_or_desc'];?>"  />
 <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo $_POST['order_by'];?>"  />
    <input type="hidden" name="option" value="com_Spider_Video_Player">
    <input type="hidden" name="task" value="select_video">    
    <input type="hidden" name="boxchecked" value="0">   
    </form>
    <?php
}

?>