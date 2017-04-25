<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<span class="navbar-brand"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Welcome, <?php echo $user['first_name'];?>!&nbsp;&nbsp;&nbsp;&nbsp;</span>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<?php
				foreach($nav_menus as $name => $menu){
				?>
					<li <?php echo array_key_exists('active', $menu) && $menu['active'] ? 'class="active"' : ''; ?>><a href="<?php echo base_url();?>smd/<?php echo $name;?>"><?php echo $menu['text']?></a></li>
				<?php
				}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php echo base_url();?>smd/ac/sign_out"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a></li>
			</ul>
		</div>
	</div>
</nav>


