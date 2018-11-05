<style>
.doc-view-wrapper{margin:40px 0}
.doc-view-left{overflow:hidden;min-width:200px;margin:0 40px;}
.doc-view-right{width:400px;margin:40px}
.doc-view-right1{display:none}
.document-content{padding:40px 0;line-height:25px;}
.document-content .content-image{text-align:center;margin:40px auto} 
.document-content img{width:100%;max-width:600px}
@media only screen and (max-width:900px) {
.doc-view-wrapper{margin:40px 0;display:table}
.video-text{margin:20px;}
.document-subject{text-align:left;font-weight:normal}
.doc-view-left{margin:0;width:100%;min-width:0;}
.doc-view-right{display:none}
.doc-view-right1{display:block;margin:20px}
}
</style>
<div class="clearfix doc-view-wrapper">
	<div class="pull-right doc-view-right">
		<?php
		foreach($docs as $d){
		?>
		<div class="clearfix" style="font-size:16px;padding:5px 0">
		<?php 
			$mt = mime_type(getcwd().'/src/doc/'.$d['uniqid'].'.'.$d['file_name']);
			echo '<div class="pull-left" style="margin-right:20px"><i class="fa fa-file-'.$mt[0].'-o" style="color:'.doc_icon_color($mt).'"></i>&nbsp;';
			echo '<a href="'.base_url().'documents/view/'.$d['uniqid'].'">'.$d['subject'].'</a>';
			echo '</div>';
		?>
		</div>
		<?php
		}
		?>
	</div>

	<div class="doc-view-left">
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url();?>">Home</a></li>
		<li><a href="<?php echo base_url();?>documents">Documents</a></li> 
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
		<?php
		$video_duration = array();
		if(!empty($duration) && (strtotime('now') > strtotime($expire))){
			$video_duration = explode(',', $duration);
		}
		if(count($video_duration) == 2){
			$m = floor(($video_duration[1] - $video_duration[0]) / 60);
			$s = $video_duration[1] - $video_duration[0] - $m * 60
		?>
		<?php
		}
		?>
		<div class="video-text">
		<p class="text-danger">You can only watch the video for <?php echo str_pad($m, 2, '0', STR_PAD_LEFT).':'.str_pad($s, 2, '0', STR_PAD_LEFT);?> by this access code. To watch the full video, please contact <a href="<?php echo base_url();?>contact" target="_blank">Lilyfortuneclub</a>.</p>
		<h2><?php echo $subject;?></h2>
		<div style="line-height:30px">Content Type: <?php echo $content_type;?></div>
		<?php if(!empty($abstract)){ ?>
		<div style="line-height:20px"><?php echo str_replace("\n", '<br/>', $abstract);?></div>
		</div>
		<?php } 
//-----
		$captions = array();
		if(!empty($video_duration)){
			$captions = array(array(0, $video_duration[1] + 1, 'Please contact Lilyfortuneclub to get the full video'));
		}
//---------		
		?>
	<script>
		//-----
		$(document).ready(function(){
			$('.video-player').simple_video_player({
				src: '<?php echo base_url().'src/doc/'.$file;?>',
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
		<img src="<?php echo base_url().'src/doc/'.$file;?>" onload="document_loaded('<?php echo $file;?>')" style="width:100%">
		</div>
	<?php
	}
	?>
	</div>
		<div class="doc-view-right1">
		<?php
		foreach($docs as $d){
		?>
		<div class="clearfix" style="font-size:16px;padding:5px 0">
		<?php 
			$mt = mime_type(getcwd().'/src/doc/'.$d['uniqid'].'.'.$d['file_name']);
			echo '<div class="pull-left" style="margin-right:20px"><i class="fa fa-file-'.$mt[0].'-o" style="color:'.doc_icon_color($mt).'"></i>&nbsp;';
			echo '<a href="'.base_url().'documents/view/'.$d['uniqid'].'">'.$d['subject'].'</a>';
			echo '</div>';
		?>
		</div>
		<?php
		}
		?>
	</div>

</div>
	
