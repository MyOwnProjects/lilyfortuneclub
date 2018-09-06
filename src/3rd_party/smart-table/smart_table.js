(function($){
	$.fn.smart_table = function(prop){//, header, url, customized_buttons, filter, row_count, order_by){
		var selected_data_id = 0;
		var total_rows = prop['total_rows'];
		var headers = prop['headers'];
		var columns = headers[headers.length - 1];
		var url = prop['url'];
		var summery = prop['summary'];
		var _this = this;
		var $_this = $(this);
		var $_main_menu = $('<div>').attr('tabindex', '0').addClass('smart-table-main-menu').appendTo($_main_table);
		var $_main_table = $('<table>').addClass('smart-table');
		var $_input_wrapper = $('<div>').addClass('editor-wrapper');
		var $_input = $('<input>').addClass('editor')./*attr('type', 'date').*/appendTo($_input_wrapper);
		var _selected_index_row;
		$_this.append($_main_table);
		var $_tr = $('<tr>').appendTo($_main_table);
		var $_td = $('<td>').addClass('header').addClass('header-c').addClass('header-r').appendTo($_tr);
		$_tr.append('<td class="space header-c"></td>');
		var get_data_id = function(){
			return $_main_table.children('tbody').children('tr').eq(_selected_index_row).attr('data-id');
		};
		var delete_row = function(data_id){
			$.ajax({
				url: url['delete'],
				method: 'post',
				data: {data_id: data_id},
				success: function(){
				},
				error: function(){
				},
				complete: function(){
				}
			});
		};
		
		var update_data = function(){
			if(_selected_index_row === undefined ){
				return false;
			}
			var $_tr = $_main_table.children('tbody').children('tr').eq(_selected_index_row);
			var data_id = $_tr.attr('data-id');
			var data = [];
			$_tr.children('td.editable').each(function(index, obj){
				data.push($(obj).text());
			});
			$.ajax({
				url: url['update'],
				method: 'post',
				data: {data_id: data_id, data: data},
				success: function(data){
					$_tr.attr('data-id', data);
				},
				error: function(){
				},
				complete: function(){
				}
			});
		};
		
		var calculate_summary = function($_td){
			var index_td = $_td.index();
			var sum = 0;
			$_main_table.children('tbody').children('tr').each(function(index, obj){
				var data_id = parseInt($(obj).attr('data-id'));
				if(data_id > 0){
					var v = parseInt($(obj).children('td:nth-child(' + (index_td + 1) + ')').text());
					sum += v;
				}
			});
			return sum;
		};
		
		for(var j = 0; j < columns.length; ++j){
			var $_td = $('<td>').addClass('header').addClass('header-c').appendTo($_tr);
			if(columns[j]['width']){
				$_td.css('min-width', columns[j]['width']);
			}
			$_td.html(String.fromCharCode(65 + j)).resizable({handles:'e'});
		}
		for(var i = 0; i < headers.length; ++i){
			var $_tr = $('<tr>').addClass('c-header').attr('data-id', 0).appendTo($_main_table);
			var $_td = $('<td>').addClass('header').addClass('header-r').html(' ').appendTo($_tr);
			$_tr.append('<td class="space"></td>');
			var c = headers[i];
			for(var j = 0; j < c.length; ++j){
				var $_td = $('<td>').addClass('header-c').html(c[j]['header']).appendTo($_tr);
				if(c[j]['col_span']){
					$_td.attr('colspan', c[j]['col_span']);
				}
			}
		}
		
		$_this.load = function(){		
			var sel = '';
			for(var i = 1; i <= headers.length; ++i){
				sel += ':not(:nth-child(' + (i + 1) + '))';
			}
			$_main_table.find('tr:not(:nth-child(1))' + sel).remove();
			ajax_loading(true);
			$.ajax({
				url: url['get'],
				dataType: 'json',
				success: function(data){
					if(data){
						var has_total = false;
						for(var i = 0; i < data.length; ++i){
							var row = data[i];
							var $_tr = $('<tr>').attr('data-id', row[0]).appendTo($_main_table);
							var $_td = $('<td>').addClass('header-r').html(i + 1).appendTo($_tr);
							$_tr.append('<td class="space"></td>');
							for(var j = 1; j < row.length; ++j){
								var $_td = $('<td>').addClass(columns[j - 1]['editable'] ? 'editable' : '').html(row[j]).appendTo($_tr);
								if(columns[j - 1]['text_align']){
									$_td.css('text-align', columns[j - 1]['text_align']);
								}
								if(columns[j - 1]['summary']){
									has_total = true;
								}
							}
						}
						if(has_total){
							var $_tr = $('<tr>').attr('data-id', row[0]).appendTo($_main_table);
							var $_td = $('<td>').addClass('header-r').html(i + 1).appendTo($_tr);
							$_tr.append('<td class="space"></td>');
							for(var i = 0; i < columns.length; ++i){
								var $_td = $('<td>').appendTo($_tr);
								if(i == 0){
									$_td.html('Total');
								}
								else{
									if(columns[i]['summary']){
										$_td.html(calculate_summary($_td));
									}
								}
								if(columns[i]['text_align']){
									$_td.css('text-align', columns[i]['text_align']);
								}
							}
						}
						if(total_rows !== undefined){
							for(var i = has_total ? data.length + 1 : data.length; i < total_rows; ++i){
								var $_tr = $('<tr>').attr('data-id', -1).appendTo($_main_table);
								var $_td = $('<td>').addClass('header-r').html(i + 1).appendTo($_tr);
								$_tr.append('<td class="space"></td>');
								for(var j = 0; j < columns.length; ++j){
									var $_td = $('<td>').appendTo($_tr);
									if(columns[j]['editable']){
										$_td.addClass('editable').html('');
									}
								}							
							}
						}
						$_this.find('td.header-r').outerHeight(26).resizable({handles:'s', minHeight:26});
					}
					ajax_loading(false);
				},
				error: function(){
					ajax_loading(false);
				},
				complete: function(){
					ajax_loading(false);
				}
			});
		};
		
		$_this.delegate('.editor-wrapper', 'click', function(e){
			e.stopPropagation();
		});
		$_this.delegate('.header-r', 'click', function(){
			$(this).parent().siblings().removeClass('selected-row');
			$_input_wrapper.remove();
			$_this.find('.active-cell').removeClass('active-cell').html($_input.val());
			if($(this).parent().is(':first-child, :nth-child(2)')){
				return false;
			}
			$(this).parent().addClass('selected-row');
		});
		
		document.addEventListener("keyup", function(event) {
			return;
			var $_tr = $_this.find('.selected-row');
			if($_tr.length == 1 && event.which == 46){
				var data_id = $_tr.attr('data-id');
				if(data_id == -1){
					return false;
				}
				delete_row(data_id);
				$_tr.removeClass('selected-row');
				
				while(!$_tr.is(':last-child')){
					var $_next = $_tr.next();
					$_tr.attr('data-id', $_next.attr('data-id'));
					for(var i = 0; i < columns.length; ++i){
						$_tr.children('td:nth-child(' + (i + 3) + ')').html($_next.children('td:nth-child(' + (i + 3) + ')').text());
					}
					$_tr = $_next;
				}
				$_tr.attr('data-id', '-1');
				for(var i = 0; i < columns.length; ++i){
					$_tr.children('td:nth-child(' + (i + 3) + ')').html('');
				}
			}
		});
		$_this.delegate('.editable', 'click', function(){
			$_this.find('.selected-row').removeClass('selected-row');
			$_input_wrapper.remove();
			$_this.find('.active-cell').removeClass('active-cell').html($_input.val());
			var self = $(this);
			var new_index_row = self.parent().index();
			if(_selected_index_row != new_index_row){
				update_data();
				_selected_index_row = new_index_row;
			}
			
			$_input.innerWidth($(this).innerWidth() - 10);
			$_input.innerHeight($(this).innerHeight());
			var value = self.text();
			self.html('');
			self.addClass('active-cell');
			$_input.val(value);
			self.append($_input_wrapper);
			$_input.focus();
			if($_input.setSelectionRange){
				$_input.setSelectionRange(0, $_input.val().length);
			}
			else{
				$_input.select();
			}
			return false;
		});
		$_this.click(function(e){
			//alert(selected_data_id);
			$_input_wrapper.remove();
			$_this.find('.active-cell').removeClass('active-cell').html($_input.val());
			if(!$(e.target).hasClass('header-r')){
				$_this.find('.selected-row').removeClass('selected-row');
			}
			update_data();
			_selected_index_row = undefined;
			return false;
		});
		
		$_this.load();
		
		return $_this;
	};
}(jQuery));