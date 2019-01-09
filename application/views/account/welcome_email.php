<style>
.nav-tabs{white-space:nowrap;overflow:ellipsis}
.nav-tabs-2>li{width:50%}
.nav-tabs-3>li:not(:last-child){width:33%}
.nav-tabs-3>li:last-child{width:34%}
.nav-tabs-5>li{width:20%}
.tab-content-page{padding:40px}
.content-page-head{text-align:center;margin-bottom:40px}
.tab-content img{width:100%}
.tab-content .detail-url{display:none}
.tab-content .detail-url a{color:red;text-decoration:underline}
.content-list{padding:20px 0}
@media only screen and (max-width:768px) {
.tab-content img{display:none}
.tab-content .detail-url{display:inline;}
.content-list{padding:0}
}
</style>
<div style="margin:0 auto;max-width:1000px;padding:20px 0 80px 0;">
	<h2 class="text-center">Welcome Email</h2>
		<div class="form-group">
			<label>Select the member</label>
			<select class="form-control control-sm" data-live-search='true' id="member-select">
				<option value="<?php echo $user['membership_code'];?>"><?php echo $user['first_name'].' '.$user['last_name'].' ('.$user['membership_code'].')';?></option>
				<?php 
				foreach($members as $m){
				?>
				<option value="<?php echo $m['membership_code'];?>"><?php echo $m['name'];?></option>
				<?php 
				}
				?>
			</select>
			<br/>
			<button class="btn btn-primary" onclick="get_member_info();">Select</button>
		</div>
		<textarea id="email-template" style="width:100%"></textarea>	
</div>
<script>
$('#recruits-baseshop-select').selectpicker();
function AutoGrowTextArea(textField)
{
  if (textField.clientHeight < textField.scrollHeight)
  {
    textField.style.height = textField.scrollHeight + "px";
    if (textField.clientHeight < textField.scrollHeight)
    {
      textField.style.height = 
        (textField.scrollHeight * 2 - textField.clientHeight) + "px";
    }
  }
}
function get_member_info(){
	ajax_loading(true);
	$.ajax({
		url: '<?php echo base_url();?>team/get_member_info/' + $('#member-select').val(),
		dataType:'json',
		success:function(data){
			console.log(data);
			var sep = "\n";
			var welcome_email_template = "Hi "+ (data['info']['nick_name'] ? data['info']['nick_name'] : data['info']['first_name']) + ","
				+ sep
				+ sep + "Hearty Congratulations on becoming a member of Lily Fortune Club/WFG!"
				+ sep
				+ sep + "Your associate ID is " + data['info']['membership_code'] 
				+ sep
				+ sep + "This first step will open doors to achieve true financial independence through education in the fields of Insurance, LTC, financial Investments and business ownership! This education can be powerful tool in building wealth, ensuring true independence, peace of mind and a secured retirement life!"
				+ sep
				+ sep + "Four reasons I liked this program:"
				+ sep + "1. I am able to make a difference to lives of the people around me by providing right guidance to secure their financial well being."
				+ sep + "2. Ability to suggest not just Transamerica products but over 200 other A, A+ accredited products from various other companies."
				+ sep + "3. Build my own financial freedom at my own ease with no targets."
				+ sep + "4. Strong & proven successful leadership, process, platform and support to make it happen."
				+ sep
				+ sep + "Your account on lilyfortuneclub.com is already set up. Go to https://www.lilyfortuneclub.com/ac/sign_in. Your username is your Associate ID, and your password is Associate ID followed by your last name, all capital. After you successfully log in, you can review and use the source on it."
				+ sep
				+ sep + "I strongly encourage you to do the following two things:"
				+ sep + "- Review your personal financial plan. Secure your family, retirement and future. There is no need to buy anything or spend money but let one of the experts discuss your financial planning and explain the gaps. Your continuous learning will help to validate the facts/findings. I recommend to do this within one week to get started your journey, we will engage the experienced advisers from Lily Fortune Club/WFG."
				+ sep + "- Get Licensed as Insurance Agent and then as a financial adviser."
				+ sep
				+ sep + "To get the license, go to https://www.lilyfortuneclub.com/license, and follow the instruction."
				+ sep
				+ sep + "Looking forward to an exciting journey together to build an enduring business partnership to achieve true financial independence!"
				+ sep
				+ sep + "Please contact me directly if you have any questions on how to go forward."
				+ sep
				+ sep + "Best regards,";
			$('#email-template').html(welcome_email_template);
			AutoGrowTextArea($('#email-template')[0]);
		},
		error: function(){
		},
		complete: function(){
			ajax_loading(false);
		}
	});
}
</script>
