<div class="main-body-wrapper">
<div id="tasks-grid"></div>
</div>
<script>
	$('#tasks-grid').data_table({
		header: [
			{id: 'tasks_case_no', text: 'Case #', sortable: true, width:'80px', align: 'left'}, 
			{id: 'tasks_name', text: 'Name', width:'100px', sortable: true}, 
			{id: 'tasks_subject', text: 'Subject',narrow_display: true}, 
			{id: 'tasks_type', text: 'Type', width:'100px', align: 'center', sortable: true}, 
			{id: 'tasks_priority', text: 'Priority', sortable: true, width:'60px', align: 'center',narrow_display: true}, 
			{id: 'tasks_create', text: 'Create', sortable: true, width:'50px', align:'center'},
			{id: 'tasks_due_date', text: 'Due', sortable: true, width:'50px', align:'center', narrow_display: true},
			{id: 'tasks_status', text: 'Status', sortable: true, width:'60px', align: 'center',narrow_display: true}, 
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
		order_by: {tasks_create: 'desc'},
		filter: {id: 'tasks_status', options:{
			new: '<span class="text-red glyphicon glyphicon-plus-sign"></span> New', 
			pending: '<span class="text-danger glyphicon glyphicon-question-sign"></span> Pending',
			done: '<span class="text-green glyphicon glyphicon-ok-sign"></span> Done',
			reopen: '<span class="text-danger glyphicon glyphicon-exclamation-sign"></span> Reopen'
		}}
	});
</script>
