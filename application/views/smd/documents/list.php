<div class="main-body-wrapper">
<div id="documents-grid"></div>
</div>
<script>
	$('#documents-grid').data_table({
		header: [
			{id: 'subject', text: 'Subject', }, 
			{id: 'file_name', text: 'File Name', sortable: true, width:'150px'}, 
			{id: 'grade_access', text: 'Grade Access', sortable: true, width:'120px'}, 
			{id: 'mime_content_type', text: 'File Type', sortable: true, width:'60px'}, 
			{id: 'content_type', text: 'Content Type', sortable: true, width:'100px'}, 
			{id: 'create_date', text: 'Created', sortable: true, width:'130px'}, 
			{id: 'file_size', text: 'File Size', sortable: true, width:'60px'}, 
		],
		url: '<?php echo base_url();?>smd/documents/get_document_list',
		customized_buttons: [
			/*{
				text: '<span class="glyphicon glyphicon-upload"></span>&nbsp;Upload',
				success_reload: true,
				callback: function(param){
					$.ajax({
						url: '<?php echo base_url();?>smd/documents/upload',
						success: new_item({
							title: 'Upload Document(s)', 
							url: '<?php echo base_url();?>smd/documents/upload',
							param: param
						}),
						error: function(a, b, c){
							Dialog.error(a.responseText);
						}
					});
				}
			},*/
			{
				text: '<span class="glyphicon glyphicon-edit"></span>&nbsp;Update',
				checked: true,
				sub_menus:[
					{
						text: 'Update Content Type',
						success_reload: true,
						checked: true,
						callback: function(param){
							$.ajax({
								url: '<?php echo base_url();?>smd/documents/bulk_update/content_type',
								success: new_item({
									title:'Update Document(s)', 
									url: '<?php echo base_url();?>smd/documents/bulk_update/content_type',
									param: param
								}),
								error: function(a, b, c){
									Dialog.error(a.responseText);
								}
							});
						}
					},
					{
						text: 'Update Grade Access', 
						success_reload: true,
						checked: true,
						callback: function(param){
							$.ajax({
								url: '<?php echo base_url();?>smd/documents/bulk_update/grade_access',
								success: new_item({
									title: 'Update Document(s)', 
									url: '<?php echo base_url();?>smd/documents/bulk_update/grade_access',
									param: param
								}),
								error: function(a, b, c){
									Dialog.error(a.responseText);
								}
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
					$.ajax({
						url: '<?php echo base_url();?>smd/documents/delete',
						success: new_item({
							title: 'Delete Document(s)', 
							url: '<?php echo base_url();?>smd/documents/delete',
							param: param
						}),
						error: function(a, b, c){
							Dialog.error(a.responseText);
						}
					});
				}
			},
		],
		filter: JSON.parse('<?php echo isset($filter) ? json_encode($filter) : json_encode(array());?>'),
		row_count: 20,
		order_by: {create_date: 'desc'}
	});
</script>