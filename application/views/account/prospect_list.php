<style>
table{width:100%}
thead td{background:green;color:#fff}
table td{padding:2px 5px;padding:10px}
table td:first-child, table td:last-child{text-align:center}
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
	<div class="text-right" style="padding:0 20px 10px 0">
		<span style="color:green;cursor:pointer" class="glyphicon glyphicon-plus" title="New" onclick="new_prospect();"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo base_url();?>account/prospect/pnt" target="_blank"><span style="color:grey;cursor:pointer" class="glyphicon glyphicon-print" title="Print"></span></a>
	</div>
	<table class="prospect-table table-bordered table-striped">
		<thead>
			<tr>
				<td style="width:40px">Seq</td>
				<td style="width:150px">Name</td>
				<td style="width:120px">Phone</td>
				<td>Comment</td>
				<td style="width:50px">Action</td>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($list as $i => $l){
		?>
		<tr data-id="<?php echo $l['prospects_id'];?>">
			<td><?php echo ($i+ 1);?></td>
			<td>
				<div><input type="text" class="prospects_name form-control input-sm" value="<?php echo $l['prospects_name'];?>"></div>
			</td>
			<td>
				<div><input type="text" class="prospects_phone form-control input-sm" value="<?php echo $l['prospects_phone'];?>"></div>
			</td>
			<td>
				<div><textarea class="prospects_background input-sm"><?php echo $l['prospects_background'];?></textarea></div>
			</td>
			<td>
				<span style="cursor:pointer;" title="Save" class="prospect-save prospect-save-disabled glyphicon glyphicon-floppy-disk"></span>&nbsp;<span style="cursor:pointer;color:red;" title="Delete" class="prospect-delete glyphicon glyphicon-remove"></span>
			</td>
		</tr>
		
		<?php
		}
		?>
		</tbody>
	</table>
	<br/>
	<div class="text-right" style="padding:0 20px 10px 0">
		<span style="color:green;cursor:pointer" class="glyphicon glyphicon-plus" title="New" onclick="new_prospect();"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<span style="color:grey;cursor:pointer" class="glyphicon glyphicon-print" title="Print"></span>
	</div>
	
	<div>
		<h4>* Qualification of the prospects</h4>
		<ul>
			<li>25+ years old
			<li>Married</li>
			<li>Dependent children</li>
			<li>Homeowner</li>
			<li>Solid business/career background</li>
			<li>$40,000+ household income</li>
			<li>Dissatisfied with his/her current situation</li>
			<li>Entrepreneurial</li>
		</ul>
	</div>
<script>
$('.prospect-table').delegate('.prospect-delete', 'click', function(){
	var $obj = $(this);
	bootbox.confirm({
		title: "Confirmation",
		message: "Do you want to delete this prospect?",
		buttons: {
			cancel: {
				label: 'No',
				className: 'btn'
			},
			confirm: {
				label: 'Yes',
				className: 'btn-danger'
			}
		},
		callback: function (result) {
			if(result){
				var id = $obj.parent().parent().attr('data-id');
				if(id){
					ajax_loading(true);
					$.ajax({
						url: '<?php echo base_url();?>account/prospect/delete',
						method: 'post',
						data: {id: id},
						dataType: 'json',
						success:function(data){
							ajax_loading(false);
							if(data['success']){
								$obj.parent().parent().remove();
								var $tbody = $('.prospect-table tbody');
								$tbody.children('tr').each(function(index, obj){
									$(obj).children('td:first-child').html(index + 1);
								});
							}
							else{
								bootbox.confirm({
									title: "Error!",
									message: '<span style="color:red" class="glyphicon glyphicon-remove-sign"></span>Failed to delete this prospect!',
									buttons: {
										cancel: {
											label: 'Close',
											className: 'btn-primary'
										}
									},
									callback: function (result) {
									}
								});
							}
						},
						error: function(){
								ajax_loading(false);
								bootbox.confirm({
									title: "Error!",
									message: '<span style="font-size:16px;color:red" class="glyphicon glyphicon-remove-sign"></span>&nbsp;Failed to delete this prospect!',
									buttons: {
										cancel: {
											label: 'Close',
											className: 'btn-primary'
										}
									},
									callback: function (result) {
									}
								});
						},
						complete: function(){
							ajax_loading(false);
						}
					});
				}
				else{
					$obj.parent().parent().remove();
					var $tbody = $('.prospect-table tbody');
					$tbody.children('tr').each(function(index, obj){
						$(obj).children('td:first-child').html(index + 1);
					});
				}
			}
		}
	});
}).delegate('.prospect-save', 'click', function(){
	if($(this).hasClass('prospect-save-disabled')){
		return false;
	}
	var $obj = $(this);
	var id = $obj.parent().parent().attr('data-id');
	if(id){
		ajax_loading(true);
		$.ajax({
			url: '<?php echo base_url();?>account/prospect/update',
			method: 'post',
			data: {id: id, name: $obj.parent().parent().find('.prospects_name').val(), 
				phone: $obj.parent().parent().find('.prospects_phone').val(), 
				background: $obj.parent().parent().find('.prospects_background').val()},
			dataType: 'json',
			success:function(data){
				ajax_loading(false);
				if(!data['success']){
					bootbox.confirm({
						title: "Error!",
						message: '<span style="color:red" class="glyphicon glyphicon-remove-sign"></span>Failed to save this prospect!',
						buttons: {
							cancel: {
								label: 'Close',
								className: 'btn-primary'
							}
						},
						callback: function (result) {
						}
					});
				}
				else{
					$obj.parent().parent().parent().find('.prospect-save').addClass('prospect-save-disabled');
				}
			},
			error: function(){
				ajax_loading(false);
				bootbox.confirm({
					title: "Error!",
					message: '<span style="font-size:16px;color:red" class="glyphicon glyphicon-remove-sign"></span>&nbsp;Failed to save this prospect!',
					buttons: {
						cancel: {
							label: 'Close',
							className: 'btn-primary'
						}
					},
					callback: function (result) {
					}
				});
			},
			complete: function(){
				ajax_loading(false);
			}
		});
	}	
	else{
		ajax_loading(true);
		$.ajax({
			url: '<?php echo base_url();?>account/prospect/add',
			method: 'post',
			data: {name: $obj.parent().parent().find('.prospects_name').val(), 
				phone: $obj.parent().parent().find('.prospects_phone').val(), 
				background: $obj.parent().parent().find('.prospects_background').val()},
			dataType: 'json',
			success:function(data){
				ajax_loading(false);
				if(data['success']){
					$obj.parent().parent().attr('data-id') = data['id'];
					$obj.parent().parent().parent().find('.prospect-save').addClass('prospect-save-disabled');
				}
				else{
					bootbox.confirm({
						title: "Error!",
						message: '<span style="color:red" class="glyphicon glyphicon-remove-sign"></span>Failed to save this prospect!',
						buttons: {
							cancel: {
								label: 'Close',
								className: 'btn-primary'
							}
						},
						callback: function (result) {
						}
					});
				}
			},
			error: function(){
				ajax_loading(false);
				bootbox.confirm({
					title: "Error!",
					message: '<span style="font-size:16px;color:red" class="glyphicon glyphicon-remove-sign"></span>&nbsp;Failed to save this prospect!',
					buttons: {
						cancel: {
							label: 'Close',
							className: 'btn-primary'
						}
					},
					callback: function (result) {
					}
				});
			},
			complete: function(){
				ajax_loading(false);
			}
		});
	}
}).delegate('.prospects_name, .prospects_phone, .prospects_background', 'change', function(){
	$(this).parent().parent().parent().find('.prospect-save').removeClass('prospect-save-disabled');
});

function new_prospect(){
	var $tbody = $('.prospect-table tbody');
	var $tr = $('<tr>').appendTo($tbody);
	var $td = $('<td>').html($tbody.children().length).appendTo($tr);
	$td = $('<td>').html('<div><input type="text" class="prospects_name form-control input-sm"></div>').appendTo($tr);
	$td = $('<td>').html('<div><input type="text" class="prospects_phone form-control input-sm"></div>').appendTo($tr);
	$td = $('<td>').html('<div><textarea class="prospects_background input-sm"></textarea></div>').appendTo($tr);
	$td = $('<td>').html('<span style="cursor:pointer" title="Save" class="prospect-save prospect-save-disabled glyphicon glyphicon-floppy-disk"></span>&nbsp;<span style="cursor:pointer;color:red;" title="Delete" class="prospect-delete glyphicon glyphicon-remove"></span>').appendTo($tr);
}
</script>