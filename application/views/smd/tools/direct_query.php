<style>
#query-result thead{font-weight:bold}	
</style>
<div style="margin:40px">
<h4>Direct Query</h4>
	<div class="row">
		<div class="col-xs-12">
			<textarea class="form-control input-sm" id="text-sql" style="height:100px"></textarea>
		</div>
		<div class="col-xs-12 text-right">
			<button class="btn btn-sm btn-primary" style="margin:10px 0" onclick="direct_query();">Go</button>
		</div>
		<div class="col-xs-12">
				<table id="query-result" class="table table-responsive table-condensed table-striped"></table>
		</div>
	</div>
</div>	
<script>
function direct_query(){
	var sql = $('#text-sql').val();
	if(sql.length > 0){
		var table = $('#query-result');
		table.empty();
		ajax_loading(true);
		$.ajax({
			url: '<?php echo base_url();?>smd/tools/direct_query',
			data: {sql: sql},
			method: 'post',
			success: function(data){
				try{
					data = JSON.parse(data);
					if(data['success']){
						var result = data['result'];
						if(!result || result.length == 0){
							table.append('<tr><td style="text-align:center; line-height:80px">Empty result.</td></tr>');
						}
						else{
							var thead = $('<thead>').appendTo(table);
							var tr = $('<tr>').appendTo(thead);
							for(var col in result[0]){
								tr.append('<td>' + col + '</td>');
							}
							var tbody = $('<tbody>').appendTo(table);
							for(var i = 0; i < result.length; ++i){
								var tr = $('<tr>').appendTo(tbody);
								for(var c in result[i]){
									tr.append('<td>' + result[i][c] + '</td>');
								}
							}
						}
					}
					else{
						table.append('<tr><td class="bg-danger" style="text-align:center;padding:40px 0px">' + data['message'] + '</td></tr>');
					}
				}
				catch(e){
					table.append('<tr><td class="bg-danger" style="text-align:center;padding:40px 0px">' + data + '</td></tr>');
				}
			},
			error: function(a, b, c){
				table.append('<tr><td class="bg-danger" style="text-align:center;padding:40px 0px">' + a.responseText + '</td></tr>');
			},
			complete: function(){
				ajax_loading(false);
			}
		});
	}
}
</script>
