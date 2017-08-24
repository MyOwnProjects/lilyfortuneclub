<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Startup extends Account_base_controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$data = array(
			array(
				'subject' => "Welcome to WFG, Lily's Finance Team",
				'icon' => base_url().'src/img/gift.svg',
				'text' => array(
					'Congratulations on your decision to become an associate with World Financial Group (WFG). We believe you’ve made an excellent choice for you and your family, and will soon be helping others to achieve their dreams as well.',
				),
				'btn' => array(
					'url' => base_url().'account/business',
					'text' => "Let's start"
				)
			),
			array(
				'subject' => 'Important to Know',
				'icon' => base_url().'src/img/exclamation-sign.svg',
				'question' => 'It is important to know before you startup the business!',
				'text' => array(
					'- Know about the <a href="'.base_url().'account/documents/view/599e6834d4d8c" target="_blank">promotion standard</a>.',
					'- Know about the <a href="'.base_url().'account/documents/view/599e6b4cc736e" target="_blank">commission split and override rule</a>.'
				),
			),
			array(
				'subject' => 'Startup Your Business',
				'icon' => base_url().'src/img/give-money.svg',
				'question' => 'Do you want to startup your own business?',
				'text' => array(
					'- The best approach is to go to training <a href="'.base_url().'seminar" target="_blank">class</a> and field training!',
					'- Start from here - building your business team.'
				),
				'btn' => array(
					'url' => base_url().'account/business',
					'text' => 'Statup your business'
				)
			),
			array(
				'subject' => 'Get Your License',
				'icon' => base_url().'src/img/certificate.svg',
				'question' => 'Get your license',
				'text' => array(
					'- Complete the 52 hours online courses.',
					'- Take and pass the license exam.',
					'- Apply for your license.',
					'- Finish continuing education courses.',
				),
				'btn' => array(
					'url' => base_url().'account/license',
					'text' => 'Prepare your license'
				)
			),
			array(
				'subject' => 'Finance Education',
				'icon' => base_url().'src/img/books-stack-of-three.svg',
				'question' => 'Do you understand your own family financial status?',
				'text' => array(
					'- The best approach is to go to training <a href="<?php echo base_url();?>schedule" target="_blank">class</a> and field training!',
					'- Start to learn the finance knowledge yourself.'
				),
				'btn' => array(
					'url' => base_url().'account/documents',
					'text' => 'Learn finance knowledge'
				)
			),
			array(
				'subject' => 'WFG History',
				'icon' => base_url().'src/img/history-clock-button.svg',
				'question' => "Are you interested in WFG's history?",
				'text' => array(
					"- Watch the video to know about WFG's history."
				),
				'btn' => array(
					'url' => 'javascript:void(0)',
					'text' => 'Watch WFG History'
				)
			),
		);
		$this->load_view('startup', array('pages' => $data));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */