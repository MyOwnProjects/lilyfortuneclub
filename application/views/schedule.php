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
    var full_calendar = $('#calendar').fullCalendar({
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
		eventClick: function(event, element) {
			var d = new Date(event.start);
			$.ajax({
				url : '<?php echo base_url();?>schedule/get_event/' + event.id + '?start=' 
					+ d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate(),
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

	events: '<?php echo base_url();?>schedule/get_events?sadsdasd',
    dayClick: function(date, jsEvent, view, resource) {
        console.log(
          'dayClick',
          date.format(),
          resource ? resource.id : '(no resource)'
        );
      }
    });
	/*for(var i = 0; i < 2; ++i){
		var event = {
			id: i,
			daysOfWeek: 2,
			title: "test",
			startTime: "10:00:00",
			endTime: "11:30:00"
		};
		full_calendar.addEvent(event);
	}*/
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
