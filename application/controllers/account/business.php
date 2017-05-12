<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Business extends Account_base_controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$pages = array(
			array(
				'subject' => "Prospecting",
				'list' => array(
					array(
						'text' => 'Find the people you already know, <a href="business#edit-prospect" data-transition="slide">add</a> them into your prospect list.',
					),
					array(
						'text' => '<a href="business#prospects" data-transition="slide">Review</a> your top 25 prospect list.',
					),
					array(
						'text' => "Discuss the prospect list with your leader face to face, or through phone.",
					)
				),
			),
			array(
				'subject' => "Invitation/Approach",
				'list' => array(
					array(
						'id' => 'list-phone',
						'text' => 'Invite through phone.',
						'sub_list' => array(
							'<b>Goal:</b> Bring him/her to office. <a href="business#invitation-why">Why</a>?',
							'<b>Method:</b> Share the business opportunity. <a href="business#invitation-how">How</a>?',
							'<b>Scripts:</b> <a href="business#invitation-scripts">Invitation scripts</a>, <a href="business#invitation-scripts-cn">中文示例</a> and <a href="business#objection">handling objection</a>.'
						)
					),
					array(
						'id' => 'list-email',
						'text' => 'Approach by email.',
					),
					array(
						'id' => 'list-wechat',
						'text' => "Contact by wechat.",
					)
				),
			)
		);
		$invitation_why = array(
			array(
				'subject' => 'Bring your guest to BMP',
				'text' => '<p>The purpose of the BPM is to share the business opportunity that WFG offers, the dream of business ownership, and how WFG can change lives.</p><p>The BPM is a major aspect of your business, and many of WFG’s successful leaders schedule their week around BPMs.</p>'
			),
			array(
				'subject' => 'Bring your guest to meet your leader',
				'text' => '<p>You are a new associate, and premature to offer extensive answers as you may not know all the information, instead let them hear it from WFG’s experienced leadership.		);</p>'
			)
		);
		$invitation_how = array(
			array(
				'subject' => 'What you should do?',
				'list' => array(
					'Show your confidence with your WFG business',
					'Try to complete the conversation in 5 - 10 minutes',
					'Take control the conversation by asking questions.',
					'Always answer a question with another question. Never leave statement.'
				)
			),
			array(
				'subject' => 'What you should not do?',
				'list' => array(
					'Do not try to handle objections. If you have to, see the <a href="business#objection">handle objection</a> scripts',
					"Do not ask open ended question (Are you free on Wed?), always choices (Are you free on Wed or Friday?)"			
				)
			)
		);
		$invitation_scripts = array(
			array(
				'subject' => "Invite Warm Market",
				'list' => array(
					"A [You]: Chit chat – family, job, etc",
					"B: Guest",
					"A: What are you doing this Wed night or Sat morning [pick BPM time or one-on-one time]?",
					"B: Nothing. What’s going on?",
					"A: The reason I called you is because a good friend of mine [or a family member of mine] is doing really well in a financial business. So I took a look and I really liked it. I called you because I want to invite you to my office and get to know what I do so later on you can give me referrals and if timing is right maybe we can be business partners. Is Wed night better or Sat morning better?",
					"B: Sure. What business is it? Can you tell me more about this business? What’s the name?",
					"A: I’m glad you asked. But I before I tell you that let me tell you why I’m making the change. [now give your 2 mn testimony] ",
					"Examples: you know I’ve been working as a ____ for a long time. The more I moved up, the more I feel unsecured about my job; I have no time with my family, my income is not enough to provide for my family/retire my parents/allow my wife to stay home and take care of the kids, my job is too hard on my body and I don’t think I can do it forever, I want to own a business and work hard for myself instead of for other people, etc. [pick pain points that the other person can relate to]. ",
					"Now let me answer your question. A lot of people know how to work hard for money but don’t know how to make money work hard for them, right? [wait for answer]. Also, many people don’t know how to leverage tax structure. I can’t talk about all of this in 1 or 2 mns over the phone, that’s why I want to sit down so I can show you more. Is 7pm on Wed. better or 10am on Sat. better?",
					"B: Wed is better. If “ask more questions”",
					"A: Sure. Good question(s). Let me answer them when we get together. It’s just easier that way. Ok?",
					"B: Ok.",
					"A: Ok, see you at 7pm on Wed. I’ll text you the address. Dress code is business casual.",
					"B: Ok."
				)
			),
			array(
				'subject' => 'Invite Cold Market',
				'list' => array(
					"A: Hello. Is this John? (Wait for answer) Did I catch you in a good time?",
					"B: Yes, John is speaking. Yes, we can talk",
					"A: Hi John, this is Alex, we met at Costco yesterday. Remember me? (wait for answer) How are you? It was very nice meeting you. I noticed you are very friendly and you have a lot of experience in Financial industry. We have a lot of people with your background that are doing very well in our office. Like I said before, I can't promise anything. I don’t know if this is the right business for you or if you are the right person for this business. So I took a look at my schedule and we have a few business orientation coming up. Our business is growing very fast right now and there are going to be a lot of people at these events. I have a couple of numbers I have to call but I want to make sure that I call you first and invite to come to learn more about this opportunity. is this Wednesday night and Saturday morning better for you?",
					"B: Ok Wednesday 7 pm is better for me.",
					"A: Ok, see you at 7pm on Wed. I’ll text you the address. Dress code is business casual. BTW, I would like to introduce you to some people from your background that are doing really well in our office. I think you are gonna like it. Ok Ill see you on Wednesday at 7 pm."
				),
			),		
		);	
		$invitation_scripts_cn = array(
			array(
				'subject' => '邀请熟人到办公室',
				'list' => array(
					'你好，最近在忙什么 ？',
					'还不是上班，忙小孩',
					'对呀，公司呆久了也是无聊。不过我最近自己想做点东西，你啥时有空我们聊聊。',
					'你想做什么， 自己搞公司？',
					'我看好了一个方向，觉得具有可能性，前景也不错',
					'什么方向？',
					'Financial Service呀！你有没有看到雅虎上有篇文章对今后 10 年热门行业的预计，这行是名列榜首。我已经了解一些，觉得大有可为，所以找你探讨一下。你是中午有空或是下班后有空？那就中午吧，我给你text地址。好，周五中午见。'
				)
			),
			array(
				'subject' => '邀请熟人到ＢＰＭ',
				'list' => array(
					'你好，最近在忙什么 ？',
					'还不是上班 ，忙小孩',
					'对呀，公司呆久了也是无聊。不过我最近自己想做点东西，你啥时有空我们聊聊。',
					'你想做什么，自己搞公司？',
					'我看好了一个方向，觉得具有可能性，前景也不错。',
					'什么方向？',
					'Financial Service 呀！你有没 有看到雅虎上有篇文章对今后 10 年热门行业的预计，这行是名列榜 首。我已经了解一些，觉得 大有可为，你也来了解一下，咱们可以探讨一下。咱们也不能只低头拉车，不抬头看路。你周二下班后得空，还是周六上午？',
					'干吗？',
					'找你来看看这方面的信息，可以给我一些建议，了解一下，你觉得不错的话，也可以一起讨论一下呀。'
				)
			),
			array(
				'subject' => '在活动上遇到的生人',
				'list' => array(
					'你好，我是×××，咱们前天在××活动上认识的。',
					'噢',
					'那天的活动挺热门的，也很高兴认识你，觉得你人很（sharp / nice）,可惜那时没太多时间聊。记得你也是工程师（CPA 或者×××）吧！今天给你打电话主要是想问你一下，我们公司现在发展很迅速，也在寻找能干的人。我办公室里有满多与你背景相同的（工程师／会计师／ＲＮ……..），他们也挺聪明的，有full time job（全职工作），不过在我们这里做兼职，有第二收入。我也不知道你感不感兴趣，是不适合，喜欢不喜欢， 所以想请你来观察一下。',
					'Continue...'
				)
			),
			array(
				'subject' => 'Continue 1, 邀请到办公室',
				'list' => array(
					'哎，你公司在那个city ，（×××），噢，那离我们办公室挺近的，你可以中午，或下班后过来看看。你是周三有空或是周五有空？',
					'你们是做什么的？哪个公司？',
					'噢，是financial service呀，你不知道现在这个行业很热吗？接下来的１０年２０年这个行业对 人才的需求都很大的，所以很多工程师都往这边发展。我这边Intel, Cisco, Marvell满多的，你过来了解一下情况吧。',
					'给我寄点材料吧！',
					'噢，那我或许可以给你寄一卡车了，你反正也不远，来参观一下工作环境，想拿什么资料，你再拿吗！'
				)
			),		
			array(
				'subject' => 'Continue 2, 邀请到ＢＰＭ',
				'list' => array(
					'所以想请你参观一下；你周二下班有空吗？还是周六有空？',
					'干什么？',
					'刚好公司有overview，你可以来看看，了解一下现在的行业动向总是没错的。',
					'那周六吧！',
					'ＯＫ，我text你地址，咱们周六见。'
				)
			),		
		);
		$objection = array(
			array(
				'subject' => "Who's the Company?",
				'text' => '<p>Have you hear bout Transamerica, Prudential, ING, and Fidelity? wfa... Well, we do their marketing.</p>'
			),
			array(
				'subject' => 'I heard Negative Things about WFG',
				'text' => "<p>That's not uncommon. Have you been to a restaurant that you like and one time the waiter/waitress had a bad attitude and the experience wasn't as good as before? Has that ever happened to you? wfa....That’s probably what happened here, You might’ve run into someone who wasn’t good or didn’t have the right attitude</p>"
			)
		);
		$this->load_view('business', array('pages' => $pages, 'invitation_why' => $invitation_why, 'invitation_how' => $invitation_how,
			'invitation_scripts' => $invitation_scripts, 'invitation_scripts_cn' => $invitation_scripts_cn, 'objection' => $objection));
	}
	
	public function get_prospect_list(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			print_r($this->input->post());
			exit;
		}
		$result = $this->user_model->get_prospect_list("prospects_user_id='".$this->user['users_id']."'");
		echo json_encode($result);
	}
	
	public function get_prospect($id){
		$result = $this->user_model->get_prospect_list("prospects_id='$id'");
		echo json_encode($result);
	}
	
	public function update_prospect(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$id = $this->input->post('id');
			$name = $this->input->post('name');
			$relationship = $this->input->post('relationship');
			$phone = $this->input->post('phone');
			$email = $this->input->post('email');
			$profile = $this->input->post('profile');
			$background = $this->input->post('background');
			$pi = 0;
			foreach($profile as $i => $p){
				if($p){
					$pi += pow(2, $i);
				}
			}
			if(!$id){
				$ret = $this->user_model->insert_prospect(array(
					'prospects_user_id' => $this->user['users_id'],
					'prospects_name' => $name,
					'prospects_relationship' => $relationship,
					'prospects_phone' => $phone,
					'prospects_email' => $email,
					'prospects_profile' => $pi,
					'prospects_background' => $background
				));
				echo json_encode(array('success' => $ret));
			}
			else{
				$ret = $this->user_model->update_prospect(array(
					'prospects_user_id' => $this->user['users_id'],
					'prospects_name' => $name,
					'prospects_relationship' => $relationship,
					'prospects_phone' => $phone,
					'prospects_email' => $email,
					'prospects_profile' => $pi,
					'prospects_background' => $background
				), "prospects_id='$id'");
				echo json_encode(array('success' => $ret));
			}
		}
	}
	
	public function delete_prospect($id = 0){
		$ret = $this->user_model->delete_prospect(array($id));
		echo json_encode(array('success' => $ret));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */