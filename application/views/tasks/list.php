<style>
.doc-list li{font-size:13px;line-height:40px}
.doc-list>li>div{overflow:hidden;white-space:nowrap;text-overflow:ellipsis}
.doc-list>li>div:not(:last-child){text-align:center;}
.doc-list>li>div:first-child,.doc-list>li>div:nth-child(2){width:70px}
.doc-list>li>div:nth-child(3),.doc-list>li>div:nth-child(5){width:120px}
.doc-list>li>div:nth-child(4){width:80px}
.doc-list>li>div:last-child{overflow:hidden;padding-left:10px}
.dropdown a,.dropdown .btn-link{text-decoration:none;color:#000}
@media only screen and (max-width:600px) {
.doc-list li:first-child{border-top:none;display:none}
.doc-list li>div:not(:last-child){display:none}
.doc-list li>div:last-child{padding-left:10px}
}
	
</style>
<div class="resource-list  main-content-wrapper">
	<div class="breadcrumb">Home > Tasks > list</div>
	<div class="clearfix" style="font-size:14px;text-align:right;margin-top:10px">
		<div class="pull-right dropdown">
			Priority
			<button class="btn btn-link dropdonw-toggle" data-toggle="dropdown" aria-expanded="false">
				<?php echo array_key_exists($priority, $all_priority) ? $all_priority[$priority] : 'All';?>
				&nbsp;<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li><a href="<?php echo base_url();?>account/tasks<?php echo empty($status) ? '' : "?status=$status";?>">All</a></li>
				<?php 
				foreach($all_priority as $k => $v){
				?>
				<li><a href="<?php echo base_url();?>account/tasks?priority=<?php echo $k;?><?php echo empty($status) ? '' : "&status=$status";?>"><?php echo $v;?></a></li>
				<?php
				}
				?>
			</ul>
		</div>
		<div class="pull-right dropdown" style="margin-right:40px">
			Status
			<button class="btn btn-link dropdonw-toggle" data-toggle="dropdown" aria-expanded="false">
				<?php echo array_key_exists($status, $all_status) ? $all_status[$status] : 'All';?>
				&nbsp;<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li><a href="<?php echo base_url();?>account/tasks<?php echo empty($priority) ? '' : "?priority=$priority"?>">All</a></li>
				<?php 
				foreach($all_status as $k => $v){
				?>
				<li><a href="<?php echo base_url();?>account/tasks?status=<?php echo $k;?><?php echo empty($priority) ? '' : "&priority=$priority"?>"><?php echo $v;?></a></li>
				<?php
				}
				?>
			</ul>
		</div>
	</div>
	<ul class="doc-list">
		<li class="clearfix" style="background:#efefef;line-height:30px !important">
		<?php
			echo '<div class="pull-left" style="border-right:1px solid #fff">ID</div>';
			echo '<div class="pull-left" style="border-right:1px solid #fff">Priority</div>';
			echo '<div class="pull-right" style="border-left:1px solid #fff">Due</div>';
			echo '<div class="pull-right" style="border-left:1px solid #fff">Status</div>';
			echo '<div class="pull-right" style="border-left:1px solid #fff">Updated</div>';
			echo '<div>Subject</div>';
		?>
		</li>
	<?php
	if(count($list) == 0){
	?>
		<li style="text-align:center;line-height:160px">No schedules.</li>
	<?php
	}
	else{
		foreach($list as $l){
		?>
			<li class="clearfix">
				<?php
					echo '<div class="pull-left">'.str_pad($l['tasks_id'], 5, '0', STR_PAD_LEFT).'</div>';
					echo '<div class="pull-left">'.$all_priority[$l['tasks_priority']].'</div>';
					$due_text = isset($l['tasks_due_date']) || isset($l['tasks_due_time']) ? (isset($l['tasks_due_date']) ? date_format(date_create($l['tasks_due_date']), 'm/d ') : '').(isset($l['tasks_due_time']) ? date_format(date_create($l['tasks_due_time']), 'g:i A') : '') : '&nbsp;';
					echo '<div class="pull-right">'.$due_text.'</div>';
					echo '<div class="pull-right">'.$all_status[$l['tasks_status']].'</div>';
					echo '<div class="pull-right">'.date_format(date_create($l['tasks_update']), 'm/d g:i A').'</div>';
					echo '<div ><a href="'.base_url().'account/tasks/view?id='.$l['tasks_id'].'">'.$l['tasks_subject'].'</a></div>';
				?>
			</li>
		<?php
		}
	}
		?>
		<li style="text-align:center">
			<a class="btn btn-link <?php echo count($list) == 0 ? 'disabled' : '';?>" href="<?php echo base_url().'account/tasks?pg=1'.(empty($status) ? '' : "&status=$status").(empty($priority) ? '' : "&priority=$priority");?>">First</a>
			<a class="btn btn-link <?php echo $current > 1 ? '' : 'disabled';?>" href="<?php echo base_url().'account/tasks?pg='.($current - 1).(empty($status) ? '' : "&status=$status").(empty($priority) ? '' : "&priority=$priority");?>">Prev</a>
			<?php echo (empty($list) ? 0 : $current).' / '.$total;?>
			<a class="btn btn-link <?php echo $current < $total ? '' : 'disabled';?>" href="<?php echo base_url().'account/tasks?pg='.($current + 1).(empty($status) ? '' : "&status=$status").(empty($priority) ? '' : "&priority=$priority");?>">Next</a>
			<a class="btn btn-link <?php echo count($list) == 0 ? 'disabled' : '';?>" href="<?php echo base_url().'account/tasks?pg='.$total.(empty($status) ? '' : "&status=$status").(empty($priority) ? '' : "&priority=$priority");?>">Last</a>
		</li>
	</ul>
</div>
