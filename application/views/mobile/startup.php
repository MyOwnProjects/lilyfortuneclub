<?php
foreach($pages as $i => $p){
?>
<div data-role="page" id="startup-<?php echo $i;?>" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Startup'));?>
	<div data-role="content">
		<div>
			<h2 style="text-align:center"><?php echo $p['subject'];?></h2>
			<div style="margin:20px auto;width:40%;max-width:100px">
				<img src="<?php echo $p['icon'];?>" style="width:100%">
			</div>
			<?php 
			if(isset($p['question'])){
			?>
			<div><?php echo $p['question'];?></div>
			<?php
			}
			?>
			<?php
			foreach($p['text'] as $t){
			?>
			<p><?php echo $t;?></p> 
			<?php
			}
			if(array_key_exists('btn', $p)){
			?>
			<div><a data-ajax="false" data-role="button" class="ui-btn ui-btn-inline ui-corner-all" href="<?php echo $p['btn']['url'];?>"><?php echo $p['btn']['text'];?></a></div>
			<?php
			}
			?>
			<div class="page-nav">
				<a class="nav-prev <?php echo $i <= 0 ? 'ui-disabled' : ''?>" data-role="button" data-icon="arrow-l" href="startup#startup-<?php echo $i - 1;?>" data-transition="slide" data-iconpos="left" data-inline="true" data-mini="true" data-theme="b" data-direction="reverse">Prev</a>
				<a class="nav-next <?php echo $i >= count($pages) - 1 ? 'ui-disabled' : ''?>" data-role="button" data-icon="arrow-r" href="startup#startup-<?php echo $i + 1;?>" data-transition="slide" data-iconpos="right" data-inline="true" data-mini="true" data-theme="b">Next</a>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
