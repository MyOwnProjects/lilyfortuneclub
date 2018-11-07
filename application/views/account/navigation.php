<div class="main-body-header">Navigation</div>
<div class="main-body-wrapper clearfix">
	<?php
	foreach($navigation as $nav){
	?>
		<div class="panel panel-default" style="margin:20px">
			<div class="panel-heading"><strong><?php echo $nav['text'];?></strong></div>
			<div class="panel-body">
				<?php
				foreach($nav['sub_menu'] as $sm){
					if(!array_key_exists('desc', $sm) || $sm['url'] == 'smd'){
						continue;
					}
				?>
				<div class="clearfix" style="margin:20px 0">
					<div class="pull-left"><img style="width:20px;height:20px;margin:0 10px 0 20px" src="<?php echo base_url();?>src/img/<?php echo $sm['icon'];?>"></div>
					<div class="pull-left text-left" style="width:120px;margin-right:10px">
						<a href="<?php echo base_url().$sm['url'];?>">
							<strong><?php echo $sm['text'];?></strong>
						</a>
					</div>
					<div style="overflow:hidden"><?php echo $sm['desc'];?></div>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	<?php
	}
	?>
</div>
