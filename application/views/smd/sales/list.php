<div class="main-body-wrapper">
<div id="sales-grid"></div>
</div>
<script>
	$('#sales-grid').data_table({
		header: [
			{id: 'sales_policy_no', text: 'Policy #', sortable: true, width:'70px', align: 'left'}, 
			{id: 'sales_client', text: 'Insured / Owner'}, 
			{id: 'sales_agents', text: 'Writing / Split Agent', align: 'left'}, 
			{id: 'sales_policy', text: 'Provider / Type', width:'180px', align: 'center'}, 
			{id: 'sales_date_submission', text: 'Submission / Closure', sortable: true, width:'160px', align: 'center'}, 
			{id: 'sales_face_amount', text: 'DB', sortable: true, width:'60px', align:'center'},
			{id: 'sales_status', text: 'Status', sortable: true, width:'60px', align:'center'},
		],
		url: '<?php echo base_url();?>smd/sales/get_sales_list',
		customized_buttons: [
			{
				text: '<span class="glyphicon glyphicon-trash"></span>&nbsp;Delete',
				success_reload: true,
				checked: true,
				callback: function(param){
					new_item({
						title: 'Delete Sales', 
						url: '<?php echo base_url();?>smd/sales/delete',
						param: param
					});
				}
			}
		],
		row_count: 20,
		//order_by: {tasks_create: 'desc'},
		filter: {id: 'sales_status', options:{
			P: '<span class="text-danger glyphicon glyphicon-question-sign"></span> Pending',
			I: '<span class="text-green glyphicon glyphicon-ok-sign"></span> Inforced',
			C: '<span class="text-muted glyphicon glyphicon-exclamation-sign"></span> Closed'
		}}
	});
</script>
