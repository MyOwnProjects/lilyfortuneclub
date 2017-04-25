<table class="table table-striped">
	<tr>
		<?php
		foreach($header as $h){
			echo '<th>'.$h.'</th>';
		}
		?>
	</tr>
	<?php
	foreach($body as $row){
		echo '<tr>';
		foreach($row as $v){
			echo '<td>'.$v.'</td>';
			
		}
		echo '</tr>';
	}
	?>
	
</table>
<button class="btn btn-primary btn-sm">Import</button>
