<div class="main-body-wrapper">
<div id="sales-grid"></div>
</div>
<script>
	$('#sales-grid').data_table({
		header: [
			{id: 'policies_number', text: 'Policy#', sortable: true, width:'100px', valign: 'middle', align: 'left'}, 
			{id: 'policies_status', text: 'Status', sortable: true, width:'60px', valign: 'middle', align: 'left'}, 
			{id: 'policies_name', text: 'Insured / Owner', width:'200px'}, 
			{id: 'policies_issue_date', text: 'Issure Date', width:'90px', valign: 'middle', align: 'center', sortable: true}, 
			{id: 'policies_provider', text: 'Provider', valign: 'middle', width:'70px', align: 'center', sortable: true}, 
			{id: 'policies_agents', text: 'Agents', valign: 'middle', align:'left', width: '150px'},
			{id: 'policies_notes', text: 'Notes', align:'left'},
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
		order_by: {self_agent: 'DESC', policies_issue_date: 'desc'},
		filter: {id: 'sales_status', options:{
			P: '<span class="text-danger">Pending</span>',
			I: '<span class="text-green"> Inforced</span>',
			C: '<span class="text-muted">Closed</span>',
			CA: '<span class="text-muted">Canceled</span>',
		}}
	});
</script>
