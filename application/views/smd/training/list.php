<style>
#file_browser{position:absolute;top:0;right:0;left:0;}	
</style>
<div id="file_browser"></div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/file-browser/file-browser.css?<?php echo time();?>" />
<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/file-browser/file-browser.js?<?php echo time();?>"></script>
<script>
	$('#file_browser').file_browser({
		get_files: '<?php echo base_url();?>smd/training/get_files', 
		upload_files: '<?php echo base_url();?>smd/training/upload_files',
		delete_file: '<?php echo base_url();?>smd/training/delete_file',
		rename_file: '<?php echo base_url();?>smd/training/rename_file',
		root: 'src/training', 
	});
</script>