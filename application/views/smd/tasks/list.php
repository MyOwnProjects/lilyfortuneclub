<div class="main-body-wrapper">
<div id="tasks-grid"></div>
</div>
<script>
	$('#tasks-grid').data_table({
		header: [
			{id: 'tasks_case_no', text: 'Case #', sortable: true, width:'80px', align: 'left'}, 
			{id: 'tasks_subject', text: 'Subject',narrow_display: true, sortable: true}, 
			{id: 'tasks_type', text: 'Type', width:'100px', align: 'center', sortable: true}, 
			{id: 'tasks_priority', text: 'Priority', sortable: true, width:'60px', align: 'center',narrow_display: true}, 
			//{id: 'tasks_create', text: 'Create', sortable: true, width:'50px', align:'center'},
			{id: 'tasks_due_date', text: 'Due', sortable: true, width:'50px', align:'center', narrow_display: true},
			{id: 'tasks_status', text: 'Status', sortable: true, width:'60px', align: 'center',narrow_display: true}, 
			{id: 'tasks_name', text: 'Assign to', width:'150px'}, 
		],
		url: '<?php echo base_url();?>smd/tasks/get_task_list',
		customized_buttons: [
			{
				text: '<span class="glyphicon glyphicon-trash"></span>&nbsp;Delete',
				success_reload: true,
				checked: true,
				callback: function(param){
					new_item({
						title: 'Delete Tasks', 
						url: '<?php echo base_url();?>smd/tasks/delete',
						param: param
					});
				}
			}
		],
		row_count: 20,
		order_by: {tasks_due_date: 'desc'},
		filter: [
			{
				id: 'tasks_due_date',
				text: 'Due date',
				options:{
					'2 days': '2 days',
					future: 'All future'
				}
			},
			{
				id: 'tasks_status', 
				text: 'Status',
				options:{
					Pending: '<span class="text-warning">Pending</span>',
					Escalated: '<span class="text-danger">Escalated</span>',
					Done: '<span class="text-success">Done</span>',
				}
			},
			{
				id: 'tasks_type', 
				text: 'Type',
				options:{
					'BPM': 'BPM',
					'Fast Start': 'Fast Start',
					'Outstanding Requirement': 'Outstanding Requirement',
					'Process': 'Process',
					'Prospect': 'Prospect',
					'Recruit': 'Recruit',
					'Sales': 'Sales',
					'Team Building': 'Team Building',
					'Technical': 'Technical',
					'Other': 'Other'
				}
			},
		],
		filter_by: {tasks_status: 'Pending', tasks_due_date: '2 days'} 
	});
</script>
