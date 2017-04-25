<div class="clearfix">
	<div>File Format:</div> 
	<?php 
	foreach($user_fields as $f){
		echo '<div style="font-size:12px;float:left;margin-right:10px;background:#dfdfdf;padding:0 5px;border-radius:3px">'.$f.'</div>';
	}
?>
</div>
<div id="filename"><b>File:</b> Please select a file to upload. </div>
<button class="btn btn-primary btn-sm" onclick="$('#uploaded_file').click()">
	<span class="glyphicon glyphicon-open-file"></span>
	Select File
</button>
<button id="upload-button" class="btn btn-primary btn-sm disabled" onclick="$('#upload_submit').click()">
	<span class="glyphicon glyphicon-upload"></span>
	Upload
</button>
<div id="upload-info"></div>
<form method="post" action="<?php echo base_url();?>smd/team/upload" enctype="multipart/form-data" id="upload_form">
	<input name="uploaded_file" id="uploaded_file" type="file" style="display: none;" onchange="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">						
	<input class="btn" type="submit" value="Upload" id="upload_submit" style="display: none;">
</form>
<div id="member-grid">
	
</div>
<script type="text/javascript">
$("#uploaded_file").change(function(){
	var file_array = $('#uploaded_file').attr('value').split(".");
	//check file extension
	if(file_array[file_array.length-1] == 'xls' || file_array[file_array.length-1] == 'xlsx' || file_array[file_array.length-1] == 'csv'){
		$("#filename").html('<b>File: </b><span style="color:green">' + $('#uploaded_file').attr('value') + '</span>');
		$('#upload-button').removeClass('disabled');
	}
	else{
		$('#uploaded_file').attr('value', '');
		$("#filename").html('<b>File: </b><span class="error">Error! Only csv and xlsx file are acceptable.</span>');
		$('#upload-button').addClass('disabled');
	}
});
	
	
	
	
$('#upload_form').submit(function(e){
	var form_data = new FormData(this);
	$('#upload-info').html('Uploaded......');
	$.ajax({
		url: '<?php echo base_url();?>smd/team/upload',
			data: form_data,
			method: 'post',
			cache: false,
			contentType: false,
            processData: false,
			//dataType: 'json',
			xhr: function() {  // custom xhr
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // if upload property exists
					myXhr.upload.addEventListener('progress', function(data){
						$('#upload-info').html(Math.round(data.loaded / data.total * 100) + '% is uploaded.');
					}, 
					false); // progressbar
                }
                return myXhr;
            },
			success: function(data){
				$('#member-grid').html(data);
			},
			error: function(a, b, c){
				$('#member-grid').html('Failed to upload ' + $('#uploaded_file').attr('value'));
			}
		});
		e.preventDefault();
		return false;
});

</script>

