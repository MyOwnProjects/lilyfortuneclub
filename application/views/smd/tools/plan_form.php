
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $name?></title>
	<!--meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<link href='http://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link rel="icon" type="image/png/ico" href="<?php echo base_url();?>src/img/lfc.ico"-->
	<!--link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/css/bootstrap.css?<?php time();?>" />
	<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script-->
	<style>
		.clearfix:after{content:"";display: table;clear: both}
		table{table-layout:fixed;font-size:12px;border-collapse:collapse;}
		table.t1 thead td, table.t1 thead th{padding:5px 2px}
		table thead th, table thead td, table tbody td{border: 1px solid #d5d5d5}
		table thead th, table thead td{background:#f5f5f5;vertical-align:middle;text-align:center}
		table td.c{text-align:center}
		table tbody td{line-height:20px}
		table.t1 tbody td{padding:0 2px;}
		table:not(.t1) thead th{padding:5px 10px;}
		table:not(.t1) tbody td{padding:0 5px;}
	</style>
</head>
<body>
<?php
$ages = array(45, 55, 65, 75, 85, 95, 100);
$real_age_count = count($plans[0]['cash_value']);
?>
<h3>案例 <?php echo $name?></h3>
<?php $da = explode("\n", $desc);?>
<p><?php echo ($gender == 'F' ? '女' : '男').', '.$age.'岁。 <br/>'.implode('<br/>', $da);?><br/></p>
<table class="t1" cellspacing="0" cellpadding="0" border="0" style="width:1790px">
	<thead>
      <tr>
        <th rowspan="2" style="width:20px"></th>
        <th rowspan="2" style="width:100px">描述</th>
        <th rowspan="2" style="width:200px">投资额</th>
        <th rowspan="2" style="width:200px">生前取出现金值 - 全部免税</th>
		<?php
		foreach($plans[0]['cash_value'] as $age => $v){
			echo '<th colspan="4" style="width:165px">'.$age.'岁</th>';
		}
		?>
      </tr>
	  <tr>
		  <?php
		  for($i = 0; $i < $real_age_count; ++$i){
			 ?>
        <td style="width:40px">账户现金余额</td>
        <td style="width:40px">生前取出总额</td>
        <td style="width:40px">身后传承额</td>
        <td style="width:40px">投资杠杆</td>
		  <?php
		  }
		  ?>
	  </tr>
    </thead>
    <tbody>
		<?php 
		foreach($plans as $i => $plan){
			$premium_total = $plan['premium']['amount_per_year'] * $plan['premium']['years'] + $plan['premium']['amount_last_year'];
		?>
		<tr>
			<td style="text-align:center"><?php echo $i + 1;?></td>
			<td><?php echo $plan['desc'];?></td>
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
				foreach($plan['cash_value'] as $a => $v){
			?>
				<td class="c" style="color:red"><?php echo number_to_chinese($v);?></td>
				<td class="c" style="color:blue"><?php echo number_to_chinese($plan['withdraw_value'][$a]);?></td>
				<td class="c" style="color:green"><?php echo number_to_chinese($plan['death_benifit'][$a]);?></td>
				<td class="c">
					<?php echo number_to_chinese($plan['rate'][$a]);?>
					<br/>
					<?php echo round($plan['rate'][$a] / $premium_total, 1);?>倍
				</td>
			<?php 
				}
			?>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
<br/><br/><br/><br/>
<?php
if($illu){
?>
<div class="clearfix" style="width:1790px">
<?php
foreach($plan_data as $i => $data){
?>
	<table style="float:left;margin-right:20px">
		<thead>
		<tr>
			<th colspan="7">计划 <?php echo ($i + 1);?></th>
		</tr>
			<tr>
				<th>年龄</th>
				<th>每年投资<br/>金额</th>
				<th>累积投资<br/>金额</th>
				<th>生前每年<br/>取出</th>
				<th>生前取出<br/>总额</th>
				<th>账户现金<br/>余额</th>
				<th>身后传承</th>
			</tr>
		</thead>
		<tbody>
	<?php
	$s1 = 0;
	$s2 = 0;
	foreach($data as $row){
		$s1 += $row[2];
		$s2 += $row[3] + $row[4];
		echo '<tr>';
		echo '<td>'.$row[0].'岁</td>';
		echo '<td>'.number_to_chinese($row[2]).'</td>';
		echo '<td>'.number_to_chinese($s1).'</td>';
		echo '<td>'.number_to_chinese($row[3] + $row[4]).'</td>';
		echo '<td>'.number_to_chinese($s2).'</td>';
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

<?php
}
?>

</body>
</html>
