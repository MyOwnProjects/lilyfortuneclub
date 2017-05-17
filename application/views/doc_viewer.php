<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="google" content="notranslate">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $subject;?></title>
 <script src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
  </head>

  <body>
	<div style="position:fixed;top:0;right:0;bottom:0;left:0">
		<embed class="doc-frame" src="https://view.officeapps.live.com/op/embed.aspx?src=<?php echo base_url().'src/temp/'.$file;?>&embedded=true" style="width:100%;height:100%" onload="document_loaded('<?php echo $file;?>')">
	<!--embed class="doc-frame" src="https://docs.google.comsdasd/gview?url=<?php echo base_url().'src/temp/'.$file;?>&embedded=true" style="width:100%;height:100%" onload="document_loaded('<?php echo $file;?>')"-->
	</div>
  </body>
</html>
<script>
function document_loaded(file){
	if(file){
		$.ajax({
			url: '<?php echo base_url();?>' + 'account/documents/delete_temp_document',
			data: {file: file},
		});
	}
}
	
</script>
