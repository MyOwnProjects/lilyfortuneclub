<style>
ul.doc-list, ul.doc-list li{list-style:none;margin:0;padding:0}
ul.doc-list li{padding:20px 10px 20px 20px}
ul.doc-list li{border-top:1px solid #efefef}
.doc-icon{float:left;font-size:60px;margin-right:20px}
.doc-type{float:right;margin-left:20px;width:100px;text-align:center;line-height:60px}
.doc-text{overflow:hidden}
.doc-subject{margin-bottom:10px;height:18px;font-size:18px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.doc-abstract{line-height:16px;height:32px;}
</style>
<div class="wrapper-900">
	<div class="clearfix" style="margin-top:20px;padding-left:20px">
		<div class="pull-left" style="line-height:40px"><a href="<?php echo base_url();?>">Account</a> > Documents > list</div>
		<div class="pull-right" style="line-height:40px;font-size:14px;text-align:right">
			<div class="pull-right dropdown">
				Content
				<button class="btn btn-link dropdonw-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $content_type;?>&nbsp;<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url();?>account/documents<?php echo empty($mime_type) ? '' : "?mime_type=$mime_type";?>">All</a></li>
					<?php
					foreach($content_type_list as $ct){
						echo '<li><a href="'.base_url().'account/documents?content_type='.$ct.(empty($mime_type) ? '' : "&mime_type=$mime_type").'">'.$ct.'</a></li>';
					}
					?>
				</ul>
			</div>
		</div>
	</div>
	<ul class="doc-list">
		<li class="clearfix">
			<div class="doc-icon">
				<i class="fa fa-file-pdf-o"></i>
			</div>
		</li>
	<?php
	foreach($list as $l){
	?>
		<li class="clearfix">
			<div class="doc-icon" style="color:<?php echo doc_icon_color($l['mime_type']);?>">
				<?php
				$a = array_unique($l['mime_type']);
				foreach($a as $mt){
					echo '<i class="fa fa-file-'.$mt.'-o"></i>';
				}
				?>
			</div>
			<div class="doc-type"><?php echo $l['content_type'];?></div>
			<div class="doc-text">
				<div class="doc-subject"><a href="<?php echo base_url();?>account/documents/view/<?php echo $l['uniqid'];?>" target="_blank"><?php echo $l['subject'];?></a></div>
				<div class="doc-abstract"><?php echo $l['abstract'];?></div>
			</div>
		</li>
		
			<?php continue;
			if(!empty($l['file_name'])){
				$file_size = filesize(getcwd().'/application/documents/'.$l['uniqid'].'.'.$l['file_name']);
				if($file_size / 1024 < 1){
					$file_size = number_format($file_size, 0).' B';
				}
				else if($file_size / 1024 / 1024 < 1){
					$file_size = number_format($file_size / 1024, 0).' KB';
				}
				else{
					$file_size = number_format($file_size / 1024 / 1024, 0).' MB';
				}
				echo '<div class="pull-left icon"><img src="'.base_url().'src/img/file_type/'.$l['mime_type'][1].'.png'.'"></div>';
			}
			else{
				echo '<div class="pull-left icon"><img src="'.base_url().'src/img/file_type/'.$l['mime_type'].'.png'.'"></div>';
			}
			echo '<div class="pull-right" style="width:80px;margin-left:20px;font-size:14px;">'.(empty($file_size) ? '&nbsp;' : $file_size).'</div>';
			echo '<div class="pull-right" style="width:80px;margin-left:20px;font-size:14px;">'.$l['mime_content_type'].'</div>';
			if(!empty($l['subject'])){
				echo '<div class="overflow:hidden"><a href="'.base_url(),'account/documents/view/'.$l['uniqid'].'" target="_blank">'.$l['subject'].'</a></div>';
			}
			else{
				echo '<div class="overflow:hidden"><a href="'.base_url(),'account/documents/view/'.$l['uniqid'].'" target="_blank">'.$l['file_name'].'</a></div>';
			}
			?>
		</li>
	<?php
	}
	?>
		<li style="font-size:14px;text-align:center">
			<a class="btn btn-link <?php echo count($list) == 0 ? 'disabled' : '';?>" href="<?php echo base_url().'account/documents?pg=1'.(empty($mime_type) ? '' : "&mime_type=$mime_type")
				.(empty($content_type) ? '' : "&content_type=$content_type");?>"><span class="glyphicon glyphicon-step-backward"></span></a>
			<a class="btn btn-link <?php echo $current > 1 ? '' : 'disabled';?>" href="<?php echo base_url().'account/document?pg='.($current - 1)
				.(empty($mimt_type) ? '' : "&mime_type=$mime_type")
				.(empty($content_type) ? '' : "&content_type=$content_type");?>"><span class="glyphicon glyphicon-backward"></span></a>
			<?php echo (empty($list) ? 0 : $current).' / '.$total;?>
			<a class="btn btn-link <?php echo $current < $total ? '' : 'disabled';?>" href="<?php echo base_url().'account/document?pg='.($current + 1)
				.(empty($mimt_type) ? '' : "&mime_type=$mime_type")
				.(empty($content_type) ? '' : "&content_type=$content_type");?>"><span class="glyphicon glyphicon-forward"></span></a>
			<a class="btn btn-link <?php echo count($list) == 0 ? 'disabled' : '';?>" href="<?php echo base_url().'account/documents?pg='.$total.(empty($mime_type) ? '' : "&mime_type=$mime_type")
				.(empty($content_type) ? '' : "&content_type=$content_type");?>"><span class="glyphicon glyphicon-step-forward"></span></a>
		</li>
	</ul>
</div>
<script>
$('#doc-list-filter-content, #doc-list-filter-type').change(function(){
	
});
</script>
