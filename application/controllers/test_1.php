<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_1 extends CI_Controller {

	public function index()
	{
?>
<html>
<body>

<!-- really dirty! this is just a test drive ;) -->

<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/pdfjs/pdf.js"></script>
<script type="text/javascript">
function renderPDF(url, canvasContainer, options) {
    var options = options || { scale: 1.5 };
        
    function renderPage(page) {
        var viewport = page.getViewport(options.scale);
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var renderContext = {
          canvasContext: ctx,
          viewport: viewport
        };
        
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        canvasContainer.appendChild(canvas);
        
        page.render(renderContext);
    }
    
    function renderPages(pdfDoc) {
        for(var num = 1; num <= pdfDoc.numPages; num++)
            pdfDoc.getPage(num).then(renderPage);
    }
    PDFJS.disableWorker = true;
    PDFJS.getDocument(url).then(renderPages);
}   
</script> 

<div id="holder"></div>

<script type="text/javascript">
renderPDF("<?php echo base_url().'src/temp/58a0a7451ee24.pdf';?>", document.getElementById('holder'));
</script>  

</body>
</html>
<?php		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */