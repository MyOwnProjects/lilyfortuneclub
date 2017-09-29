<style>
.nav-tabs>li{width:50%}
.tab-content-page{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content-page p{margin-bottom:20px}	
</style>
<div class="main-content-wrapper">
	<h2 class="text-center">Terminologies</h2>
	<ul class="nav nav-tabs clearfix" id="top-tab">
		<li class="active"><a data-toggle="tab" href="#page-tech">Technology</a></li>
		<li><a data-toggle="tab" href="#page-biz">Business</a></li>
	</ul>
	<div id="tab-content-pages" class="tab-content">
		<div id="page-tech" class="tab-pane fade in active tab-content-page">
			<?php
			foreach($terms as $t){
			?>
			<p>
				<b><?php echo $t['term'];?></b>	
				<br/>
				<?php echo $t['comment'];?>
			</p>
			<?php
			}
			?>
		</div>
		<div id="page-biz" class="tab-pane fade tab-content-page">
			<p>
				<b>WFG Levels</b>	
				<br/>
				There are 5 levels in a SMD team: Senior Marketing Direct (SMD), Marketing Director (MD), Senior Associate (SA), Associate (A), Trainee Associate (TA). The initial level is Trainee Associate. After you become a WFG member, you first level is Trainee Associate.
			</p>
			<p>
				<b>Trainee and Trainer</b>
				<br/>
				When you bring your guest in front of your lead, you are in a field training. You lead is the trainer, and you are the trainee. Field training is the most efficient way to improve your business and professional skills. You can learn the skills of recruit, sales and objection handling.
			</p>
			<p>
				<b>Baseshop</b>
				<br/>
				......
			</p>
			<p>
				<b>3-3-30</b>
				<br/>
				......
			</p>
		</div>
	</div>
</div>
