<?php
foreach($pages as $i => $p){
?>
<div data-role="page" id="step-<?php echo $i;?>" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Business'));?>
	<div data-role="content" data-theme="d">
		<h4>Step <?php echo $i + 1;?>.&nbsp;<?php echo $p['subject'];?></h4>
		<ul class="list1">
			<?php 
			foreach($p['list'] as $l){
			?>
			<li <?php echo array_key_exists('id', $l) ? 'id="'.$l['id'].'"' : '';?>>
				<?php echo $l['text'];?>
				<?php
				if(array_key_exists('sub_list', $l) && $l['sub_list']){
				?>
				<ul class="list2">
					<?php
					foreach($l['sub_list'] as $sl){
					?>
					<li><?php echo $sl;?></li>
					<?php
					}
					?>
				</ul>
				<?php
				}
				?>
			</li>
			<?php
			}
			?>
		</ul>
		<div class="page-nav">
			<?php if($i > 0){?>
			<a class="nav-prev" data-role="button" data-icon="arrow-l" href="business#step-<?php echo $i - 1;?>" data-transition="slide" data-iconpos="left" data-inline="true" data-mini="true" data-direction="reverse">Prev</a>
			<?php
			}
			if($i < count($pages) - 1){
			?>
			<a class="nav-next" data-role="button" data-icon="arrow-r" href="business#step-<?php echo $i + 1;?>" data-transition="slide" data-iconpos="right" data-inline="true" data-mini="true">Next</a>
			<?php
			}
			?>
		</div>
	</div>
</div>
<?php
}
?>
<div data-role="page" id="invitation-why">
	<div data-role="header" data-theme="e">
		<h1>Bring your guest to office</h1>
		<a data-rel="back" data-icon="back" data-iconpos="notext" data-direction="reverse">Back</a>
	</div>
	<div data-role="content">
		<?php foreach($invitation_why as $iw){
		?>
		<div>
			<u><?php echo $iw['subject'];?></u>
			<?php echo $iw['text'];?>
		</div>
		<?php }?>
	</div>
</div>
<div data-role="page" id="invitation-how">
	<div data-role="header" data-theme="e">
		<b>How to invite your guests?</b>
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
<div data-role="page" id="invitation-scripts">
	<div data-role="header" data-theme="e">
		<b>Invitation Scripts</b>
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
<div data-role="page" id="invitation-scripts-cn">
	<div data-role="header" data-theme="e">
		<b>中文邀请示例</b>
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
<div data-role="page" id="objection">
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
				<input type="checkbox" name="edit-prospect-profile-<?php echo $i;?>" id="edit-prospect-profile-<?php echo $i;?>" value="" data-mini="true">
				<?php
				}
				?>
			</fieldset>
		</div>
		<div class="ui-field-contain">
			<label for="edit-prospect-background">Background:</label>
			<textarea name="edit-prospect-background" id="edit-prospect-background"></textarea>
		</div>
		<div class="ui-field-contain" style="text-align:right"><a id="submit-prospect" data-role="button" class="ui-btn ui-corner-all ui-mini ui-btn-mini ui-btn-inline ui-btn-b" onclick="save_prospect();">Save</a></div>
	</div>
</div>

<div id="delete-prospect-opoup-content" style="display:none">
	<p data-theme="e">Delete this prospect?</p>
	<div>
	<a href="#" data-rel="back" class="ui-btn ui-btn-inline ui-corner-all ui-mini" data-mini="true">Delete</a>
	<a href="#" data-rel="back" class="ui-btn ui-btn-inline ui-corner-all">Cancel</a>
	</div>
</div>
<script>
var edit_prospect_id = 0;

function load_prospect(){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	var pl = $('#prospect-list');
	pl.empty();
	$.ajax({
		url: '<?php echo base_url();?>account/business/get_prospect_list',
		dataType: 'json',
		success: function(data){
			if(data.length > 0){
				for(var i = 0; i < data.length; ++i){
					$('<li>').attr('data-id', data[i]['prospects_id']).addClass("clearfix").addClass("ui-li-static").addClass("ui-body-inherit")
						.append('<span>' + data[i]['prospects_name'] + '</span>')
						.append('<span class="delete-prospect ui-btn ui-btn-icon-notext ui-icon-delete ui-corner-all ui-btn-inline"></span>')
						.append('<span class="edit-prospect ui-btn ui-btn-icon-notext ui-icon-edit ui-corner-all ui-btn-inline"></span>')
						.appendTo(pl);
				}
			}
			else{
				pl.children(':first-child').html('No prospects').appendTo(pl);
			}
		},
		error: function(){
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
}

function delete_prospect(){

}

function edit_prospect(){
alert(1);
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	$.ajax({
		url: '<?php echo base_url();?>account/business/update_prospect/' + edit_prospect_id,
		dataType: 'json',
			success: function(data){
				if(data['success']){
					$.mobile.changePage('bisubess#edit-prospect', { transition: "slide"} );
				}
				else{
					$('#popup').html().popup('open');
				}
			},
			error: function(){
			},
			complete: function(){
				$.mobile.loading( 'hide', {
					theme: 'z',
					html: ""
				});
			}
		});
}

function save_prospect(){
	$.mobile.loading( 'show', {
		theme: 'z',
		html: ""
	});
	var profile = [];
	for(var i = 7; i >= 0; --i){
		profile.push($('#edit-prospect-profile-' + i).is(':checked') ? 1 : null);
	}
	$.ajax({
		url: '<?php echo base_url();?>account/business/update_prospect',
		method: 'post',
		data: {
			name: $('#edit-prospect-name').val(),
			relationship: $('[name=edit-prospect-relationship]:checked').val(),
			phone: $('#edit-prospect-phone').val(),
			email: $('#edit-prospect-email').val(),
			profile: profile,
			background: $('#edit-prospect-background').val(),
		},
		dataType: 'json',
		success: function(data){
			if(data['success']){
				$('#edit-prospect [data-rel="back"]').click();
			}
			else{
			}
		},
		error: function(){
		},
		complete: function(){
			$.mobile.loading( 'hide', {
				theme: 'z',
				html: ""
			});
		}
	});
}
	
$(document).on("pageshow","#prospects",function(){
	load_prospect();
}).on('pagebeforeshow', '#edit-prospect', function(){
	$('#edit-prospect [data-role=header] h1').html(edit_prospect_id ? 'Edit Proespect' : 'New Proespect');
}).on('pagehide', '#edit-prospect', function(){
	edit_prospect_id = 0;
}).delegate('.edit-prospect', 'click', function(){
	edit_prospect_id = $(this).parent().attr('data-id');
	edit_prospect();
}).delegate('.delete-prospect', 'click', function(){
	edit_prospect_id = $(this).parent().attr('data-id');
	$('#popup').html($('#delete-prospect-opoup-content').html()).popup('open');
	delete_prospect();
});
</script>
