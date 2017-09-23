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
	$.ajax({
		url: url,
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
		var _row_count = row_count > 0 ? row_count : Number.MAX_SAFE_INTEGER;
		var _this = this;
		var $_this = $(this);
		var _search_key = '';
		var _filter = {};
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
		this.toolbar = $('<div>').addClass('data-table-toolbar').addClass('clearfix').appendTo($_this);
		
		var $_customized_button_group;
		if(customized_buttons){
			var $customized_group = $('<div>').addClass('customized_group').addClass('pull-left').appendTo(this.toolbar);
			var $_customized_button_group = $('<div>').addClass('btn-group').appendTo($customized_group);
			for(var i = 0; i < customized_buttons.length; ++i){
				var $_button;
				if(customized_buttons[i]['sub_menus'] && customized_buttons[i]['sub_menus'].length > 0){
					var $_dropdown_group = $('<div>').addClass('btn-group').appendTo($_customized_button_group);
					$_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary')
						.addClass('dropdown-toggle').attr('data-toggle', 'dropdown')
						.html(customized_buttons[i]['text'] + '&nbsp;<span class="caret"></span>').appendTo($_dropdown_group);
					var $_dorpdown_ul = $('<ul>').addClass('dropdown-menu').appendTo($_dropdown_group);
					for(var j = 0; j < customized_buttons[i]['sub_menus'].length; ++j){
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
		var $_table_group_bar = $('<div>').addClass('table-group-bar').addClass('clearfix').appendTo(this.toolbar);
		var $_standard_groups = $('<div>').addClass('standard-groups').addClass('pull-right').appendTo($_table_group_bar);
		if(filter && !$.isEmptyObject(filter)){
			var $_filter_group = $('<div>').addClass('dialog-input-group-block').addClass('input-group').addClass('pull-right').addClass('dropdown').appendTo($_table_group_bar);
			var $_filter_input_group = $('<div>').addClass('input-group').addClass('pull-left').addClass('dropdown-toggle').attr('data-toggle', 'dropdown').appendTo($_filter_group);
			var $_filter_select = $('<input>').addClass('form-control').addClass('input-sm').attr('type', 'text').attr('readonly', true).css('background', '#fff').attr('placeholder', 'Filter by ').appendTo($_filter_input_group);
			var $_span = $('<span>').addClass('input-group-btn').appendTo($_filter_input_group);
			var $_filter_select_button = $('<button>').addClass('btn').addClass('btn-primary').addClass('btn-sm').attr('type','button').append('<span class="glyphicon glyphicon glyphicon-menu-down"></span>').appendTo($_span).click(function(){
				//_search(this);
			});
			var $_filter_dropdown_menu = $('<ul>').addClass("dropdown-menu").css('width', '100%').css('margin', '0').appendTo($_filter_group);
			$('<li data-value=""><a href="javascript:void(0)">All</a></li>').appendTo($_filter_dropdown_menu);
			for(var filter_id in filter['options']){
				$('<li data-value="' + filter_id + '"><a href="javascript:void(0)">' + filter['options'][filter_id] + '</a></li>').appendTo($_filter_dropdown_menu);
			}
			this.filter_dropdown_menu = $_filter_dropdown_menu;
		}
		else if(customized_filters && Array.isArray(customized_filters)){
			
		}

        var $_search_group = $('<div>').addClass('dialog-input-group-block').css('overflow', 'hidden').appendTo($_table_group_bar);
		var $_input_group = $('<div>').addClass('input-group').addClass('pull-left').appendTo($_search_group);
		var $_search_input = $('<input>').addClass('form-control').addClass('input-sm').attr('type', 'text').attr('placeholder', 'search').appendTo($_input_group).keypress(function(e){
			if ( e.which == 13 ) {
				e.preventDefault();
				_search(this);
				return false;
			}          
		});
		var $_span = $('<span>').addClass('input-group-btn').appendTo($_input_group);
		var $_search_button = $('<button>').addClass('btn').addClass('btn-primary').addClass('btn-sm').attr('type','button').append('<span class="glyphicon glyphicon-search"></span>').appendTo($_span).click(function(){
			_search(this);
		});
                  
		//var $_button_group = $('<div>').addClass('data-table-button-group').appendTo($_standard_groups);
		var $_button_group = $('<div>').addClass('btn-group').appendTo($_standard_groups);
		var $_refresh_button = $('<button>').addClass('btn').addClass('btn-primary').addClass('btn-sm').attr('title', 'refresh').append('<span class="glyphicon glyphicon-refresh"></span>')
			.click(function(){
				_this.reload();
			}).appendTo($_button_group);
		$_button_group = $('<div>').addClass('btn-group').appendTo($_standard_groups);//addClass('data-table-button-group').appendTo($_standard_groups);
		var $_first_page_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary').attr('title', 'first page').append('<span class="glyphicon glyphicon-step-backward"></span>').appendTo($_button_group).click(function(){
			_current_page = 'first';
			_this.reload();
		});
		var $_prev_page_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary').attr('title', 'prev page').append('<span class="glyphicon glyphicon-chevron-left"></span>').appendTo($_button_group).click(function(){
			_current_page--;
			_this.reload();
		});
		var $_current_page_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-text').css('width', '60px').html('0').appendTo($_button_group);
		var $_next_page_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary').attr('title', 'next page').append('<span class="glyphicon glyphicon-chevron-right"></span>').appendTo($_button_group).click(function(){
			_current_page++;
			_this.reload();
		});
		var $_last_page_button = $('<button>').attr('type', 'button').addClass('btn').addClass('btn-sm').addClass('btn-primary').attr('title', 'last page').append('<span class="glyphicon glyphicon-step-forward"></span>').appendTo($_button_group).click(function(){
			_current_page = 'last';
			_this.reload();
		});
                                    
		this.table = $('<table>').attr('cellpadding', '0').attr('cellspacing', '0').appendTo($_this);
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
				td.addClass('sortable').attr('title', 'Click to sort').append('<span class="glyphicon glyphicon-sort pull-right"></span>');
			}
		}
		$('<td>').addClass('data-table-action').addClass('bg-primary').html('Action').appendTo($_tr);
		this.tbody = $('<tbody>').appendTo(this.table);
		
		this.reload = function(){
			$.ajax({
				url: url,
				method: 'post',
				data: {current: _current_page, row_count: _row_count, sort: _sort, search: _search_key, filter: _filter},
				dataType: 'json',
				success: function(data){
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
							$('<td>').addClass('data-table-checkbox').html('<input type="checkbox">').appendTo(tr);
							for(var j = 0; j < header.length; ++j){
								var td = $('<td>').html(data['rows'][i][header[j]['id']]).appendTo(tr);
								if(header[j]['align']){
									td.css('text-align', header[j]['align']);
								}
							}
							var $_action = $('<td>').addClass('data-table-action').html('').appendTo(tr);
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
							}
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
			this.filter_dropdown_menu.delegate('li', 'click', function(){
				$(this).parent().parent().children(':first-child').children(':first-child').val($(this).text());
				var new_filter = $(this).attr('data-value');
				if(_filter[filter['id']] != new_filter){
					_filter[filter['id']] = new_filter;
					_this.reload();
				}
				else if(new_filter == ''){
					_filter = [];
				}
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
                                    this.thead.delegate('.sortable', 'click', function(){
                                            if($(this).hasClass('sort-asc')){
                                                $(this).removeClass('sort-asc').addClass('sort-desc');
                                                $(this).children('span').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom');
												_sort[$(this).attr('data-id')] = 'desc';
                                            }
                                            else if($(this).hasClass('sort-desc')){
                                                $(this).removeClass('sort-desc');
                                                $(this).children('span').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-sort');
												delete _sort[$(this).attr('data-id')];
                                            }
                                            else{
                                                $(this).addClass('sort-asc');
                                                $(this).children('span').removeClass('glyphicon-sort').addClass('glyphicon-triangle-top');
												_sort[$(this).attr('data-id')] = 'asc';
                                            }
                                            //$(this).siblings().removeClass('sort-asc').removeClass('sort-desc');
                                            //$(this).siblings().children('span').removeClass('glyphicon-triangle-top').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-sort');
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
					col.children('span').removeClass('glyphicon-sort').addClass('glyphicon-triangle-bottom');
				}
				else if(v == 'desc'){
					col.addClass('sort-desc');
					col.children('span').removeClass('glyphicon-sort').addClass('glyphicon-triangle-bottom');
				}
			}
		}
		this.reload();
		return $_this;
	};
}(jQuery));