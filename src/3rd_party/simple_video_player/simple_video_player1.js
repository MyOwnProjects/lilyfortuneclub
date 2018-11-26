

function simple_video_player1(_video, prop){
	var _start = 0, _end = 0;
	var _cut = false;
	var $_end_text = null;
	if(prop['end_text'] && prop['end_text'].length > 0){
		$_end_text = $('<div>').css('position', 'absolute').css('top', '0').css('right', '0')
			.css('left', '0').css('color', '#fff').css('text-align', 'center').css('padding', '20px 40px')
			.css('background-color', 'rgba(0, 0, 0, 0.6)').css('z-index', '10').css('font-size', '18px').html(prop['end_text']).hide();
		$(_video).parent().css('position', 'relative').append($_end_text);
	}
	var _changeCurrentTime = function(){
		if(_cut){
			if(_video.currentTime < _start){
				_video.currentTime = _start;
			}
			if(_video.currentTime > _end - 5 && prop['end_text'] && prop['end_text'].length > 0){
				if($_end_text){
					$_end_text.show();
				}
			}
			else{
				if($_end_text){
					$_end_text.hide();
				}
			}
			
			if(_video.currentTime > _end){
				_video.currentTime = _end;
				_video.pause();
			}
		}
	};
	
	$(_video).css('z-index', '1');
	if(prop['duration'] && prop['duration'].length > 0){
		for(var i = 0; i < prop['duration'].length; ++i){
			prop['duration'][i] = parseInt(prop['duration'][i]);
		}
	}

	if(prop['duration'] && prop['duration'].length == 2 && 
		(prop['duration'][0] < prop['duration'][1])){
		_start = prop['duration'][0];
		_end = prop['duration'][1];
		_cut = true;
	}
		
	_video.onloadedmetadata = function(){
		if(_cut){
			_video.currentTime = _start;
		}
	};
		
	_video.onseeking = function(){
	};
	_video.onseeked = function(){
		_changeCurrentTime();
	};
	_video.ontimeupdate = function(){
		_changeCurrentTime();
	};
}
