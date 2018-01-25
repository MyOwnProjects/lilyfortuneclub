<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
<script>
<?php
foreach($cases as $case){
	$html = str_replace(array("\n", "\r"), '', $case);
?>
var newWindow = window.open('');
newWindow.document.write('<?php echo $html;?>');
newWindow.document.close();
<?php
}
?>
window.close();
</script>
</head>
<body></body>
</html>