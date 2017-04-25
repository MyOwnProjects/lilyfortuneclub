<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
?>
<style>
	body{margin:0 auto}
</style>
<div style="position:absolute;top:0;bottom:20px;left:0;right:0">
	<iframe name="frame" id="test" src="http://localhost/fin/test_1" style="width:100%;width:1000px" scrolling="no" frameborder="0"></iframe>
		
</div>
<script src="<?php echo base_url();?>/3rd_party/jquery-1.11.2.js"></script>	
<script>
$("#test").outerHeight(window.innerHeight);
</script>
<?php		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */