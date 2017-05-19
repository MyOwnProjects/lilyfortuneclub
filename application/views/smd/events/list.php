<div class="main-body-wrapper">
<div id="events-grid"></div>
</div>
<script>
	$('#events-grid').data_table({
		header: [
			{id: 'events_subject', text: 'Subject'}, 
			{id: 'events_start_date', text: 'Start Date', align:'center', sortable: true, width:'130px'}, 
			{id: 'events_end_date', text: 'End Date', align:'center', sortable: true, width:'130px'}, 
			{id: 'events_city', text: 'Location', sortable: true, width:'150px'}, 
			{id: 'event_guests', text: 'Guests', sortable: true, width:'50px', align:'center'}, 
		],
		url: '<?php echo base_url();?>smd/events/get_event_list',
		customized_buttons: [
			{
				text: '<span class="glyphicon glyphicon-trash"></span>&nbsp;Delete',
				success_reload: true,
				checked: true,
				callback: function(param){
					new_item({
							title: 'Delete Event(s)', 
							url: '<?php echo base_url();?>smd/events/delete',
							param: param,
							button_labels: {primary: 'Yes', cancel: 'No'}
						});
				}
			},
		],
		filter: JSON.parse('<?php echo isset($filter) ? json_encode($filter) : json_encode(array());?>'),
		row_count: 20,
		order_by: {events_start_time: 'DESC'}
	});
</script>