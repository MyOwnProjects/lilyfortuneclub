<div data-role="page" id="event-list" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Events'));?>
	<div data-role="main" class="ui-content" data-theme="d">
		<form class="ui-filterable ui-content ui-mini ">
			<input id="event-filter" data-type="search">
		</form>
		<ul data-role="listview" data-filter="true" data-input="#event-filter"></ul>
	</div>
</div>

<script>
function load_events(){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	var pl = $('#event-list ul[data-role=listview]');
	pl.empty();
	$.ajax({
		url: '<?php echo base_url();?>events/get_list',
		dataType: 'json',
		success: function(data){
			if(data.length > 0){
				for(var i = 0; i < data.length; ++i){
					var content_wrapper = $('<div>').append(data[i]['content']);
					var $_li = $('<li>').addClass("clearfix").addClass("ui-li-static").addClass("ui-body-inherit");
					var $_a = $('<a>')
						.attr('href', '<?php echo base_url();?>events/item/' + data[i]['events_id'])
						.addClass('nondec')
						.attr('data-transition', 'slide')
						.appendTo($_li);
					
/*					var img_wrappers = content_wrapper.children('.content-image');
					if(img_wrappers.length > 0){
						var $_thumbnail = $('<div>').addClass('thumbnail').appendTo($_a);
						$('<img src="' + $(img_wrappers[0]).children('img').attr('src') + '">').appendTo($_thumbnail);
					}*/
					$('<div>').addClass('list-text').append('<div class="sub">' + data[i]['events_subject'] + '</div>').append('<div class="info">' + data[i]['events_start_date'] + ', ' + data[i]['events_city'] + '</div>').appendTo($_a);

					$_li.appendTo(pl);
				}
			}
			else{
				pl.children(':first-child').html('No events').appendTo(pl);
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
$(document).on("pageshow","#event-list",function(){
	load_events();
});
</script>
