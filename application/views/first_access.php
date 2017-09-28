<div class="main-content-wrapper">
	<h2 class="text-center">First Time Access</h2>
<form method="POST" style="margin:40px auto">
	<?php 
	if(!empty($error)){
	?>
	<div class="alert alert-danger"><?php echo $error;?></div>
	<?php
	}
	if(!empty($success)){
	?>
	<div class="alert alert-success"><?php echo $success;?></div>
	<?php
	}
	
	?>
	<p>Hello <?php echo $first_name.' '.$last_name?>, this is your first time to access your account. Please enter or update the email, and change your password. </p>
	<div class="form-group">
		<label>Enter / Update Email (<span style="color:red;font-weight:normal">Important! Email is used to reset your password</span>)</label>
		<input class="form-control" type="email" required name="email" value="<?php echo $email;?>">
	</div>
	<div class="form-group">
		<label>New Password</label>
		<input class="form-control" type="password" required name="password">
	</div>
	<div class="form-group">
		<label>Confirm New Password</label>
		<input class="form-control" type="password" required name="confirm_password">
	</div>
	<div class="form-group">
		<input class="pull-right btn btn-primary" type="submit" value="Change">
	</div>
</form>	
</div>
