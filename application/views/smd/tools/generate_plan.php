<style>
#query-result thead{font-weight:bold}
.form-group{padding:5px}
.block-plan-template{display:none}
.block-plan{border-top:1px solid #d5d5d5;padding-top:10px;margin-top:10px}
label{font-weight:normal}
</style>
<div style="margin:40px">
<h3 class="text-center">Generate Plans</h3>
<form class="form-inline" target="_blank" action="<?php echo base_url();?>smd/tools/commission_report" method="post" enctype="multipart/form-data">
	<label>For</label>&nbsp;
		<select class="form-control input-sm" name="case-for">
			<option value="0">其它</option>
			<option value="1">新京集团</option>
		</select>
	&nbsp;&nbsp;
		<a href="javascript:void()" onclick="file_load_click1();">Click to select case file(s)</a><input style="display:none" type="file" id="input-load-file1" name="case-files-commission-report[]" value="" onchange="file_selected1(this)" required multiple accept=".json">
	&nbsp;
	<button class="btn btn-primary btn-xs disabled" type="submit" id="button-file-load1">&nbsp;Generate Commission Report&nbsp;</button>
</form>
<br/><br/>
<form class="form-inline" target="_blank" action="<?php echo base_url();?>smd/tools/bulk_plans" method="post" enctype="multipart/form-data">
	<a href="javascript:void()" onclick="file_load_click2();">Click to select multiple case files</a><input style="display:none" type="file" id="input-load-file2" name="bulk-plans-report[]" value="" onchange="file_selected2(this)" required multiple accept=".json">
	&nbsp;
	<button class="btn btn-primary btn-xs disabled" type="submit" id="button-file-load2">&nbsp;Generate Bulk Plans&nbsp;</button>
</form>
<br/><br/>
<form action="<?php echo base_url();?>smd/tools/generate_plan/load" method="post" enctype="multipart/form-data">
	<a href="javascript:void()" onclick="file_load_click();">Click to select a case file</a><input style="display:none" type="file" id="input-load-file" name="file" value="" onchange="file_selected(this)" required accept=".json">
&nbsp;
	<button class="btn btn-primary btn-xs disabled" type="submit" id="button-file-load">&nbsp;Load&nbsp;</button>
</form>
<br/>
<form id="the_form" class="form-inline" target="_blank" action="<?php echo base_url();?>smd/tools/generate_plan" method="post" enctype="multipart/form-data">
	<div class="form-group form-group-sm">
		<label>For</label>&nbsp;
		<select class="form-control" name="case-for">
			<option value="0" <?php echo isset($content) && array_key_exists('case_for', $content) && $content['case_for'] == 0 ? 'selected' : ''?>>其它</option>
			<option value="1" <?php echo !isset($content) || !array_key_exists('case_for', $content) || $content['case_for'] == 1 ? 'selected' : ''?>>新京集团</option>
		</select>
	</div>
	<br/>
	<input type="hidden" name="action" value="">
	<div class="form-group form-group-sm">  
		<label>Client Name</label>&nbsp;<input type="text" class="form-control" name="client-name" required value="<?php echo isset($content) && array_key_exists('client_name', $content) ? urldecode($content['client_name']) : ''?>">
	</div>
	<div class="form-group form-group-sm">
		<label>Age</label>&nbsp;<input type="number" class="form-control" min="20" max="100" name="case-age" value="<?php echo isset($content) && $content['case_age'] ? $content['case_age'] : ''?>">
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
		<label>Face Amount</label>&nbsp;
		<select class="form-control" name="face-amount">
			<option value="50000">50K</option>
			<option value="100000">100K</option>
			<option value="150000">150K</option>
			<option value="200000">200K</option>
			<option value="250000">250K</option>
			<option value="300000">300K</option>
			<option value="500000">500K</option>
			<option value="1000000">1M</option>
			<option value="2000000">2M</option>
		</select>
	</div>
	&nbsp;&nbsp;
	<div class="checkbox">
		<label><input type="checkbox" value="">&nbsp;Cash out</label>
	</div>
	<br/>
	<div class="form-group form-group-sm">  
		<label>Case Name</label>&nbsp;<input type="text" class="form-control" name="case-name" required value="<?php echo isset($content) && $content['case_name'] ? urldecode($content['case_name']) : ''?>" readonly1>
	</div>
	<div class="form-group form-group-sm">
		<label>Case Desc</label>&nbsp;
		<textarea class="form-control" name="case-desc" style="height:80px;width:600px" readonly1><?php echo isset($content) && $content['case_desc'] ? urldecode($content['case_desc']) : ''?></textarea>
	</div>
	<br/>
	<div class="form-group">
		<a type="submit" class="btn btn-small btn-primary <?php echo isset($content) && count($content['plan_data']) > 0 ? '' : 'disabled';?> button-submit" onclick="commission_click();">Commission</a>
		&nbsp;
		<button type="submit" class="btn btn-small btn-primary <?php echo isset($content) && count($content['plan_data']) > 0 ? '' : 'disabled';?> button-submit" onclick="generate_report();">Generate Report</button>
		&nbsp;
		<button type="submit" class="btn btn-small btn-success <?php echo isset($content) && count($content['plan_data']) > 0 ? '' : 'disabled';?> button-submit" onclick="save_report();">Save</button>
		
		<a class="btn btn-danger btn-small" style="margin-left:50px" role="button" href="<?php echo base_url();?>smd/tools/generate_plan">New Plan</a>
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
				</a>
				&nbsp;&nbsp;
				<label>Code</label>&nbsp;<input type="text" name="plan-code[]" style="width:300px" class="form-control" value="<?php echo array_key_exists('plan_code', $content) ? urldecode($content['plan_code'][$i]) : '';?>">
				<br/><br/>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>Desc</label>&nbsp;
				<input type="text" name="plan-desc[]" style="width:300px" class="form-control" value="<?php echo urldecode($content['plan_descs'][$i]);?>">
			</div>&nbsp;<div class="form-group form-group-sm">
				<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quote</label>&nbsp<textarea style="height:150px;width:500px" name="plan-data[]" class="form-control"><?php echo $pd;?></textarea>
			</div>
		</div>
		<?php
			}
		}
		?>
	</div>

</form>
<div class="block-plan-template">
	<div style="float:left;padding-right:20px">
		<div class="form-group form-group-sm">
		<a title="Remove the plan" class="btn btn-xs btn-danger" onclick="remove_plan(this);">
			<span class="glyphicon glyphicon-trash"></span>
		</a>
		</div>
	</div>
	<div style="float:left;padding-right:20px">
		<div class="form-group form-group-sm">
			<select name="plan-type1[]" class="form-control" onchange="plan_type_change(this)">
				<option value="0">5 years 7 pay</option>
				<option value="1">5 years 7 pay alternitive</option>
				<option value="2">10 years target</option>
				<option value="3">15 years target</option>
				<option value="4">20 years target</option>
			</select>
			<br/><br/>
			<input name="plan-code[]" class="form-control" type="text" style="width:100px" readonly1 placeholder="Code">
			<br/><br/>
			<input name="plan-desc[]" class="form-control" type="text" style="width:300px" readonly1 placeholder="Desc">
		</div>
	</div>
	<div style="overflow:hidden;">
		<div class="form-group form-group-sm">
			<textarea style="height:130px;width:500px" name="plan-data[]" class="form-control" placeholder="Quote"></textarea>
		</div>		
	</div>
</div>	
<script>
var plan_seq = 0;
function remove_plan(obj){
	$(obj).parent().parent().parent().remove();
	if($('.block-plan').length == 0){
		$('.button-submit').addClass('disabled');
	}
}
	
function add_plan(){
	plan_seq++;
	var block_plan = $('<div>').addClass('block-plan').addClass('clear').appendTo($('.block-plans')).append($('.block-plan-template').html());
	/*var group = $('<div>').addClass('form-group').addClass('form-group-sm').appendTo(block_plan);
	$('<a>').attr('title', 'Remove the plan').addClass('btn').addClass('btn-xs').addClass('btn-danger').html('<span class="glyphicon glyphicon-trash"></span>')
		.click(function(){
			remove_plan(this);
		})
		.appendTo(group);
	group.append('&nbsp;&nbsp;');
    $('<label>').attr('for', 'aa').html('Code').appendTo(group);
	group.append('&nbsp;');
	$('<input>').attr('type', 'text').attr('name', 'plan-code[]').css('width', '300px').addClass('form-control').appendTo(group);	group.append('&nbsp;');
	group.append('<br/><br/>');
	group.append('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
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
	$('<textarea>').css('height', '150px').css('width', '500px').attr('name', 'plan-data[]').addClass('form-control').appendTo(group);*/
	$('.button-submit').removeClass('disabled');
	return false;
}

function plan_type_change(obj){
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
		$(obj).prev().html('Click to select a case file');
		$('#button-file-load').addClass('disabled');
	}
}

function file_load_click1(){
	$('#input-load-file1').click();
}
function file_selected1(obj){
	if($(obj)[0].files.length > 0){
		$(obj).prev().html($(obj)[0].files.length + ' files are selected');
		$('#button-file-load1').removeClass('disabled');
	}
	else{
		$(obj).prev().html('Click to select case file(s)');
		$('#button-file-load1').addClass('disabled');
	}
}

function file_load_click2(){
	$('#input-load-file2').click();
}
function file_selected2(obj){
	if($(obj)[0].files.length > 0){
		$(obj).prev().html($(obj)[0].files.length + ' files are selected');
		$('#button-file-load2').removeClass('disabled');
	}
	else{
		$(obj).prev().html('Click to select multiple case files');
		$('#button-file-load2').addClass('disabled');
	}
}

function commission_click(){
	var s = calculate_commission();
	/*var wrapper = $('<div>');
	var form = $('<div>').addClass('clearfix').appendTo(wrapper);
	$('<a type="button" class="btn btn-primary btn-sm pull-right" style="margin-left:10px" onclick="calculate_commission();">Calculate</a>').appendTo(form); 
	var input_group = $('<div>').css('overflow', 'hidden').addClass('input-group').appendTo(form)
		.append('<span class="input-group-addon"><i class="glyphicon">$</i></span>')
		.append('<input id="input-premium" type="text" class="form-control input-sm" placeholder="Premium">');
	wrapper.append('<br/>');
	var table = $('<table>').attr('id', 'table-premium').attr('border', '0').css('width', '100%').appendTo(wrapper);*/
	Dialog.modal({
		message: s,
		title: "Calculate Commission",
		buttons: {
			cancel: {
				label: "Close",
				className: "btn"
			}
		},
		onEscape: function () {
			Dialog.modal('hide');
		}
	});
}

function calculate_commission(){
	var output = [];
	var commission_premium = 999999999;//parseFloat($('#input-premium').val().trim().replace(/[,$]+/g,''));
	
	$('input[name="plan-code[]"]').each(function(index, obj){
		output[index] = {code: $(obj).val().trim()};
	});
	$('textarea[name="plan-data[]"]').each(function(index, obj){
		var premium_sum = 0;
		var data = $(obj).val();
		var rows = data.split('\n');
		for(var i = 0; i < rows.length; ++i){
			var cells = rows[i].split('\t');
			var v = parseInt(cells[2].trim().replace(/[,$)]+/g,'').replace(/[(]+/g,'-'));
			if(v > 0){
				premium_sum += v;
			}
			if(i == 0 && v < commission_premium){
				commission_premium = v;
			}
		}
		output[index]['premium'] = premium_sum;
	});
	var table = $('<table>').attr('id', 'table-premium').css('width', '100%');
	table.empty().append('<thead><tr><th class="text-center">Plan Code</th><th class="text-center">Total Premium</th><th class="text-center">Commission</th><tr></thead>');
	var tbody = $('<tbody>').appendTo(table);
	for(var i = 0; i < output.length; ++i){
		var tr = $('<tr>').appendTo(tbody);
		$('<td>').addClass('text-center').css('border-top', '1px solid #e5e5e5').html(output[i]['code']).appendTo(tr);
		$('<td>').addClass('text-center').css('border-top', '1px solid #e5e5e5').html('$' + output[i]['premium'].toLocaleString()).appendTo(tr);
		$('<td>').addClass('text-center').css('border-top', '1px solid #e5e5e5').html('$' + Math.floor(commission_premium * 1.25 * 0.65 / 2).toLocaleString()).appendTo(tr);
	}
	var wrapper = $('<div>').append(table);
	return wrapper.html();
}
</script>
