<style>
@media only screen and (max-width:768px) {
#text-block{width:auto;padding:0 40px}	
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>src/css/home.css?t=<?php echo time();?>"></script>
<script>
	$(document).ready(function(){
		var $_main_home_slide = $('#main-home-slide');
		$(window).resize(function(){
			$_main_home_slide.outerHeight($_main_home_slide.outerWidth() / 2.5);
		});
		$_main_home_slide.outerHeight($_main_home_slide.outerWidth() / 2.5);
	});
</script>
<div id="main-home">
	<div class="swiper-container">
		<div class="swiper-wrapper" style="height:580px">
			<div class="swiper-slide item active clearfix" id="slider-about">
				<div class="slider-content-wrapper">
					<div class="slider-content-subject">Who We Are?</div>
					<ul class="slider-content-body">
						<li>We are Financial Doctors</li>
						<li>We are Financial Brokers</li>
					</ul>
				</div>
			</div>
			<div class="swiper-slide item clearfix" id="finance-status">
				<div class="slider-content-wrapper">
					<div class="slider-content-subject">What We Do?</div>
					<ul class="slider-content-body">
						<li>We help provide Solutions</li>
						<li>Client Oriented vs. Company Oriented</li>
						<li>Education Approach</li>
					</ul>
				</div>
			</div>
			<div class="swiper-slide item clearfix" id="diy">
				<div class="slider-content-wrapper">
							<div class="slider-content-subject">Great Business Opportunity</div>
							<ul class="slider-content-body">
								<li>Huge Market / Product Service</li>
								<li>Powerful and Efficient System</li>
								<li>Great Profitability</li>
								<li>Doable</li>
							</ul>
				</div>
			</div>
			<div class="swiper-slide item clearfix" id="business-partner">
				<div class="slider-content-wrapper">
					<div class="slider-content-subject">Become Our Business Partners</div>
					<ul class="slider-content-body">
						<li>Financial Knowledge</li>
						<li>Leadership Skills</li>
						<li>Field Training</li>
						<li>CEO of your own Business</li>
					</ul>
				</div>
			</div>

</div>
 
<div class="swiper-pagination"></div>
 
<div class="swiper-button-next"></div>
<div class="swiper-button-prev"></div>
</div>
	<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/swiper/css/swiper.min.css">
	<script src="<?php echo base_url();?>src/3rd_party/swiper/js/swiper.min.js"></script>
	<script>
	var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 0,
        loop: true
    });
	</script>
	
	<div id="text-block" style="width:100%;max-width:1000px">
		<div class="row">
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 image">
				<div class="text-block-content-image" id="x-curve">
					<img src="<?php echo base_url();?>src/img/x-curve.png">
				</div>
			</div>
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 list">
				<div class="text-block-subject">
					Know Your Financial Status
				</div>
				<ul class="text-block-desc">
					<li>How much protection - Debt, Income, Mortgage and Education?</li>
					<li>The wealth formula - Money, Time, Rate of Return, Inflation and Taxes</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 list">
				<div class="text-block-subject">
					Manage Rate & Risk
				</div>
				<ul class="text-block-desc">
					<li>How much protection - Debt, Income, Mortgage and Education?</li>
					<li>The wealth formula - Money, Time, Rate of Return, Inflation and Taxes</li>
				</ul>
			</div>
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 image">
				<div class="text-block-content-image" id="umbrella">
					<img src="<?php echo base_url();?>src/img/umbrella1.png">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 image">
				<div class="text-block-content-image" id="tax-impact">
					<img src="<?php echo base_url();?>src/img/tax-impact.png">
				</div>
			</div>
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 list">
					<div class="text-block-subject">
						Reduce the Impact of Tax
					</div>
					<ul class="text-block-desc">
						<li>Does it have TAX ADVANTAGE?</li>
						<li>Does it have proper PROTECTION for your family?</li>
					</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 list">
					<div class="text-block-subject">
						Learn Financial Knowledge
					</div>
					<ul class="text-block-desc">
						<li>Cash Flow & Debt Management</li>
						<li>Emergency Fund & Proper Protection</li>
						<li>Asset Accumulation & Estate Preservation</li>
					</ul>
			</div>
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 image">
				<div class="text-block-content-image" id="rule72">
					<img src="<?php echo base_url();?>src/img/72-rule.png">
				</div>
			</div>
		</div>
</div>
</div>
