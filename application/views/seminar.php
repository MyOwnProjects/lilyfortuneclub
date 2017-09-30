<?php
$back_imgs = array(
	'bkg_01_january.jpg','bkg_02_february.jpg','bkg_03_march.jpg', 'bkg_04_april.jpg', 'bkg_05_may.jpg', 'bkg_06_june.jpg',
	'bkg_07_july.jpg','bkg_08_august.jpg','bkg_09_september.jpg', 'bkg_10_october.jpg', 'bkg_11_november.jpg', 'bkg_12_december.jpg'
);
$month = intval($month);
?>
<style>
ul, ul li{list-style:none}
.background-list-block{position:relative;padding:80px 20px;font-family:Comic Sans MS, cursive, sans-serif}
.background-list-block:after{
	content: "";
	background-image:url('<?php echo base_url();?>src/img/12 Google Calendar Walls/<?php echo $back_imgs[$month - 1];?>');
	background-size:100% 100%;
	opacity: 0.2;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	position: absolute;
	z-index: -1;
}
.background-list-block-line>div{line-height:60px}
.background-list-block-line>div a{color:#ff0000;text-decoration:underline}
.background-list-block-line>div:first-child{float:left;width:250px;margin-right:40px;text-align:center}
.background-list-block-line>div:nth-child(2){float:left;width:180px;margin-right:20px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
.background-list-block-line>div:last-child{overflow:hidden;margin-left:10px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
@media only screen and (max-width:768px) {
.background-list-block{padding:40px 20px}
.background-list-block-line{margin-bottom:40px}
.background-list-block-line>div{line-height:30px;text-align:center}
.background-list-block-line>div:first-child,
.background-list-block-line>div:nth-child(2),
.background-list-block-line>div:last-child{float:none;display:block;width:100%}
.background-list-block:after{
	background-size:auto 100%;
}
}
	
</style>
<div class="resource-list  main-content-wrapper background-list-block">
		<h2 class="text-center" style="margin-bottom:40px"><?php echo date_format(date_create("$year-".($month)."-01"), 'F, Y');?></h2>
		<div style="font-size:18px;min-height:300px">
		<?php
		if(count($list) == 0){
		?>
			<div style="text-align:center;line-height:300px">No schedules available so far.</div>
		<?php
		}
		else{
			foreach($list as $l){
			?>
				<div class="clearfix background-list-block-line">
					<?php
					$start_date = date_create($l['schedule_date_start']);
					if(!empty($l['schedule_date_end'])){
						$end_date = date_create($l['schedule_date_end']);
					}
					else{
						$end_date = null;
					}
					
					$pos1 = strpos($l['file'], '.');
					if($pos1 !== false){
						$pos2 = strrpos($l['file'], '.');
						if($pos2 == $pos1){
							$text = substr($l['file'], 0, $pos1);
						}
						else{
							$text = substr($l['file'], $pos1 + 1, $pos2 - $pos1 - 1);
						}
					}
					$text = str_replace('_', ' ', $text);
					?>
						<div>
							<?php echo date_format($start_date, 'M d, Y');
							if(!empty($end_date)){
							?>
							 - 
							<?php
								echo date_format($end_date, 'M d, Y');
							}
							?>
						</div>
						<div>
							<?php echo (empty($l['office_name']) ? 'Other' : $l['office_name']);?>
						</div>
						<div>
							<a href="<?php echo base_url();?>src/schedule/<?php echo date_format($start_date, 'Y').'/'.$l['file'];?>" target="_blank"><?php echo $text;?></a>
						</div>
				</div>
			<?php
			}
		}
		?>
		</div>
		<div class="text-center">
			<?php 
			if($month == 1){
				$last_month = 12;
				$last_year = $year - 1;
			}
			else{
				$last_month = $month - 1;
				$last_year = $year;
			}
			if($month == 12){
				$next_month = 1;
				$next_year = $year + 1;
			}
			else{
				$next_month = $month + 1;
				$next_year = $year;
			}
			?>
			<a class="btn btn-link" href="<?php echo base_url();?>seminar?year=<?php echo $last_year;?>&month=<?php echo $last_month;?>">Last Month</a>
			<a class="btn btn-link" href="<?php echo base_url();?>seminar?year=<?php echo $next_year;?>&month=<?php echo $next_month;?>">Next Month</a>
		</div>
</div>
