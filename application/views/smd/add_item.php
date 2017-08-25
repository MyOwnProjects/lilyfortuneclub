<?php
$item_count = isset($items) ? count($items) : 0;
$half_count = floor($item_count / 2 - 0.5);
?>
<div class="row">
	<div class="col-lg-<?php echo $item_count > 6 ? '6' : '12';?>">
		<?php
		if(isset($items)){
		foreach($items as $i => $item){
			if($item['tag'] == 'text'){
				echo '<p>'.$item['text'].'<p>';
				continue;
			}
		?>
		<div class="form-group">
			<label for="<?php echo is_string($item['name']) ? $item['name'] : '';?>"><?php echo $item['label'];?></label>
				<?php echo array_key_exists('required', $item) ? '<span class="text-danger">*</span>' : ''; ?>

			<?php
			if($item['tag'] == 'combo'){
				if($item['type'] == 'year_month'){
			?>
			<div>
			<select class="form-control dialog-edit-field" style="display:inline;width:auto" id="<?php echo $item['name']['year'];?>">
					<?php
						foreach($item['options']['year'] as $option){
						?>
						<option value="<?php echo $option['value'];?>" <?php echo $item['value']['year'] == $option['value'] ? 'selected' : ''?>><?php echo $option['text'];?></option>
						<?php
						}
					?>
			</select>
			/
			<select class="form-control dialog-edit-field" style="display:inline;width:auto" id="<?php echo $item['name']['month'];?>">
					<?php
						foreach($item['options']['month'] as $option){
						?>
						<option value="<?php echo $option['value'];?>" <?php echo $item['value']['year'] == $option['value'] ? 'selected' : ''?>><?php echo $option['text'];?></option>
						<?php
						}
					?>
			</select>
			</div>
			<?php			
				}
			}
			else if($item['tag'] == 'textarea'){
			?>
			<textarea class="form-control dialog-edit-field" name="<?php echo $item['name'];?>" id="<?php echo $item['name'];?>"><?php echo array_key_exists('value', $item) ? $item['value'] : '';?></textarea>
			<?php
			}
			else if($item['tag'] == 'select'){
			?>
				<select class="form-control dialog-edit-field" id="<?php echo $item['name'];?>" name="<?php echo $item['name'];?>">
					<?php
					if(array_key_exists('optgroups', $item)){
						foreach($item['optgroups'] as $group){
					?>
						<optgroup label="<?php echo $group['label']?>">
						<?php
							foreach($group['options'] as $option){
						?>
						<option value="<?php echo $option['value'];?>" <?php echo $item['value'] == $option['value'] ? 'selected' : ''?>><?php echo $option['text'];?></option>
						<?php
						}
						?>
						</optgroup>	
					<?php
						}
					}
					else{
						foreach($item['options'] as $option){
						?>
						<option value="<?php echo $option['value'];?>" <?php echo array_key_exists('value', $item) && $item['value'] == $option['value'] ? 'selected' : ''?>><?php echo $option['text'];?></option>
						<?php
						}
					}
					?>
				</select>
			<?php
			}
			else if($item['tag'] == 'input'){
				$attributes = '';
				foreach($item as $name => $value){
					if($name != 'tag' && $name != 'label'){
						$attributes .= $name.'="'.$value.'"';	
					}
				}
			?>
			<?php
				if(array_key_exists('type', $item) && $item['type'] == 'file'){
			?>
			<div id="input-file">
			</div>
			<input class="dialog-edit-field" type="hidden" id="<?php echo $item['name'];?>">
			<?php
				}
				else{
			?>
				<input <?php echo $attributes;?> class="form-control dialog-edit-field" id="<?php echo $item['name'];?>" <?php echo array_key_exists('type', $item) && $item['type'] == 'file' ? 'onchange="selected_files_change(this)"' :''?>>
			<?php
				}
			}
			else if($item['tag'] == 'image'){
			?>
				<form action="/upload-target" class="dropzone"></form>
				<div class="clearfix">
					<div id="image-preview" class="pull-left" style="color:red;font-size:12px;cursor:pointer;margin-right:20px;width:60px;height:60px;border:1px solid #d5d5d5" onclick="$('#upload-file').click();"></div>
					<div class="overflow:hidden">
						<input type="file" id="upload-file" name="upload-file" accept="image/*" onchange="upload_file(this)" style="display:none">
						<div id="local-file-name" style="line-height:30px"><a href="#" onclick="$('#upload-file').click();">Click to select a file</a></div>
						<input id="target-file-name" type="hidden" class="dialog-edit-field">
						<div id="uploaded-progress-bar" class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0">
								0
							</div>
						</div>
					</div>
				</div>
			<?php
			}
		}
			?>
		</div>
	<?php
	if($item_count > 6 && $i == $half_count){
	?>
	</div>
	<div class="col-lg-6">
	<?php	
	}
	}
		?>
	</div>
</div>

<script>
(function($){
	if($('#input-file')){	
		$('#input-file').ajax_upload('<?php echo base_url();?>smd/documents/upload_files').change(function(files){
			var file_names = [];
			for(var i = 0; i < files.length; ++i){
				file_names.push(files[i]['final_file_name']);
			}
			$('#input-file').next().val(file_names);
		});
	}
	
	/*var my_jstz = jstz();
	$('select[type=timezone']).each(function(index, obj){
		$(obj).children('option').each(function(i, option){
			var $_option = $(option);
			if($_option.val() == my_jstz.timezone_name){
				$_option.attr('selected', true);
			}
			else{
				$_option.removeAttr('selected');
			}
		});
		my_jstz.timezone_name
	data: {timezone: my_jstz.timezone_name, dst: my_jstz.uses_dst ? 'Y' : 'N'},
						
	});
	
	$('select[type=dst']).each(function(index, obj){
		$(obj).children('option').each(function(i, option){
			var $_option = $(option);
			if($_option.val() == my_jstz.timezone_name){
				$_option.attr('selected', true);
			}
			else{
				$_option.removeAttr('selected');
			}
		});
	});*/
}(jQuery));

</script>