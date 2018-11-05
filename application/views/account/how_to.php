<style>
.main-content-wrapper{max-width:none}
.menu-ico-url .btn{width:100%;padding:0 40px;margin:20px auto;text-align:left}
.list-icon{float:left;padding:25px 10px 25px 0}
.list-text{overflow:hidden;line-height:80px;font-size:16px}
.list-icon img{height:30px}
p{margin:0 0 20px 16px;}
h4{margin-top:40px;}
@media only screen and (max-width:768px) {
.main-content-wrapper{padding:20px}
.list-icon img{height:30px}
.list-icon{float:left;padding:10px 10px 10px 0}
.list-text{overflow:hidden;line-height:50px;font-size:16px}
.menu-ico-url .btn{margin:10px auto;padding:0 20px}
}
</style>
<div class="main-content-wrapper" style="width:100%;max-width:1000px">
	<div class="row" style="margin-bottom:20px">
		<h2 class="text-center">How to ...</h2>
	</div>
	<div class="row">
		<?php
		foreach($list as $n => $l){
		?>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 clearfix">
			<?php 
			$url = array_key_exists('url', $l) ? $l['url'] : base_url().'how_to';
			?>
			<a class="menu-ico-url" href="<?php echo $url.(array_key_exists('content', $l) ? '#'.$n : '');?>">
				<div class="btn btn-default">
					<div class="list-icon"><img src="<?php echo base_url();?>src/img/<?php echo $l['img'];?>"></div>
					<div class="list-text"><?php echo $l['text'];?></div>
				</div>
			</a>
		</div>
		<?php
		}
		?>
	</div>
	<?php
	foreach($list as $n => $l){
		if(!array_key_exists('content', $l)){
			continue;
		}
	?>
	<div class="row" <?php echo array_key_exists('content', $l) ? 'id="'.$n.'"' : '';?>>
		<div class="col-sm-12">
			<h4>
			<?php
			echo $l['text'];
			?>
			</h4>
			<div>
			<?php
			echo $l['content'];
			?>
			</div>
		</div>
	</div>
	
	<?php
	}
	?>
</div>
