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
		<div class="page-nav">
			<a class="nav-prev ui-btn-b" data-role="button" data-icon="arrow-l" href="documents#view-document-1" data-transition="slide" data-iconpos="left" data-inline="true" data-mini="true" data-theme="e" data-direction="reverse">Prev</a>
			<a class="nav-next ui-btn-b" data-role="button" data-icon="arrow-r" href="documents#view-document-1" data-transition="slide" data-iconpos="right" data-inline="true" data-mini="true" data-theme="e">Next</a>
		</div>
	</div>
</div>
<div data-role="page" id="view-document-1" class="view-document" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Document</h1>
		<a href="#document-list" data-icon="back" data-iconpos="notext" data-transition="slide" data-direction="reverse">Back</a>
	</div>
	<div data-role="main" class="ui-content">
		<div class="document-content"></div>
		<div class="page-nav">
			<a class="nav-prev ui-btn-b" data-role="button" data-icon="arrow-l" href="documents#view-document-0" data-transition="slide" data-iconpos="left" data-inline="true" data-mini="true" data-theme="e" data-direction="reverse">Prev</a>
			<a class="nav-next ui-btn-b" data-role="button" data-icon="arrow-r" href="documents#view-document-0" data-transition="slide" data-iconpos="right" data-inline="true" data-mini="true" data-theme="e">Next</a>
		</div>
	</div>
</div>
<script>
var resource_id = 0;
var file = '';
$(document).delegate('#document-list ul[data-role=listview] li', 'click', function(){
	resource_id = $(this).attr('data-id');
	var content_type = $(this).attr('content-type');
	if(content_type == 'pdf'){
		window.open('<?php echo base_url();?>account/documents/view/' + resource_id);
	}
	else{
		$.mobile.changePage('documents#view-document-0', { transition: "slide"} );
	}
}).delegate('.nav-prev, .nav-next', 'click', function(){
	resource_id = $(this).attr('data-id');
}).on('pageshow', '.view-document', function(){
	var $_page = $(this);
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	$.ajax({
		url: '<?php echo base_url();?>account/documents/view/' + resource_id,
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

			var $_doc_content = $_page.find('.document-content').append(data);
			/*if(data['mime_type'] == 'video'){
			}
			else if(data['mime_type'] == 'doc' || data['mime_type'] == 'ppt' || data['mime_type'] == 'excel'){
			}
			else if(data['mime_type'] == 'HTML'){
			}*/
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

function document_loaded(obj){
	if(obj && !$(obj).attr('src')) 
		return false;
	$.ajax({
		url: '<?php echo base_url();?>' + 'account/documents/delete_temp_document',
		data: {file: file},
	});
}

function renderPDF(url, frame) {
	var width = 0;
	var height = 0;
	var total_page = 0;
	var options = { scale: 1 };
	function renderPage(page) {
		var viewport = page.getViewport(options.scale);
		var canvas = document.createElement('canvas');
		var ctx = canvas.getContext('2d');
		var renderContext = {
			canvasContext: ctx,
			viewport: viewport
		};
		page.render(renderContext).then(function(){
			width = viewport.width;
			height = viewport.height;alert(height);
			var w = frame.outerWidth();
			var h = height * total_page * w / width;alert(h);
			frame.outerHeight(h);
			frame.attr('src', '<?php echo base_url();?>' + 'src/temp/' + file + '#toolbar=0&navpanes=0&scrollbar=0');
		});
	}
	function renderPages(pdfDoc) {
		total_page = pdfDoc.numPages;
		pdfDoc.getPage(1).then(renderPage);
	}
	PDFJS.disableWorker = true;
	PDFJS.getDocument(url).then(renderPages);
}   
</script>
	<?php
	if($mime_type == 'video'){
	?>
		<h3 class="text-center"><?php echo $subject;?></h3>
		<div class="video-player" style="margin:20px auto">
		</div>
		<div style="line-height:30px">Content Type: <?php echo $content_type;?></div>
		<?php if(!empty($html_content)){ ?>
		<div style="line-height:20px"><?php echo $html_content;?></div>
		<?php } ?>
	<script>
	$('.video-player').simple_video_player({
		src: '<?php echo base_url().'src/temp/'.$file;?>', 
		autostart: true, 
		loaded: function(){
			document_loaded();		
		}
	});
	</script>
	<?php
	}
	else if($mime_type == 'doc' || $mime_type == 'ppt' || $mime_type == 'excel'){ 
	?>
		<embed class="doc-frame" src="<?php echo sprintf($src, base_url().'src/temp/'.$file);?>" style="width:100%" onload="document_loaded()">
	<?php
	}
	else if($mime_type == 'HTML'){
	?>
		<h3 class="text-center"><?php echo $subject;?></h3>
		<div class="document-content"><?php echo $html_content;?></div>
	<?php
	}
	else if($mime_type == 'pdf'){
	?>
		<h3 class="text-center"><?php echo $subject;?></h3>
		<iframe class="doc-frame" frameborder="0" style="width:100%" onload="document_loaded(this)"></iframe>
		<script type="text/javascript">
		(function($){
			function renderPDF(url, options) {
				var width = 0;
				var height = 0;
				var total_page = 0;
				var options = options || { scale: 1 };
				function renderPage(page) {
					var viewport = page.getViewport(options.scale);
					var canvas = document.createElement('canvas');
					var ctx = canvas.getContext('2d');
					var renderContext = {
						canvasContext: ctx,
						viewport: viewport
					};
					page.render(renderContext).then(function(){
						width = viewport.width;
						height = viewport.height;
						var w = $('.doc-frame').outerWidth();
						var h = height * total_page * w / width;
						$('.doc-frame').outerHeight(h);
						$('.doc-frame').attr('src', '<?php echo base_url().'src/temp/'.$file;?>#toolbar=0&navpanes=0&scrollbar=0');
					});
				}
    
				function renderPages(pdfDoc) {
					total_page = pdfDoc.numPages;
					pdfDoc.getPage(1).then(renderPage);
					//for(var num = 1; num <= pdfDoc.numPages; num++){
					//}
				}
				
				PDFJS.disableWorker = true;
				PDFJS.getDocument(url).then(renderPages);
			}   
			renderPDF("<?php echo base_url().'src/temp/'.$file;?>");
		}(jQuery));
		</script>
	<?php
	}
	?>

