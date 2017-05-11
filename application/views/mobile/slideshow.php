<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css">
		<link rel="stylesheet" href="<?php echo base_url();?>src/3rd_party/font-awesome-4.7.0/css/font-awesome.min.css">
		<script src="<?php echo base_url();?>src/3rd_party/jquery-1.11.2.js"></script>
		<script src="<?php echo base_url();?>src/3rd_party/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>
	</head>		
	<script>
		$(document).ready(function(){
			$('.slide-page').on('swipeleft', function(){
				window.location=window.location + "#slide4";
				$(this).children('prev-page').click();
			}).on('swiperight', function(){
				$(this).children('next-page').click();
			});
 		});
	</script>
	<body>
		<div data-role="page" id="slide1" class="slide-page">
			<a href="#slide4" class="prev-page"><</a>
			This is home 1
			<a href="#slide2" class="next-page">></a>
		</div>
		<div data-role="page" id="slide2" class="slide-page">
			<a href="#slide1" class="prev-page"><</a>
			This is home 2
			<a href="#slide3" class="next-page">></a>
		</div>
		<div data-role="page" id="slide3" class="slide-page">
			<a href="#slide2" class="prev-page">></a>
			This is home 3
			<a href="#slide4" class="next-page">></a>
		</div>
		<div data-role="page" id="slide4" class="slide-page">
			<a href="#slide3" class="prev-page">></a>
			This is home 4
			<a href="#slide1" class="next-page">></a>
		</div>
	</body>
</html>
