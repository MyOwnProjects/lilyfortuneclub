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
				'<p>
					<img src="'.base_url().'src/img/WFG_logo.jpg" class="pull-left" style="width:50px;margin-right:20px">
					World Financial Group (WFG) is one of the few companies of its kind in the industry today. WFG, an AEGON Company, is dedicated to serving the financial needs of individuals and families from all walks of life. AEGON is an international life insurance, pension and investment group based in The Hague, The Netherlands, with businesses in more than 20 markets in the Americas, Europe, and Asia. In June 2001, WFG was acquired by Aegon, and wholly owned by <b>Transamerica</b>, a subsidiary of AEGON.
				</p>
				<p>WFG Associates have the ability to offer products and services from a broad array of financial services providers. This enables our associates to find the very best solution for their clients, including insurance protection and lifestyle changes. </p>
				<p>WFG Associates are committed to:
					<br/>&nbsp;&nbsp;-&nbsp;Helping individuals and families who are often overlooked by other companies in the financial services industry. 
					<br/>&nbsp;&nbsp;-&nbsp;Working with clients to create a customized strategy to protect them and their families. 
					<br/>&nbsp;&nbsp;-&nbsp;Educating individuals, families and business owners that financial decisions made today are critical in determining their financial futures.
				</p>
				<p>
					<img src="'.base_url().'src/img/Transamerica_Corporation.png" class="pull-left" style="width:150px;margin-right:20px">
					World Financial Group (WFG) is a Transamerica Company. Transamerica is one of the world’s leading financial services companies, providing insurance, investments and more to 19 million customers. Transamerica companies offer a wide array of life and health insurance solutions that can help create better tomorrows by protecting families and their dreams. With more than a century of experience, Transamerica has built a solid reputation due to its sound management and decision-making as well as consumer confidence. In 1999, it became a subsidiary of Aegon. To learn more about Transamerica, <a href="http://www.transamerica.com/" target="_blank">click here</a>.
					<br/>&nbsp;&nbsp;-&nbsp;<a href="https://www.transamerica.com/individual/about-us/who-we-are/financial-strength/" target="_blank">TransAmerica&#39;s Financial Strength.</a>
					<br/>&nbsp;&nbsp;-&nbsp;<a href="http://www.investopedia.com/articles/financial-advisors/081215/independent-brokerdealers-most-women-advisors.asp" target="_blank">Transamerica Financial Advisors, Inc is the #1 independent Broker Dealer with the most women advisers.</a>
				</p>
				<p>
					<img src="'.base_url().'src/img/AEGON_(logo).svg" class="pull-left" style="width:100px;margin-right:20px">
					 Aegon N.V. is a multinational life insurance, pensions and asset management company headquartered in The Hague, Netherlands, is one of the world&#39;s leading insurance, pension and related financial services organizations. At the end of 2015, Aegon companies employed approximately 31,530 people worldwide, serving millions of customers. Aegon has major operations in the United States, where it is mostly represented through World Financial Group and Transamerica.
					 <br/>&nbsp;&nbsp;-&nbsp;<a href="http://www.bloomberg.com/news/articles/2015-11-03/aegon-is-added-to-fsb-s-list-of-nine-too-big-to-fail-insurers" target="_blank">Aegon, our parent company, was recently named as one of the 9-Too-Big-To-Fail Insurers in the world.</a>
				</p>
				<p>Ms. Lily Min Zhu is a Senior Marketing Director with
					World Financial Group, a Transamerica Company. She has many years professional
					management experience at Intel and Samsung in
					California. Ms. Zhu and her business
					partners built a successful financial services business based in the San Francisco Bay Area, and
					established a well respected professional brand, especially
					among many high end customers. She received top 25 personal producer / financial advisor award from Transamerica , out of around 70,000 licensed professionals, and her name was published in Fortune Magazine in 2017. Currently Ms. Zhu and her business partners represent
					around 200 top rated financial companies. They provide
					total solutions and individualized/personalized asset
					allocation strategies, include investment, retirement, life
					insurance, long term care, tax planning, estate planning
					and education planning. Ms. Zhu is also dedicated to
					establish the US asset diversification channel for high net
					worth individuals and to provide long term and dependable
					professional services.
				</p>',
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