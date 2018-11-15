<style>
.table-prop-wrapper{border:1px solid #888;}
.table-prop{border:none;width:100%}
.table-prop tr td{padding:2px 5px;border:1px solid #e5e5e5}
.table-prop td.prop-label{background:#f8f8f8;text-align:right;width:300px}
.table-prop input, .table-prop select, .table-prop textarea{border:none;outline:none;box-sizing:border-box;width:100%;line-height:initial !important}
.table-prop	tr.prop-error td:first-child{border-right:1px solid red}
.table-prop	tr.prop-error td:last-child{border:1px solid red}
.table-prop tr.prop-split td{border-bottom:1px solid #888 !important;}
.table-prop tr:first-child td{border-top:none !important}
.table-prop tr:last-child td{border-bottom:none !important}
.table-prop tr td:first-child{border-left:none !important}
.table-prop tr td:last-child{border-right:none !important}
</style>
<div class="table-prop-wrapper">
<table class="table-prop" border="0" cellspacing="0" cellpadding="0">
				<?php
				foreach($field as $id => $prop){
					if($prop == 'split') continue;
				?>
				<tr class="<?php echo array_key_exists('split', $prop) && $prop['split'] ? 'prop-split' : '';?> <?php echo !empty($error) && in_array($id, $error['fields']) ? 'prop-error' : ''; ?>">
					<td class="prop-label"><?php echo $prop['label'];?></td>
					<td class="prop-value">
						<?php
						if(array_key_exists('tag', $prop)){
							echo '<'.$prop['tag'].' name="'.$id.'"';
							foreach($prop as $name => $value){
								if(!in_array($name, array('label', 'tag', 'options'))){
									if($prop['tag'] == 'textarea' && $name == 'value'){
										continue;
									}
									echo ' '.$name.'="'.$value.'"';
								}
							}
							echo '>';
							if($prop['tag'] == 'select'){
								foreach($prop['options'] as $o){
									echo '<option value="'.$o['value'].'"'.($o['selected'] ? ' selected' : '').'>'.$o['text'].'</option>';
								}
								echo "</select>";
							}
							else if($prop['tag'] == 'textarea'){
								echo $prop['value'];
								echo "</textarea>";
							}
						}
						else{
							echo $value;
						}
						?>
					</td>
				</tr>
				<?php
				}
				?>
			</table>
</div>
<script>
$('.table-prop .prop-value input, .table-prop .prop-value select, .table-prop .prop-value textarea').change(function(){
	$('.table-prop tr').removeClass('prop-error');
});	
</script>
