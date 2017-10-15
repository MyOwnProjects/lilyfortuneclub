<style>
.main-content-wrapper{max-width:1000px !important}	
.nav-tabs>li{width:33.3%}
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
		<div id="page-hierarchy" class="tab-pane fade tab-content-page">
			<div class="clearfix">
				<div id="team-member-grid-hierarchy"></div>
			</div>
			<script>
				$('#team-member-grid-hierarchy').tree_grid('', '<?php echo base_url();?>account/team/get_direct_downline');
			</script>
		</div>
		<div id="page-recruits" class="tab-pane fade tab-content-page">
			<div class="form-group">
				<label>Team Member</label>
				<select class="form-control control-sm"></select>
			</div>
			<div class="form-group">
				<label>Date From</label>
				<input type="date" class="form-control control-sm">
			</div>
			<div class="form-group">
				<label>Date To</label>
				<input type="date" class="form-control control-sm">
			</div>
			<div class="form-group text-right">
				<button class="btn btn-sm btn-primary">Go</button>
			</div>
		</div>
	</div>
</div>
<script>
$('body').delegate('.hierarchy-url', 'click', function(){
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
				var ancestors = data['ancestors'];
				var t = '<span>' + info['name'] + '</span>';
				for(var i = ancestors.length - 1; i >= 0; --i){
					t += '&nbsp;&rarr;&nbsp;<span>' + ancestors[i]['first_name'] + ' ' + ancestors[i]['last_name'] 
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
</script>
