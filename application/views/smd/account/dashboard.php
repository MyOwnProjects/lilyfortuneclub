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