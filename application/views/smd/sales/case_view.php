<style>
.row-bg{border-bottom:1px solid #f5f5f5;padding:10px 0}
.prop-row{margin:5px 0}
.prop-label{text-transform:capitalize;width:160px;margin-right:10px;text-align:right;line-height:30px;font-weight:bold}
.prop-value input, .prop-value select, .prop-value textarea{outline:none;cursor:pointer;border:1px solid <?php echo empty($policies_id) ? '#ced4da' : '#fff';?>;box-sizing:border-box;width:100%;line-height:initial !important}
.prop-value input:hover, .prop-value select:hover, .prop-value textarea:hover{border:1px solid #ced4da;outline:none}
.prop-value input:focus, .prop-value select:focus, .prop-value textarea:focus{outline:none;}
.prop-value textarea{height:200px !important;}
.bootstrap-select .btn{padding:0;border:none}
.prop-value input.value-error, .prop-value select.value-error, .prop-value textarea.value-error{border:1px solid #ff0000}

.bootstrap-select .btn-group.open .dropdown-toggle{webkit-box-shadow:none;box-shadow:none}
.bootstrap-select .btn-default:active, .bootstrap-select .btn-default:focus, .bootstrap-select .btn-default:hover, .bootstrap-select .open>.dropdown-toggle.btn-default {background-color:#fff !important;border-color:#fff !important}
</style>

<div style="margin:40px"> 
	<h4><?php echo empty($policies_id) ? 'New Case' : 'Policy Case';?></h4>
	<?php
	if(empty($policies_id)){
	?>
	<form method="post">
		<div class="row row-bg">
			<div class="col-sm-12 text-right">
				<input class="btn btn-primary btn-sm" type="submit" value="Submit">
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn btn-danger btn-sm" href="<?php echo base_url();?>smd/sales">Cancel</a>
			</div>
		</div>
	<?php
	}
	?>
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
			if($id != 'policies_notes'){
				$col = 'col-md-6 col-sm-12';
			}
			else{
				$col = 'col-sm-12';
			}
	?>
		<div class="<?php echo $col;?> d-flex prop-row">
			<div class="prop-label"><?php echo $prop['label'];?>:</div>
			<div class="prop-value flex-fill">
						<?php
						if(array_key_exists('tag', $prop)){
							if($prop['tag'] == 'input'){
							?>
							<input class="form-control form-control-sm" id="<?php echo $id;?>" name="<?php echo $id;?>" value="<?php echo $prop['value'];?>" type="<?php echo array_key_exists('type', $prop) ? $prop['type'] : 'text';?>">
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
								<input type="hidden" name="<?php echo $id;?>" id="<?php echo $id;?>" value="<?php echo $prop['value'];?>">
								<?php
								$display_value = $prop['value'];
								foreach($prop['options'] as $o){
									if($prop['value'] == $o['value']){
										$display_value = $o['text'];
										break;
									}
								}
								?>
								
								<input type="text" class="dropdown-toggle form-control form-control-sm" data-toggle="dropdown" value="<?php echo $display_value;?>" <?php echo array_key_exists('readonly', $prop) ? 'readonly' : ''; ?> style="background:#fff">
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
	<?php
	if(empty($policies_id)){
	?>
	</form>
	<?php
	}
	?>
	
</div>
<script>
$(document).ready(function(){
	if(<?php echo empty($policies_id) ? 'true' : 'false';?>){
		$('#policies_number').change(function(){
			var $_input = $(this);
			$.ajax({
				url: '<?php echo base_url();?>smd/sales/number_existing',
				method: 'post',
				dataType: 'json',
				data: {policies_number: $(this).val().trim()},
				success: function(data){
					if(data['exist']){
						$_input.addClass('value-error');
					}
					else{
						$_input.removeClass('value-error');
					}
				},
				error: function(a, b, c){
				}

			});
		});
	}
});

$('.dropdown .dropdown-menu .dropdown-item').click(function(){
	$(this).parent().prev().val($(this).html());
	$(this).parent().prev().prev().val($(this).attr('value'));
	if(<?php echo empty($policies_id) ? 'false' : 'true';?>){
		ajax_loading(true);
		var data = {};
		data[$(this).parent().prev().prev().attr('id')] = $(this).attr('value');
		$.ajax({
			url: '<?php echo base_url();?>smd/sales/sales_case/<?php echo $policies_id;?>',
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
	}
});


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
	$(this).prev().val($(this).val());
	if(<?php echo empty($policies_id) ? 'false' : 'true';?>){
		ajax_loading(true);
		var data = {};
		var id = $(this).prop('id') ? $(this).attr('id') : $(this).prev().attr('id');
		data[id] = $(this).val();
		$.ajax({
			url: '<?php echo base_url();?>smd/sales/sales_case/<?php echo $policies_id;?>',
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
	}
});
</script>