<div data-role="page" id="event-list" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Events'));?>
	<div data-role="main" class="ui-content" data-theme="d">
		<form class="ui-filterable ui-content ui-mini ">
			<input id="event-filter" data-type="search">
		</form>
		<ul data-role="listview" data-filter="true" data-input="#event-filter"></ul>
	</div>
</div>

<div data-role="page" id="view-event-0" class="view-event" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Event</h1>
		<a href="#event-list" data-icon="back" data-iconpos="notext" data-transition="slide" data-direction="reverse">Back</a>
	</div>
	<div data-role="main" class="ui-content">
		<div class="event-content"></div>
		<div>
			<form method="post" data-ajax="false" action="<?php echo base_url();?>events/sign_up">
				<input type="text" name="event_guests_name" placeholder="Your Name (Required)" required>
				<input type="email" name="event_guests_email" placeholder="Email (Required)" required>
				<input type="text" name="event_guests_phone" placeholder="Phon Number (Required)" required>
				<input type="text" name="event_guests_referee" placeholder="Referee Name (Optional)">
				<button type="submit" class="btn-1 ui-btn ui-corner-all">Sign up</button>
			</form>
		</div>
	</div>
</div>
<script>
function load_events(){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	var pl = $('#event-list ul[data-role=listview]');
	pl.empty();
	$.ajax({
		url: '<?php echo base_url();?>events/get_list',
		dataType: 'json',
		success: function(data){
			if(data.length > 0){
				for(var i = 0; i < data.length; ++i){
					var content_wrapper = $('<div>').append(data[i]['content']);
					var $_li = $('<li>').addClass("clearfix").addClass("ui-li-static").addClass("ui-body-inherit");
					var $_a = $('<a>').attr('data-id', data[i]['events_id']).attr('href', '#view-event-0').addClass('nondec').attr('data-transition', 'slide').appendTo($_li);
					
/*					var img_wrappers = content_wrapper.children('.content-image');
					if(img_wrappers.length > 0){
						var $_thumbnail = $('<div>').addClass('thumbnail').appendTo($_a);
						$('<img src="' + $(img_wrappers[0]).children('img').attr('src') + '">').appendTo($_thumbnail);
					}*/
					$('<div>').addClass('list-text').append('<div class="sub">' + data[i]['events_subject'] + '</div>').append('<div class="info">' + data[i]['events_start_date'] + ', ' + data[i]['events_city'] + '</div>').appendTo($_a);

					$_li.appendTo(pl);
				}
			}
			else{
				pl.children(':first-child').html('No events').appendTo(pl);
			}
		},
		error: function(){
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
}

var event_id = 0;

$(document).delegate('#event-list ul[data-role=listview] a', 'click', function(){
	event_id = $(this).attr('data-id');
}).delegate('.nav-prev, .nav-next', 'click', function(){
	event_id = $(this).attr('data-id');
}).on("pageshow","#event-list",function(){
	load_events();
}).on('pagebeforeshow', '.view-event', function(){
	$('.event-content').empty();
}).on('pageshow', '.view-event', function(){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	$.ajax({
		url: '<?php echo base_url();?>events/item/' + event_id,
		dataType: 'json',
		success: function(data){
			var subject = $('<h4>').html(data['events_subject']);
			var time = '';
			if(data['start_date'] == data['end_date']){
				time = $('<p>').html('Time: ' + data['start_date'] + ', ' + data['start_time'] + ' - ' + data['end_time']);
			}
			else{
				time = $('<p>').html('Time: ' + data['start_date'] + ', ' + data['start_time'] + ' - ' + data['end_date'] + ', ' + data['end_time']);
			}
			var address = data['events_street'] + ', ' + data['events_city'] + ', ' + data['events_state'] + ' ' + data['events_zipcode'];
			var location = $('<p>').html('Location: ' + '<a href="https://www.google.com/maps/place/' + address + '" target="_blank">' + address + '</a>');
			var detail = $('<div>').html(data['events_detail']);
			$('.event-content').append(subject).append(detail).append(time).append(location);
		},
		error: function(){
			location.href="#event-list";
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
});
</script>
