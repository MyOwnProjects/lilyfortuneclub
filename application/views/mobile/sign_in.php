<style>
.ui-grid-solo{border-bottom:1px solid silver;padding:20px 0}
.ui-block-a>div, .ui-block-a>ul{margin:0 auto;max-width:600px}
.ui-block-a,.ui-block-b{text-align:center;padding:20px}
.text-block-subject{margin-bottom:10px;text-align:center;font-family: 'Open Sans Condensed', sans-serif;}
.text-block-desc{font-size:16px;line-height:30px;text-align:left;font-family: 'Open Sans Condensed', sans-serif;list-style:square outside;}
img{width:100%;max-width:400px;max-height:200px}
</style>
<div data-role="page" id="home" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Sign in'));?>
	<div data-role="main" class="ui-content" data-theme="d">
			<form method="post" data-ajax="false">
				<div style="color:red"><?php echo $error;?></div>
				<input type="text" name="username" placeholder="Username" required>
				<input type="password" name="password" placeholder="Password" required>
				<label for="save_password">Save Password</label>
				<input type="checkbox" name="save_password" id="save_password" checked>
				<button type="submit" class="btn-1 ui-btn ui-corner-all">Sign in</button>
			</form>
	</div>
</div>