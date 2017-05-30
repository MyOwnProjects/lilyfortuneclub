<style>
.event-subject{text-align:center;font-weight:bold}
.event-info{text-align:left}
.event-content{padding:40px 0;line-height:25px;}
.event-content .content-image{text-align:center;margin:40px auto} 
.event-content img{width:100%;max-width:600px}
@media only screen and (max-width:800px) {
.resource-subject, .resource-info{text-align:left;font-weight:normal}
}
</style>
<div class="resource main-content-wrapper">
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url();?>">Home</a></li>
		<li><a href="<?php echo base_url();?>events">Seminar</a></li> 
		<li class="active">Item</li> 
	</ul>

	<h3 class="event-subject"><?php echo $events_subject;?></h3>
	<div class="event-content"><?php echo $events_detail;?></div>
	<?php 
	if($start_date == $end_date){
		$time = "$start_date, $start_time - $end_time";
	}
	else{
		$time = "$start_date, $start_time - $end_date, $end_time";
	}
	?>
	<p><label>Time:</label> <?php echo $time;?></p>
	<?php $address = "$events_street, $events_city, $events_state $events_zipcode";?>
	<p><label>Location:</label> <a href="https://www.google.com/maps/place/<?php echo $address;?>" target="_blank"><?php echo $address;?></a></p>
	<div id="sign-up-form">
		<div class="alert" style="visibility:hidden">&nbsp;</div>
		<form method="post" data-ajax="false" onsubmit="return signup_submit();">
			<div class="form-group">
				<input class="form-control" type="text" name="event_guests_name" placeholder="Your Name (Required)" required>
			</div>
			<div class="form-group">
				<input class="form-control" type="email" name="event_guests_email" placeholder="Email (Required)" required>
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="event_guests_phone" placeholder="Phone Number (Required)" required>
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="event_guests_referee" placeholder="Referee Name (Optional)">
			</div>
			<button type="submit" class="btn btn-primary">Sign up</button>
		</form>
	</div>
	
</div>
<script>
function signup_submit(){
	ajax_loading(true);
	var data = {event_guests_event_id: <?php echo $events_id;?>};
	$('#sign-up-form input').each(function(index, obj){
		data[$(obj).attr('name')] = $(obj).val();
	});
	$.ajax({
		url: '<?php echo base_url();?>events/sign_up',
		method: 'post',
		data: data,
		dataType: 'json',
		success: function(data){
			if(data['success']){
				$('#sign-up-form form').hide();
				$('#sign-up-form .alert').removeClass('alert-danger').addClass('alert-success').html('<span class="glyphicon glyphicon-ok-sign"></span>&nbsp;You have successfully signed up!').css('visibility', 'visible');
			}
			else{
				$('#sign-up-form .alert').removeClass('alert-success').addClass('alert-danger').html('<span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Failed to sign up. Please do it again.').css('visibility', 'visible');
			}
		},
		error: function(){
			$('#sign-up-form .alert').removeClass('alert-success').addClass('alert-danger').html('<span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Failed to sign up. Please do it again.').css('visibility', 'visible');
		},
		complete: function(){
			ajax_loading(false);
		}
	});
	return false;
}
</script>