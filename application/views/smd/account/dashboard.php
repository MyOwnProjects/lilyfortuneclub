<style>
.dashboard-block{text-align:center;border-radius:3px;margin:20px auto;padding:15px 0}
.dashboard-block-bg{font-size:36px;font-weight:bold}
.dashboard-block-sm{font-size:14px}
.dashboard-block-red{background:#ff5454;border:1px solid #ff2121;color:#fff;}
.dashboard-block-blue{background:#67c2ef;border:1px solid #39afea;color:#fff;}
.dashboard-block-orange{background: #fabb3d;border:1px solid #f9aa0b;color:#fff;}
.dashboard-block-green{background: #79c447;border:1px solid #61a434;color:#fff;}
.dashboard-block-darkorange{background: #FF5722;border:1px solid #f24a15;color:#fff;}
</style>
<div class="main-body-wrapper">
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<?php
			if(!empty($birthday1) || !empty($birthday2)){
			?>
			<div class="panel panel-warning">
				<div class="panel-heading" style="padding-left:50px;font-weight:bold;background-image:url(<?php echo base_url();?>src/img/cake_red.svg);background-repeat:no-repeat;background-position:10px 5px;background-size:25px 25px">Recent Birthday</div>
				<div class="panel-body">
					<table class="table">
					<?php
					foreach($birthday1 as $b){
					?>
						<tr>
							<td><a href="<?php echo base_url();?>smd/team/member/<?php echo $b['membership_code'];?>"><?php echo (empty($b['nick_name']) ? $b['first_name'] : $b['nick_name']).' '.$b['last_name'];?></a></td>
							<td style="color:red">Today</td>
						</tr>
					<?php
					}
					foreach($birthday2 as $b){
					?>
						<tr>
							<td><a href="<?php echo base_url();?>smd/team/member/<?php echo $b['membership_code'];?>"><?php echo (empty($b['nick_name']) ? $b['first_name'] : $b['nick_name']).' '.$b['last_name'];?></a></td>
							<td><?php echo date_format(date_create($b['date_of_birth']), 'M d');?></td>
						</tr>
					<?php
					}
					?>
					</table>
				</div>
			</div>
			<?php
			}
			?>
  		</div>
	</div>
	<div class="row">
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
	</div>
</div>