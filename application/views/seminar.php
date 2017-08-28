<style>
ul, ul li{list-style:none}
@media only screen and (max-width:600px) {
.doc-list li:first-child{border-top:none;display:none}
.doc-list li>div:not(:last-child){display:none}
.doc-list li>div:last-child{padding-left:10px}
}
	
</style>
<div class="resource-list  main-content-wrapper">
	<div class="breadcrumb"><a href="<?php echo base_url();?>">Home</a> > Seminar > list</div>
	<div class="clearfix" style="font-size:14px;text-align:right">
		<div class="pull-right dropdown">
				Location
				<button class="btn btn-link dropdonw-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $location;?>&nbsp;<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url();?>seminar<?php echo empty($year) ? '' : "?year=$year";?>">All</a></li>
					<?php
					foreach($locations as $l){
						echo '<li><a href="'.base_url().'seminar?location='.$l.(empty($year) ? '' : "&year=$year").'">'.$l.'</a></li>';
					}
					?>
					<li><a href="<?php echo base_url();?>seminar?location=Other<?php echo (empty($year) ? '' : "&year=$year");?>">Other</a></li>
				</ul>
		</div>
		<div class="pull-right dropdown" style="margin-right:40px">
			Year
			<button class="btn btn-link dropdonw-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $year;?>&nbsp;<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<li><a href="<?php echo base_url();?>seminar<?php echo empty($location) ? '' : "?location=$location"?>">All</a></li>
				<?php
				foreach($years as $y){
					echo '<li><a href="'.base_url().'seminar?year='.$y.(empty($location) ? '' : "&location=$location").'">'.$y.'</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
	<ul class="doc-list">
		<!--li class="clearfix" style="font-size:14px;background:#efefef;line-height:30px !important">
		<?php
			echo '<div class="pull-left" style="width:100px;text-align:center;border-right:1px solid #fff">Date</div>';
			echo '<div class="pull-left" style="width:180px;margin:0 10px;border-right:1px solid #fff">Location / Office</a></div>';
			echo '<div class="overflow:hidden;padding-left:10px">Schedule File</div>';
		?>
		</li-->
	<?php
	if(count($list) == 0){
	?>
		<li style="text-align:center;line-height:160px">No schedules.</li>
	<?php
	}
	else{
		foreach($list as $l){
		?>
			<li class="clearfix">
				<?php
				$pos = strpos($l['file'], '.');
				if($pos !== false){
					$text = substr($l['file'], 0, $pos);
				}
				$text = str_replace('_', ' ', $text);
					echo '<div class="pull-left" style="font-size:14px;width:100px;text-align:center">'.(empty($l['schedule_month']) ? "" : str_pad($l['schedule_month'], 2, '0', STR_PAD_LEFT).' / ').$l['schedule_year'].'</div>';
					echo '<div class="pull-left" style="font-size:14px;width:180px;margin:0 10px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis"><a href="'.base_url().'seminar?location='.(empty($l['office_name']) ? 'Other' : $l['office_name']).'">'.(empty($l['office_name']) ? 'Other' : $l['office_name']).'</a></div>';
					echo '<div class="overflow:hidden;margin-left:10px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis"><a href="'.base_url(),'src/schedule/'.$l['schedule_year'].'/'.$l['file'].'" target="_blank">'.$text.'</a></div>';
				?>
			</li>
		<?php
		}
	}
		?>
		<li style="font-size:14px;text-align:center">
			<a class="btn btn-link <?php echo count($list) == 0 ? 'disabled' : '';?>" href="<?php echo base_url().'seminar?pg=1'.(empty($year) ? '' : "&year=$year").(empty($location) ? '' : "&location=$location");?>">First</a>
			<a class="btn btn-link <?php echo $current > 1 ? '' : 'disabled';?>" href="<?php echo base_url().'seminar?pg='.($current - 1).(empty($year) ? '' : "&year=$year").(empty($location) ? '' : "&location=$location");?>">Prev</a>
			<?php echo (empty($list) ? 0 : $current).' / '.$total;?>
			<a class="btn btn-link <?php echo $current < $total ? '' : 'disabled';?>" href="<?php echo base_url().'seminar?pg='.($current + 1).(empty($year) ? '' : "&year=$year").(empty($location) ? '' : "&location=$location");?>">Next</a>
			<a class="btn btn-link <?php echo count($list) == 0 ? 'disabled' : '';?>" href="<?php echo base_url().'seminar?pg='.$total.(empty($year) ? '' : "&year=$year").(empty($location) ? '' : "&location=$location");?>">Last</a>
		</li>
	</ul>
</div>
