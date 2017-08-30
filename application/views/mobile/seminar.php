<?php
$back_imgs = array(
	'bkg_01_january.jpg','bkg_02_february.jpg','bkg_03_march.jpg', 'bkg_04_april.jpg', 'bkg_05_may.jpg', 'bkg_06_june.jpg',
	'bkg_07_july.jpg','bkg_08_august.jpg','bkg_09_september.jpg', 'bkg_10_october.jpg', 'bkg_11_november.jpg', 'bkg_12_december.jpg'
);
$month = intval($month);
?>
<style>
.background-list{position:relative;font-family:Comic Sans MS, cursive, sans-serif;font-size:16px;min-height:300px;
}
.ui-content:after{
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
.background-list-block{padding:10px 0}
.background-list-block>div{text-align:center;line-height:30px;}
</style>
<div data-role="page" id="seminar" data-theme="f">
	<?php $this->load->view('mobile/header', array('header_text' => 'Seminar'));?>
	<div data-role="main" class="ui-content" data-theme="d">
			<div class="background-list">
			<h3 style="margin-bottom:20px;text-align:center;font-family:Comic Sans MS, cursive, sans-serif !important;border-bottom:1px solid #d5d5d5"><?php echo date_format(date_create("$year-".($month)."-01"), 'F, Y');?></h3>
				<?php
				if(count($list)== 0){
				?>
				<div style="line-height:300px;text-align:center">No schedule available.</div>
				<?php
				}
				foreach($list as $l){
					$start_date = date_create($l['schedule_date_start']);
					if(!empty($l['schedule_date_end'])){
						$end_date = date_create($l['schedule_date_end']);
					}
					else{
						$end_date = null;
					}

					$pos = strpos($l['file'], '.');
					if($pos !== false){
						$text = substr($l['file'], 0, $pos);
					}
					$text = str_replace('_', ' ', $text);
				?>
					<div class="background-list-block">
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
				?>
			</div>
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
			
			<div class="page-nav">
				<a class="nav-prev" data-ajax="false" data-role="button" data-inline="true" data-mini="true" data-theme="b" data-icon="arrow-l" href="<?php echo base_url();?>seminar?year=<?php echo $last_year;?>&month=<?php echo $last_month;?>" data-transition="slide" data-iconpos="left" data-direction="reverse">Prev</a>
				<a class="nav-next" data-ajax="false" data-role="button" data-icon="arrow-r" data-theme="b" href="<?php echo base_url();?>seminar?year=<?php echo $next_year;?>&month=<?php echo $next_month;?>" data-transition="slide" data-iconpos="right" data-inline="true" data-mini="true">Next</a>
			</div>
	</div>
</div>
