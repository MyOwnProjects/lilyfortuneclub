<style>
.nav-tabs-2>li{width:50%}
.tab-content-page{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content img{width:100%}
.tab-content .detail-url{display:none}
.tab-content .detail-url a{color:red;text-decoration:underline}
.content-list{padding:20px 0}
.courses-block{border-bottom:1px solid #d5d5d5}
.courses-block:not(:first-child){padding:20px 10px}
.courses-block:first-child{padding:0 10px 20px 10px}
@media only screen and (max-width:768px) {
.tab-content img{display:none}
.tab-content .detail-url{display:inline;}
.content-list{padding:0}
}
</style>
<div class="main-body-header">Courses</div>
<div class="text-center">We provide 20 courses and materials. Please check the face to face <a href="<?php echo base_url();?>schedule">course schedule</a>.</div>
<div class="main-body-wrapper clearfix">
	<div style="margin:0 auto;max-width:800px;padding:20px 0 80px 0;">
	<ul class="nav nav-tabs nav-tabs-2 clearfix" id="top-tab">
		<li class="active"><a data-toggle="tab" href="#courses-F">Financial Concept Classes</a></li>
		<li><a data-toggle="tab" href="#courses-B">BFS/Marketing Classes</a></li>
	</ul>
	<div id="tab-content-pages" class="tab-content">
		<?php
		$types = array('F', 'B');
		foreach($types as $j => $type){
		?>
		<div id="courses-<?php echo $type;?>" class="tab-pane fade <?php echo $j == 0 ? 'in active' : '';?> tab-content-page">
			<?php
			$i = 0;
			foreach($courses as $c){
				if($c['courses_type'] == $type){
			?>
			<div class="courses-block">
				<h4><?php echo $type.(++$i).'. '.$c['courses_topic'];?></h4>
				<p class="course-desc"><?php echo $c['courses_desc'];?></p>
				<div class="clearfix" style="font-size:16px">
					<?php
					foreach($c['docs'] as $d){
						$mt = mime_type(getcwd().'/src/doc/'.$d['uniqid'].'.'.$d['file_name']);
						echo '<div class="pull-left" style="margin-right:20px"><i class="fa fa-file-'.$mt[0].'-o" style="color:'.doc_icon_color($mt).'"></i>&nbsp;';
						echo '<a href="'.base_url().'documents/view/'.$d['uniqid'].'" target="_blank">'.$d['subject'].'</a>';
						echo '</div>';
					}
					?>
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
	</div>
</div>
