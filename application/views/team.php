<style>
.main-content-wrapper{max-width:1000px !important}	
.nav-tabs>li{width:25%}
.tab-content-page{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content-page p{margin-bottom:20px}	

#page-summary .row>div>div:first-child{float:left;font-weight:bold;width:100px;margin-right:20px;line-height:30px}
#page-summary .row>div>div:nth-child(2){overflow:hidden;line-height:30px}
</style>
<div class="main-content-wrapper">
	<h2 class="text-center">My Team</h2>
	<ul class="nav nav-tabs clearfix" id="top-tab">
		<li class="active"><a data-toggle="tab" href="#page-summary">Summary</a></li>
		<li><a data-toggle="tab" href="#page-baseshop">Base Shop</a></li>
		<li><a data-toggle="tab" href="#page-hierarchy">Hierarchy</a></li>
		<li><a data-toggle="tab" href="#page-recruits">Recruits</a></li>
	</ul>
	<div id="tab-content-pages" class="tab-content">
		<div id="page-summary" class="tab-pane fade in active tab-content-page">
				<div class="row">
					<div class="col-xs-12 clearfix">
						<div>Your Code:</div><div><?php echo $user['membership_code'];?></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 clearfix">
						<div>Your Level:</div><div><?php echo $user['grade'];?></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 clearfix">
						<div>Your Upline:</div><div><?php echo empty($user['first_name2']) ? 'N/A' : $user['first_name2'].' '.$user['last_name2'].(empty($user['nick_name2']) ? '' : ' ('.$user['nick_name2'].')');?></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 clearfix">
						<div>Your Baseshop:</div><div><?php echo $user['children'];?></div>
					</div>
				</div>
		</div>
		<div id="page-baseshop" class="tab-pane fade tab-content-page">
			<div class="clearfix">
				<div id="team-member-grid-baseshop"></div>
			</div>
		</div>
		<div id="page-hierarchy" class="tab-pane fade tab-content-page">
			<div class="clearfix">
				<div id="team-member-grid-hierarchy"></div>
			</div>
			<script>
				$('#team-member-grid-hierarchy').tree_grid('', '<?php echo base_url();?>account/team/get_direct_downline');
			</script>
		</div>
		<div id="page-recruits" class="tab-pane fade tab-content-page">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="form-group">
						<label>Type</label>
						<select class="form-control control-sm" id="recruits-type-select">
							<option value="P">Personal Recruits</option>
							<option value="T">Baseshop Recruits</option>
							<option value="3_30">Rolling 3/30</option>
							<option value="6_30">Rolling 6/30</option>
							<option value="BBC10">BBC 10</option>
							<option value="BBC20">BBC 20</option>
						</select>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="form-group">
						<label>Team Member</label>
						<select class="form-control control-sm" data-live-search='true' id="recruits-baseshop-select">
							<option value="<?php echo $user['membership_code'];?>"><?php echo $user['first_name'].' '.$user['last_name'].' ('.$user['membership_code'].')';?></option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<div class="form-group">
						<label>Date From</label>
						<input type="date" class="form-control control-sm" id="recruits-date-from">
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="form-group">
						<label>Date To</label>
						<input type="date" class="form-control control-sm" id="recruits-date-to">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group text-right">
						<button class="btn btn-sm btn-primary" onclick="export_recruits();">Export</button>
						<button class="btn btn-sm btn-primary" onclick="get_recruits();">Go</button>
					</div>
				</div>
			</div>
			<div class="clearfix">
				<div id="recruits-grid"></div>
			</div>
			
		</div>
	</div>
</div>
<script>
function baseshop_sort(data, column, order){
	data.sort(
		function(x, y){
			return order == 'asc' ? x[column].localeCompare(y[column]) : y[column].localeCompare(x[column]);
		}
	);
}

function export_recruits(){
	var type = $('#recruits-type-select').val();
	var code = $('#recruits-baseshop-select').val();
	var date_from = $('#recruits-date-from').val();
	var date_to = $('#recruits-date-to').val();
	window.location.href = '<?php echo base_url();?>account/team/export_recruits?type=' + type + 
		'&code=' + code + '&date_from=' + date_from + '&date_to=' + date_to;
}

function get_recruits(){
	$('#recruits-grid').empty();
	ajax_loading(true);
	var type = $('#recruits-type-select').val();
	$.ajax({
		url: '<?php echo base_url();?>account/team/get_recruits',
		method: 'post',
		dataType: 'json',
		data: {
			type: type,
			code: $('#recruits-baseshop-select').val(),
			date_from: $('#recruits-date-from').val(),
			date_to: $('#recruits-date-to').val(),
		},
		success: function(data){
			if(data['success']){
				var data = data['data'];
				var table = $('<table>').addClass('table').addClass('table-striped').appendTo($('#recruits-grid'));
				if(type == 'P' || type == 'T'){
					table.append('<thead><tr><th>&nbsp;</th><th>Name</th><th>Code</th><th>Recruiter</th><th>Start Date</th></tr></thead>');
					var tbody = $('<tbody>').appendTo(table);
					for(var i = 0; i < data.length;++i){
						var tr = $('<tr>').appendTo(tbody);
						$('<td>').html(i + 1).appendTo(tr);
						//$('<td>').html('<a href="javascript:void(0)" class="detail-url" data-id="' + data[i]['membership_code'] + '">' + data[i]['name'] + '</a>').appendTo(tr);
						$('<td>').html('<a href="<?php echo base_url();?>account/team/team_member_info/' + data[i]['membership_code'] + '" target="_blank">' + data[i]['name'] + '</a>').appendTo(tr);
						$('<td>').html(data[i]['membership_code']).appendTo(tr);
						$('<td>').html(data[i]['recruiter_name'] + ' (' + data[i]['recruiter'] + ')').appendTo(tr);
						$('<td>').html(data[i]['start_date']).appendTo(tr);
					}
				}
				else if(type == '3_30' || type == '6_30'){
					table.append('<thead><tr><th>Recruiter</th><th>Recruit</th><th>Recruit</th><th>Date</th></tr></thead>');
					var tbody = $('<tbody>').appendTo(table);
					for(var recruiter in data){
						for(var i = 0; i < data[recruiter]['matches'].length; ++i){
							var match = data[recruiter]['matches'][i];
							for(var j = 0; j < match.length; ++j){
								var tr = $('<tr>').appendTo(tbody);
								if(j == 0){
									$('<td>').attr('rowspan', match.length).html(data[recruiter]['name'] + '<br/>' + recruiter).appendTo(tr);
								}
								$('<td>').html(match[j]['name']).appendTo(tr);
								$('<td>').html(match[j]['membership_code']).appendTo(tr);
								$('<td>').html(match[j]['start_date']).appendTo(tr);
							}
						}
					}
				}
			}
			else{
			}
		},
		error: function(a, b, c){
		},
		complete: function(){
			//ajax_loading(false);
		}
	});
}

$('body').delegate('.detail-url', 'click', function(){
	var code = $(this).attr('data-id');
	ajax_loading(true);
	$.ajax({
		url: '<?php echo base_url();?>account/team/get_member_info/' + code,
		dataType: 'json',
		success: function(data){
			if(data['success']){
				var row_data = {};
				var info = data['info'];
				row_data['Name'] = info['name']; 
				row_data['Code'] = info['membership_code']; 
				row_data['Level'] = info['grade']; 
				row_data['Start'] = info['start_date']; 
				var ancestors = data['ancestors'];
				var t = '';
				for(var i = ancestors.length - 1; i >= 0; --i){
					t += (i < ancestors.length - 1 ? '&nbsp;&rarr;&nbsp;' : '') + '<span>' + ancestors[i]['first_name'] + ' ' + ancestors[i]['last_name'] 
						+ (ancestors[i]['nick_name'] !== undefined && ancestors[i]['nick_name'] !== null && ancestors[i]['nick_name'].length > 0 ? ' (' + ancestors[i]['nick_name'] + ')' : '') + '</span>'; 
				}
				row_data['Upline'] = t; 
				row_data['Baseshop'] = info['children']; 
				row_data['Personal Recruits'] = 0; 

				var wrap = $('<div>');
				for(var label in row_data){
					var row = $('<div>').addClass('clearfix').css('padding', '5px 0').appendTo(wrap);
					var div_label = $('<div>').addClass('pull-left').css('font-weight', 'bold').css('width', '125px').css('margin-right', '5px').html(label + ':');
					var div_value = $('<div>').css('overflow', 'hidden').html(row_data[label]);
					row.append(div_label).append(div_value);
				}
				Dialog.modal({message: wrap.html(), title: 'Member Information'});
			}
			else{
				Dialog.modal({message: '<div class="alert alert-danger">' + data['message'] + '</div>', title: 'Error'});
			}
		},
		error: function(){
		},
		complete: function(){
			ajax_loading(true);
		}
	});	
});	

				$.ajax({
					url: '<?php echo base_url();?>account/team/get_baseshop',
					dataType: 'json',
					success: function(data){
						if(data['success']){
							var baseshop = data['baseshop'];
							baseshop_sort(baseshop, 'start_date', 'desc');
							var table = $('<table>').addClass('table').addClass('table-striped').appendTo($('#team-member-grid-baseshop'));
							table.append('<thead><tr><th>Name</th><th>Code</th><th>Level</th><th>Baseshop</th><th>Start Date</th></tr></thead>');
							var tbody = $('<tbody>').appendTo(table);
							for(var i = 0; i < baseshop.length;++i){
								var tr = $('<tr>').appendTo(tbody);
								//$('<td>').html('<a href="javascript:void(0)" class="detail-url" data-id="' + baseshop[i]['membership_code'] + '">' + baseshop[i]['name']).appendTo(tr);
								$('<td>').html('<a href="<?php echo base_url();?>account/team/team_member_info/' + baseshop[i]['membership_code'] + '" target="_blank">' + baseshop[i]['name'] + '</a>').appendTo(tr);
								$('<td>').html(baseshop[i]['membership_code']).appendTo(tr);
								$('<td>').html(baseshop[i]['grade']).appendTo(tr);
								$('<td>').html(baseshop[i]['children']).appendTo(tr);
								$('<td>').html(baseshop[i]['start_date']).appendTo(tr);
								var option = $('<option>').val(baseshop[i]['membership_code']).html(baseshop[i]['name'] + ' (' + baseshop[i]['membership_code'] + ')').appendTo($('#recruits-baseshop-select'));
							}
							$('#recruits-baseshop-select').selectpicker();
						}
						else{
							$('#team-member-grid-baseshop').html('<div class="alert alert-danger">' + data['message'] + '</div>');
						}
					},
					error: function(){
					},
					complete: function(){
					}
				});

</script>
