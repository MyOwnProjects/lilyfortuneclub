
<style>
.common-ln{padding:5px 0}	
</style>
<div class="main-body-wrapper clearfix">
	<div class="row" style="margin:20px 0">
		<div class="col-md-6 col-sm-12">
			<div class="panel panel-default" style="margin:20px">
				<div class="panel-heading"><strong>Navigation</strong></div>
				<div class="panel-body">
					<?php
					foreach($navigation as $nav){
					?>
					<div class="clearfix" style="padding:10px 0">
						<div class="pull-left text-right" style="width:70px;margin-right:10px;"><?php echo $nav['text'];?>:</div>
						<div style="overflow:hidden">
							<?php
							foreach($nav['sub_menu'] as $sm){
								if(!array_key_exists('desc', $sm) || $sm['url'] == 'smd'){
									continue;
								}
							?>
								<a href="<?php echo base_url().$sm['url'];?>" style="white-space:nowrap;text-decoration:underline;margin-right:10px">
									<?php echo $sm['text'];?>
								</a>
							<?php
							}
							?>

						</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-12">
			<div class="panel panel-default" style="margin:20px">
				<div class="panel-heading"><strong>Highlights</strong></div>
				<div class="panel-body">
					<div class="common-ln">
						<a href="<?php echo base_url();?>documents/view/599e6b4cc736e">Code of Honor</a>
					</div>
					<div class="common-ln">
						<a href="<?php echo base_url();?>documents/view/599e6b4cc736e">High Standard Promotion Guideline</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
