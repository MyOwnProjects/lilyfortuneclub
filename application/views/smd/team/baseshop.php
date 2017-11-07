<div class="main-body-wrapper">
	<div class="form-group">
		<label>Code</label>
		<input class="form-control control-sm" id="code">
	</div>
	<div class="form-group">
		<button class="btn btn-sm btn-primary" onclick="get_baseshop();">Go</button>
	</div>
	<div id="res"></div>
</div>
<script>
function get_baseshop(){
	
$.ajax({
		url: '<?php echo base_url();?>smd/team/get_base_shop/' + $('#code').val().trim(),
		success:function(data){
			var codes = [];
			var result = JSON.parse(data);
			for(var i = 0; i < result.length; ++i){
				var aaData = result[i]['aaData'];
				for(var j = 0; j < aaData.length; ++j){
					codes.push(aaData[j][1]);
				}
			}
			$('#res').html("'" + codes.join("','") + "'");
		}
	});
}
</script>
