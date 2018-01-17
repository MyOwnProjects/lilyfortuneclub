
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $name?></title>
	<link rel="icon" type="image/png/ico" href="<?php echo base_url();?>src/img/smd.ico">
	<!--meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<link href='http://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<!--link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/css/bootstrap.css?<?php time();?>" />
	<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script-->
	<style>
		body{margin:0;padding:0}
		.a4{width:200mm;height:287mm;padding:5mm;margin:0 auto;overflow:auto;}
		.clearfix:after{content:"";display:table;clear:both}
		ul,ul li{padding:0;margin:0;list-style:none}
		.block .head1{color:#8B0000;font-weight:bold;font-size:5mm;line-height:10mm}
		.block:not(:first-child) .head1{margin-top:5mm}
		.block .text{font-size:3.5mm;line-height:5mm}
		
		table{table-layout:fixed;border-collapse:collapse;}
		table.t1 td.h.h1.h2{font-size:3.5mm}
		table.t1 td:not(.h):not(.h1):not(.h2){font-size:3.5mm}
		table.t1 tr td.h{padding:0.5mm 0;text-align:center;vertical-align:middle;color:#fff;background:#8B0000/*#d9534f*/;font-weight:bold}
		table.t1 tr td.h1{border-right:1px solid #fff;}
		table.t1 tr td.h:first-child{border-left:1px solid #8B0000;}
		table.t1 td.h:not(.b){border-bottom:1px solid #fff}
		table.t1 td:not(.h):not(.f){padding:5px 5px;vertical-align:top;text-align:left}
		table.t1 td.h2{color:#000;font-weight:bold;border-bottom:1px solid #8B0000}
		table.t1 td:not(.h):not(.h1):not(.h2):not(.b):not(.f):not(.g){border-bottom:1px solid #858585}
		table.t1 td.g{border-bottom:1px solid #f5f5f5}
		table.t1 td.h2.t{text-align:center}
		table.t1 tr td:last-child{border-right:1px solid #8B0000}
		table.t1 td.t{border-top:1px solid #8B0000}
		table.t1 td.b{border-bottom:1px solid #8B0000}
		table.t1 tr td:not(:last-child):not(.h):not(.h1):not(.h2){border-right:1px solid #858585}
		table.t1 tr td.h2:not(:last-child){border-right:1px solid #8B0000 !important}
		
		table.t2{text-align:center;table-layout:fixed;border-collapse:collapse;font-size:3.5mm}
		table.t2.th{width:95mm}
		table.t2.tf{width:200mm}
		table.t2:first-child{float:left}
		table.t2:nth-child(2){float:right}
		table.t2 tr td{border-top:1px solid #e5e5e5;white-space:nowrap;}
	</style>
</head>
<?php
$blocks = array(
	array(
		'head' => '产品介绍',
		'text' => array(
			'本款产品为指数型美元投资养老保险产品，保底无市场风险，有稳健的投资回报。过去20年平均年化收益率为7 - 9%。过去65年平均年化收益率最低的25年是7.75%。以下案例中用7.75%回报率保守计算，实际收益有可能更高。'
		)
	),
	array(
		'head' => '产品功能',
		'text' => array(
			' - 保底无市场风险，稳健的投资回报', ' - 财产的保护以及财富的传承', ' - 全免税：免除投资增益税和收入税', ' - 高杠杆的家庭保护', ' - 灵活的投资取放形式，可流动性现金池', ' - 多功能的运用：保护，教育，退休，遗产，税务'
		)
	),
);
?>
<body>
	<div class="a4">
		<?php
		foreach($blocks as $block){
		?>
		<div class="block">
			<div class="head1">
				<?php echo $block['head'];?>
			</div>
			<div class="text">
				<ul class="clearfix">
				<?php 
				foreach($block['text'] as $text){
				?>
					<li><?php echo $text;?></li>	
				<?php
				}
				?>
				</ul>
			</div>
		</div>
		<?php
		}
		
		$ages = array(70, 80, 90, 100);
		$real_age_count = count($plans[0]['cash_value']);
		?>
		
		<div class="block">
			<div class="head1">案例 - <?php echo $name?></div>
			<div class="text">
				<?php $da = explode("\n", $desc);?>
				<div><?php echo implode('<br/>', $da);?></div>
				<br/>
				<table class="t1" cellspacing="0" cellpadding="0" border="0" style="width:200mm">
					<tr>
						<td class="f" style="width:8mm;height:0px"></td>
						<td class="f" style="width:30mm"></td>
					<tr>
					<tr>
						<td colspan="2" class="h t">计划代码</td>
						<?php
						foreach($plans as $i => $plan){
						?>
						<td class="h2 t">
							<?php echo $plan['code'];?>
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
						<td><?php echo $plan['desc'];?></td>
						<?php
						}
						?>
					</tr>
					<tr>
						<td colspan="2" class="h">投资方案</td>
						<?php
						foreach($plans as $i => $plan){
							$premium_total = $plan['premium']['amount_per_year'] * $plan['premium']['years'] + $plan['premium']['amount_last_year'];
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
							共<?php echo number_to_chinese($premium_total);?>美元。
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
						<td class="h <?php echo $a == 100 ? 'b' : ''?>">投资杠杆</td>
						<?php
						foreach($plans as $i => $plan){
						?>
						<td class="c <?php echo $a == 100 ? 'b' : ''?>">
							<?php echo number_to_chinese($plan['rate'][$a]);?>，
							<?php echo round($plan['rate'][$a] / $premium_total, 1);?>倍
						</td>
						<?php
						}
						?>
					</tr>
					<?php
					}
					?>
				</table>
				
			</div>
		</div>
	</div>
<?php
foreach($plan_data as $i => $data){
?>
<div class="a4 clearfix">
	<div class="block clearfix">
		<div class="head1">附 <?php echo ($i + 1);?>：详细列表 - 计划 <?php echo $plans[$i]['code'];?> </div>
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
	$end = count($data) < 53 ? count($data) : 53;
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
		echo '<td>'.number_to_chinese($row[6]).'</td>';
		echo '<td>'.number_to_chinese($row[8]).'</td>';
		echo '</tr>';
	}
	?>
		</tbody>
	</table>
		<?php
		if(count($data) > 53){
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
	$s1 = 0;
	$s2 = 0;
	for($i = 53; $i < count($data); ++$i){
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
		echo '<td>'.number_to_chinese($row[6]).'</td>';
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
<?php
}
?>
	</body>
</html>
