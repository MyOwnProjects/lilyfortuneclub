<style>
.doc-view-wrapper{margin:40px 0}
.doc-view-left{overflow:hidden;min-width:200px;margin:0 40px;}
.doc-view-right{width:400px;margin:40px}
.doc-view-right1{display:none}
.document-content{padding:40px 0;line-height:25px;}
.document-content .content-image{text-align:center;margin:40px auto} 
.document-content img{width:100%;max-width:600px}
@media only screen and (max-width:900px) {
.doc-view-wrapper{margin:40px 0;display:table}
.video-text{margin:20px;}
.document-subject{text-align:left;font-weight:normal}
.doc-view-left{margin:0;width:100%;min-width:0;}
.doc-view-right{display:none}
.doc-view-right1{display:block;margin:20px}
}
</style>
<div style="margin:20px">
	<div id="calendar"></div>
</div>
<script>
$(function() {
	var $_calendar = $('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		navLinks: true, // can click day/week names to navigate views
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		eventRender: function (event, element) {
			element.find('.fc-title').html(event.title);
		},
		
		eventClick: function(event, element) {
			var url = '<?php echo base_url();?>smd/schedule/update_schedule/' + event.id;
			$.ajax({
				url: url,
				success: function(data){
					Dialog.modal({
						message: data,
						title: 'Schedule',
						loaded: function(){},
						buttons: {
							primary: {
								label: 'Submit',
								className: "btn-primary",
								callback: function() {
									Dialog.modal.ajaxLoad(function(){
										var param_data = {};
										//if(param && param['selected_ids']){
										//	param_data['selected_ids'] = param['selected_ids'];
										//}
										$('.dialog-edit-field:not(div)').each(function(index, field){
											var obj = $(this);
											var id = obj.attr('id');
											param_data[id] = obj.val().trim();
										});
										$.ajax({
											url: url,
											method: 'post',
											data: param_data,
											dataType: 'json',
											success: function(data){
												if(data['success']){
													Dialog.hide();
													event.title = '';
													$('#calendar').fullCalendar('updateEvent', event);
												}
												else{
													if(data['fields']){
														Dialog.modal.fielderror(data['fields']);
													}
													if(data['message']){
														Dialog.modal.error(data['message']);
													}
													return false;
												}
											},
											error: function(a, b, c){
												Dialog.modal.error(a.responseText);
												return false;
											},
											complete: function(){
											}
										});
									return false;
									});
									return false;
								}
							},
							cancel: {
								label: 'Cancel',
								className: "btn"
							}
						},
						onEscape: function () {
							Dialog.modal('hide');
						}
					});
					//if(param && param['source']){
					//	var source = param['source'];
					//	for(var id in source){
					//		$('.bootbox #' + id).val(source[id]);
					//	}
					//}
				},
				error: function(a, b, c){
					Dialog.error(a.responseText);
				}
			});
		},
		dayClick: function(date, jsEvent, view) {
			date._d.setDate(date._d.getDate() + 1);
			var url = '<?php echo base_url();?>smd/schedule/add_schedule?date=' 
				+ date._d.getFullYear() + '-' + String(date._d.getMonth() + 1).padStart(2, '0') + '-' + String(date._d.getDate()).padStart(2, '0');
			$.ajax({
				url: url,
				success: function(data){
					Dialog.modal({
						message: data,
						title: 'New Schedules',
						loaded: function(){},
						buttons: {
							primary: {
								label: 'Submit',
								className: "btn-primary",
								callback: function() {
									Dialog.modal.ajaxLoad(function(){
										var param_data = {};
										//if(param && param['selected_ids']){
										//	param_data['selected_ids'] = param['selected_ids'];
										//}
										$('.dialog-edit-field:not(div)').each(function(index, field){
											var obj = $(this);
											var id = obj.attr('id');
											param_data[id] = obj.val().trim();
										});
										$.ajax({
											url: url,
											method: 'post',
											data: param_data,
											dataType: 'json',
											success: function(data){
												if(data['success']){
													Dialog.hide();
													$_calendar.fullCalendar('renderEvent', data['data']);
												}
												else{
													if(data['fields']){
														Dialog.modal.fielderror(data['fields']);
													}
													if(data['message']){
														Dialog.modal.error(data['message']);
													}
													return false;
												}
											},
											error: function(a, b, c){
												Dialog.modal.error(a.responseText);
												return false;
											},
											complete: function(){
											}
										});
									return false;
									});
									return false;
								}
							},
							cancel: {
								label: 'Cancel',
								className: "btn"
							}
						},
						onEscape: function () {
							Dialog.modal('hide');
						}
					});
					//if(param && param['source']){
					//	var source = param['source'];
					//	for(var id in source){
					//		$('.bootbox #' + id).val(source[id]);
					//	}
					//}
				},
				error: function(a, b, c){
					Dialog.error(a.responseText);
				}
			});		
		},
    });

	ajax_loading(true);
	$.ajax({
		url: '<?php echo base_url();?>schedule/get_events',
		dataType: 'json',
		success: function(data){
			$_calendar.fullCalendar('renderEvents',data);
		},
		error: function(a, b, c){
		},
		complete: function(){
			ajax_loading(false);
		}
	});

});
</script>	
