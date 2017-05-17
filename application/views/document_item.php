<style>
.left-part{padding:0 100px;max-width:1000px;width:100%}
.document-content{padding:40px 0;line-height:25px;}
.document-content .content-image{text-align:center;margin:40px auto} 
.document-content img{width:100%;max-width:600px}
@media only screen and (max-width:800px) {
.document-subject{text-align:left;font-weight:normal}
.right-part{display:none;}
.left-part{padding:0 20px}
}
</style>
<script>
function document_loaded(obj){
	if(obj && !$(obj).attr('src')) 
		return false;
	$.ajax({
		url: '<?php echo base_url();?>account/documents/delete_temp_document',
		data: {file: '<?php echo $file?>'},
	});
}
/*$('.doc-frame').each(function(index, obj){
	$(obj).outerHeight($(obj).outerWidth() * 1.4);
});*/
</script>
<div class="clearfix" style="margin-bottom:40px">
	<div class="left-part pull-left">
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url();?>">Home</a></li>
		<li><a href="<?php echo base_url();?>account/documents">Documents</a></li> 
		<li class="active">Item</li> 
	</ul>
	<?php
	if(isset($error) && !empty($error)){
		echo '<div class="alert alert-danger">'.$error.'</div>';
		return;
	}
	?>
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
		<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/pdfjs/pdf.js"></script>
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
	</div>
	
	<div class="right-part" style="overflow:hidden;padding-top:40px">
		Ads
	</div>
	
	
</div>
	
