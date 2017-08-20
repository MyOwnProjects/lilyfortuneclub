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
					'subject' => '52 Hours Online Cources',
					'url' => base_url().'account/license/online_course',
					'comment' => 'The 52 hours onine courses are mandatory in some states, such as California. Some states do not require it, such as New Hampshire. <b>The online class is strongly recommended before your license exam, no matter the class is required or not</b>.',
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
							'You have completed the courses registration. Fowllow the instruction in your account, and start your class.You have to spend at least 12 hours on Code & Ethics, and 40 hours on Life and Accident & Health.',
							'After you have completed the course, click the <i>Main Menu</i> on the top bar',
							'At the bottom of the page, click <i>Get Certificate</i> link',
							'Click the <i>Get Certificate</i> link in each course.',
							'Check <i>Please send a copy of the certificate to my e-mail address</i>, and then click <i>Print Certificate</i> button. The cerfiticate will be printed, and an email will be sent.'.
							'Congratulations! You have got your online course certificate. Now let us take the license exam.',
						),
					)
				),
				array(
					'subject' => 'License Exam',
					'url' => base_url().'account/license/exam',
					'comment' => 'You must correctly answer above 60 or 70 percent, depends on state, of 150 questions in 195 minutes to pass the exam.',
					'instruct' => array(
						'subject' => "52 Hours Online Class Registration",
						'image_file_name'=> 'license-exam',
						'steps' => array(
							'Go to the PSI Exam  website at <a href="https://www.psiexams.com" target="_blank">www.psiexams.com</a>, and click <i>Create</i> an account.',
							'Enter your account information.',
							'Log in your account, in the account page, click <i>Register for a test</i> link.',
							'Select <i>Government/State Licensing Agencies</i> option.',
							'Select the state option.',
							'Select <i>CA Department of Insurance</i>.',
							'Select <i>CA PSI Site - Life, Accident and health Agent Examination (Life Agent)</i> option.',
							'Click <i>Register</i> button.',
							'Enter your information. In the School/Provider, select the <i>145803 ExamFX</i> option, and then click <i>Continue</i> button.',
							'Click <i>Continue</i> button',
							'Follow the instruction, and pay for the exam.',
							'After go back to the PSI Exam page, click the <i>schedule for the test</i> link, to select a time and location you would like for the exam, following the instruction.',
							'Next, go to take the exam at the time and location you have scheduled. Good luck!'
						),
					)
				),
				array(
					'subject' => 'License Application',
					'url' => base_url().'account/license/application',
					'comment' =>'You can only apply for the license after you finished both of the 52 hours courses and license exam.',
					'instruct' => array(
						'subject' => "License Application",
						'image_file_name'=> 'license-application',
						'steps' => array(
						)
					)
				)
			)
		);
	}
	
	public function index(){
		$this->load_view('license', array('summary' => $this->summary));
	}
	
	public function get_step_detail(){
		$page = $this->input->get('page');
		$step = $this->input->get('step');
		echo json_encode(array(
			'subject' => $this->summary['steps'][$page]['subject'], 
			'image_file_name'=> $this->summary['steps'][$page]['instruct']['image_file_name'], 
			'step' => $this->summary['steps'][$page]['instruct']['steps'][$step]));
		
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