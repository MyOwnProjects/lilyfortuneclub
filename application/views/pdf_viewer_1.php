<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo isset($name) ? $name.' - ' : '';?>Lily Fortune Club</title>
<link rel="icon" type="image/png/ico" href="<?php echo base_url();?>src/img/lfc.ico">
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/css/bootstrap.css?<?php time();?>" />
<style>
	#pdf-viewer{position:absolute;top:0;right:0;bottom:0;left:0;}
	#navigation-controls{color:#FFF;position:absolute;top:0;right:0;left:0;bottom:44px;background:#444;padding:10px 20px}
	#pdf-subject{/*position:absolute;left:20px;float:left;*/display:none;overflow:hidden;line-height:26px;height:26px;margin-right:20px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
	#navigation-controls .buttons{cursor:pointer;text-align:center;line-height:26px;height:26px;width:26px;display:inline-block;border-radius:2px}
	#navigation-controls .buttons:hover{background:#666}
	#navigation-controls #download{/*position:absolute;right:120px*/display:none;float:right;}
	#navigation-controls #zoom_out{/*position:absolute;right:146px*/display:none;float:right;}
	#navigation-controls #zoom_in{/*position:absolute;right:172px*/display:none;float:right;}
	#navigation-controls #page_number{/*display:none;position:absolute;right:20px;*/display:none;float:right;text-align:center}
	#navigation-controls #loading{position:absolute;left:80px;right:80px;text-align:center}
	#navigation-controls #loading img{height:24px;line-height:24px}
	#navigation-controls #current_page{display:none;color:#000;text-align:right;padding:0 2px;width:50px;margin-left:20px}
	#canvas-container {background: #333;text-align:center;position:absolute;top:44px;right:0;bottom:0;left:0;overflow:auto}
</style>
<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>src/3rd_party/pdfjs/pdf.min.js"></script>
</head>
<body style="margin:0">
	<div id="pdf-viewer">
		<div id="navigation-controls" class="clearfix">
			<div id="loading"><img src="<?php echo base_url();?>src/img/spinning.gif"></div>
			<div id="page_number"><input id="current_page" min="1" max="" value="" type="number"> of <span id="total_page"></span></div>
			<div id="download" class="buttons"><span class="glyphicon glyphicon-download-alt" aria-hidden="true" title="download"></span></div>
			<div id="zoom_out" class="buttons"><span class="glyphicon glyphicon-minus" aria-hidden="true" title="zoom out"></span></div>
			<div id="zoom_in" class="buttons"><span class="glyphicon glyphicon-plus" aria-hidden="true" title="zoom in"></span></div>
			<div id="pdf-subject"><?php echo isset($name) ? $name : '';?></div>
		</div>
		
		<div id="canvas-container">
		</div>
	</div>
</body>
<script>
var myState = {
	pdf: null,
	currentPage: 1,
	zoom: 1.2,
	pageHeights: []
};
function render() {
    myState.pdf.getPage(myState.currentPage).then((page) => {
		var canvas = document.getElementById("pdf_renderer");
		var ctx = canvas.getContext('2d');
		
		var viewport = page.getViewport(myState.zoom);
		canvas.width = viewport.width;
		canvas.height = viewport.height;
		page.render({
			canvasContext: ctx,
			viewport: viewport
		});
    });
}

pdfjsLib.getDocument('<?php echo base_url().$file;?>?<?php echo time();?>').then(function(pdf) {
    myState.pdf = pdf;
	$('#loading').hide();
	$('#total_page').html(myState.pdf.numPages).show();
	$('#current_page').attr('min', 1).attr('max', myState.pdf.numPages).val(1).show();
	$('#zoom_in, #zoom_out, #download, #page_number, #pdf-subject').show();
	renderAllpages();
});

/*function renderAllpages(){
    viewer = document.getElementById('canvas-container');
	while(viewer.childNodes.length > 0){
		viewer.removeChild(viewer.childNodes[0]);
	}
	myState.pageHeights.length = 0;
    for(page = 1; page <= myState.pdf.numPages; page++) {
		canvas = document.createElement("canvas");    
        canvas.className = 'pdf-renderer';
		canvas.id="pdf-pg-" + page;
        viewer.appendChild(canvas); 
        renderPage(page, canvas);
    }
}
function renderPage(pageNumber, canvas) {
    myState.pdf.getPage(pageNumber).then(function(page) {
		viewport = page.getViewport(myState.zoom);
		canvas.height = viewport.height;
		canvas.width = viewport.width;          
		page.render({canvasContext: canvas.getContext('2d'), viewport: viewport});
		if(myState.pageHeights.length == 0){
			myState.pageHeights.push(canvas.offsetHeight + 15);
		}
		else{
			myState.pageHeights.push(myState.pageHeights[myState.pageHeights.length - 1] + canvas.offsetHeight);
		}
    });
}*/
var viewer = document.getElementById('canvas-container');
function renderAllpages(){
    while(viewer.childNodes.length > 0){
		viewer.removeChild(viewer.childNodes[0]);
	}
	myState.pageHeights.length = 0;
    /*for(page = 1; page <= myState.pdf.numPages; page++) {
		canvas = document.createElement("canvas");    
        canvas.className = 'pdf-renderer';
		canvas.id="pdf-pg-" + page;
        viewer.appendChild(canvas); 
        renderPage(page, canvas);
    }*/
	renderPage(1);
}

function renderPage(pageNumber) {
	if(pageNumber > myState.pdf.numPages){
		return;
	}
    myState.pdf.getPage(pageNumber).then(function(page) {
		var canvas = document.createElement("canvas");    
        canvas.className = 'pdf-renderer';
		canvas.id="pdf-pg-" + page;
        viewer.appendChild(canvas); 
		viewport = page.getViewport(myState.zoom);
		canvas.height = viewport.height;
		canvas.width = viewport.width;          
		page.render({canvasContext: canvas.getContext('2d'), viewport: viewport});
		if(myState.pageHeights.length == 0){
			myState.pageHeights.push(canvas.offsetHeight + 15);
		}
		else{
			myState.pageHeights.push(myState.pageHeights[myState.pageHeights.length - 1] + canvas.offsetHeight);
		}
		renderPage(pageNumber + 1);
    });
}
document.getElementById('current_page').addEventListener('change', (e) => {
	if(myState.pdf == null){
		return;
	} 
	var desiredPage = document.getElementById('current_page').valueAsNumber;
    viewer = document.getElementById('canvas-container');
	viewer.scrollTop = desiredPage == 1 ? 0 : myState.pageHeights[desiredPage - 2];
});
		
document.getElementById('download').addEventListener('click', (e) => {
	if(myState.pdf == null){
		return;
	}
	window.open('<?php echo base_url();?>training/download?file=<?php echo $file;?>' );
});

document.getElementById('zoom_in').addEventListener('click', (e) => {
	if(myState.pdf == null){
		return;
	}
    myState.zoom += 0.2;
    renderAllpages();
});
		
document.getElementById('zoom_out').addEventListener('click', (e) => {
	if(myState.pdf == null){
		return;
	}
    myState.zoom -= 0.2;
    renderAllpages();
});
var lastScrollTop = 0;
document.getElementById('canvas-container').addEventListener("scroll", function(){
	if(lastScrollTop < this.scrollTop){
		//scroll down
		var i;
		for(i = myState.pageHeights.length - 1; i >= 0 ; --i){
			if(i == 0){
				if(this.scrollTop < myState.pageHeights[i]){
					break;
				}
			}
			else{
				if(this.scrollTop >= myState.pageHeights[i - 1] - (myState.pageHeights[i] - myState.pageHeights[i - 1]) * 0.3/* && this.scrollTop < myState.pageHeights[i]*/){
					break;
				}
			}
		}
		document.getElementById('current_page').value = i + 1;
		console.log(this.scrollTop);
	}
	else{
		//scroll up
		var i;
		for(var i = 0; i < myState.pageHeights.length; ++i){
			if(i == 0){
				if(this.scrollTop < myState.pageHeights[0] * 0.7){
					break;
				}
			}
			else{
				if(this.scrollTop < myState.pageHeights[i - 1] + (myState.pageHeights[i] - myState.pageHeights[i - 1]) * 0.5){
					break;
				}
			}
		}
		document.getElementById('current_page').value = i + 1;
	}
	lastScrollTop = this.scrollTop;
});
</script>
</html>