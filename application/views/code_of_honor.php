<style>
.nav-tabs>li{width:50%}
.tab-content-page{padding:40px 10px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content img{width:100%}
.tab-content .detail-url{display:none}
.tab-content .detail-url a{color:red;text-decoration:underline}
.content-list{padding:20px 0}
iframe{width:100%;border:0}
@media only screen and (max-width:768px) {
.tab-content img{display:none}
.tab-content .detail-url{display:inline;}
.content-list{padding:0}
}
</style>
<div style="margin:0 auto;max-width:800px;padding:20px 0 80px 0;">
		<h2 class="text-center">Code of Honor</h2>
		
	<ul class="nav nav-tabs clearfix" id="top-tab">
		<li class="active"><a data-toggle="tab" href="#page-pg">Promotion Guideline</a></li>
		<li><a data-toggle="tab" href="#page-cod">Code of Honor</a></li>
	</ul>
	<div id="tab-content-pages" class="tab-content">
		<div id="page-pg" class="tab-pane fade in active tab-content-page">
			<h4 class="text-center">High Standard Promotion Guideline</h4>
			<p>High standard promotion is very important to your business, and your team build. We are very proud to hold a high standard for our business.</p>
			<iframe frameBorder="0" src="<?php echo base_url();?>account/documents/view/59a3bbd9eb40a"></iframe>
		</div>
		<div id="page-cod" class="tab-pane fade tab-content-page">
			<h4 class="text-center">Code of Honor - Dream Team</h4>
			<p>"Do it right, do it with pride". Code of Honor & Team Pride. Commission Split. Client Services. SMD Promotion.</p>
			<iframe frameBorder="0" src="<?php echo base_url();?>account/documents/view/599e6b4cc736e"></iframe>
		</div>
	</div>
</div>
<script>
function resizeFrame(){
	var w = $('#tab-content-pages').innerWidth() - 20;
		var iframe1 = $('#page-pg iframe');
		iframe1.outerWidth(w).outerHeight(iframe1.outerWidth() * 290 / 220);
		var iframe2 = $('#page-cod iframe');
		iframe2.outerWidth(w).outerHeight(iframe2.outerWidth() * 100 / 130);
}
$(window).resize(function(){
	resizeFrame();
});
$('iframe').load(function(){
resizeFrame();
});
</script>
