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
				<u>Trainee Associate (TA)</u>
				<br/>
				This is the initial level. After you sign up the WFG membership, you are a trainee associate.
				<br/><br/>
				<u>Associate (A)</u>
				<br/>
				You recruit 3 new associates and observe your field trainer complete 3 non-securities sales calls in 30 days (3-3-30), or make 20,000 net points in a rolling 3 months.
				<br/><br/>
				<u>Marketing Director (MD)</u>
				<br/>
				You have 3 direct associates, 5 Life-licensed associates in downline and 40,000 base shop net points in rolling 3 Months.
				<br/><br/>
				<u>Senior Marketing Director (SMD)</u>
				<br/>
				You have 10 licensed associates in downline (6 must be life licensed), 3 direct legs (Legs must include 1 MD or 2 SA), 225,000 base net points (6) and $35,000 or more in rolling 12-month cash flow
			</p>
			<p>
				<b>Trainee and Trainer</b>
				<br/>
				When you bring your guest in front of your lead, you are in a field training. You lead is the trainer, and you are the trainee. Field training is the most efficient way to improve your business and professional skills. You can learn the skills of recruit, sales and objection handling.
			</p>
			<p>
				<b></b>
				<br/>
			</p>
		</div>
	</div>
</div>
