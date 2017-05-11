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
				'subject' => 'Startup Your Business',
				'icon' => base_url().'src/img/give-money.svg',
				'question' => 'Do you want to startup your own business?',
				'text' => array(
					'- The best approach is to go to training <a href="<?php echo base_url();?>schedule">class</a> and field training!',
					'- Start from here - building your business team.'
				),
				'btn' => array(
					'url' => base_url().'account/business',
					'text' => 'Statup you business'
				)
			),
			array(
				'subject' => 'Finance Education',
				'icon' => base_url().'src/img/books-stack-of-three.svg',
				'question' => 'Do you understand your own family financial status?',
				'text' => array(
					'- The best approach is to go to training <a href="<?php echo base_url();?>schedule">class</a> and field training!',
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