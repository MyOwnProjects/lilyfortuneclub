<style>
.row-bg{border-top:1px solid #d5d5d5}
.prop-row{margin:5px 0}
.prop-label{text-transform:capitalize;width:160px;margin-right:10px;text-align:right;line-height:30px;font-weight:bold}
.prop-value input, .prop-value select, .prop-value textarea{outline:none;cursor:pointer;border:1px solid #fff;box-sizing:border-box;width:100%;line-height:initial !important}
.prop-value input:hover, .prop-value select:hover, .prop-value textarea:hover{border:1px solid #ced4da;outline:none}
.prop-value input:focus, .prop-value select:focus, .prop-value textarea:focus{outline:none;}
.prop-value textarea{height:200px !important;}
.bootstrap-select .btn{padding:0;border:none}

.bootstrap-select .btn-group.open .dropdown-toggle{webkit-box-shadow:none;box-shadow:none}
.bootstrap-select .btn-default:active, .bootstrap-select .btn-default:focus, .bootstrap-select .btn-default:hover, .bootstrap-select .open>.dropdown-toggle.btn-default {background-color:#fff !important;border-color:#fff !important}
</style>
<?php
$fields = array();
	foreach($policy as $n => $v){
		if($n == 'policies_id'){
			continue;
		}
		$fields[$n] = array();
		$fields[$n]['label'] = str_replace('_', ' ', substr($n, 9)); 
		if(in_array($n, array('policies_status', 'policies_provider', 'policies_owner_gender', 'policies_insured_gender'
			, 'policies_writing_agent', 'policies_split_agent'))){
			$fields[$n]['tag'] = 'dropdownedit';
			if($n == 'policies_owner_gender' || $n == 'policies_insured_gender'){
				$fields[$n]['readonly']= 'true';
				$fields[$n]['options']= array(
					array('value' => '', 'text' => 'Unknown'),
					array('value' => 'F', 'text' => 'Female'),
					array('value' => 'M', 'text' => 'Male'),
				);
			}
			else if($n == 'policies_provider'){
				$fields[$n]['readonly']= 'true';
				$fields[$n]['options']= array(
					array('value' => 'Transamerica', 'text' => 'Transamerica'),
					array('value' => 'Nationwide', 'text' => 'Nationwide'),
					array('value' => 'Pacific Life', 'text' => 'Pacific Life'),
				);
			}
			else if($n == 'policies_status'){
				$fields[$n]['readonly']= 'true';
				$fields[$n]['options']= array(
					array('value' => 'Active', 'text' => 'Active'),
					array('value' => 'Approved', 'text' => 'Approved'),
					array('value' => 'Incomplete', 'text' => 'Incomplete'),
					array('value' => 'Pending', 'text' => 'Pending'),
					array('value' => 'Declined', 'text' => 'Declined'),
				);
			}
			else if(in_array($n, array('policies_writing_agent', 'policies_split_agent'))){
				$fields[$n]['options']= array();
				foreach($users as $u){
					array_push($fields[$n]['options'], array('value' => $u['value'], 'text' => $u['text']));
				}
			}
		}
		/*else if(in_array($n, array('policies_writing_agent', 'policies_split_agent'))){
			$fields[$n]['tag'] = 'dropdownedit';
			$fields[$n]['options']= array();
			foreach($users as $u){
				array_push($fields[$n]['options'], array('value' => $u['value'], 'text' => $u['text']));
			}
		}*/
		else if($n == 'policies_notes'){
			$fields[$n]['tag'] = 'textarea';
		}
		else{
			$fields[$n]['tag'] = 'input';
		}
		
		if(in_array($n, array('policies_issue_date', 'policies_insured_dob', 'policies_owner_dob'))){
			$fields[$n]['type'] = 'date';
		}
		if(in_array($n, array('policies_face_amount', 'policies_target_premium'))){
			$fields[$n]['type'] = 'number';
		}
		$fields[$n]['value'] = $v;
		if(in_array($n, array('policies_target_premium', 'policies_owner_gender', 'policies_insured_gender'))){
			array_push($fields, 'split');
		}
		
	}

?>
<div style="margin:40px"> 
	<h4>Policy Case</h4>
	<div class="row row-bg">
	<?php
		foreach($fields as $id => $prop){
		if($prop == 'split'){
	?>
	</div>
	<div class="row row-bg">
	<?php
		}
		else{
	?>
		<div class="col-md-6 col-ms-12 d-flex prop-row">
			<div class="prop-label"><?php echo $prop['label'];?>:</div>
			<div class="prop-value flex-fill">
						<?php
						if(array_key_exists('tag', $prop)){
							if($prop['tag'] == 'input'){
							?>
							<input class="form-control form-control-sm" id="<?php echo $id;?>" name="<?php echo $id;?>" value="<?php echo $prop['value'];?>" type="<?php array_key_exists('type', $prop) ? $prop['type'] : 'text';?>">
							<?php
							}
							else if($prop['tag'] == 'select'){
							?>
							<select class="form-control form-control-sm" id="<?php echo $id;?>" name="<?php echo $id;?>" >
							<?php
								foreach($prop['options'] as $o){
									echo '<option value="'.$o['value'].'"'.($o['value'] == $prop['value'] ? ' selected' : '').'>'.$o['text'].'</option>';
								}
							?>
							</select>
							<?php
							}
							else if($prop['tag'] == 'textarea'){
							?>
							<textarea class="form-control form-control-sm" id="<?php echo $id;?>" name="<?php echo $id;?>"><?php echo $prop['value'];?></textarea>
							<?php
							}
							else if($prop['tag'] == 'dropdownedit'){
							?>
							<div class="dropdown">
								<?php
								$display_value = '';
								foreach($prop['options'] as $o){
									if($prop['value'] == $o['value']){
										$display_value = $o['text'];
										break;
									}
								}
								?>
								
								<input type="text" class="dropdown-toggle form-control form-control-sm" data-toggle="dropdown" name="<?php echo $id;?>" id="<?php echo $id;?>" value="<?php echo $display_value;?>" <?php echo array_key_exists('readonly', $prop) ? 'readonly' : ''; ?> style="background:#fff">
								<div class="dropdown-menu" style="max-height:200px;overflow-y:auto;right:0px !important;padding:0 !important">
									<?php
									foreach($prop['options'] as $o){
									?>
									<a class="dropdown-item" value="<?php echo $o['value'];?>"><?php echo $o['text'];?></a>
									<?php
									}
									?>
								</div>
							  </div>						
							<?php
							}
						}
						else{
							echo $value;
						}
						?>
				
			</div>
		</div>
	<?php
		}
		}
	?>
	</div>
</div>
<script>
$('.dropdown .dropdown-menu .dropdown-item').click(function(){
	$(this).parent().prev().val($(this).html());
	ajax_loading(true);
	var data = {};
	data[$(this).parent().prev().attr('id')] = $(this).attr('value');
	$.ajax({
		url: '<?php echo base_url();?>smd/sales/sales_case/<?php echo $policy['policies_id'];?>',
		method: 'post',
		data: data,
		dataType: 'json',
		success: function(data){
		},
		error: function(a, b, c){
		},
		complete:function(){
			ajax_loading(false);
		}
	});
});

/*$('.dropdown input.dropdown-toggle').click(function(){
	$(this).next().children().empty();
	for(var i =0; i < user_list.length; ++i){
		var a = $('<a>').addClass('dropdown-item').attr('value', user_list[i]['value']).html(user_list[i]['text']).appendTo($(this).next());
	}
});
*/
$('.dropdown input.dropdown-toggle').keyup(function(e){
	if($(this).prop('readonly')){
		return;
	}
	var value = $(this).val().trim();
	$(this).next().children().each(function(index, obj){
		if($(obj).html().toLowerCase().indexOf(value.toLowerCase()) >= 0){
			$(obj).show();
		}
		else{
			$(obj).hide();
		}
	});
});

$('.prop-value input, .prop-value select, .prop-value textarea').change(function(){
	ajax_loading(true);
	var data = {};
	data[$(this).attr('id')] = $(this).val();
	$.ajax({
		url: '<?php echo base_url();?>smd/sales/sales_case/<?php echo $policy['policies_id'];?>',
		method: 'post',
		data: data,
		dataType: 'json',
		success: function(data){
		},
		error: function(a, b, c){
		},
		complete:function(){
			ajax_loading(false);
		}
	});
});
</script>