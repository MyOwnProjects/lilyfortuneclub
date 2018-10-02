<style>
.main-content-wrapper{max-width:1000px !important}
.group-head{background:#00004d;margin-top:10px;color:#fff;padding:10px 0 10px 20px;font-weight:bold;}
.group{margin:10px 0}
.group-label{font-weight:bold;float:left;width:122px;margin-right:10px;text-align:right}
.group-label:after{content:":"}
.group-value{overflow:hidden;word-wrap: break-word}
.empty{color:#d5d5d5}
</style>
<div class="main-content-wrapper"> 
	<h2 class="text-center">Sales Case</h2>
	<div class="row">
		<div class="col-lg-12 clearfix">
			<span class="pull-left">&nbsp;&nbsp;</span>
			<a class="pull-left" style="margin-top:20px" href="<?php echo base_url();?>account/sales">Back to List</a>
			<span class="pull-right">&nbsp;&nbsp;</span>
			<a href="#" class="pull-right btn btn-primary btn-ms"><span class="glyphicon glyphicon-paperclip"></span>&nbsp;Upload</a>
			<span class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<a class="pull-right btn btn-primary btn-ms" href="<?php echo base_url();?>account/sales/sales_case/<?php echo $sale['sales_id'];?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit</a>
		</div>
		<div class="col-lg-12 group-head">General</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="group clearfix">
				<div class="group-label">Priority</div>
				<div class="group-value">
					<?php 
					echo ($sale['sales_priority'] > 0 ? '<span class="label label-danger">High</span>' : ($sale['sales_priority'] == 0 ? '<span class="label label-warning">Medium</span>' : '<span class="label label-success">Low</span>'))
					?>
				</div>
			</div>
			<div class="group clearfix">
				<div class="group-label">Priority Note</div>
				<div class="group-value"><?php echo str_replace("\n", '<br/>', $sale['sales_priority_note']);?></div>
			</div>
			<div class="group clearfix">
				<div class="group-label">Status</div>
				<?php
				$status_list = array(
					'P' => '<span class="text-danger">Pending</span>', 
					'I' => '<span class="text-success">Inforced</span>', 
					'C' => '<span class="text-muted">Closed</span>', 
					'CA' => '<span class="text-muted">Canceled</span>'
				);
				?>
				<div class="group-value"><?php echo $status_list[$sale['sales_status']];?></div>
			</div>
		</div>	
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="group clearfix">
				<div class="group-label">Policy NO</div>
				<div class="group-value"><?php echo $sale['sales_policy_no'];?></div>
			</div>
			<div class="group clearfix">
				<div class="group-label">Policy Type</div>
				<?php 
				$type_list = array(
					'IL' => 'IUL + LTC',
					'I' => 'IUL',
					'A' => 'Annuity',
					'T' => 'Term',
				);
				?>
				<div class="group-value"><?php echo $sale['sales_provider'].' - '.$type_list[$sale['sales_policy_type']];?></div>	
			</div>
			<div class="group clearfix">
				<div class="group-label">Submission</div>
				<div class="group-value"><?php echo $sale['sales_date_submission'];?></div>	
			</div>
			<div class="group clearfix">
				<div class="group-label">Closure</div>
				<div class="group-value"><?php echo $sale['sales_date_closure'];?></div>	
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="group clearfix">
				<div class="group-label">Face AMT</div>
				<div class="group-value"><?php echo '$'.number_to_english($sale['sales_face_amount']);?></div>	
			</div>
			<div class="group clearfix">
				<div class="group-label">Target PREM</div>
				<div class="group-value"><?php echo isset($sale['sales_target_premium']) ? '$'.number_format(intval($sale['sales_target_premium']), 0) : '';?></div>	
			</div>
			<div class="group clearfix">
				<div class="group-label">Initial PREM</div>
				<div class="group-value"><?php echo isset($sale['sales_initial_premium']) ? '$'.number_format(intval($sale['sales_initial_premium']), 0) : '';?></div>	
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 group-head">Contact</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-6 col-xs-12">
			<?php
			$n = array('Insured' => 'insured', 'Owner' => 'owner');//, 'primary_beneficiary', 
				//'contingent_beneficiary_1', 'contingent_beneficiary_3', 'contingent_beneficiary_3');
			foreach($n as $k => $v){
			?>
			<div class="group clearfix">
				<div class="group-label"><?php echo $k;?></div>
				<div class="group-value">
					<span class="<?php echo empty($sale['sales_'.$v]) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v]) ? 'Name' : $sale['sales_'.$v];?></span><br/>
					<span class="<?php echo empty($sale['sales_'.$v.'_dob']) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v.'_dob']) ? 'Date of Birth' : $sale['sales_'.$v.'_dob'];?></span><br/>
					<span class="<?php echo empty($sale['sales_'.$v.'_phone']) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v.'_phone']) ? 'Phone' : $sale['sales_'.$v.'_phone'];?></span><br/>
					<span class="<?php echo empty($sale['sales_'.$v.'_email']) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v.'_email']) ? 'Email' : $sale['sales_'.$v.'_email'];?></span><br/>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<?php
			$n = array('Payor' => 'payor', 'PRI BENEF' => 'primary_beneficiary');
			foreach($n as $k => $v){
			?>
			<div class="group clearfix">
				<div class="group-label"><?php echo $k;?></div>
				<div class="group-value">
					<span class="<?php echo empty($sale['sales_'.$v]) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v]) ? 'Name' : $sale['sales_'.$v];?></span><br/>
					<span class="<?php echo empty($sale['sales_'.$v.'_dob']) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v.'_dob']) ? 'Date of Birth' : $sale['sales_'.$v.'_dob'];?></span><br/>
					<span class="<?php echo empty($sale['sales_'.$v.'_phone']) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v.'_phone']) ? 'Phone' : $sale['sales_'.$v.'_phone'];?></span><br/>
					<span class="<?php echo empty($sale['sales_'.$v.'_email']) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v.'_email']) ? 'Email' : $sale['sales_'.$v.'_email'];?></span><br/>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<?php
			$n = array('CONTG BENEF 1' => 'contingent_beneficiary_1', 'CONTG BENEF 2' => 'contingent_beneficiary_2');
			foreach($n as $k => $v){
			?>
			<div class="group clearfix">
				<div class="group-label"><?php echo $k;?></div>
				<div class="group-value">
					<span class="<?php echo empty($sale['sales_'.$v]) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v]) ? 'Name' : $sale['sales_'.$v];?></span><br/>
					<span class="<?php echo empty($sale['sales_'.$v.'_dob']) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v.'_dob']) ? 'Date of Birth' : $sale['sales_'.$v.'_dob'];?></span><br/>
					<span class="<?php echo empty($sale['sales_'.$v.'_phone']) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v.'_phone']) ? 'Phone' : $sale['sales_'.$v.'_phone'];?></span><br/>
					<span class="<?php echo empty($sale['sales_'.$v.'_email']) ? 'empty' : '';?>"><?php echo empty($sale['sales_'.$v.'_email']) ? 'Email' : $sale['sales_'.$v.'_email'];?></span><br/>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 group-head">Notes</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="group clearfix">
				<div class="group-value"><?php echo $sale['sales_details'];?></div>	
			</div>
		</div>
	</div>
</div>
