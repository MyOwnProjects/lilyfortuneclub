<div class="main-body-wrapper">
<div id="team-member-grid"></div>
</div>
<script>
	$('#team-member-grid').data_table({
		header: [
			{id: 'membership_code', text: 'Code', sortable: true, width:'60px', align:'center'},
			{id: 'name', text: 'Name', sortable: true, width:'200px'}, 
			{id: 'email', text: 'Email', sortable: true}, 
			{id: 'grade', text: 'Grade', sortable: true, width:'40px', align:'center'},
			{id: 'status', text: 'Status', align: 'center', width: '50px', sortable: true},
			{id: 'start_date', text: 'Start Date',  width: '80px', sortable: true},
			{id: 'location', text: 'Location', align: 'center', width: '60px', sortable: true},
			{id: 'upline', text: 'Recruiter', width:'100px', sortable: true},
			{id: 'children', text: 'Downline', width:'60px', align: 'center', sortable: true},
		],
		url: '<?php echo base_url();?>smd/team/get_member_list',
		customized_buttons: [
			{
				text: '<span class="glyphicon glyphicon-plus"></span>&nbsp;New',
				success_reload: true,
				callback: function(param){
					new_item({
						title: 'Add Member', 
						url: '<?php echo base_url();?>smd/team/add_member',
						param: param
					});
				}
			},
			{
				text: '<span class="glyphicon glyphicon-export"></span>&nbsp;Export',
				checked: false,
				sub_menus:[
					{
						text: 'All',
						success_reload: false,
						checked: false,
						callback: function(param){
							location.href = '<?php echo base_url();?>smd/team/export';
						}
					},
					{
						text: 'Mobile Phone Only', 
						success_reload: false,
						checked: false,
						callback: function(param){
							location.href = '<?php echo base_url();?>smd/team/export/mobile_phone';
					}
					}
				]
				
			},
		],
		row_count: 50,
		order_by:{start_date: 'desc'}
	});
</script>
