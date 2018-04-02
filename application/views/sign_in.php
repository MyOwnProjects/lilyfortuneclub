<script>
	$(document).ready(function(){
		$('body').keyup(function(e){
			if(e.which ==  13){
				$('#sign_in').click();
			}
		});
	});
</script>
<div class="clearfix" style="width:400px;margin:50px auto;">
	<h3 style="text-align:center">Sign In</h3>
	<br/>
	<form method="post">
		<?php $is_guest = isset($as)&& $as == 'guest'; ?>
		<?php echo $error ? '<div class="alert alert-danger">'.$error.'</div>' : '';?>
		<div class="form-group">
			<label for="role">Sign in as</label>
			<select class="form-control" id="role" name="role" onchange="role_change(this);">
				<option value="guest" <?php echo $is_guest ? 'selected' : '';?>>Guest</option>
				<option value="member" <?php echo !$is_guest ? 'selected' : '';?>>Member</option>
			</select>
		</div>
		<div class="form-group g" style="display:<?php echo $is_guest ? 'block' : 'none';?>">
			<label for="pwd">Guest Passcode</label>
			<input type="password" class="form-control" type="password" id="password-g" name="password-g" required <?php echo $is_guest ? '' : 'disabled';?>>
		</div>
		<div class="form-group m" style="display:<?php echo !$is_guest ? 'block' : 'none';?>">
			<label for="email">Username</label>
			<input class="form-control" id="username" name="username" required autofocus <?php echo !$is_guest ? '' : 'disabled';?>>
		</div>
		<div class="form-group m" style="display:<?php echo !$is_guest ? 'block' : 'none';?>">
			<a class="pull-right" style="font-size:12px;margin-top:4px" href="<?php echo base_url();?>ac/reset_password">Forget your password?</a>
			<label for="pwd">Password</label>
			<input type="password" class="form-control" type="password" id="password" name="password" required <?php echo !$is_guest ? '' : 'disabled';?>>
		</div>
		<div class="checkbox">
			<input type="checkbox" style="margin-left:0 !important;" name="save_password" checked>&nbsp;&nbsp;&nbsp;&nbsp;Stay signed in
		</div>
		<div class="form-group clearfix">
			<button type="submit" class="btn btn-primary pull-right">Sign in</button>
		</div>
	</form>
</div>
<script>
function role_change(obj){
	if($(obj).val() == 'guest'){
		$('#password-g').val('').prop('disabled', false);
		$('.g').show();
		$('.m').hide();
		$('#password, #username').val('').prop('disabled', true);
	}
	else{
		$('.g').hide();
		$('#password, #username').val('').prop('disabled', false);
		$('.m').show();
		$('#password-g').val('').prop('disabled', true);
	}
}
</script>