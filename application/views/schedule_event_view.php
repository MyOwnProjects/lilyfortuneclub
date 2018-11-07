<style>
.aRow{padding:10px 10px;margin:0 10px;}
.aRow:not(:last-child){border-bottom:1px solid #d5d5d5}
.row-label{float:left;font-weight:bold;text-align:right;margin-right:10px;width:80px}
.row-value{overflow:hidden}
</style>
<div class="aRow clearfix">
	<div class="row-label"><b>Time:</b></div>
	<div class="row-value">
	<?php 
		$start_date_str = date_format(date_create($schedule_start_date), 'D, M j');
		$end_date_str = '';empty($schedule_end_date) ? '' : date_format(date_create($schedule_start_date), 'm/d/Y');
		if(!empty($end_date_str)){
			$end_date_str = date_format(date_create($schedule_end_date), 'D, M j');
			if($end_date_str == $start_date_str){
				$end_date_str = '';
			}
		}
		$start_time_str = empty($schedule_start_time) ? '' : date_format(date_create($schedule_start_time), 'h:iA');
		$end_time_str = empty($schedule_end_time) ? '' : date_format(date_create($schedule_end_time), 'h:iA');
		
		if(empty($end_date_str)){
			$start_str = $start_time_str;
			$end_str = $end_time_str.' '.$start_date_str;
		}
		else{
			$start_str = $start_time_str.' '.$start_date_str;
			$end_str = $end_time_str.' '.$end_date_str;
		}
		echo "$start_str - $end_str";
	?>
	</div>
</div>
<div class="aRow clearfix">
	<div class="row-label"><b>Location:</b></div>
	<div class="row-value"><?php echo empty($schedule_location) ? $schedule_address : $schedule_location;?></div>
</div>
<div class="aRow clearfix">
	<div class="row-label"><b>Topic:</b></div>
	<div class="row-value"><?php echo $schedule_topic;?></div>
</div>
<div class="aRow clearfix">
	<div class="row-label"><b>Presenters:</b></div>
	<div class="row-value"><?php echo $schedule_presenters;?></div>
</div>
<div class="aRow clearfix">
	<div class="row-label"><b>Comment:</b></div>
	<div class="row-value"><?php echo $schedule_comment;?></div>
</div>

