<style>
.aRow{padding:2px 0;}
.row-value{overflow:hidden}
</style>
<table class="table table-striped table-condensed">
	<tr>
        <th>Topics&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>Presenters</th>
	</tr>
<?php
	$t = explode("\n", $schedule_topic);
	$p = explode("\n", $schedule_presenters);
	$tt = array();
	for($i = 0; $i < max(count($t), count($p)); ++$i){
?>
<tr>
<?php
	echo "<td>".($i < count($t) ? $t[$i] : '')."</td>";
	echo "<td>".($i < count($p) ? $p[$i] : '')."</td>";
?>
</tr>	
<?php
	}
?>
</table>
<div class="aRow clearfix">
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
		echo "<b>Time:</b> $start_str - $end_str";
	?>
	</div>
</div>
<div class="aRow clearfix">
	<div class="row-value"><b>Location:</b> <?php echo empty($schedule_location) ? $schedule_address : $schedule_location.' office';?></div>
</div>
<div class="aRow clearfix">
	<div class="row-value"><b>Comment:</b> <?php echo empty($schedule_comment) ? 'N/A' : $schedule_comment;?></div>
</div>

