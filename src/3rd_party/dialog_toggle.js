$(document).ready(function(){
	$('body').delegate('a.dialog-toggle', 'click', function(){
		var $_this = $(this);
		var id = $(this).attr('data-id');
		$.ajax({
			url: $_this.attr('dialog-url') + (id ? '/' + id : ''),
			method: 'get',
			statusCode: {
				403: function(a, b, c){
					window.location.href = a.responseText;
					return false;
				}
			},
			success: function(data){
				Dialog.modal({
					message: data,
					title: $_this.attr('dialog-header'),
					buttons: {
						primary: {
							label: "Submit",
							className: "btn-primary",
							callback: function() {
								Dialog.modal.ajaxLoad(function(){
									var data = {};
									$('.dialog-edit-field:not(div)').each(function(){
										var $_this = $(this);
										data[$_this.attr('name')] = $_this.val().trim();
									});
									$.ajax({
										url: $_this.attr('dialog-url') + (id ? '/' + id : ''),
										data: data,
										method: 'post',
										dataType: 'json',
										statusCode: {
											403: function(a, b, c){
												window.location.href = a.responseText;
												return false;
											}
										},			
										success: function(data){
											if(data['success']){
												/*if(id && id > 0){
													$_this.prev().html(data['value']);
												}
												else{//new one
													var $_list_group_item = $('<li>').addClass('list-group-item');
													$_list_group_item.append();
													var a = $('<a>').addClass('pull-right').addClass('dialog-toggle').attr('href', 'javascript:void(0)').attr('data-id', data['id']).attr('dialog-header', $_this.attr('new-dialog-header')).attr('dialog-url', $_this.attr('new-dialog-url'))
														.append('<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>');
													var span_value = $('<span>').addClass('value').append(data['value']);
													$_list_group_item.append(span_value).append(a);
													$_this.parent().parent().append($_list_group_item);
												}*/
												Dialog.hide();
												location.reload();
											}
											else{
												Dialog.modal.error(data['message']);
												return false;
											}
										},
										error: function(a, b, c){
											Dialog.modal.error(a.responseText);
											return false;
										}
									});
									return false;
								});
								return false;
							}
						},
						cancel: {
							label: "Cancel",
							className: "btn",
							callback: function() {
							}
						}
					}
				});
			},
			error: function(data){
				Dialog.modal({
					message: '<div class="alert alert-danger">' + data.responseText + '</div>',
					title: 'Error',
					buttons: {
						cancel: {
							label: "Cancel",
							className: "btn",
							callback: function() {
							}
						}
					}
				});
			}
		});
	});
 });
