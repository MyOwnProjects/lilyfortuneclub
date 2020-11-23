<style>
#animation-bk{position:relative;/*url(<?php echo base_url();?>src/img/background/dark-wood-background-1013tm-pic-2573.jpg1);*/overflow:hidden;}
#animation-block{position:relative;}
#animation1{background:#fff;position:absolute;top:0;right:0;bottom:0;left:0;margin:0 auto;border-radius:50%}
#animation1-bk{opacity:0.3;width:100%;height:100%;position:absolute;top:0;right:0;bottom:0;left:0;}
.circle-md{position:absolute;border-radius:50%;}
.circle-sm{cursor:pointer;overflow:hidden;position:absolute;border:0px solid #0080FF;border-radius:50%;background:#fff}
.circle-sm-bk1{overflow:hidden;border-radius:50%;background:#fff;border-color:#A0C4DE;border-style:solid}
.circle-sm-bk1:hover{border-color:#3289C7}
.circle-sm-bk2{border-radius:50%;}
.circle-sm-bk3{border-radius:50%;overflow:hidden}
.circle-sm-bk3 img{width:100%;height:100%;overflow:hidden}
.circle-md{position:absolute;}
.circle-md-center{position:absolute;background:#D80027;border-radius:50%}
.circle-md img{display:block;margin:0 auto;}
#question-bubble{-webkit-transform: scale(0.8);-moz-transform: scale(0.8);-ms-transform: scale(0.8);transform: scale(0.8);
	color:#000;position:absolute;top:10px;bottom:10px;}
.popup_visible #question-bubble {-webkit-transform: scale(1);-moz-transform: scale(1);-ms-transform: scale(1);transform: scale(1);}
#question-bubble .quiz-option-selected{color:green}
#speech-div-wrap{z-index:10;position:absolute;top:10px}
#speech-div{float:left;visibility:hidden;border:1px solid#000;white-space:normal;border-radius:5px;background:#e5e5e5;font-size:16px;font-family:Helvetica,Open Sans,Meta;padding:8px 10px;}
#smd-profile-wrap{float:right;border-radius:50%;overflow:hidden;background:#fff;padding:2px}
#smd-profile{border-radius:50%;overflow:hidden;background:url(<?php echo base_url();?>/src/img/smd_profile.jpg);background-size:100% 100%}
</style>
<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jQueryRotate.js?<?php echo time();?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-easing/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>src/3rd_party/jquery-easing/rotate.js"></script>
<div id="animation-bk">
	<div id="speech-div-wrap" class="clearfix">
		<div id="smd-profile-wrap"><div id="smd-profile"></div></div>
		<div id="speech-div" class="text-danger"></div>
	</div>
	<div id="animation-block">
		<div id="animation1">
			<img id="animation1-bk" src="<?php echo base_url();?>src/img/earth-cartoon-transparent.png">
			<?php
			for($i = 0; $i < 12; ++$i){
			?>
			<div class="circle-sm" id="circle-sm-<?php echo $i;?>" >
				<div class="circle-sm-bk1">
					<div class="circle-sm-bk2">
						<div class="circle-sm-bk3">
							<img>
						</div>'
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		<div class="circle-md">
			<div class="circle-md-center"></div>
			<img src="<?php echo base_url();?>src/img/clock-pointer.png">
		</div>
	</div>
	<div id="question-bubble"></div>
</div>
<script>

var rotate1, rotate2;
var quiz = [
	['Have you heard about 36 rule and 72 rule in finance industry?', ['36 rule only.', '72 rule only.', 'Both.', 'Neither.'], 1, -1, false, 1], 
	['What is the penalty if you withdraw money from your 401K account at age 52 and 67?', ['0 and 0', '0 and 10%', '10% and 0', '50% and 10%'], 2, -1, false, 1],
	['What is the penalty if you withdraw money from your 401K account at age 70 and 76?', ['0 and 0', '0 and 10%', '10% and 10%', '0 and 50%'], 3, -1, false, 1],
	['There are three investment accounts. During the next year, the balance in the first account increases 50%, and then decreases 50%; in the second account, the balance keeps no change; in the third account, the balance decreases 50%, and then increases 50%. Which account would you like to invest?', ['Account 1.', 'Account 2.', 'Account 3.', 'They are same.'], 1, -1, false, 2],
	['What is the maximum expense for a commom family averagely in the Unites States?', ['Medical Expenses.', 'Tax.', 'Mortgage.', 'Food.'], 1, -1, false, 2],
	['The annual list price to attend Stanford University on a full time basis for 2017/2018 is $69,109. Suppose the cost increases 8% per year. In approximately how many years the price will become four times?', ['9 years', '15 years', '18 years', '20 years.'], 2, -1, false, 2],
	['What is the amount of individual federal estate or gift tax exemptionin for US citizen in 2018?', ['0', '$5.6M', '$11.2M', 'None of the above.'], 1, -1, false, 2],
	['How does the Medicare pay the long-term care expenses?', ['Medicare fully pays the long-term care expenses.', 'Medicare pays part of the long-term care expenses.', 'Medicare does not pay any part of the long-term care expenses.', 'None of above.'], 1, -1, false, 2],
	['Three persons whose status are US citizen, permanent residence, and non residence, relatively. Are they qualified for long-term care?', ['Yes, yes and yes.', 'Yes, yes and no.', 'Yes, no and no.', 'None of the above.'], 1, -1, false, 2],
	['Six daily activities are defined: Eating, drinking, bathing, transferring, talking and listening. Which activities disabled will trigger the long-term care?', ['Eating and drinking.', 'Talking and listening.', 'Eating and listening.', 'Bathing and transferring.'], 3, -1, false, 3],
	['One of the current individual income tax rates in 2018 is 37% in the United States. What is the highest individual income tax rate in history?', ['60-70%', '70-80%', '80-90%', '90-100%.'], 3, -1, false, 3],
];

var sm_image_list = [
	'retirement.svg', 'graduate-student-avatar.svg','golden-gate-bridge.svg', 
	'first-aid-kit.svg','tax.svg','statue-of-liberty.svg', 
	'profits.svg','bed.svg','maple-leaf.svg', 
	'umbrella.svg', 'volunteer.svg', 'great-wall-of-china.svg', 
];

function resize_all(){
	var rb = 400;
	var sb = 10, sp = 10;
	var rc = 20;
	var piw = 100;
	var spw = 80;
	var sdw = 156;
	var sdh = 65;
	var rs = rb * 0.4;
	if($('#animation-bk').innerWidth() <= 800){
		$('#speech-div-wrap').css('left', 'auto').css('right', 0);
	}
	else{
		$('#speech-div-wrap').css('left', ($('#animation-bk').innerWidth() / 2 + rs) + 'px').css('margin-left', '0').css('right', 'auto');
	}
	if($('#animation-bk').innerWidth() <= 600){
		rb = 200;
		rs = rb * 0.4;
		sb = 5;
		sp = 5;
		rc = 10;
		piw = 50;
		$('#question-bubble').css('background', '#fff').css('border', '5px solid #1DB34A').css('padding', '20px')
			.css('margin', '10px').css('border-radius', '10px');
	}
	else{
		$('#question-bubble').css('background', 'url(<?php echo base_url();?>src/img/think-bubble-green.png) no-repeat')
			.css('margin', '0').css('background-size', '100% 100%').css('border', 'none').css('padding', '100px 150px 100px 200px');
	}
	var rm = rb * 0.75;
	var left = rb - rm;
	var top = rb - rm;
	var bw = 1280, bh = 712;
	$('#animation-bk').css('height', (rs + rb) + 'px' );
	$('#animation-block').css('left', '50%').css('margin', (rs / 2 + 20) + 'px 0 ' + (rs / 2 + 20) + 'px -' + rb + 'px')
		.css('height', (rb * 2) + 'px').css('width', (rb * 2) + 'px');
	$('.circle-sm').css('width', rs + 'px').css('height', rs + 'px');
	for(i = 0; i < 12; ++i){
		var ang = Math.deg2rad(i * 30 - 90);
		var left = rb * Math.cos(ang) + rb - rs / 2;
		var top = rb * Math.sin(ang) + rb - rs/2;
		$('#circle-sm-' + i).css('top', top + 'px').css('left', left + 'px');
		$('#circle-sm-' + i + ' img').css('transform', 'rotate(' + (i * 30) + 'deg)').attr('src', '<?php echo base_url();?>src/img/' + sm_image_list[i]);
	}
	
	$('.circle-sm-bk1').css('height', rs + 'px').css('width', rs + 'px')
		.css('border-width', sb + 'px');
	$('.circle-sm-bk2').css('border', sb + 'px solid #fff').css('width', (rs - sb * 2) + 'px')
		.css('height', (rs - sb * 2) + 'px');
	$('.circle-md').css('height', (rm * 2) + 'px').css('width', (rm * 2) + 'px')
		.css('left', rb + 'px').css('top', rb + 'px').css('margin-left', '-' + rm + 'px').css('margin-top', '-' + rm + 'px');
	$('.circle-md-center').css('width', (rc * 2) + 'px').css('height', (rc * 2) + 'px')
		.css('left', rm + 'px').css('margin-left', '-' + rc + 'px').css('top', rm + 'px')
		.css('margin-top', '-' + rc + 'px');
	$('.circle-md img').css('height', rm + 'px');
	
	$('#smd-profile').css('width', spw + 'px').css('height', spw + 'px');
	$('#speech-div').css('width', sdw + 'px').css('height', sdh + 'px');
}

$(window).resize(function(){
	resize_all();
});

$(document).ready(function(){
	resize_all();
	rotate_start();	
	
	setTimeout(function(){
		show_speech();
	}, 3000);
	$('#question-bubble').popup({
		pagecontainer: '#animation-bk',
        transition: 'all 0.3s',
	});

});
	
function show_word(speech_text_array, i, new_page){
	if(i < speech_text_array.length){
		var int = 400;
		if(speech_text_array[i] == '\n'){
			int = 3000;
			new_page = true;
		}
		else{
			if(new_page){
				$('#speech-div').empty().append(speech_text_array[i]);
			}
			else{
				$('#speech-div').append(' ').append(speech_text_array[i]);
			}
			new_page = false;
		}
		setTimeout(function(){show_word(speech_text_array, i + 1, new_page);}, int);
	}
	else{
		setTimeout(function(){
			$('#speech-div').css('visibility', 'hidden')
			setTimeout(function(){
				show_speech();
			}, 3000);
		}, 3000);
	}
}

function show_speech(){
	$('#speech-div').html('');
var speech_text = 'Do|you|know|how|money|works?|\n|Click|the|bubbles|for|a|quiz.|<i class="fa fa-arrow-down" aria-hidden="true"></i>';
	var speech_text_array = speech_text.split('|');
	$('#speech-div').css('visibility', 'visible');
	show_word(speech_text_array, 0);
}

function rotate_start(){
	var deg = 0;
	rotate1 = setInterval(function(){
	    deg-=1;
		var $m = $("#animation1");
		$m.myRotate({animateTo:deg});
	},150);
	var deg1 = 0;
	var rand = 29;
	var plus = true;
	rotate2 = setInterval(function(){
		if(rand > 0 && deg1 > rand){
			rand = Math.floor(-80 * Math.random()) - 10;
			deg1--;
			plus = false;
		}
		else if(rand < 0 && deg1 < rand){
			rand = Math.floor(80 * Math.random()) + 10;
			deg1++;
			plus = true;
		}
		else if(plus){
			deg1++;
		}
		else{
			deg1--;
		}
		var $m = $(".circle-md");
		$m.myRotate({animateTo:deg1});
	},200);
}

var current_quiz = -1;
function reset_quiz(){
	for(var i = 0; i < quiz.length; ++i){
		quiz[i][3] = -1;
		quiz[i][4] = false;
	}
	current_quiz = -1;
}

function next_quiz(){
	if(current_quiz > 0){
	}
	var s = -1;
	$('#question-bubble').find('.quiz-option').each(function(index, obj){
		if($(obj).hasClass('quiz-option-selected')){
			s = index;
			return false;
		}
	});
	if(current_quiz >= 0){
		quiz[current_quiz][3] = s;
	}
	var t = [];
	for(i = 0; i < quiz.length; ++i){
		if(!quiz[i][4]){
			t.push(i);
		}
	}
	var last_current_quiz = current_quiz;
	if(t.length == 0){
		current_quiz = -1;
	}
	else{
		current_quiz = t[Math.floor(Math.random() * t.length)];
	}
	if(last_current_quiz >= 0){
		$('#question-bubble').popup('hide');
	}
	else{
		show_quiz();
	}
}

function quit_quiz(){
	reset_quiz();
	$('#question-bubble').popup({closetransitionend: function(){
	}}).popup('hide');
}

function quiz_summary(){
	var total = 0;
	for(var i = 0; i < quiz.length; ++i){
		if(quiz[i][2] == quiz[i][3]){
			total += quiz[i][5];
		}
		else{
		}
	}
	return total / (quiz.length * 2);
}

function show_quiz(){
	var div = $('<div>').css('max-width', '600px');
	if(current_quiz >= 0){
		div.append('<p style="font-size:16px">' + quiz[current_quiz][0] + '</p>');
		for(var i = 0; i < quiz[current_quiz][1].length; ++i){
			var p = $('<p>').addClass('quiz-option').css('font-size', '16px').css('cursor', 'pointer')
				.append('<i class="fa fa-square-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;' + quiz[current_quiz][1][i]);
			div.append(p);
		}
		div.append('<p style="text-align:center"><br/><button class="btn-next btn btn-md btn-success disabled" onclick="next_quiz();">NEXT</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-md btn-danger" onclick="quit_quiz();">Quit</button></p>');
		$('#question-bubble').empty().append(div);
		quiz[current_quiz][4] = true;
	}
	else{
		var score = quiz_summary();
		div.append('<p style="font-size:16px">You score is ' + Math.floor(score * 100)  + '%.</p>');
		var t = "You don't seem to have enough financial knowledges.";
		if(score > 0.6){
			t = 'Congratulations! You seem to have some financial knowledges.';
		}
		div.append('<p style="font-size:16px">' + t + ' If you want to learn more about HOW MONEY WORKS, please come to listen to our <a href="<?php echo base_url();?>courses">financial courses</a>.</p>');
		div.append('<p style="text-align:center"><br/><button class="btn btn-md btn-danger" onclick="quit_quiz();">Close</button></p>');
		$('#question-bubble').empty().append(div);
	}
	$('#question-bubble').popup('show');
}

$('#question-bubble').delegate('.quiz-option', 'click', function(){
	$(this).siblings('.quiz-option').removeClass('quiz-option-selected').each(function(){
		$(this).children('.fa').removeClass('fa-check-square').addClass('fa-square-o')
	});
	$(this).addClass('quiz-option-selected').find('.fa').removeClass('fa-square-o').addClass('fa-check-square');
	$('.btn-next').removeClass('disabled'); 
});
$('#animation1').delegate('.circle-sm', 'click', function () {
	if(current_quiz >= 0){
		return false;
	}
	clearInterval(rotate1);
	clearInterval(rotate2);
    if (!$('#animation1').is(':animated')) {
        $(".complete").remove();
    }

    $('#animation1').rotate(-1500, {
        duration: 1500,
        easing: 'easeOutExpo',
        complete: function() {
            $(".ani-status").remove();
			rotate_start();	
			$('#question-bubble').popup({closetransitionend: function(){
				show_quiz();
			}});
			next_quiz();
        }
    });

});
</script>

