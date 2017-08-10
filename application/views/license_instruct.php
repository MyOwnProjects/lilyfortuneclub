<style>
.img-wrapper{margin:0 0 40px 40px}
 .img-wrapper img{cursor:pointer;height:300px;border:1px solid #fff}
 .img-wrapper img:hover{border:1px solid #ddd}
 .screen-shot-btn{color:#ea7600;}
 .subject1{font-size:16px}
.list1{list-style-type:none;line-height:20px;list-style-position:outside;font-size:16px;padding:0;margin:0;}
.list1>li{padding-left:30px;margin:25px 0;}
.list1>li{background:url('<?php echo base_url();?>src/img/finger-of-a-hand-pointing-to-right-direction.svg') no-repeat 0 0;background-size:20px 20px}
.list2{list-style-type:none;line-height:20px;list-style-position:outside;font-size:14px;margin:40px 0 0 0;}
.list2>li{padding-left:20px;margin:10px 0}
.list2 li.important{background:url('<?php echo base_url();?>src/img/important.svg') no-repeat 0 2px;background-size:16px 16px}
.list2 li.info{background:url('<?php echo base_url();?>src/img/information.svg') no-repeat 0 2px;background-size:16px 16px}
.list3{list-style-type:none;line-height:20px;list-style-position:outside;margin:0;padding:0;}
.list3 li:before{content:'- '}
.list4{padding-left:20px;line-height:25px;font-size:16px;margin-top:5px}
.list5{font-size:12px;list-style-position:inside;padding:0;margin:0 0 20px 0;}
.list5s li:nth-child(odd){color:#000}
.list5s li:nth-child(even){color:#999}
</style>
	<ul class="breadcrumb" style="border-bottom:1px solid #d5d5d5">
		<li><a href="<?php echo base_url();?>account">Account</a></li>
		<li><a href="<?php echo base_url();?>account/license">License</a></li>
		<li><?php echo $instruct['subject'];?></li>
	</ul>
<div style="margin:0 auto;max-width:1000px;padding:20px 0 80px 0;">
	<div class="row" style="margin-bottom:20px">
		<h2 class="text-center"><?php echo $instruct['subject'];?></h2>
		<div class="text-center" style="font-size:16px">Follow the instruction to register the 52 hours online courses.</div>
	</div>
	
	<div class="row">
		<?php
		foreach($instruct['steps'] as $i => $s){
		?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div style="padding:0 20px">
				<h4 class="text-left"><?php echo ($i + 1).'. '.$s;?></h4>
				<?php 
				$img = $instruct['image_file_name'].'-'.  str_pad($i + 1, 2, '0', STR_PAD_LEFT).'.png';
				if(file_exists(getcwd().'/src/img/license/'.$img)){
				?>
				<div class="img-wrapper">
					<img src="<?php echo base_url();?>src/img/license/<?php echo $img;?>">
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
</div>
<script></script>