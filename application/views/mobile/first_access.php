<div data-role="page" id="first-access" data-theme="d">
	<div data-role="content">
		<p>Hello <?php echo $first_name.' '.$last_name;?>, this is your first time to access your account. Please enter or update the email, and change your password. </p>
		<form method="POST" data-ajax="false" action="<?php echo base_url();?>account/first_access">
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
			<input type="email" required name="email" value="<?php echo $email;?>" placeholder="Enter/update email">
			<input type="password" required name="password" placeholder="New password">
			<input type="password" required name="confirm_password" placeholder="Confirm new password">
			<button type="submit" class="ui-btn ui-corner-all btn-1">Update</button>
		</form>
	</div>
</div>