<style>
.wc{margin:0 20px}
.wc>div{float:left;margin-right:20px}	
</style>

<div class="main-body-wrapper">
<?php 
if($error){
?>
<div class="alert alert-danger"><?php echo $error?></div>
<?php
	exit;
}
?>
<div class="clearfix">
	<div class="form-group clearfix wc">
		<div class="checkbox">
			<label class="text-success"><input type="checkbox" checked id="status-a"> Active</label>
		</div>
		<div class="checkbox">
			<label class="text-danger"><input type="checkbox" checked id="status-i"> Inactive</label>
		</div>
		<div class="checkbox">
			<label class="text-success"><input type="checkbox" checked id="status-l"> Licensed</label>
		</div>
		<div class="checkbox">
			<label class="text-warning"><input type="checkbox" checked id="status-lep"> License Exam Passed</label>
		</div>
		<div class="checkbox">
			<label class="text-danger"><input type="checkbox" checked id="status-nl"> None Licensed</label>
		</div>
	</div>
	<div id="team-member-grid-hierarchy"></div>
</div>
</div>
<script>
$('.wc input').click(function(){
	if(!$(this).prop('checked')){
		var checked = false;
		$(this).parent().parent().siblings().find('input').each(function(i, e){
			if($(e).prop('checked')){
				checked = true;
				return false;
			}
		});
		if(!checked){
			$(this).prop('checked', true);
			return false;
		}
	}
	//return false;
	//location.href= '<?php echo base_url();?>smd/team/hierarchy?filter=';
});
$('#team-member-grid-hierarchy').tree_grid('', '<?php echo base_url();?>smd/team/get_direct_downline');
</script>
