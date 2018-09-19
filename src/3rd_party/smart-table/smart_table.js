(function($){
	$.fn.smart_table = function(prop){//, header, url, customized_buttons, filter, row_count, order_by){
		var changed_cell_list = [];
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
		var total_tr;
		var $_last_selected_cell;
		$_this.append($_main_table);
		var $_tr = $('<tr>').appendTo($_main_table);
		var $_td = $('<td>').addClass('header').addClass('header-c').addClass('header-r').appendTo($_tr);
		var timeout_callback;
		$_tr.append('<td class="space header-c"></td>');
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
		
		var update_data = function(value){
			if($_last_selected_cell === undefined ){
				return false;
			}
			var $_tr = $_last_selected_cell.parent();//$_main_table.children('tbody').children('tr').eq(_selected_index_row);
			var data_id = $_tr.attr('data-id');
			var index = $_last_selected_cell.index() - 2;
			if(!columns[index]['id']){
				return false;
			}
			$.ajax({
				url: url['update'],
				method: 'post',
				data: {data_id: data_id, field: columns[index]['id'], value: value === undefined ? $_last_selected_cell.text() : value},
				success: function(data){
					$_tr.attr('data-id', data);
				},
				error: function(){
				},
				complete: function(){
				}
			});
			calculate_summary();
		};
		
		var calculate_summary = function(){
			if(!total_tr){
				return;
			}
			var sum = {};
			var sum_index = [];
			for(var i = 0; i < columns.length; ++i){
				if(columns[i]['summary']){
					sum[i] = 0;
					sum_index.push(i);
				}
			}
			var sel = ':not(:nth-child(1))';
			for(var i = 1; i <= headers.length; ++i){
				sel += ':not(:nth-child(' + (i + 1) + '))';
			}
			total_tr.siblings(sel).each(function(index, obj){
				for(var i = 0; i < sum_index.length; ++i){
					var $_td = $(obj).children('td:nth-child(' + (sum_index[i] + 3) + ')');
					var t = $_td.text();
					var v = parseInt(t);
					if(!isNaN(v)){
						sum[sum_index[i]] += v;
					}
				}
			});
			for(var i = 0; i < sum_index.length; ++i){
				var v = sum[sum_index[i]];
				total_tr.children('td:nth-child(' + (sum_index[i] + 3) + ')').html(v);
			}
		};
		
		for(var j = 0; j < columns.length; ++j){
			var $_td = $('<td>').addClass('header').addClass('header-c').appendTo($_tr);
			if(columns[j]['width']){
				$_td.css('min-width', columns[j]['width']);
			}
			if(columns[j]['id']){
				$_td.attr('data-id', columns[j]['id']);
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
				if(c[j]['css']){
					for(var prop in c[j]['css']){
						$_td.css(prop, c[j]['css'][prop]);
					}
				}
			}
		}
		
		var callback = function(){
			$.ajax({
				url: url['get'],
				dataType: 'json',
				success: function(data){
					if(data){
						for(var i = 0; i < columns.length; ++i){
							if(columns[i]['auto_refresh']){
								$_main_table.children('tbody').children('.row-value').each(function(index, obj){
									$(obj).children('td:nth-child(' + (i + 3) + ')').html(data[index][i + 1]);
								});
							}
						}
					}
					timeout_callback = setTimeout(callback, 1000);
				},
				error: function(){
					clearTimeout(timeout_callback, 1000);
				}
			});
		};
		
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
						var tab_index = 0;
						var has_total = false;
						for(var i = 0; i < data.length; ++i){
							var row = data[i];
							var $_tr = $('<tr>').attr('data-id', row[0]).addClass('row-value').appendTo($_main_table);
							var $_td = $('<td>').addClass('header-r').html(i + 1).appendTo($_tr);
							$_tr.append('<td class="space"></td>');
							for(var j = 1; j < row.length; ++j){
								var $_td = $('<td>').addClass(columns[j - 1]['editable'] ? 'editable' : '').html(row[j]).appendTo($_tr);
								if(columns[j - 1]['editable']){
									$_td.attr('tab-index', tab_index++);
								}
								if(columns[j - 1]['css']){
									for(var prop in columns[j - 1]['css']){
										$_td.css(prop, columns[j - 1]['css'][prop]);
									}
								}
								if(columns[j - 1]['summary']){
									has_total = true;
								}
							}
						}
						if(has_total){
							total_tr = $('<tr>').attr('data-id', row[0]).appendTo($_main_table);
							var $_td = $('<td>').addClass('header-r').html(i + 1).appendTo(total_tr);
							total_tr.append('<td class="space"></td>');
							for(var i = 0; i < columns.length; ++i){
								var $_td = $('<td>').appendTo(total_tr);
								if(i == 0){
									$_td.html('Total');
								}
								if(columns[i]['css']){
									for(var prop in columns[i]['css']){
										$_td.css(prop, columns[i]['css'][prop]);
									}
								}
							}
							calculate_summary();
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
						
						timeout_callback = setTimeout(callback, 1000);
					}
					ajax_loading(false);
				},
				error: function(){
					if(timeout_callback){
						clearTimeout(timeout_callback);
					}
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
			if($(this).parent().is(':first-child') || 
				$(this).parent().hasClass('c-header')){
				return false;
			}
			$(this).parent().addClass('selected-row');
		});
		
		/*document.addEventListener("keyup", function(event) {
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
		});*/
		$_this.delegate('.editable', 'click', function(){
			$_this.find('.selected-row').removeClass('selected-row');
			$_input_wrapper.remove();
			$_this.find('.active-cell').removeClass('active-cell').html($_input.val());
			var self = $(this);
			if(self != $_last_selected_cell){
				update_data();
				$_last_selected_cell = self; 
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
		
		$_this.delegate($_input, 'keyup', function(e){
			update_data($_input.val());
		}).keydown(function(e){
			var index = $_input.parent().parent().index();
			var $_td = $_input.parent().parent();
			var	$_tr = $_td.parent();
			var $_new_td;
			if(e.which == 38){
				while(!$_tr.is(':first-child')){
					if($_tr.prev().children('td:nth-child(' + (index + 1) + ')') && 
						$_tr.prev().children('td:nth-child(' + (index + 1) + ')').hasClass('editable')){
						$_new_td = $_td.parent().prev().children('td:nth-child(' + (index + 1) + ')');
						break;
					}
					$_tr = $_tr.prev();
				}
			}
			else if(e.which == 40){
				while(!$_tr.is(':last-child')){
					if($_tr.next().children('td:nth-child(' + (index + 1) + ')') && 
						$_tr.next().children('td:nth-child(' + (index + 1) + ')').hasClass('editable')){
						$_new_td = $_td.parent().next().children('td:nth-child(' + (index + 1) + ')');
						break;
					}
					$_tr = $_tr.next();
				}
			}
			else if(e.which == 9){
				var tab_index = parseInt($_td.attr('tab-index'));
				var $_next_td = $_main_table.find('td[tab-index=' + (tab_index + 1) + ']');
				if($_next_td.length == 1){
					$_new_td = $_next_td;
				}
			}
			if($_new_td){
				$_new_td.click();
				$_input.focus();
				if($_input.setSelectionRange){
					$_input.setSelectionRange(0, $_input.val().length);
				}
				else{
					$_input.select();
				}
			}
			return e.which != 9 && e.which != 40 && e.which != 38;
		});
		
		$('body').click(function(e){
			$_input_wrapper.remove();
			$_this.find('.active-cell').removeClass('active-cell').html($_input.val());
			if(!$(e.target).hasClass('header-r')){
				$_this.find('.selected-row').removeClass('selected-row');
			}
			update_data();
			$_last_selected_cell = undefined;
			//return false;
		});
		
		$_this.load();
		
		return $_this;
	};
}(jQuery));