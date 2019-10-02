<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My PDF Viewer</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/css/bootstrap.css?<?php time();?>" />
<style>
	#pdf-viewer{position:absolute;top:0;right:0;bottom:0;left:0;}
	#navigation-controls{color:#FFF;position:absolute;top:0;right:0;left:0;background:#444;padding:10px 0}
	#pdf-subject{margin-left:20px;float:left;line-height:26px;height:26px;}
	#navigation-controls .buttons{float:right;cursor:pointer;text-align:center;line-height:26px;height:26px;width:26px;display:inline-block;border-radius:2px}
	#navigation-controls .buttons:hover{background:#666}
	#navigation-controls #zoom_out{margin-right:20px}
	#navigation-controls #total_page{margin-right:60px}
	#navigation-controls #current_page{color:#000;text-align:right;padding:0 2px;width:50px}
	#canvas-container {background: #333;text-align:center;position:absolute;top:44px;right:0;bottom:0;left:0;overflow:auto}
</style>
<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>src/3rd_party/pdfjs/pdf.min.js"></script>
</head>
<body style="margin:0">
	<div id="pdf-viewer">
		<div id="navigation-controls" class="clearfix">
			<div id="pdf-subject"><?php echo isset($name) ? $name : '';?></div>
			<!--div id="go_previous" class="buttons"><span class="glyphicon glyphicon-triangle-left" aria-hidden="true" title="previous page"></span></div>
			<div id="go_next" class="buttons"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true" title="next page"></span></div>
			<input id="current_page" value="1" type="number"> of <span id="total_page"></span-->
			<div id="zoom_out" class="buttons"><span class="glyphicon glyphicon-minus" aria-hidden="true" title="zoom out"></span></div>
			<div id="zoom_in" class="buttons"><span class="glyphicon glyphicon-plus" aria-hidden="true" title="zoom in"></span></div>
		</div>
		
		<div id="canvas-container">
		</div>
	</div>
</body>
<script>
var myState = {
	pdf: null,
	currentPage: 1,
	zoom: 1.2
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

pdfjsLib.getDocument('<?php echo base_url().$file;?>').then(function(pdf) {
    myState.pdf = pdf;
	renderAllpages();
});

function renderAllpages(){
    viewer = document.getElementById('canvas-container');
	while(viewer.childNodes.length > 0){
		viewer.removeChild(viewer.childNodes[0]);
	}
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
    });
    }

/*document.getElementById('go_previous').addEventListener('click', (e) => {
	if(myState.pdf == null || myState.currentPage == 1){
		return;
	}
    myState.currentPage -= 1;
    document.getElementById("current_page").value = myState.currentPage;
    render();
});
		
document.getElementById('go_next').addEventListener('click', (e) => {
	if(myState.pdf == null || myState.currentPage >= myState.pdf._pdfInfo.numPages){ 
		return;
	}
	myState.currentPage += 1;
	document.getElementById("current_page").value = myState.currentPage;
		render();
	});
		
document.getElementById('current_page').addEventListener('change', (e) => {
	if(myState.pdf == null){
		return;
	} 
	
	var desiredPage = document.getElementById('current_page').valueAsNumber;
    if(desiredPage >= 1 && desiredPage <= myState.pdf._pdfInfo.numPages) {
		myState.currentPage = desiredPage;
        document.getElementById("current_page")
                                .value = desiredPage;
                        render();
	}
});*/
		
document.getElementById('zoom_in').addEventListener('click', (e) => {
	if(myState.pdf == null){
		return;
	}
    myState.zoom += 0.5;
    renderAllpages();
});
		
document.getElementById('zoom_out').addEventListener('click', (e) => {
	if(myState.pdf == null){
		return;
	}
    myState.zoom -= 0.5;
    renderAllpages();
});
</script>
</html>