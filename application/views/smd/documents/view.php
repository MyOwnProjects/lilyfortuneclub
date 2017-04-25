<ul class="breadcrumb">
	<li>Document</li>
	<li>view</li>
	<li><?php echo $name;?></li>
</ul>
<div style="position:absolute;top:46px;bottom:0;left:0;right:0;overflow:hidden;text-align:center">
<?php
if(isset($error) && !empty($error)){
	echo '<div class="alert alert-danger">'.$error.'</div>';
	return;
}
?>
<?php
if($mime_type == 'video'){
?>
	<div class="video-player" style="margin:40px auto;width:400px">
	</div>
<script>
$('.video-player').simple_video_player({
	src: '<?php echo base_url().'src/temp/'.$file;?>', 
	autostart: true, 
	loaded: function(){
		document_loaded('<?php echo base_url();?>smd/documents/delete_temp_document', '<?php echo $file;?>');		
	}
});
</script>
<?php
}
else if($mime_type == 'doc' || $mime_type == 'ppt' || $mime_type == 'excel'){ 
?>
	<embed src="<?php echo sprintf($src, base_url().'src/temp/'.$file);?>" style="width:100%;height:100%" onload="document_loaded('<?php echo base_url();?>smd/documents/delete_temp_document', '<?php echo $file;?>')">
<?php
}
else{
?>
	<embed src="<?php echo base_url().'src/temp/'.$file;?>" style="width:100%;height:100%" onload="document_loaded('<?php echo base_url();?>smd/documents/delete_temp_document', '<?php echo $file;?>')">
<?php
}
?>
</div>	
<script>
function document_loaded(url, file){
	$.ajax({
		url: url,
		data: {file: file},
	});
}
</script>
	
