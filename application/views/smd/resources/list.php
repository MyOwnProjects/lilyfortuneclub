<div class="main-body-wrapper">
<div id="resources-grid"></div>
</div>
<script>
	$('#resources-grid').data_table({
		header: [
			{id: 'subject', text: 'Subject', narrow_display: true}, 
			{id: 'top', text: 'Top', align:'center', sortable: true, width:'40px'}, 
			{id: 'language', text: 'Language', align:'center', sortable: true, width:'70px', narrow_display: true}, 
			{id: 'create_time', text: 'Create Time', align:'center', sortable: true, width:'150px'}, 
			{id: 'source', text: 'Source', sortable: true, width:'80px'}, 
		],
		url: '<?php echo base_url();?>smd/resources/get_resource_list',
		customized_buttons: [
			{
				text: '<span class="glyphicon glyphicon-trash"></span>&nbsp;Delete',
				success_reload: true,
				checked: true,
				callback: function(param){
					new_item({
							title: 'Delete Resource(s)', 
							url: '<?php echo base_url();?>smd/resources/delete',
							param: param,
							button_labels: {primary: 'Yes', cancel: 'No'}
						});
					/*$.ajax({
						url: '<?php echo base_url();?>smd/resources/delete',
						success: new_item({
							title: 'Delete Resource(s)', 
							url: '<?php echo base_url();?>smd/resources/delete',
							param: param,
							button_labels: {primary: 'Yes', cancel: 'No'}
						}),
						error: function(a, b, c){
							Dialog.error(a.responseText);
						}
					});*/
				}
			},
		],
		filter: JSON.parse('<?php echo isset($filter) ? json_encode($filter) : json_encode(array());?>'),
		row_count: 20,
		order_by: {create_time: 'DESC'}
	});
</script>