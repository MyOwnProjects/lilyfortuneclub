<div class="main-body-wrapper">
<div id="team-member-grid"></div>
</div>
<script>
	$('#team-member-grid').data_table({
		header: [
			{id: 'seq', text: 'Seq', sortable: false, width:'50px', align:'right'},
			{id: 'membership_code', text: 'Code', sortable: true, width:'40px', align:'center', narrow_display: true},
			{id: 'name', text: 'Name', sortable: true, narrow_display: true}, 
			{id: 'status', text: 'Status', sortable: true, width:'50px', align:'center'},
			{id: 'licensed', text: 'Licensed', sortable: true, width:'60px', align:'center'}, 
			{id: 'grade', text: 'Grade', sortable: true, width:'50px', align:'center'},
			{id: 'start_date', text: 'Start/Transfer',  width: '100px', sortable: true},
			{id: 'original_start_date', text: 'Transfer', align: 'center', width: '60px', sortable: true},
			{id: 'location', text: 'Location', align: 'center', width: '60px', sortable: true},
			{id: 'upline', text: 'Recruiter', width:'100px', sortable: true, narrow_display: true},
			{id: 'children', text: 'Team', width:'50px', align: 'center', sortable: true},
		],
		url: '<?php echo base_url();?>smd/team/get_member_list',
		customized_buttons: [
			/*{
				text: '<span class="glyphicon glyphicon-plus"></span>&nbsp;New',
				success_reload: true,
				callback: function(param){
					new_item({
						title: 'Add Member', 
						url: '<?php echo base_url();?>smd/team/add_member',
						param: param
					});
				}
			},*/
			{
				text: '<span class="glyphicon glyphicon-export"></span>&nbsp;Export',
				checked: false,
				sub_menus:[
					{
						text: 'All',
						success_reload: false,
						checked: false,
						callback: function(param){
							var p = "";
							if(!jQuery.isEmptyObject(param['sort'])){
								p += "?sort=" + JSON.stringify(param['sort']);
							}
							if(param['search']){
								p += "&search=" + param['search'].trim();
							}
							if(param['filter'].length > 0){
								p += "&filter=" + JSON.stringify(param['filter']);
							}
							//console.log('<?php echo base_url();?>smd/team/export' + p);
							location.href = '<?php echo base_url();?>smd/team/export' + p;
						}
					},
					{
						text: 'Google Import',
						success_reload: false,
						checked: false,
						callback: function(param){
							location.href = '<?php echo base_url();?>smd/team/export/google_import';
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
