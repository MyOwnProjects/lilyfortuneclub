<style>
.nav-tabs{white-space:nowrap;overflow:ellipsis}	
.nav-tabs-2>li{width:50%}
.nav-tabs-3>li:not(:last-child){width:33%}
.nav-tabs-3>li:last-child{width:34%}
.nav-tabs-4>li{width:25%}
.nav-tabs-5>li{width:20%}
.tab-content-page{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content img{width:100%}
.tab-content .detail-url{display:none}
.tab-content .detail-url a{color:red;text-decoration:underline}
.content-list{padding:20px 0}
@media only screen and (max-width:768px) {
.tab-content img{display:none}
.tab-content .detail-url{display:inline;}
.content-list{padding:0}
}
</style>
<div style="margin:0 auto;max-width:1000px;padding:20px 0 80px 0;">
	<button class="pull-right btn btn-xs btn-primary" onclick="window.print();"><span class="glyphicon glyphicon-print"></span>&nbsp;Print</button>
		<h2 class="text-center">Get Your License</h2>
		<div class="text-center" style="font-size:16px;margin-bottom:20px"><?php echo $summary['summary'];?></div>
	
	<ul class="nav nav-tabs nav-tabs-<?php echo count($summary['steps']);?> clearfix" id="top-tab">
		<?php
		foreach($summary['steps'] as $i => $step){
		?>
		<li <?php echo $i == 0 ? 'class="active"' : '';?>><a data-toggle="tab" href="#license-page-<?php echo $i + 1;?>"><?php echo $step['title'];?></a></li>
		<?php
		}
		?>
	</ul>
	<div id="tab-content-pages" class="tab-content">
		<?php
		foreach($summary['steps'] as $i => $step){
		?>
		<div id="license-page-<?php echo $i + 1;?>" class="tab-pane fade <?php echo $i == 0 ? 'in active' : '';?> tab-content-page">
		<h4 class="text-center"><?php echo $step['subject'];?></h4>
		<p><?php echo $step['comment'];?></p>

		<?php
		foreach($step['steps'] as $j => $s){
		?>
			<div class="clearfix content-list">
				<div class="pull-left" style="width:30px">
					<h5><?php echo ($j + 1).'.'?></h5>
				</div>
				<?php 
				$image_exist = false;
				if(array_key_exists('image_file_name', $step)){
					$img = $step['image_file_name'].'-'.  str_pad($j + 1, 2, '0', STR_PAD_LEFT).'.png';
					$image_exist = file_exists(getcwd().'/src/img/license/'.$img);
				}
				?>
				<div style="overflow:hidden">
					<h5 class="text-left">
						<?php 
						echo '<p>'.str_replace('<br/>', '</p><p>', $s).($image_exist ? '<span class="detail-url">&nbsp;[<a href="'.base_url().'src/img/license/'.$img.'?'.time().'" target="_blank">Detail'.'</a>]</span>' : '').'</p>';
						?>
					</h5>
				<?php 
				if($image_exist){
				?>
				<div class="img-wrapper">
					<a href="<?php echo base_url();?>src/img/license/<?php echo $img;?>?<?php echo time();?>" target="_blank"><img src="<?php echo base_url();?>src/img/license/<?php echo $img;?>?<?php echo time();?>"></a>
				</div>
				<?php
				}
				?>
				</div>
			</div>
		<?php
		}
		?>
		</div>
		<?php
		}
		?>
	</div>
</div>

<script></script>
