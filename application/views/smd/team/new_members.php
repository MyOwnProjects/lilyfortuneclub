<style>
.text{line-height:40px}
.result>div:nth-child(2)>div, .result>div:nth-child(4)>div{width:230px;margin-right:20px;float:left;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
#get-baseshop-progress{display:none}
</style>
<div class="main-body-wrapper">
	<h3 class="text-center">Members Update</h3>
	<div class="row">
		<div class="col-xs-12">
			<button class="btn btn-primary btn-sm" id="button-start" onclick="starting();">Start</button>
			<button class="btn btn-primary btn-sm" id="button-fast-start" onclick="fast_start();">Fast Start</button>
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
				<div class="text clearfix">New members: <span>0</span>&nbsp;&nbsp;&nbsp;&nbsp;</div>
				<div class="clearfix"></div>
				<div class="text clearfix">Level changed members: <span>0</span>&nbsp;&nbsp;&nbsp;&nbsp;</span</div>
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
	$('#button-start, #button-fast-start').addClass('disabled');
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

var retrieved_members = 0;
function parseData(aaData){
	var code = aaData[1];
	var wrap = $('<div>').append(aaData);
	var name = wrap.children('.list-agent-name').text();
	var l = wrap.children('.list-agent-level').text().trim();
	var level = l.substr(l.lastIndexOf(' ') + 1);
	if(code in existingCodes){
		if(level != existingCodes[code]){
			var t = existingCodes[code] + '&rarr;' + level +  ' - ' + name + ' (' + code + ')';
			changedCodes[code] = {name: name, level: level, old_level: existingCodes[code]};
			$('#get-baseshop-progress .result>div:nth-child(3) span').html(Object.keys(changedCodes).length');
			$('#get-baseshop-progress .result>div:nth-child(4)')
				.attr('id', 'btn-trvieve-new-members').append('<div title="' + t + '">' + t + '</div>');
		}
	}
	else{
		var t = code + ' - ' + name;
		newCodes[code] = {name: name, level: level};
		$('#get-baseshop-progress .result>div:nth-child(1) span').html(Object.keys(newCodes).length');
		$('#get-baseshop-progress .result>div:nth-child(2)')
			.append('<div title="' + t + '"><button type="button" class="new-member-url btn btn-link" data-id="' + code + '">' + t + '</button></div>');
	}
	
	
}

function get_5_members(start, total){
	if(start < total){
		$.ajax({
			url: '<?php echo base_url();?>smd/team/get_base_shop?code=<?php echo $user['membership_code'];?>&start=' + start,
			success: function(data){
				var result = JSON.parse(data);
				var total = parseInt(result['iTotalRecords']);
				var aaData = result['aaData'];
				for(var i = 0; i < aaData.length; ++i){
					parseData(aaData[i]);
				}
				retrieved_members += aaData.length;			
				var rate = retrieved_members / total;
				var percent = Math.round(rate * 100);
				$('#get-baseshop-progress .progress-bar').attr('aria-valuenow', rate).html(percent + '%').css('width', percent + '%');
				if(retrieved_members >= total){
					var btn_update_level = null;
					if(Object.keys(changedCodes).length > 0){
						btn_update_level = $('<button>').addClass('btn').addClass('btn-sm').addClass('btn-success')
							.attr('id', 'btn-update-level').html('Update Member Level').click(function(){
								update_level();
							}
						);
					}
					
					return false;
				}
				get_5_members(start + 50, total);
			}
		});
	}
}


function fast_start(){
	newCodes = {};
	$('#button-start, #button-fast-start').addClass('disabled');
	$('#get-baseshop-progress').show();
	$.ajax({
		url: '<?php echo base_url();?>smd/team/get_new_members',
		dataType: 'json',
		success: function(data){
			existingCodes = data;
			$('#result').html('Retrieving baseshop from MyWFG.com......');
			$.ajax({
				url: '<?php echo base_url();?>smd/team/get_base_shop?code=<?php echo $user['membership_code'];?>&start=0',
				success: function(data){
					//data = '{"iTotalRecords":443,"iTotalDisplayRecords":443,"aaData":[["\u003cspan class=\"list-count\"\u003e1\u003c/span\u003e\u003cspan class=\"list-agent-name\"\u003eXIN  HU\u003c/span\u003e\u003cdiv class=\"list-agent-level\"\u003e(48SZN) - MD\u003c/div\u003e","48SZN","ViewAssociate"],["\u003cspan class=\"list-count\"\u003e2\u003c/span\u003e\u003cspan class=\"list-agent-name\"\u003eLUCY  CHAN\u003c/span\u003e\u003cdiv class=\"list-agent-level\"\u003e(099ETC) - A\u003c/div\u003e","099ETC","ViewAssociate"],["\u003cspan class=\"list-count\"\u003e3\u003c/span\u003e\u003cspan class=\"list-agent-name\"\u003eGLORIA  CHUNG\u003c/span\u003e\u003cdiv class=\"list-agent-level\"\u003e(48TAN) - A\u003c/div\u003e","48TAN","ViewAssociate"],["\u003cspan class=\"list-count\"\u003e4\u003c/span\u003e\u003cspan class=\"list-agent-name\"\u003eDIANE  DAO\u003c/span\u003e\u003cdiv class=\"list-agent-level\"\u003e(41AQI) - A\u003c/div\u003e","41AQI","ViewAssociate"],["\u003cspan class=\"list-count\"\u003e5\u003c/span\u003e\u003cspan class=\"list-agent-name\"\u003eYIQING  DU\u003c/span\u003e\u003cdiv class=\"list-agent-level\"\u003e(51LKJ) - A\u003c/div\u003e","51LKJ","ViewAssociate"]]}';
					var result = JSON.parse(data);
					var total = parseInt(result['iTotalRecords']);
					var aaData = result['aaData'];
					for(var i = 0; i < aaData.length; ++i){
						parseData(aaData[i]);
					}
					retrieved_members += aaData.length;
					var rate = retrieved_members / total;
					var percent = Math.round(rate * 100);
					$('#get-baseshop-progress .progress-bar').attr('aria-valuenow', rate).html(percent + '%').css('width', percent + '%');
					for(var j = 1; j <= 10; ++j){//5,55, 105
						var start = j * 5;
						get_5_members(start, total);
					}
				},
				error: function(a, b, c){
				}
			});
		},
		error: function(){
		},
		complete: function(){
		}
	});

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