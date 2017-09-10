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
		<input class="form-control input-sm" style="width:80px" name="source" value="<?php echo isset($source) ? $source : '';?>">
		&nbsp;&nbsp;
		<label>Top</label>
		<select class="form-control input-sm" name="top">
			<option value="N" <?php echo isset($top) && $top == 'N' ? 'selected' : '';?>>No</option>
			<option value="Y" <?php echo isset($top) && $top == 'Y' ? 'selected' : '';?>>Yes</option>
		</select>
		&nbsp;&nbsp;
		<label>Language</label>
		<select class="form-control input-sm" name="language">
			<option value="EN" <?php echo isset($language) && $language == 'EN' ? 'selected' : '';?>>English</option>
			<option value="CN" <?php echo isset($language) && $language == 'CN' ? 'selected' : '';?>>Chinese</option>
		</select>
 		<input class="btn btn-sm btn-success pull-right" type="submit" value="Submit">
		</div>
			<div style="padding:10px">
				<div id="input-file">
				</div>
				<input class="dialog-edit-field" type="hidden" id="upload_files" name="upload_files">
			</div>
		
		<div style="position:absolute;top:150px;right:0;bottom:0;left:0;">
			<textarea class="form-control" name="content" id="resource-content"><?php echo isset($content) ? $content : '';?></textarea>
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
	CKEDITOR.config.contentsCss = '<?php echo base_url();?>src/css/smd/ckeditor.css' ;
}(jQuery));
</script>