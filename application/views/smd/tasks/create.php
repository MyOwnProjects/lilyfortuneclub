<?php
if($task){
	$fields = array('tasks_id','tasks_subject','tasks_detail','tasks_due_date','tasks_status','tasks_type','tasks_name','tasks_priority','tasks_source','tasks_case_no');
	foreach($fields as $f){
		$$f = array_key_exists($f, $task) ? $task[$f] : null;
	}
}
$tasks_name = isset($tasks_name) ?  $tasks_name : '';
//$prop = $task['prop'];
?>

<div style="margin-top:40px;">
	<h3 class="text-center"><?php echo isset($tasks_id) ? 'Edit' : 'New' ?> Task</h3>
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
				<button class="btn btn-sm btn-danger" >Close</button>
			</div>
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-12 form-group">
						<label>Subject</label>
						<input class="form-control form-control-sm" name="tasks_subject" value="<?php echo isset($tasks_subject) ? $tasks_subject : '';?>">
					</div>
					<div class="col-lg-12 form-group">
						<label>Detail</label>
						<textarea class="form-control form-control-sm" style="height:170px" name="tasks_detail" id="tasks_detail"><?php echo isset($tasks_detail) ? $tasks_detail : '';?></textarea>
					</div>
				</div>
			</div>
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-md-6 form-group">
						<label>Due Date</label>
						<input name="tasks_due_date" class="form-control form-control-sm" type="date" value="<?php echo isset($tasks_due_date) ? $tasks_due_date : '';?>">
					</div>
					<div class="col-md-6 form-group">
						<label>Status</label>
						<select class="form-control form-control-sm" name="tasks_status">
							<option value="Pending" <?php echo isset($tasks_status) && $tasks_status == 'pending' ? 'selected' : '';?>>Pending</option>
							<option value="Escalated" <?php echo isset($tasks_status) && $tasks_status == 'escalated' ? 'selected' : '';?>>Escalated</option>
							<option value="Done" <?php echo isset($tasks_status) && $tasks_status == 'done' ? 'selected' : '';?>>Done</option>
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label>Assign to</label>
						<!--input class="form-control form-control-sm" name="tasks_name" value="<?php echo isset($tasks_name) ? $tasks_name : '';?>"-->
						
						<div class="dropdownedit">
							<input type="hidden" name="tasks_name" id="tasks_name" value="<?php echo isset($tasks_name) ? $tasks_name : '';?>">
							<?php
							$display_value = $tasks_name;
							foreach($users as $o){
								if($tasks_name == $o['value']){
									$display_value = $o['text'];
									break;
								}
							}
							?>
							<input type="text" class="dropdown-toggle form-control form-control-sm" data-toggle="dropdown" value="<?php echo $display_value;?>">
							<div class="dropdown-menu" style="max-height:200px;overflow-y:auto;right:0px !important;padding:0 !important">
								<?php
								foreach($users as $o){
								?>
								<a class="dropdown-item" value="<?php echo $o['value'];?>"><?php echo $o['text'];?></a>
								<?php
								}
								?>
							</div>
						</div>						

						
						
						
						
					</div>
					<div class="col-md-6 form-group">
						<label>Priority</label>
						<select class="form-control form-control-sm" name="tasks_priority">
							<option value="L" <?php echo isset($tasks_priority) && $tasks_priority == 'L' ? 'selected' : '';?>>Low</option>
							<option value="M" <?php echo !isset($tasks_priority) || $tasks_priority == 'M' ? 'selected' : '';?>>Medium</option>
							<option value="H" <?php echo isset($tasks_priority) && $tasks_priority == 'H' ? 'selected' : '';?>>High</option>
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label>Case NO</label>
						<input class="form-control form-control-sm" name="tasks_case_no" value="<?php echo isset($tasks_case_no) ? $tasks_case_no : '';?>">
					</div>
					<div class="col-md-6 form-group">
						<label>Type</label>
						<select class="form-control form-control-sm" name="tasks_type">
							<option value="BPM" <?php echo isset($tasks_type) && $tasks_type == 'BPM' ? 'selected' : '';?>>BPM</option>
							<option value="Fast Start" <?php echo isset($tasks_type) && $tasks_type == 'Fast Start' ? 'selected' : '';?>>Fast Start</option>
							<option value="Outstanding Requirement" <?php echo isset($tasks_type) && $tasks_type == 'Outstanding Requirement' ? 'selected' : '';?>>Outstanding Requirement</option>
							<option value="Process" <?php echo isset($tasks_type) && $tasks_type == 'Process' ? 'selected' : '';?>>Process</option>
							<option value="Prospect" <?php echo isset($tasks_type) && $tasks_type == 'Prospect' ? 'selected' : '';?>>Prospect</option>
							<option value="Recruit" <?php echo isset($tasks_type) && $tasks_type == 'Recruit' ? 'selected' : '';?>>Recruit</option>
							<option value="Sales" <?php echo isset($tasks_type) && $tasks_type == 'Sales' ? 'selected' : '';?>>Sales</option>
							<option value="Team Building" <?php echo isset($tasks_type) && $tasks_type == 'Team Building' ? 'selected' : '';?>>Team Building</option>
							<option value="Other" <?php echo !isset($tasks_type) || $tasks_type == 'Other' ? 'selected' : '';?>>Other</option>
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label>Source</label>
						<select class="form-control form-control-sm" name="tasks_source">
							<option value="other">Other</option>
							<option value="tp" <?php echo isset($tasks_source) && $tasks_source == 'tp' ? 'selected' : '';?>>Transamerica Premier</option>
							<option value="tfaconnect" <?php echo isset($tasks_source) && $tasks_source == 'tfaconnect' ? 'selected' : '';?>>TFAConnect Account</option>
							<option value="yahoo" <?php echo isset($tasks_source) && $tasks_source == 'yahoo' ? 'selected' : '';?>>Yahoo Email</option>
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label>Create Date</label>
						<input name="tasks_create" class="form-control form-control-sm" type="date" value="<?php echo isset($tasks_create) ? $tasks_create : date_format(date_create(), 'Y-m-d');?>">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
$('.dropdownedit .dropdown-menu .dropdown-item').click(function(){
	$(this).parent().prev().val($(this).html());
	$(this).parent().prev().prev().val($(this).attr('value'));
	/*if(<?php echo empty($policies_id) ? 'false' : 'true';?>){
		ajax_loading(true);
		var data = {};
		data[$(this).parent().prev().prev().attr('id')] = $(this).attr('value');
		$.ajax({
			url: '<?php echo base_url();?>smd/sales/sales_case/<?php echo $policies_id;?>',
			method: 'post',
			data: data,
			dataType: 'json',
			success: function(data){
			},
			error: function(a, b, c){
			},
			complete:function(){
				ajax_loading(false);
			}
		});
	}*/
});


$('.dropdownedit input.dropdown-toggle').keyup(function(e){
	var value = $(this).val().trim();
	$(this).next().children().each(function(index, obj){
		if($(obj).html().toLowerCase().indexOf(value.toLowerCase()) >= 0){
			$(obj).show();
		}
		else{
			$(obj).hide();
		}
	});
	$(this).prev().val(value);
});
	
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