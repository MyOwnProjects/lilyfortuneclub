<style>
.block .panel-heading{font-weight:bold;font-size:16px;text-align:left;}
.block-icon{float:left;text-align:center;margin-right:20px}
.block-icon img{width:40px;height:40px}
.block-text{overflow:hidden;min-height:160px}
</style>
<div style="max-width:1000px;width:100%;margin:0 auto 40px auto;padding:40px 0">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="text-center">Welcome to WFG, Lily's Finance Team</h2>
			<div style="font-size:16px;margin-top:40px;line-height:30px">
				<p>Congratulations on your decision to become an associate with World Financial Group (WFG). We believe you’ve made an excellent choice for you and your family, and will soon be helping others to achieve their dreams as well. </p>
				<p>Click [<a href="javascript:show_welcome();">Here</a>] to know more about WFG.</p>
			</div>
		</div>
	</div>
	<div style="height:40px"></div>
	<div class="row">
		<?php
		$len =  count($pages);
		for($i = 1; $i < $len; ++$i){
			$p = $pages[$i];
		?>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 block">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<?php echo $p['subject'];?> 
				</div>
				<div class="panel-body clearfix">
					<div class="block-icon"><img src="<?php echo $p['icon'];?>"></div>
					<div class="block-text">
						<b><?php echo $p['question'];?></b><br/><br/>
						<p><?php echo implode('</p><p>', $p['text']); ?></p>
						<a class="btn btn-sm btn-success" href="<?php echo $p['btn']['url'];?>"><?php echo $p['btn']['text'];?></a>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>
	<div id="welcome-content" style="display:none">	
			<h2>Welcome</h2>
			<p>Congratulations on your decision to become an associate with World Financial Group (WFG). We believe you’ve made an excellent choice for you and your family, and will soon be helping others to achieve their dreams as well.</p>
			<p>WFG offers a unique opportunity to people just like you — a chance to build a financial services business of your own no matter what your previous work or life experiences have been. You can build this business as big as you desire. The only obstacle in your path is your tenacity, dedication to the mission and desire to help individuals and families achieve their financial goals.</p>
			<p>A unique advantage of our business platform is that you don’t have to commit to a full-time role right away. Not sure if starting your own business is right for you? Join the company part-time*, to “test drive” the opportunity while keeping your current job, to help you to determine whether WFG is the place for you. We think you’ll decide to go full-time with WFG, and sooner rather than later. In fact, many of our top field associates today started with the company part-time and then became full-time associates and successful WFG leaders.</p>
			<p>However you begin your career with WFG, there is one thing you must do: Commit! You must make a commitment of your time – and manage that time appropriately – to make your business a success. Remember: Starting your own business, no matter what industry it is in, is never easy. Being an entrepreneur building a financial services business requires long hours and a lot of hard work, and it doesn’t happen overnight. Most businesses take several years before they become successful. But, in the end, you will be rewarded many times over because of the financial help you bring to people who need it the most.</p>
			<p>You must also commit to doing things right the first time. You must always be forthright and ethical as you build your business, no matter whether you are working with a prospective associate or a client. If you do things the correct way from the beginning then you’ll save time and be a better associate, and person, for it.</p>
			<p>In order to build a business with WFG, you must make a commitment to:</p>
			<p>
			<ul>
				<li>Recruiting: You must personally recruit to continually build your team. </li>
				<li>Leadership: You must lead by example, think big, but keep things simple. </li>
				<li>System: You must commit to duplicating the system and having your team do so. </li>
				<li>Positivity and Optimism: People prefer to be around positive, optimistic and motivated people, so set the example for your team. </li>
				<li>Duplication: You must keep duplicating the WFG System again and again, even if you are bored with it. If you follow these principles and commit yourself to WFG, you have every chance to be a successful business leader. The future belongs to you.
			</ul>
		<p>Let’s get started!</p>
	</div>
</div>
<script>
function show_welcome(){
	bootbox.dialog({
		size: 'large',
		title: "Welcome to WFG - Lily's team ",
		message: $('#welcome-content').html(),
		buttons: {
			cancel: {
				label: 'Close',
				className: 'btn-success'
			}
		},
	});
}
</script>