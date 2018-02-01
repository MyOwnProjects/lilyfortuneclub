
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
function one_page(&$data, $row_count){
?>
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
					$index_count = 0;
					$case = current($data);
					while($case !== FALSE && $index_count < $row_count){
						$key = key($data);
						$b = end(array_keys($data)) == $key || $index_count == $row_count - 1 ? 'b' : '';
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
						$index_count++;
						$case = next($data);
					}
					?>
				</table>
				
			</div>
<?php
return $index_count;
}
?>
<body>
<?php 
reset($data);
?>
<div class="a4">
	<div class="header">
		<div>投资理财计划佣金列表</div>
	</div>
	<div class="main">
		<h2 class="title">投资理财计划佣金列表</h2>
		<div class="block">
			<div class="p">以下是不同案例代码和对应的参考佣金列表。案例代码所对应的案例详情请参阅附加文档。</div>
			<div class="p">本列表仅供参考，实际的佣金以客户实际购买的计划为准。如果客户实际购买的计划和案例不完全相同，或者客户健康状况批准的等级不同，则佣金也会相应改变。</div>
			<div class="p">如果客户购买计划生效日2年之内取消，则佣金需要全额退回。</div>
		</div>
		<br/>
		<div class="block">
			<div class="text">
				
			<?php $total_row_count = one_page($data, 6);?>
			</div>
		</div>
	</div>
	<div class="footer">
		<div>仅供内部使用</div><div><?php echo $for == '0' ? 'Internal use only' : '新京集团财富管理中心'?></div>		
	</div>
</div>

<?php
while($total_row_count < count($data)){
?>
<div class="a4">
	<div class="header">
		<div>投资理财计划佣金列表</div>
	</div>
	<div class="main">
		<div class="block">
		<br/>
			<div class="text">
			<?php $total_row_count += one_page($data, 8);?>
			</div>
		</div>
	</div>
	<div class="footer">
		<div>仅供内部使用</div><div><?php echo $for == '0' ? 'Internal use only' : '新京集团财富管理中心'?></div>		
	</div>
</div>
<?php
}
?>
</body>
</html>
