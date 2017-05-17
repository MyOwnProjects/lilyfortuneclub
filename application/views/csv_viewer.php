<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="google" content="notranslate">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $subject;?></title>
	<style>

.csv-output{width:100%;border-collapse:collapse;border-spacing:0;border:1px solid #000}
.csv-output tr td{padding:0;border:1px solid #000;padding:2px}
.csv-output tr:first-child td, .csv-output tr td:first-child{background:#d5d5d5}
.csv-output tr:first-child td{text-align:center}		
	</style>
 <script src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
  </head>

<body>
	<h3><?php echo $subject;?></h3>
	<table class="csv-output">
		<tr>
			<td></td>
		<?php
		for($i = 0; $i < $max_columns; ++$i){
			echo '<td>'.chr($i + 65).'</td>';
		}
		?>
		</tr>
	<?php
		foreach($data as $i => $row){
			if(empty($row)){
				continue;
			}
			echo '<tr><td>'.($i + 1).'</td><td>';
			echo implode('</td><td>', $row);
			echo '</td></tr>';
		}
	?>
	</table>
  </body>
</html>