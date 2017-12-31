<div >
	<form method="post" style="margin:40px" action="<?php echo base_url();?>smd/tasks/<?php echo isset($tasks_id) ? "update/$tasks_id" : 'create';?>">
		<?php 
		if(isset($error) && $error){
		?>
		<div class="alert alert-danger"><?php echo $error;?></div>
		<?php
		//$case_no, $name, $subject, $detail, $type, $source, $priority, $due_date
		}
		?>
		<div class="row">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-md-6 form-group">
						<label>Case NO</label>
						<input class="form-control input-sm" name="tasks_case_no" value="<?php echo isset($tasks_case_no) ? $tasks_case_no : '';?>" required>
					</div>
					<div class="col-md-6 form-group">
						<label>Name</label>
						<input class="form-control input-sm" name="tasks_name" value="<?php echo isset($tasks_name) ? $tasks_name : '';?>" required>
					</div>
					<div class="col-md-6 form-group">
						<label>Type</label>
						<select class="form-control input-sm" name="tasks_type">
							<option value="other">Other</option>
							<option value="or" <?php echo isset($tasks_type) && $tasks_type == 'or' ? 'selected' : '';?>>Outstanding Requirement</option>
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label>Source</label>
						<select class="form-control input-sm" name="tasks_source">
							<option value="other">Other</option>
							<option value="tp" <?php echo isset($tasks_source) && $tasks_source == 'tp' ? 'selected' : '';?>>Transamerica Premier</option>
							<option value="tfaconnect" <?php echo isset($tasks_source) && $tasks_source == 'tfaconnect' ? 'selected' : '';?>>TFAConnect Account</option>
							<option value="yahoo" <?php echo isset($tasks_source) && $tasks_source == 'yahoo' ? 'selected' : '';?>>Yahoo Email</option>
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label>Priority</label>
						<select class="form-control input-sm" name="tasks_priority">
							<option value="L" <?php echo isset($tasks_priority) && $tasks_priority == 'L' ? 'selected' : '';?>>Low</option>
							<option value="M" <?php echo !isset($tasks_priority) || $tasks_priority == 'M' ? 'selected' : '';?>>Medium</option>
							<option value="H" <?php echo isset($tasks_priority) && $tasks_priority == 'H' ? 'selected' : '';?>>High</option>
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label>Status</label>
						<select class="form-control input-sm" name="tasks_status" <?php echo isset($tasks_status) ? '' : 'disabled';?>>
							<option value="done" <?php echo isset($tasks_status) && $tasks_status == 'new' ? 'selected' : '';?>>Done</option>
							<option value="new" <?php echo !isset($tasks_status) || $tasks_status == 'new' ? 'selected' : '';?>>New</option>
							<option value="pending" <?php echo isset($tasks_status) && $tasks_status == 'pending' ? 'selected' : '';?>>Pending</option>
							<option value="reopen" <?php echo isset($tasks_status) && $tasks_status == 'reopen' ? 'selected' : '';?>>Reopen</option>
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label>Create Date</label>
						<input name="tasks_create" class="form-control input-sm" type="date" value="<?php echo isset($tasks_create) ? $tasks_create : date_format(date_create(), 'Y-m-d');?>" required>
					</div>
					<div class="col-md-6 form-group">
						<label>Due Date</label>
						<input name="tasks_due_date" class="form-control input-sm" type="date" value="<?php echo isset($tasks_due_date) ? $tasks_due_date : '';?>">
					</div>
				</div>
			</div>
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-12 form-group">
						<label>Subject</label>
						<input class="form-control input-sm" name="tasks_subject" value="<?php echo isset($tasks_subject) ? $tasks_subject : 'A batch of requirements';?>" required>
					</div>
					<div class="col-lg-12 form-group">
						<label>Detail</label>
						<textarea class="form-control input-sm" style="height:170px" name="tasks_detail" id="tasks_detail"><?php echo isset($tasks_detail) ? $tasks_detail : '';?></textarea>
					</div>
				</div>
			</div>
			<div class="col-lg-12 form-group">
				<?php 
				if(isset($tasks_id)){
				?>
				<input class="btn btn-sm btn-success" type="submit" value="Update">
				<?php
				}
				else
				{
				?>
				<input class="btn btn-sm btn-success" type="submit" value="Create">
				<?php
				}
				?>
				<span>&nbsp;&nbsp;</span>
				<button class="btn btn-sm" >Close</button>
			</div>
		</div>
	</form>
</div>
<script>
(function($){
	/*CKEDITOR.replace( 'resource-content', {
		enterMode: CKEDITOR.ENTER_P, 
		extraPlugins: 'autogrow',
		autoGrow_onStartup: true,
		removePlugins: 'resize'
	}).on('instanceReady', function(ev) {
		ev.editor.on('resize',function(reEvent){
		});
	});*/

	
}(jQuery));
</script>