<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"></meta>
		<title></title>
		<link type="text/css" rel="Stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-4.1.3-dist/css/bootstrap.min.css" />
    	<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-migrate-1.2.1.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
	</head>
	<body style="margin:100px auto 0 auto;width:400px">
		<h3>SMD Sign In</h3>
		<br/>
		<?php if(!empty($error)){ ?>
		<div class="alert alert-danger"><?php echo $error;?></div>
		<?php } ?>
		<form method="post" role="form">
			<div class="form-group">
				<label for="email">Username</label>
				<input id="username" name="username" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" id="password" name="password" class="form-control"/>
			</div>
			<div class="checkbox">
				<input type="checkbox" style="margin-left:0 !important;" name="save_password">&nbsp;&nbsp;&nbsp;&nbsp;Save Password
			</div>
			<div class="control-group">
				<input type="submit" value="Sign In" class="pull-right btn btn-primary" />
			</div>
		</form>
	</body>
</html>