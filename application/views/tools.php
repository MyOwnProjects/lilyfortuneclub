<style>
.tab-content-page{padding:40px 80px}
.content-page-head{text-align:center;margin-bottom:40px}
.table-report{border:1px solid darkgreen;overflow-x:auto}
.table-report table{width:100%;}
.table-report td{font-size:12px;}
.table-report thead{background:linear-gradient(darkgreen, #5cb85c)}
.table-report thead td{border:1px solid #fff;color:#fff;text-align:center;padding:5px}
.table-report tbody td{border:1px solid #e5e5e5;padding:5px}
.table-report tbody tr td:not(:first-child){text-align:right}
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
				<div class="panel-heading">Setting<div class="pull-right">[<a href="#setting-body" data-toggle="collapse" style="color:#fff">+/-</a>]</div></div>
				<div class="panel-body collapse in" id="setting-body">
			<form id="illustration-form">
					<fieldset>
						<legend>Rate</legend>
							<div class="row">
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>First year of interest</label> <span class="glyphicon glyphicon-info-sign"></span>
										<select class="submit-field form-control input-sm" id="interest-year-start">
										<?php 
										foreach($interest_history as $year => $rate){
										?>
											<option value="<?php echo $year;?>"><?php echo $year.': '.$rate.'%';?></option>
										<?php
										}
										?>	
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Investment Tax</label>
										<select class="submit-field form-control input-sm" id="tax-investment">
										<?php 
										for($i = 5; $i <= 100; $i += 5){
										?>
											<option value="<?php echo $i;?>" <?php echo $i == 20 ? 'selected' : '';?>><?php echo $i;?>%</option>
										<?php
										}
										?>	
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Income Tax</label>
										<select class="submit-field form-control input-sm" id="tax-income">
										<?php 
										for($i = 5; $i <= 100; $i += 5){
										?>
											<option value="<?php echo $i;?>" <?php echo $i == 30 ? 'selected' : '';?>><?php echo $i;?>%</option>
										<?php
										}
										?>	
										</select>
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Annual inflation</label>
										<select class="submit-field form-control input-sm" id="inflation">
										<?php 
										for($i = 1; $i <= 100; $i++){
										?>
											<option value="<?php echo $i;?>" <?php echo $i == 4 ? 'selected' : ''?>><?php echo $i;?>%</option>
										<?php
										}
										?>	
										</select>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Year</legend>
							<div class="row">
								<div class="col-lg-2 col-md-3 col-sm-3">
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
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>End age</label>
										<select class="submit-field form-control input-sm" id="end-age">
											<?php 
											for($i = 20; $i <= 120; ++$i){
											?>
												<option value="<?php echo $i;?>" <?php echo $i == 70 ? 'selected' : ''?>><?php echo $i;?></option>
											<?php
											}
											?>	
										</select>
									</div>
								</div>								
								<div class="col-lg-2 col-md-3 col-sm-3">
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
								<div class="col-lg-2 col-md-3 col-sm-3">
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
								<div class="col-lg-2 col-md-3 col-sm-3">
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
							</div>
						</fieldset>
						<fieldset>
							<legend>Current Balance</legend>
							<div class="row">
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Tax-now account</label>
										<input type="number" class="submit-field form-control input-sm" id="balance-tax-now" value="1500000">
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Tax-defer account</label>
										<input type="number" class="submit-field form-control input-sm" id="balance-tax-defer" value="200000">
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Tax-free account</label>
										<input type="number" class="submit-field form-control input-sm" id="balance-tax-free" value="0">
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Annual Deposit and Withdraw</legend>
							<div class="row">
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Deposit to tax-now</label>
										<input type="number" class="submit-field form-control input-sm" id="deposit-tax-now" value="0">
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Deposit to tax-defer</label>
										<input type="number" class="submit-field form-control input-sm" id="deposit-tax-defer" value="0">
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Deposit to tax-free</label>
										<input type="number" class="submit-field form-control input-sm" id="deposit-tax-free" value="0">
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Withdraw living</label>
										<input type="number" class="submit-field form-control input-sm" id="withdraw-living" value="36000">
									</div>
								</div>
								<div class="col-lg-2 col-md-3 col-sm-3">
									<div class="form-group">
										<label>Withdraw LTC</label>
										<input type="number" class="submit-field form-control input-sm" id="withdraw-ltc" value="190000">
									</div>
								</div>
							</div>
						</fieldset>
				</form>
			<div style="padding-top:10px">
				<button type="button" class="btn btn-sm btn-primary" onclick="illustration_submit();">Go</button>
			</div>
			</div>
			</div>
			<div class="table-report">
				<table border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<td rowspan="2">Age</td>
							<td colspan="4">Year Begin Balance</td>
							<td colspan="3">Deposit</td>
							<td rowspan="2">Interest</td>
							<td colspan="2">Tax</td>
							<td colspan="2">Withdraw</td>
							<td colspan="4">Year End Balance</td>
						</tr>
						<tr>
							<td>Total</td>
							<td>Tax Now</td>
							<td>Tax Defer</td>
							<td>Tax Free</td>
							<td>Tax Now</td>
							<td>Tax Defer</td>
							<td>Tax Free</td>
							<td>Invest</td>
							<td>Income</td>
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
					<li>Living withdraw has 4% of inflation per year.</li>
					<li>Suppose no deposit after retirement.</li>
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
function illustration_submit(){
	ajax_loading(true);
	var tbody = $('.table-report tbody');
	tbody.empty();
	var data = {};
	$('#illustration-form .submit-field').each(function(index, obj){
		data[$(obj).attr('id')] = $(obj).val();
	});	
	$.ajax({
		url: '<?php echo base_url();?>account/tools/illustration_report',
		method: 'post',
		data: data,
		dataType: 'json',
		success: function(data){
			for(var i = 0; i < data.length; ++i){
				var tr = $('<tr>').appendTo(tbody);
				for(var j = 0; j < data[i].length; ++j){
					tr.append('<td>' + data[i][j] + '</td>');
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
</script>