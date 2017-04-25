<div >
	<form method="post" style="margin:40px">
		<?php 
		if($error){
		?>
		<div class="alert alert-danger"><?php echo $error;?></div>
		<?php
		}
		?>
		<div class="row">
			<div class="col-lg-6 form-group">
				<label>Subject</label>
				<input class="form-control" name="subject" value="<?php echo isset($subject) ? $subject : '';?>" required>
			</div>
			<div class="col-lg-6">
				<label>Source</label>
				<input class="form-control" name="source" value="<?php echo isset($source) ? $source : '';?>">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<label>Content</label>
				<textarea class="form-control" style="height:300px" name="content" id="resource-content"><?php echo isset($content) ? $content : '';?></textarea>
			</div>
		</div>
		<div class="form-group">
			<input class="btn btn-primary pull-right" type="submit" value="submit">
		</div>
	</form>
</div>
<script>
(function($){
	CKEDITOR.replace( 'resource-content', {
		enterMode: CKEDITOR.ENTER_P, 
		extraPlugins: 'autogrow',
		autoGrow_onStartup: true,
		/*removePlugins: 'resize'*/
	}).on('instanceReady', function(ev) {
		ev.editor.on('resize',function(reEvent){
		});
	});
}(jQuery));
</script>