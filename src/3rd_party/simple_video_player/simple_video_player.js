

(function($){
	$.fn.simple_video_player = function(prop){
		var _timer;
		var _this = this;
		var $_this = $(this);
		$_this.css('position', 'relative').css('width', '100%').css('background', '#000').outerHeight($_this.outerWidth() * 9 / 16);
		var original_size = {width: $_this.outerWidth(), height: $_this.outerHeight()};
		var $_video = $('<video>').attr('preload', 'auto').css('z-index', '1').appendTo($_this).contextmenu(function(){
			return false;
		}).appendTo($_this);
		var _control_height = '40px';
		var _captions = {};
		if(prop['captions']){
			for(var i = 0; i < prop['captions'].length; ++i){
				var start = prop['captions'][i][0];
				var end = prop['captions'][i][1];
				for(var j = start; j <= end; ++j){
					_captions[j] = prop['captions'][i][2];
				}
			}
		}
		var _video = $_video[0];
		if(prop['duration'] && prop['duration'].length > 0){
			for(var i = 0; i < prop['duration'].length; ++i){
				prop['duration'][i] = parseInt(prop['duration'][i]);
			}
		}
		var pause = function(){
			_video.pause();
			$_control_bar.slideDown();
		};
		
		var is_full_screen = function(){
			return document.fullscreenElement ||
				document.webkitFullscreenElement ||
				document.mozFullScreenElement ||
				document.msFullscreenElement;
		};
		
		var $_source = $('<source>').appendTo($_video);
		var $_caption = $('<div>').css('background', '#000').css('opacity', '0.8').css('padding', '5px').css('position','absolute').css('z-index', '5').css('bottom','40px').css('left','20%').css('right','20%')
			.css('text-align', 'center').css('color', '#fff').css('font-size', '18px').hide().appendTo($_this);
		var $_control_bar = $('<div>').css('background', 'rgba(0,0,0, 0.6)').css('color', '#fff').css('position','absolute').css('z-index', '10').css('bottom','0').css('left','0').css('right','0')
			/*.css('border', '1px solid #d5d5d5')*/.css('margin-top', '-5px').css('padding-right', '5px').css('overflow', 'auto')
			.appendTo($_this);
		var $_loading = $('<div>').css('z-index', 7).css('background', '#000').css('opacity', '0.9').css('color', '#fff')
			.css('text-align', 'center').css('position', 'absolute').css('top', 0).css('right', 0).css('bottom', 0)
			.css('left', 0).html('<table style="width:100%;height:100%"><tr><td style="vertical-align:middle;text-align:center"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i></tr></td></table>').hide().appendTo($_this);	
		var $_play_button = $('<div>').addClass('no-select').css('border-radius', '3px').css('text-align', 'center').css('border-radius', '2px').css('cursor', 'pointer')
			.outerHeight('26px').css('font-size', '18px').css('line-height', '26px').css('float', 'left').outerWidth('26px').css('margin', '7px 0 0 10px').addClass('play')
			.click(function(){
				click_play_button();
			}).mouseenter(function(){
				$(this).css('background','red');
			}).mouseleave(function(){
				$(this).css('background','none');
			}).appendTo($_control_bar);
		var $_full_screen_button = $('<div>').addClass('no-select').css('float', 'right').css('text-align', 'center').css('border-radius', '2px').css('cursor', 'pointer')
			.css('line-height', _control_height).css('width',_control_height).css('height',_control_height).addClass('play').attr('title', 'Full screen').html('<i class="fa fa-expand" aria-hidden="true"></i>')
			.click(function(){
				if (_this[0].requestFullscreen) {
					if(!is_full_screen()){
						_this[0].requestFullscreen();
						$(this).attr('title', 'Exit full screen').html('<i class="fa fa-compress" aria-hidden="true"></i>');
					}
					else{
						document.exitFullscreen();
						$(this).attr('title', 'Full screen').html('<i class="fa fa-expand" aria-hidden="true"></i>');
					}
				}
				else if (_this[0].mozRequestFullScreen) {
					if(!is_full_screen()){
						_this[0].mozRequestFullScreen();
						$(this).attr('title', 'Exit full screen').html('<i class="fa fa-compress" aria-hidden="true"></i>');
					}
					else{
						document.mozCancelFullScreen();
						$(this).attr('title', 'Full screen').html('<i class="fa fa-expand" aria-hidden="true"></i>');
					}
				} 
				else if (_this[0].webkitRequestFullscreen) {
					if(!is_full_screen()){
						_this[0].webkitRequestFullscreen();
						$(this).attr('title', 'Exit full screen').html('<i class="fa fa-compress" aria-hidden="true"></i>');
					}
					else{
						document.webkitExitFullscreen();
						$(this).attr('title', 'Full screen').html('<i class="fa fa-expand" aria-hidden="true"></i>');
					}
				}
				else if (_this[0].msRequestFullscreen) {
					if(!is_full_screen()){
						_this[0].msRequestFullscreen();
						$(this).attr('title', 'Exit full screen').html('<i class="fa fa-compress" aria-hidden="true"></i>');
					}
					else{
						document.msExitFullscreen();
						$(this).attr('title', 'Full screen').html('<i class="fa fa-expand" aria-hidden="true"></i>');
					}
				}
			}).appendTo($_control_bar);	
		var $_progress_bar = $('<div>').addClass('clearfix').css('overflow', 'hidden').appendTo($_control_bar);
		var $_current = $('<div>').addClass('no-select').css('text-align', 'right').css('margin-right', '5px').css('font-size', '12px').css('line-height', _control_height)
			.css('float', 'left').css('height',_control_height)
			.css('width', '50px').appendTo($_progress_bar);
		var $_total = $('<div>').addClass('no-select').css('text-align', 'left').css('margin-left', '5px').css('font-size', '12px').css('line-height', _control_height)
			.css('float', 'right').css('height',_control_height).html('00:00').css('width', '50px').appendTo($_progress_bar);
		var $_progress = $('<div>').css('height',_control_height).css('overflow', 'hidden').css('position', 'relative').appendTo($_progress_bar);
		var _mouse_time = $('<div>').css('position', 'absolute').css('font-size', '12px').css('color', '#fff').hide().appendTo($_progress);
		var bh = 10;
		var $_progress_line_grey = $('<div>').addClass('progress-line-grey').css('position', 'absolute').css('z-index', 10).css('left', 0).css('right', 0)
			.css('height', bh + 'px').css('background', '#858585').css('cursor', 'pointer')
			.css('top', (parseInt(_control_height) - bh) / 2).click(function(e){
				var val = e.offsetX / $_progress_line_grey.outerWidth() * _video.duration;
				if(prop['duration'] && prop['duration'].length == 2 && 
					(val < prop['duration'][0] || val > prop['duration'][1])){
					if(prop['out_duration_callback']){
						prop['out_duration_callback']();
					}
					return;
				}
				_video.currentTime = val;
				update_current();
			}).mouseenter( function(e){
				var rate = e.offsetX / $_progress_line_grey.outerWidth();
				var val = convert_time_format(rate * _video.duration);
				_mouse_time.html(val);
				var left = e.offsetX - _mouse_time.outerWidth() / 2;
				if(left < 0){
					left = 0;
				}
				_mouse_time.css('left', (left * 100) + '%').show();
			}).mouseleave( function(e){
				_mouse_time.hide();
			}).mousemove( function(e){
				var rate = e.offsetX / $_progress_line_grey.outerWidth();
				var val = convert_time_format(rate * _video.duration);
				_mouse_time.html(val);
				var left = e.offsetX - _mouse_time.outerWidth() / 2;
				if(left < 0){
					left = 0;
				}
				_mouse_time.css('left', (rate * 100) + '%').show();
			}).appendTo($_progress);
		var $_progress_line_duration = $('<div>').css('position', 'absolute').css('z-index', 11).css('left', 0).css('width', 0)	
			.css('height', bh + 'px').css('background', '#eee').css('cursor', 'pointer')
			.css('top', (parseInt(_control_height) - bh) / 2).hide().click(function(e){
				var val = e.offsetX / $_progress_line_duration.outerWidth() * (prop['duration'][1]- prop['duration'][0]) + prop['duration'][0];
				_video.currentTime = val;
				update_current();
			}).mouseenter( function(e){
				var val = convert_time_format((e.offsetX + $(this).position().left) / $_progress_line_grey.outerWidth() * _video.duration);
				_mouse_time.html(val);
				var left = e.offsetX + $(this).position().left - _mouse_time.outerWidth() / 2;
				if(left < 0){
					left = 0;
				}
				_mouse_time.css('left', left + 'px').show();
			}).mouseleave( function(e){
				_mouse_time.hide();
			}).mousemove( function(e){
				var val = convert_time_format((e.offsetX + $(this).position().left) / $_progress_line_grey.outerWidth() * _video.duration);
				_mouse_time.html(val);
				var left = e.offsetX + $(this).position().left - _mouse_time.outerWidth() / 2;
				if(left < 0){
					left = 0;
				}
				_mouse_time.css('left', left + 'px').show();
			}).appendTo($_progress);
		var $_progress_line_color = $('<div>').css('position', 'absolute').css('z-index', 12).css('left', 0).css('width', '0')
			.css('height', bh + 'px').css('background', '#ff0000').css('cursor', 'pointer')
			.css('top', (parseInt(_control_height) - bh) / 2).click(function(e){
				var val = e.offsetX / $_progress_line_grey.outerWidth() * _video.duration;
				if(prop['duration'] && prop['duration'].length == 2){
					val += prop['duration'][0];
					if(val < prop['duration'][0] || val > prop['duration'][1]){
						if(prop['out_duration_callback']){
							prop['out_duration_callback']();
						}
						return;
					}
				}
				_video.currentTime = val;
				update_current();
			}).mouseenter( function(e){
				var val = convert_time_format((e.offsetX + $(this).position().left) / $_progress_line_grey.outerWidth() * _video.duration);
				_mouse_time.html(val);
				var left = e.offsetX + $(this).position().left - _mouse_time.outerWidth() / 2;
				if(left < 0){
					left = 0;
				}
				_mouse_time.css('left', left + 'px').show();
			}).mouseleave( function(e){
				_mouse_time.hide();
			}).mousemove( function(e){
				var val = convert_time_format((e.offsetX + $(this).position().left) / $_progress_line_grey.outerWidth() * _video.duration);
				_mouse_time.html(val);
				var left = e.offsetX + $(this).position().left - _mouse_time.outerWidth() / 2;
				if(left < 0){
					left = 0;
				}
				_mouse_time.css('left', left + 'px').show();
			}).appendTo($_progress);
			
		var click_play_button = function(){
			if(_video.paused){
				if(prop['duration'] && prop['duration'].length == 2 && 
					(_video.currentTime < prop['duration'][0] || _video.currentTime > prop['duration'][1])){
					if(_timer)
						clearTimeout(_timer);
					pause();
					$_play_button.html('&#9658');
					update_progress_bar();
					update_caption();
					if(prop['out_duration_callback']){
						prop['out_duration_callback']();
					}
					
					return;
				}
				$_play_button.attr('title', 'Pause').html('&#10074;&#10074;');
				_video.play();
				_timer = setTimeout(update_current, 10);
			}
			else{
				clearTimeout(_timer);
				$_play_button.attr('title', 'Play').html('&#9658');
				pause();
			}
		};
		
		var update_play_button = function(){
			if(_video.paused)
				$_play_button.html('&#9658;');
			else
				$_play_button.html('&#10074;&#10074;');
		};
		
		var update_video_size = function(){
			if(is_full_screen()){
				$_this.css('height', '100%');
				if(_video.videoWidth / _video.videoHeight > screen.width / screen.height){
					$_video.css('width', '100%');
					$_video.css('margin', ($_video.parent().innerHeight() - $_video.outerHeight()) / 2 + 'px' + ' 0');
				}
				else{
					$_video.css('height', '100%');
					$_video.css('margin', '0 ' + ($_video.parent().innerWidth() - $_video.outerWidth()) / 2 + 'px');
				}
			}
			else{
				//$_this.outerWidth(original_size['width']);
				$_this.outerHeight($_this.outerHeight($_this.outerWidth() * 9 / 16));
				if(_video.videoWidth / _video.videoHeight > $_this.innerWidth() / $_this.innerHeight()){
					$_video.css('width', '100%');
					$_video.css('margin', ($_video.parent().innerHeight() - $_video.outerHeight()) / 2 + 'px' + ' 0');
				}
				else{
					$_video.css('height', '100%');
					$_video.css('margin', '0 ' + ($_video.parent().innerWidth() - $_video.outerWidth()) / 2 + 'px');
				}
			}
		};
		
		_video.onloadeddata = function() {
			$_this.mouseenter(function(){
				if(!_video.paused){
					$_control_bar.slideDown();
				}
			}).mouseleave(function(){
				if(!_video.paused){
					$_control_bar.slideUp();
				}
			});
			update_video_size();
			/*if(_video.videoWidth / _video.videoHeight > $_this.innerWidth() / $_this.innerHeight()){
				$_video.css('width', '100%');//outerWidth($_video.parent().innerWidth() + 'px');
				//$_video.css('margin-top', ($_video.parent().innerHeight() - $_video.outerHeight()) / 2 + 'px');
			}
			else{
				$_video.css('height', '100%');//outerHeight($_video.parent().innerHeight() + 'px');
				//$_video.css('margin-left', ($_video.parent().innerWidth() - $_video.outerWidth()) / 2 + 'px');
			}*/
			//$_source.removeAttr('src');
			$_current.html(convert_time_format(0));
			$_total.html(convert_time_format(_video.duration));
			if($.isFunction(prop['loaded'])){
				prop['loaded']();
			}
			$_play_button.addClass('active').html('&#9658');
			if(prop['duration'] && prop['duration'] && prop['duration'].length == 2){
				_video.currentTime = prop['duration'][0];
				update_progress_bar();
				update_caption();
			}
			setInterval(update_play_button, 100);
			if(prop['autostart']){
				click_play_button();
			}
		};
		
		_video.onloadedmetadata = function(){
			$_loading.css('line-height', $_this.innerHeight() + 'px');
			if(prop['duration'] && prop['duration'].length == 2){
				var left = prop['duration'][0] / _video.duration;
				var width = (prop['duration'][1] - prop['duration'][0]) / _video.duration;
				
				$_progress_line_duration.css('left', (left * 100) + '%').css('width', (width * 100) + '%').show();
				$_progress_line_color.css('left', (left * 100) + '%');
			}
		}
		
		//_video.onprogress = function(e) {
		//	$_loading.show();
		//};

		_video.onwaiting = function(e) {
			$_loading.show();
		};

		_video.onplay = function(e) {
			$_loading.hide();
		};

		_video.onplaying = function(e) {
			$_loading.hide();
		};
		
		_video.oncanplay = function(e) {
			$_loading.hide();
		};
		
		_video.oncanplaythrough = function(e) {
			$_loading.hide();
		};
		
		var update_current = function(){
			if(prop['duration'] && prop['duration'] && prop['duration'].length == 2 && 
				(_video.currentTime < prop['duration'][0] || _video.currentTime > prop['duration'][1])){
				if(_timer)
					clearTimeout(_timer);
				pause();
				$_play_button.html('&#9658');
				update_progress_bar();
				update_caption();
				if(prop['out_duration_callback']){
					prop['out_duration_callback']();
				}
				
				return;
			}
			
			if(_video.currentTime >= _video.duration){
				if(_timer)
					clearTimeout(_timer);
				pause();
				reset();
				update_progress_bar();
				update_caption();
				$_control_bar.slideDown();
			}
			else{
				update_progress_bar();
				update_caption();
				_timer = setTimeout(update_current, 10);
			}
		};
		
		var reset = function(){
			_video.currentTime = 0;
			$_play_button.html('&#9658');
		};
		
		var convert_time_format = function(total_seconds){
			var minutes = Math.floor(total_seconds / 60);
			var seconds = Math.floor(total_seconds - minutes * 60);
			return String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
		};
		
		var update_progress_bar = function(){
			$_current.html(convert_time_format(_video.currentTime));
			if(prop['duration'] && prop['duration'] && prop['duration'].length == 2){
				$_progress_line_color.outerWidth((_video.currentTime - prop['duration'][0]) / _video.duration * 100 + '%');
			}
			else{
				$_progress_line_color.outerWidth(_video.currentTime / _video.duration * 100 + '%');
			}
		};
		
		var update_caption = function(){
			var t = parseInt(_video.currentTime);
			if(_captions[t]){
				$_caption.show().html(_captions[t]);
			}
			else{
				$_caption.hide().html('');
			}
		}

		$(document).on("fullscreenchange", function(e){
			update_video_size();
		}).on('mozfullscreenchange', function(e){
			update_video_size();
		}).on('webkitfullscreenchange', function(e){
			update_video_size();
		}).on('msfullscreenchange', function(e){
			update_video_size();
		});
		
		$(window).resize(function(){
			update_video_size();
		});
		$_this.find('.no-select').css('-webkit-touch-callout', 'none').css('-webkit-user-select', 'none').css('-khtml-user-select', 'none')
			.css('-moz-user-select', 'none').css('-ms-user-select', 'none').css('user-select', 'none');
		$_source.attr('src', prop['src']);
		return $_this;
	};
}(jQuery));