<div class="main-body-wrapper">
<?php 
if(!$member){
?>
<div class="alert alert-danger">The member does not exists, or you don't have permission.</div>
<?php
	exit;
}
?>
<div class="row">
	<div class="col-lg-6">
		<ul class="list-group">
			<li class="list-group-item list-group-item-info cearfix">
				<b>Member Information</b>
				<a href="javascript:void(0)" class="pull-right dialog-toggle" data-id="<?php echo $member['membership_code'];?>" dialog-header="Update Member Information" dialog-url="<?php echo base_url();?>smd/team/add_member">
					<i class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Edit"></i>
				</a>
			</li>
			<?php 
			foreach($member as $name => $value){
				if(in_array($name, array('users_id', 'reset_token', 'smd', 'street', 'city', 'state', 
					'zipcode', 'country', 'first_name', 'last_name', 'nick_name'))) continue;
			?>
			<li class="list-group-item clearfix">
				<div class="pull-left" style="font-weight:bold;text-transform:capitalize;width:130px;margin-right:5px;text-align:right">
					<?php
					echo str_replace('_', ' ', $name);
					?>:
				</div>
				<div class="value pull-left">
					<?php 
					if($name == 'status'){
						echo $value == 'active' ? '<span class="label label-success">Active</span>' : '<span class="label label-default">Inactive</span>';
					}
					else if($name == 'password'){
						echo '********';
					}
					else{
						echo $value;
					}
					?>
				</div>
				<?php
				if(!in_array($name, array('create_date', 'SMD', 'downline'))){
				?>
				<a href="javascript:void(0)" class="pull-right dialog-toggle" data-id="<?php echo $member['membership_code'];?>" dialog-header="Update Member Information" dialog-url="<?php echo base_url();?>smd/team/update_user/<?php echo $name?>"><i class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
				<?php
				}
				?>
			</li>
			<?php
			}
			?>
		</ul>
	</div>
	<div class="col-lg-6">
		<ul class="list-group">
			<li class="list-group-item list-group-item-info"><b>Member Customized Information</b>
				<a href="javascript:void(0)" class="pull-right dialog-toggle"  dialog-header="Add Member Customized Information" dialog-url="<?php echo base_url();?>smd/team/add_user_info/<?php echo $member['users_id'];?>" new-dialog-header="Update Member Customized Information" new-dialog-url="update_user_info"><i class="glyphicon glyphicon-import" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Import"></i></a>
				<span class="pull-right">&nbsp;&nbsp;</span>
				<a href="javascript:void(0)" class="pull-right dialog-toggle"  dialog-header="Add Member Customized Information" dialog-url="<?php echo base_url();?>smd/team/add_user_info/<?php echo $member['users_id'];?>" new-dialog-header="Update Member Customized Information" new-dialog-url="update_user_info"><i class="glyphicon glyphicon-plus" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Add"></i></a>
			</li>
			<?php foreach($member_info as $mi){ ?>
			<li class="list-group-item clearfix">
				<div class="pull-left" style="font-weight:bold;text-transform:capitalize;width:130px;margin-right:5px;text-align:right"><?php echo $mi['user_info_label'];?>:</div>
				<div class="value pull-left"><?php echo $mi['user_info_value'];?></div>
				<a href="javascript:void(0)" class="pull-right dialog-toggle" data-id="<?php echo $mi['users_info_id'];?>" dialog-header="Delete Member Customized Information" dialog-url="<?php echo base_url();?>smd/team/delete_user_info"><i class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
				<span class="pull-right">&nbsp;&nbsp;</span>
				<a href="javascript:void(0)" class="pull-right dialog-toggle" data-id="<?php echo $mi['users_info_id'];?>" dialog-header="Update Member Customized Information" dialog-url="<?php echo base_url();?>smd/team/update_user_info"><i class="glyphicon glyphicon-edit" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
			</li>
			<?php 
			}
			?>
		</ul>
	</div>
</div>
</div>
<script>
$(document).ready(function(){
});
</script>