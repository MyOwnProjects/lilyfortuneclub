<div data-role="page" id="prospects" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Profile'));?>
	<div data-role="main">
		<ul class="list5" data-role="listview" >
			<li data-role="list-divider">Account</li>
			<li><label>Username:</label><?php echo $user['username'];?></li>
			<li>
				<div class="btn">
					<a href="#change-password" data-transition="slide"><span class="ui-btn ui-btn-icon-notext ui-icon-edit ui-corner-all ui-btn-inline ui-btn-b"></span></a>
				</div>
				<div style="overflow:hidden">
				<label>Password:</label>
				********
				</div>
			</li>
			<li data-role="list-divider">Membership</li>
			<li><label>Grade:</label><?php echo $user['grade'];?>&nbsp;</li>
			<li><label>Code:</label><?php echo $user['membership_code'];?>&nbsp;</li>
			<li><label>Upline:</label><?php echo $user['first_name2'].' '.$user['last_name2'].(empty($user['nick_name2']) ? '' : ' ('.$user['nick_name2'].')');?>&nbsp;</li>
			<li><label>SMD:</label><?php echo $user['first_name1'].' '.$user['last_name1'].(empty($user['nick_name1']) ? '' : ' ('.$user['nick_name1'].')');?>&nbsp;</li>
			<li  data-role="list-divider">General Info</li>
			<li><label>Name:</label><?php echo $user['first_name'].' '.$user['last_name'];?>&nbsp;</li>
			<li><label>Nick Name:</label><?php echo $user['nick_name'];?>&nbsp;</li>
			<li>
				<label>Preference:</label>
				<fieldset data-role="controlgroup" data-type="horizontal" >
					<label for="preference-e">Learn knowledge</label>
					<input type="radio" name="preference" id="preference-e" value="E" data-mini="true" <?php echo $user['preference'] == 'E' ? 'checked' : '';?>>
					<label for="preference-b">Do business</label>
					<input type="radio" name="preference" id="preference-b" value="B" data-mini="true" <?php echo $user['preference'] == 'B' ? 'checked' : '';?>>
					<label for="preference-be">Both</label>
					<input type="radio" name="preference" id="preference-be" value="BE" data-mini="true" <?php echo $user['preference'] == 'BE' ? 'checked' : '';?>>
				</fieldset>				
			</li>
			<li><label>Email:</label><?php echo $user['email'];?>&nbsp;</li>
			<li><label>Date of Birth:</label><?php echo date_format(date_create($user['date_of_birth']), 'F j, Y');?>&nbsp;</li>
			<li><label>Phone:</label><?php echo $user['phone'];?>&nbsp;</li>
			<li><label>Address:</label>
				<?php 
					echo (empty($user['street']) ? '' : $user['street'])
						.(empty($user['city']) && empty($user['state']) && empty($user['zipcode']) ? '' : ', '.$user['city'].', '.$user['state'].' '.$user['zipcode'])
						.(empty($user['country']) ? '' : ', '.$user['country']);
				?>&nbsp;
			</li>
		</ul>
	</div>
</div>

<div data-role="page" id="change-password" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Change Password</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="main" class="ui-content">
		<div class="ui-field-contain">
			<input type="password" name="password" id="password" placeholder="New Password">
		</div>
		<div class="ui-field-contain">
			<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm New Password">
		</div>
		<div class="ui-field-contain" style="text-align:right"><span id="btn-save-password" data-role="button" class="ui-btn ui-corner-all ui-mini ui-btn-mini ui-btn-inline ui-btn-b">Save</span></div>
	</div>
</div>
<script>
$(document).on("pagehide","#change-password",function(){
	$('#password, #confirm_password').val('');
});
$('#btn-save-password').click(function(e){
	var password = $('#password').val();
	var confirm_password = $('#confirm_password').val();
	if(password != confirm_password){
		return false;
	}
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	$.ajax({
		url: '<?php echo base_url();?>account/password',
		method: 'post',
		data: {password: password, confirm_password: confirm_password},
		dataType: 'json',
		success: function(data){
			if(!data['success']){
				$('#popup').html('<p class="w3-text-red">Failed to change password. ' + data['error'] + '<p><p class="w3-text-red">Please change again.</p>').popup('open');
			}
			else{
				$('#change-password [data-rel="back"]').click();
			}
		},
		error: function(){
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
});

function update_user_preference(val){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	$.ajax({
		url: '<?php echo base_url();?>account/profile/update_preference',
		method: 'post',
		data: {preference:val},
		success: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
			location.reload();
		},
		error: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
}
$('input[name=preference]').change(function(){
	update_user_preference($(this).val());
});
</script>

