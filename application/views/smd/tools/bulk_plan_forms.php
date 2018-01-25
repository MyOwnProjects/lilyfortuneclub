<?php
foreach($cases as $case){
	$html = str_replace(array("\n", "\r"), '', $case);
?>
<script>
var newWindow = window.open();
newWindow.document.write('<?php echo $html;?>');
newWindow.document.close();
</script>
<?php
}
?>
<script>//window.close();</script>