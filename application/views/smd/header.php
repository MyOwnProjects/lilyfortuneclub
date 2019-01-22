<div class="container-fluid nav-top bg-dark d-flex nav-top-sm">
	<?php 
	foreach($nav_menus as $menu_name => $menu){
		if(array_key_exists('active', $menu) && $menu['active']){
			foreach($menu['sub_menus'] as $sub_menu_name=> $sub_menu){
	?>
	<a href="<?php echo base_url().'smd/'.$menu_name.'/'.$sub_menu_name;?>">
		<div class="pl-2 pr-2"><?php echo $sub_menu['text'];?></div>
	</a>
	<?php
			}
			break;
		}
	}
	?>
	<div class="ml-auto pl-2 pr-2 dropdown menu-item-a">
		<i class="fa fa-bars" data-toggle="dropdown" aria-hidden="true" style="line-height:48px;cursor:pointer"></i>
		<div class="dropdown-menu dropdown-menu-right">
			<a href="<?php echo base_url();?>" class="dropdown-item">Home</a>
			<?php
			foreach($nav_menus as $name => $menu){
			?>
			<a href="<?php echo base_url();?>smd/<?php echo $name;?>" class="dropdown-item">
				<?php echo $menu['text']?>
			</a>
			<?php
			}
			?>
			<a href="<?php echo base_url();?>smd/ac/sign_out" class="dropdown-item">Sign out</a>
		</div>
	</div>
</div>

<div class="container-fluid nav-top bg-dark d-flex nav-top-bg">
	<a href="<?php echo base_url();?>" class="menu-item"><div class="pl-2 pr-2">Home</div></a>
	<?php
	foreach($nav_menus as $name => $menu){
	?>
	<a href="<?php echo base_url();?>smd/<?php echo $name;?>" class="menu-item">
		<div class="pl-2 pr-2"<?php echo array_key_exists('active', $menu) && $menu['active'] ? 'class="active"' : ''; ?>>
			<?php echo $menu['text']?>
		</div>
	</a>
	<?php
	}
	?>
	<a class="ml-auto menu-item" href="<?php echo base_url();?>smd/ac/sign_out">
		<div class="pl-2 pr-2">Sign Out</div>
	</a>
</div>


