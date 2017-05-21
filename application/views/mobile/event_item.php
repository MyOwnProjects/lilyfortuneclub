<div data-role="page" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => $events_subject.' - Lily Fortune Club'));?>
	<div data-role="main" class="ui-content">
		<div class="event-content">
			<h4><?php echo $events_subject;?></h4>
			<div><?php echo $events_detail;?></div>
			<?php 
			if($start_date == $end_date){
				$time = "$start_date, $start_time - $end_time";
			}
			else{
				$time = "$start_date, $start_time - $end_date, $end_time";
			}
			?>
			<p>Time: <?php echo $time;?></p>
			<p>Location: <?php echo "$events_street, $events_city, $events_state $events_zipcode";?></p>
		</div>
		<div id="sign-up-form">
			<form method="post" data-ajax="false" onsubmit="return signup_submit();">
				<input type="text" name="event_guests_name" placeholder="Your Name (Required)" required>
				<input type="email" name="event_guests_email" placeholder="Email (Required)" required>
				<input type="text" name="event_guests_phone" placeholder="Phone Number (Required)" required>
				<input type="text" name="event_guests_referee" placeholder="Referee Name (Optional)">
				<button type="submit" class="btn-1 ui-btn ui-corner-all">Sign up</button>
			</form>			
			<p style="display:none" class="w3-text-green">You have successfully signed up!<p>
		</div>
	</div>
</div>
<script>
function signup_submit(){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
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
				$('#sign-up-form p').show();
			}
			else{
				$('#popup').html('<p class="w3-text-red">Failed to sign up. Please do it again.</p>').popup('open');
			}
		},
		error: function(){
			$('#popup').html('<p class="w3-text-red">Failed to sign up. Please do it again.</p>').popup('open');
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
	return false;
}
</script>