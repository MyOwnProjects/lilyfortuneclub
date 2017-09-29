<style>
#query-result thead{font-weight:bold}	
</style>
<div style="margin:40px">
<h4>Javascript Code</h4>
	<div class="row">
		<div class="col-xs-12">
			<textarea class="form-control input-sm" id="js_code" style="height:500px;font-size:16px;">$('#js_output').val();</textarea>
		</div>
		<div class="col-xs-12 text-right">
			<button class="btn btn-sm btn-primary" style="margin:10px 0" onclick="run_js_code();">Go</button>
		</div>
		<div class="col-xs-12">
			<textarea id="js_output" class="form-control input-sm" style="height:500px"></textarea>
		</div>
	</div>
</div>	
<script>
function run_js_code(){
	eval($('#js_code').val());
}
</script>
