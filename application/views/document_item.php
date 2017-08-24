<style>
.left-part{padding:0 100px;max-width:1000px;width:100%}
.document-content{padding:40px 0;line-height:25px;}
.document-content .content-image{text-align:center;margin:40px auto} 
.document-content img{width:100%;max-width:600px}
@media only screen and (max-width:800px) {
.document-subject{text-align:left;font-weight:normal}
.right-part{display:none;}
.left-part{padding:0 20px}
}
</style>
<script>
function document_loaded(file){
	$.ajax({
		url: '<?php echo base_url();?>account/documents/delete_temp_document',
		data: {file: file},
	});
}
/*$('.doc-frame').each(function(index, obj){
	$(obj).outerHeight($(obj).outerWidth() * 1.4);
});*/
</script>
<div class="clearfix" style="margin-bottom:40px">
	<div class="left-part pull-left">
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url();?>">Home</a></li>
		<li><a href="<?php echo base_url();?>account/documents">Documents</a></li> 
		<li class="active">Item</li> 
	</ul>
	<?php
	if(isset($error) && !empty($error)){
		echo '<div class="alert alert-danger">'.$error.'</div>';
		return;
	}
	?>
	<?php
	if($mime_type == 'video'){
	?>
		<h3 class="text-center"><?php echo $subject;?></h3>
		<div class="video-player" style="margin:20px auto">
		</div>
		<div style="line-height:30px">Content Type: <?php echo $content_type;?></div>
		<?php if(!empty($html_content)){ ?>
		<div style="line-height:20px"><?php echo $html_content;?></div>
		<?php } ?>
	<script>
	$('.video-player').simple_video_player({
		src: '<?php echo base_url().'src/temp/'.$file;?>', 
		autostart: true, 
		loaded: function(){
			document_loaded('<?php echo $file;?>');		
		}
	});
	</script>
	<?php
	}
	else if($mime_type == 'doc' || $mime_type == 'ppt' || $mime_type == 'excel'){ 
	}
	else if($mime_type == 'HTML'){
	?>
		<h3 class="text-center"><?php echo $subject;?></h3>
		<div class="document-content"><?php echo $html_content;?></div>
	<?php
	}
	else if($mime_type == 'pdf'){
	}
	else if($mime_type == 'image'){
	?>
		<h3 class="text-center"><?php echo $subject;?></h3>
		<div>
		<img src="<?php echo base_url().'src/temp/'.$file;?>" onload="document_loaded('<?php echo $file;?>')" style="width:100%">
		</div>
	<?php
	}
	?>
	</div>
	<div class="right-part" style="overflow:hidden;padding-top:40px">
	</div>
</div>
	
