<div data-role="footer">
	<a href="<?php echo base_url();?>" class="nondec"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
	<div style="float:right">
		<?php
		if(empty($user)){
		?>
		<a href="#sign_in">class="nondec"><i class="fa fa-sign-in fa-2x" aria-hidden="true"></i></a>
		<?php
		}
		else{
		?>
		<a href="<?php echo base_url();?>ac/sign_out" class="nondec"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
		<?php
		}
		?>	
		&nbsp;
		<a href="#main-menu" data-transition="slide" class="nondec"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>
	</div>
</div>