<style>
.nav-tabs>li{width:25%}
.tab-content-page{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content-page p{margin-bottom:20px}
.tab-content-page p a{color:red;text-decoration:underline}
</style>
<div style="margin:0 auto;max-width:800px;padding:20px 0 80px 0;">
		<h2 class="text-center">Startup</h2>
	
	<ul class="nav nav-tabs clearfix" id="top-tab">
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
		<div id="license-page-<?php echo $i + 1;?>" class="tab-pane fade <?php echo $i == 0 ? 'in active' : ''; ?> tab-content-page">
			<h3 class="text-center"><?php echo $step['subject'];?></h3>

		<?php
		foreach($step['steps'] as $j => $s){
			echo $s;
		}
		?>
		</div>
		<?php
		}
		?>
	</div>
</div>
