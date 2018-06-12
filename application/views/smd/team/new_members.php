<style>
.text{line-height:40px}
.result>div:nth-child(2)>div, .result>div:nth-child(4)>div{width:230px;margin-right:20px;float:left;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
</style>
<div class="main-body-wrapper">
	<h3 class="text-center">Members Update</h3>
	<div class="row">
		<div class="col-xs-12" id="get-baseshop-progress">
			<button class="btn btn-primary btn-sm" id="button_start" onclick="starting();">Click to start</button>
			<button class="btn btn-primary btn-sm" onclick="test();">Test</button>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12" id="get-baseshop-progress">
			<div class="text">1. Retrieving baseshop......</div>
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
					0
				</div>
			</div>
			<div class="result">
				<div class="text clearfix"></div>
				<div class="clearfix"></div>
				<div class="text clearfix"></div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="col-xs-12" id="update-new-members" style="display:none">
			<div class="text">Synchronizing New Members......</div>
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
					0
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var existingCodes = {};
var newCodes = {};
var changedCodes = {};
var start = 0;

function update_level(){
	ajax_loading(true);
	var data = {};
	for(var code in changedCodes){
		data[code] = changedCodes[code]['level'];
	}
	$.ajax({
			url: '<?php echo base_url();?>smd/team/bulk_update_users',
			method: 'post',
			data: {data: data},
			complete: function(){
				ajax_loading(false);
			}
	});
}

function get_baseshop1(start1){
	for(var i = 0; i < 10; ++i){
		$.ajax({
			url: '<?php echo base_url();?>smd/team/get_base_shop?code=<?php echo $user['membership_code'];?>&start=' + (i * 5),
			success: function(data){
				alert(i + 'done');
			}
		});
	}
}

function get_baseshop(start){
	$.ajax({
		url: '<?php echo base_url();?>smd/team/get_base_shop?code=<?php echo $user['membership_code'];?>&start=' + start,
		success: function(data){
			var result = JSON.parse(data);
			var total = result['iTotalRecords'];
			var aaData = result['aaData'];
			if(aaData.length > 0){
				for(var i = 0; i < aaData.length; ++i){
					var code = aaData[i][1];
					var wrap = $('<div>').append(aaData[i]);
					var name = wrap.children('.list-agent-name').text();
					var l = wrap.children('.list-agent-level').text().trim();
					var level = l.substr(l.lastIndexOf(' ') + 1);
					if(code in existingCodes){
						if(level != existingCodes[code]){
							changedCodes[code] = {name: name, level: level, old_level: existingCodes[code]};
						}
					}
					else{
						newCodes[code] = {name: name, level: level};
					}
				}
				start += aaData.length;
				var rate = start / total;
				var percent = Math.round(rate * 100);
				$('#get-baseshop-progress .progress-bar').attr('aria-valuenow', rate).html(percent + '%').css('width', percent + '%');
				if(start < total){
					get_baseshop(start);
				}
				else{
					$('#get-baseshop-progress>.text').html('1. Retrieving baseshop. Done!');
					$('#get-bashop-progress .progress-bar').attr('aria-valuenow', 1).css('width', '100%');
					var c = 0;
					for(var code in newCodes){
						c++;
						var t = code + ' - ' + newCodes[code]['name'];
						$('#get-baseshop-progress .result>div:nth-child(2)')
							.append('<div title="' + t + '"><button type="button" class="new-member-url btn btn-link" data-id="' + code + '">' + t + '</button></div>');
					}
					var btn_trvieve_new_members = null;
					if(c > 0){
						btn_trvieve_new_members = $('<button>').addClass('btn').addClass('btn-sm').addClass('btn-success')
							.html('Retrieve All').click(function(){
								update_level();
							}
						);
					}
					$('#get-baseshop-progress .result>div:nth-child(1)').append('<span>New members: ' + c + '&nbsp;&nbsp;&nbsp;&nbsp;</span>').append(btn_trvieve_new_members);
					c = 0;
					for(var code in changedCodes){
						c++;
						var t = changedCodes[code]['old_level'] + '&rarr;' + changedCodes[code]['level'] +  ' - ' + changedCodes[code]['name'] + ' (' + code + ')';
						$('#get-baseshop-progress .result>div:nth-child(4)')
							.attr('id', 'btn-trvieve-new-members').append('<div title="' + t + '">' + t + '</div>');
					}
					var btn_update_level = null;
					if(c > 0){
						btn_update_level = $('<button>').addClass('btn').addClass('btn-sm').addClass('btn-success')
							.attr('id', 'btn-update-level').html('Update Member Level').click(function(){
								update_level();
							}
						);
					}
					$('#get-baseshop-progress .result>div:nth-child(3)').append('<span>Level changed members: ' + c + '&nbsp;&nbsp;&nbsp;&nbsp;</span>').append(btn_update_level);
				}
			}
		}
	});
}

function retrive_and_update_member(){
	$.ajax({
		url:'<?php echo base_url();?>smd/team/retrieve_and_update_member/' + code,

	});
}

function retrive_all_members(){
	var c = 0;
	for(var code in newCodes){
		c++;
		$.ajax({
			url:'<?php echo base_url();?>smd/team/retrieve_and_update_member/' + code,

		});
	}
}

function starting(){
	$('#button_start').addClass('disabled');
	$.ajax({
		url: '<?php echo base_url();?>smd/team/get_new_members',
		dataType: 'json',
		success: function(data){
			existingCodes = data;
			$('#result').html('Retrieving baseshop from MyWFG.com......');
			get_baseshop(0);
		},
		error: function(){
		},
		complete: function(){
		}
	});
}

function test(){
	get_baseshop1(0);
}

$('body').delegate('.new-member-url', 'click', function(){
	var $_this = $(this);
	ajax_loading(true);
	var code = $_this.attr('data-id');
	$.ajax({
		url:'<?php echo base_url();?>smd/team/retrieve_member/' + code,
		success:function(data){
			var wrap = $('<div>').append(data);
			var text = '';
			wrap.find('.wfg-form-control').each(function(index, obj){
				text += $(obj).find('.horizontal-form-title').text().trim() + '\n';
				text += $(obj).find('.horizontal-form-value').text().trim() + '\n';
			});
			new_item({title: "Add Member", url: "<?php echo base_url();?>smd/team/add_member",
				loaded: function(){
					$('#auto-fill-btn').click();
				},
				param:{source: {'auto-fill': text}, 
					func: function(){
						delete newCodes[code];
						$_this.parent().prepend('<span class="text-success glyphicon glyphicon-ok-sign"></span>');
						$_this.addClass('disabled');
					},
				}
			});
		},
		error: function(){
		},
		complete: function(){
			ajax_loading(false);
		}
	});
});


$(document).ready(function(){
return false;
	$.ajax({
		url: '<?php echo base_url();?>smd/team/get_new_members',
		dataType: 'json',
		success: function(data){
			existingCodes = data;
			$('#result').html('Retrieving baseshop from MyWFG.com......');
			//get_baseshop(0);
		},
		error: function(){
		},
		complete: function(){
		}
	});
});
</script>