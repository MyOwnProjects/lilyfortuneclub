<div data-role="page" id="resource-list" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Resource'));?>
	<div data-role="main" class="ui-content" data-theme="d">
		<form class="ui-filterable ui-content ui-mini ">
			<input id="resource-filter" data-type="search">
		</form>
		<ul data-role="listview" data-filter="true" data-input="#resource-filter"></ul>
	</div>
</div>

<div data-role="page" id="view-resource-0" class="view-resource" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Resource</h1>
		<a href="#resource-list" data-icon="back" data-iconpos="notext" data-transition="slide" data-direction="reverse">Back</a>
	</div>
	<div data-role="main" class="ui-content">
		<div class="resource-content"></div>
		<div class="page-nav">
			<a class="nav-prev ui-btn-b" data-role="button" data-icon="arrow-l" href="resource#view-resource-1" data-transition="slide" data-iconpos="left" data-inline="true" data-mini="true" data-theme="e" data-direction="reverse">Prev</a>
			<a class="nav-next ui-btn-b" data-role="button" data-icon="arrow-r" href="resource#view-resource-1" data-transition="slide" data-iconpos="right" data-inline="true" data-mini="true" data-theme="e">Next</a>
		</div>
	</div>
</div>
<div data-role="page" id="view-resource-1" class="view-resource" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Resource</h1>
		<a href="#resource-list" data-icon="back" data-iconpos="notext" data-transition="slide" data-direction="reverse">Back</a>
	</div>
	<div data-role="main" class="ui-content">
		<div class="resource-content"></div>
		<div class="page-nav">
			<a class="nav-prev ui-btn-b" data-role="button" data-icon="arrow-l" href="resource#view-resource-0" data-transition="slide" data-iconpos="left" data-inline="true" data-mini="true" data-theme="e" data-direction="reverse">Prev</a>
			<a class="nav-next ui-btn-b" data-role="button" data-icon="arrow-r" href="resource#view-resource-0" data-transition="slide" data-iconpos="right" data-inline="true" data-mini="true" data-theme="e">Next</a>
		</div>
	</div>
</div>
<script>
function load_resource(){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	var pl = $('#resource-list ul[data-role=listview]');
	pl.empty();
	$.ajax({
		url: '<?php echo base_url();?>resource/get_list',
		dataType: 'json',
		success: function(data){
			if(data.length > 0){
				for(var i = 0; i < data.length; ++i){
					var content_wrapper = $('<div>').append(data[i]['content']);
					var $_li = $('<li>').addClass("clearfix").addClass("ui-li-static").addClass("ui-body-inherit");
					var $_a = $('<a>').attr('data-id', data[i]['url_id']).attr('href', '#view-resource-0').addClass('nondec').attr('data-transition', 'slide').appendTo($_li);
					
					var img_wrappers = content_wrapper.children('.content-image');
					if(img_wrappers.length > 0){
						var $_thumbnail = $('<div>').addClass('thumbnail').appendTo($_a);
						$('<img src="' + $(img_wrappers[0]).children('img').attr('src') + '">').appendTo($_thumbnail);
					}
					var date = data[i]['create_time'].split(' ');
					$('<div>').addClass('resource-list-text').append('<div class="sub">' + data[i]['subject'] + '</div>').append('<div class="info">' + date[0] + '</div>').appendTo($_a);

					$_li.appendTo(pl);
				}
			}
			else{
				pl.children(':first-child').html('No resource').appendTo(pl);
			}
		},
		error: function(){
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
}

var resource_id = 0;

$(document).delegate('#resource-list ul[data-role=listview] a', 'click', function(){
	resource_id = $(this).attr('data-id');
}).delegate('.nav-prev, .nav-next', 'click', function(){
	resource_id = $(this).attr('data-id');
}).on("pageshow","#resource-list",function(){
	load_resource();
}).on('pagebeforeshow', '.view-resource', function(){
	$('.resource-content').empty();
}).on('pageshow', '.view-resource', function(){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	$.ajax({
		url: '<?php echo base_url();?>resource/item/' + resource_id,
		dataType: 'json',
		success: function(data){
			if(data['prev']){
				$('.nav-prev').attr('data-id', data['prev']).removeClass( "ui-disabled" ).removeAttr( "aria-disabled");
			}
			else{
				$('.nav-prev').removeAttr('data-id').addClass( "ui-disabled" ).attr( "aria-disabled", true );
			}
			if(data['next']){
				$('.nav-next').attr('data-id', data['next']).removeClass( "ui-disabled" ).removeAttr( "aria-disabled");
			}
			else{
				$('.nav-next').removeAttr('data-id').addClass( "ui-disabled" ).attr( "aria-disabled", true );
			}
			var subject = $('<h4>').html(data['subject']);
			var date = $('<div>').html(data['create_time']);
			var source = $('<div>').html(data['source']);
			var content = $('<div>').html(data['content']);
			$('.resource-content').append(subject).append(date).append(source).append(content);
		},
		error: function(){
			location.href="#resource-list";
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
});
</script>
