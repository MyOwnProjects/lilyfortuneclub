<style>
input,textarea,select{box-sizing:border-box;width:100%}
</style>
<div class="main-body-wrapper">
	<h3 class="text-center">New Member</h3>
	<div class="row" style="padding:20px 20px 0 20px">
		<div class="col-sm-12 form-group">
			<label>MyWFG Fields</label>
			<textarea class="form-control form-control-sm" id="auto-fill" style="height:100px"></textarea>
			<br/>
			<button class="btn btn-sm btn-primary" onclick="auto_fill()" id="auto-fill-btn">&nbsp;&nbsp;&nbsp;&nbsp;Fill&nbsp;&nbsp;&nbsp;&nbsp;</button>
		</div>
	</div>
	<form style="padding:20px;border-top:1px solid #d5d5d5" method="post">
	<div class="row">
		<div class="col-sm-12 form-group clearfix">
			<div class="pull-left text-danger">
				<?php echo $error;?>
			</div>
			<div class="pull-right">
			<button class="btn btn-sm btn-success" id="btn-submit">Submit</button>
			&nbsp;&nbsp;
			<a href="<?php echo base_url();?>smd/team" class="btn btn-sm btn-danger" role="button">Cancel</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-6 col-sm-12 form-group" ng-app="myapp" ng-controller="mycontroller" ng-init="membership_code_error=''">
			<label>Code <span class="text-danger">*</span></label><div class="pull-right text-danger">{{member.membership_code_error()}}</div>
			<input class="form-control form-control-sm member-info-field" name="membership_code" required ng-model="member.membership_code">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Upline Code <span class="text-danger">*</span></label>
			<div class="dropdown">
				<input type="text" class="dropdown-toggle form-control form-control-sm member-info-field" data-toggle="dropdown" name="recruiter" required>
				<div class="dropdown-menu" style="max-height:200px;overflow-y:auto;right:0px !important;padding:0 !important">
					<?php
					foreach($all_member as $m){
					?>
					<a class="dropdown-item" value="<?php echo $m['value'];?>"><?php echo $m['text'];?></a>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>First Name <span class="text-danger">*</span></label>
			<input class="form-control form-control-sm member-info-field" name="first_name" required>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Last Name <span class="text-danger">*</span></label>
			<input class="form-control form-control-sm member-info-field" name="last_name" required>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Start Date</label>
			<input type="date" class="form-control form-control-sm member-info-field" name="start_date" placeholder="YYYY-MM-DD">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Initial Date</label>
			<input type="date" class="form-control form-control-sm member-info-field" name="original_start_date" placeholder="YYYY-MM-DD">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Nick Name</label>
			<input class="form-control form-control-sm member-info-field" name="nick_name" placeholder="">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Email</label>
			<input class="form-control form-control-sm member-info-field" name="email" placeholder="">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Date of Birth</label>
			<input class="form-control form-control-sm member-info-field" name="date_of_birth" placeholder="">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Phone</label>
			<input class="form-control form-control-sm member-info-field" name="phone" placeholder="">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Street</label>
			<input class="form-control form-control-sm member-info-field" name="street" placeholder="">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>City</label>
			<input class="form-control form-control-sm member-info-field" name="city" placeholder="">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>State</label>
			<input class="form-control form-control-sm member-info-field" name="state" placeholder="">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Zipcode</label>
			<input class="form-control form-control-sm member-info-field" name="zipcode" placeholder="">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Country</label>
			<input class="form-control form-control-sm member-info-field" name="country" placeholder="">
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Level</label>
			<select class="custom-select custom-select-sm member-info-field" name="grade">
				<option value="G">Guest</option>
				<option value="TA" selected="">Trainee Associate</option>
				<option value="A">Associate</option>
				<option value="SA">Senior Associate</option>
				<option value="MD">Margeting Director</option>
			</select>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 form-group">
			<label>Send Email?</label>
			<select class="custom-select custom-select-sm" name="grade" disabled>
				<option value="Y">Yes</option>
				<option value="N" selected>No</option>
			</select>
		</div>
	</div>
	</form>
<script>
$('.member-info-field').each(function(){
	$(this).attr('id', $(this).attr('name'));
});
var all_members = JSON.parse('<?php echo json_encode($all_member);?>');
angular.module("myapp", [])
	.controller("mycontroller", function($scope) {
		$scope.member = {
			membership_code: '',
			membership_code_error: function(){
				var found = false;
				for(var ii = 0; ii < all_members.length; ++ii){
					if($scope.member.membership_code == all_members[ii]['value']){
						found = true;
						break;
					}
				}
				if(found){
					$('#btn-submit').prop('disabled', true);
				}
				else{
					$('#btn-submit').removeProp('disabled');
				}
				return found ? 'Code already exists' : '';
			}
		};
	});
	
var dorpdownedit = $('#recruiter').parent().dropdownedit();
function auto_fill(){
	var content_array = $('#auto-fill').val().trim().split('\n');
	var name = null;
	var phone_list = [];
	var address = [];
	for(var i = 0; i < content_array.length; ++i){
		var line = content_array[i].trim();
		if(line.length > 0){
			if(line[line.length - 1] == ':'){
				name = line.substr(0, line.length - 1);
			}
			else{
				switch(name){
					case 'Name':
						lpos = line.indexOf('(');
						rpos = line.indexOf(')');
						code_len = rpos - lpos - 1;
						$('#membership_code').val(line.substr(line.length - (code_len + 1), code_len)).trigger('change'); 
						line = line.substr(0, line.length - (code_len + 2)).trim();
						var pos = line.lastIndexOf(' ');
						$('#first_name').val(line.substr(0, pos));
						$('#last_name').val(line.substr(pos + 1, line.length - pos));
						break;
					case 'Level':
						$('#grade').val(line);
						break;
					case 'Start Date':
						var date = new Date(line);
						var today = new Date();
						var diff = dateDiffInDays(today, date);
						var date_str = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
						if(diff > 180){
							$('#start_date').val(today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0'));
							$('#original_start_date').val(date_str);
						}
						else{
							$('#start_date').val(date_str);
						}
						break;
					case 'DOB':
						var date = new Date(line + ' 2017');
						var date_str = '1900-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
						$('#date_of_birth').val(date_str);
						break;
					case 'Home Phone':
						phone_list.push('H:' + line);
						break;
					case 'Business Phone':
						phone_list.push('B:' + line);
						break;
					case 'Mobile Phone':
						phone_list.push('M:' + line);
						break;
					case 'Personal Email':
						$('#email').val(line);
						break;
					case 'Home Address':
						address.push(line);
						break;
					case 'Recruiter':
						var p = line.lastIndexOf(' ');
						var l_first_name = line.substr(0, p).toLowerCase();
						var l_last_name = line.substr(p + 1).toLowerCase();
						for(var ii = 0; ii < all_members.length; ++ii){
							var v = all_members[ii]['text'].trim().toLowerCase();
							var p1 = v.indexOf('(');
							var p2 = v.indexOf(')');
							if(p1 >= 0 && p2 >= 3){
								var v_nick_name = v.substr(p1 + 1, p2 - p1 - 1);
								v = v.substr(0, p1).trim();
							}
							var p = v.lastIndexOf(' ');
							var v_first_name = v.substr(0, p).toLowerCase();
							var v_last_name = v.substr(p + 1).toLowerCase();
							if(l_last_name == v_last_name && 
								( l_first_name == v_first_name || l_first_name == v_nick_name)){
								//$('#recruiter').val($(obj).val()).selectpicker('refresh');
								dorpdownedit.update(all_members[ii]['value']);
								break;
							}
						}
						break;
				}
			}
		}
	}
	if(address.length >= 2){
		$('#street').val(address[0]);
		var ar = address[1].split(',');
		$('#city').val(ar[0].trim());
		ar = ar[1].split('-');
		$('#country').val(ar[1].trim());
		ar = ar[0].trim().split(' ');
		$('#state').val(ar[0].trim());
		$('#zipcode').val(ar[1].trim());
	}
	$('#phone').val(phone_list.join(','));
}
</script>