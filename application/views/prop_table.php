<style>
.table-prop:not(:last-child){margin-right:20px}
.table-prop{margin-bottom:20px}
.table-prop td{padding:2px 5px;border:1px solid #e5e5e5}
.table-prop td.prop-label{background:#f8f8f8;text-align:right}
.table-prop input, .table-prop select, .table-prop textarea{border:none;outline:none;box-sizing:border-box;width:100%;line-height:initial !important}
	
</style>
<table class="table-prop pull-left" border="0" cellspacing="0" cellpadding="0">
				<?php
				foreach($field as $id => $prop){
				?>
				<tr>
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
