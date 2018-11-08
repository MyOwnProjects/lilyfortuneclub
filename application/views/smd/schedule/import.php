<form method="post">
	<div style="padding:10px">
		<input class="btn btn-primary btn-sm" type="submit" value="Submit">
	</div>
	<table cellspacing="0" cellpadding="0">
		<thead>
			<tr><td></td><td>Start</td><td>End</td><td>Topic</td><td>Presenters</td><td>Location</td><td>Address</td><td>Comment</td></tr>
		</thead>
	<?php
	for($i = 0; $i < 50; ++$i){
	?>
		<tr>
			<td><?php echo $i + 1;?></td>
			<td style="width:225px">
				<div class="input-group">
					<input class="form-control form-control-sm" type="date" name="schedule_start_date[]" style="width:125px">
					<select class="form-control form-control-sm" name="schedule_start_time[]" style="width:55px">
						<option value="0">None</option>
						<?php
						for($j = 0; $j < 24; ++$j){
						?>
						<option value="<?php echo $j;?>:00"><?php echo $j;?>:00</option>
						<option value="<?php echo $j;?>:30"><?php echo $j;?>:30</option>
						<?php
						}
						?>
					</select>
				</div>
			</td>
			<td style="width:225px">
				<div class="input-group">
					<input class="form-control form-control-sm" type="date" name="schedule_end_date[]" style="width:125px">
					<select class="form-control form-control-sm" name="schedule_end_time[]" style="width:55px">
						<option value="0">None</option>
						<?php
						for($j = 0; $j < 24; ++$j){
						?>
						<option value="<?php echo $j;?>:00"><?php echo $j;?>:00</option>
						<option value="<?php echo $j;?>:30"><?php echo $j;?>:30</option>
						<?php
						}
						?>
					</select>
				</div>
			</td>
			<td><input class="form-control form-control-sm" name="schedule_topic[]" style="width:150px"></td>
			<td><input class="form-control form-control-sm" name="schedule_presenters[]" style="width:100px"></td>
			<td>
				<select class="form-control form-control-sm" name="schedule_location[]">
					<option value="Fremont">FR</option>
					<option value="San Jose">SJ</option>
					<option value="Pleasanton">PL</option>
					<option value="0">Other</option>
				</select>
			</td>
			<td><input class="form-control form-control-sm" name="schedule_address[]"></td>
			<td><input class="form-control form-control-sm" name="schedule_comment[]"></td>
		</tr>
	<?php
	}
	?>
	</table>
</form>