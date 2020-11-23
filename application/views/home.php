<style>
.swiper-slide{text-align:center;height:100%}
.swiper-slide .slider-content-wrapper{height:100%;float:left;width:400px;padding:80px;background:rgba(0, 0, 0, 0.8);color:#fff;text-align:left;margin-left:15%}
.swiper-wrapper .slider-content-subject{font-family: 'Open Sans Condensed', sans-serif;/*font-family: 'Titillium Web', sans-serif;*/font-size:40px;line-height:40px;margin-bottom:30px}
.swiper-wrapper .slider-content-body{font-family: 'Open Sans Condensed', sans-serif;font-size:24px;}
.swiper-wrapper #slider-about{background:url(<?php echo base_url();?>src/img/background/ict-goals-1.jpg) #fff no-repeat;background-size:100% 100%;}
.swiper-wrapper #finance-status{background:url(<?php echo base_url();?>src/img/background/finance-banner-banks-glass-buildings.jpg) #fff no-repeat;background-size:100% 100%;}
.swiper-wrapper #diy{background:url(<?php echo base_url();?>src/img/background/finance_status.jpg) #fff no-repeat;background-size:100% 100%;}
.swiper-wrapper #business-partner{background:url(<?php echo base_url();?>src/img/background/hex1600640.jpg) #fff no-repeat;background-size:100% 100%;}
	.slider-content-body li{line-height:50px;}
	.slider-content-body{list-style-type:square}

#text-block-wrapper{width:100%;background-image:linear-gradient(#fafafa,#FFF)}
#text-block{width:100%;max-width:1000px;margin:0 auto;}
#text-block .image, #text-block .list{width:50%;float:left;padding:0 40px}
#text-block .image img{width:100%}
#text-block .text-block-row{border-bottom:1px solid silver;padding:100px 0}
	.text-block-subject{margin-left:30px;margin-bottom:10px;text-align:left;font-size:36px;font-family: 'Open Sans Condensed', sans-serif;}
	.text-block-desc{font-size:26px;line-height:30px;text-align:left;font-family: 'Open Sans Condensed', sans-serif;list-style:square outside;}
	.text-block-desc li{padding:10px 0 3px 20px}

@media only screen and (max-width:768px) {
#text-block .image, #text-block .list{width:100%;float:none;padding:20px 40px}
#text-block .text-block-row{padding:40px 0}
#text-block .text-block-row>div:first-child{padding-bottom:40px}
.text-block-subject{margin-left:0;text-align:center}
</style>
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
	<?php
	$this->load->view('home_animation');
	?>
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
	
	<div id="text-block-wrapper">
		<div id="text-block">
			<div class="clearfix text-block-row">
					<div class="image">
						<div class="text-block-content-image" id="x-curve">
							<img src="<?php echo base_url();?>src/img/x-curve.png">
						</div>
					</div>	
					<div class="list">
						<div class="text-block-subject">
							Know Your Financial Status
						</div>
						<ul class="text-block-desc">
							<li>How much protection - Debt, Income, Mortgage and Education?</li>
							<li>The wealth formula - Money, Time, Rate of Return, Inflation and Taxes</li>
						</ul>
					</div>
				</div>
			<div class="clearfix text-block-row">
				<div class="list">
					<div class="text-block-subject">
						Manage Rate & Risk
					</div>
					<ul class="text-block-desc">
						<li>How much protection - Debt, Income, Mortgage and Education?</li>
						<li>The wealth formula - Money, Time, Rate of Return, Inflation and Taxes</li>
					</ul>
				</div>
				<div class="image">
					<div class="text-block-content-image" id="umbrella">
						<img src="<?php echo base_url();?>src/img/umbrella1.png">
					</div>
				</div>
			</div>
			<div class="clearfix text-block-row">
				<div class="image">
					<div class="text-block-content-image" id="tax-impact">
						<img src="<?php echo base_url();?>src/img/tax-impact.png">
					</div>
				</div>
				<div class="list">
						<div class="text-block-subject">
							Reduce the Impact of Tax
						</div>
						<ul class="text-block-desc">
							<li>Does it have TAX ADVANTAGE?</li>
							<li>Does it have proper PROTECTION for your family?</li>
						</ul>
				</div>
			</div>
			<div class="clearfix text-block-row">
				<div class="list">
						<div class="text-block-subject">
							Learn Financial Knowledge
						</div>
						<ul class="text-block-desc">
							<li>Cash Flow & Debt Management</li>
							<li>Emergency Fund & Proper Protection</li>
							<li>Asset Accumulation & Estate Preservation</li>
						</ul>
				</div>
				<div class="image">
					<div class="text-block-content-image" id="rule72">
						<img src="<?php echo base_url();?>src/img/72-rule.png">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
