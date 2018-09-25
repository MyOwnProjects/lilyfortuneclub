<div >
	<form method="post" style="margin:40px" action="<?php echo base_url();?>smd/sales/sales_case<?php echo empty($sale) ? '' : '/'.$sale['sales_id']; ?>">
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
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Policy NO</label>
							<input class="form-control control-sm" name="sales_policy_no" value="<?php echo empty($sale) ? '': $sale['sales_policy_no'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Face Amount</label>
							<span class="text-danger">*</span>
							<input class="form-control control-sm" type="number" name="sales_face_amount" value="<?php echo empty($sale) ? '': $sale['sales_face_amount'];?>" require min="0">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Writing Agent</label>
							<select class="form-control control-sm selectpicker" data-live-search='true' name="sales_writing_agent">
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
							<select class="form-control control-sm selectpicker" data-live-search='true' name="sales_split_agent">
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
							<label>Provider</label>
							<select class="form-control control-sm" name="sales_provider">
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
							<select class="form-control control-sm" name="sales_policy_type">
								<option value="IL" <?php echo empty($sale) || $sale['sales_policy_type'] != 'IL' ? '' : 'selected';?>>IUL + LTC</option>
								<option value="I" <?php echo empty($sale) || $sale['sales_policy_type'] != 'I' ? '' : 'selected';?>>IUL</option>
								<option value="A" <?php echo empty($sale) || $sale['sales_policy_type'] != 'A' ? '' : 'selected';?>>Annuity</option>
								<option value="T" <?php echo empty($sale) || $sale['sales_policy_type'] != 'T' ? '' : 'selected';?>>Term</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Insured Name</label>
							<span class="text-danger">*</span>
							<input class="form-control control-sm" name="sales_insured" value="<?php echo empty($sale) ? '': $sale['sales_insured'];?>" required>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Owner Name</label>
							<input class="form-control control-sm" name="sales_owner" value="<?php echo empty($sale) ? '': $sale['sales_owner'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Submission Date</label>
							<span class="text-danger">*</span>
							<input class="form-control control-sm" type="date" name="sales_date_submission" value="<?php echo empty($sale) ? '': $sale['sales_date_submission'];?>" required>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Closure Date</label>
							<input class="form-control control-sm" type="date" name="sales_date_closure" value="<?php echo empty($sale) || empty($sale['sales_date_closure']) ? '': $sale['sales_date_closure'];?>">
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<div class="form-group">
							<label>Status</label>
							<select class="form-control control-sm" name="sales_status">
								<option value="P" <?php echo empty($sale) || $sale['sales_status'] != 'P' ? '' : 'selected';?>>Pending</option>
								<option value="I" <?php echo empty($sale) || $sale['sales_status'] != 'I' ? '' : 'selected';?>>Inforced</option>
								<option value="C" <?php echo empty($sale) || $sale['sales_status'] != 'C' ? '' : 'selected';?>>Closed</option>
								<option value="CA" <?php echo empty($sale) || $sale['sales_status'] != 'CA' ? '' : 'selected';?>>Canceled</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label>Client Contact</label>
					<span class="text-danger">*</span>
					<input class="form-control control-sm" name="sales_client_contact" value="<?php echo empty($sale) || empty($sale['sales_client_contact']) ? '': $sale['sales_client_contact'];?>" placeholder="abc@gmail.com, xxx-xxx-xxxx" required>
				</div>
				<div class="form-group">
					<label>Details (Outstanding Requirements)</label>
					<textarea class="form-control control-sm" name="sales_details" rows="15"><?php echo empty($sale) || empty($sale['sales_details']) ? '': $sale['sales_details'];?></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="text-right col-lg-12">
				<input type="submit" class="btn btn-sm btn-primary" value="Submit">
			</div>
		</div>
	</form>
</div>
<script>
	$('.selectpicker').selectpicker();
					
</script>