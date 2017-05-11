<div class="main-body-wrapper">
<div id="documents-grid"></div>
</div>
<script>
	$('#documents-grid').data_table({
		header: [
			{id: 'file', text: 'File Name', sortable: true}, 
			{id: 'access', text: 'Access', sortable: true, width:'80px', align: 'center'}, 
			{id: 'date', text: 'Date', sortable: true, width:'60px', align: 'center'}, 
			{id: 'office_name', text: 'Location', sortable: true, width:'120px'}, 
		],
		url: '<?php echo base_url();?>smd/schedule/get_schedule_list',
		customized_buttons: [
			{
				text: '<span class="glyphicon glyphicon-plus"></span>&nbsp;Add',
				success_reload: true,
				callback: function(param){
					new_item({
							title: 'Add Schedule', 
							url: '<?php echo base_url();?>smd/schedule/add',
							param: param
						});
				}
			},
			{
				text: '<span class="glyphicon glyphicon-edit"></span>&nbsp;Update',
				checked: true,
				sub_menus:[
					{
						text: 'Access',
						success_reload: true,
						checked: true,
						callback: function(param){
							new_item({
									title: 'Update Schedule(s) Access', 
									url: '<?php echo base_url();?>smd/schedule/update/access',
									param: param
							});
						}
					},
					{
						text: 'Time',
						success_reload: true,
						checked: true,
						callback: function(param){
							new_item({
									title: 'Update Schedule(s) Time', 
									url: '<?php echo base_url();?>smd/schedule/update/time',
									param: param
							});
						}
					},					
					{
						text: 'Location', 
						success_reload: true,
						checked: true,
						callback: function(param){
							new_item({
								title: 'Update Schedule(s) Location', 
								url: '<?php echo base_url();?>smd/schedule/update/location',
								param: param
							});
						}
					}
				]
			},
			{
				text: '<span class="glyphicon glyphicon-trash"></span>&nbsp;Delete',
				connected_id: 'delete',
				success_reload: true,
				checked: true,
				callback: function(param){
					new_item({
						title: 'Delete Schedule(s)', 
						url: '<?php echo base_url();?>smd/schedule/delete',
						param: param
					});
				}
			},
		],
		filter: JSON.parse('<?php echo isset($filter) ? json_encode($filter) : json_encode(array());?>'),
		row_count: 20,
		'order_by': {date: 'DESC'}
	});
</script>