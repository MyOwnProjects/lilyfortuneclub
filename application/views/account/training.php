
<style>
.common-ln{padding:5px 0}
.item-body{margin:40px 20px 20px 20px}
.item-body>.f-body{margin-left:10px}
.f-head{font-size:18px;}
.f-head>div:first-child{color:darkred;border-bottom:3px solid darkred;float:left;width:30px;text-align:center}
.f-head>div:last-child{overflow:hidden;border-bottom:3px solid #e5e5e5;padding-left:10px}
.f-head>div{padding-bottom:5px;}

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
		<h2 class="text-center">On-Boarding Process</h2>
		<div class="item-body">
			<div class="f-head f-head-g clearfix">
				<div>1</div>
				<div>Licensing</div>
			</div>
			<div class="f-body">
				<div class="row">
					<div class="col-md-6">
						<div class="f-body">
							<div class="f-sub-body-text clearfix"><div>a.</div><div>United States<img src="<?php echo base_url();?>src/img/national_flags/Flag_of_the_United_States.svg"></div></div>
							<div class="f-body">
								<div class="f-sub-body-text clearfix"><div>i.</div><div><a href="<?php echo base_url();?>license">Pre-Licensing Education</a></div></div>
								<div class="f-sub-body-text clearfix"><div>ii.</div><div><a href="<?php echo base_url();?>license?page=1">License Exam</a></div></div>
								<div class="f-sub-body-text clearfix"><div>iii.</div><div><a href="<?php echo base_url();?>license?page=2">License Application</a></div></div>
								<div class="f-sub-body-text clearfix"><div>iv.</div><div><a href="<?php echo base_url();?>license?page=3">Continuing Education</a></div></div>
								<div class="f-sub-body-text clearfix"><div>vi.</div><div><a href="<?php echo base_url();?>license?page=4">Carrier Appointment</a></div></div>					
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="f-body">
						<div class="f-sub-body-text clearfix"><div>b.</div><div>Canada<img src="<?php echo base_url();?>src/img/national_flags/Flag_of_Canada.svg"></div></div>
						<div class="f-body">
							<div class="f-sub-body-text clearfix">TBD</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
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
		<div class="item-body">
			<div class="f-head f-head-g">
				<div>7</div>
				<div>Resources</div>
			</div>
			<div class="f-body">
				<div class="row">
					<div class="col-md-12">
						<div class="f-body">
							<div class="f-sub-body-text clearfix"><div>a.</div><div><a href="<?php echo base_url();?>license">Provider resource (web training etc)</a></div></div>
							<div class="f-sub-body-text clearfix"><div>b.</div><div><a href="<?php echo base_url();?>license?page=1">Lilyfortuneclub.com tools</a></div></div>
							<div class="f-sub-body-text clearfix"><div>c.</div><div><a href="<?php echo base_url();?>license?page=2">Facebook live and recorded videos</a></div></div>
							<div class="f-sub-body-text clearfix"><div>d.</div><div><a href="<?php echo base_url();?>license?page=3">WFG resources</a></div></div>
							<div class="f-body">
								<div class="f-sub-body-text clearfix"><div>i.</div><div><a href="<?php echo base_url();?>license">Web Training(in sales force and WFG talks)</a></div></div>
								<div class="f-sub-body-text clearfix"><div>ii.</div><div><a href="<?php echo base_url();?>license?page=1">Ed Mylett web</a></div></div>
								<div class="f-sub-body-text clearfix"><div>iii.</div><div><a href="<?php echo base_url();?>license?page=1">Sales Force</a></div></div>
								<div class="f-sub-body-text clearfix"><div>iv.</div><div><a href="<?php echo base_url();?>license?page=1">Campaign Manager</a></div></div>
								<div class="f-sub-body-text clearfix"><div>vi.</div><div><a href="<?php echo base_url();?>license?page=1">Mywfg.com other tools</a></div></div>
							</div>
							<div class="f-sub-body-text clearfix"><div>f.</div><div>Books/Audio/Video (Technical, and business, Jonathan CD)</div></div>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>
</div>
