<style>
.list-group-item:not(:first-child)>div:first-child{overflow:hidden;float:left;margin-right:10px;width:100px;text-align:right}	
.list-group-item>div:nth-child(2){float:left;overflow:hidden}	
</style>

<div style="max-width:1000px;width:100%;padding:40px 20px;margin:0 auto">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6">
			<ul class="list-group">
				<li class="list-group-item list-group-item-info clearfix"><div><label>Membership Info</label></div></li>
				<li class="list-group-item clearfix"><div><label>Grade:</label></div><div><?php echo $user['grade'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Upline:</label></div><div><?php echo $user['first_name2'].' '.$user['last_name2'].(empty($user['nick_name2']) ? '' : ' ('.$user['nick_name2'].')');?></div></li>
				<li class="list-group-item clearfix"><div><label>Code:</label></div><div><?php echo $user['membership_code'];?></div></li>
				<li class="list-group-item clearfix"><div><label>SMD:</label></div><div><?php echo $user['first_name1'].' '.$user['last_name1'].(empty($user['nick_name1']) ? '' : ' ('.$user['nick_name1'].')');?></div></li>
			</ul>
			<ul class="list-group">
				<li class="list-group-item list-group-item-info clearfix"><div><label>Account Info</label></div></li>
				<li class="list-group-item clearfix"><div><label>Username:</label></div><div><?php echo $user['username'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Password:</label></div><div>********</div><a class="pull-right" href="<?php echo base_url();?>account/password"><span class="glyphicon glyphicon-pencil"></span></a></li>
			</ul>
		</div>
		<div class="col-lg-6 col-md-6  col-sm-6">
			<ul class="list-group">
				<li class="list-group-item list-group-item-info clearfix"><div><label>General Info</label></div></li>
				<li class="list-group-item clearfix"><div><label>Name:</label></div><div><?php echo $user['first_name'].' '.$user['last_name'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Nick Name:</label></div><div><?php echo $user['nick_name'];?></div></li>
				<li class="list-group-item clearfix">
					<div><label>Preference:</label></div>
					<div>
						<div class="radio" style="margin-top:0 !important;">
							<label><input type="radio" name="preference" value="E" <?php echo $user['preference'] == 'E' ? 'checked' : '';?>>Learn knowledge</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="preference" value="B" <?php echo $user['preference'] == 'B' ? 'checked' : '';?>>Do business</label>
						</div>
						<div class="radio disabled">
							<label><input type="radio" name="preference" value="BE" <?php echo $user['preference'] == 'BE' ? 'checked' : '';?>>Both</label>
						</div>
					</div>
				</li>
				<li class="list-group-item clearfix">
					<div><label>Email:</label></div>
					<div><?php echo $user['email'];?></div>
				</li>
				<li class="list-group-item clearfix"><div><label>Date of Birth:</label></div><div><?php echo date_format(date_create($user['date_of_birth']), 'F j');?></div></li>
				<li class="list-group-item clearfix"><div><label>Phone:</label></div><div><?php echo $user['phone'];?></div></li>
				<li class="list-group-item clearfix"><div><label>Address:</label></div><div>
					<?php 
						echo (empty($user['street']) ? '' : $user['street'].'<br/>')
							.(empty($user['city']) && empty($user['state']) && empty($user['zipcode']) ? '' : $user['city'].', '.$user['state'].' '.$user['zipcode'].'<br/>')
							.(empty($user['country']) ? '' : $user['country']);
					?>
				</div></li>
			</ul>
		</div>
	</div>
</div>
<script>
function update_user_preference(val){
	ajax_loading(true);
	$.ajax({
		url: '<?php echo base_url();?>account/profile/update_preference',
		method: 'post',
		data: {preference:val},
		success: function(){
			ajax_loading(flse);
			location.reload();
		},
		error: function(){
			ajax_loading(flse);
		}
	});
}
$('input[name=preference]').change(function(){
	update_user_preference($(this).val());
});
</script>
