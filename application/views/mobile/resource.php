<div data-role="page" id="resource-list" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Resource'));?>
	<div data-role="main" class="ui-content" data-theme="d">
		<form class="ui-filterable ui-content ui-mini ">
			<input id="resource-filter" data-type="search">
			<div class="ui-field-contain">
				<fieldset data-role="controlgroup" data-type="horizontal">
					<label for="language-en">English</label>
					<input type="radio" name="language" id="language-en" value="EN" data-mini="true" <?php echo $language == 'EN' ? 'checked' : ''?>>
					<label for="language-cn">中文</label>
					<input type="radio" name="language" id="language-cn" value="CN" data-mini="true" <?php echo $language == 'CN' ? 'checked' : ''?>>
				</fieldset>
			</div>		
		</form>
		<ul data-role="listview" data-filter="true" data-input="#resource-filter"></ul>
	</div>
</div>
<script>
function load_resource(language){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	var pl = $('#resource-list ul[data-role=listview]');
	pl.empty();
	$.ajax({
		url: '<?php echo base_url();?>resource/get_list?language=' + language,
		dataType: 'json',
		success: function(data){
			if(data.length > 0){
				for(var i = 0; i < data.length; ++i){
					var content_wrapper = $('<div>').append(data[i]['content']);
					var $_li = $('<li>').addClass("clearfix").addClass("ui-li-static").addClass("ui-body-inherit");
					var $_a = $('<a>').attr('target', '_blank').attr('href', '<?php echo base_url();?>resource/item/' + data[i]['url_id']).addClass('nondec').attr('data-transition', 'slide').appendTo($_li);
					
					var img_wrappers = content_wrapper.children('.content-image');
					if(img_wrappers.length > 0){
						var $_thumbnail = $('<div>').addClass('thumbnail').appendTo($_a);
						$('<img src="' + $(img_wrappers[0]).children('img').attr('src') + '">').appendTo($_thumbnail);
					}
					var date = data[i]['create_time'].split(' ');
					$('<div>').addClass('list-text').append('<div class="sub">' + data[i]['subject'] + '</div>').append('<div class="info">' + date[0] + '</div>').appendTo($_a);

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
$(document).on("pageshow","#resource-list",function(){
	load_resource($('input[name=language]').val());
});

$('input[name=language]').change(function(){
	load_resource($(this).val());
});
</script>
