<style>
.screen-shot-btn{color:#ea7600;}
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
			?>
			<li id="<?php echo $j;?>">
				<?php echo $l;?>&nbsp;[<a href="javascript:void(0)">Detail</a>]
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
<div data-role="page" id="invitation-why" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Bring your guest to office</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="content">
	</div>
</div>
<div data-role="page" id="invitation-how" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>How to invite your guests?</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="content">
		<?php foreach($invitation_how as $ih){
		?>
		<div>
			<u><?php echo $ih['subject'];?></u>
			<ul class="list3">
			<?php foreach($ih['list'] as $l){
			?>
				<li><?php echo $l;?></li>
			<?php
			}?>
			</ul>
		</div>
		<?php }?>
	</div>
</div>
<div data-role="page" id="invitation-scripts" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Invitation Scripts</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="content">
		<?php foreach($invitation_scripts as $ih){
		?>
		<div>
			<u><?php echo $ih['subject'];?></u>
			<ul class="list3">
			<?php foreach($ih['list'] as $l){
			?>
				<li><?php echo $l;?></li>
			<?php
			}?>
			</ul>
		</div>
		<?php }?>
	</div>
</div>
<div data-role="page" id="invitation-scripts-cn" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>中文邀请示例</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="content">
		<?php foreach($invitation_scripts_cn as $ih){
		?>
		<div>
			<u><?php echo $ih['subject'];?></u>
			<ul class="list3">
			<?php foreach($ih['list'] as $l){
			?>
				<li><?php echo $l;?></li>
			<?php
			}?>
			</ul>
		</div>
		<?php }?>
	</div>
</div>
<div data-role="page" id="objection" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Handling Objection</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="content">
		<?php foreach($objection as $o){
		?>
		<div>
			<u><?php echo $o['subject'];?></u>
			<?php echo $o['text'];?>
		</div>
		<?php }?>
	</div>
</div>

<div data-role="page" id="prospects" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>Prospect List</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="main">
		<form class="ui-filterable ui-content ui-mini ">
			<input id="prospect-filter" data-type="search">
		</form>
		<div class="clearfix">
			<button class="ui-btn ui-btn-icon-notext ui-icon-refresh ui-corner-all ui-btn-inline ui-mini " data-mini="true" onclick="load_prospect();"></button>
		<a href="business#edit-prospect" class="nondec" data-transition="slide"><span class="ui-btn ui-btn-icon-notext ui-icon-plus ui-corner-all ui-btn-inline ui-mini"></span></a>
		</div>
			<ol class="list4" id="prospect-list" data-role="listview" data-filter="true" data-input="#prospect-filter">
		</ol>
	</div>
</div>
<div data-role="page" id="edit-prospect" data-theme="d">
	<div data-role="header" data-theme="e">
		<h1>&nbsp;</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="main" class="ui-content">
		<div class="ui-field-contain">
			<label for="edit-prospect-name">Name:</label>
			<input type="text" name="edit-prospect-name" id="edit-prospect-name" value="">
		</div>
		<div class="ui-field-contain">
			<label for="name">Relationship:</label>
			<fieldset data-role="controlgroup" data-type="horizontal" >
				<label for="edit-prospect-relationship-r">Relative</label>
				<input type="radio" name="edit-prospect-relationship" id="edit-prospect-relationship-r" value="R" data-mini="true" checked>
				<label for="edit-prospect-relationship-f">Friend</label>
				<input type="radio" name="edit-prospect-relationship" id="edit-prospect-relationship-f" value="F" data-mini="true">
				<label for="edit-prospect-relationship-a">Associate</label>
				<input type="radio" name="edit-prospect-relationship" id="edit-prospect-relationship-a" value="A" data-mini="true">
			</fieldset>
		</div>
		<div class="ui-field-contain">
			<label for="edit-prospect-phone">Phone:</label>
			<input type="text" name="edit-prospect-phone" id="edit-prospect-phone" value="">
		</div>
		<div class="ui-field-contain">
			<label for="edit-prospect-name">Email:</label>
			<input type="email" name="edit-prospect-email" id="edit-prospect-email" value="">
		</div>
		<div class="ui-field-contain">
			<label for="profile">Profile:</label>
			<?php $profile_list = array('25+ Years', 'Married', 'Children', 'Home Owner', 'Solid Business Background', 'Income', 'Dissatisfied', 'Entrepreneurial');?>
			<fieldset data-role="controlgroup" data-type1="horizontal">
				<?php
				foreach($profile_list as $i => $p){
				?>
				<label for="edit-prospect-profile-<?php echo $i;?>"><?php echo $p;?></label>
				<input type="checkbox" class="edit-prospect-profile" name="edit-prospect-profile-<?php echo $i;?>" id="edit-prospect-profile-<?php echo $i;?>" value="" data-mini="true">
				<?php
				}
				?>
			</fieldset>
		</div>
		<div class="ui-field-contain">
			<label for="edit-prospect-background">Background:</label>
			<textarea name="edit-prospect-background" id="edit-prospect-background" rows="5"></textarea>
		</div>
		<div class="ui-field-contain" style="text-align:right"><a id="submit-prospect" data-role="button" class="ui-btn ui-corner-all ui-mini ui-btn-mini ui-btn-inline ui-btn-b" onclick="save_prospect();">Save</a></div>
	</div>
</div>

<div data-role="page" data-dialog="true" id="confirm-delete-prospect" data-theme="e" data-overlay-theme="d">
	<div data-role="header" >
		<h1>Confirmation!</h1>
	</div>	
	<div data-role="main" class="ui-content" data-theme="e">
		<p>Delete this prospect?</p>
		<div style="text-align:right">
			<a data-role="button" data-rel="back" data-inline="true" data-mini="true" data-theme="e" onclick="delete_prospect();">Delete</a>
			<a data-role="button" data-rel="back" data-inline="true" data-mini="true" data-theme="d">Cancel</a>
		</div>
	</div>
</div>

<script>
$(document).on("pageshow","#prospects",function(){
	selected_prospect_id = 0;
	load_prospect();
}).on('pagebeforeshow', '#edit-prospect', function(){
	$('#edit-prospect [data-role=header] h1').html(selected_prospect_id ? 'Edit Prospect' : 'New Prospect');
}).on('pagehide', '#edit-prospect', function(){
	selected_prospect_id = 0;
	$('#edit-prospect-name').val('');
	$('[name=edit-prospect-relationship]').each(function(index, obj){
		$(obj).prop( 'checked', index === 0).checkboxradio( 'refresh' );	
	});
	$('#edit-prospect-phone').val('');
	$('#edit-prospect-email').val('');
	for(var i = 0; i < 8; ++i){
		$('#edit-prospect-profile-' + i).prop('checked', false).checkboxradio('refresh');;
	}
	$('#edit-prospect-background').val('');
}).delegate('.edit-prospect', 'click', function(){
	selected_prospect_id = $(this).parent().attr('data-id');
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	$.ajax({
		url: '<?php echo base_url();?>account/business/get_prospect/' + selected_prospect_id,
		dataType: 'json',
		success: function(data){
			if(data.length > 0){
			$('#edit-prospect-name').val(data[0]['prospects_name']);
			$('[name=edit-prospect-relationship]').each(function(index, obj){
				$(obj).prop( 'checked', $(obj).val() == data[0]['prospects_relationship']).checkboxradio( 'refresh' );	
			});
			//relationship: $('[name=edit-prospect-relationship]:checked').val(),
			$('#edit-prospect-phone').val(data[0]['prospects_phone']);
			$('#edit-prospect-email').val(data[0]['prospects_email']);
			var v = data[0]['prospects_profile'];
			for(var i = 8; i > 0; --i){
				var checked = v % 2;
				v = Math.floor(v / 2);
				$('#edit-prospect-profile-' + (i - 1)).prop('checked', checked).checkboxradio('refresh');;
			}
			$('#edit-prospect-background').val(data[0]['prospects_background']);
			//edit_prospect();
			}
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
}).delegate('.delete-prospect', 'click', function(){
	selected_prospect_id = $(this).parent().attr('data-id');
});
</script>
