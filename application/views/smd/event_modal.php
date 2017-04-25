<style>
[name=event-date]{display:inline !important;width:150px !important}
[name=event-start-time],[name=event-end-time]{display:inline !important;width:auto !important} 
</style>
<div class="form-group">
  <label for="event_subject">Subject:</label>
  <input type="text" class="form-control" id="event_subject" value="<?php echo $is_new ? '' : $event['subject'];?>">
</div>
<div class="form-group">
	<label for="event_detail">Detail:</label>
	<textarea class="form-control" rows="5" id="event_detail"><?php echo $is_new ? '' : $event['detail'];?></textarea>
</div>
<div class="form-group">
  <label for="event_days">Number of Consecutive Days:</label>
  <select class="form-control" id="event_days" before-change-value="0" onchange="update_event_time_groups()">
	  <?php
		$days = $is_new ? 1 : count($event['time']);
		for($i = 1; $i <= 14; ++$i){
			echo '<option class="form-control" value="'.$i.'" '.($i == $days ? 'selected' : '').'>'.$i.'</option>';
		}
	  ?>
  </select>
</div>
<div id="event_time_group" style="max-height:150px;overflow:auto">
</div>	
<script>
<?php
$event_times = $is_new ? array(array(date_format(date_create(), 'Y-m-d 06:00:00'), date_format(date_create(), 'Y-m-d 06:30:00'))) : $event['time'];
?>
(function(){
	update_event_time_groups(JSON.parse('<?php echo json_encode($event_times);?>'));
	$('#event_time_group [name=event-start-time]').change(function(){
		update_event_time_values(this);
	});
	//$('#event_time_group').children('.form-group').first().children('[name=event-date]').datepicker().
	//	datepicker("option", "dateFormat", "yy-mm-dd").val('');
	//update_event_date_values();
})();
</script>


