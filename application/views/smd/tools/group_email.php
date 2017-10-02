<style>
	.checkbox{padding:2px 10px}
</style>
<div style="margin:40px">
	<div class="row">
		<div class="form-group col-xs-12">
			<div class="alert" style="display:none"></div>
			<br/>
			<button class="btn btn-sm btn-primary" onclick="send_email();">Send</button>
		</div>
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label>From</label>
				<input class="form-control input-sm" id="email-from" value="Lily Office Manager <lily.officemanager@gmail.com>">
			</div>
			<div class="form-group">
				<label>To:</label>
				<span id="selected-count">0</span> users
				<div class="checkbox" style="border-bottom:1px solid #f5f5f5">
					<label><input type="checkbox" name="selected_user_all" value="all">
						Select All (Total <?php echo count($users);?>)
					</label>					
				</div>
				<div class="checkbox row" style="max-height:500px;overflow-y:auto">
					<?php 
					foreach($users as $u){
					?>
							<div class="col-lg-6 col-md-6 col-sm-6 col-sx-12">
							<label><input type="checkbox" class="checkbox-selected-users" value="<?php echo $u['users_id'];?>">
								<?php echo $u['name'].' - '.$u['membership_code'];?>
							</label>					
							</div>
					<?php
					}
					?>
						</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label>Template</label>
				<select class="form-control input-sm" id="email-template">
					<option value="new">New</option>	
				<?php
				foreach($templates as $k => $v){
				?>
					<option value="<?php echo $k;?>"><?php echo str_replace('_', ' ', $k);?></option>	
				<?php
				}
				?>
				</select>
				<br/>
				<label>Subject</label>
				<input class="form-control input-sm" id="email-subject" placeholder="Email Subject" style="background-color:#fff !important">
				<label>Body</label>
				<textarea class="form-control input-sm" id="email-body-text" style="height:500px"></textarea>
				<div style="display:none;padding:10px;overflow-x:auto;min-height:100px;border:1px solid #e5e5e5" id="email-body-html"></div>
			</div>
		</div>
	</div>
</div>	
<script>
function send_email(){
	$('.alert').removeClass('alert-danger').removeClass('alert-success').empty().hide();
	var to = [];
	if($('[name=selected_user_all]').prop('checked')){
		to = 'all';
	}
	else{
		$('.checkbox-selected-users').each(function(index, obj){
			if($(obj).prop('checked')){
				to.push($(obj).val())
			}
		}); 
		if(to.length == 0){
			$('.alert').addClass('alert-danger').html('To cannot be empty.').show();		
			return false;
		}
	}
	var from = $('#email-from').val().trim();
	if(from.length == 0){
		$('.alert').addClass('alert-danger').html('From cannot be empty.').show();		
		return false;
	}
	ajax_loading(true);
	$.ajax({
		url:'<?php echo base_url();?>smd/tools/group_email',
		method: 'post',
		data: {
			from: from,
			to: to,
			template: $('#email-template').val(),
			subject: $('#email-template').val == 'new' ? $('#email-subject').val() : '',
			body: $('#email-template').val == 'new' ? $('#email-body-text').nal() : ''
		},
		dataType: 'json',
		success: function(data){
			if(data['success']){
				$('.alert').addClass('alert-success').html('Email has been sent.').show();
			}
			else{
				$('.alert').addClass('alert-danger').html(data['message']).show();
			}
		},
		error: function(a, b, c){
			$('.alert').addClass('alert-danger').html(a.responseText).show();
		},
		complete: function(){
			ajax_loading(false);
		}
		
	});
}

$('#email-template').change(function(){
	var t = $(this).val();
	if(t == 'new'){
		$('#email-subject').val('');
		$('#email-body-text').show();
		$('#email-body-html').hide();
	}
	else{
		$('#email-body-html').show();
		$('#email-body-text').hide();
		ajax_loading(true);
		$.ajax({
			url: '<?php echo base_url()?>smd/tools/get_email_template',
			data: {template: t},
			dataType: 'json',
			success: function(data){
				$('#email-subject').val(data['subject']);
				$('#email-body-html').html(data['body']);
			},
			error: function(){
			},
			complete: function(){
				ajax_loading(false);
			}
		});
	}
});

$('[name=selected_user_all]').click(function(){
	$('.checkbox-selected-users').prop('checked', $(this).prop('checked'));
	$('#selected-count').html($(this).prop('checked') ? $('.checkbox-selected-users').length : 0);
});

$('.checkbox-selected-users').click(function(){
	var select_count = 0;
	$('.checkbox-selected-users').each(function(index, obj){
		if($(obj).prop('checked')){
			select_count++;
		}
	});
	$('[name=selected_user_all]').prop('checked', select_count == $('.checkbox-selected-users').length);
	$('#selected-count').html(select_count);
});
</script>
