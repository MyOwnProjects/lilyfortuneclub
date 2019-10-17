
<style>
.common-ln{padding:5px 0}
.item-body{margin:40px 20px 20px 20px}
.item-body>.f-body{margin-left:10px}
.f-head{font-size:18px;}
.f-head>div:first-child{color:darkred;border-bottom:3px solid darkred;float:left;width:30px;text-align:center}
.f-head>div:last-child{overflow:hidden;border-bottom:3px solid #e5e5e5;padding-left:10px}
.f-head>div{padding-bottom:5px;}

.f-body{padding:0 0 0 20px}
.f-sub-body-text img,.f-sub-body-file img{height:14px;margin-top:-4px;margin-left:10px}
.f-sub-body-text>div:first-child{float:left;width:25px;margin-right:5px}
.f-sub-body-file>div:first-child{float:left;width:20px;}
.f-sub-body-text>div:last-child,.f-sub-body-file>:last-child{overflow:hidden}
.f-sub-body-text{padding-top:12px}
.f-sub-body-file{display:inline-block;padding-right:16px}
.f-sub-body-file>div:first-child{background-repeat:no-repeat;background-position:0 3px;background-size:auto 16px}
.file-pdf{background-image:url('<?php echo base_url();?>src/img/pdf.svg')}
.file-ppt{background-image:url('<?php echo base_url();?>src/img/ppt.svg')}
.file-xls{background-image:url('<?php echo base_url();?>src/img/xls.svg')}
.file-doc{background-image:url('<?php echo base_url();?>src/img/doc.svg')}
.file-mp4{background-image:url('<?php echo base_url();?>src/img/mp4.svg')}
.file-png{background-image:url('<?php echo base_url();?>src/img/png.svg')}
.file-html{background-image:url('<?php echo base_url();?>src/img/html.svg')}
.file-default{background-image:url('<?php echo base_url();?>src/img/file.svg')}

</style>
<?php
function list_items($list, $level){
	$list_number = array(
		array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k'),
		array('i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x')
	);
?>
<div class="f-body">
<?php
	foreach($list as $i => $item){
		if($item['type'] == 'dir'){
?>
	<div class="f-sub-body-text clearfix">
		<div><?php echo $list_number[$level - 1][$i];?>.</div>
		<div><?php echo substr($item['name'], 3);?></div>
	</div>
	
<?php
			if(array_key_exists('children', $item) && count($item['children']) > 0){
				list_items($item['children'], $level + 1);
			}
		}
		else{
?>
	<div class="f-sub-body-file clearfix">
<?php
			$ext = strtolower($item['ext']);
			switch($ext){
				case 'pdf':
					$type_class = 'file-pdf';
					break;
				case 'ppt':
				case 'pptx':
					$type_class = 'file-ppt';
					break;
				case 'xls':
				case 'xlsx':
					$type_class = 'file-xls';
					break;
				case 'doc':
				case 'docx':
					$type_class = 'file-doc';
					break;
				case 'mp4':
					$type_class = 'file-mp4';
					break;
				case 'png':
					$type_class = 'file-png';
					break;
				case 'url':
					$type_class = 'file-html';
					break;
				default:
					$type_class = 'file-default';
					
			}
?>
		<div class="<?php echo $type_class;?>">&nbsp;</div>
		<div>
			<?php
			$href = base_url().'training/view?file='.$item['path'].'/'.$item['name'];
			?>
			<a href="<?php echo $href;?>" target="_blank"><?php echo substr($item['name'], 0, strlen($item['name']) - strlen($ext) - 1);?></a>
		</div>
	</div>
<?php
		}
	}
?>
</div>	
<?php
}
?>
<div class="main-body-wrapper clearfix">
	<div class="main-content-wrapper">
		<h2 class="text-center">On-Boarding Process</h2>
		<?php
		foreach($data as $i => $d){
		?>
		<div class="item-body">
			<div class="f-head f-head-g">
				<div><?php echo $i + 1;?></div>
				<div><?php echo substr($d['name'], 3);?></div>
			</div>
			<div class="f-body">
				<div class="row">
					<div class="col-md-12">
						<?php
						if(array_key_exists('children', $d) && count($d['children']) > 0){
							list_items($d['children'], 1);
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>


	</div>
</div>
