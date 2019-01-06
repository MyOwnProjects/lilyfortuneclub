<style>
.panel-heading{font-weight:bold}
.panel-body div{line-height:30px;}
</style>

<div style="max-width:1000px;width:100%;padding:40px 20px;margin:0 auto">
	<h3 class="text-center">Contact Us</h3>
	<div style="margin:40px auto;max-width:600px;width:100%">
		<?php
		if(!empty($user)){
		?>
		<div class="panel panel-success">
			<div class="panel-heading">Senior Marketing Director</div>
			<div class="panel-body"><b>Lily Zhu</b> (510) 501-4697, lily_min_zhu@yahoo.com</div>
		</div>
		<div class="panel panel-info">
				<div class="panel-heading">Invitation and Objection Handling</div>
				<div class="panel-body"> 
					<div class="row">
						<div class="col-sm-4 col-xs-6">
							<b>Lily Zhu</b><br/>
							(510) 501-4697<br/>
							lily_min_zhu@yahoo.com
						</div>
						<div class="col-sm-4 col-xs-6">
							<b>Minna Millare</b><br/>
							(415) 828-8841<br/>
							Minna.millare@gmail.com
						</div>
						<div class="col-sm-4 col-xs-6">
							<b>Bob Wang</b><br/>
							(408) 718-3622<br/>
							bob888wang@gmail.com
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-info">
				<div class="panel-heading">Products</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-6 col-xs-6">
							<b>Lily Zhu</b><br/>
							(510) 501-4697<br/>
							lily_min_zhu@yahoo.com
						</div>
						<div class="col-sm-6 col-xs-6">
							<b>Kun Yang</b><br/>
							(510) 461-3854<br/>
							kunyangnew@gmail.com
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-info">
				<div class="panel-heading">
					License Procedure / Website Administration<br/>
					Name Tag, Team Shirt and Binder Order
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6">
							<b>Kun Yang</b><br/>
							(510) 461-3854<br/>
							kunyangnew@gmail.com
						</div>
						<div class="col-xs-6">
							<b>Christine Cen</b><br/>
							(510) 364-0502<br/>
							chrislicen@gmail.com
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			else{
			?>
			<div class="panel panel-info">
				<div class="panel-heading">
					General Questions
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 clearfix">
							<div class="pull-left">
								<b>Kun Yang</b><br/>
								1-510-461-3854<br/>
								kunyangnew@gmail.com<br/>
								lilyfortuneclub@gmail.com
							</div>
							<div class="pull-right">
								<img style="width:200px" src="<?php echo base_url();?>src/img/webwxgetmsgimg.jpg">
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>
