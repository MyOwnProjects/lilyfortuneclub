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
	<h3 style="text-align:center">Reset Password</h3>
	<br/>
	<form method="post">
		<?php
		if(isset($error) && !empty($error)){
			echo '<div class="alert alert-danger">'.$error.'</div>';
		}
		else if(isset($message) && !empty($message)){
			echo '<div class="alert alert-success">'.$message.'</div>';
		}
		?>
		<?php 
		if(isset($token) && $token){
		?>
		<input type="hidden" name="token" value="<?php echo $token;?>">
		<div class="form-group">
			<label>New Password</label>
			<input type="password" class="form-control" id="email" name="password" required>
		</div>
		<div class="form-group">
			<label>Confirm New Password</label>
			<input type="password" class="form-control" id="email" name="confirm_password" required>
		</div>
		<?php 
		}
		else{
		?>
		<div class="form-group">
			<label>Username</label>
			<input class="form-control" id="username" name="username" required>
		</div>
		<?php 
		}
		?>
		<button type="submit" class="btn btn-primary pull-right">Submit</button>
	</form>
</div>
