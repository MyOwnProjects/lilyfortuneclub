<style>
.main-content-wrapper{max-width:1000px !important}
.bootstrap-select .btn{padding:0;border:none}

.bootstrap-select .btn-group.open .dropdown-toggle{webkit-box-shadow:none;box-shadow:none}
.bootstrap-select .btn-default:active, .bootstrap-select .btn-default:focus, .bootstrap-select .btn-default:hover, .bootstrap-select .open>.dropdown-toggle.btn-default {background-color:#fff !important;border-color:#fff !important}
.table-prop td{padding:5px 5px !important}
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
			'value' => empty($sale) ? '': $sale['sales_date_closure']
		),
		'sales_status' => array(
			'label' => 'Status',
			'tag' => 'select',
			'options' => $general_select(array(
				'P' => 'Pending',
				'I' => 'Inforced',
				'C' => 'Closed',
				'CA' => 'Canceled'
			), 'sales_status')
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
			'value' => empty($sale) ? '': $sale['sales_insured_email']
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
			'value' => empty($sale) ? '': $sale['sales_owner_email']
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
			'value' => empty($sale) ? '': $sale['sales_payor_email']
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
				'value' => empty($sale) ? '': $sale['sales_primary_beneficiary_email']
			)
		),
		call_user_func(function() use($sale, $general_select){
			$ret = array();
			for($i = 1; $i <= 3; ++$i){
				$ret['sales_contingent_beneficiary_'.$i] = array(
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
<div class="main-content-wrapper"> 
	<h2 class="text-center"><?php echo empty($sale) ? 'New Sales Case' : 'Edit Sales Case'?></h2>
	
	<?php
	if(!empty($error)){
	?>
	<div class="alert alert-danger">
		<?php echo $error['text'];?>
	</div>
	<?php
	}
	?>
	<form method="post"  action="<?php echo base_url();?>account/sales/sales_case<?php echo empty($sales_id) ? '' : '/'.$sales_id; ?>">
		<div style="margin:20px 0 10px 0">
			<input type="submit" value="Submit" class="btn btn-sm btn-success">
			<a href="<?php echo base_url();?>account/sales" class="btn btn-sm">Back to List</a>
		</div>
		<div class="clearfix">
			<?php
			foreach($fields as $field){
				$this->load->view('prop_table', array('field' => $field, 'error' => $error));
			}
			?>
		</div>
	</form>
</div>
<script>
	$('.selectpicker').selectpicker();
					
</script>