<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Startup extends Account_base_controller {
	public function __construct(){
		$this->guest_access_allowed = true;
		parent::__construct();
		$steps = array(array(
			'title' => 'Who',
			'comment' => '',
			'subject' => "Who we are?",
			'steps' => array(
				'<p>We are an independant team, based in San Francisco bay area, of <u>World Financial Group</u>. Our team lead (SMD), <b>Lily Min Zhu</b>, is one of the best advisors in Silicon Valley. she received top 25 personal producer / financial advisor award from Transamerica in around 70,000 licensed professionals, and her name was recently published on Fortune Magazine in 2017. She had earned very good credibility from the customers, and recognitions from teammates and business partners. She is helping us to bulid success in personal career for everyone in this team.</p>
				<p><img src="'.base_url().'src/img/WFG_logo.jpg" class="pull-left" style="width:50px;margin-right:20px">World Financial Group, Inc. (WFG) is a financial services marketing company based in Johns Creek, Georgia, whose associates help people of all income levels create appropriate financial strategies, build financial confidence and pursue financial independence. WFG has thousands of associates in the Canada and U.S. dedicated to helping everyday people achieve their family&#39;s goals for their financial future, and more than 32,000 client accounts. WFG has selling agreements with more than 50 separate insurance and mutual funds companies. In June 2001, WFG was acquired by Aegon, and wholly owned by Transamerica, a subsidiary of AEGON.</p>
				<p><img src="'.base_url().'src/img/Transamerica_Corporation.png" class="pull-left" style="width:150px;margin-right:20px">The Transamerica Corporation is an American holding company for various life insurance companies and investment firms doing business primarily in the United States, offering life and supplemental health insurance, investments, and retirement services. In 1999, it became a subsidiary of Aegon.</p>
				<p><img src="'.base_url().'src/img/AEGON_(logo).svg" class="pull-left" style="width:100px;margin-right:20px">Aegon N.V. is a multinational life insurance, pensions and asset management company headquartered in The Hague, Netherlands, is one of the world&#39;s leading insurance, pension and related financial services organizations. At the end of 2015, Aegon companies employed approximately 31,530 people worldwide, serving millions of customers. Aegon has major operations in the United States, where it is mostly represented through World Financial Group and Transamerica.</p>',
			)
		),
		array(
			'title' => 'What',
			'subject' => "What we do?",
			'steps' => array(
				'<p>Unlike other companies who target only wealthy clients, WFG is dedicated to teaching people simple financial concepts that will help them put their money to work more effectively and move them toward achieving their financial goals.</p>
				<p>We also helps families by offering everyday people an uncommon opportunity - the chance to change careers and be in business <b>for themselves, but not by themselves</b>.</p>
				<p>We are helping individuals and families who are often overlooked by other companies in the financial services industry.</p> 
				<p>We are working with clients to create a customized strategy to protect them and their families. </p>
				<p>We are educating individuals, families and business owners that financial decisions made today are critical in determining their financial futures.</p>'
			),
		)
	);
	if($this->user['membership_code'] != 'GUEST'){
		array_push($steps, array(
				'title' => 'How',
				'subject' => "How we do?",
				'steps' => array(
					"<p>To start up the business, the first step is to invite people. You can either invite your friends, relatives or colleagues to BPM, or one to one in coffee shop, office and your home. Bring your guest in front of your lead, and your lead will help you to recruit.</p>
					<p>A good way is to invite your friends to your home for kids' birthday party, or home gathering. Bring your lead to the party, and your lead will help you to invite them.</p>
					<p>Go to <a href=\"".base_url()."account/business\">Start your business</a> for details.</p>
					",
					),
				)
		);
	}
		$this->summary = array(
			'summary' => 'There are 2 or 3 steps to get your license, denpends on the state',
			'steps' => $steps		
		);
		
	}
	
	public function index(){
		$this->load_view('startup', array('summary' => $this->summary));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */