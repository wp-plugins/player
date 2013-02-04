	<?php			

function html_add_video($lists, $tags){
		?>
<script language="javascript" type="text/javascript">
function  submitform( pressbutton )
{
	document.getElementById("adminForm").action="admin.php?page=Spider_Video_Player_Videos&task="+pressbutton;
	document.getElementById("adminForm").submit();
}
function submitbutton(pressbutton) 
{
	var form = document.getElementById("adminForm");
	if (pressbutton == 'cancel_video') 
	{
		submitform( pressbutton );
		return;
	}
	
	if(form.title.value=="")
	{
		alert('Set Video title');
		return;
	}
	
<?php 
foreach($tags as $tag)
{
	if($tag->published)
		if($tag->required)
			echo '		
	if(document.getElementById("params.'.$tag->id.'").value=="")
	{
		alert("Set '.$tag->name.'");
		return;
	}
		
';
}

?>
	submitform( pressbutton );
}


function removeVideo(id)
{
				document.getElementById(id+"_link").innerHTML='Select Video';
				document.getElementById(id).value='';
}

function change_type(type)
{
	switch(type)
	{
		case 'http':
			document.getElementById('http_post_video').innerHTML="";
			document.getElementById('div_url').style.display="inline";
			document.getElementById('url').value='';
			document.getElementById('url').type='hidden';
			
			document.getElementById('http_post_video_UrlHD').innerHTML="";
			document.getElementById('div_urlHD').style.display="inline";
			document.getElementById('urlHD').type='hidden';
			document.getElementById('urlHD').value='';
			document.getElementById('tr_fmsUrl').setAttribute('style','display:none');
			document.getElementById('tr_urlHD').removeAttribute('style');
		 break;
		 
		 
		case 'youtube':
		
			document.getElementById('div_url').style.display="none";
			document.getElementById('url').type='text';
			document.getElementById('url').value='';
			document.getElementById('url').size='100';
			
			document.getElementById('div_urlHD').style.display="none";
			document.getElementById('tr_urlHD').setAttribute('style','display:none');
			document.getElementById('urlHD').type='text';
			document.getElementById('urlHD').value='';
			document.getElementById('urlHD').size='100';
			
			document.getElementById('tr_fmsUrl').setAttribute('style','display:none');
			document.getElementById('fmsUrl').value='';
		  break;
		  
		case 'rtmp':
			document.getElementById('div_url').style.display="none";
			document.getElementById('url').type='text';
			document.getElementById('url').value='';
			document.getElementById('url').size='100';
			
			document.getElementById('div_urlHD').style.display="none";
			document.getElementById('urlHD').type='text';
			document.getElementById('urlHD').value='';
			document.getElementById('urlHD').size='100';
			document.getElementById('fmsUrl').value='';

			document.getElementById('tr_fmsUrl').removeAttribute('style');
			document.getElementById('tr_urlHD').removeAttribute('style');
			
		  break;
		  
		default:
		  alert('def')
	}	
}

i=0;

function add()
{


var input_tr=document.createElement('tr');
    input_tr.setAttribute("id", "params_tr_"+i); 
	
var input_name_td=document.createElement('td');
var input_value_td=document.createElement('td');
var input_span_td=document.createElement('td');


var input_name=document.createElement('input');
    input_name.setAttribute("type", "text"); 
    input_name.setAttribute("name", "pname_"+i); 
    input_name.setAttribute("id", "pname_"+i); 

var input_value=document.createElement('input');
    input_value.setAttribute("type", "text"); 
    input_value.setAttribute("name", "pvalue_"+i); 
    input_value.setAttribute("id", "pvalue_"+i); 

var span=document.createElement('span');
	span.setAttribute("style", "cursor:pointer; border:1px solid black; margin-left:10px; font-size:10px"); 
	span.setAttribute("id", "span_"+i); 
	span.setAttribute("onclick", "remove_('"+i+"')"); 
		
   	span.innerHTML="&nbsp;X&nbsp;";

input_span_td.appendChild(span);



input_tr.appendChild(input_name_td);
input_tr.appendChild(input_value_td);
input_tr.appendChild(input_span_td);
input_name_td.appendChild(input_name);
input_value_td.appendChild(input_value);
document.getElementById("params_tbody").appendChild(input_tr);
i++;
}

function remove_(x)
{
node=document.getElementById('params_tr_'+x);
parent_=node.parentNode;

parent_.removeChild(node);
}

</script>
<script type="text/javascript">

jQuery(function() {
	var formfield=null;
	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html){
		if (formfield) {
			
			var fileurl = jQuery('img',html).attr('src');
			if(!fileurl)
			{
				
			var exploded_html;
			var exploded_html_askofen;
			exploded_html=html.split('"');
			for(i=0;i<exploded_html.length;i++)
			exploded_html_askofen=exploded_html[i].split("'");
			for(i=0;i<exploded_html.length;i++)
			{
				for(j=0;j<exploded_html_askofen.length;j++)
				{
				if(exploded_html_askofen[j].search("href"))
				{
				fileurl=exploded_html_askofen[i+1];
				break;
				}
				}
			}
			
			}
			else
			{
							window.parent.document.getElementById('imagebox').src=fileurl;
							window.parent.document.getElementById('imagebox').style.display="block";
							window.parent.document.getElementById('thumb').value=fileurl;
			}

			formfield.val(fileurl);
			if(!window.parent.document.getElementById('post_image').value)
			window.parent.document.getElementById('imagebox').style.display="none";
			else
			window.parent.document.getElementById('imagebox').src=window.parent.document.getElementById('post_image').value;
			tb_remove();
		} else {
			window.original_send_to_editor(html);
		}
		formfield=null;
	};
 
	jQuery('.lu_upload_button').click(function() {
 		formfield = jQuery(this).parent().parent().find(".text_input");
 		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		jQuery('#TB_overlay,#TB_closeWindowButton').bind("click",function(){formfield=null;});
		return false;
	});
	jQuery(document).keyup(function(e) {
  		if (e.keyCode == 27) formfield=null;
	});
});

</script>

<style type="text/css">

.admintable td
{
padding:15px;
border-right:1px solid #cccccc;
border-top:1px solid #cccccc;
border-left:1px solid #cccccc;
border-bottom:1px solid #cccccc;
}
</style>

<?php ?>
<table width="95%">
  <tbody>
   <tr>   
<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://webdorado.org/spider-video-player-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br />
This section allows you to upload videos or add videos from the Internet. <a href="http://webdorado.org/spider-video-player-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>   
  <td colspan="7" align="right" style="font-size:16px;">
  		<a href="http://webdorado.org/files/fromSVP.php" target="_blank" style="color:red; text-decoration:none;">
		<img src="<?php echo plugins_url("images/header.png",__FILE__) ?>" border="0" alt="http://webdorado.org/files/fromSVP.php" width="215"><br>
		Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
		</a>
        </td>
        </tr>
  <tr>
  <td width="100%"><h2>Add Video</h2></td>
  <td align="right"><input type="button" onclick="submitbutton('Save')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('Apply')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=Spider_Video_Player_Videos'" value="Cancel" class="button-secondary action"> </td> 
  </tr>
  </tbody></table>
<form action="admin.php?page=Spider_Video_Player_Videos" method="post" name="adminForm" id="adminForm">
<table style="width:95%" class="admintable"  cellspacing="0">
				<tr>
					<td class="key" style="width:200px">
						<label for="title">
							<?php echo 'Title'; ?>:
						</label>
					</td>
					<td >
                                    <input type="text" name="title" id="title" size="80" />
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="type">
							<?php echo 'Type' ; ?>:
						</label>
					</td>
					<td >
                                   <input type="radio" value="http" name="type" checked="checked" onchange="change_type('http')" />http
                                   <input type="radio" value="youtube"  name="type" onchange="change_type('youtube')" />youtube
                                   <input type="radio" value="rtmp" name="type"  onchange="change_type('rtmp')" />rtmp
									
					</td>
				</tr>
                <tr id="tr_fmsUrl" style="display:none" >
                        <td class="key">
                                <label for="fmsUrl">
                                        <?php echo  'fmsUrl'; ?>:
                                </label>
                        </td>
                        <td  id="td_fmsUrl">
                        <input type="text" name="fmsUrl" id="fmsUrl" size="100"/>
                        </td>
                </tr>
                <tr>
                        <td class="key">
                                <label for="File">
                                        <?php echo 'URl' ; ?>:
                                </label>
                        </td>
                        <td id="td_url" >
                        <div id="div_url">
                        <input type="text" value="" name="http_post_video" id="http_post_video" class="text_input" style="width:137px"/><a class="button lu_upload_button" href="#" />Select</a>
                       
                        </div>
                        <input type="hidden" name="url" id="url"/>
                        </td>
                </tr>
                <tr id="tr_urlHD" >
                        <td class="key">
                                <label for="UrlHD">
                                        <?php echo  'UrlHD' ; ?>:
                                </label>
                        </td>
                        <td  id="td_urlHD">
                        <div id="div_urlHD">
                       <input type="text" value="" name="http_post_video_UrlHD" id="http_post_video_UrlHD" class="text_input" style="width:137px"/><a class="button lu_upload_button" href="#" />Select</a>
                        </div>
                        <input type="hidden" name="urlHD" id="urlHD"/>
                        </td>
                </tr>
				<tr>
					<td class="key">
						<label for="Thumb">
							<?php echo 'Thumb'; ?>:
						</label>
					</td>
                	<td>
					<input type="hidden" value="" name="thumb" id="thumb" />
<input type="text" value="" name="post_image" id="post_image" class="text_input" style="width:137px"/><a class="button lu_upload_button" href="#" />Select</a><br />
<a href="javascript:removeImage();">Remove Image</a><br />
             <div style="height:150px;">
                       <img style="display:none" height="150" id="imagebox" src="" />     
             </div>     
<script type="text/javascript">    
function removeImage()
{
				document.getElementById("imagebox").style.display="none";
				document.getElementById("post_image").value="";
				document.getElementById("thumb").value='';
}
</script>              
                  </td>				
             </tr>
<?php 
if($tags)
foreach($tags as $tag)
{
	if($tag->published)
	echo '		<tr>
					<td class="key">
						<label for="title">
							'.$tag->name.':
						</label>
					</td>
					<td >
                                    <input type="text" name="params['.$tag->id.']" id="params.'.$tag->id.'" size="80" />
					</td>
				</tr>
				';
}

?>
				<tr>
					<td class="key">
						<label for="published">
							<?php echo  'Published' ; ?>:
						</label>
					</td>
					<td >
						<?php
                        echo $lists['published'];
						?>
					</td>
				</tr>                
 </table>    
                
    <input type="hidden" name="option" value="com_player" />
    <input type="hidden" name="task" value="" />
</form>
<div id="sbox-content" style="zoom: 1; opacity: 0; "></div>
<?php
}

function html_show_video($rows, $pageNav,$sort,$playlists){
		global $wpdb;
	?>
    <script language="javascript">
	function ordering(name,as_or_desc)
	{
		document.getElementById('asc_or_desc').value=as_or_desc;		
		document.getElementById('order_by').value=name;
		document.getElementById('admin_form').submit();
	}
	function submit_form_id(x)
				 {
					 
					 var val=x.options[x.selectedIndex].value;
					 document.getElementById("id_for_playlist").value=val;
					 document.getElementById("admin_form").submit();
				 }
				 	function doNothing() {  
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if( keyCode == 13 ) {


        if(!e) var e = window.event;

        e.cancelBubble = true;
        e.returnValue = false;

        if (e.stopPropagation) {
                e.stopPropagation();
                e.preventDefault();
        }
}
}
	</script>
    <form method="post" onkeypress="doNothing()" action="admin.php?page=Spider_Video_Player_Videos" id="admin_form" name="admin_form">
	<table cellspacing="10" width="100%">
      <tr>   
<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://webdorado.org/spider-video-player-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br />
This section allows you to upload videos or add videos from the Internet. <a href="http://webdorado.org/spider-video-player-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>   
  <td colspan="7" align="right" style="font-size:16px;">
  		<a href="http://webdorado.org/files/fromSVP.php" target="_blank" style="color:red; text-decoration:none;">
		<img src="<?php echo plugins_url("images/header.png",__FILE__) ?>" border="0" alt="http://webdorado.org/files/fromSVP.php" width="215"><br>
		Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
		</a>
        </td>
        </tr>
    <tr>
    <td style="width:80px">
    <?php $Forms_title='Form Maker'; echo "<h2 style=\"float:left\">".'Videos'. "</h2>"; ?>
    <input type="button" style="float:left; position:relative; top:10px; margin-left:20px" class="button-secondary action" value="Add a Video" name="custom_parametrs" onclick="window.location.href='admin.php?page=Spider_Video_Player_Videos&task=add_video'" />
    </td>

 

    </tr>
    </table>
    
    <div class="tablenav top" style="width:95%">
	<div class="alignleft actions" style="width:150px;">
    	<label for="form_id" style="font-size:14px">Filter by a playlist: </label>
        </div>
        <div class="alignleft actions">
       <select name="form_id" id="form_id" onchange="submit_form_id(this)" style="width:130px">
            <option value="0" <?php $zxc='selected="selected"'; if(isset($_POST["id_for_playlist"])){if($_POST["id_for_playlist"]>0 ){$zxc=""; }} echo $zxc;  ?> > Select a Playlist </option>
            <?php foreach($playlists as $playlist){	?>
                        <option value="<?php echo $playlist->id ?>" <?php if(isset($_POST["id_for_playlist"])) { if($_POST["id_for_playlist"]==$playlist->id){ echo'selected="selected"'; }} ?> ><?php echo $playlist->title ?></option>

                       <?php }?> 
                     
            </select>
    </div>
</div>
    <?php
	if(isset($_POST['serch_or_not'])) {if($_POST['serch_or_not']=="search"){ $serch_value=$_POST['search_events_by_title']; }else{$serch_value="";}} 
	$serch_fields='<div class="alignleft actions" style="width:180px;">
    	<label for="search_events_by_title" style="font-size:14px">Title: </label>
        <input type="text" name="search_events_by_title" value="'.$serch_value.'" id="search_events_by_title" onchange="clear_serch_texts()">
    </div>
	<div class="alignleft actions">
   		<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
		 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
		 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=Spider_Video_Player_Videos\'" class="button-secondary action">
    </div>';
	 print_html_nav($pageNav['total'],$pageNav['limit'],$serch_fields);	
	
	?>
  <table class="wp-list-table widefat fixed pages" style="width:95%">
 <thead>
 <TR>
 <th scope="col"  id="id" class="<?php if($sort["sortid_by"]=="id") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:50px" ><a href="javascript:ordering('id',<?php if($sort["sortid_by"]=="id") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>ID</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="title" class="<?php if($sort["sortid_by"]=="title") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:120px" ><a href="javascript:ordering('title',<?php if($sort["sortid_by"]=="title") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Title</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="type" class="<?php if($sort["sortid_by"]=="type") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="width:80px" ><a href="javascript:ordering('type',<?php if($sort["sortid_by"]=="type") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Type</span><span class="sorting-indicator"></span></a></th>
  <th scope="col" id="URL" class="<?php if($sort["sortid_by"]=="url") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" ><a href="javascript:ordering('url',<?php if($sort["sortid_by"]=="url") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>URL</span><span class="sorting-indicator"></span></a></th>
  <th scope="col" id="UrlHD" class="<?php if($sort["sortid_by"]=="urlHD") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" ><a href="javascript:ordering('urlHD',<?php if($sort["sortid_by"]=="urlHD") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>UrlHD</span><span class="sorting-indicator"></span></a></th><th scope="col" id="thumb" class="<?php if($sort["sortid_by"]=="thumb") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:120px" ><a href="javascript:ordering('thumb',<?php if($sort["sortid_by"]=="thumb") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Thumb</span><span class="sorting-indicator"></span></a></th>
  <th scope="col" id="published" class="<?php if($sort["sortid_by"]=="published") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:120px" ><a href="javascript:ordering('published',<?php if($sort["sortid_by"]=="published") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Published</span><span class="sorting-indicator"></span></a></th>
 <th style="width:80px">Edit</th>
 <th  style="width:80px">Delete</th>
 </TR>
 </thead>
 <tbody>
 <?php for($i=0; $i<count($rows);$i++){ ?>
 <tr>
         <td><?php echo $rows[$i]->id; ?></td>
         <td><a href="admin.php?page=Spider_Video_Player_Videos&task=edit_video&id=<?php echo $rows[$i]->id; ?>"><?php echo $rows[$i]->title; ?></a></td>
         <td><?php echo $rows[$i]->type; ?></td>
         <td><?php echo $rows[$i]->url; ?></td>
         <td><?php echo $rows[$i]->urlHD; ?></td>
         <td><img width="50" src="<?php echo $rows[$i]->thumb; ?>" title="<?php echo $rows[$i]->thumb; ?>"></td>
         <td><a <?php if(!$rows[$i]->published) echo 'style="color:#C00"'; ?> href="admin.php?page=Spider_Video_Player_Videos&task=published&id=<?php echo $rows[$i]->id; ?>"><?php if($rows[$i]->published) echo "Yes"; else echo "No"; ?></a></td>
         <td><a href="admin.php?page=Spider_Video_Player_Videos&task=edit_video&id=<?php echo $rows[$i]->id; ?>">Edit</a></td>
         <td><a href="admin.php?page=Spider_Video_Player_Videos&task=remove_video&id=<?php echo $rows[$i]->id; ?>">Delete</a></td>
               
  </tr> 
 <?php } ?>
 </tbody>
 </table>
 <input type="hidden" name="id_for_playlist" id="id_for_playlist" value="<?php if(isset($_POST['id_for_playlist'])) echo $_POST['id_for_playlist'];?>" />
 <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo $_POST['asc_or_desc'];?>"  />
 <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo $_POST['order_by'];?>"  />

 <?php
?>
    
    
   
 </form>
  
    <?php
}

function html_edit_video($lists, $row,$tags,$id){
		?>
        
<script language="javascript" type="text/javascript">
function submitform( pressbutton ){
	document.getElementById("adminForm").action="admin.php?page=Spider_Video_Player_Videos&task="+pressbutton+"&id="+<?php echo $id; ?>;
	document.getElementById("adminForm").submit();
}
function submitbutton(pressbutton) {
var form = document.adminForm;

if (pressbutton == 'cancel_video') 
{
submitform( pressbutton );
return;
}

	
		
	if(form.title.value=="")
	{
		alert('Set Video title');
		return;
	}
		
<?php 
foreach($tags as $tag)
{
	if($tag->published)
	if($tag->required)
	echo '		
	if(document.getElementById("params.'.$tag->id.'").value=="")
	{
		alert("Set '.$tag->name.'");
		return;
	}
		
';
}

?>
	submitform( pressbutton );
}

function removeVideo(id)
{
				document.getElementById(id+"_link").innerHTML='Select Video';
				document.getElementById(id).value='';
}

function change_type(type)
{
	switch(type)
	{
		case 'http':
			document.getElementById('http_post_video').value="";
			document.getElementById('div_url').style.display="inline";
			document.getElementById('url').value='';
			document.getElementById('url').type='hidden';
			

			document.getElementById('http_post_video_UrlHD').value="";
			document.getElementById('div_urlHD').style.display="inline";
			document.getElementById('urlHD').type='hidden';
			document.getElementById('urlHD').value='';
			document.getElementById('tr_fmsUrl').setAttribute('style','display:none');
			document.getElementById('tr_urlHD').removeAttribute('style');
		 break;
		 
		 
		case 'youtube':
		
			document.getElementById('div_url').style.display="none";
			document.getElementById('url').type='text';
			document.getElementById('url').value='';
			document.getElementById('url').size='100';
			
			document.getElementById('div_urlHD').style.display="none";
			document.getElementById('tr_urlHD').setAttribute('style','display:none');
			document.getElementById('urlHD').type='text';
			document.getElementById('urlHD').value='';
			document.getElementById('urlHD').size='100';
			
			document.getElementById('tr_fmsUrl').setAttribute('style','display:none');
			document.getElementById('fmsUrl').value='';
		  break;
		  
		case 'rtmp':
			document.getElementById('div_url').style.display="none";
			document.getElementById('url').type='text';
			document.getElementById('url').value='';
			document.getElementById('url').size='100';
			
			document.getElementById('div_urlHD').style.display="none";
			document.getElementById('urlHD').type='text';
			document.getElementById('urlHD').value='';
			document.getElementById('urlHD').size='100';
			document.getElementById('fmsUrl').value='';

			document.getElementById('tr_fmsUrl').removeAttribute('style');
			document.getElementById('tr_urlHD').removeAttribute('style');
			
		  break;
		  
		default:
		  alert('def')
	}	
}
<?php 
$pname= array();
$pvalue= array();

$params=explode('#***#',$row->params);
foreach($params as $param)
{
if($param)
	{$temp=explode('#===#',$param);
	
		$pname[]=htmlspecialchars($temp[0]);
		$pvalue[]=htmlspecialchars($temp[1]);
	}
}

?>

i=<?php echo count($pname); ?>;

//-->
</script> 
<script type="text/javascript">

jQuery(function() {
	var formfield=null;
	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function(html){
		if (formfield) {
			
			var fileurl = jQuery('img',html).attr('src');
			if(!fileurl)
			{
				
			var exploded_html;
			var exploded_html_askofen;
			exploded_html=html.split('"');
			for(i=0;i<exploded_html.length;i++)
			exploded_html_askofen=exploded_html[i].split("'");
			for(i=0;i<exploded_html.length;i++)
			{
				for(j=0;j<exploded_html_askofen.length;j++)
				{
				if(exploded_html_askofen[j].search("href"))
				{
				fileurl=exploded_html_askofen[i+1];
				break;
				}
				}
			}
			
			}
			else
			{
							window.parent.document.getElementById('imagebox').src=fileurl;
							window.parent.document.getElementById('imagebox').style.display="block";
			}

			formfield.val(fileurl);
			
			tb_remove();
		} else {
			window.original_send_to_editor(html);
		}
		formfield=null;
	};
 
	jQuery('.lu_upload_button').click(function() {
 		formfield = jQuery(this).parent().parent().find(".text_input");
 		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		jQuery('#TB_overlay,#TB_closeWindowButton').bind("click",function(){formfield=null;});
		return false;
	});
	jQuery(document).keyup(function(e) {
  		if (e.keyCode == 27) formfield=null;
	});
});

</script>   
<style type="text/css">

.admintable td
{
padding:15px;
border-right:1px solid #cccccc;
border-top:1px solid #cccccc;
border-left:1px solid #cccccc;
border-bottom:1px solid #cccccc;
}
</style>
<table width="95%">
  <tbody>
   <tr>   
<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://webdorado.org/spider-video-player-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br />
This section allows you to upload videos or add videos from the Internet. <a href="http://webdorado.org/spider-video-player-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>   
  <td colspan="7" align="right" style="font-size:16px;">
  		<a href="http://webdorado.org/files/fromSVP.php" target="_blank" style="color:red; text-decoration:none;">
		<img src="<?php echo plugins_url("images/header.png",__FILE__) ?>" border="0" alt="http://webdorado.org/files/fromSVP.php" width="215"><br>
		Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
		</a>
        </td>
        </tr>
  <tr>
  <td width="100%"><h2>Video - <?php echo $row->title; ?></h2></td>
  <td align="right"><input type="button" onclick="submitbutton('Save')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('Apply')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=Spider_Video_Player_Videos'" value="Cancel" class="button-secondary action"> </td> 
  </tr>
  </tbody></table>    
<form action="admin.php?page=Spider_Video_Player_Videos" method="post" name="adminForm" id="adminForm">
<table class="admintable" style="width:95%">
				<tr>
					<td class="key" style="width:200px">
						<label for="title">
							<?php echo 'Title'; ?>:
						</label>
					</td>
					<td >
                                    <input type="text" name="title" id="title" size="80" value="<?php echo htmlspecialchars($row->title) ?>" />
					</td>
				</tr>
                
                <tr>
					<td class="key">
						<label for="Type">
							<?php echo 'Type'; ?>:
						</label>
					</td>
					<td >
                                   <input type="radio" value="http" name="type" <?php if($row->type=="http") echo 'checked="checked"';?> onchange="change_type('http')" />http
                                   <input type="radio" value="youtube"  name="type" <?php if($row->type=="youtube") echo 'checked="checked"';?> onchange="change_type('youtube')" />youtube
                                   <input type="radio" value="rtmp" name="type" <?php if($row->type=="rtmp") echo 'checked="checked"';?> onchange="change_type('rtmp')" />rtmp
									
					</td>
				</tr>
                <tr id="tr_fmsUrl" <?php if($row->type!="rtmp") echo 'style="display:none"'; ?>>
                        <td class="key">
                                <label for="fmsUrl">
                                        <?php echo 'fmsUrl'; ?>:
                                </label>
                        </td>
                        <td  id="td_fmsUrl">
                        <input type="text" name="fmsUrl" id="fmsUrl" size="100" <?php if($row->type=="rtmp") echo 'value="'.htmlspecialchars($row->fmsUrl).'"'; ?>/>
                        </td>
                </tr>
                <tr>
                              <td class="key">
                                  <label for="URL">
                                      <?php echo 'URL'; ?>:
                                  </label>
                                
                              </td>
                              <td >
                <div id="div_url" style="display:<?php if($row->type=="http") echo "inline"; else echo "none";?>">
                 <input type="text" value="<?php if($row->url )echo htmlspecialchars($row->url); ?>" name="http_post_video" id="http_post_video" class="text_input" style="width:137px"/><a class="button lu_upload_button" href="#" />Select</a><br />
                </div>       
                <input <?php if($row->type=="http") echo 'type="hidden"'; else echo 'type="text" size="100"';?> name="url" id="url" value="<?php echo htmlspecialchars($row->url) ?>"  />         
                        </td>
                </tr>
                <tr  id="tr_urlHD" <?php if($row->type=="youtube") echo 'style="display:none"'; ?> >
                        <td class="key">
                                <label for="UrlHD">
                                        <?php echo  'UrlHD'; ?>:
                                </label>
                        </td>
                        <td >
                <div id="div_urlHD" style="display:<?php if($row->type=="http") echo "inline"; else echo "none";?>">
                <input type="text" value="<?php if($row->urlHD )echo htmlspecialchars($row->urlHD);  ?>" name="http_post_video_UrlHD" id="http_post_video_UrlHD" class="text_input" style="width:137px"/><a class="button lu_upload_button" href="#" />Select</a><br />
                </div>
            
                <input type="hidden" name="urlHD" id="urlHD"/> 
                        </td>
                </tr>
                <tr>
					<td class="key">
						<label for="Thumb">
							<?php echo 'Thumb'; ?>:
						</label>
					</td>
                	<td>
					<input type="text" value="<?php if($row->thumb )echo htmlspecialchars($row->thumb); ?>" name="post_image" id="post_image" class="text_input" style="width:137px"/><a class="button lu_upload_button" href="#" />Select</a><br>

<a href="javascript:removeImage();">Remove Image</a><br />
<div style=" position:absolute; width:1px; height:1px; top:0px; overflow:hidden">
<textarea id="tempimage" name="tempimage" class="mce_editable"></textarea><br />
</div>
<script type="text/javascript">
function removeImage()
{
				document.getElementById("imagebox").style.display="none";
				document.getElementById("post_image").value="";
}
</script>

                                       <div style="height:150px;">
                       <img style="display:<?php if($row->thumb=='') echo 'none'; else echo 'block' ?>;" height="150" id="imagebox" src="<?php echo htmlspecialchars($row->thumb) ; ?>" />     
                                       </div>                    </td>
<?php 

foreach($tags as $tag)
{
	
	
	if($tag->published)
	if( in_array($tag->id,$pname))
	{
	$key_value = array_search($tag->id,$pname);
	echo '		<tr>
					<td class="key">
						<label for="title">
							'.$tag->name.':
						</label>
					</td>
					<td >
                                    <input type="text" name="params['.$tag->id.']" id="params.'.$tag->id.'" value="'.$pvalue[$key_value].'" size="80" />
					</td>
				</tr>
				';
	}
	else
	{
	echo '		<tr>
					<td class="key">
						<label for="title">
							'.$tag->name.':
						</label>
					</td>
					<td >
                                    <input type="text" name="params['.$tag->id.']" id="params.'.$tag->id.'" value="" size="80" />
					</td>
				</tr>
				';
	}
}

?>
    
				<tr>
					<td class="key">
						<label for="published">
							<?php echo  'Published'; ?>:
						</label>
					</td>
					<td >
						<?php
                        echo $lists['published'];
						?>
					</td>
				</tr>                
 </table>        
<input type="hidden" name="id" value="<?php echo $row->id?>" />        
<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />         
</form>
        <?php		
       
}

