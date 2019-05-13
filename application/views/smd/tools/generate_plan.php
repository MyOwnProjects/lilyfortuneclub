<style>
#query-result thead{font-weight:bold}
.form-group{padding:5px}
.block-plan-template{display:none}
.block-plan{border-top:1px solid #d5d5d5;padding-top:10px;margin-top:10px}
label{font-weight:normal}
a.btn{color:#fff !important}
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
	<input type="hidden" name="action" value="">
	<div class="form-group form-group-sm">
		<label>Age</label>&nbsp;<input type="number" class="form-control" min="20" max="100" name="case-age" value="<?php echo isset($content) && $content['case_age'] ? $content['case_age'] : ''?>" required>
	</div>
	<div class="form-group form-group-sm">
		<label>Gender</label>&nbsp;
		<select class="form-control" name="case-gender">
			<option value="F">Female</option>
			<option value="M" <?php echo isset($content) && $content['case_gender'] == 'M' ? 'selected' : ''?>>Male</option>
		</select>
	</div>
	&nbsp;&nbsp;
	<div class="form-group form-group-sm">
		<label>Face Amount</label>&nbsp;
		<select class="form-control" name="face-amount">
			<?php
			$face_amount = $content['face_amount'];
			$fas = array(200000,250000,300000,400000,500000,750000,1000000,1500000,2000000,2500000,3000000,3500000
				,4000000,4500000);
			foreach($fas as $fa){
			?>
			<option value="<?php echo $fa;?>" <?php echo isset($face_amount) ? ($face_amount == $fa ? 'selected' : '') : ($fa == 1000000 ? 'selected' : '');?>>
				<?php echo custom_number_format($fa);?>
			</option>
			<?php
			}
			?>
		</select>
	</div>
	<div class="form-group form-group-sm">
		<label>For</label>&nbsp;
		<select class="form-control" name="case-for">
			<option value="0" <?php echo !isset($content) || array_key_exists('case_for', $content) || $content['case_for'] == 0 ? 'selected' : ''?>>其它</option>
			<option value="1" <?php echo isset($content) && !array_key_exists('case_for', $content) && $content['case_for'] == 1 ? 'selected' : ''?>>新京集团</option>
		</select>
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
			$plan_types = $content['plan_types'];
			foreach($content['plan_data'] as $i => $pd){
		?>
		<div class="block-plan clear">
			<div style="float:left;padding-right:20px">
				<div class="form-group form-group-sm">
				<a title="Remove the plan" class="btn btn-xs btn-danger" onclick="remove_plan(this);">
					<i class="fa fa-trash" aria-hidden="true"></i>
				</a>
				</div>
			</div>
			<div style="float:left;padding-right:20px">
				<div class="form-group form-group-sm">
					<select name="plan-type[]" class="form-control">
						<option value="0" <?php echo $plan_types[$i] == '0' ? 'selected' : '';?>>5 years 7 pay</option>
						<option value="1" <?php echo $plan_types[$i] == '1' ? 'selected' : '';?>>5 years 7 pay alternitive</option>
						<option value="2" <?php echo $plan_types[$i] == '2' ? 'selected' : '';?>>target</option>
						<option value="3" <?php echo $plan_types[$i] == '3' ? 'selected' : '';?>>5 years 7 pay cash out</option>
						<option value="4" <?php echo $plan_types[$i] == '4' ? 'selected' : '';?>>5 years 7 pay alternitive cash out</option>
					</select>
				</div>
			</div>
			<div style="overflow:hidden;">
				<div class="form-group form-group-sm">
					<textarea style="height:130px;width:500px" name="plan-data[]" class="form-control" placeholder="Quote"><?php echo $pd;?></textarea>
				</div>		
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
			<i class="fa fa-trash" aria-hidden="true"></i>
		</a>
		</div>
	</div>
	<div style="float:left;padding-right:20px">
		<div class="form-group form-group-sm">
			<select name="plan-type[]" class="form-control">
				<option value="0">5 years 7 pay</option>
				<option value="1">5 years 7 pay alternitive</option>
				<option value="2">target</option>
				<option value="3">5 years 7 pay cash out</option>
				<option value="4">5 years 7 pay alternitive cash out</option>
			</select>
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
