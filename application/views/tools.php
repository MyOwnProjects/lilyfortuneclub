<style>
.tab-content-page{padding:40px 80px}
.content-page-head{text-align:center;margin-bottom:40px}
.setting-body .form-group label{overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
.table-report td{font-size:12px;}
.table-report thead{background:linear-gradient(darkgreen, #5cb85c);border-bottom:1px solid darkgreen}
.table-report thead td{border:1px solid #fff;color:#fff;text-align:center;padding:5px}
.table-report tbody td{border:1px solid #a5a5a5;padding:2px 5px}
.table-report tbody td.editable{border:1px solid #a5a5a5;padding:0 !important;position:relative;background:#e8e8e8}
.table-report tbody td.editable .text-back{line-height:20px;position:absolute;right:5px;top:0;z-index:10}
.table-report tbody td.editable input{z-index:1;text-align:right;border:0 !important;padding:2px 5px !important;margin-right:15px;box-sizing:border-box}
.table-report tbody td.editable input.input-amount{width:70px}
.table-report tbody td.editable input.input-percent{width:45px}
.table-report tbody tr:not(.button) td:first-child{text-align:center}
.table-report tbody tr td:not(:first-child){text-align:right}
.table-report tbody tr.highlight td{color:#ff0000}
.table-report tbody tr td.disabled{color:#a5a5a5;text-decoration:line-through}
.table-report tbody tr td:nth-child(2),.table-report tbody tr td:last-child{font-weight:bold} 
</style>
	<ul class="breadcrumb" style="border-bottom:1px solid #d5d5d5">
		<li><a href="<?php echo base_url();?>account">Account</a></li>
		<li>Tools</li>
	</ul>
<div style="margin:0 auto;padding:20px 40px 80px 40px;">
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
			<div class="panel panel-primary">
				<div class="panel-heading">Setting</div>
					<div class="panel-body">
						<form id="illustration-form">
							<div class="row">
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>Start/Current age</label>
										<select class="submit-field form-control input-sm" id="current-age">
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
										<select class="submit-field form-control input-sm" id="ltc-age-start">
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
										<select class="submit-field form-control input-sm" id="ltc-years">
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
										<input type="number" class="submit-field form-control input-sm" id="withdraw-living" value="36000">
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>Current LTC expense</label>
										<input type="number" class="submit-field form-control input-sm" id="withdraw-ltc" value="130000">
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
										<select class="submit-field form-control input-sm" id="end-age">
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
											<div class="pull-right" style="line-height:30px">%</div><div style="overflow:hidden"><input type="number" class="submit-field form-control input-sm" min="0" max="20" id="inflation" value="3.5"></div>
										</div>
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-3 col-sx-6">
									<div class="form-group">
										<label>Retirement age</label>
										<select class="submit-field form-control input-sm" id="retirement-age">
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
										<select class="submit-field form-control input-sm" id="interest-year-start">
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
										<select class="submit-field form-control input-sm" id="loop-year-start">
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
							</div>
					</form>
			<div style="padding-top:10px">
				<button type="button" class="btn btn-sm btn-primary" onclick="illustration_submit();">Go</button>
			</div>
			</div>
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
			<div class="report-notes">
				<h5>Notes</h5>
				<ul>
					<li>Living withdraw and LTC withdraw have an percentage inflation per year.</li>
					<li>Suppose no deposit after retirement age.</li>
					<li>Living withdraw started only after retirement starts.</li>
				</ul>
			</div>
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
				
				var input = $('<input>').addClass('deposit-tax-now').addClass('input-amount').val(parseInt(data['deposit-tax-now']).toLocaleString());
				var back_amount = $('<div>$</div>').addClass('text-back');
				var td11 = $('<td>').css('width', '70px').addClass('editable').append(input).append(back_amount.clone()).appendTo(tr);
				var input = $('<input>').addClass('deposit-tax-defer').addClass('input-amount').val(parseInt(data['deposit-tax-defer']).toLocaleString());
				var td12 = $('<td>').css('width', '70px').addClass('editable').append(input).append(back_amount.clone()).appendTo(tr);
				var input = $('<input>').addClass('deposit-tax-free').addClass('input-amount').val(parseInt(data['deposit-tax-free']).toLocaleString());
				var td13 = $('<td>').css('width', '70px').addClass('editable').append(input).append(back_amount.clone()).appendTo(tr);
				var td1 = $('<td>').html(parseFloat(data['historical-interest']).toFixed(2).toLocaleString() + '%').appendTo(tr);
				var back_percent = $('<div>%</div>').addClass('text-back');
				var input = $('<input>').addClass('applied-interest').addClass('input-percent');
				var td2 = $('<td>').css('width', '70px').addClass('editable').append(back_percent.clone()).append(input).appendTo(tr);
				var applied_interest = parseFloat(data['applied-interest']).toFixed(2);
				if(!isNaN(applied_interest)){
					td1.addClass('disabled');
					input.val(applied_interest.toLocaleString());
				}
				var back_percent = $('<div>%</div>').addClass('text-back');
				input = $('<input>').addClass('tax-rate-investment').addClass('input-percent').val(parseFloat(data['tax-rate-investment']).toFixed(2).toLocaleString());
				var td3 = $('<td>').css('width', '70px').addClass('editable').append(input).append(back_percent.clone()).appendTo(tr);
				tr.append('<td>' + parseInt(data['tax-amount-investment']).toLocaleString() + '</td>');
				input = $('<input>').addClass('tax-rate-income').addClass('input-percent').val(parseFloat(data['tax-rate-income']).toFixed(2).toLocaleString());
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
			
		},
		error: function(){
		},
		complete: function(){
			ajax_loading(false);
		}
	});
}

function illustration_submit(){
	var data = {
		flexible: {}
	};
	$('#table-illustration tbody tr').each(function(index, obj){
		var tr = $(obj);
		var age = parseInt(tr.attr('data-id'));
		data['flexible'][age] = {
			'tax-rate-income': tr.find('.tax-rate-income').val(), 'tax-rate-investment': tr.find('.tax-rate-investment').val(),
			'applied-interest': tr.find('.applied-interest').val(), 'deposit-tax-free': tr.find('.deposit-tax-free').val(), 
			'deposit-tax-defer': tr.find('.deposit-tax-defer').val(), 'deposit-tax-now': tr.find('.deposit-tax-now').val()
		};
	});
	$('#illustration-form .submit-field').each(function(index, obj){
		data[$(obj).attr('id')] = $(obj).val();
	});	
	illustration_post(data);
}

$('#table-illustration').delegate('input', 'dblclick', function(){
	var input = $(this);
	bootbox.confirm({
		title: "Confirmation?",
		message: "Do you want to apply this value (" + input.val() + ") to all in the this column?",
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Cancel'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Yes',
				className: 'btn-danger'
			}
		},
		callback: function (result) {
			if(result){
				var col_index = input.parent().parent().children('td').index(input.parent()) + 1;
				$('#table-illustration tbody tr').each(function(index, tr){
					$(tr).children('td:nth-child('+ col_index + ')').children('input').val(input.val());
				});
			}
		}
	});
}).delegate('input', 'click', function(){
	this.select();
	this.setSelectionRange(0, $(this).val().length);
});

$(document).ready(function(){
illustration_submit();	
});
</script>