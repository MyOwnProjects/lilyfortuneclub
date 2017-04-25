<div class="main-body-wrapper">
<div id="team-member-grid"></div>
</div>
<script>
	$('#team-member-grid').data_table({
		header: [
			{id: 'username', text: 'Username', sortable: true, width:'80px'}, 
			{id: 'name', text: 'Name', sortable: true, width:'120px'}, 
			{id: 'email', text: 'Email', sortable: true}, 
			{id: 'membership_code', text: 'Code', sortable: true, width:'40px', align:'center'},
			{id: 'grade', text: 'Grade', sortable: true, width:'40px', align:'center'},
			{id: 'status', text: 'Status', align: 'center', width: '50px', sortable: true},
			{id: 'create_date', text: 'Create Date',  width: '80px', sortable: true},
			{id: 'location', text: 'Location', align: 'center', width: '60px', sortable: true},
			{id: 'upline', text: 'Upline', width:'100px', sortable: true},
			{id: 'downline', text: 'Downline', width:'60px', align: 'center', sortable: true},
		],
		url: '<?php echo base_url();?>smd/team/get_member_list',
		customized_buttons: [
			{
				text: '<span class="glyphicon glyphicon-plus"></span>&nbsp;New',
				success_reload: true,
				callback: function(param){
					$.ajax({
						url: '<?php echo base_url();?>smd/team/add_memner',
						success: new_item({
							title: 'Add Member', 
							url: '<?php echo base_url();?>smd/team/add_member',
							param: param
						}),
						error: function(a, b, c){
							Dialog.error(a.responseText);
						}
					});
				}
			}
		],
		row_count: 20
	});
</script>
