<style>
.ui-grid-solo{border-bottom:1px solid silver;padding:20px 0}
.ui-block-a>div, .ui-block-a>ul{margin:0 auto;max-width:600px}
.ui-block-a,.ui-block-b{text-align:center;padding:20px}
.text-block-subject{margin-bottom:10px;text-align:center;font-family: 'Open Sans Condensed', sans-serif;}
.text-block-desc{font-size:16px;line-height:30px;text-align:left;font-family: 'Open Sans Condensed', sans-serif;list-style:square outside;}
img{width:100%;max-width:400px;max-height:200px}
</style>
<div data-role="page" id="home" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Home'));?>
	<div data-role="main" class="ui-content" data-theme="d">
		<div class="ui-grid-solo ui-responsive">
			<div class="ui-block-a">
				<img src="<?php echo base_url();?>src/img/x-curve.png">
			</div>
			<div class="ui-block-a">
				<h2 class="text-block-subject">
					Know Your Financial Status
				</h2>
				<ul class="text-block-desc">
					<li>How much protection - Debt, Income, Mortgage and Education?</li>
					<li>The wealth formula - Money, Time, Rate of Return, Inflation and Taxes</li>
				</ul>
			</div>
		</div>
		<div class="ui-grid-solo ui-responsive">
			<div class="ui-block-a">
					<h2 class="text-block-subject">
						Manage Rate & Risk
					</h2>
					<ul class="text-block-desc">
						<li>How much protection - Debt, Income, Mortgage and Education?</li>
						<li>The wealth formula - Money, Time, Rate of Return, Inflation and Taxes</li>
					</ul>
			</div>

			<div class="ui-block-a">
				<img src="<?php echo base_url();?>src/img/umbrella1.png">
			</div>
		</div>
		<div class="ui-grid-solo ui-responsive">
			<div class="ui-block-a">
				<img src="<?php echo base_url();?>src/img/tax-impact.png">
			</div>
			<div class="ui-block-a">
						<h2 class="text-block-subject">
							Reduce the Impact of Tax
						</h2>
						<ul class="text-block-desc">
							<li>Does it have TAX ADVANTAGE?</li>
							<li>Does it have proper PROTECTION for your family?</li>
						</ul>
			</div>
		</div>
		<div class="ui-grid-solo ui-responsive">
			<div class="ui-block-a">
						<h2 class="text-block-subject">
							Learn Financial Knowledge
						</h2>
						<ul class="text-block-desc">
							<li>Cash Flow & Debt Management</li>
							<li>Emergency Fund & Proper Protection</li>
							<li>Asset Accumulation & Estate Preservation</li>
						</ul>
			</div>
			<div class="ui-block-a">
				<img src="<?php echo base_url();?>src/img/72-rule.png">
			</div>
		</div>
		<?php if(empty($user)) {
		?>
		<div class="ui-grid-solo ui-responsive" id="sign_in">
			<div>
				<h3 style="text-align:center">Sign in you account</h3>
				<form method="post" data-ajax="false" action="<?php echo base_url();?>ac/sign_in">
					<input type="text" name="username" placeholder="Username" required>
					<input type="password" name="password" placeholder="Password" required>
					<label for="save_password">Save Password</label>
					<input type="checkbox" name="save_password" id="save_password" chacked>
					<button type="submit" class="btn-1 ui-btn ui-corner-all">Sign in</button>
				</form>
			</div>
		</div>	
		<?php
		}
		?>
	</div>
</div>