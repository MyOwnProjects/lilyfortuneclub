(function($){
	$.fn.tree_grid = function(header, loading_url){//nodes = [['text','view', 'child_count', 'child_url'], [], []...]
		var tree_node_icon_down = 'glyphicon-menu-down';
		var tree_node_icon_right = 'glyphicon-menu-right';
		var _this = this;
		var $_this = $(this);
		$_this.addClass('tree-grid');
			var $_div = $('<div>').html(header ? '<label>' + header + '</label>' : '');
			var $_head = $('<li>').append($_div).appendTo($_this);
			this.load_children = function(parent, ajax_url){
				parent.find('.'+ tree_node_icon_right + ', .glyphicon-unchecked').removeClass(tree_node_icon_right).removeClass('glyphicon-unchecked').addClass(tree_node_icon_down); 
				var $_ul_parent = $('<ul>').appendTo(parent);
				var $_loading = $('<div>').addClass('loading');
				var $_li_loading = $('<li>').html($_loading).appendTo($_ul_parent);
				$.ajax({
					url: ajax_url,
					dataType: 'json',
					success: function(data){
						if(data['success'] === true){
							if(Array.isArray(data['data'])){
								$_ul_parent.empty();
								var children = data['data'];
								for(i = 0; i < children.length; ++i){
									var node = children[i];
									var $_li = $('<li>').appendTo($_ul_parent);
									if(node['child_count'] && node['child_url']){
										var $_node_text = $('<span>').html(node['text']);
										var $_leaf_icon = $('<div>').addClass('tree-node-icon').addClass('glyphicon').attr('data-url', node['child_url']);
										$_leaf_icon.addClass(tree_node_icon_right);
										if(node['child_count'] == 0){
											$_leaf_icon.css('visibility', 'hidden').attr('data-url', node['child_url']);
										}
										var $_div = $('<div>').append($_leaf_icon).append($_node_text);
										var $_node_text = $('<div>').html(node['text']);
										var $_div = $('<div>').addClass('clearfix').addClass('tree-row').append($_leaf_icon).append($_node_text);
										$_li.append($_div);
									}
									else{
										var $_node_text = $('<div>').html(node['text']);
										var $_div = $('<div>').addClass('clearfix').addClass('tree-row').append($_node_text);
										$_li.append($_div);
									}
									$_ul_parent.append($_li);
								}
							}
							else{
								var $_alert = $('<div>').addClass('alert'). addClass('alert-info').html(data['data']);
								$_li_loading.empty().append($_alert);
							}
						}
						else{
							var $_alert = $('<div>').addClass('alert'). addClass('alert-danger').html(data['message']);
							$_li_loading.empty().append($_alert);
						}
					},
					error: function(a, b, c){
						var $_alert = $('<div>').addClass('alert'). addClass('alert-danger').html(a.responseText);
						$_li_loading.empty().append($_alert);
					}
				});
			};
                                    
			this.delegate('.' + tree_node_icon_right + ', .glyphicon-unchecked', 'click', function(){
				var $_parent = $(this).parent().parent();
				_this.load_children($_parent, $(this).attr('data-url'));
			}).delegate('.' + tree_node_icon_down, 'click', function(){
				$(this).removeClass(tree_node_icon_down).addClass(tree_node_icon_right).parent().next('ul').remove();
			});
                                    
			this.load_children($_head,loading_url);
		return $_this;
	};
}(jQuery));