<div data-role="page" id="document-list" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Documents'));?>
	<div data-role="main" class="ui-content" data-theme="d">
		<form class="ui-filterable ui-content ui-mini ">
			<select id="documents-filter">
				<option value="all">All</option>
				<?php
				foreach($content_type_list as $ct){
					echo '<option value="'.$ct.'">'.$ct.'</option>';
				}
				?>				
			</select>
		</form>
		<ul data-role="listview">
		<?php
		foreach($list as $l){
		?>
			<li data-id="<?php echo $l['uniqid'];?>" content-type="<?php echo is_array($l['mime_type'])? $l['mime_type'][0] : $l['mime_type'];?>" data-type="<?php echo $l['content_type'];?>">
				<img src="<?php echo base_url();?>src/img/file_type/<?php echo empty($l['file_name']) ? $l['mime_type'] : $l['mime_type'][1];?>.png" class="ui-li-icon">
				<?php echo empty($l['subject']) ? $l['file_name'] : $l['subject'];?>
			</li>
		<?php
		}
		?>
		</ul>
	</div>
</div>

<div data-role="page" id="view-document-0" class="view-document" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Document</h1>
		<a href="#document-list" data-icon="back" data-iconpos="notext" data-transition="slide" data-direction="reverse">Back</a>
	</div>
	<div data-role="main" class="ui-content" style="height:100%">
		<div class="document-content" style="height:100%"></div>
	</div>
</div>
<script>
var resource_id = 0;
$(document).delegate('#document-list ul[data-role=listview] li', 'click', function(){
	resource_id = $(this).attr('data-id');
	var content_type = $(this).attr('content-type');
	if(content_type == 'pdf' || content_type == 'doc' || content_type == 'ppt' || content_type == 'excel' || content_type == 'csv'){
		window.open('<?php echo base_url();?>account/documents/view/' + resource_id);
	}
	else{
		$.mobile.changePage('documents#view-document-0', { transition: "slide"} );
	}
}).delegate('.nav-prev, .nav-next', 'click', function(){
	resource_id = $(this).attr('data-id');
}).on('pagehide', '.view-document', function(){
	$(this).find('.document-content').empty();
}).on('pageshow', '.view-document', function(){
	var $_page = $(this);
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	$.ajax({
		url: '<?php echo base_url();?>account/documents/view/' + resource_id,
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

			var $_doc_content = $_page.find('.document-content');
			var mime_type = data['mime_type'].toLowerCase();
			if(mime_type == 'image'){
				var img = $('<img>').load(function(){
					document_loaded(data['file']);				
				}).css('width', '100%').attr('src', '<?php echo base_url();?>src/temp/' + data['file']).appendTo($_doc_content);
				
			}
			else if(mime_type == 'html'){
				$_doc_content.append(data['html_content']);
			}
			else if(mime_type == 'video'){
				$('<h3>').html(data['subject']).appendTo($_doc_content);
				var $_vp = $('<div>').attr('id', 'video-player').appendTo($_doc_content);
				$('<p>').html('Content Type: ' + data['content_type']).appendTo($_doc_content);
				if(data['html_content']){
					$('<div>').html(data['html_content']).appendTo($_doc_content);
				}
				$_vp.simple_video_player({
					src: '<?php echo base_url();?>src/temp/' + data['file'], 
					autostart: false, 
					loaded: function(){
						document_loaded(data['file']);		
					}
				});
			}
			else if(mime_type == 'csv'){
				var data = data['data'];
				var t = $('<table>').addClass('csv-output').appendTo($_doc_content);
				var max_width = 0;
				for(var i = 0; i < data.length; ++i){
					if(data[i].length == 0){
						continue;
					}
					if(data[i].length > max_width){
						max_width = data[i].length;
					}
					var tr = $('<tr>').appendTo(t);
					$('<td>').html(i + 1).appendTo(tr);
					for(var j = 0; j < data[i].length; ++j){
						$('<td>').html(data[i][j]).appendTo(tr);
					}
				}
				var tr = $('<tr>').prependTo(t);
				$('<td>').appendTo(tr);
				for(var i = 0; i < max_width; ++i){
					var c = String.fromCharCode(i + 65);
					$('<td>').html(c).appendTo(tr);
				}
			}
		},
		error: function(){
			location.href="documents#document-list";
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
}).delegate('#documents-filter', 'change', function(){
	var filter = $(this).val();
	if(filter == 'all'){
		$('ul[data-role=listview] li').show();
	}
	else{
		$('ul[data-role=listview] li').each(function(index, obj){
			if($(obj).attr('data-type') == filter){
				$(obj).show();
			}
			else{
				$(obj).hide();
			}
		});
	}
});

function document_loaded(file){
	if(file){
		$.ajax({
			url: '<?php echo base_url();?>' + 'account/documents/delete_temp_document',
			data: {file: file},
		});
	}
}
</script>
