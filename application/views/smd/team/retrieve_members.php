<div class="main-body-wrapper">
	<table border="1">
		<tbody>
			
		</tbody>
	</table>
</div>
<script>
var codes = JSON.parse('<?php echo json_encode($codes);?>');
var tbody = $('tbody');
var rows = {};
function retrieve_one(index){
	ajax_loading(true);
	if(index >= codes.length){
		ajax_loading(false);
		return false;
	}
	var code = codes[index];
	$.ajax({
		url: '<?php echo base_url();?>smd/team/retrieve_member/' + code,
		method: 'post',
		success: function(data){
			var wrapper = $('<div>').append(data);
			var phone_list = [];
			var address = [];
			var tr = $('<tr>').appendTo(tbody);
			tr.append('<td>' + (index + 1) + '</td>');
			wrapper.find('.wfg-form-control').each(function(index, obj){
				var title = $(obj).find('.horizontal-form-title').text().trim();
				var value = $(obj).find('.horizontal-form-value').text().trim();
				if(value.length > 0){
						switch(title){
							case 'Name:':
								lpos = value.indexOf('(');
								rpos = value.indexOf(')');
								code_len = rpos - lpos - 1;
								var membership_code = value.substr(value.length - (code_len + 1), code_len); 
								value = value.substr(0, value.length - (code_len + 2)).trim();
								var pos = value.lastIndexOf(' ');
								var first_name = value.substr(0, pos);
								var last_name = value.substr(pos + 1, value.length - pos);
								tr.append('<td>' + membership_code + '</td>'
									+ '<td>' + last_name + '</td>'
									+ '<td>' + first_name + '</td>');
								break;
							case 'Level:':
								tr.append('<td>' + value + '</td>');
								break;
							case 'Start Date:':
								var date = new Date(value);
								var date_str = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
								tr.append('<td>' + date_str + '</td>');
								break;
							case 'DOB:':
								var date = new Date(value + ' 2017');
								var date_str = '1900-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
								tr.append('<td>' + date_str + '</td>');
								break;
							case 'Home Phone:':
								phone_list.push('H:' + value);
								break;
							case 'Business Phone:':
								phone_list.push('B:' + value);
								break;
							case 'Mobile Phone':
								phone_list.push('M:' + value);
								break;
							case 'Personal Email:':
								tr.append('<td>' + value + '</td>');
								break;
							case 'Home Address:':
								address = value.split('\n');
								break;
							case 'Recruiter:':
								var p = value.lastIndexOf(' ');
								var l_first_name = value.substr(0, p).toLowerCase();
								var l_last_name = value.substr(p + 1).toLowerCase();
								tr.append('<td>' + l_first_name +' ' + l_last_name + '</td>');
								break;
						}
						}
					
				
				});
				if(address.length >= 2){
					tr.append('<td>' + address[0].trim() +'</td>');
					var ar = address[1].trim().split(',');
					tr.append('<td>' + ar[0].trim() + '</td>');
					ar = ar[1].split('-');
					tr.append('<td>' + ar[1].trim() + '</td>');
					ar = ar[0].trim().split(' ');
					tr.append('<td>' + ar[0].trim() + '</td>');
					tr.append('<td>' + ar[1].trim() + '</td>');
				}
				tr.append('<td>' + phone_list.join(',') + '</td>');
		},
		error: function(a, b, c){
		},
		complete: function(){
			retrieve_one(index + 1);
		}
	});
}
retrieve_one(0);
</script>
