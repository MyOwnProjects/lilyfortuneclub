<style>
#query-result thead{font-weight:bold}
.form-group{padding:5px}
</style>
<div style="margin:40px">
<h3 class="text-center">Generate Plans</h3>
<form action="<?php echo base_url();?>smd/tools/generate_plan/load" method="post" enctype="multipart/form-data">
	<a href="javascript:void()" onclick="file_load_click();">Click to select a file</a><input style="display:none" type="file" id="input-load-file" name="file" value="" onchange="file_selected(this)" required>
	&nbsp;
	<button class="btn btn-primary btn-xs disabled" type="submit" id="button-file-load">&nbsp;Load&nbsp;</button>
</form>
<br/><br/>
<form id="the_form" class="form-inline" target="_blank" action="<?php echo base_url();?>smd/tools/generate_plan" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="">
	<div class="form-group form-group-sm">
		<label>Language</label>&nbsp;
		<select class="form-control" name="language"><option value="en">English</option><option value="cn">Chinese</option></select>
	</div>
	<div class="form-group form-group-sm">
		<label>Output Format</label>&nbsp;<select class="form-control" name="format"><option value="web">Web</option><option value="csv">Csv</option></select>
	</div>
	<div class="form-group form-group-sm">
		<label>Attach Illustration</label>&nbsp;<select class="form-control" name="illustration"><option value="Y">Yes</option><option value="N">No</option></select>
	</div>
	<div class="form-group form-group-sm">  
		<label>Case Name</label>&nbsp;<input type="text" class="form-control" name="case-name" required value="<?php echo isset($content) && $content['case_name'] ? urldecode($content['case_name']) : ''?>">
	</div>
	<div class="form-group form-group-sm">
		<label>Age</label>&nbsp;<input type="number" class="form-control" min="30" max="100" name="case-age" value="<?php echo isset($content) && $content['case_age'] ? $content['case_age'] : ''?>">
	</div>
	<div class="form-group form-group-sm">
		<label>Gender</label>&nbsp;
		<select class="form-control" name="case-gender">
			<option value="F">Female</option>
			<option value="M" <?php echo isset($content) && $content['case_gender'] == 'M' ? 'selected' : ''?>>Male</option>
		</select>
	</div>
	<br/>
	<div class="form-group form-group-sm">
		<label>Desc</label>&nbsp;
		<textarea class="form-control" name="case-desc" style="height:150px;width:600px"><?php echo isset($content) && $content['case_desc'] ? urldecode($content['case_desc']) : ''?></textarea>
	</div>
	<br/>
	<div class="form-group">
		<a class="btn btn-xs btn-success" onclick="add_plan();return false;"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add a Plan</a>
	</div>
	<br/>
	<div class="block-plans">
		<?php
		if(isset($content)){
			foreach($content['plan_data'] as $i => $pd){
		?>
		<div class="block-plan">
			<div class="form-group form-group-sm">
				<a title="Remove the plan" class="btn btn-xs btn-danger" onclick="remove_plan(this);">
					<span class="glyphicon glyphicon-trash"></span>
				</a>&nbsp;&nbsp;<label>Desc</label>&nbsp;<input type="text" name="plan-desc[]" style="width:300px" class="form-control" value="<?php echo urldecode($content['plan_descs'][$i]);?>">
			</div>&nbsp;<div class="form-group form-group-sm">
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quote</label>&nbsp<textarea style="height:150px;width:500px" name="plan-data[]" class="form-control"><?php echo $pd;?></textarea>
			</div>
		</div>
		<?php
			}
		}
		?>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-small btn-primary <?php echo isset($content) && count($content['plan_data']) > 0 ? '' : 'disabled';?> button-submit" onclick="generate_report();">Generate Report</button>
		&nbsp;
		<button type="submit" class="btn btn-small btn-success <?php echo isset($content) && count($content['plan_data']) > 0 ? '' : 'disabled';?> button-submit" onclick="save_report();">Save</button>
		
		<a class="btn btn-danger btn-small" style="margin-left:200px" role="button" href="<?php echo base_url();?>smd/tools/generate_plan">New Plan</a>
	</div>
</form>
</div>	
<script>
var plan_seq = 0;
function remove_plan(obj){
			$(obj).parent().parent().remove();
			if($('.block-plan').length == 0){
				$('.button-submit').addClass('disabled');
			}
}
	
function add_plan(){
	plan_seq++;
	var block_plan = $('<div>').addClass('block-plan').appendTo($('.block-plans'));
	var group = $('<div>').addClass('form-group').addClass('form-group-sm').appendTo(block_plan);
	$('<a>').attr('title', 'Remove the plan').addClass('btn').addClass('btn-xs').addClass('btn-danger').html('<span class="glyphicon glyphicon-trash"></span>')
		.click(function(){
			remove_plan(this);
		})
		.appendTo(group);
	group.append('&nbsp;&nbsp;');
    $('<label>').attr('for', 'aa').html('Desc').appendTo(group);
	group.append('&nbsp;');
	$('<input>').attr('type', 'text').attr('name', 'plan-desc[]').css('width', '300px').addClass('form-control').appendTo(group);	group.append('&nbsp;');
 
	var group = $('<div>').addClass('form-group').addClass('form-group-sm').appendTo(block_plan);
	//$('<label>').html('Quote').appendTo(group);
	//group.append('&nbsp;');
	//$('<input>').attr('type', 'file').attr('name', 'plan-files[]').attr('accept', '.csv').addClass('form-control').appendTo(group);
	//group.append('<br/>');
	$('<label>').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quote').appendTo(group);
	group.append('&nbsp;');
	$('<textarea>').css('height', '150px').css('width', '500px').attr('name', 'plan-data[]').addClass('form-control').appendTo(group);
	$('.button-submit').removeClass('disabled');
	return false;
}

function save_report(){
	$('input[name=action]').val('save');
}

function generate_report(){
	$('input[name=action]').val('');
}

function file_load_click(){
	$('#input-load-file').click();
}
function file_selected(obj){
	if($(obj).val().length > 0){
		$(obj).prev().html($(obj).val());
		$('#button-file-load').removeClass('disabled');
	}
	else{
		$(obj).prev().html('Click to select a file');
		$('#button-file-load').addClass('disabled');
	}
}
</script>
