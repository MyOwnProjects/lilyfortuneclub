<div >
	<form method="post" action="<?php echo base_url();?>smd/events/<?php echo isset($events_id) ? "edit/$events_id" : "create";?> "style="margin:40px">
		<?php 
		if(isset($error) && $error){
		?>
		<div class="alert alert-danger"><?php echo $error;?></div>
		<?php
		}
		if(isset($event_guests)){
		?>
		<div class="row"><div class="col-lg-12 form-group"><a href="#event-guests" class="pull-right">Registered Guest List</a></div></div>
		<?php
		}
		?>
		<div class="row">
			<div class="col-lg-6 form-group">
				<label>Subject</label>
				<input class="form-control" name="events_subject" value="<?php echo isset($events_subject) ? $events_subject : '';?>" required>
			</div>
			<div class="col-lg-6">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 form-group">
						<label>From</label>&nbsp;
						<div class="input-group input-group-sm" id="dp-from">
							<input class="form-control" name="events_start_time" type="text" value="<?php echo isset($events_start_time) ? $events_start_time : date_format(date_create(), 'Y-m-d H:i');?>" style="background:#fff">
							<div class="input-group-addon" style="cursor:pointer">
								<span class="glyphicon"><i class="glyphicon glyphicon-time"></i></span>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 form-group">
						<label>To</label>&nbsp;
						<div class="input-group input-group-sm" id="dp-to">
							<input class="form-control" name="events_end_time" type="text" value="<?php echo isset($events_end_time) ? $events_end_time : date_format(date_create(), 'Y-m-d H:i');?>" style="background:#fff">
							<div class="input-group-addon" style="cursor:pointer">
								<span class="glyphicon"><i class="glyphicon glyphicon-time"></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-5 col-md-5 form-group">
				<label>Street</label>
				<input class="form-control" name="events_street" value="<?php echo isset($events_street) ? $events_street : '';?>" required>
			</div>
			<div class="col-lg-3 col-md-3 form-group">
				<label>City</label>
				<input class="form-control" name="events_city" value="<?php echo isset($events_city) ? $events_city : '';?>" required>
			</div>
			<div class="col-lg-2 col-md-2 form-group">
				<label>State</label>
				<input class="form-control" name="events_state" value="<?php echo isset($events_state) ? $events_state : '';?>" required>
			</div>
			<div class="col-lg-2 col-md-2 form-group">
				<label>Zipcode</label>
				<input class="form-control" name="events_zipcode" value="<?php echo isset($events_zipcode) ? $events_zipcode : '';?>" required>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<label>Detail</label>
				<textarea class="form-control" style="height:300px" name="events_detail" id="events_detail"><?php echo isset($events_detail) ? $events_detail : '';?></textarea>
			</div>
		</div>
		<div class="form-group">
			<input class="btn btn-success pull-right" type="submit" value="submit">
		</div>
		<?php
		if(isset($event_guests)){
		?>
		<div class="row" id="event-guests">
			<h3>Registered guests</h3>
			<div class="table-responsive">
			<table class="table-bordered table-condensed" style="width:100%">
				<thead><tr class="bg-primary"><td></td><td>Name</td><td>Email</td><td>Phone</td><td>Referee</td></tr></thead>
				<?php
				foreach($event_guests as $i => $g){
					echo '<td>'.($i + 1).'</td>';
					echo '<td>'.$g['event_guests_name'].'</td>';
					echo '<td>'.$g['event_guests_email'].'</td>';
					echo '<td>'.$g['event_guests_phone'].'</td>';
					echo '<td>'.$g['event_guests_referee'].'</td>';
				}
				?>
			</table>
			</div>
		</div>
		<?php
		}
		?>
	</form>
</div>
<script>
(function($){
	$('#dp-from input').datetimepicker({
		format:'Y-m-d H:i',
		step: 30,
		minDate: new Date()
	});
	$('#dp-to input').datetimepicker({
		format:'Y-m-d H:i',
		step: 30,
		validateOnBlur: true,
		onShow:function( ct ){
			this.setOptions({
				minDate: $('#dp-from input').val() ? $('#dp-from input').val() : false
			});
		}
	});
	$('#dp-from .input-group-addon, #dp-to .input-group-addon').click(function(){
		$(this).prev().datetimepicker('show');
	});

	CKEDITOR.replace( 'events_detail', {
		enterMode: CKEDITOR.ENTER_P, 
		extraPlugins: 'autogrow',
		autoGrow_onStartup: true,
		/*removePlugins: 'resize'*/
	}).on('instanceReady', function(ev) {
		ev.editor.on('resize',function(reEvent){
		});
	});
}(jQuery));
</script>