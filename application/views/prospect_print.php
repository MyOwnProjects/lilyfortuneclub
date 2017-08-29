<style>
#main-header, footer{display:none}
table{width:100%}
thead td{background:green;color:#fff;font-weight:bold}
table td{padding:2px 5px;padding:10px;vertical-align:top;text-align:left}
.cell-row{margin:5px}
.cell-row .cell-label{float:left;line-height:30px;padding-right:10px;width:90px;text-align:right}
.cell-row .cell-value{overflow:hidden}
input[type=text], textarea{border:1px solid #f6f6f6}
textarea{box-sizing:border-box;width:100%;}
input[type=button]{width:60px !important;box-sizing:border-box;}
.prospect-save{color:blue} 
.prospect-save-disabled{color:silver}
</style>
<div style="padding:40px">
	<h3 class="text-center">Prospect List</h3>
	<table class="prospect-table table-bordered table-striped">
		<thead>
			<tr>
				<td style="width:40px">Seq</td>
				<td style="width:150px">Name</td>
				<td style="width:120px">Phone</td>
				<td>Comment</td>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($list as $i => $l){
		?>
		<tr data-id="<?php echo $l['prospects_id'];?>">
			<td><?php echo ($i+ 1);?></td>
			<td>
				<div><?php echo $l['prospects_name'];?></div>
			</td>
			<td>
				<div><?php echo $l['prospects_phone'];?></div>
			</td>
			<td>
				<div><?php echo str_replace("\n", '<br/>', $l['prospects_background']);?></div>
			</td>
		</tr>
		
		<?php
		}
		?>
		</tbody>
	</table>
