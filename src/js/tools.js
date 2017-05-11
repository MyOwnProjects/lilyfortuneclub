Date.prototype.nextMonth = function(){
	var thisMonth = this.getMonth();
	this.setMonth(thisMonth+1);
	if(this.getMonth() !== thisMonth+1 && this.getMonth() !== 0)
	this.setDate(0);
};
Date.prototype.prevMonth = function(){
	var thisMonth = this.getMonth();
	this.setMonth(thisMonth-1);
	if(this.getMonth() !== thisMonth-1 && (this.getMonth() !== 11 || (thisMonth === 11 && this.getDate() === 1)))
	this.setDate(0);
};
Date.prototype.lastDateOfMonth = function(){
	var date = new Date(this.getFullYear(), this.getMonth() + 1, 0);
    return date.getDate();
};

Date.prototype.numberOfWeeks = function(){
	var used = new Date(this.getFullYear(), this.getMonth(), 1).getDay() + new Date(this.getFullYear(), this.getMonth() + 1, 0).getDate();
    return Math.ceil( used / 7);
};

String.prototype.padStart = function(targetLength, padChar){
	var ret = '';
	for(var i = 0; i < this.length; ++i)
		ret += this[i];
	if(padChar.length > 0){
		for(var i = 0; i < targetLength - ret.length; ++i){
			ret = padChar[0] + ret;
		}
	}
	return ret;
};

function timeStr(hour, minute){
	if(minute !== undefined){
		if(minute < 10)
			minute = ':0' + minute;
		else
			minute = ':' + minute;
	}
	else minute = '';
	if(hour === 0){
		return '12' + minute + '&nbsp;am';
	}
	else if(hour === 12){
		return '12' + minute + '&nbsp;pm';
	}
	else if(hour < 12){
		return hour + minute + '&nbsp;am';
	}
	else{
		return (hour - 12) + minute + '&nbsp;pm';
	}	
}

function upload_file(form, progress, success, error){
	$.ajax({
		url: $(form).attr('action'),
		data: new FormData(form),
		method: $(form).attr('method'),
		cache: false,
			contentType: false,
            processData: false,
			dataType: 'json',
			xhr: function() {  // custom xhr
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // if upload property exists
					myXhr.upload.addEventListener('progress', function(data){
						if(progress){
							progress(data);
						}
					}, 
					false); // progressbar
                }
                return myXhr;
            },
			success: function(data){
				if(success){
					success(data);
				}
			},
			error: function(a, b, c){
				if(error){
					error(a, b, c);
				}
			}
		});		
}

$.fn.scrollBottom = function(scroll){
	if(typeof scroll === 'number'){
		window.scrollTo(0,$(document).height() - $(window).height() - scroll);
		return $(document).height() - $(window).height() - scroll;
	} else {
		return $(document).height() - $(window).height() - $(window).scrollTop();
	}
}

function ajax_loading(show){
	if(show){
		if($('#ajax-loading').length){
			$('#ajax-loading').show();
		}
		else{
			var $_div = $('<div>').attr('id', 'ajax-loading').css('position', 'fixed').css('margin', '100px auto 0 auto').css('left', '0').css('right', '0')
				.css('width', '400px').css('border', '1px solid #d5d5d5').css('background', '#fff').css('z-index', '10000').css('text-align', 'center').css('padding', '20px 0')
				.html('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>');
			$('body').append($_div);
		}
	}
	else{
		if($('#ajax-loading').length){
			$('#ajax-loading').hide();
		}
	}
}