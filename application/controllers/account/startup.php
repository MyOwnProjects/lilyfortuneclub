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
					'url' => base_url().'account/startup#startup-1',
					'text' => "Let's start"
				)
			)
		);
		if($this->user['preference'] == 'B' || $this->user['preference'] == 'BE'){
			array_push($data, array(
				'subject' => 'Startup Your Business',
				'icon' => base_url().'src/img/give-money.svg',
				'question' => 'Do you want to startup your own business?',
				'text' => array(
					'- The best approach is to go to training <a href="'.base_url().'seminar" target="_blank">class</a> and field training!',
					'- Start from here - building your business team.'
				),
				'btn' => array(
					'url' => base_url().'account/business',
					'text' => 'Startup your business'
				)
			));
			array_push($data, array(
				'subject' => 'Get Your License',
				'icon' => base_url().'src/img/certificate.svg',
				'question' => 'Prepare and get your license',
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
			));
		}
		array_push($data, array(
			'subject' => 'Come to Training Classes',
			'icon' => base_url().'src/img/instructor-lecture-with-sceen-projection-tool.svg',
			'question' => 'These free classes are the best approach.',
			'text' => array(
				'- Come to our free professional <a href="'.base_url().'seminar" target="_blank">classes</a> every week.',
			),
		));
		if($this->user['preference'] == 'E'){
			$u = base_url().'account/license'.($this->is_mobile ? '' : '/online_courses');
			array_push($data, array(
				'subject' => 'Take the License Courses',
				'icon' => base_url().'src/img/certificate.svg',
				'question' => 'This is an alternative approach, which need to be paid.',
				'text' => array(
					'- Take the <a href="'.$u.'" target="_blank">52 hours online courses</a>. This is <u>manatory</u> for license.',
					'- Take the EXAM Prep/Cram Class ($68),  plus the textbook ($32). This is <u>optional</u> for license. Contact Mr. Ron Nishimura at 559-213-2341.',
				),
			));
		}
		array_push($data, array(
			'subject' => 'Know Your Own Finacial Status',
			'icon' => base_url().'src/img/learning.svg',
			'question' => 'Do you understand your own family financial status?',
			'text' => array(
				'- <a href="'.base_url().'contact" target="_blank">Contact</a> SMD, Lily Zhu, to appoint a one-hour financial analysis.',
			)
		));
		if($this->user['preference'] == 'B' || $this->user['preference'] == 'BE'){
			array_push($data, array(
				'subject' => 'Promotion and Code of Honor',
				'icon' => base_url().'src/img/promotion.svg',
				'question' => 'It is important to know the guidence before you startup the business!',
				'text' => array(
					'- Know about the <a href="'.base_url().'documents/view/59a3bbd9eb40a" target="_blank">promotion standard</a>.',
					'- Know about the <a href="'.base_url().'documents/view/599e6b4cc736e" target="_blank">commission split and override rule</a>.'
				),
			));
		}
		
		$this->load_view('startup', array('pages' => $data));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */