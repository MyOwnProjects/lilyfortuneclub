<style>
.nav-tabs>li:not(:last-child){width:33%}
.nav-tabs>li:last-child{width:34%}
.tab-content{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.setting-body .form-group label{overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
.table-report table{margin-right:40px}
.table-report td{font-size:12px;border:1px solid #5cb85c}
.table-report thead{background:linear-gradient(darkgreen, #5cb85c)}
.table-report thead tr:first-child td{font-weight:bold;font-size:16px}
.table-report thead td{text-align:center;padding:5px;color:#fff;border-top:1px solid white}
.table-report thead tr:not(:last-child) td{border-bottom:1px solid white}
.table-report thead td:not(:last-child){border-right:1px solid white;}
.table-report tbody td{padding:2px 5px}
.table-report tbody td.editable{padding:0 !important;position:relative;background:#e8e8e8}
.table-report tbody td.editable .text-back{line-height:20px;position:absolute;right:5px;top:0;z-index:10}
.table-report tbody td.editable input{z-index:1;text-align:right;border:0 !important;padding:2px 5px !important;margin-right:15px;box-sizing:border-box}
.table-report tbody td.editable input.input-amount{width:70px}
.table-report tbody td.editable input.input-percent{width:45px}
.table-report tbody tr:not(.button) td:first-child{text-align:center}
.table-report tbody tr td:not(:first-child){text-align:right}
.table-report tbody tr.highlight td{color:#ff0000}
.table-report tbody tr td.disabled{color:#a5a5a5;text-decoration:line-through}
.table-report tbody tr td:nth-child(2),.table-report tbody tr td:last-child{font-weight:bold} 
@media only screen and (max-width:768px) {
.tab-content{padding:20px 10px}
.main-content-wrapper{padding:20px 0}
</style>
<div class="main-content-wrapper">
	<div class="row" style="margin-bottom:20px">
		<h2 class="text-center">Tools</h2>
	</div>
	
	<ul class="nav nav-tabs" id="top-tab">
		<li class="active"><a data-toggle="tab" href="#illustration-page">Illustration</a></li>
		<li><a data-toggle="tab" href="#invitation-page">Invitation</a></li>
		<li><a data-toggle="tab" href="#field-training-page">Field Training</a></li>
	</ul>
	<div id="tab-content-pages" class="tab-content">
		<div id="illustration-page" class="tab-pane fade in active tab-content-page">
			<form id="illustration-form" method="POST" action="<?php echo base_url();?>account/tools/illustration_export" target="_blank" onsubmit1="return false;">
				<div class="panel panel-primary">
					<div class="panel-heading">Setting</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>Start/Current age</label>
										<select class="submit-field form-control input-sm" name="current-age" id="current-age">
											<?php 
											for($i = 20; $i <= 80; ++$i){
											?>
												<option value="<?php echo $i;?>" <?php echo $i == 56 ? 'selected' : ''?>><?php echo $i;?></option>
											<?php
											}
											?>	
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>LTC start age</label>
										<select class="submit-field form-control input-sm" name="ltc-age-start" id="ltc-age-start">
											<?php 
											for($i = 20; $i <= 100; ++$i){
											?>
												<option value="<?php echo $i;?>" <?php echo $i == 66 ? 'selected' : '';?>><?php echo $i;?></option>
											<?php
											}
											?>	
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>LTC last years</label>
										<select class="submit-field form-control input-sm" name="ltc-years" id="ltc-years">
											<?php 
											for($i = 1; $i <= 80; ++$i){
											?>
												<option value="<?php echo $i;?>" <?php echo $i == 4 ? 'selected' : '';?>><?php echo $i;?></option>
											<?php
											}
											?>	
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>Current living expense</label>
										<input type="number" class="submit-field form-control input-sm" name="withdraw-living" id="withdraw-living" value="36000">
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>Current LTC expense</label>
										<input type="number" class="submit-field form-control input-sm" name="withdraw-ltc" id="withdraw-ltc" value="130000">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<a href="#advanced-settings" data-toggle="collapse">Advanced settings</a>
								</div>
							</div>
							<div class="row collapse setting-body" id="advanced-settings">
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>End age</label>
										<select class="submit-field form-control input-sm" name="end-age" id="end-age">
											<?php 
											for($i = 60; $i <= 120; ++$i){
											?>
												<option value="<?php echo $i;?>" <?php echo $i == 100 ? 'selected' : ''?>><?php echo $i;?></option>
											<?php
											}
											?>	
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>Annual inflation</label>
										<div class="clearfix">
											<div class="pull-right" style="line-height:30px">%</div><div style="overflow:hidden"><input type="number" class="submit-field form-control input-sm" min="0" max="20" name="inflation" id="inflation" value="3.5"></div>
										</div>
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>Retirement age</label>
										<select class="submit-field form-control input-sm" name="retirement-age" id="retirement-age">
											<?php 
											for($i = 60; $i <= 70; ++$i){
											?>
												<option value="<?php echo $i;?>" <?php echo $i == 66 ? 'selected' : ''?>><?php echo $i;?></option>
											<?php
											}
											?>	
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>First year S&P 500</label>
										<select class="submit-field form-control input-sm" name="interest-year-start" id="interest-year-start">
										<?php 
										foreach($interest_history as $year => $rate){
										?>
											<option value="<?php echo $year;?>" <?php echo $year == 2000 ? 'selected' : ''?>><?php echo $year.': '.$rate.'%';?></option>
										<?php
										}
										?>	
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>Loop year S&P 500</label>
										<select class="submit-field form-control input-sm" name="loop-year-start" id="loop-year-start">
										<?php 
										foreach($interest_history as $year => $rate){
										?>
											<option value="<?php echo $year;?>" <?php echo $year == 2000 ? 'selected' : ''?>><?php echo $year.': '.$rate.'%';?></option>
										<?php
										}
										?>	
										</select>
									</div>
								</div>
									<div class="col-xs-12 report-notes">
										<h5>Notes</h5>
										<ul>
											<li>Living expense and LTC expense have a percentage inflation per year.</li>
											<li>Suppose no deposit after retirement.</li>
											<li>Living withdraw starts only after retirement starts.</li>
										</ul>
									</div>
							</div>
						</div>
						</div>
						<div style="padding-bottom:10px">
							<button type="button" class="btn btn-sm btn-primary" onclick="illustration_report();">Recap</button>
							&nbsp;&nbsp;
							<button type="button" class="btn btn-sm btn-success" onclick="illustration_export();">Export</button>
						</div>
						<div class="table-report">
							<table border="1" cellspacing="0" cellpadding="0" id="table-illustration">
								<thead>
									<tr>
										<td rowspan="2">Age</td>
										<td colspan="4">Year Begin Balance</td>
										<td colspan="3">Deposit to Account</td>
										<td colspan="2">Gain Interest</td>
										<td colspan="2">Investment </td>
										<td colspan="2">Income</td>
										<td colspan="2">Expenses</td>
										<td colspan="4">Year End Balance</td>
									</tr>
									<tr>
										<td>Total</td>
										<td>Tax Now</td>
										<td>Tax Defer</td>
										<td>Tax Free</td>
										<td>Now</td>
										<td>Defer</td>
										<td>Free</td>
										<td>Historical<br/>Interest</td>
										<td>Applied<br/>Interest</td>
										<td>Tax Rate</td>
										<td>Tax Amount</td>
										<td>Tax Rate</td>
										<td>Tax Amount</td>
										<td>Living</td>
										<td>LTC</td>
										<td>Tax Now</td>
										<td>Tax Defer</td>
										<td>Tax Free</td>
										<td>Total</td>
									<tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<div style="padding:10px 0">
							<button type="button" class="btn btn-sm btn-primary" onclick="illustration_report();">Recap</button>
							&nbsp;&nbsp;
							<button type="button" class="btn btn-sm btn-success" onclick="illustration_export();">Export</button>
						</div>
				
			</form>
		</div>

		<div id="invitation-page" class="tab-pane fade tab-content-page">
		</div>
		
		<div id="field-training-page" class="tab-pane fade tab-content-page">
		</div>		
				
	</div>
</div>
<script>
var post_data = {};
function illustration_post(data){
	ajax_loading(true);
	var tbody = $('.table-report tbody');
	tbody.empty();
	$.ajax({
		url: '<?php echo base_url();?>account/tools/illustration_report',
		method: 'post',
		data: data,
		dataType: 'json',
		success: function(resp){
			if(resp['error']){
				var tr = $('<tr>').appendTo(tbody);
				tr.append('<td colspan="18" style="text-align:center">' + resp['error'] + '</td>');
				return false;
			}
			$('#setting-body').collapse("hide");
			post_data = resp['post'];
			for(var age in resp){
				var data = resp[age];
				var tr = $('<tr>').attr('data-id', age).appendTo(tbody);
				if(data['balance-total-end'][0] == '-'){
					tr.addClass('highlight');
				}
				tr.append('<td>' + age + '</td>');
				tr.append('<td>' + parseInt(data['balance-total-begin']).toLocaleString() + '</td>')
					.append('<td>' + parseInt(data['balance-now-begin']).toLocaleString() + '</td>')
					.append('<td>' + parseInt(data['balance-defer-begin']).toLocaleString() + '</td>')
					.append('<td>' + parseInt(data['balance-free-begin']).toLocaleString() + '</td>');
				
				var input = $('<input>').attr('name', 'deposit-tax-now[]').addClass('deposit-tax-now').addClass('input-amount').val(parseInt(data['deposit-tax-now']).toLocaleString());
				var back_amount = $('<div>$</div>').addClass('text-back');
				var td11 = $('<td>').css('width', '70px').addClass('editable').append(input).append(back_amount.clone()).appendTo(tr);
				var input = $('<input>').attr('name', 'deposit-tax-defer[]').addClass('deposit-tax-defer').addClass('input-amount').val(parseInt(data['deposit-tax-defer']).toLocaleString());
				var td12 = $('<td>').css('width', '70px').addClass('editable').append(input).append(back_amount.clone()).appendTo(tr);
				var input = $('<input>').attr('name', 'deposit-tax-free[]').addClass('deposit-tax-free').addClass('input-amount').val(parseInt(data['deposit-tax-free']).toLocaleString());
				var td13 = $('<td>').css('width', '70px').addClass('editable').append(input).append(back_amount.clone()).appendTo(tr);
				var td1 = $('<td>').html(parseFloat(data['historical-interest']).toFixed(2).toLocaleString() + '%').appendTo(tr);
				var back_percent = $('<div>%</div>').addClass('text-back');
				var input = $('<input>').attr('name', 'applied-interest[]').addClass('applied-interest').addClass('input-percent');
				var td2 = $('<td>').css('width', '70px').addClass('editable').append(back_percent.clone()).append(input).appendTo(tr);
				var applied_interest = parseFloat(data['applied-interest']).toFixed(2);
				if(!isNaN(applied_interest)){
					td1.addClass('disabled');
					input.val(applied_interest.toLocaleString());
				}
				var back_percent = $('<div>%</div>').addClass('text-back');
				input = $('<input>').attr('name', 'tax-rate-investment[]').addClass('tax-rate-investment').addClass('input-percent').val(parseFloat(data['tax-rate-investment']).toFixed(2).toLocaleString());
				var td3 = $('<td>').css('width', '70px').addClass('editable').append(input).append(back_percent.clone()).appendTo(tr);
				tr.append('<td>' + parseInt(data['tax-amount-investment']).toLocaleString() + '</td>');
				input = $('<input>').attr('name', 'tax-rate-income[]').addClass('tax-rate-income').addClass('input-percent').val(parseFloat(data['tax-rate-income']).toFixed(2).toLocaleString());
				var td4 = $('<td>').css('width', '70px').addClass('editable').append(input).append(back_percent.clone()).appendTo(tr);
				tr.append('<td>' + parseInt(data['tax-amount-income']).toLocaleString() + '</td>');
				tr.append('<td>' + parseInt(data['withdraw-living']).toLocaleString() + '</td>')
					.append('<td>' + parseInt(data['withdraw-ltc']).toLocaleString() + '</td>')
					.append('<td>' + parseInt(data['balance-now-end']).toLocaleString() + '</td>')
					.append('<td>' + parseInt(data['balance-defer-end']).toLocaleString() + '</td>')
					.append('<td>' + parseInt(data['balance-free-end']).toLocaleString() + '</td>');
				var fv = parseInt(data['balance-total-end']);
				tr.append('<td>' + fv.toLocaleString() + '</td>');
				if(fv < 0){
					tr.addClass('highlight');
				}
			}
			tbody.find('.editable input').attr('title', 'Double click to change whole column.');
		},
		error: function(){
		},
		complete: function(){
			ajax_loading(false);
		}
	});
}

function illustration_data(){
	var data = {
		'tax-rate-income': [], 'tax-rate-investment': [],
		'applied-interest': [], 'deposit-tax-free': [], 
		'deposit-tax-defer': [], 'deposit-tax-now': []
	};
	$('#table-illustration tbody tr').each(function(index, obj){
		var tr = $(obj);
		var age = parseInt(tr.attr('data-id'));
		data['tax-rate-income'].push(tr.find('.tax-rate-income').val()); 
		data['tax-rate-investment'].push(tr.find('.tax-rate-investment').val()); 
		data['applied-interest'].push(tr.find('.applied-interest').val()); 
		data['deposit-tax-free'].push(tr.find('.deposit-tax-free').val()); 
		data['deposit-tax-defer'].push(tr.find('.deposit-tax-defer').val()); 
		data['deposit-tax-now'].push(tr.find('.deposit-tax-now').val()); 
	});
	$('#illustration-form .submit-field').each(function(index, obj){
		data[$(obj).attr('id')] = $(obj).val();
	});
	return data;
}

function illustration_report(){
	var data = illustration_data();
	$('#illustration-form .submit-field').each(function(index, obj){
		data[$(obj).attr('id')] = $(obj).val();
	});	
	illustration_post(data);
	return false;
}

function illustration_export(){
	$('#illustration-form').submit();
	$('#illustration-form').prop('onsubmit', 'return false');
}

$('#table-illustration').delegate('input', 'dblclick', function(){
	var input = $(this);
	bootbox.prompt({
		title: "Apply the value to all in this column",
		inputType: 'number',
		value: input.val(),
		callback: function (result) {
			console.log(result);
		},
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Apply',
				className: 'btn-danger'
			}
		},
		callback: function (result) {
			if(result === null){
				return;
			}	
			var col_index = input.parent().parent().children('td').index(input.parent()) + 1;
			$('#table-illustration tbody tr').each(function(index, tr){
				$(tr).children('td:nth-child('+ col_index + ')').children('input').val(result);
			});
		}
	});
}).delegate('input', 'click', function(){
	this.select();
	this.setSelectionRange(0, $(this).val().length);
});

$(document).ready(function(){
	illustration_report();	
});
</script>