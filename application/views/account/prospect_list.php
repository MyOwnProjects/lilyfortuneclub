<style>
thead td{background:green;color:#fff}
	table td{padding:2px 5px}
</style>
<div style="padding:40px">
	<h4 class="text-center">Top 25 Prospect List</h4>
	<table class="table-bordered">
		<thead>
			<tr><td>Name</td><td style="width:130px">Relationship</td><td style="width:120px">Phone Number</td><td style="width:550px">Profile</td><td>Comment</td></tr>
		</thead>
		<?php
		for($i = 0; $i < 25; ++$i){
		?>
		<tr>
			<td><input class="form-control input-sm"></td>
			<td><select class="form-control input-sm"><option value="R">Relative</option><option value="F">Friend</option><option value="A">Acquaintance</option></select></td>
			<td><input class="form-control input-sm"></td>
			<td>
				<input type="checkbox"> 25+ Years
				<input type="checkbox"> Married
				<input type="checkbox"> Children
				<input type="checkbox"> Home Owner
				<input type="checkbox"> Solid Business Background
				<input type="checkbox"> Income
				<input type="checkbox"> Dissatisfied
				<input type="checkbox"> Entrepreneurial
			</td>
			<td><textarea class="form-control input-sm"></textarea></td>
		</tr>
		
		<?php
		}
		?>
	</table>
	<br/>
	<div class="text-right"><button class="btn btn-primary">Update</button>&nbsp;&nbsp;<a href="<?php echo base_url();?>account/startup" class="btn btn-default">Close</a></div>
</div>

