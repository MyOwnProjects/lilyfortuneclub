<div class="main-body-wrapper">
<div id="sales-grid"></div>
</div>
<script>
	$('#sales-grid').data_table({
		header: [
			{id: 'sales_priority', text: 'Status', sortable: true, width:'60px', align: 'left'}, 
			{id: 'sales_insured', text: 'Insured / Owner', width:'120px', sortable: true}, 
			{id: 'sales_date_submission', text: 'Date', width:'70px', align: 'center', sortable: true}, 
			{id: 'sales_provider', text: 'Provider', valign: 'middle', width:'70px', align: 'center', sortable: true}, 
			{id: 'sales_info', text: 'Info', align:'left'},
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
		row_count: 100,
		order_by: {self_agent: 'DESC', sales_priority: 'DESC', sales_date_submission: 'asc'},
		filter: {id: 'sales_status', options:{
			P: '<span class="text-danger">Pending</span>',
			I: '<span class="text-green"> Inforced</span>',
			C: '<span class="text-muted">Closed</span>',
			CA: '<span class="text-muted">Canceled</span>',
		}}
	});
</script>
