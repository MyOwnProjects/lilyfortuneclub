<?php
if ( ! function_exists('write_footer'))
{
	function write_footer($for){
	?>
		<div class="footer">
			<div>仅供内部使用</div><div><?php echo $for == 1 ? '新京集团财富管理中心' : 'Internal use only'?></div>		
		</div>

	<?php
	}
}
if ( ! function_exists('write_header'))
{
	function write_header($name){
	?>
		<div class="header">
			<div>案例 - <?php echo $name;?></div>
		</div>

	<?php
	}
}
$name = $age.'岁，'.($gender == 'F' ? '女' : '男').'，保额'.number_to_chinese($face_amount).'美元';
$descs = array(
	0 => '5年最大化投资',
	1 => '前4年中等额度投资，第5年最大化投资',
	2 => '年中等额度投资',
	3 => '5年最大化投资，取钱',
	4 => '前4年中等额度投资，第5年最大化投资，取钱',
);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $name;?></title>
	<?php
	$this->load->view('smd/pages/css.php');
	?>
</head>
<?php
$blocks = array(
	array(
		'head' => '产品介绍',
		'text' => '本款产品为指数型美元投资养老保险产品，保底无市场风险，有稳健的投资回报。过去20年平均年化收益率为7 - 9%。过去65年平均年化收益率最低的25年是7.75%。以下案例中用7.75%回报率保守计算，实际收益有可能更高。'
	),
	array(
		'head' => '产品功能',
		'text' => array(
			'保底无市场风险，稳健的投资回报', '财产的保护以及财富的传承', '全免税：免除投资增益税和收入税', '高杠杆的家庭保护', '灵活的投资取放形式，可流动性现金池', '多功能的运用：保护，教育，退休，遗产，税务'
		)
	),
);
?>
<body onload="window.print();">
<div class="a4">
	<?php write_header($name);?>
	<div class="main">
		<?php
		foreach($blocks as $block){
		?>
		<div class="block">
			<div class="head1">
				<?php echo $block['head'];?>
			</div>
			<div class="text">
				<div class="clearfix">
				<?php 
				if(is_array($block['text'])){
					foreach($block['text'] as $text){
					?>
					<div style="float:left;width:50%;"><div style="margin:0 1mm"><!--&#10023;--><span style="color:#B80000">&#10022;</span>&nbsp;<?php echo $text;?></div></div>	
					<?php
					}
				}
				else{
				?>
					<div><?php echo $block['text'];?></div>	
				<?php
				}
				?>
				</div>
			</div>
		</div>
		<?php
		}
		
		$ages = array(70, 80, 90, 100);
		
		$real_age_count = empty($plans) ? 0 : count($plans[0]['cash_value']);
		?>
		
		<div class="block">
			<div class="head1">案例 - <?php echo $name;?></div>
			<div class="text">
				<?php //$da = explode("\n", $desc);?>
				<!--div><?php echo implode('<br/>', $da);?></div-->
				<br/>
				<table class="t1" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td class="f" style="width:8mm;height:0px"></td>
						<td class="f" style="width:30mm"></td>
					<tr>
					<tr>
						<td colspan="2" class="h t">计划代码</td>
						<?php
						foreach($plans as $i => $plan){
							switch($plan['type']){
								case '0':
								case '3':
									$co = 'A';
									break;
								case '1':
								case '4':
									$co = 'B';
									break;
								default:
									$co = 'C';
							}
							$code = $gender.$age.($plan['type'] < 3 ? 'NC' : 'CO').custom_number_format($face_amount).$co;
						?>
						<td class="h2 t">
							<?php echo $code;?>
						</td>
						<?php
						}
						?>
					</tr>
					<tr>
						<td colspan="2" class="h">计划描述</td>
						<?php
						foreach($plans as $i => $plan){
						?>
						<td>
						<?php 
							echo $plan['type'] == 2 ? $plan['premium']['years'].$descs[$plan['type']] : $descs[$plan['type']];
						?></td>
						<?php
						}
						?>
					</tr>
					<tr>
						<td colspan="2" class="h">投资方案</td>
						<?php
						foreach($plans as $i => $plan){
						?>
						<td>
							从<?php echo $plan['premium']['start_age'];?>岁起每年投<?php echo number_to_chinese($plan['premium']['amount_per_year']);?>美元，
							共投<?php echo $plan['premium']['years'];?>年，
							<?php
							if($plan['premium']['amount_last_year'] > 0){
							?>
							最后一年投<?php echo number_to_chinese($plan['premium']['amount_last_year']);?>美元，
							<?php
							}
							?>
							共<?php echo number_to_chinese($plan['premium_total']);?>美元。
						</td>
						<?php
						}
						?>
					</tr>
					<tr>
						<td colspan="2" class="h">生前取现金方案</td>
						<?php
						foreach($plans as $i => $plan){
						?>
						<td>
							<?php
							if($plan['withdraw']['start_age'] > 0){
							?>
							从<?php echo number_to_chinese($plan['withdraw']['start_age']);?>岁<?php echo $plan['withdraw']['start_age'] > 65 ? '退休' : '小孩上大学';?>起每年取
							<?php echo number_to_chinese($plan['withdraw']['amount_per_year']);?>美元，
							直到<?php echo number_to_chinese($plan['withdraw']['end_age']);?>岁<?php echo $plan['withdraw']['end_age'] == 100 ? '' : '小孩毕业';?>，
							生前共取<?php echo number_to_chinese($plan['withdraw']['total_amount']);?>美元。
							<?php
							}
							?>
						</td>
						<?php
						}
						?>
					</tr>
					<?php
					if(!empty($plans)){
						foreach($plans[0]['cash_value'] as $a => $v){
						?>
						<tr>
							<td rowspan="4" class="h h1 <?php echo $a == 100 ? 'b' : ''?>"><?php echo $a.'<br/>岁';?></td>
							<td class="h">账户现金余额</td>
							<?php
							foreach($plans as $i => $plan){
							?>
							<td class="c g"><?php echo number_to_chinese($plan['cash_value'][$a]);?></td>
							<?php
							}
							?>
						</tr>
						<tr>
							<td class="h">生前取出总额</td>
							<?php
							foreach($plans as $i => $plan){
							?>
							<td class="c g"><?php echo number_to_chinese($plan['withdraw_value'][$a]);?></td>
							<?php
							}
							?>
						</tr>
						<tr>
							<td class="h">身后传承额</td>
							<?php
							foreach($plans as $i => $plan){
							?>
							<td class="c g"><?php echo number_to_chinese($plan['death_benifit'][$a]);?></td>
							<?php
							}
							?>
						</tr>
						<tr>
							<td class="h <?php echo $a == 100 ? 'b' : ''?>">投资回报率</td>
							<?php
							foreach($plans as $i => $plan){
							?>
							<td class="c <?php echo $a == 100 ? 'b' : ''?>">
								<?php echo number_to_chinese($plan['rate'][$a]);?>，
								<?php echo round($plan['rate'][$a] / $plan['premium_total'], 1);?>倍
							</td>
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
	<?php write_footer($for);?>
</div>
<?php
foreach($plan_data as $i => $data){
?>
<div class="a4 clearfix">
	<?php write_header($name);?>
	<div class="main">
		<div class="block clearfix">
			<div class="head1">附 
				<?php 
							switch($plans[$i]['type']){
								case '0':
								case '3':
									$co = 'A';
									break;
								case '1':
								case '4':
									$co = 'B';
									break;
								default:
									$co = 'C';
							}
				
				$code = $gender.$age.($plans[$i]['type'] < 3 ? 'NC' : 'CO').custom_number_format($face_amount).$co;
				echo ($i + 1);?>：详细列表 - 计划 <?php echo $code;?> 
			</div>
			<div class="clearfix">
		<table class="t2 <?php echo count($data) > 53 ? 'th' : 'tf';?>">
			<thead>
				<tr>
					<th style="width:12mm">年龄</th>
					<th>投资金额<br/>每年/总额</th>
					<th>生前取出<br/>每年/总额</th>
					<th>账户<br/>现金余额</th>
					<th>身后传承</th>
				</tr>
			</thead>
			<tbody>
		<?php
		$s1 = 0;
		$s2 = 0;
		$end = count($data) < 50 ? count($data) : 50;
		for($i = 0; $i < $end; ++$i){
			$row = $data[$i];
			$a = intval($row[0]);
			/*if($a > 100){
				continue;
			}
			if($i != 0 && ($a < 70 && $a % 5 != 0)){
				continue;
			}*/
			$s1 += $row[2];
			$s2 += $row[3] + $row[4];
			echo '<tr>';
			echo '<td>'.$row[0].'岁</td>';
			echo '<td>'.number_to_chinese($row[2]).'/'.number_to_chinese($s1).'</td>';
			echo '<td>'.number_to_chinese($row[3] + $row[4]).'/'.number_to_chinese($s2).'</td>';
			if($s2 > 0){
				echo '<td>'.number_to_chinese($row[7]).'</td>';
			}
			else{
				echo '<td>'.number_to_chinese($row[6]).'</td>';
			}
			echo '<td>'.number_to_chinese($row[8]).'</td>';
			echo '</tr>';
		}
		?>
			</tbody>
		</table>
			<?php
			if(count($data) > 50){
			?>
		<table class="t2 th">
			<thead>
				<tr>
					<th style="width:12mm">年龄</th>
					<th>投资金额<br/>每年/总额</th>
					<th>生前取出<br/>每年/总额</th>
					<th>账户<br/>现金余额</th>
					<th>身后传承</th>
				</tr>
			</thead>
			<tbody>
		<?php
		for($i = 50; $i < count($data); ++$i){
			$row = $data[$i];
			$a = intval($row[0]);
			/*if($a > 100){
				continue;
			}
			if($i != 0 && ($a < 70 && $a % 5 != 0)){
				continue;
			}*/
			$s1 += $row[2];
			$s2 += $row[3] + $row[4];
			echo '<tr>';
			echo '<td>'.$row[0].'岁</td>';
			echo '<td>'.number_to_chinese($row[2]).'/'.number_to_chinese($s1).'</td>';
			echo '<td>'.number_to_chinese($row[3] + $row[4]).'/'.number_to_chinese($s2).'</td>';
			if($s2 > 0){
				echo '<td>'.number_to_chinese($row[7]).'</td>';
			}
			else{
				echo '<td>'.number_to_chinese($row[6]).'</td>';
			}
			echo '<td>'.number_to_chinese($row[8]).'</td>';
			echo '</tr>';
		}
		?>
			</tbody>
		</table>		
			<?php
			}
			?>


			</div>
		</div>
	</div>
	<?php write_footer($for);?>
</div>
<?php
}
?>
</body>
</html>
