<style>
.cke_contents{height:400px !important}
</style>

<div style="position:absolute;top:0;right:0;bottom:0;left:0">
	<form class="clearfix" method="post" style="position:absolute;top:0;right:0;bottom:0;left:0;padding:20px">
		<?php 
		if($error){
		?>
		<div class="alert alert-danger"><?php echo $error;?></div>
		<?php
		}
		?>
		<div class="row">
			<div class="col-lg-12">
		 		<input class="btn btn-sm btn-success pull-right" type="submit" value="Submit">
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-12 form-group">
				<label>Subject</label>
				<input class="form-control input-sm" name="subject" value="<?php echo isset($subject) ? $subject : '';?>" required>
			</div>
			<div class="col-md-6 col-sm-12 form-group">
				<label>Source</label>
				<input class="form-control input-sm" name="source" value="<?php echo isset($source) ? $source : '';?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 form-group">
				<label>Top</label>
				<select class="form-control input-sm" name="top">
					<option value="N" <?php echo isset($top) && $top == 'N' ? 'selected' : '';?>>No</option>
					<option value="Y" <?php echo isset($top) && $top == 'Y' ? 'selected' : '';?>>Yes</option>
				</select>
			</div>
			<div class="col-md-3 col-sm-12 form-group">
				<label>Language</label>
				<select class="form-control input-sm" name="language">
					<option value="EN" <?php echo isset($language) && $language == 'EN' ? 'selected' : '';?>>English</option>
					<option value="CN" <?php echo isset($language) && $language == 'CN' ? 'selected' : '';?>>Chinese</option>
				</select>				
			</div>
			<div class="col-md-6 col-sm-12 form-group">
				<label>Source URL</label>
				<input class="form-control input-sm" name="source_url" value="<?php echo isset($source_url) ? $source_url : '';?>">
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 col-sm-12 form-group">
				<label>Upload File</label>				
				<div id="input-file"></div>
				<input class="dialog-edit-field" type="hidden" id="upload_files" name="upload_files">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<textarea class="form-control" name="content" id="resource-content" style="height:500px;"><?php echo isset($content) ? $content : '';?></textarea>
			</div>
		</div>
	</form>
</div>
<script>

(function($){
	if($('#input-file')){	
		$('#input-file').ajax_upload('<?php echo base_url();?>smd/resources/upload_files').change(function(files){
			var file_names = [];
			for(var i = 0; i < files.length; ++i){
				file_names.push(files[i]['final_file_name']);
			}
			$('#input-file').next().val(file_names);
		});
	}
	
	var editor = CKEDITOR.replace( 'resource-content', {
		enterMode: CKEDITOR.ENTER_P, 
		//extraPlugins: 'autogrow',
		autoGrow_onStartup: false,
		removePlugins: 'resize'
	})/*.on('instanceReady', function(ev) {
		ev.editor.on('resize',function(reEvent){
		});
	})*/;
	CKEDITOR.config.contentsCss = '<?php echo base_url();?>src/css/smd/ckeditor.css1' ;
}(jQuery));
</script>