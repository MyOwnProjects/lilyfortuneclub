<form method="POST" style="width:600px;margin:80px auto">
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
	<div class="form-group">
		<label>Password</label>
		<input class="form-control" type="password" required name="password">
	</div>
	<div class="form-group">
		<label>Confirm Password</label>
		<input class="form-control" type="password" required name="confirm_password">
	</div>
	<div class="form-group">
		<input class="pull-right btn btn-primary" type="submit" value="Change">
	</div>
</form>