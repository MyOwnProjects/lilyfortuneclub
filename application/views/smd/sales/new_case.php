<style>
fieldset{border:1px solid #858585;border-radius:4px}	
legend{font-weight:bold}
label{font-weight:normal}

.bootstrap-select .btn{padding:0;border:none}

.bootstrap-select .btn-group.open .dropdown-toggle{webkit-box-shadow:none;box-shadow:none}
.bootstrap-select .btn-default:active, .bootstrap-select .btn-default:focus, .bootstrap-select .btn-default:hover, .bootstrap-select .open>.dropdown-toggle.btn-default {background-color:#fff !important;border-color:#fff !important}
</style>
<?php
$user_list = function($users, $sale, $name){
			$ret = array();
			foreach($users as $user){
				array_push($ret, array(
					'text' => $user['text'],
					'value' => $user['value'],
					'selected' => !empty($sale) && $sale[$name] == $user['value']
				));
			}
			return $ret;
};

$general_select = function($list, $name) use($sale){
			$ret = array();
			foreach($list as $k => $v){
				array_push($ret, array('text' => $v, 'value' => $k, 'selected' => !empty($sale) && $sale[$name] == $k));
			}
			return $ret;
};
$fields = array(
	array(
		'sales_writing_agent' => array(
			'label' => 'Writing Agent',
			'tag' => 'select',
			'class' => 'selectpicker',
			'data-live-search' => 'true',
			'options' => $user_list($users, $sale, 'sales_writing_agent'),
		),
		'sales_split_agent' => array(
			'label' => 'Split Agent',
			'tag' => 'select',
			'class' => 'selectpicker',
			'data-live-search' => 'true',
			'options' => $user_list(array_merge(array('-1' => array('text' => 'None', 'value' => '0')), $users), $sale, 'sales_split_agent'),
			'split' => true
		),
		'sales_priority' => array(
			'label' => 'Priority',
			'tag' => 'select',
			'options' => $general_select(array(
				1 => 'High', 0 => 'Medium', -1 => 'Low'
			), 'sales_priority')
		),
		'sales_priority_note' => array(
			'label' => 'Priority Note',
			'tag' => 'textarea',
			'rows' => '4',
			'value'=> empty($sale) ? '': $sale['sales_priority_note']
		),
		'sales_status' => array(
			'label' => 'Status',
			'tag' => 'select',
			'options' => $general_select(array(
				'P' => 'Pending',
				'I' => 'Inforced',
				'C' => 'Closed',
				'CA' => 'Canceled'
			), 'sales_status'),
			'split' => true, 
		),
		'sales_policy_no' => array(
			'label' => 'Policy NO',
			'tag' => 'input',
			'value'=> empty($sale) ? '': $sale['sales_policy_no'],
		),
		'sales_face_amount' => array(
			'label' => 'Face Amount',
			'tag' => 'input',
			'type' => 'number',
			'min' => '0',
			'value' => empty($sale) ? '': $sale['sales_face_amount']
		),
		'sales_provider' => array(
			'label' => 'Provider',
			'tag' => 'select',
			'options' => $general_select(array(
				'Allianz' => 'Allianz', 'Nationwide' => 'Nationwide', 'PacLife' => 'PacLife', 
				'Prudential' => 'Prudential', 'Transamerica' => 'Transamerica', 'Voya' => 'Voya'
			), 'sales_provider')
		),
		'sales_policy_type' => array(
			'label' => 'Policy Type',
			'tag' => 'select',
			'options' => $general_select(array(
					'IL' => 'IUL + LTC', 'I' => 'IUL', 'A' => 'Annuity', 'T' => 'Term'
			), 'sales_policy_type'),
			'split' => true
		),
		'sales_date_submission' => array(
			'label' => 'Submission Date',
			'tag' => 'input',
			'type' => 'date',
			'value' => empty($sale) ? '': $sale['sales_date_submission']
		),
		'sales_date_closure' => array(
			'label' => 'Closure Date',
			'tag' => 'input',
			'type' => 'date',
			'value' => empty($sale) ? '': $sale['sales_date_closure'],
			'split' => true
		),
		'sales_details' => array(
			'label' => 'Notes',
			'tag' => 'textarea',
			'rows' => '40',
			'value' => empty($sale) || empty($sale['sales_details']) ? '': $sale['sales_details']
		)
		
	),
	array_merge(array(
		'sales_insured' => array(
			'label' => 'Insured Name',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_insured']
		),
		'sales_insured_dob' => array(
			'label' => 'Insured DOB',
			'tag' => 'input',
			'type' => 'date',
			'value' => empty($sale) || empty($sale['sales_insured_dob']) ? '': $sale['sales_insured_dob']
		),
		'sales_insured_gender' => array(
			'label' => 'Insured Gender',
			'tag' => 'select',
			'options' => $general_select(array('F' => 'Female', 'M' => 'Male'), 'sales_insured_gender')
		),
		'sales_insured_phone' => array(
			'label' => 'Insured Phone',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_insured_phone']
		),
		'sales_insured_email' => array(
			'label' => 'Insured Email',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_insured_email'],
			'split' => true
		),
		'sales_owner' => array(
			'label' => 'Owner Name',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_owner']
		),
		'sales_owner_dob' => array(
			'label' => 'Owner DOB',
			'tag' => 'input',
			'type' => 'date',
			'value' => empty($sale) || empty($sale['sales_owner_dob']) ? '': $sale['sales_owner_dob']
		),
		'sales_owner_gender' => array(
			'label' => 'Owner Gender',
			'tag' => 'select',
			'options' => $general_select(array('F' => 'Female', 'M' => 'Male'), 'sales_owner_gender')
		),
		'sales_owner_phone' => array(
			'label' => 'Owner Phone',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_owner_phone']
		),
		'sales_owner_email' => array(
			'label' => 'Owner Email',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_owner_email'],
			'split' => true
		),
		'sales_payor' => array(
			'label' => 'Payor Name',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_payor']
		),
		'sales_payor_dob' => array(
			'label' => 'Payor DOB',
			'tag' => 'input',
			'type' => 'date',
			'value' => empty($sale) || empty($sale['sales_payor_dob']) ? '': $sale['sales_payor_dob']
		),
		'sales_payor_gender' => array(
			'label' => 'Payor Gender',
			'tag' => 'select',
			'options' => $general_select(array('F' => 'Female', 'M' => 'Male'), 'sales_payor_gender')
		),
		'sales_payor_phone' => array(
			'label' => 'Payor Phone',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_payor_phone']
		),
		'sales_payor_email' => array(
			'label' => 'Payor Email',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_payor_email'],
			'split' => true
		),
		'sales_primary_beneficiary' => array(
			'label' => 'Primary Beneficiary Name',
			'tag' => 'input',
			'value' => empty($sale) ? '': $sale['sales_primary_beneficiary']
			),
			'sales_primary_beneficiary_dob' => array(
				'label' => 'Primary Beneficiary DOB',
				'tag' => 'input',
				'type' => 'date',
				'value' => empty($sale) || empty($sale['sales_primary_beneficiary_dob']) ? '': $sale['sales_primary_beneficiary_dob']
			),
			'sales_primary_beneficiary_gender' => array(
				'label' => 'Primary Beneficiary Gender',
				'tag' => 'select',
				'options' => $general_select(array('F' => 'Female', 'M' => 'Male'), 'sales_primary_beneficiary_gender')
			),
			'sales_primary_beneficiary_phone' => array(
				'label' => 'Primary Beneficiary Phone',
				'tag' => 'input',
				'value' => empty($sale) ? '': $sale['sales_primary_beneficiary_phone']
			),
			'sales_primary_beneficiary_email' => array(
				'label' => 'Primary Beneficiary Email',
				'tag' => 'input',
				'value' => empty($sale) ? '': $sale['sales_primary_beneficiary_email'],
				'split' => true
			)
		),
		call_user_func(function() use($sale, $general_select){
			$ret = array();
			for($i = 1; $i <= 3; ++$i){
				$ret['sales_contingent_beneficiary_'.$i] = array(
					'split' => true,
					'label' => 'Contingent Beneficiary '.$i.' Name',
						'tag' => 'input',
						'value' => empty($sale) ? '': $sale['sales_contingent_beneficiary_'.$i]
				);
				$ret['sales_contingent_beneficiary_'.$i.'_dob'] = array(
						'label' => 'Contingent Beneficiary '.$i.' DOB',
						'tag' => 'input',
						'type' => 'date',
						'value' => empty($sale) || empty($sale['sales_contingent_beneficiary_'.$i.'_dob']) ? '': $sale['sales_contingent_beneficiary_'.$i.'_dob']
				);
				$ret['sales_contingent_beneficiary_'.$i.'_gender'] = array(
						'label' => 'Contingent Beneficiary '.$i.' Gender',
						'tag' => 'select',
						'options' => $general_select(array('F' => 'Female', 'M' => 'Male'), 'sales_contingent_beneficiary_'.$i.'_gender')
				);
				$ret['sales_contingent_beneficiary_'.$i.'_phone'] = array(
						'label' => 'Contingent Beneficiary '.$i.' Phone',
						'tag' => 'input',
						'value' => empty($sale) ? '': $sale['sales_contingent_beneficiary_'.$i.'_phone']
				);
				$ret['sales_contingent_beneficiary_'.$i.'_email'] = array(
						'label' => 'Contingent Beneficiary '.$i.' Email',
						'tag' => 'input',
						'value' => empty($sale) ? '': $sale['sales_contingent_beneficiary_'.$i.'_email']
				);
			}
			return $ret;
		})
	)
);
?>
<div style="margin:40px"> 
	<h4><?php echo empty($sale) ? 'New Case' : 'Edit Case'?></h4>
	<form method="post"  action="<?php echo base_url();?>smd/sales/sales_case<?php echo empty($sale) ? '' : '/'.$sale['sales_id']; ?>">
		<div style="margin:20px 0 10px 0">
			<input type="submit" value="Submit" class="btn btn-sm btn-primary">
			&nbsp;&nbsp;
			<a href="<?php echo base_url();?>smd/sales">Back to List</a>
		</div>
		<div class="clearfix">
			<?php
			foreach($fields as $field){
				$this->load->view('prop_table', array('field' => $field));
			}
			?>
		</div>
	</form>
	<!--form method="post" style="margin:40px" action="<?php echo base_url();?>smd/sales/sales_case<?php echo empty($sale) ? '' : '/'.$sale['sales_id']; ?>">
		<?php 
		if(isset($error) && $error){
		?>
		<div class="alert alert-danger"><?php echo $error;?></div>
		<?php
		//$case_no, $name, $subject, $detail, $type, $source, $priority, $due_date
		}
		?>
		
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<fieldset>
					<legend>Policy</legend>
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Writing Agent</label>
							<select class="form-control input-sm selectpicker" data-live-search='true' name="sales_writing_agent">
								<?php
								foreach($users as $user){
								?>
								<option value="<?php echo $user['membership_code'];?>" <?php echo empty($sale) || $sale['sales_writing_agent'] != $user['membership_code'] ? '' : 'selected';?>><?php echo $user['first_name'].' '.$user['last_name'].' ('.$user['membership_code'].')';?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Split Agent</label>
							<select class="form-control input-sm selectpicker" data-live-search='true' name="sales_split_agent">
								<option value="0">None</option>
								<?php
								foreach($users as $user){
								?>
								<option value="<?php echo $user['membership_code'];?>" <?php echo empty($sale) || $sale['sales_split_agent'] != $user['membership_code'] ? '' : 'selected';?>><?php echo $user['first_name'].' '.$user['last_name'].' ('.$user['membership_code'].')';?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Policy NO</label>
							<input class="form-control input-sm" name="sales_policy_no" value="<?php echo empty($sale) ? '': $sale['sales_policy_no'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Face Amount</label>
							<span class="text-danger">*</span>
							<input class="form-control input-sm" type="number" name="sales_face_amount" value="<?php echo empty($sale) ? '': $sale['sales_face_amount'];?>" require min="0">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Provider</label>
							<select class="form-control input-sm" name="sales_provider">
								<option <?php echo empty($sale) || $sale['sales_provider'] != 'Allianz' ? '' : 'selected';?>>Allianz</option>
								<option <?php echo empty($sale) || $sale['sales_provider'] != 'Nationwide' ? '' : 'selected';?>>Nationwide</option>
								<option <?php echo empty($sale) || $sale['sales_provider'] != 'PacLife' ? '' : 'selected';?>>PacLife</option>
								<option <?php echo empty($sale) || $sale['sales_provider'] != 'Prudential' ? '' : 'selected';?>>Prudential</option>
								<option <?php echo empty($sale) || $sale['sales_provider'] != 'Transamerica' ? '' : 'selected';?>>Transamerica</option>
								<option <?php echo empty($sale) || $sale['sales_provider'] != 'Voya' ? '' : 'selected';?>>Voya</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Policy Type</label>
							<select class="form-control input-sm" name="sales_policy_type">
								<option value="IL" <?php echo empty($sale) || $sale['sales_policy_type'] != 'IL' ? '' : 'selected';?>>IUL + LTC</option>
								<option value="I" <?php echo empty($sale) || $sale['sales_policy_type'] != 'I' ? '' : 'selected';?>>IUL</option>
								<option value="A" <?php echo empty($sale) || $sale['sales_policy_type'] != 'A' ? '' : 'selected';?>>Annuity</option>
								<option value="T" <?php echo empty($sale) || $sale['sales_policy_type'] != 'T' ? '' : 'selected';?>>Term</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Submission Date</label>
							<span class="text-danger">*</span>
							<input class="form-control input-sm" type="date" name="sales_date_submission" value="<?php echo empty($sale) ? '': $sale['sales_date_submission'];?>" required>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Closure Date</label>
							<input class="form-control input-sm" type="date" name="sales_date_closure" value="<?php echo empty($sale) || empty($sale['sales_date_closure']) ? '': $sale['sales_date_closure'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Status</label>
							<select class="form-control input-sm" name="sales_status">
								<option value="P" <?php echo empty($sale) || $sale['sales_status'] != 'P' ? '' : 'selected';?>>Pending</option>
								<option value="I" <?php echo empty($sale) || $sale['sales_status'] != 'I' ? '' : 'selected';?>>Inforced</option>
								<option value="C" <?php echo empty($sale) || $sale['sales_status'] != 'C' ? '' : 'selected';?>>Closed</option>
								<option value="CA" <?php echo empty($sale) || $sale['sales_status'] != 'CA' ? '' : 'selected';?>>Canceled</option>
							</select>
						</div>
					</div>
				</div>
				</fieldset>
				<fieldset>
					<legend>Insured</legend>

				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Insured Name</label>
							<span class="text-danger">*</span>
							<input class="form-control input-sm" name="sales_insured" value="<?php echo empty($sale) ? '': $sale['sales_insured'];?>" required>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Insured Date of Birth</label>
							<input class="form-control input-sm" type="date" name="sales_insured_dob" value="<?php echo empty($sale) ? '': $sale['sales_insured_dob'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Insured Gender</label>
							<select class="form-control input-sm" name="sales_insured_gender">
								<option value="F" <?php echo empty($sale) || $sale['sales_insured_gender'] != 'F'? '': 'selected';?>>Female</option>
								<option value="M" <?php echo empty($sale) || $sale['sales_insured_gender'] != 'M'? '': 'selected';?>>Male</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Insured Phone</label>
							<input class="form-control input-sm" name="sales_insured_phone" value="<?php echo empty($sale) ? '': $sale['sales_insured_phone'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Insured Email</label>
							<input class="form-control input-sm" name="sales_insured_email" value="<?php echo empty($sale) ? '': $sale['sales_insured_email'];?>">
						</div>
					</div>
				</div>
				</fieldset>
				<fieldset>
					<legend>Owner</legend>
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Owner Name</label>
							<input class="form-control input-sm" name="sales_owner" value="<?php echo empty($sale) ? '': $sale['sales_owner'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Owner Date of Birth</label>
							<input class="form-control input-sm" type="date" name="sales_owner_dob" value="<?php echo empty($sale) ? '': $sale['sales_owner_dob'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Owner Gender</label>
							<select class="form-control input-sm" name="sales_owner_gender">
								<option value="F" <?php echo empty($sale) || $sale['sales_owner_gender'] != 'F'? '': 'selected';?>>Female</option>
								<option value="M" <?php echo empty($sale) || $sale['sales_owner_gender'] != 'M'? '': 'selected';?>>Male</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Owner Phone</label>
							<input class="form-control input-sm" name="sales_owner_phone" value="<?php echo empty($sale) ? '': $sale['sales_owner_phone'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Owner Email</label>
							<input class="form-control input-sm" name="sales_owner_email" value="<?php echo empty($sale) ? '': $sale['sales_owner_email'];?>">
						</div>
					</div>
				</div>
				</fieldset>
				<fieldset>
					<legend>Payor</legend>
					<div class="row">
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Payor Name</label>
							<input class="form-control input-sm" name="sales_payor" value="<?php echo empty($sale) ? '': $sale['sales_payor'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Payor Date of Birth</label>
							<input class="form-control input-sm" type="date" name="sales_payor_dob" value="<?php echo empty($sale) ? '': $sale['sales_payor_dob'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Payor Gender</label>
							<select class="form-control input-sm" name="sales_payor_gender">
								<option value="F" <?php echo empty($sale) || $sale['sales_payor_gender'] != 'F'? '': 'selected';?>>Female</option>
								<option value="M" <?php echo empty($sale) || $sale['sales_payor_gender'] != 'M'? '': 'selected';?>>Male</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Payor Phone</label>
							<input class="form-control input-sm" name="sales_payor_phone" value="<?php echo empty($sale) ? '': $sale['sales_payor_phone'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Payor Email</label>
							<input class="form-control input-sm" name="sales_payor_email" value="<?php echo empty($sale) ? '': $sale['sales_payor_email'];?>">
						</div>
					</div>
				</div>
				</fieldset>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>Client Contact</label>
					<span class="text-danger">*</span>
					<input class="form-control input-sm" name="sales_client_contact" value="<?php echo empty($sale) || empty($sale['sales_client_contact']) ? '': $sale['sales_client_contact'];?>" placeholder="abc@gmail.com, xxx-xxx-xxxx" required>
				</div>
				<div class="form-group">
					<label>Details (Outstanding Requirements)</label>
					<textarea class="form-control input-sm" name="sales_details" rows="40"><?php echo empty($sale) || empty($sale['sales_details']) ? '': $sale['sales_details'];?></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="text-right col-lg-12">
				<input type="submit" class="btn btn-sm btn-primary" value="Submit">
			</div>
		</div>
	</form-->
</div>
<script>
	$('.selectpicker').selectpicker();
					
</script>