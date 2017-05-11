<div class="main-body-wrapper">
<div id="tasks-grid"></div>
</div>
<script>
	$('#tasks-grid').data_table({
		header: [
			{id: 'tasks_id', text: 'ID', sortable: true, width:'60px', align: 'center'}, 
			{id: 'tasks_priority', text: 'Priority', sortable: true, width:'60px', align: 'center'}, 
			{id: 'tasks_subject', text: 'Subject', sortable: true}, 
			{id: 'tasks_update', text: 'Update', sortable: true, width:'100px', align:'center'},
			{id: 'tasks_user', text: 'Assigned to', sortable: true, width:'120px', align:'center'},
			{id: 'tasks_due', text: 'Due', sortable: true, width:'100px', align:'center'},
			{id: 'tasks_status', text: 'Status', sortable: true, width:'60px', align: 'center'}, 
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
		order_by: {tasks_update: 'desc'},
		filter: {id: 'tasks_status', options:{
			new: '<span class="text-red glyphicon glyphicon-plus-sign"></span> New', 
			pending: '<span class="text-danger glyphicon glyphicon-question-sign"></span> Pending',
			done: '<span class="text-green glyphicon glyphicon-ok-sign"></span> Done',
			reopen: '<span class="text-danger glyphicon glyphicon-exclamation-sign"></span> Reopen'
		}}
	});
</script>
