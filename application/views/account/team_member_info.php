<style>
.main-content-wrapper{max-width:800px !important}
.row{padding:5px 0}
.block-label{float:left;width1:120px;font-weight:bold;text-align:right1;padding-right:10px}
.block-value{overflow:hidden}
.nav-tabs>li{width:25%}
.tab-content-page{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content-page p{margin-bottom:20px}	

#page-summary .row>div>div:first-child{float:left;font-weight:bold;width:100px;margin-right:20px;line-height:30px}
#page-summary .row>div>div:nth-child(2){overflow:hidden;line-height:30px}
</style>
<div class="main-content-wrapper">
	<h2 class="text-center">Team Member</h2>
	<div style="height:40px"></div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="clearfix">
					<div class="block-label"><label>Name:</label></div>
					<div class="block-value"><?php echo $name;?></div>
				</div>
				<div class="clearfix">
					<div class="block-label">
						<label>Code:</label>
					</div>
					<div class="block-value"><?php echo $membership_code;?></div>
				</div>
				<div class="clearfix">
					<div class="block-label"><label>Grade:</label></div>
					<div class="block-value"><?php echo $grade;?></div>
				</div>
				<div class="clearfix">
					<div class="block-label">
						<label>Recruiter:</label>
					</div>
					<?php $count = count($ancestors);?>
					<div class="block-value"><?php echo $count > 2 ? $ancestors[$count - 2]['first_name'].' '.$ancestors[$count - 2]['last_name'].' ('.$ancestors[$count - 2]['membership_code'].')' : 'N/A';?></div>
				</div>
				<div class="clearfix">
					<div class="block-label"><label>Baseshop:</label></div>
					<div class="block-value"><?php echo $children;?></div>
				</div>
				<div class="clearfix">
					<div class="block-label">
						<label>Direct Downline:</label>
					</div>
					<div class="block-value"><?php echo $downline;?></div>
				</div>
				<div class="clearfix">
					<div class="block-label">
						<label>Birthday:</label>
					</div>
					<?php
					$dl = explode('-', $date_of_birth);
					?>
					<div class="block-value"><?php echo $dl[1].' / '.$dl[2];?></div>
				</div>
				<div class="clearfix">
					<div class="block-label"><label>Email:</label></div>
					<div class="block-value"><?php echo $email;?></div>
				</div>
				<div class="clearfix">
					<div class="block-label"><label>Address:</label></div>
					<div class="block-value"><?php echo $street.',<br/>'.$city.', '.$state.' '.$zipcode.'<br/>'.$country;?></div>
				</div>
				<div class="clearfix">
					<div class="block-label">
						<label>Phone:</label>
					</div>
					<div class="block-value"><?php echo str_replace(',', '<br/>', $phone);?></div>
				</div>
				<div class="clearfix">
					<div class="block-label">
						<label>Start Date:</label>
					</div>
					<div class="block-value"><?php echo $start_date;?></div>
				</div>
				<?php
					$u = '';
					foreach($ancestors as $i => $a){
						if($i > 0){
							$u .= '<br/><span class="glyphicon glyphicon-arrow-up"></span><br/>';
						}
						$u .= '<span class="badge" style="font-size:14px">'.$a['first_name'].' '.$a['last_name'].' ('.$a['membership_code'].')</span>';
					}
				?>
				<div class="clearfix">
					<div class="block-label">
						<label>Upline:</label>
					</div>
					<div class="block-value clearfix">
						<div class="text-center" style="float:left"><?php echo $u;?></div>
					</div>
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
	$.ajax({
		url: '<?php echo base_url();?>account/team/get_recruits',
		method: 'post',
		dataType: 'json',
		data: {
			type: $('#recruits-type-select').val(),
			code: $('#recruits-baseshop-select').val(),
			date_from: $('#recruits-date-from').val(),
			date_to: $('#recruits-date-to').val(),
		},
		success: function(data){
			if(data['success']){
				var data = data['data'];
						var table = $('<table>').addClass('table').addClass('table-striped').appendTo($('#recruits-grid'));
							table.append('<thead><tr><th>&nbsp;</th><th>Name</th><th>Code</th><th>Recruiter</th><th>Start Date</th></tr></thead>');
							var tbody = $('<tbody>').appendTo(table);
							for(var i = 0; i < data.length;++i){
								var tr = $('<tr>').appendTo(tbody);
								$('<td>').html(i + 1).appendTo(tr);
								$('<td>').html('<a href="javascript:void(0)" class="detail-url" data-id="' + data[i]['membership_code'] + '">' + data[i]['name'] + '</a>').appendTo(tr);
								$('<td>').html(data[i]['membership_code']).appendTo(tr);
								$('<td>').html(data[i]['recruiter']).appendTo(tr);
								$('<td>').html(data[i]['start_date']).appendTo(tr);
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
								$('<td>').html('<a href="javascript:void(0)" class="detail-url" data-id="' + baseshop[i]['membership_code'] + '">' + baseshop[i]['name']).appendTo(tr);
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
