<style>
.screen-shot-btn{color:#ea7600;}
.detail-text{margin:10px 20px}
.detail-img{margin:20px}
</style>
<?php
$pages = $summary['steps'];
foreach($pages as $i => $p){
?>
<div data-role="page" id="step-<?php echo $i;?>" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'License'));?>
	<div data-role="content" data-theme="d">
		<h4><?php echo $p['subject'];?></h4>
		<div><?php echo $p['comment'];?></div>
		<ol>
			<?php 
			foreach($p['instruct']['steps'] as $j => $l){
					$img = $p['instruct']['image_file_name'].'-'.  str_pad($j + 1, 2, '0', STR_PAD_LEFT).'.png';
					if(file_exists(getcwd().'/src/img/license/'.$img)){
						$img_url = base_url().'src/img/license/'.$img.'?'.time();
					}
					else{
						$img_url = '';
					}
			?>
			<li page-id="<?php echo $i;?>" step-id="<?php echo $j;?>">
				<?php 
				echo $l;
				if(!empty($img_url)){
				?>
				&nbsp;[<a href="license#step-detail" data-transition="slide" class="step-detail">Detail</a>]
				<?php
				}
				?>
			</li>
			<?php
			}
			?>
		</ol>
		<div class="page-nav">
			<a class="nav-prev <?php echo $i <= 0 ? 'ui-disabled' : ''?>" data-role="button" data-inline="true" data-mini="true" data-theme="b" data-icon="arrow-l" href="license#step-<?php echo $i - 1;?>" data-transition="slide" data-iconpos="left" data-direction="reverse">Prev</a>
			<a class="nav-next <?php echo $i >= count($pages) - 1 ? 'ui-disabled' : ''?>" data-role="button" data-icon="arrow-r" data-theme="b" href="license#step-<?php echo $i + 1;?>" data-transition="slide" data-iconpos="right" data-inline="true" data-mini="true">Next</a>
		</div>
	</div>
</div>
<?php
}
?>
<div data-role="page" id="step-detail" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Prospect List</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="main">
		<div class="detail-text"></div>
		<div class="detail-img">
			<img src="" style="width:100%">
		</div>
	</div>
</div>

<script>
var selected_page_id = 0;
var selected_step_id = 0;
$(document).on("pageshow","#step-detail",function(){
	;
}).on('pagebeforeshow', '#step-detail', function(){
	$('.detail-img img').attr('src', '');
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	$.ajax({
		url: '<?php echo base_url();?>account/license/get_step_detail?page=' + selected_page_id + '&step=' + selected_step_id,
		dataType: 'json',
		success: function(data){
			$('#step-detail h1').html(data['subject']);
			$('.detail-text').html(data['step']);
			$('.detail-img img').attr('src', '<?php echo base_url();?>' + 'src/img/license/' + data['image_file_name'] + '-' + String(selected_step_id + 1).padStart(2, '0') + '.png?'.time();
		},
		error: function(a, b, c){
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
}).delegate('.step-detail', 'click', function(){
	selected_page_id = parseInt($(this).parent().attr('page-id'));
	selected_step_id = parseInt($(this).parent().attr('step-id'));
});
</script>
