<div style="padding:40px">
	<form method="post">
		<div class="row">
			<div class="col-lg-6 form-group">
				<label>Subject</label>
				<input class="form-control" name="subject" value="<?php echo isset($subject) ? $subject : '';?>" required>
			</div>
			<div class="col-lg-3">
				<label>Content Type</label>
				<select class="form-control" name="content_type">
					<?php
					foreach($content_types as $t){
						echo '<option value="'.$t.'" '.(isset($content_type) && $content_type == $t ? 'selected' : '').'>'.$t.'</option>';
					}
					?>
				</select>
			</div>
			<div class="col-lg-3">
				<label>Grade Access</label>
				<select class="form-control" name="grade_access">
					<?php
					foreach($access_grades as $g){
						echo '<option value="'.$g['value'].'" '.(isset($grade_access) && $grade_access == $g['value'] ? 'selected' : '').'>'.$g['text'].'</option>';
					}
					?>
					
				</select>
			</div>
		</div>
		<?php if(empty($uniqid)){ ?>
		<div class="row">
			<div class="form-group col-lg-12">
				<label>Upload File(s)</label>
				<div id="input-file">
				</div>
				<input class="dialog-edit-field" type="hidden" id="upload_files" name="upload_files">
			</div>
		</div>
		<?php } ?>
		<div class="row">
			<div class="col-lg-12 form-group">
				<label>Content</label>
				<textarea class="form-control" name="html_content" id="html_content"><?php echo isset($html_content) ? $html_content : '';?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<input type="submit" class="btn btn-success pull-right" value="Submit" />
			</div>
		</div>
	</form>
</div>
<script>
(function($){
	CKEDITOR.replace( 'html_content', {
		enterMode: CKEDITOR.ENTER_P, 
		extraPlugins: 'autogrow',
		/*removePlugins: 'resize'*/
	}).on('instanceCreated', function(ev) {
		ev.editor.on('resize',function(reEvent){
		});
	});
	if($('#input-file')){	
		$('#input-file').ajax_upload('<?php echo base_url();?>smd/documents/upload_files').change(function(files){
			var file_names = [];
			for(var i = 0; i < files.length; ++i){
				file_names.push(files[i]['final_file_name']);
			}
			$('#input-file').next().val(file_names);
		});
	}
}(jQuery));
</script>
