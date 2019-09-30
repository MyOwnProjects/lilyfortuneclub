
<style>
.common-ln{padding:5px 0}
.item-body{margin:20px}
.item-body>.f-body{margin-left:10px}
.f-head{position:relative;height:60px;}
.f-head>div{position:absolute}
.f-head>div:first-child{border:5px solid #FFF;z-index:1000;top:0;bottom:0;left:0;width:60px;height:60px;border-radius:50%;line-height:50px;text-align:center;font-size:24px;font-weight:bold}
.f-head>div:last-child{top:10px;right:0;left:30px;line-height:40px;padding-left:40px;font-size:18px;border-radius:30px}
.f-head-r>div{background:red;color:#FFF}
.f-head-g>div{background:green;color:#FFF}
.f-body{padding:0 30px}
.f-sub-body-text img,.f-sub-body-file img{height:14px;margin-top:-4px;margin-left:10px}
.f-sub-body-text>div:first-child,.f-sub-body-file>div:first-child{float:left;width:25px;}
.f-sub-body-text>div:last-child,.f-sub-body-file>:last-child{overflow:hidden}
.f-sub-body-text{padding-top:12px}
.f-sub-body-file{display:inline-block;padding-right:10px}
.file-pdf{background:url('<?php echo base_url();?>src/img/pdf.svg') no-repeat 0 2px;background-size:auto 20px}
.file-ppt{background:url('<?php echo base_url();?>src/img/ppt.svg') no-repeat 0 2px;background-size:auto 20px}
.file-mp4{background:url('<?php echo base_url();?>src/img/mp4.svg') no-repeat 0 2px;background-size:auto 20px}
.file-png{background:url('<?php echo base_url();?>src/img/pdfpng.svg') no-repeat 0 2px;background-size:auto 20px}
.file-default{background:url('<?php echo base_url();?>src/img/file.svg') no-repeat 0 2px;background-size:auto 20px}

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
				case 'mp4':
					$type_class = 'file-mp4';
					break;
				case 'png':
					$type_class = 'file-png';
					break;
				default:
					$type_class = 'file-default';
					
			}
?>
		<div class="<?php echo $type_class;?>">&nbsp;</div>
		<div>
			<a href="<?php echo base_url();?>training/view?file=<?php echo $item['path'].'/'.$item['name'];?>" target="_blank">
			<?php echo $item['name'];?>
			</a>
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
		<h2 class="text-center">Training</h2>
		<?php
		foreach($data as $i => $d){
		?>
		<div class="item-body">
			<div class="f-head f-head-g">
				<div><?php echo $i + 2;?></div>
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
