<div class="main-body-wrapper">
<div id="live-events-grid"></div>
</div>
<script>
(function($){
	var my_jstz= jstz();
	$('#live-events-grid').data_table({
		header: [
			{id: 'uniqid', text: 'ID', sortable: true, width:'120px'}, 
			{id: 'title', text: 'Title', sortable: true}, 
			{id: 'youtube_code', text: 'Youtube Code', sortable: true, width:'100px', align: 'center'}, 
			{id: 'start_time', text: 'Start Time', sortable: true, width:'120px'}, 
			{id: 'timezone', text: 'Timezone', width:'200px'},
			{id: 'dst', text: 'DST', width:'60px', align: 'center'},
			{id: 'end_time', text: 'End Time', width:'120px'}, 
		],
		url: '<?php echo base_url();?>smd/live/get_live_event_list',
		customized_buttons: [
			{
				text: '<span class="glyphicon glyphicon-plus"></span>&nbsp;Create',
				success_reload: true,
				callback: function(param){
					/*$.ajax({
						url: '<?php echo base_url();?>smd/live/create?timezone=' + my_jstz.timezone_name + '&dst=' + (my_jstz.uses_dst ? 'Y' : 'N'),
						success: function(data){
							new_item({
								title: 'Create Live Event',
								data: data,
								url: '<?php echo base_url();?>smd/live/create',
								param: param
							}
						}),
						error: function(a, b, c){
							Dialog.error(a.responseText);
						}
					});*/
					$.extend(param, {
						url: '<?php echo base_url();?>smd/live/create?timezone=' + my_jstz.timezone_name + '&dst=' + (my_jstz.uses_dst ? 'Y' : 'N'),
						title: 'Create Live Event',
					});
					pop_up(param);
				}
			},
			{
				text: '<span class="glyphicon glyphicon-trash"></span>&nbsp;Delete',
				connected_id: 'delete',
				success_reload: true,
				checked: true,
				callback: function(param){
					new_item({
							title: 'Delete Document(s)', 
							url: '<?php echo base_url();?>smd/live/delete',
							param: param
						});
				}
			},
		],
		filter: JSON.parse('<?php echo isset($filter) ? json_encode($filter) : json_encode(array());?>'),
		row_count: 20,
		order_by: {start_time: 'asc'}
	});
}(jQuery));
</script>