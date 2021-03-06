<style>
.dashboard-block{text-align:center;border-radius:3px;margin:20px auto;padding:15px 0}
.dashboard-block-bg{font-size:36px;font-weight:bold}
.dashboard-block-sm{font-size:14px}
.dashboard-block-red{background:#ff5454;border:1px solid #ff2121;color:#fff;}
.dashboard-block-blue{background:#67c2ef;border:1px solid #39afea;color:#fff;}
.dashboard-block-orange{background: #fabb3d;border:1px solid #f9aa0b;color:#fff;}
.dashboard-block-green{background: #79c447;border:1px solid #61a434;color:#fff;}
.dashboard-block-darkorange{background: #FF5722;border:1px solid #f24a15;color:#fff;}
.panel-heading{padding:10px 0 10px 50px;font-weight:bold;}
.d-flex{border-top:1px solid #e5e5e5}
.d-flex:last-child{border-bottom:1px solid #e5e5e5}
</style>
<div class="main-body-wrapper">
	<div class="row">
			<?php
			if(count($tasks) > 0){
			?>
		<div class="col-md-6 col-sm-12">
			<div class="panel panel-warning">
				<div class="panel-heading " style="background-image:url(<?php echo base_url();?>src/img/alert.svg);background-repeat:no-repeat;background-position:10px 10px;background-size:25px 25px">Tasks</div>
				<div class="panel-body">
					<?php
					foreach($tasks as $t){
						$d = array(
							-1 => 'yesterday',
							0 => 'today',
							1 => 'tomorrow',
						);
						$dt = array_key_exists($t['due_days'], $d) ? $d[$t['due_days']] : ($t['due_days'] > 0 ? 'in '.$t['due_days'].' days' : 'past '.(-1 * $t['due_days']).' days');
					?>
					<div class="d-flex">
						<div class="p-2 flex-grow-1"><a href="<?php echo base_url();?>smd/tasks/view/<?php echo $t['tasks_id'];?>" target="_blank"><?php echo $t['tasks_subject'];?></a></div>
						<div class="p-2 <?php echo $t['due_days'] < 2 ? 'text-danger' : 'text-warning';?>"><?php echo $dt;?></div>
						<div class="p-2" style="width:80px"><?php echo $t['tasks_status'];?></div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
			<?php
			}
			?>
			<?php
			if(!empty($birthday1) || !empty($birthday2) || !empty($birthday3) || !empty($birthday4)){
			?>
		<div class="col-md-6 col-sm-12">
			<div class="panel panel-warning">
				<div class="panel-heading " style="background-image:url(<?php echo base_url();?>src/img/cake_red.svg);background-repeat:no-repeat;background-position:10px 5px;background-size:25px 25px">Recent Birthday</div>
				<div class="panel-body">
					<?php
					foreach($birthday1 as $b){
					?>
					<div class="d-flex">
						<div class="p-2 flex-grow-1"><a href="<?php echo base_url();?>smd/sales/sales_case/<?php echo $b['policies_id'];?>"><?php echo $b['name'];?></a></div>
						<div class="p-2 text-red">Today</div>
						<div class="p-2">Client</div>
					</div>
					<?php
					}
					foreach($birthday3 as $b){
					?>
					<div class="d-flex">
						<div class="p-2 flex-grow-1"><a href="<?php echo base_url();?>smd/team/member/<?php echo $b['membership_code'];?>"><?php echo (empty($b['nick_name']) ? $b['first_name'] : $b['nick_name']).' '.$b['last_name'];?></a></div>
						<div class="p-2 text-red">Today</div>
						<div class="p-2">Team</div>
					</div>
					<?php
					}
					foreach($birthday2 as $b){
					?>
					<div class="d-flex">
						<div class="p-2 flex-grow-1"><a href="<?php echo base_url();?>smd/sales/sales_case/<?php echo $b['policies_id'];?>"><?php echo $b['name'];?></a></div>
						<div class="p-2"><?php echo date_format(date_create($b['dob']), 'M d');?></div>
						<div class="p-2">Client</div>
					</div>
					<?php
					}
					foreach($birthday4 as $b){
					?>
					<div class="d-flex">
						<div class="p-2 flex-grow-1"><a href="<?php echo base_url();?>smd/team/member/<?php echo $b['membership_code'];?>"><?php echo (empty($b['nick_name']) ? $b['first_name'] : $b['nick_name']).' '.$b['last_name'];?></a></div>
						<div class="p-2"><?php echo date_format(date_create($b['date_of_birth']), 'M d');?></div>
						<div class="p-2">Team</div>
					</div>
					<?php
					}
					?>


					<!--table class="table" style="width:100%">
					<?php
					foreach($birthday1 as $b){
					?>
						<tr>
							<td><a href="<?php echo base_url();?>smd/sales/sales_case/<?php echo $b['policies_id'];?>"><?php echo $b['name'];?></a></td>
							<td style="color:red">Today</td>
							<td>Client</td>
						</tr>
					<?php
					}
					foreach($birthday3 as $b){
					?>
						<tr>
							<td><a href="<?php echo base_url();?>smd/team/member/<?php echo $b['membership_code'];?>"><?php echo (empty($b['nick_name']) ? $b['first_name'] : $b['nick_name']).' '.$b['last_name'];?></a></td>
							<td style="color:red">Today</td>
							<td>Team</td>
						</tr>
					<?php
					}
					foreach($birthday2 as $b){
					?>
						<tr>
							<td><a href="<?php echo base_url();?>smd/sales/sales_case/<?php echo $b['policies_id'];?>"><?php echo $b['name'];?></a></td>
							<td><?php echo date_format(date_create($b['dob']), 'M d');?></td>
							<td>Client</td>
						</tr>
					<?php
					}
					foreach($birthday4 as $b){
					?>
						<tr>
							<td><a href="<?php echo base_url();?>smd/team/member/<?php echo $b['membership_code'];?>"><?php echo (empty($b['nick_name']) ? $b['first_name'] : $b['nick_name']).' '.$b['last_name'];?></a></td>
							<td><?php echo date_format(date_create($b['date_of_birth']), 'M d');?></td>
							<td>Team</td>
						</tr>
					<?php
					}
					?>
					</table-->
				</div>
			</div>
  		</div>
			<?php
			}
			?>
			<?php
			if(!empty($policy_ann)){
			?>
		<div class="col-md-6 col-sm-12">
			<div class="panel panel-warning">
				<div class="panel-heading" style="padding-left:50px;font-weight:bold;background-image:url(<?php echo base_url();?>src/img/first-annual-day-calendar-page-interface-symbol.svg);background-repeat:no-repeat;background-position:10px 10px;background-size:25px 25px">Policy Anniversary</div>
				<div class="panel-body">
					<?php
					foreach($policy_ann as $p){
					?>
					<div class="d-flex">
						<div class="p-2"><img src="<?php echo base_url();?>src/img/<?php echo $p['policies_provider'];?>_logo.ico" style="height:15px;margin-top:-5px">&nbsp;<a href="<?php echo base_url();?>smd/sales/sales_case/<?php echo $p['policies_id'];?>"><?php echo $p['policies_number'];?></a></div>
						<div class="p-2"><?php echo date_format(date_create($p['policies_issue_date']), 'M d, Y');?></div>
						<div class="p-2 flex-grow-1"><?php echo $p['policies_insured_name'];?></div>
					</div>
					<?php
					}
					?>


					<!--table class="table" style="width:100%">
					<?php
					foreach($policy_ann as $p){
					?>
						<tr>
							<td><img src="<?php echo base_url();?>src/img/<?php echo $p['policies_provider'];?>_logo.ico" style="height:15px;margin-top:-5px">&nbsp;<a href="<?php echo base_url();?>smd/sales/sales_case/<?php echo $p['policies_id'];?>"><?php echo $p['policies_number'];?></a></td>
							<td><?php echo date_format(date_create($p['policies_issue_date']), 'M d, Y');?></td>
							<td><?php echo $p['policies_insured_name'];?></td>
						</tr>
					<?php
					}
					?>
					</table-->
				</div>
			</div>
  		</div>
			<?php
			}
			?>
	</div>
	
	<!--div class="row">
		<div class="col-md-4">
			<?php
			$pie_chart_data = array(	
				array(
					'label' => 'Active Members', 
					'value' => $statuses['active'] 
				),
				array(
					'label' => 'Inactive Members', 
					'value' => $statuses['inactive'] 
				),
			);
			$this->load->view('smd/pie_chart', array(
					'element' => "members-pie-chart",
					'width' => '200%',
					'data' => $pie_chart_data
			));
			?>
		</div>
		<div class="col-md-8"
			<div class="row">
				<?php
				$color_list = array('red', 'blue', 'orange', 'green', 'darkorange');
				$grade_names = array('MD' => 'Marketing Director', 'SA' => 'Senior Associate', 'A' => 'Associate', 'TA' => 'Trainee Associate', 'G' => 'Guest');
				$i = 0;
				foreach($grade_names as $grade => $grade_names){
				?>
				<div class="col-md-3 col-xs-6">
					<div class="dashboard-block dashboard-block-<?php echo $color_list[$i++];?>">
						<div class="dashboard-block-bg"><?php echo array_key_exists($grade, $grades) ? $grades[$grade] : 0;?></div>
						<div class="dashboard-block-sm"><?php echo $grade_names;?></div>
					</div>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</div-->
</div>