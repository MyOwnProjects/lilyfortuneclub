<style>
ul.doc-list, ul.doc-list li{list-style:none;margin:0;padding:0}
ul.doc-list li{padding:20px 10px 20px 20px}
ul.doc-list li{border-top:1px solid #efefef}
.doc-icon{float:left;font-size:60px;line-height:60px;height:60px;margin-right:20px}
.doc-type{float:right;margin-left:20px;width:100px;text-align:center;line-height:60px}
.doc-text{overflow:hidden}
.doc-subject{margin-bottom:6px;height:22px;font-size:18px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.doc-subject{text-decoration:none}
.doc-abstract{line-height:16px;height:32px;}
@media only screen and (max-width:768px) {
ul.doc-list li{padding:0 20px}
.doc-icon{font-size:20px;line-height:30px;height:30px;margin-right:10px}
.doc-subject{font-size:14px;line-height:30px;height:30px}
.doc-text .doc-abstract{display:none}
.doc-type{display:none}
.doc-subject{margin-bottom:0;height:20px;font-size:16px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
}
</style>
<div class="wrapper-900">
	<div class="clearfix" style="margin-top:20px;padding-left:20px">
		<div class="pull-right" style="line-height:40px;font-size:14px;text-align:right">
			<div class="pull-right dropdown">
				Content
				<button class="btn btn-link dropdonw-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $content_type;?>&nbsp;<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url();?>documents<?php echo empty($mime_type) ? '' : "?mime_type=$mime_type";?>">All</a></li>
					<?php
					foreach($content_type_list as $ct){
						echo '<li><a href="'.base_url().'documents?content_type='.$ct.(empty($mime_type) ? '' : "&mime_type=$mime_type").'">'.$ct.'</a></li>';
					}
					?>
				</ul>
			</div>
		</div>
	</div>
	<ul class="doc-list">
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
			<div class="doc-type"><a href="<?php echo base_url();?>documents?content_type=<?php echo $l['content_type'];?>"><?php echo $l['content_type'];?></a></div>
			<div class="doc-text">
				<div class="doc-subject"><a href="<?php echo base_url();?>documents/view/<?php echo $l['uniqid'];?>" target="_blank"><?php echo $l['subject'];?></a></div>
				<div class="doc-abstract"><?php echo $l['abstract'];?></div>
			</div>
		</li>
	<?php
	}
	?>
		<li style="font-size:14px;text-align:center">
			<a class="btn btn-link <?php echo count($list) == 0 ? 'disabled' : '';?>" href="<?php echo base_url().'documents?pg=1'.(empty($mime_type) ? '' : "&mime_type=$mime_type")
				.(empty($content_type) ? '' : "&content_type=$content_type");?>"><span class="glyphicon glyphicon-step-backward"></span></a>
			<a class="btn btn-link <?php echo $current > 1 ? '' : 'disabled';?>" href="<?php echo base_url().'document?pg='.($current - 1)
				.(empty($mimt_type) ? '' : "&mime_type=$mime_type")
				.(empty($content_type) ? '' : "&content_type=$content_type");?>"><span class="glyphicon glyphicon-backward"></span></a>
			<?php echo (empty($list) ? 0 : $current).' / '.$total;?>
			<a class="btn btn-link <?php echo $current < $total ? '' : 'disabled';?>" href="<?php echo base_url().'document?pg='.($current + 1)
				.(empty($mimt_type) ? '' : "&mime_type=$mime_type")
				.(empty($content_type) ? '' : "&content_type=$content_type");?>"><span class="glyphicon glyphicon-forward"></span></a>
			<a class="btn btn-link <?php echo count($list) == 0 ? 'disabled' : '';?>" href="<?php echo base_url().'documents?pg='.$total.(empty($mime_type) ? '' : "&mime_type=$mime_type")
				.(empty($content_type) ? '' : "&content_type=$content_type");?>"><span class="glyphicon glyphicon-step-forward"></span></a>
		</li>
	</ul>
</div>
<script>
$('#doc-list-filter-content, #doc-list-filter-type').change(function(){
	
});
</script>
