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
		<?php echo $error ? '<div class="alert alert-danger">'.$error.'</div>' : '';?>
		<div class="form-group m">
			<label for="email">Username</label>
			<input class="form-control" id="username" name="username" required autofocus>
		</div>
		<div class="form-group m">
			<a class="pull-right" style="font-size:12px;margin-top:4px" href="<?php echo base_url();?>ac/reset_password">Forget your password?</a>
			<label for="pwd">Password</label>
			<input type="password" class="form-control" type="password" id="password" name="password" required>
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
		$('#password-g, #guest-name').val('').prop('disabled', false);
		$('.g').show();
		$('.m').hide();
		$('#password, #username').val('').prop('disabled', true);
	}
	else{
		$('.g').hide();
		$('#password, #username').val('').prop('disabled', false);
		$('.m').show();
		$('#password-g, #guest-name').val('').prop('disabled', true);
	}
}
</script>