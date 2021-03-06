<div style="padding:40px">
	<form method="post">
		<div class="row">
			<div class="form-group col-lg-12">
				<label>Subject</label>
				<input class="form-control" name="subject" value="<?php echo isset($subject) ? $subject : '';?>" required>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-lg-3 col-md-4 col-sm-6">
				<label>Content Type</label>
				<select class="form-control" name="content_type">
					<?php
					foreach($content_types as $t){
						echo '<option value="'.$t.'" '.(isset($content_type) && $content_type == $t ? 'selected' : '').'>'.$t.'</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group col-lg-3 col-md-4 col-sm-6">
				<label>Grade Access</label>
				<select class="form-control" name="grade_access">
					<?php
					foreach($access_grades as $g){
						echo '<option value="'.$g['value'].'" '.(isset($grade_access) && $grade_access == $g['value'] ? 'selected' : '').'>'.$g['text'].'</option>';
					}
					?>
					
				</select>
			</div>
			<!--div class="form-group col-lg-3 col-md-4 col-sm-6">
				<label>Expiration</label>
				<div class="input-group">
					<input type="number" class="form-control">
					<div class="input-group-append">
						<span class="input-group-text">Hours</span>
					</div>
				</div>				
			</div-->
			<div class="form-group col-lg-3 col-md-4 col-sm-6">
				<label>Duration (Seconds)</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">Start</span>
					</div>
					<input type="number" min="0" class="form-control" name="video_duration_tart">
					<div class="input-group-prepend">
						<span class="input-group-text">End</span>
					</div>
					<input type="number" min="0" class="form-control" name="video_duration_end">
				</div>				
			</div>
			<div class="form-group col-lg-3 col-md-4 col-sm-6">
				<label>Course Related</label>
				<select class="form-control" name="courses_id">
					<option value="0">None</option>
					<?php
					foreach($courses as $t => $ct){
					?>
					<optgroup label="<?php echo $t == 'F' ? 'Financial Concept' : 'BFS/Marketing';?>">
					<?php
					foreach($ct as $c){
					?>
						<option value="<?php echo $c['courses_id'];?>"><?php echo $c['courses_topic'];?></option>
					<?php
					}
					?>
					</optgroup>
					<?php
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
				<label>Abstract</label>
				<textarea class="form-control" name="abstract" style="height:100px"><?php echo isset($abstract) ? $abstract : '';?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<label>HTML Content</label>
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
