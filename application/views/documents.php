<style>
.doc-list{margin-bottom:100px;list-style:none}
.doc-list li{line-height:50px;font-size:16px;}	
.doc-list, .doc-list li:not(:first-child){border-top:1px dotted #e5e5e5}
.doc-list li .icon{margin-right:5px;}
.doc-list img{height:20px;}
</style>
<div class="wrapper-900">
	<div class="breadcrumb">Account > Documents > list</div>
	<div class="clearfix" style="font-size:14px;text-align:right">
		<div class="pull-right dropdown" style="margin-left:40px">
			Type
			<button class="btn btn-link dropdonw-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $mime_type;?>&nbsp;<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<li><a href="<?php echo base_url();?>account/documents<?php echo empty($content_type) ? '' : "?content_type=$content_type";?>">All</a></li>
				<?php
				foreach($mime_type_list as $mt){
					echo '<li><a href="'.base_url().'account/documents?mime_type='.$mt.(empty($content_type) ? '' : "&content_type=$content_type").'">'.$mt.'</a></li>';
				}
				?>
			</ul>
		</div>
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
	<ul class="doc-list">
	<?php
	foreach($list as $l){
	?>
		<li class="clearfix">
			<?php
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
				echo '<div class="overflow:hidden"><a href="'.base_url(),'account/documents/view/'.$l['uniqid'].'">'.$l['subject'].'</a></div>';
			}
			else{
				echo '<div class="overflow:hidden"><a href="'.base_url(),'account/documents/view/'.$l['uniqid'].'">'.$l['file_name'].'</a></div>';
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
