<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class License extends Account_base_controller {
	private $summary;
	public function __construct(){
		parent::__construct();
		$this->summary = array(
			'There are 2 or 3 steps to get your license, denpends on the state',
			'steps' => array(
				array(
					'subject' => 'Online 52 Hourse Cource',
					'url' => base_url().'account/license/online_course',
					'comment' => 'The online 52 hours class is mandatory in some states, such as California. Some states do not require it, such as New Hampshire. <b>The online class is strongly recommended before your license exam, no matter the class is required or not</b>.',
					'instruct' => array(
						'subject' => "52 Hours Online Class Registration",
						'image_file_name'=> 'license-52-hours',
						'steps' => array(
							'Go to the 52 online courses website at <a href="https://www.examfx.com" target="_blank">www.examfx.com</a>, and click <span class="screen-shot-btn">GET STARTED NOW</span> button.',
							'In the edit box, enter <i>teamaspire@examfx.com</i>, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
							'Click <span class="screen-shot-btn">NEW STUDENT</span> button.',
							'Click the link <span class="screen-shot-btn">Life and Health Insurance</span>.',
							'In the dropdown box, select your state, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
							'Read the policy carefully in this page, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
							'Select the package you want. The first or second choice is recommended, since Continuing Education is required after you get your licence.',
							'Click <span class="screen-shot-btn">CONTINUE</span> button directly.',
							'Click <span class="screen-shot-btn">I ACCEPT</span> button.',
							'Enter the information to create your account, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
							'Enter your credit card information, and then click <i>Process Order</i> button.',
							'Click the <span class="screen-shot-btn">Launch Course</span> button.',
							'Congratulations! You have completed the registration. Fowllong the instruction in your account, and start your class.'
						),
					)
				),
				array(
					'subject' => 'License Exam',
					'url' => base_url().'account/license/exam',
					'comment' => 'You must correctly answer above 60 or 70 percent, depends on state, of 150 questions in 3 hours to pass the exam.',
					'instruct' => array(
						'subject' => "52 Hours Online Class Registration",
						'image_file_name'=> 'license-52-hours',
						'steps' => array(
							'Go to the 52 online courses website at <a href="https://www.examfx.com" target="_blank">www.examfx.com</a>, and click <span class="screen-shot-btn">GET STARTED NOW</span> button.',
							'In the edit box, enter <i>teamaspire@examfx.com</i>, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
							'Click <span class="screen-shot-btn">NEW STUDENT</span> button.',
							'Click the link <span class="screen-shot-btn">Life and Health Insurance</span>.',
							'In the dropdown box, select your state, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
							'Read the policy carefully in this page, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
							'Select the package you want. The first or second choice is recommended, since Continuing Education is required after you get your licence.',
							'Click <span class="screen-shot-btn">CONTINUE</span> button directly.',
							'Click <span class="screen-shot-btn">I ACCEPT</span> button.',
							'Enter the information to create your account, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
							'Enter your credit card information, and then click <i>Process Order</i> button.',
							'Click the <span class="screen-shot-btn">Launch Course</span> button.',
							'Congratulations! You have completed the registration. Fowllong the instruction in your account, and start your class.'
						),
					)
				),
				array(
					'subject' => 'License Application',
					'url' => base_url().'account/license/ce',
					'comment' =>'Additional online classes are required afetr you get your license. No exam is required for these class.'
				)
			)
		);
	}
	
	public function index(){
		$this->load_view('license', array('summary' => $this->summary));
	}
	
	public function online_courses(){

		$this->load_view('license_instruct', array('instruct' => $this->summary['steps'][0]['instruct']));
	}
	
	public function exam(){
		$instruct = array(
			'subject' => "License Exam Registration",
			'image_file_name'=> 'license-52-hours',
			'steps' => array(
				'Go to the 52 online courses website at <a href="https://www.examfx.com" target="_blank">www.examfx.com</a>, and click <span class="screen-shot-btn">GET STARTED NOW</span> button.',
				'In the edit box, enter <i>teamaspire@examfx.com</i>, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
				'Click <span class="screen-shot-btn">NEW STUDENT</span> button.',
				'Click the link <span class="screen-shot-btn">Life nd Health Insurance</span>.',
				'In the dropdown box, select your state, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
				'Read the policy carefully in this page, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
				'Select the package you want. The first or second choice is recommended, since Continuing Education is required after you get your licence.',
				'Click <span class="screen-shot-btn">CONTINUE</span> button directly.',
				'Click <span class="screen-shot-btn">I ACCEPT</span> button.',
				'Enter the information to create your account, and then click <span class="screen-shot-btn">CONTINUE</span> button.',
				'Enter your credit card information, and then click <i>Process Order</i> button.',
				'Click the <span class="screen-shot-btn">Launch Course</span> button.',
				'Congratulations! You have completed the registration. Fowllong the instruction in your account, and start your class.'
			),
		);
		$this->load_view('license_instruct', array('instruct' => $instruct));
	}
	
	public function application(){
	}
	
	public function ce(){
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */