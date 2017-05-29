<style>
.cke_editor_resource-content, .cke_inner{position:absolute;top:0;right:0;bottom:0;left:0;}
.cke_top{position:absolute;top:0;right:0;left:0;}
.cke_contents{position:absolute;top:108px;right:0;bottom:27px;left:0;height:auto !important;}
.cke_bottom{position:absolute;bottom:0;right:0;left:0;}
</style>

<div style="position:absolute;top:0;right:0;bottom:0;left:0">
	<form class="form-inline" method="post" style="position:absolute;top:0;right:0;bottom:0;left:0">
		<?php 
		if($error){
		?>
		<div class="alert alert-danger"><?php echo $error;?></div>
		<?php
		}
		?>
		<div style="padding:10px 10px">
		<label>Subject</label>
		<input class="form-control input-sm" style="width:300px" name="subject" value="<?php echo isset($subject) ? $subject : '';?>" required>
		&nbsp;&nbsp;
		<label>Source</label>
		<input class="form-control input-sm" style="width:150px" name="source" value="<?php echo isset($source) ? $source : '';?>">
 		<input class="btn btn-sm btn-primary pull-right" type="submit" value="submit">
		</div>
		<div style="position:absolute;top:50px;right:0;bottom:0;left:0;">
			<textarea class="form-control" name="content" id="resource-content"><?php echo isset($content) ? $content : '';?></textarea>
		</div>
	</form>
</div>
<script>
(function($){
	var editor = CKEDITOR.replace( 'resource-content', {
		enterMode: CKEDITOR.ENTER_P, 
		//extraPlugins: 'autogrow',
		autoGrow_onStartup: false,
		removePlugins: 'resize'
	})/*.on('instanceReady', function(ev) {
		ev.editor.on('resize',function(reEvent){
		});
	})*/;
	CKEDITOR.config.contentsCss = '<?php echo base_url();?>src/css/smd/ckeditor.css' ;
}(jQuery));
</script>