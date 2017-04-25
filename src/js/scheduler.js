var event_time_str_list = [];
for(var i = 0; i < 24; ++i){
	event_time_str_list.push({value: String(i).padStart(2, '0') + ':00', text: timeStr(i, 0).padStart(8, '0')});
	event_time_str_list.push({value: String(i).padStart(2, '0') + ':30', text: timeStr(i, 30).padStart(8, '0')});
}

function init_est_time_list(select, add, value){
	var est = $(select);
	for(var i = 0; i < event_time_str_list.length; ++i){
			$('<option>').val(event_time_str_list[i]['value']).prop('selected', event_time_str_list[i]['value'] == value).html(event_time_str_list[i]['text']).appendTo(est);
		//else
		//	$('<option>').val(event_time_str_list[i]['value']).html(event_time_str_list[i]['text']).appendTo(est);
	}
	if(add)
		$('<option>').val('00:00').prop('selected', '00:00' == value).html('12:00 am').appendTo(est);
}

function update_event_time_values(sevent_tart_time_obj){
	var est = $(sevent_tart_time_obj);
	var eet = $(est).siblings('[name=event-end-time]');
	for(var i = 0; i < event_time_str_list.length; ++i){//
		if(i <= sevent_tart_time_obj.selectedIndex){
			eet.children('option:nth-child(' + (i + 1) + ')').prop('disabled', true);
		}
		else{
			eet.children('option:nth-child(' + (i + 1) + ')').prop('disabled', false);
		}
	}
	if(sevent_tart_time_obj.selectedIndex >= eet.get(0).selectedIndex ){
		eet.get(0).selectedIndex = sevent_tart_time_obj.selectedIndex + 1;
	}
}

function update_event_date_values(){
	$.each($('#event_time_group').children('.form-group'), function(index, object){
		if(index > 0){
			var last_date = $(object).prev().children('[name=event-date]').val().split('-');
			last_date = new Date(parseInt(last_date[0]), parseInt(last_date[1]) - 1, parseInt(last_date[2]) + 1);
			$(object).children('[name=event-date]').val(
					last_date.getFullYear() + '-' + 
					String(last_date.getMonth() + 1).padStart(2, '0') + '-' + 
					String(last_date.getDate()).padStart(2, '0'));
		}
	});
					
}
function update_event_time_groups(event_times){
	var days = $('#event_days').val();
	var old_days = $('#event_days').attr('before-change-value');
	var days_diff = days - old_days;
	if(days_diff == 0)
		return;
	var $_event_time_group = $('#event_time_group');
	if(days_diff > 0){
		while($_event_time_group.children('.form-group').length < days){
			var form_group = $('<div>').addClass('form-group').appendTo($_event_time_group);
			$('<label>').attr('for', 'event_date_').html('Event Date').appendTo(form_group);
			form_group.append('&nbsp;');
			var $_event_date = $('<input>').addClass('form-control').attr('name', 'event-date').css('display', 'inline').css('width', '150px').appendTo(form_group);
			if(old_days == 0)
				$_event_date.change(function(){
					update_event_date_values();
				});
			form_group.append('&nbsp;&nbsp;');
			$('<label>').attr('for', 'event_start_time_').html('From').appendTo(form_group);
			form_group.append('&nbsp;');
			var s1 = $('<select>').addClass('form-control').attr('name', 'event-start-time').css('display', 'inline').css('width', 'auto').appendTo(form_group);
			var time='06:00';
			if(event_times && event_times[$_event_time_group.children().length - 1]
				&& event_times[$_event_time_group.children().length - 1][0]){
				time = event_times[$_event_time_group.children().length - 1][0].split(' ')[1].substr(0, 5);
			}
			init_est_time_list(s1.get(0), false, time);
			form_group.append('&nbsp;');
			$('<label>').attr('for', 'event_end_time_').html('to').appendTo(form_group);
			form_group.append('&nbsp;');
			var s2 = $('<select>').addClass('form-control').attr('name', 'event-end-time').css('display', 'inline').css('width', 'auto').appendTo(form_group);
			if(event_times && event_times[$_event_time_group.children().length - 1]
				&& event_times[$_event_time_group.children().length - 1][1]){
				time = event_times[$_event_time_group.children().length - 1][1].split(' ')[1].substr(0, 5);
			}
			init_est_time_list(s2.get(0), true, time);
			update_event_time_values(s1.get(0));
			if($_event_time_group.children().length > 1){
				var last_date = form_group.prev().children('[name=event-date]').val().split('-');
				last_date = new Date(parseInt(last_date[0]), parseInt(last_date[1]) - 1, parseInt(last_date[2]) + 1);
				$_event_date.prop('disabled', true).val(
					last_date.getFullYear() + '-' + 
					String(last_date.getMonth() + 1).padStart(2, '0') + '-' + 
					String(last_date.getDate()).padStart(2, '0'));
			}
		}
		if(event_times){
			$_event_time_group.children('.form-group').first().children('[name=event-date]').datepicker().
				datepicker("option", "dateFormat", "yy-mm-dd").val(event_times[0][0].split(' ')[0]);
			update_event_date_values();
		}
	}
	else{
		while($_event_time_group.children('.form-group').length > days){
			$_event_time_group.children('.form-group').last().remove();
		}
	}
	$('#event_days').attr('before-change-value', days);
	$('#event_time_group [name=event-start-time]').change(function(){
		update_event_time_values(this);
	});
}

var pEvents = [
				/*{subject: 'Test', time: [
					[new Date(2016,6,29,11,0,0), new Date(2016,6,29,17,0,0)], 
					[new Date(2016,6,30,11,0,0), new Date(2016,6,30,17,0,0)],
					[new Date(2016,6,31,11,0,0), new Date(2016,6,31,17,0,0)],
					[new Date(2016,7,1,11,0,0), new Date(2016,7,1,17,0,0)],
					[new Date(2016,7,2,11,0,0), new Date(2016,7,2,15,0,0)],
					[new Date(2016,7,3,11,0,0), new Date(2016,7,3,17,0,0)],
					[new Date(2016,7,4,11,0,0), new Date(2016,7,4,17,0,0)],
					[new Date(2016,7,5,11,0,0), new Date(2016,7,5,17,0,0)],
					[new Date(2016,7,6,11,0,0), new Date(2016,7,6,17,0,0)],
					[new Date(2016,7,7,11,0,0), new Date(2016,7,7,17,0,0)],
				]},*/
				{id:1, subject: 'Test1', time: [
					[new Date(2016,7,3,10,30,0), new Date(2016,7,3,12,0,0)],
					[new Date(2016,7,4,10,0,0), new Date(2016,7,4,15,30,0)],
					[new Date(2016,7,5,11,0,0), new Date(2016,7,5,12,0,0)],
					[new Date(2016,7,6,10,0,0), new Date(2016,7,6,15,0,0)],
				]},
				{id:2, subject: 'Test2', time: [
					[new Date(2016,7,3,11,0,0), new Date(2016,7,3,14,0,0)],
				]},
			
			
];

(function($){
	var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		var days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
		var colors = ['red','yellow', 'orange','green', 'blue', 'pink', 'purple', 'grey', 'olive', 'brown', 'gold'];
		$.fn.scheduler = function(url){
		var _this = this;
		var $_this = $(this);
		var _year, _month, _date;
		var _mode;//M,W,d,Y
		var _processing_box;
		var _event_modal_operation_type = 0;//0:add, 1:update
		var _url = url;
		var $_header = $('<div>').addClass('scheduler-header').appendTo($_this);
		var $_event_modal; //= create_event_modal();
		var $_title = $('<div>').addClass('sheduler-title').appendTo($_header);
		var $_operation_bar = $('<div>').css('float', 'left').css('margin-right', '20px').appendTo($_header);
		var $_add_event_button = $('<button>').css('margin-right', '5px').html('<span class="glyphicon glyphicon-plus"></span>&nbsp;Add').appendTo($_operation_bar);
		var $_refresh_button = $('<button>').css('margin-right', '5px').attr('data-toggle', 'modal').html('<span class="glyphicon glyphicon-refresh"></span>&nbsp;Refresh').appendTo($_operation_bar);
		var $_calendar_type_bar = $('<div>').css('float', 'right').appendTo($_header);
		var $_today_button = $('<button>').addClass('btn').addClass('btn-primary').addClass('btn-sm').css('float', 'right').css('margin-right', '20px').html('Today').appendTo($_header);
		var $_calendar_prev_next_bar = $('<div>').css('float', 'right').css('margin-right', '20px').appendTo($_header);
		
		//var $_calendar_prev_next_group = $('<div>').addClass('btn-group').attr('data-toggle', 'buttons').appendTo($_calendar_prev_next_bar);
		var $_calendar_prev_button = $('<button>').addClass('circle').css('margin-right', '5px').addClass('btn-primary').html('<span class="glyphicon glyphicon-chevron-left"></span>').appendTo($_calendar_prev_next_bar);
		var $_calendar_next_button = $('<button>').addClass('circle').addClass('btn-primary').html('<span class="glyphicon glyphicon-chevron-right"></span>').appendTo($_calendar_prev_next_bar);
		var $_calendar_type_button_group = $('<div>').addClass('btn-group').attr('data-toggle', 'buttons').appendTo($_calendar_type_bar);
		var $_radio = $('<input>').attr('type', 'radio').prop('checked', true);
		var $_day_type_button = $('<label>').addClass('btn').addClass('btn-primary').addClass('btn-sm').append($_radio).append('Day' ).appendTo($_calendar_type_button_group);
		var $_radio = $('<input>').attr('type', 'radio');
		var $_week_type_button = $('<label>').addClass('btn').addClass('btn-primary').addClass('btn-sm').append($_radio).append('Week').appendTo($_calendar_type_button_group);
		var $_radio = $('<input>').attr('type', 'radio');
		var $_month_type_button = $('<label>').addClass('btn').addClass('btn-primary').addClass('btn-sm').addClass('active').append($_radio).append('Month').appendTo($_calendar_type_button_group);
		
		var $_calendar = $('<div>').addClass('scheduler-body').appendTo($_this);
		var $_main_table = $('<table>').attr('cellspacing', '0').attr('cellpadding', '0').css('table-layout', 'fixed').appendTo($_calendar);
		var $_table_head = $('<thead>').appendTo($_main_table);
		var $_table_body = $('<tbody>').appendTo($_main_table);
		var calendar_grids = [];
		var calendar_date_list = [];
		var initial_hour = 6;
		
		var ajax_get_events = function(){
			if(_mode == 'W'){
				var day = new Date(_year, _month, _date).getDay();				
				var first_date = new Date(_year, _month, _date - day);
				var last_date = new Date(_year, _month, _date + (6 - day));
			}
			else{
				var first_date = new Date(_year, _month, 1);
				var last_date = new Date(_year, _month + 1, 0);
			}
			_processing_box = bootbox.dialog({
				closeButton: false,
				message: '<div style="text-align:center">Loading......</div>'
			});
			$.ajax({
				url: _url + '/get_events?start=' + first_date.getFullYear() + '-' + String(first_date.getMonth() + 1).padStart(2, '0') + '-' + String(first_date.getDate()).padStart(2, '0') 
					+ '&end=' + last_date.getFullYear() + '-' + String(last_date.getMonth() + 1).padStart(2, '0') + '-' + String(last_date.getDate()).padStart(2, '0'),
				dataType: 'json',
				success: function(data){
					if(data){
						var index = 0;
						for(var id in data){
							var event = data[id];							
							event['id'] = id;
							for(var j = 0; j < event['time'].length; ++j){
								var ta = event['time'][j][0].split(' ');
								var date_a = ta[0].split('-');
								var time_a = ta[1].split(':');
								event['time'][j][0] = new Date(parseInt(date_a[0]), parseInt(date_a[1]) - 1 , parseInt(date_a[2]), parseInt(time_a[0]), parseInt(time_a[1]), parseInt(time_a[2]));
								var ta = event['time'][j][1].split(' ');
								var date_a = ta[0].split('-');
								var time_a = ta[1].split(':');
								event['time'][j][1] = new Date(parseInt(date_a[0]), parseInt(date_a[1]) - 1 , parseInt(date_a[2]), parseInt(time_a[0]), parseInt(time_a[1]), parseInt(time_a[2]));
							}
							add_event(event, colors[index % colors.length]);
							index++;
						}
					}
				},
				error: function(a, b, c){
					
				},
				complete: function(){
					_processing_box.modal('hide');				
				}
			});
		};
		
		var ajax_update_event = function(event_id){
			var subject = $_event_modal.find('#event_subject').val().trim();
			var detail = $_event_modal.find('#event_detail').val().trim();
			var time = [];
			$.each($_event_modal.find('[name=event-date]'), function(index, object){
				time[index] = [$(object).val()];
			});
			$.each($_event_modal.find('[name=event-start-time]'), function(index, object){
				time[index].push($(object).val());
			});
			$.each($_event_modal.find('[name=event-end-time]'), function(index, object){
				time[index].push($(object).val());
			});
			_processing_box = bootbox.dialog({
				closeButton: false,
				message: '<div style="text-align:center">Loading......</div>'
			});
			$.ajax({
				url: _url + '/update_event',
				method: 'post',
				data: {
					id: event_id,
					subject: subject,
					detail: detail,
					time: time
				},
				dataType: 'json',
				success: function(data){
					_processing_box.modal('hide');
					if(data['success'] === true){
						refresh_events();			
					}
				},
				error: function(a, b, c){
					_processing_box.modal('hide');
				},
			});
			return false;
		};
		
		var ajax_delete_event = function(event_id){
			_processing_box = bootbox.dialog({
				closeButton: false,
				message: '<div style="text-align:center">Loading......</div>'
			});			
			$.ajax({
				url: _url + '/delete_event?id=' + event_id,
				dataType: 'json',
				success: function(data){
					if(data['success'] === true){
						_processing_box.modal('hide');				
						refresh_events();			
					}
				},
				error: function(a, b, c){
					_processing_box.modal('hide');				
				},
			});
			return false;
		};
		
		var add_event = function(event, color){
			var color_class = 'scheduler-event-block-' + color;
			switch (_mode){
				case 'D':
				break;
			case 'W':
				var first_event_index = -1;
				var first_calendar_column_index = -1;
				for(var i = 0; i < event['time'].length; ++i){
					for(var j = 0; j < 7; ++j){
						if(calendar_date_list[j] === event['time'][i][0].getFullYear() + '-' + event['time'][i][0].getMonth() + '-' + event['time'][i][0].getDate()){
							first_event_index = i;
							first_calendar_column_index = j;
							break;
						}
					}
					if(first_event_index >= 0 && first_calendar_column_index >= 0){
						break;
					}
				}
				if(first_event_index >= 0 && first_calendar_column_index >= 0){
					var last_event_index = Math.min(event['time'].length - 1, first_event_index + (6 - first_calendar_column_index % 7));
					for(var i = first_event_index; i <= last_event_index; ++i){
						var first_row_index = (event['time'][i][0].getHours() * 2 + event['time'][i][0].getMinutes() / 30 - initial_hour * 2 + 48) % 48;
						var half_hours = (event['time'][i][1] - event['time'][i][0]) / 1000 / 60 / 30;
						//var hours = Math.floor(minutes / 60);
						for(var j = 0; j < half_hours; ++j){
							var text = '&nbsp;';
							var add_class = 'scheduler-event-block';
							if(j === 0){
								text = event['subject'] + ':&nbsp;' + 
									timeStr(event['time'][i][0].getHours(), event['time'][i][0].getMinutes()) + '&nbsp;-&nbsp;' + 
									timeStr(event['time'][i][1].getHours(), event['time'][i][1].getMinutes());
								add_class += '-top';
							}
							add_class += '-right';
							if(j === half_hours - 1)
								add_class += '-bottom';
							add_class += '-left';
							var cell_index = (j + first_row_index)* 7 + first_calendar_column_index;
							var $_event_block = $('<div>').attr('event-id', event['id']).addClass(add_class).addClass('scheduler-event-block').addClass(color_class).html(text);
							$(calendar_grids[cell_index]).append($_event_block);
						}
						first_calendar_column_index++;
					}
				}
				break;
			
			default:
				var first_event_index = -1;
				var first_calendar_index = -1;
				for(var i = 0; i < event['time'].length; ++i){
					for(var j = 0; j < calendar_grids.length; ++j){
						if(calendar_date_list[j] === event['time'][i][0].getFullYear() + '-' + event['time'][i][0].getMonth() + '-' + event['time'][i][0].getDate()){
							first_event_index = i;
							first_calendar_index = j;
							break;
						}
					}
					if(first_event_index >= 0 && first_calendar_index >= 0){
						break;
					}
				}
				if(first_event_index >= 0 && first_calendar_index >= 0){
					for(var i = first_event_index; i < event['time'].length; ++i){
						var text = event['subject'] + ':&nbsp;' + timeStr(event['time'][i][0].getHours(), event['time'][i][0].getMinutes()) + '&nbsp;-&nbsp;' + 
							timeStr(event['time'][i][1].getHours(), event['time'][i][1].getMinutes());
						var add_class = 'scheduler-event-block-top-right-bottom-left';
						if(event['time'].length > 1){
							if(i === 0){
								add_class = 'scheduler-event-block-top-bottom-left';
							}
							else if(i === event['time'].length - 1){
								add_class = 'scheduler-event-block-top-right-bottom';
							}
							else{
								add_class = 'scheduler-event-block-top-bottom';
							}
						}
						var $_event_block = $('<div>').attr('event-id', event['id']).addClass(add_class).addClass('scheduler-event-block').addClass(color_class).html(text);
						$(calendar_grids[first_calendar_index++]).append($_event_block);
					}
				}
			}
		};

		var refresh_events = function(){
			$('.scheduler-event-block').remove();
			ajax_get_events();
		};

		$_this.click(function(e){
			if(e.target.parentNode === $_calendar_prev_button.get(0) ||  e.target === $_calendar_prev_button.get(0)){
				if(_mode === 'D'){
					var d = new Date(_year, _month, _date - 1);
					_this.update(_mode, d.getFullYear(), d.getMonth(), d.getDate());
				}
				else if(_mode === 'W'){
					var d = new Date(_year, _month, _date - 7);
					_this.update(_mode, d.getFullYear(), d.getMonth(), d.getDate());
				}
				else{
					var d = new Date(_year, _month - 1, _date);
					_this.update(_mode, d.getFullYear(), d.getMonth(), d.getDate());
				}
				return false;
			}
			else if(e.target.parentNode === $_calendar_next_button.get(0) ||  e.target === $_calendar_next_button.get(0)){
				if(_mode === 'D'){
				}
				else if(_mode === 'W'){
					var d = new Date(_year, _month, _date + 7);
					_this.update(_mode, d.getFullYear(), d.getMonth(), d.getDate());
				}
				else{
					var d = new Date(_year, _month + 1, _date);
					_this.update(_mode, d.getFullYear(), d.getMonth(), d.getDate());
				}
				return false;
			}
			else if(e.target === $_day_type_button.get(0)){
				return false;
			}
			else if(e.target === $_week_type_button.get(0)){
				var d = new Date(_year, _month, _date);
				_this.update('W', _year, _month, _date);
				return false;
			}
			else if(e.target === $_month_type_button.get(0)){
				var d = new Date(_year, _month, _date);
				_this.update('M', _year, _month, _date);
				return false;
			}
			else if(e.target === $_today_button.get(0)){
				var today = new Date();
				_this.update(_mode, today.getFullYear(), today.getMonth(), today.getDate());
			}
			else if(e.target === $_add_event_button.get(0) || e.target.parentNode === $_add_event_button.get(0)){
				_processing_box = bootbox.dialog({
					closeButton: false,
					message: '<div style="text-align:center">Loading......</div>'
				});				
				$.ajax({
					method: 'post',
					url: _url + '/get_event?id=0',
					success: function(data){
						if(data){
							$_event_modal = bootbox.dialog({
								message: data,
								title: 'Add Event',	
								buttons:{
									success: {
										label: 'Add',
										className: 'btn-primary',
										callback: function(){
											ajax_update_event(0);
										}
									},
									cancel: {
										label: 'Cancel',
										className: 'btn-default'
									}
								}
							});
						}
					},
					error: function(a, b, c){
					},
					complete: function(){
						_processing_box.modal('hide');				
					}
				});
			}
			else if(e.target === $_refresh_button.get(0) || e.target.parentNode === $_refresh_button.get(0)){
				refresh_events();
			}

			if($(e.target).hasClass('scheduler-event-block')){
				var event_id = $(e.target).attr('event-id');
				_processing_box = bootbox.dialog({
					closeButton: false,
					message: '<div style="text-align:center">Loading......</div>'
				});				
				$.ajax({
					method: 'post',
					url: _url + '/get_event?id=' + event_id,
					success: function(data){
						if(data){
							$_event_modal = bootbox.dialog({
								message: data,
								title: 'Update Event',	
								buttons:{
									success: {
										label: 'Update',
										className: 'btn-primary',
										callback: function(){
											ajax_update_event(event_id);
										}
									},
									danger: {
										label: 'Delete Event',
										className: 'btn-danger',
										callback: function(){
											$_event_modal.modal('hide');
											bootbox.confirm("Are you sure to delete this event?", function(result) {
												if(result){
													ajax_delete_event(event_id);
												}
											}); 
											
										}
									},
									cancel: {
										label: 'Cancel',
										className: 'btn-default'
									}
								}
							});
						}
					},
					error: function(a, b, c){
					},
					complete: function(){
						_processing_box.modal('hide');				
					}
				});
				
			}
		});
		
		$_this.dblclick(function(e){
			if($(e.target).hasClass('scheduler-event-block')){
			}
		});
		this.update = function(mode, year, month, date){
			if(mode !== _mode || _year !== year || _month !== month || _date !== date){
				calendar_grids.length = 0;
				calendar_date_list.length = [];
				_year = year;
				_month = month;
				_date = date;
				_mode = mode;
				switch(_mode){
					case 'W':
						$_week_type_button.button('toggle');
						var date_obj = new Date(year, month, date);
						var day = date_obj.getDay();
						$_table_head.empty();
						var first_date_of_week = new Date(year, month, date - day);
						$_table_head.empty();
						var $_tr = $('<tr>').appendTo($_table_head);
						var $_td = $('<td>').addClass('w50').appendTo($_tr);
						var title = months[first_date_of_week.getMonth()] + ' ' + first_date_of_week.getDate() + ' - ';
						for(var i = 0; i < 7; ++i){
							if(i > 0)
								first_date_of_week.setDate(first_date_of_week.getDate() + 1);
							var $_td = $('<td>').html(days[i] + '&nbsp;&nbsp;&nbsp;&nbsp;' 
								+ (first_date_of_week.getMonth() + 1 ) + '/' + first_date_of_week.getDate()).appendTo($_tr);
							calendar_date_list.push(first_date_of_week.getFullYear() + '-' + first_date_of_week.getMonth() + '-' + first_date_of_week.getDate());
						}
						title += months[first_date_of_week.getMonth()] + ' ' + first_date_of_week.getDate();
						$_title.html(title + ', '+ year);
						$_table_body.empty();
						for(var i = 0; i < 24; ++i){
							var $_tr = $('<tr>').appendTo($_table_body);
							var $_td = $('<td>').addClass('h20').appendTo($_tr).html(timeStr(initial_hour) + '&nbsp;');
							for(var j = 0; j < 7; ++j){
								var $_td = $('<td>').addClass('h20').appendTo($_tr);
								calendar_grids.push($_td.get(0));
							}
							var $_tr = $('<tr>').appendTo($_table_body);
							var $_td = $('<td>').addClass('h20').appendTo($_tr).html('&nbsp;');
							for(var j = 0; j < 7; ++j){
								var $_td = $('<td>').addClass('h20').appendTo($_tr);
								calendar_grids.push($_td.get(0));
							}
							initial_hour = (initial_hour + 1) % 24;							
						}
						break;
					case 'D':
						break;
					case 'Y':
						break;
					default:
						$_month_type_button.button('toggle');
						$_title.html(months[month] + ' '+ year);
						$_table_head.empty();
						var $_tr = $('<tr>').appendTo($_table_head);
						for(var i = 0; i < 7; ++i){
						var t = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
							var $_td = $('<td>').css('text-align', 'center').html(t[i]).appendTo($_tr);
						}
						$_table_body.empty();
						var date_obj = new Date(year, month, 1);
						var day = date_obj.getDay();
						var date_of_last_month = new Date(year, month, 0).getDate() - day + 1;
						var last_month_first_date = new Date(year, month - 1, date_of_last_month);
						var next_month_first_date = new Date(year, month + 1, 1);
						var date = 1;
						var month_date = 0;
						for(var i = 0; i < date_obj.numberOfWeeks(); ++i){
							var $_tr = $('<tr>').appendTo($_table_body);
							for(var j = 0; j < 7; ++j){								
								var $_td = $('<td>').addClass('h90').appendTo($_tr);
								calendar_grids.push($_td.get(0));
								if(day === j){
									if(date <= date_obj.lastDateOfMonth()){
										//$_td.attr('date', year + '-' + month + '-' + date);
										calendar_date_list.push(year + '-' + month + '-' + date);
										month_date = 1;
										var $d = $('<div>').addClass('plain-text').addClass('active').html(date++);
										$_td.append($d);
									}
									else{
										month_date = 2;										
									}
									day = (day + 1) % 7;
								}
								if(month_date === 0){									
									//$_td.attr('date', last_month_first_date.getFullYear() + '-' + last_month_first_date.getMonth() + '-' + last_month_first_date.getDate());
									calendar_date_list.push(last_month_first_date.getFullYear() + '-' + last_month_first_date.getMonth() + '-' + last_month_first_date.getDate());
									var $d = $('<div>').addClass('h90').addClass('plain-text').addClass('inactive').html(last_month_first_date.getDate());
									last_month_first_date.setDate(last_month_first_date.getDate() + 1);
									$_td.append($d);
								}
								else if(month_date === 2){
									//$_td.attr('date', next_month_first_date.getFullYear() + '-' + next_month_first_date.getMonth() + '-' + next_month_first_date.getDate());
									calendar_date_list.push(next_month_first_date.getFullYear() + '-' + next_month_first_date.getMonth() + '-' + next_month_first_date.getDate());
									var $d = $('<div>').addClass('h90').addClass('plain-text').addClass('inactive').html(next_month_first_date.getDate());
									next_month_first_date.setDate(next_month_first_date.getDate() + 1);
									$_td.append($d);
								}
							}
						}
				}
				$.each($_main_table.find('td'), function(){
					var $_div = $('<div>').addClass('div-back').appendTo($(this));
				});
				
				ajax_get_events();
			}
		};
		var today = new Date();
		_this.update(_mode, today.getFullYear(), today.getMonth(), today.getDate());
		return _this;
	};
})(jQuery);

