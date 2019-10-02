(function($){
	$.fn.file_browser = function(prop){
		var url = prop['get_files'];
		var root = prop['root'];
		var upload_url = prop['upload_files'];
		var delete_url = prop['delete_file'];
		var rename_url = prop['rename_file'];
		var header = ['name', 'size', 'date_create'];
		var _this = this;
		var $_this = $(this);
		$_this.attr('id', 'qaz');
		var update_view = function(path, index, level, data){
			var count = 0;
			for(var i = 0; i < data.length; ++i){
				++count;
				var type_class = 'file-browser-item-file';
				var ext = data[i]['ext'].toLowerCase();
				if(data[i]['type'] == 'dir'){
					type_class = 'file-browser-item-folder';
				}
				else{
					if(ext == 'pdf'){
						type_class = 'file-browser-item-pdf';
					}
					else if(ext == 'ppt' || ext == 'pptx'){
						type_class = 'file-browser-item-ppt';
					}
					else if(ext == 'xls' || ext == 'xlsx'){
						type_class = 'file-browser-item-xls';
					}
					else if(ext == 'doc' || ext == 'docx'){
						type_class = 'file-browser-item-doc';
					}
					else if(ext == 'mp4'){
						type_class = 'file-browser-item-mp4';
					}
					else if(ext == 'png'){
						type_class = 'file-browser-item-png';
					}
					else{
						type_class = 'file-browser-item-file';
					}
				}
				var size = parseInt(data[i]['size']);
				if( size >= 1000000){
					size = Math.floor(size / 1000000) + 'M';
				}
				else if (size >= 1000){
					size = Math.floor(size / 1000) + 'K';
				}
				
				var d = [];
				d[0] = $('<div>').addClass('file-browser-item').addClass('clearfix').addClass(data[i]['type'] == 'dir' ? 'file-browser-item-clickable' : '').addClass('text-center');
				d[1] = $('<div>').addClass('file-browser-item').addClass('clearfix').addClass('file-browser-item-l' + level)
					.attr('data-level', level).attr('data-name', data[i]['name'])
					.attr('data-folder', path)
					.addClass(data[i]['type'] == 'dir' ? 'file-browser-item-clickable' : '')
					.addClass(type_class)
					.attr('data-ext', ext)
					.append(data[i]['name']);
				d[2] = $('<div>').addClass('file-browser-item').addClass('clearfix').addClass(data[i]['type'] == 'dir' ? 'file-browser-item-clickable' : '').html(size);
				d[3] = $('<div>').addClass('file-browser-item').addClass('clearfix').addClass(data[i]['type'] == 'dir' ? 'file-browser-item-clickable' : '').html(data[i]['ctime']);
				for(var j = 0;j < d.length; ++j){
					if(index < 0){
						d[j].appendTo($('.file-browser-col:nth-child(' + (j + 1) + ')'));
					}
					else{
						d[j].insertAfter($('.file-browser-col:nth-child(' + (j + 1) + ') .file-browser-item:nth-child(' + (index) + ')'));
					}
				}
			}
			return count;
		};
		
		var load = function(ele, path, index, level){
			if(ele){
				ele.addClass('file-browser-item-loading');
			}
			$.ajax({
				url: url,
				data: {path: path, sort: index < 0 ? 0 : 1},
				method: 'post',
				dataType: 'json',
				success: function(resp){
					var count = 0;
					if(index < 0){
						count += update_view(path, index, level, resp['folders']);
						count += update_view(path, index, level, resp['files']);
					}
					else{
						count += update_view(path, index, level, resp['files']);
						count += update_view(path, index, level, resp['folders']);
					}
					if(index > 0 && count > 0){
						$('.file-browser-col:nth-child(2) .file-browser-item:nth-child(' + index + ')').addClass('file-browser-item-expanded');
					}
					return false;
				},
				error: function(a, b, c){
					return false;
				},
				complete: function(){
					if(ele){
						ele.removeClass('file-browser-item-loading');
					}
				}
			});
		};
		
		var upload_files = function(droppedFiles, dest){
			var overwrite_list = [];
			var dest_path = dest.join('/');
			for(var i = 0; i < droppedFiles.length; ++i){
				var file_name = droppedFiles[i].name.toLowerCase();
				$('.file-browser-item').each(function(){
					if($(this).attr('data-folder') == dest_path && $(this).attr('data-name').toLowerCase() == file_name){
						overwrite_list.push(file_name);
						return false;
					}
				});
			}
			if(overwrite_list.length > 0){
				if(!window.confirm('Do you want to overwrite ' +  overwrite_list.join(', ') + '?')){
					return false;
				}
			}
			ajax_loading(true);
			var ajaxData = new FormData();
			for(var i = 0; i < droppedFiles.length; ++i){
				ajaxData.append('uploaded[]', droppedFiles[i]);
			}
			ajaxData.append('path', dest_path);
			$.ajax({
				xhr: function() {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(evt) {
						if (evt.lengthComputable) {
							var percentComplete = evt.loaded / evt.total;
							percentComplete = parseInt(percentComplete * 100);
							console.log(percentComplete + '%');
						}
					}, false);
					return xhr;
				},
				url: upload_url,
				type: "POST",
				data: ajaxData,
				processData: false,
				contentType: false,
				dataType: "json",
				success: function(result) {
					$('.file-browser-item-folder').each(function(){
						var o = $(this);
						if(o.attr('data-folder') == dest[0] && o.attr('data-name') == dest[1]){
							if(click_folder($(this)) == 'collapsed'){
								click_folder($(this));
							}
							return false;
						}
					});
					return false;
				},
				error: function(){
				},
				complete: function(){
					ajax_loading(false);
				}
			});
		};
		
		var click_folder = function(ele){			
			var index = ele.parent().children().index(ele);
			++index;
			var d = $('.file-browser-col:nth-child(2) .file-browser-item:nth-child(' + index + ')');
			if(d.hasClass('file-browser-item-expanded')){
				if(d.next()){
					var level = parseInt(d.attr('data-level'));
					var next_level = parseInt(d.next().attr('data-level'));
					while(next_level > level && d.next()){
						$('.file-browser-item:nth-child(' + (index + 1) + ')').remove();
						
						next_level = parseInt(d.next().attr('data-level'));
					}
				}
				d.removeClass('file-browser-item-expanded');
				return 'collapsed';
			}
			var name = d.attr('data-name');
			var folder = d.attr('data-folder');
			var level = parseInt(d.attr('data-level'));
			load(d, folder + '/' + name, index, level + 1);
			return 'expended';
		};
		
		$($_this).delegate('.file-browser-item', 'hover', function(e){
			var ele = $(this);
			var index = ele.parent().children().index(ele);
			++index;
			var fe = $('.file-browser-col:first-child .file-browser-item:nth-child(' + index + ')');
			if( e.type === 'mouseenter' ){  
				$('.file-browser-item:nth-child(' + index + ')').css('background-color', '#f5f5f5');
				if(!$('.file-browser-col:nth-child(2) .file-browser-item:nth-child(' + index + ')').hasClass('file-browser-item-folder')){
					//$('<i>').attr('title', 'change name').addClass('icon-change').addClass("fa").addClass("fa-pencil-square-o").attr("aria-hidden", "true").appendTo(fe);
					//$('<i>').attr('title', 'delete').addClass('icon-delete').addClass("fa").addClass("fa-times").attr("aria-hidden", "true").appendTo(fe);
					$('<div>').attr('title', 'change name').addClass('file-browser-item-icon').addClass('icon-change').appendTo(fe);
					$('<div>').attr('title', 'delete').addClass('file-browser-item-icon').addClass('icon-delete').appendTo(fe);
				}
			}
			else{
				$($('.file-browser-item:nth-child(' + index + ')')).css('background-color', '#FFF');
				fe.children('.icon-delete, .icon-change').remove();
			}
		}).delegate('.file-browser-item-clickable', 'click', function(e){
			click_folder($(this));
		}).delegate('.file-browser-item', 'dragenter', function(e){
			e.stopPropagation();
			e.preventDefault();
			var ele = $(this);
			var index = ele.parent().children().index(ele);
			++index;
			$('.file-browser-item:nth-child(' + (index) + ')').addClass('file-browser-drop-target');
		}).delegate('.file-browser-item', 'dragover', function(e){
			e.stopPropagation();
			e.preventDefault();
			e.originalEvent.dataTransfer.dropEffect = 'upload'; // Explicitly show this is a copy.
		}).delegate('.file-browser-item', 'dragleave', function(e){
			e.stopPropagation();
			e.preventDefault();
			var ele = $(this);
			var index = ele.parent().children().index(ele);
			++index;
			$('.file-browser-item:nth-child(' + (index) + ')').removeClass('file-browser-drop-target');
		}).delegate('.file-browser-item', 'drop', function(e){
			e.stopPropagation();
			e.preventDefault();
			
			if (window.File && window.FileReader && window.FileList && window.Blob) {
				var ele = $(this);
				var index = ele.parent().children().index(ele);
				++index;
				var cele = $('.file-browser-col:nth-child(2) .file-browser-item:nth-child(' + (index) + ')');
				var path = [];
				if(cele.hasClass('file-browser-item-folder')){
					path.push(cele.attr('data-folder'));
					path.push(cele.attr('data-name'));
				}
				else{
					var prev = cele.prev();
					var level = parseInt(cele.attr('data-level'));
					while(prev){
						if(prev.hasClass('file-browser-item-folder') && parseInt(prev.attr('data-level')) == level - 1){
							path.push(prev.attr('data-folder'));
							path.push(prev.attr('data-name'));
							break;
						}
						prev = prev.prev();
					}
				}
				upload_files(e.originalEvent.dataTransfer.files, path);
			} 
			else {
				alert('The File APIs are not fully supported in this browser.');
			}
			
		}).delegate('.file-browser-item-icon', 'click', function(){
			var ele = $(this);
			var index = ele.parent().parent().children().index(ele.parent());
			++index;
			var mele = $('.file-browser-col:nth-child(2) .file-browser-item:nth-child(' + index + ')');
			var name = mele.attr('data-name').substring(0, mele.attr('data-name').length - mele.attr('data-ext').length - 1);
			if(ele.hasClass('icon-change')){
				var new_name = window.prompt('Enther the new name (no extension):', name);
				if(new_name === null || name == new_name){
				}
				else{
					var find = false;
					new_name = new_name + '.' + mele.attr('data-ext');
					mele.siblings('.file-browser-item').each(function(){
						if($(this).attr('data-name') == new_name){
							bootbox.alert("New name already exists.");
							find = true;
							return false;
						}
					});
					if(!find){
						$.ajax({
							url: rename_url,
							method: 'post',
							data: {old: mele.attr('data-folder') + '/' + mele.attr('data-name'), new: mele.attr('data-folder') + '/' + new_name},
							dataType: 'json',
							success: function(resp){
							},
							error: function(a, b, c){
							},
							complete: function(){
							}
						});
						mele.attr('data-name', new_name).html(new_name);
					}
				} 
			}
			else if(ele.hasClass('icon-delete')){
				bootbox.confirm("Do you want to delete " + mele.attr('data-name') + "?", function(c){ 
					if(c){
						$.ajax({
						url: delete_url,
						method: 'post',
						data: {file: mele.attr('data-folder') + '/' + mele.attr('data-name')},
						dataType: 'json',
						success: function(resp){
							$('.file-browser-item:nth-child(' + index + ')').remove();
						},
						error: function(a, b, c){
						},
						complete: function(){
						}
						});					
					} 
				});
				
				/*if(bootbox.confirm("Do you want to delete " + mele.attr('data-name') + "?")){
					$.ajax({
						url: delete_url,
						method: 'post',
						data: {file: mele.attr('data-folder') + '/' + mele.attr('data-name')},
						dataType: 'json',
						success: function(resp){
							$('.file-browser-item:nth-child(' + index + ')').remove();
						},
						error: function(a, b, c){
						},
						complete: function(){
						}
					});
				}*/
			}
		});
		
		$_this.addClass('file-browser').addClass('clearfix');
		//$('<div>').addClass('file-browser-toolbar').html('&nbsp;').appendTo($_this);
		var col = $('<div>').addClass('file-browser-col').appendTo($_this);
		var col_header = $('<div>').addClass('file-browser-header').addClass('text-center').html('&nbsp;').appendTo(col);
		for(var i = 0; i < header.length; ++i){
			var col = $('<div>').addClass('file-browser-col').appendTo($_this);
			var col_header = $('<div>').addClass('file-browser-header').html(header[i]).appendTo(col);
		}
		load(null, root, -1, 1);
		return $_this;
	};
}(jQuery));
