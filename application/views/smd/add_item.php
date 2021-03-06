
<style>
 .dialogWide > .modal-dialog {
     width: 80% !important;
 }
 <?php 
 if($width){
?>
 /*@media (min-width: 576px)*/
.modal-dialog {
    max-width: 700px !important;
}
 <?php
 }
 ?>
</style>
<?php
$item_count = isset($items) ? count($items) : 0;
$col_width = 4;
if($item_count <= 4){
	$col_width = 12;
}
else if($item_count <= 10){
	$col_width = 6;
}

$half_count = floor($item_count / 2 - 0.5);
?>
<div class="row">
	<?php
	if(isset($items)){
	foreach($items as $i => $item){
		$is_auto_fill = array_key_exists('name', $item) && $item['name'] == 'auto-fill';
		if($is_auto_fill){
	?>
		<div class="col-lg-12">
			<div class="form-group">
				<textarea id="auto-fill" fill-type="<?php echo $item['fill_type'];?>" class="form-control control-sm"></textarea>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="form-group">
				<span class="btn btn-sm btn-primary" id="auto-fill-btn">Fill</span>
			</div>
		</div>
	<?php
	continue;
		}
		if($item['tag'] == 'text'){
		?>
		<div class="col-lg-12">
			<?php echo $item['text'];?>
		</div>
		<?php
			continue;
		}
		?>
	<div class="col-lg-<?php echo $col_width;?>">
		<div class="form-group">
			<label class="" for="<?php echo is_string($item['name']) ? $item['name'] : '';?>"><?php echo $item['label'];?></label>
				<?php echo array_key_exists('required', $item) ? '<span class="text-danger">*</span>' : ''; ?>

			<?php
			if($item['tag'] == 'combo'){
				if($item['type'] == 'year_month'){
			?>
			<div>
			<select class="form-control input-sm dialog-edit-field" style="display:inline;width:auto" id="<?php echo $item['name']['year'];?>">
					<?php
						foreach($item['options']['year'] as $option){
						?>
						<option value="<?php echo $option['value'];?>" <?php echo $item['value']['year'] == $option['value'] ? 'selected' : ''?>><?php echo $option['text'];?></option>
						<?php
						}
					?>
			</select>
			/
			<select class="form-control input-sm dialog-edit-field" style="display:inline;width:auto" id="<?php echo $item['name']['month'];?>">
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
				else if($item['type'] == 'date_time'){
					if(array_key_exists('value', $item)){
						$dt = explode(' ', $item['value']);
					}
					else{
						$dt = array();
					}
			?>
			<div>
			<input class="form-control input-sm dialog-edit-field mb-1" type="date" id="<?php echo $item['name']?>_date" value="<?php echo empty($dt) ? '' : $dt[0];?>">
			<select class="form-control input-sm dialog-edit-field" id="<?php echo $item['name']?>_time">
					<option value="0">None</option>
					<?php
						for($i = 0; $i < 24; ++$i){
						?>
						<option value="<?php echo $i;?>:00:00" <?php echo !empty($dt) && count($dt) > 1 && $dt[1] == date_format(date_create("$i:00:00"), 'H:i:00') ? 'selected' : '';?>><?php echo date_format(date_create("$i:00:00"), 'h:i A');?></option>
						<option value="<?php echo $i;?>:30:00" <?php echo !empty($dt) && count($dt) > 1 && $dt[1] == date_format(date_create("$i:30:00"), 'H:i:00') ? 'selected' : '';?>><?php echo date_format(date_create("$i:30:00"), 'h:i A');?></option>
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
			<textarea class="form-control input-sm dialog-edit-field" name="<?php echo $item['name'];?>" id="<?php echo $item['name'];?>"><?php echo array_key_exists('value', $item) ? $item['value'] : '';?></textarea>
			<?php
			}
			else if($item['tag'] == 'select'){
				$add_class = array_key_exists('class', $item) ? $item['class'] : '';
			?>
				<select class="form-control input-sm dialog-edit-field <?php echo $add_class;?>" id="<?php echo $item['name'];?>" name="<?php echo $item['name'];?>">
				<?php
					foreach($item['options'] as $option){
						if(array_key_exists('optgroups', $option) && $option['optgroups']){
					?>
						<optgroup label="<?php echo $option['label']?>">
					<?php
						foreach($option['options'] as $o){
					?>
							<option value="<?php echo $o['value'];?>" <?php echo array_key_exists('value', $item) && $item['value'] == $o['value'] ? 'selected' : ''?>><?php echo $o['text'];?></option>
					<?php
						}
					?>
						</optgroup>
					<?php		
						}
						else{
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
				<input <?php echo $attributes;?> class="form-control input-sm dialog-edit-field" id="<?php echo $item['name'];?>" <?php echo array_key_exists('type', $item) && $item['type'] == 'file' ? 'onchange="selected_files_change(this)"' :''?>>
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
			else if($item['name'] == 'video_duration'){
				if(!empty($item['value'])){
					$a = explode(',', $item['value']);
				}
			?>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Start</span>
				</div>
				<input type="number" min="0" class="form-control dialog-edit-field" min="0" name="video_duration_start" id="video_duration_start" value="<?php echo empty($item['value']) ? '': intval($a[0]);?>">
				<div class="input-group-prepend">
					<span class="input-group-text">End</span>
				</div>
				<input type="number" min="0" class="form-control dialog-edit-field" min="0" name="video_duration_end" id="video_duration_end" value="<?php echo empty($item['value']) ? '': intval($a[1]);?>">
			</div>				
			<?php
			}
			?>
		</div>
	</div>
		<?php		
		}
	if($item_count > 6 && $i == $half_count){
	?>
	<div class="col-lg-6">
	<?php	
	}
	}
		?>
	</div>
</div>

<script>
// a and b are javascript Date objects
function dateDiffInDays(b, a) {
  // Discard the time and time-zone information.
  var utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
  var utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());
 
  return Math.floor((utc2 - utc1) / (1000 * 60 * 60 * 24));
}

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
$(document).ready(function(){
	$('.selectpicker').attr('data-live-search', 'true').selectpicker();
	$('#auto-fill-btn').click(function(){
		var fill_type = $('#auto-fill').attr('fill-type');
		if(fill_type == 'team_member'){
			var content_array = $('#auto-fill').val().trim().split('\n');
			var name = null;
			var phone_list = [];
			var address = [];
			for(var i = 0; i < content_array.length; ++i){
				var line = content_array[i].trim();
				if(line.length > 0){
					if(line[line.length - 1] == ':'){
						name = line.substr(0, line.length - 1);
					}
					else{
						switch(name){
							case 'Name':
								lpos = line.indexOf('(');
								rpos = line.indexOf(')');
								code_len = rpos - lpos - 1;
								$('#membership_code').val(line.substr(line.length - (code_len + 1), code_len)); 
								line = line.substr(0, line.length - (code_len + 2)).trim();
								var pos = line.lastIndexOf(' ');
								$('#first_name').val(line.substr(0, pos));
								$('#last_name').val(line.substr(pos + 1, line.length - pos));
								break;
							case 'Level':
								$('#grade').val(line);
								break;
							case 'Start Date':
								var date = new Date(line);
								var today = new Date();
								var diff = dateDiffInDays(today, date);
								var date_str = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
								if(diff > 180){
									$('#start_date').val(today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0'));
									$('#original_start_date').val(date_str);
								}
								else{
									$('#start_date').val(date_str);
								}
								break;
							case 'DOB':
								var date = new Date(line + ' 2017');
								var date_str = '1900-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0');
								$('#date_of_birth').val(date_str);
								break;
							case 'Home Phone':
								phone_list.push('H:' + line);
								break;
							case 'Business Phone':
								phone_list.push('B:' + line);
								break;
							case 'Mobile Phone':
								phone_list.push('M:' + line);
								break;
							case 'Personal Email':
								$('#email').val(line);
								break;
							case 'Home Address':
								address.push(line);
								break;
							case 'Recruiter':
								var p = line.lastIndexOf(' ');
								var l_first_name = line.substr(0, p).toLowerCase();
								var l_last_name = line.substr(p + 1).toLowerCase();
								for(var ii = 0; ii < $('#recruiter option').length; ++ii){
									var obj = $('#recruiter option:nth-child(' + (ii + 1) + ')');
									var v = $(obj).html().trim().toLowerCase();
									var p1 = v.indexOf('(');
									var p2 = v.indexOf(')');
									if(p1 >= 0 && p2 >= 3){
										var v_nick_name = v.substr(p1 + 1, p2 - p1 - 1);
										v = v.substr(0, p1).trim();
									}
									var p = v.lastIndexOf(' ');
									var v_first_name = v.substr(0, p).toLowerCase();
									var v_last_name = v.substr(p + 1).toLowerCase();
									if(l_last_name == v_last_name && 
										( l_first_name == v_first_name || l_first_name == v_nick_name)){
										$('#recruiter').val($(obj).val()).selectpicker('refresh');
										break;
									}
								}
								break;
						}
					}
				}
			}
			if(address.length >= 2){
				$('#street').val(address[0]);
				var ar = address[1].split(',');
				$('#city').val(ar[0].trim());
				ar = ar[1].split('-');
				$('#country').val(ar[1].trim());
				ar = ar[0].trim().split(' ');
				$('#state').val(ar[0].trim());
				$('#zipcode').val(ar[1].trim());
			}
			$('#phone').val(phone_list.join(','));
		}
	});

});
</script>