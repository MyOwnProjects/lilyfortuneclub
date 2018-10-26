<div class="container-fluid nav-top bg-dark d-flex" style="position:absolute;top:0;right:0;left:0;z-index:100">
				<a href="<?php echo base_url();?>"><div class="pl-2 pr-2">Home</div></a>
				<?php
				foreach($nav_menus as $name => $menu){
				?>
				<a href="<?php echo base_url();?>smd/<?php echo $name;?>"><div class="pl-2 pr-2"<?php echo array_key_exists('active', $menu) && $menu['active'] ? 'class="active"' : ''; ?>><?php echo $menu['text']?></div></a>
				<?php
				}
				?>
				<a class="ml-auto" href="<?php echo base_url();?>smd/ac/sign_out"><div class="pl-2 pr-2">Sign Out</div></a>
</div>


