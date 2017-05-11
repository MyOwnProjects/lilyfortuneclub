<style>
.list-group-item:not(:first-child)>div:first-child{overflow:hidden;float:left;margin-right:10px;width:100px;text-align:right}	
.list-group-item>div:nth-child(2){float:left;overflow:hidden}	
</style>

<div data-role="page">
	<div data-role="content">
				<li class="list-group-item list-group-item-info clearfix"><div><label>Membership Info</label></div></li>
				<li class="list-group-item clearfix"><div><label>Grade:</label></div><div><?php echo $user['grade'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Upline:</label></div><div><?php echo $user['first_name2'].' '.$user['last_name2'].(empty($user['nick_name2']) ? '' : ' ('.$user['nick_name2'].')');?></div></li>
				<li class="list-group-item clearfix"><div><label>Code:</label></div><div><?php echo $user['membership_code'];?></div></li>
				<li class="list-group-item clearfix"><div><label>SMD:</label></div><div><?php echo $user['first_name1'].' '.$user['last_name1'].(empty($user['nick_name1']) ? '' : ' ('.$user['nick_name1'].')');?></div></li>
				<li class="list-group-item list-group-item-info clearfix"><div><label>Account Info</label></div></li>
				<li class="list-group-item clearfix"><div><label>Username:</label></div><div><?php echo $user['username'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Password:</label></div><div>********</div><a class="pull-right" href="<?php echo base_url();?>account/password"><span class="glyphicon glyphicon-pencil"></span></a></li>
				<li class="list-group-item list-group-item-info clearfix"><div><label>General Info</label></div></li>
				<li class="list-group-item clearfix"><div><label>Name:</label></div><div><?php echo $user['first_name'].' '.$user['last_name'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Nick Name:</label></div><div><?php echo $user['nick_name'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Email:</label></div><div><?php echo $user['email'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Date of Birth:</label></div><div><?php echo date_format(date_create($user['date_of_birth']), 'F j, Y');?></div></li>
				<li class="list-group-item clearfix"><div><label>Phone:</label></div><div><?php echo $user['phone'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Address:</label></div><div>
					<?php 
						echo (empty($user['street']) ? '' : $user['street'].'<br/>')
							.(empty($user['city']) && empty($user['state']) && empty($user['zipcode']) ? '' : $user['city'].', '.$user['state'].' '.$user['zipcode'].'<br/>')
							.(empty($user['country']) ? '' : $user['country']);
					?>
				</div></li>
	</div>
</div>
	</div>
</div>
