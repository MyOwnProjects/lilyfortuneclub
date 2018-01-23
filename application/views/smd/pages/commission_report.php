
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>投资理财计划佣金列表</title>
	<?php
	$this->load->view('smd/pages/css.php');
	?>
</head>
<?php
function one_page($data){
?>
<div class="a4">
	<div class="header"></div>
	<div class="main">
		<div class="block">
			<div class="text">
				<table class="t3" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td class="h" style="width:30mm">案例</td>
						<td class="h c" style="width:20mm">计划代码</td>
						<td class="h">计划描述</td>
						<td class="h c" style="width:30mm">投资总额（美元）</td>
						<td class="h c" style="width:22mm">佣金（美元）</td>
					<tr>
					<?php	
					foreach($data as $key => $case){
						$b = $key == end(array_keys($data)) ? 'b' : '';
					?>
					<tr>
						<?php
						$i = 0;
						$count = count($case['case_plans']);
						foreach($case['case_plans'] as $code => $plan){
							++$i;
							$c = $i == $count ? 'b' : '';
							$s = $i != $count ? 's' : '';
							$b1 = $key == end(array_keys($data)) && $i == $count ? 'b' : '';
							if($i == 1){
						?>
							<td class="gl <?php echo $b;?>" rowspan="<?php echo $count;?>"><?php echo $case['case_name'];?></td>
						<?php
							}
						?>
							<td class="c <?php echo "$b1 $s";?>"><b><?php echo $code;?></b></td>
							<td class="<?php echo "$b1 $s";?>"><?php echo $plan['plan_desc'];?></td>
							<td class="c <?php echo "$b1 $s";?>">$<?php echo number_format($plan['premium_total'], 0);?></td>
						<?php
							if($i == 1){
						?>
							<td class="gr c <?php echo $b;?>" rowspan="<?php echo $count;?>">$<?php echo number_format($case['commission'], 0);?></td>
						<?php
							}
						?>
						</tr>	

						<?php
						}
					}
					?>
				</table>
				
			</div>
		</div>
	</div>
	<div class="footer">
		<div>新京集团财富管理中心</div>		
	</div>
</div>
<?php
}
?>
<body>
	<?php
	$data_array = array();
	$data_page = array();
	$i = 0;
	foreach($data as $key => $case){
		$i++;
		if($i % 9 == 0){
			array_push($data_array, $data_page);
			$data_page = array();
		}
		array_push($data_page, $case);
	}
	array_push($data_array, $data_page);
	foreach($data_array as $d){
		one_page($d);
	}
	?>
	<!--div class="a4">
		<div class="block">
			<div class="text">
				<table class="t1" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td class="h" style="width:30mm">案例</td>
						<td class="h c" style="width:25mm">计划代码</td>
						<td class="h">计划描述</td>
						<td class="h c" style="width:32mm">投资总额（美元）</td>
						<td class="h c" style="width:25mm">佣金（美元）</td>
					<tr>
					<?php	
					foreach($data as $key => $case){
						$b = $key == end(array_keys($data)) ? 'b' : '';
					?>
					<tr>
						<?php
						$i = 0;
						$count = count($case['case_plans']);
						foreach($case['case_plans'] as $code => $plan){
							++$i;
							$c = $i == $count ? 'b' : '';
							$s = $i != $count ? 's' : '';
							$b1 = $key == end(array_keys($data)) && $i == $count ? 'b' : '';
							if($i == 1){
						?>
							<td class="gl <?php echo $b;?>" rowspan="<?php echo $count;?>"><?php echo $case['case_name'];?></td>
						<?php
							}
						?>
							<td class="c <?php echo "$b1 $s";?>"><?php echo $code;?></td>
							<td class="<?php echo "$b1 $s";?>"><?php echo $plan['plan_desc'];?></td>
							<td class="c <?php echo "$b1 $s";?>">$<?php echo number_format($plan['premium_total'], 0);?></td>
						<?php
							if($i == 1){
						?>
							<td class="gr c <?php echo $b;?>" rowspan="<?php echo $count;?>">$<?php echo number_format($case['commission'], 0);?></td>
						<?php
							}
						?>
						</tr>	

						<?php
						}
					}
					?>
				</table>
				
			</div>
		</div>
	</div-->
</body>
</html>
