<style>
body, #main{position:absolute;top:0;right:0;bottom:0;left:0;}
#main-body{position:absolute;right:20px;bottom:20px;left:20px}
footer{display:none}
.fc-event{cursor: pointer;}
@media only screen and (max-width:900px) {
}
</style>
<div id="calendar"></div>
<script>
$(function() {
	$('#main-body').css('top', $('#main-header').outerHeight() + 20);
	var $_calendar = $('#calendar').fullCalendar({
		height: 'parent',
		windowResize: function(view) {
			$('#main-body').css('top', $('#main-header').outerHeight() + 20);
		},
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		//defaultDate: '2018-03-12',
		navLinks: true, // can click day/week names to navigate views
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		eventStartEditable: false,
		eventRender: function (event, element) {
			element.find('.fc-title').html(event.title);
		},
		
		eventClick: function(event, element) {
			$.ajax({
				url : '<?php echo base_url();?>schedule/get_event/' + event.id,
				success: function(data){
					bootbox.dialog({
						title: 'Schedule',
						message: data,
						buttons: {
							cancel: {
								label: 'Close',
								className: "btn"
							}
						}
					});
				}
			});
		},
		events: '<?php echo base_url();?>schedule/get_events'
	});
	/*ajax_loading(true);
	$.ajax({
		url: '<?php echo base_url();?>schedule/get_events',
		dataType: 'json',
		success: function(data){
			$_calendar.fullCalendar('renderEvents',data);
		},
		error: function(a, b, c){
		},
		complete: function(){
			ajax_loading(false);
		}
	});*/
});
</script>	
