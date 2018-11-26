

function simple_video_player1(_video, prop){
	var _start = 0, _end = 0;
	var _cut = false;
	var _changeCurrentTime = function(){
		if(_cut){
			if(_video.currentTime < _start){
				_video.currentTime = _start;
			}
			if(_video.currentTime > _end){
				_video.currentTime = _end;
				_video.pause();
			}
		}
	};
	
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
