<div data-role="page" id="event-list" data-theme="d">
	<?php $this->load->view('mobile/header', array('header_text' => 'Seminar'));?>
	<div data-role="main" class="ui-content" data-theme="d">
		<form class="ui-filterable ui-content ui-mini ">
			<input id="event-filter" data-type="search">
		</form>
		<ul data-role="listview" data-filter="true" data-input="#event-filter">
			<?php
			foreach($list as $l){
			?>
			<li class="clearfix">
			<a href="src/schedule/<?php echo $l['schedule_year'].'/'.$l['file'];?>" target="_blank" class="nondisc" data-transition="slide" style='font-weight:normal'>
				<?php
				$text = $l['schedule_year'].'-'.$l['schedule_month'].', '.(empty($l['office_name']) ? 'Other' : $l['office_name']).', '.$l['file'];
				echo $text;
				?>
			</a>
			</li>			
			<?php
			}
			?>
		</ul>
	</div>
</div>
