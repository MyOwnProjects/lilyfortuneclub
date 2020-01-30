<style>
.nav-tabs{white-space:nowrap;overflow:ellipsis}
.nav-tabs-2>li{width:50%}
.nav-tabs-3>li:not(:last-child){width:33%}
.nav-tabs-3>li:last-child{width:34%}
.nav-tabs-5>li{width:20%}
.tab-content-page{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content img{width:100%}
.tab-content .detail-url{display:none}
.tab-content .detail-url a{color:red;text-decoration:underline}
.content-list{padding:20px 0}
@media only screen and (max-width:768px) {
.tab-content img{display:none}
.tab-content .detail-url{display:inline;}
.content-list{padding:0}
}
</style>
<div style="margin:0 auto;max-width:1000px;padding:20px 0 80px 0;">
	<h2 class="text-center">FAQ</h2>
	<ul class="nav nav-tabs nav-tabs-<?php echo count($editable_contents);?> clearfix" id="top-tab">
		<?php
		$i = 0;
		foreach($editable_contents as $c_id => $category){
		?>
		<li <?php echo $i == $active_page ? 'class="active"' : '';?>>
			<a data-toggle="tab" href="#faq-page-<?php echo $i + 1;?>"><?php echo $category['text'];?></a>
		</li>
		<?php
		++$i;
		}
		?>
	</ul>
	<div id="tab-content-pages" class="tab-content">
		<?php
		$i = 0;
		foreach($editable_contents as $c_id => $category){
		?>
		<div id="faq-page-<?php echo $i + 1;?>" class="tab-pane fade <?php echo $i == $active_page ? 'in active' : '';?> tab-content-page">
			<div style="margin:20px 0 40px 0">
				<?php
				foreach($category['sub_c'] as $sub_c_id => $sub_category){
				?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo $sub_category['text'];?>&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="btn btn-xs btn-success pull-right" style="margin-top:2px;font-size:10px" title="new question" onclick="new_question(<?php echo $sub_c_id;?>, '<?php echo  $category['text'].' / '.$sub_category['text'];?>', <?php echo $i;?>);"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;New</button>
					</div>
					<div class="panel-body">
						<div class="row">
					<?php
					$qi = 1;
					foreach($sub_category['questions'] as $q_id => $c){
					?>
						<div class="col-lg-6 col-md-6 col-sm-12 clearfix" style="padding:5px 10px">
							<div class="pull-left" style="text-align:right;margin-right:5px;width:25px;color:#337ab7"><?php echo $qi++;?>. </div> 
							<div style="overflow:hidden"><a href="?active_page=<?php echo $i;?>#<?php echo $q_id;?>"><?php echo $c['subject'];?></a></div>
						</div>
					<?php
					}
					?>
					</div>
					</div>
				</div>
				<?php
				}
				?>
			</div>
			<div>
				<?php
					foreach($category['sub_c'] as $sub_category){
						foreach($sub_category['questions'] as $q_id => $c){
				?>
				<div id="<?php echo $q_id;?>" style="margin:20px 0 10px 0">
					<b><?php echo $c['subject'];?></b>
					<?php
					if($c['editable'] == 'Y'){
					?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<button class="btn btn-xs btn-primary" style="font-size:10px;margin-top:-2px" title="edit question" onclick="edit_question(<?php echo $q_id;?>, <?php echo $i;?>);"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;&nbsp;Edit</button>
					<?php
					}
					?>
				</div>
				<div style="margin-left:10px">
					<p><?php echo str_replace("\n", "</p><p>", $c['body']);?></p>
				</div>
				<br/>
				<?php
					}
				}
				?>
			</div>
		</div>
		<?php
		++$i;
		}
		?>
	</div>
</div>
<script>
function new_question(c_id, c_text, active_page){
	if(<?php echo $user ? 'true' : 'false'?>){
		var wrapper = $('<div>');
		var form_group = $('<div>').addClass('form-group').appendTo(wrapper);
		var input = $('<select>').addClass('form-control').addClass('input-sm').addClass('category');
		$('<option>').val(c_id).attr('selected', 'selected').html(c_text).appendTo(input);
		form_group.append(input);
		form_group = $('<div>').addClass('form-group').appendTo(wrapper);
		form_group.append('<label>Question</label>');
		input = $('<input>').attr('type', 'text').addClass('form-control').addClass('input-sm').addClass('edit-subject');
		form_group.append(input);
		form_group = $('<div>').addClass('form-group').appendTo(wrapper);
		form_group.append('<label>Answer</label>');
		input = $('<textarea>').addClass('form-control').addClass('input-sm').addClass('edit-body').css('height', '150px');
		form_group.append(input);
		bootbox.dialog({
			title: "New Question",
			message: wrapper.html(),
			buttons: [
				{
					label: '<i class="fa fa-check"></i> Submit',
					className: 'btn-primary',
					callback: function(){
						ajax_loading(true);
						$.ajax({
							url: '<?php echo base_url()?>faq/new_question',
							method: 'post',
							data: {category: c_id, 
								subject: $('.bootbox-body .edit-subject').val(),
								body: $('.bootbox-body .edit-body').val() 
							},
							dataType: 'json',
							success: function(data){
								if(data['success']){
									location.href="<?php echo base_url();?>faq?active_page=" + active_page;
								}
							},
							error: function(a, b, c){
							},
							complete: function(){
								ajax_loading(false);
							}
						});
					}
				},
				{
					label: '<i class="fa fa-times"></i> Cancel',
					className: 'btn-default',
					callback: function(){
					}
				},
			]
		});
	}
}

function edit_question(q_id, active_page){
	if(<?php echo $user ? 'true' : 'false'?>){
		ajax_loading(true);
		$.ajax({
			url: '<?php echo base_url()?>faq/get_question/' + q_id,
			dataType:'json',
			success: function(data){
				var wrapper = $('<div>');
				var form_group = $('<div>').addClass('form-group').appendTo(wrapper);
				form_group.append('<label>Question</label>');
				var input = $('<input>').attr('type', 'text').addClass('form-control').addClass('input-sm').addClass('edit-subject')
					.attr('value', data['editable_contents_subject']);
				form_group.append(input);
				form_group = $('<div>').addClass('form-group').appendTo(wrapper);
				form_group.append('<label>Answer</label>');
				input = $('<textarea>').addClass('form-control').addClass('input-sm').addClass('edit-body').css('height', '150px')
					.html(data['editable_contents_body']);
				form_group.append(input);
				bootbox.dialog({
					title: "Edit Question",
					message: wrapper.html(),
					buttons: [
						{
							label: '<i class="fa fa-check"></i> Submit',
							className: 'btn-primary',
							callback: function(){
								ajax_loading(true);
								$.ajax({
									url: '<?php echo base_url()?>faq/update_question',
									method: 'post',
									data: {question: q_id, 
										subject: $('.bootbox-body .edit-subject').val(),
										body: $('.bootbox-body .edit-body').val() 
									},
									dataType: 'json',
									success: function(data){
										if(data['success']){
											location.href="<?php echo base_url();?>faq?active_page=" + active_page;
										}
									},
									error: function(a, b, c){
									},
									complete: function(){
										ajax_loading(false);
									}
								});
							}
						},
						{
							label: '<i class="fa fa-times"></i> Cancel',
							className: 'btn-default',
							callback: function(){
							}
						},
					]
				});
			},
			error: function(a, b, c){
			},
			complete: function(){
				ajax_loading(false);
			}
		});
	}
}

</script>
