<style>
.video-player video{width:100%}
</style>

<div>
	<div class="row" style="margin:40px 20px">
		<div class="col-md-1 col-span-0"></div>
		<div class="col-md-7 col-sm-12" style="padding-bottom:20px">
			<div class="video-player">
				<video oncontextmenu="return false;" controls autoplay>
					<source src="<?php echo base_url().$file;?>" type="video/mp4">
					Your browser does not support the video tag.
				</video>
			</div>
		</div>
		<div class="col-md-1 col-span-0"></div>
		<div class="col-md-3 col-sm-12">
			<h4>Upcoming Events</h4>
			<div class="row">
				<?php
				foreach($schedule as $i => $s){
				?>
				<div class="col-lg-12" style="overflow:hidden;text-overflow:ellipsis"> - [<a href="<?php echo base_url();?>schedule"><?php echo date_format(date_create($s['schedule_start_date']), 'm/d');?></a>]&nbsp;<?php echo $s['schedule_topic'];?></div>
				<?php
					if($i > 19){
						break;
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
