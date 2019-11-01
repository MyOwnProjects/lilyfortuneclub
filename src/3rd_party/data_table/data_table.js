function pop_up(prop){//title, url, param){
	var title = prop['title'];
	var url = prop['url'];
	var param = prop['param'];
	$.ajax({
		url: url,
		statusCode: {
			403: function(a, b, c){
				window.location.href = a.responseText;
				return false;
			}
		},
		success: function(data){
			Dialog.modal({
				message: data,
				title: title,
				buttons: {
					primary: {
						label: prop && prop['button_labels'] && prop['button_labels']['primary'] ? prop['button_labels']['primary'] : "Submit",
						className: "btn-primary",
						callback: function() {
							Dialog.modal.ajaxLoad(function(){
								var param_data = {};
								if(param && param['selected_ids']){
									param_data['selected_ids'] = param['selected_ids'];
								}
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
									statusCode: {
										403: function(a, b, c){
											window.location.href = a.responseText;
											return false;
										}
									},
									success: function(data){
										if(data['success']){
											Dialog.hide();
											Dialog.modal.success('', param['func']);
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
						label: prop && prop['button_labels'] && prop['button_labels']['cancel'] ? prop['button_labels']['cancel'] :"Cancel",
						className: "btn"
					}
				},
				onEscape: function () {
					Dialog.modal('hide');
				}
			});
		},
		error: function(a, b, c){
			Dialog.error(a.responseText);
		}
	});
};

function new_item(prop){//title, url, param){
	var title = prop['title'];
	var url = prop['url'];
	var param = prop['param'];
	var loaded = prop['loaded'];
	$.ajax({
		url: url,
		success: function(data){
			Dialog.modal({
				message: data,
				title: title,
				loaded: loaded,
				buttons: {
					primary: {
						label: prop && prop['button_labels'] && prop['button_labels']['primary'] ? prop['button_labels']['primary'] : "Submit",
						className: "btn-primary",
						callback: function() {
							Dialog.modal.ajaxLoad(function(){
								var param_data = {};
								if(param && param['selected_ids']){
									param_data['selected_ids'] = param['selected_ids'];
								}
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
											Dialog.modal.success('', param['func']);
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
						label: prop && prop['button_labels'] && prop['button_labels']['cancel'] ? prop['button_labels']['cancel'] :"Cancel",
						className: "btn"
					}
				},
				onEscape: function () {
					Dialog.modal('hide');
				}
			});
			if(param && param['source']){
				var source = param['source'];
				for(var id in source){
					$('.bootbox #' + id).val(source[id]);
				}
			}
		},
		error: function(a, b, c){
			Dialog.error(a.responseText);
		}
	});
}

(function($){
	$.fn.data_table = function(prop){//, header, url, customized_buttons, filter, row_count, order_by){
		var header = prop['header'];
		var url = prop['url']; 
		var customized_buttons = prop['customized_buttons'];
		var filter = prop['filter'];
		var customized_filters = prop['customized_filters'];
		var row_count = prop['row_count'];
		var order_by = prop['order_by'];
		var filter_by = prop['filter_by'];
		var _row_count = row_count > 0 ? row_count : Number.MAX_SAFE_INTEGER;
		var _this = this;
		var $_this = $(this);
		var _search_key = '';
		var _filter = filter_by ? filter_by : [];
		var _current_page = 1;
		var _sort = {};
		$.extend(_sort, order_by);
		var _search = function(btn){
			var $_btn = $(btn);
			var v = $_search_input.val().trim();
			if(v != _search_key){
				_search_key = v;
				_current_page = 1;
				_this.reload();
			}
		};

		var _update_customized_button_status = function(checked){
			for(var i = 0; i < customized_buttons.length; ++i){
				if(customized_buttons[i]['checked']){
					var $_obj = $($_customized_button_group.children()[i]);
					if(checked){
						if($_obj.hasClass('btn-group')){
							$_obj.children('.btn').removeClass('disabled');
						}
						else{
							$_obj.removeClass('disabled');
						}
					}
					else{
						if($_obj.hasClass('btn-group')){
							$_obj.children('.btn').addClass('disabled');
						}
						else{
							$_obj.addClass('disabled');
						}
					}
				}
			}
			
		};
		
		$_this.addClass('data-table');
		this.toolbar = $('<div>').addClass('data-table-toolbar').appendTo($_this);
		var $_toolbar_row = $('<div>').addClass('toolbar-row').addClass('d-flex').appendTo(this.toolbar);
		var $_input_group = $('<div>').addClass('search-group').addClass('input-group').addClass('input-group-sm').addClass('pull-left').appendTo($_toolbar_row);
		var $_search_input = $('<input>').addClass('form-control').attr('type', 'text').attr('placeholder', 'search').appendTo($_input_group).keypress(function(e){
			if ( e.which == 13 ) {
				e.preventDefault();
				_search(this);
				return false;
			}          
		});
		var $_d = $('<div>').addClass('input-group-append').appendTo($_input_group);
		var $_search_button = $('<button>').addClass('btn').addClass('btn-primary').addClass('btn-xs').attr('type','button').append('<i class="fa fa-search" aria-hidden="true"></i>').appendTo($_d).click(function(){
			_search(this);
		});
		
		//filter for mobile version
		if(filter && !$.isEmptyObject(filter)){
			$_toolbar_row = $('<div>').addClass('toolbar-row').addClass('toolbar-row-sm').addClass('d-flex').addClass('mt-2').addClass('').appendTo(this.toolbar);
			//var $_filter_group = $('<div>').addClass('dialog-input-group-block').addClass('input-group').addClass('pull-right').appendTo(this.toolbar);
			var $_filter_input_group = $('<div>').addClass('input-group').addClass('filter-group').addClass('input-group-sm').appendTo($_toolbar_row);//$_filter_group);
			var $_filter_select = $('<input>').addClass('form-control').addClass('input-sm').attr('type', 'text')
				.attr('readonly', true).css('background', '#fff').attr('placeholder', 'Filter by ')
				.appendTo($_filter_input_group);
				if(_filter){
					$_filter_select.val(Object.values(_filter));
				}
			var $_d = $('<div>').addClass('input-group-append').appendTo($_filter_input_group);
			var $_filter_select_button = $('<button>').addClass('btn').addClass('btn-primary').addClass('btn-sm').addClass('dropdown-toggle')
				.attr('type','button').attr('data-toggle', 'dropdown').appendTo($_d).click(function(){
				//_search(this);
			});
			var $_filter_dropdown_menu = $('<div>').addClass("dropdown-menu").addClass('dropdown-menu-right').appendTo($_d);
			for(var i = 0; i < filter.length; ++i){
				if(i > 0){
					$('<div>').addClass('dropdown-divider').appendTo($_filter_dropdown_menu);
				}
				$('<span class="dropdown-item">' + filter[i]['text'] + '</span>').appendTo($_filter_dropdown_menu);
				$('<a data-value="" href="javascript:void(0)" filter-id="' + filter[i]['id'] + '" class="dropdown-item' + (_filter[filter[i]['id']] === undefined ? ' dropdown-item-checked' : '') + '">'
					+ '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All</a>')
					.appendTo($_filter_dropdown_menu);
				for(var filter_id in filter[i]['options']){
					$('<a data-value="' + filter_id + '" href="javascript:void(0) "filter-id="' + filter[i]['id'] + '" class="dropdown-item' + (_filter[filter[i]['id']] == filter_id ? ' dropdown-item-checked' : '') + '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
						 + filter[i]['options'][filter_id] + '</a>').appendTo($_filter_dropdown_menu);
				}
			}
			this.filter_select1 = $_filter_select;
			this.filter_dropdown_menu1 = $_filter_dropdown_menu;
		}
		
		$_toolbar_row = $('<div>').addClass('toolbar-row').addClass('d-flex').addClass('mt-2').appendTo(this.toolbar);
		var $_customized_button_group;
		if(customized_buttons){
			var $_customized_button_group = $('<div>').addClass('btn-group').addClass('customized_button_group').addClass('mr-auto').css('margin-right', '20px').appendTo($_toolbar_row);
			for(var i = 0; i < customized_buttons.length; ++i){
				var $_button;
				if(customized_buttons[i]['sub_menus'] && customized_buttons[i]['sub_menus'].length > 0){
					var $_dropdown_group = $('<div>').addClass('btn-group').appendTo($_customized_button_group);
					$_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary')
						.addClass('dropdown-toggle').attr('data-toggle', 'dropdown')
						.html(customized_buttons[i]['text'] + '&nbsp;<span class="caret"></span>').appendTo($_dropdown_group);
					var $_dorpdown_ul = $('<div>').addClass('dropdown-menu').appendTo($_dropdown_group);
					for(var j = 0; j < customized_buttons[i]['sub_menus'].length; ++j){
						var $_a = $('<a>').addClass('dropdown-item').attr('href', 'javascript:void(0)').html(customized_buttons[i]['sub_menus'][j]['text']);
						if(customized_buttons[i]['sub_menus'][j]['callback']){
							$_a.click(function(btn_index, menu_index, obj){
								return function(){
									var param = {sort: _sort, search: _search_key, filter: _filter};
									if(customized_buttons[btn_index]['sub_menus'][menu_index]['success_reload']){
										param['func'] = _this.reload;
									}
									if(customized_buttons[btn_index]['sub_menus'][menu_index]['checked']){
										param['selected_ids'] = [];
										_this.tbody.find('.data-table-checkbox input[type=checkbox]').each(function(){
											if($(this).prop('checked')){
												param['selected_ids'].push($(this).parent().parent().attr('data-id'));
											}
										});				
									}
									customized_buttons[btn_index]['sub_menus'][menu_index]['callback'](param);
								};
							}(i, j, $_a));
						}
						$_dorpdown_ul.append($_a);
					}
				}
				else{
					$_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary')
						.html(customized_buttons[i]['text']).appendTo($_customized_button_group);
				}
				if(customized_buttons[i]['callback']){
					$_button.click(function(index, obj){
						return function(){
							var param = {};
							if(!$(obj).hasClass('disabled')){//'button-disabled')){
								if(customized_buttons[index]['success_reload']){
									param['func'] = _this.reload;
								}
								if(customized_buttons[index]['checked']){
									param['selected_ids'] = [];
									_this.tbody.find('.data-table-checkbox input[type=checkbox]').each(function(){
										if($(this).prop('checked')){
											param['selected_ids'].push($(this).parent().parent().attr('data-id'));
										}
									});				
								}
								customized_buttons[index]['callback'](param);
							}
						};
					}(i, $_button));
				}
					
				if(customized_buttons[i]['checked']){
					$_button.addClass('disabled');//'button-disabled');
				}
				else{
					$_button.removeClass('disabled');//'button-disabled');
					//$_button.addClass('btn-primary');
				}
			}
		}

		if(filter && !$.isEmptyObject(filter)){
			//var $_filter_group = $('<div>').addClass('dialog-input-group-block').addClass('input-group').addClass('pull-right').appendTo(this.toolbar);
			var $_filter_input_group = $('<div>').addClass('input-group').addClass('filter-group').addClass('filter-group-sm').addClass('input-group-sm').appendTo($_toolbar_row);//$_filter_group);
			var $_filter_select = $('<input>').addClass('form-control').addClass('input-sm')
				.attr('type', 'text').attr('readonly', true).css('background', '#fff')
				.attr('placeholder', 'Filter by ').appendTo($_filter_input_group);
			if(_filter){
				$_filter_select.val(Object.values(_filter).join(' & '));
			}
			var $_d = $('<div>').addClass('input-group-append').appendTo($_filter_input_group);
			var $_filter_select_button = $('<button>').addClass('btn').addClass('btn-primary').addClass('btn-sm').addClass('dropdown-toggle')
				.attr('type','button').attr('data-toggle', 'dropdown').appendTo($_d).click(function(){
				//_search(this);
			});
			var $_filter_dropdown_menu = $('<div>').addClass("dropdown-menu").addClass('dropdown-menu-right').appendTo($_d);
			for(var i = 0; i < filter.length; ++i){
				if(i > 0){
					$('<div>').addClass('dropdown-divider').appendTo($_filter_dropdown_menu);
				}
				$('<span class="dropdown-item">' + filter[i]['text'] + '</span>').appendTo($_filter_dropdown_menu);
				$('<a data-value="" href="javascript:void(0)" filter-id="' + filter[i]['id'] + '" class="dropdown-item' + (_filter[filter[i]['id']] === undefined ? ' dropdown-item-checked' : '') + '">'
					+ '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;All</a>')
					.appendTo($_filter_dropdown_menu);
				for(var filter_id in filter[i]['options']){
					$('<a data-value="' + filter_id + '" href="javascript:void(0) "filter-id="' + filter[i]['id'] + '" class="dropdown-item' + (_filter[filter[i]['id']] == filter_id ? ' dropdown-item-checked' : '') + '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
						 + filter[i]['options'][filter_id] + '</a>').appendTo($_filter_dropdown_menu);
				}
			}
			this.filter_select = $_filter_select;
			this.filter_dropdown_menu = $_filter_dropdown_menu;
		}
		else if(customized_filters && Array.isArray(customized_filters)){
			
		}

		var $_standard_groups = $('<div>').addClass('standard-groups').appendTo($_toolbar_row);//$_table_group_bar);

		//column
		var $_columns_button_group = $('<div>').addClass('btn-group').addClass('columns-btn-group').appendTo($_standard_groups);
		var $_columns_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary')
			.addClass('dropdown-toggle').attr('data-toggle', 'dropdown')
			.html('Columns&nbsp;<span class="caret"></span>').appendTo($_columns_button_group);
			var $_dorpdown_ul = $('<div>').addClass('dropdown-menu').appendTo($_columns_button_group);
			var $_a = $('<a>').addClass('dropdown-item').appendTo($_dorpdown_ul);
			$_d = $('<div>').addClass('form-check-label')
				.html('<label class="form-check-label"><input type="checkbox" class="form-check-input columns-display-checkbox" value="all" checked>All</label>');
			$_a.append($_d);
			for(var i = 0; i < header.length; ++i){
				var $_a = $('<a>').addClass('dropdown-item').appendTo($_dorpdown_ul);
				$_d = $('<div>').addClass('form-check-label')
					.html('<label class="form-check-label"><input type="checkbox" class="form-check-input columns-display-checkbox" value="' + header[i]['id'] + '" checked>' + header[i]['text'] + '</label>');
				$_a.append($_d);
			}
			/*for(var j = 0; j < customized_buttons[i]['sub_menus'].length; ++j){
				var $_li = $('<li>').html('<a href="javascript:void(0)">' + customized_buttons[i]['sub_menus'][j]['text'] + '</a>');
						if(customized_buttons[i]['sub_menus'][j]['callback']){
							$_li.click(function(btn_index, menu_index, obj){
								return function(){
									var param = {};
									if(customized_buttons[btn_index]['sub_menus'][menu_index]['success_reload']){
										param['func'] = _this.reload;
									}
									if(customized_buttons[btn_index]['sub_menus'][menu_index]['checked']){
										param['selected_ids'] = [];
										_this.tbody.find('.data-table-checkbox input[type=checkbox]').each(function(){
											if($(this).prop('checked')){
												param['selected_ids'].push($(this).parent().parent().attr('data-id'));
											}
										});				
									}
									customized_buttons[btn_index]['sub_menus'][menu_index]['callback'](param);
								};
							}(i, j, $_li));
						}
						$_dorpdown_ul.append($_li);
					}*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		//var $_button_group = $('<div>').addClass('data-table-button-group').appendTo($_standard_groups);
		var $_button_group = $('<div>').addClass('btn-group').appendTo($_standard_groups);
		var $_refresh_button = $('<button>').addClass('btn').addClass('btn-primary').addClass('btn-sm').attr('title', 'refresh').append('<i class="fa fa-refresh" aria-hidden="true"></i>')
			.click(function(){
				_this.reload();
			}).appendTo($_button_group);
		$_button_group = $('<div>').addClass('btn-group').appendTo($_standard_groups);//addClass('data-table-button-group').appendTo($_standard_groups);
		var $_first_page_button = $('<button>').attr('type', 'button').addClass('btn-first-pg').addClass('btn').addClass('btn-sm').addClass('btn-primary').attr('title', 'first page').append('<i class="fa fa-fast-backward" aria-hidden="true"></i>').appendTo($_button_group).click(function(){
			_current_page = 'first';
			_this.reload();
		});
		var $_prev_page_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary').attr('title', 'prev page').append('<i class="fa fa-backward" aria-hidden="true"></i>').appendTo($_button_group).click(function(){
			_current_page--;
			_this.reload();
		});
		var $_current_page_button = $('<button>').attr('type', 'button').addClass('btn-pg-number').addClass('btn').addClass('btn-sm').addClass('btn-text').css('width', '60px').html('0').appendTo($_button_group);
		var $_next_page_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary').attr('title', 'next page').append('<i class="fa fa-forward" aria-hidden="true"></i>').appendTo($_button_group).click(function(){
			_current_page++;
			_this.reload();
		});
		var $_last_page_button = $('<button>').attr('type', 'button').addClass('btn-last-pg').addClass('btn').addClass('btn-sm').addClass('btn-primary').attr('title', 'last page').append('<i class="fa fa-fast-forward" aria-hidden="true"></i>').appendTo($_button_group).click(function(){
			_current_page = 'last';
			_this.reload();
		});

		this.table1 = $('<table>').addClass('narrow-table').attr('cellpadding', '0').attr('cellspacing', '0').appendTo($_this);
		this.tbody1 = $('<tbody>').appendTo(this.table1);
	
		this.table = $('<table>').addClass('wide-table').attr('cellpadding', '0').attr('cellspacing', '0').appendTo($_this);
		this.thead = $('<thead>').appendTo(this.table);
		var $_tr = $('<tr>').appendTo(this.thead);
		var $_check_all_box = $('<input>').attr('type', 'checkbox');
		$('<td>').addClass('data-table-checkbox').addClass('bg-primary').append($_check_all_box).appendTo($_tr);
		for(var i = 0; i < header.length; ++i){
			var td = $('<td>').addClass('bg-primary').attr('data-id', header[i]['id']).html(header[i]['text']).appendTo($_tr);
			if(header[i]['align']){
				td.css('text-align', header[i]['align']);
			}
			if(header[i]['width']){
				td.css('width', (parseInt(header[i]['width']) + (header[i]['sortable'] ? 30 : 0)) + 'px');
			}
			if(header[i]['sortable']){
				if(header[i]['id'] in _sort){
					var sv = _sort[header[i]['id']].toUpperCase();
					if(sv == 'ASC'){
						td.addClass('sortable').attr('title', 'Click to sort').append('<i class="fa fa-sort-asc pull-right" aria-hidden="true"></i>');
					}
					else if(sv == 'DESC'){
						td.addClass('sortable').attr('title', 'Click to sort').append('<i class="fa fa-sort-desc pull-right" aria-hidden="true"></i>');
					}
					else{
						td.addClass('sortable').attr('title', 'Click to sort').append('<i class="fa fa-sort pull-right" aria-hidden="true"></i>');
					}
				}
				else{
					td.addClass('sortable').attr('title', 'Click to sort').append('<i class="fa fa-sort pull-right" aria-hidden="true"></i>');
				}
			}
		}
		//$('<td>').addClass('data-table-action').addClass('bg-primary').html('Action').appendTo($_tr);
		this.tbody = $('<tbody>').appendTo(this.table);
		
		this.reload = function(){
			$.ajax({
				url: url,
				method: 'post',
				data: {current: _current_page, row_count: _row_count, sort: _sort, search: _search_key, filter: _filter},
				dataType: 'json',
				success: function(data){
					_this.tbody1.empty();
					_this.tbody.empty();
					if(data['total'] == 0){
						$_first_page_button.addClass('disabled');
						$_prev_page_button.addClass('disabled');
						$_next_page_button.addClass('disabled');
						$_last_page_button.addClass('disabled');
						_current_page = 0;
						$_current_page_button.html(_current_page);
					}
					else{
						_current_page = data['current'];
						var last_page = data['last'];
						if(_current_page > 1){
							$_prev_page_button.removeClass('disabled');
						}
						else{
							$_prev_page_button.addClass('disabled');
						}
						if(last_page > _current_page){
							$_next_page_button.removeClass('disabled');
						}
						else{
							$_next_page_button.addClass('disabled');
						}
						$_current_page_button.html(_current_page + ' / ' + last_page);
					}
					$_search_input.val(data['search']);
					if(data['rows'].length > 0){
						$_check_all_box.prop('disabled', false);
						for(var i = 0; i < data['rows'].length; ++i){
							var tr = $('<tr>').attr('data-id', data['rows'][i]['id']).appendTo(_this.tbody);
							var tr1 = $('<tr>').attr('data-id', data['rows'][i]['id']).appendTo(_this.tbody1);
							if(data['rows'][i]['action'] && data['rows'][i]['action']['view']){
								tr.addClass('clickable').attr('edit-url', data['rows'][i]['action']['view']);
								tr1.addClass('clickable').attr('edit-url', data['rows'][i]['action']['view']);
							}
							$('<td>').addClass('data-table-checkbox').html('<input type="checkbox">').appendTo(tr);

							var text = '';
							for(var j = 0; j < header.length; ++j){
								var td = $('<td>').html(data['rows'][i][header[j]['id']]).appendTo(tr);
								if(header[j]['align']){
									td.css('text-align', header[j]['align']);
								}
								if(header[j]['valign']){
									td.css('vertical-align', header[j]['valign']);
								}
								if(header[j]['narrow_display']){
									text += '<div><span>' + header[j]['text'] + ': </span><b>' + data['rows'][i][header[j]['id']] + '</b></div>';
								}
							}
							$('<td>').addClass('clearfix').html(text).appendTo(tr1);
							/*var $_action = $('<td>').addClass('data-table-action').html('').appendTo(tr);
							if(data['rows'][i]['action']){
								if(data['rows'][i]['action']['view']){
									$_action.append('<a href="' + data['rows'][i]['action']['view'] + '" title="View"><span class="glyphicon glyphicon-eye-open"></span></a>');  
								}
								if(data['rows'][i]['action']['update']){
									$_action.append('<a href="' + data['rows'][i]['action']['update'] + '" title="Update"><span class="glyphicon glyphicon-edit"></span></a>');  
								}
								if(data['rows'][i]['action']['delete']){
									$_action.append('<a href="' + data['rows'][i]['action']['delete'] + '" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>');  
								}
							}*/
						}
					}
					else{
						$_check_all_box.prop('disabled', true);
						var tr = $('<tr>');
						$('<td>').addClass('center').attr('colspan', _this.thead.find('td').length).html('No data returned.').appendTo(tr);
						_this.tbody.append(tr);
					}
				},
				error: function(a, b, c){
					var tr = $('<tr>');
					var $_alert = $('<div>').addClass('alert').addClass('alert-danger').html('Error!&nbsp;' + a.responseText);
					$('<td>').addClass('center').attr('colspan', _this.thead.find('td').length).html($_alert).appendTo(tr);
					_this.tbody.empty().append(tr);
				}
			});
		};
		$_check_all_box.click(function(){
			_this.tbody.find('.data-table-checkbox').each(function(){
				$(this).children('input[type=checkbox]').prop('checked', $_check_all_box.prop('checked'));
			});
			_update_customized_button_status($_check_all_box.prop('checked'));
		});
		
		if(this.filter_dropdown_menu){
			this.filter_dropdown_menu.delegate('a:not(.dropdown-item-checked)', 'click', function(){
				var new_filter = $(this).attr('data-value');
				var filter_id = $(this).attr('filter-id');
				if(new_filter === ''){
					delete _filter[filter_id];
				}
				else{
					_filter[filter_id] = new_filter;
				}
				$(this).addClass('dropdown-item-checked');
				$(this).siblings('[filter-id=' + filter_id + ']').removeClass('dropdown-item-checked');
				$_filter_select.val(Object.values(_filter).join(' & '));
				_this.reload();
			});
		}
		
		if(this.filter_dropdown_menu1){
			this.filter_dropdown_menu1.delegate('a:not(.dropdown-item-checked)', 'click', function(){
				var new_filter = $(this).attr('data-value');
				var filter_id = $(this).attr('filter-id');
				if(new_filter === ''){
					delete _filter[filter_id];
				}
				else{
					_filter[filter_id] = new_filter;
				}
				$(this).addClass('dropdown-item-checked');
				$(this).siblings('[filter-id=' + filter_id + ']').removeClass('dropdown-item-checked');
				$_filter_select.val(Object.values(_filter).join(' & '));
				_this.reload();
			});
		}

		this.tbody.delegate('.data-table-checkbox input[type=checkbox]', 'click', function(){
			var all_checked = true;
			var all_unchecked = true;
			_this.tbody.find('.data-table-checkbox input[type=checkbox]').each(function(){
				if(!$(this).prop('checked')){
					all_checked = false;
				}
				else{
					all_unchecked = false;
				}
			});
			$_check_all_box.prop('checked', all_checked);
			_update_customized_button_status(!all_unchecked);
		});
		this.tbody.delegate('.data-table-checkbox input', 'click', function(e){
			e.stopPropagation();
		});
		this.tbody.delegate('.clickable', 'click', function(){
			if($(this).attr('edit-url').length > 0){
				location = $(this).attr('edit-url');
			}
		});
		this.tbody1.delegate('.clickable', 'click', function(){
			if($(this).attr('edit-url').length > 0){
				location = $(this).attr('edit-url');
			}
		});
		$_columns_button_group.delegate('.columns-display-checkbox', 'click', function(){
			if($(this).val() == 'all'){
				$_columns_button_group.find('.columns-display-checkbox').prop('checked', $(this).prop('checked'));
			}
			else{
				var check_all = true;
				$_columns_button_group.find('.columns-display-checkbox').each(function(index, obj){
					if(index > 0){
						if(!$(this).prop('checked')){
							check_all = false;
						}
						$_columns_button_group.find('.columns-display-checkbox[value=all]').prop('checked', check_all);
					}
				});
			}
			
			$_columns_button_group.find('.columns-display-checkbox').each(function(index, obj){
				var $_checkbox = $(this);
				for(var i = 0; i < header.length; ++i){
					if(header[i]['id'] == $_checkbox.val()){
						_this.thead.children('tr').each(function(index, obj){
							if($_checkbox.prop('checked')){
								$(this).children('td:nth-child(' + (i + 2) + ')').show();
							}
							else{
								$(this).children('td:nth-child(' + (i + 2) + ')').hide();
							}
						});
						_this.tbody.children('tr').each(function(index, obj){
							if($_checkbox.prop('checked')){
								$(this).children('td:nth-child(' + (i + 2) + ')').show();
							}
							else{
								$(this).children('td:nth-child(' + (i + 2) + ')').hide();
							}
						});
					}
				}
			});
		});
        this.thead.delegate('.sortable', 'click', function(){
                                            if($(this).hasClass('sort-asc')){
                                                $(this).removeClass('sort-asc').addClass('sort-desc');
                                                $(this).children('i').removeClass('fa-sort-asc').addClass('fa-sort-desc');
												_sort[$(this).attr('data-id')] = 'desc';
                                            }
                                            else if($(this).hasClass('sort-desc')){
                                                $(this).removeClass('sort-desc');
                                                $(this).children('i').removeClass('fa-sort-desc').addClass('fa-sort');
												delete _sort[$(this).attr('data-id')];
                                            }
                                            else{
                                                $(this).addClass('sort-asc');
                                                $(this).children('i').removeClass('fa-sort').addClass('fa-sort-asc');
												_sort[$(this).attr('data-id')] = 'asc';
                                            }
                                            var tr = $('<tr>');
                                            $('<td>').addClass('loading').attr('colspan', _this.thead.find('td').length).append('<div></div>').appendTo(tr);
                                            _this.tbody.empty().append(tr);
												/*_sort = {};
                                            $(_this.thead.find('.sortable')).each(function(){
                                                if($(this).hasClass('sort-asc')){
                                                    _sort[$(this).attr('data-id')] = 'asc';
                                                 }
                                                 else if($(this).hasClass('sort-desc')){
                                                    _sort[$(this).attr('data-id')] = 'desc';
                                                 }
                                            });*/
                                            _current_page= 1;
                                            _this.reload();
                                    });
		
		for(var col_id in _sort){
			var col = this.thead.find('td[data-id=' + col_id + ']');
			if(col.length > 0 && col.hasClass('sortable')){
				var v = _sort[col_id].toLowerCase();
				if(v == 'asc'){
					col.addClass('sort-asc');
					col.children('i').removeClass('fa-sort').addClass('fa-sort-asc');
				}
				else if(v == 'desc'){
					col.addClass('sort-desc');
					col.children('i').removeClass('fa-sort').addClass('fa-sort-desc');
				}
			}
		}
		this.reload();
		return $_this;
	};
}(jQuery));