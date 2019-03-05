<style>
/*body, #main{position:absolute;top:0;right:0;bottom:0;left:0;}
#main-body{position:absolute;right:20px;bottom:20px;left:20px}*/
footer{display:none}
.fc-event{cursor: pointer;}
@media only screen and (max-width:900px) {
}
</style>
<div id="calendar" style="margin:20px 10px 0 10px"></div>
<script>
    $('#calendar').fullCalendar({
		height: 'auto',
		schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
      //editable: true,
      selectable: true,
      eventLimit: true, // allow "more" link when too many events
	  eventLimitText: function(num){
		  return '+' + num;
	  },
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'agendaDay,agendaWeek,month'
      },
      allDaySlot: false,

		eventRender: function (event, element) {
			element.find('.fc-title').html(event.title);
		},
      events: [
        { id: '1', resourceId: 'a', start: '2018-04-06', end: '2018-04-08', title: 'event 1' },
        { id: '2', resourceId: 'a', start: '2018-04-07T09:00:00', end: '2018-04-07T14:00:00', title: 'event 2' },
        { id: '3', resourceId: 'b', start: '2018-04-07T12:00:00', end: '2018-04-08T06:00:00', title: 'event 3' },
        { id: '4', resourceId: 'c', start: '2018-04-07T07:30:00', end: '2018-04-07T09:30:00', title: 'event 4' },
        { id: '5', resourceId: 'd', start: '2018-04-07T10:00:00', end: '2018-04-07T15:00:00', title: 'event 5' }
      ],
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

	events: '<?php echo base_url();?>schedule/get_events',
      dayClick: function(date, jsEvent, view, resource) {
        console.log(
          'dayClick',
          date.format(),
          resource ? resource.id : '(no resource)'
        );
      }
    });
/*$(function() {
	$('#main-body').css('top', $('#main-header').outerHeight() + 20);//.css('padding', '0 10px');
	var $_calendar = $('#calendar').fullCalendar({
		//height: 'parent',
		windowResize: function(view) {
			//$('#main-body').css('top', $('#main-header').outerHeight() + 20);
			//$('#calendar').fullCalendar('option', 'height', 700)
		},
		eventLimit: true, // for all non-agenda views
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
});*/
</script>	
