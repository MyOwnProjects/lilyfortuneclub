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
<div id="team-member-grid-hierarchy"></div>
</div>
</div>
<script>

$('#team-member-grid-hierarchy').tree_grid('', '<?php echo base_url();?>smd/team/get_direct_downline');
</script>
