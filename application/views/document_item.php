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
	<div style="width:100%;max-width:800px;margin:0 auto">
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
		<div class="video-player">
		</div>
		<!--div class="video-player" style="margin:20px auto">
			<video id="player" playsinline controls>
				<source src="<?php echo base_url().'src/media/'.$file;?>" type="video/mp4">
				<?php
					$video_duration = array();
					if(!empty($duration) && (strtotime('now') > strtotime($expire))){
						$video_duration = explode(',', $duration);
				?>
				<track kind="captions" label="English captions" src="<?php echo base_url().'src/media/'.$uniqid.'.vtt';?>" srclang="en" default>
				<?php
					}
				?>
			</video>
		</div-->
		<?php
		if(count($video_duration) == 2){
		?>
		<p class="text-danger">You can only watch the video for <?php echo ($video_duration[1] - $video_duration[0]) / 60;?> minutes by this access code. To watch the full video, please contact <a href="<?php echo base_url();?>contact" target="_blank">Lilyfortuneclub</a></p>
		<?php
		}
		?>
		<h2><?php echo $subject;?></h2>
		<div style="line-height:30px">Content Type: <?php echo $content_type;?></div>
		<?php if(!empty($abstract)){ ?>
		<div style="line-height:20px"><?php echo str_replace("\n", '<br/>', $abstract);?></div>
		<?php } 
//-----
		$video_duration = array();
		$captions = array();
		if(!empty($duration) && (strtotime('now') > strtotime($expire))){
			$video_duration = explode(',', $duration);
			$captions = array(array(0, $video_duration[1] + 1, 'Please contact Lilyfortuneclub to get the full video'));
		}
//---------		
		?>
	<script>
		//-----
		$(document).ready(function(){
			$('.video-player').simple_video_player({
				src: '<?php echo base_url().'src/media/'.$file;?>',
				duration: JSON.parse('<?php echo json_encode($video_duration);?>'),
				captions: JSON.parse('<?php echo json_encode($captions);?>'),
				autostart: true,
				out_duration_callback: function(){
				},
			});
		});
		//-----
		/*const player = new Plyr('#player', {
			invertTime: false,
			captions: { active: true}
		});
		if(<?php echo count($video_duration) == 2 ? 'true' : 'false';?>){
			var start = <?php echo count($video_duration) == 2 ? $video_duration[0] : 0;?>;
			var end = <?php echo count($video_duration) == 2 ? $video_duration[1] : 0;?>;
			player.on('timeupdate', event => {
				if(player.currentTime > end){
					player.stop();
					player.currentTime = end;
				}
			});
			player.on('play', event => {
				if(player.currentTime < start){
					player.stop();
					player.currentTime = start;
				}
			});
		}*/
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
	<!--div class="right-part" style="overflow:hidden;padding-top:40px">
	</div-->
</div>
	
