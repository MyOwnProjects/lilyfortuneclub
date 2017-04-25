<div >
	<form method="post" style="margin:40px" action="<?php echo base_url();?>smd/tasks/<?php echo isset($tasks_id) ? "update/$tasks_id" : 'create';?>">
		<?php 
		if(isset($error) && $error){
		?>
		<div class="alert alert-danger"><?php echo $error;?></div>
		<?php
		}
		?>
		<div class="row">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-12 form-group">
						<label>Subject</label>
						<input class="form-control" name="tasks_subject" value="<?php echo isset($subject) ? $subject : '';?>" required>
					</div>
					<div class="col-lg-12 form-group">
						<label>Priority</label>
						<select class="form-control" name="tasks_priority">
							<option value="L" <?php echo $tasks_priority == 'L' ? 'selected' : '';?>>Low</option>
							<option value="M" <?php echo $tasks_priority == 'M' ? 'selected' : '';?>>Medium</option>
							<option value="H" <?php echo $tasks_priority == 'H' ? 'selected' : '';?>>High</option>
						</select>
					</div>
					<div class="col-lg-12 form-group">
						<label>Assign to</label>
						<select class="form-control" name="tasks_user_id">
							<?php
							foreach($assistants as $a){
								echo '<option value="'.$a['users_id'].'" '.(isset($tasks_user_id) && $tasks_user_id == $a['users_id'] ? 'selected' : ''  ).'>'.$a['first_name'].' '.$a['last_name'].'</option>';
							}
							?>
						</select>
					</div>
					<div class="col-lg-12 form-group">
						<label>Due Time</label>
						<div class="input-group input-group-sm" id="dp-from">
							<?php 
							$d = date_create((date_format(date_create(), 'Y-m-d H:00')));
							date_add($d, date_interval_create_from_date_string("30 minutes"));
							?>
							<input name="tasks_due_date" class="form-control" type="text" value="<?php echo date_format($d, 'Y-m-d H:i');?>" disabled style="background:#fff">
							<div class="input-group-addon" style="cursor:pointer">
								<span class="glyphicon"><i class="glyphicon glyphicon-time"></i></span>
							</div>
						</div>
					</div>
					<div class="col-lg-12 form-group">
						<?php 
						if(isset($tasks_id)){
						?>
						<input class="btn btn-success" type="submit" value="Update">
						<?php
						}
						else
						{
						?>
						<input class="btn btn-success" type="submit" value="Create">
						<?php
						}
						?>
						<button class="pull-right btn" >Close</button>
					</div>
				</div>
			</div>
			<div class="col-lg-6 form-group">
				<label>Detail</label>
				<textarea class="form-control" style="height:300px" name="tasks_detail" id="tasks_detail"><?php echo isset($tasks_detail) ? $tasks_detail : '';?></textarea>
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

	$('#dp-from input').datetimepicker({format: 'Y-m-d H:i', step:30});
	$('#dp-from .input-group-addon').click(function(){
		$(this).prev().datetimepicker('show');
	});
	
}(jQuery));
</script>