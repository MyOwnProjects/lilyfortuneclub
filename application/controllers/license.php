<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class License extends Base_controller {
	private $summary;
	public function __construct(){
		$this->guest_access_allowed = true;
		parent::__construct();
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
		$steps = array(array(
			'title' => 'Courses',
			'comment' => 'The 52 hours onine courses are mandatory in some states, such as California. Some states do not require it, such as New Hampshire. <u>The online class is strongly recommended before your license exam, no matter the class is required or not</u>.'
			.'<br/><br/><img style="height:16px;width:auto;margin-top:-5px" src="'.base_url().'src/img/star.svg">&nbsp;<b>Practise <a href="'.base_url().'documents?content_type=license" target="_blank">exam questions</a> here.</b>',
			'subject' => "52 Hours Online Class Registration",
			//'image_file_name'=> 'license-52-hours',
			'steps' => array(
				'Go to <a href="https://www.examfx.com/" target="_blank">examfx.com</a>.',
				'Click "Register Now".',
				'Under "Special Company Discount Pricing", enter our company discount email as "assistant.aspire@gmail.com", click "Next Step".',
				'Select Product "Insurance Prelicensing", then choose "California".', 
				'Select Training "Life and Health Insurance", then click "Next Step".',
				'Select Package, " California Life and Health Insurance, $29.95, Video Study Package - Life and Health", then "Next Step".', 
				'Select add-on, select "Continue" without selecting any other package.',
				'Select "New Users" in the 2nd tab, and fill out information.',
				'Under "Billing Address", fill out address, select "Continue".',
				'Under Payment, fill out Card Information, select Checkout.',
				'Click the Launch Course button.',
				'Enter your information, and click "Next".',
				'There will be two courses, for "California Life and Health", need to study at least 40 hours. For "California Insurance Code and Ethics", need to study at least 12 hours.',
				'You can choose "On Demand Video Lectures".'
			),
		),
		array(
			'title' => 'Exam',
			'comment' => 'You must correctly answer above 60 or 70 percent, depends on state, of 150 questions in 195 minutes to pass the exam.'
			.'<br/><br/><img style="height:16px;width:auto;margin-top:-5px" src="'.base_url().'src/img/star.svg">&nbsp;<b>Practise <a href="'.base_url().'documents?content_type=license" target="_blank">exam questions</a> here.</b>',
			'subject' => "License Exam Registration",
			'image_file_name'=> 'license-exam',
			'steps' => array(
				'Go to the PSI Exam  website at <a href="https://candidate.psiexams.com/" target="_blank">PSI Exams Online</a>, and click <i>Create</i> an account.',
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
		),
	);
		array_push($steps,	array(
					'title' => 'Apply',
					'comment' =>'You can only apply for the license after you finished both of the 52 hours courses and license exam.',
					'subject' => "License Application",
					'image_file_name'=> 'license-application',
					'steps' => array(
							'Go to <a href="https://www.insurance.ca.gov" target="_blank">www.insurance.ca.gov</a>, type <i>flash</i>in the search box at the top right of he page, then select <i>flash</i> in the dropbox, and click the <i>Search</i> button.',
							'In the search result, click the <i>Flash Application</i> link.',
							'Click the <i>Fast Licensing Application Service is Here (Flash)</i> link.',
							'Click <i>Start New Application</i> link.',
							'Enter your California ID, select your residency, and click the <i>Next</i> button.',
							'In the next few pages, follow the instruction to enter the correct information, and the click <i>Next</i> button.<br/> - Enter your home address in <i>Home Address</i>.<br/> - Enter 39355 California Street, Suite 201-B, Fremont, CA 94538 as <i>Business Address</i>.<br/> - Use home address as your <i>Primary Address</i>.',
							'Follow the instruct to pay. After the payment, you will go back to the Check out page. You can click <i>Download Application</i> button to save your application.',
							'You license application is done. After the license is issued, you can start the continuing education.',
							'To download your license, go to <a href="https://interactive.web.insurance.ca.gov/eLicense/index.jsp" target="_blank">download your license</a>.'
						),
		));
			array_push($steps, array(
					'title' => 'CE',
					'comment' =>'You can only pass the CE exam after you get your licen number, however, you can start to learn the curses during the course of  the license application..',
					'subject' => "Continuing Education",
					'image_file_name'=> 'license-ce',
						'steps' => array(
							'Go to <a href="https://www.webce.com" target="_blank">https://www.webce.com</a>, and click <i>Sign In</i> link.',
							'If you already have an account, sign in your account, otherwise click <i>Register Now</i> link.',
							'Enter your username, and click <i>Next</i> button.',
							'Enter the account information, and then click <i>Complete Registration</i> button.',
							'After signed in your account, click <i>Insurance CE</i> link of the navigation bar, select California state in the map, and then click <i>Life and Health</i> link.',
							'Select the below courses, and add them to you cart:<br/>(1) CA 16-Hr Life & Health CE Package: Includes 8-Hr LCT & 8-Hr Annuity Initial Traning Courses<br/>(2) Anti-Money Laundering for the Insurance Industry<br/>(3) Paul J. Winn - Ethical Practice Standards for Today&#39s Producer',
							'Click <i>Checkout</i> button.',
							'Enter the payment information, and then click <i>Complete</i>button.',
							'To start the course, click <i>Start Courses</i> button.',
							'Select a course you want to take,',
							'Click <i>Begin Courses</i> button.',
							'If you have got the license, enter your Llicense Number and NPN, and click <i>Save and Continue</i>button. Otherwise, click <i>Skip</i> button.',
							'Download the PDF document, and start to learn.'
						),
				));
		if($this->user && in_array($this->user['membership_code'], array('24KIZ', '27QUE', '53VQT'))){
			array_push($steps,	array(
					'title' => 'Appoint',
					'comment' =>'To sell products through certain product providers, you must be properly appointed. There are 3 easy steps:',
					'subject' => "Carrier Appoitment",
					'image_file_name'=> 'license-appointment',
					'steps' => array(
							'<b>License Status.</b> Check the status of license in that state on MyWFG.com at MENU > Commissions & Reports > Run a Report. <b>After the status is ready, go to step 2; Otherwise wait until the status is ready.</b>',
							'<b>Electronic Appointment.</b> Go to MyWFG.com at MENU > Licensing & Appointments > Appointments > Carrier Appointments, select "Life and Disability Insurance", and then "Non-New Youk Life and Disability Carriers". Select the provider, and then fowllow the instruction.<br/>'
							.'&nbsp;&nbsp;&nbsp;&nbsp;- PacLife and Nationwide, may or may not background questionnaire, depends on the state.<br/>' 
							.'&nbsp;&nbsp;&nbsp;&nbsp;- Transamerica, need to fill eForm online, and submit.<br/>'
							.'&nbsp;&nbsp;&nbsp;&nbsp;- Voya, need to download and fill the paper application, and send through email (instruction on the paper application). ',
							'<b>Additional Email.</b> Send an email to wfghost@transamerica.com and wfglicenseapps@transamerica.com, attached with license certificate and all required CE certificate (both resident and nonresident state CE certificate, for nonresident appointment).',
					),
				));
		}
		$this->summary = array(
			'summary' => 'There are 2 or 3 steps to get your license, denpends on the state',
			'steps' => $steps		
		);
	}
	
	public function index(){
		if(false){//$this->user['preference'] == 'E' && !$this->is_mobile){
			header('location:'.base_url().'license/online_courses');
			exit;
		}
		$this->load_view('account/license', array('summary' => $this->summary));
	}
	
	public function get_step_detail(){
		$page = $this->input->get('page');
		$step = $this->input->get('step');
		echo json_encode(array(
			'subject' => $this->summary['steps'][$page]['subject'], 
			'image_file_name'=> $this->summary['steps'][$page]['steps']['image_file_name'], 
			'step' => $this->summary['steps'][$page]['steps'][$step]));
		
	}
	
	public function online_courses(){
		if(false){//$this->user['preference'] == 'E' && $this->is_mobile){
			header('location:'.base_url().'license');
			exit;
		}
		$this->load_view('license_instruct', array('instruct' => $this->summary['steps'][0]));
	}
	
	public function exam(){
		if(false){//$this->user['preference'] == 'E'){
			header('location:'.base_url().'license');
			exit;
		}
		$this->load_view('license_instruct', array('instruct' => $this->summary['steps'][1]));
	}
	
	public function application(){
		if(false){//$this->user['preference'] == 'E'){
			header('location:'.base_url().'account/license');
			exit;
		}
		$this->load_view('license_instruct', array('instruct' => $this->summary['steps'][2]));
	}
	
	public function ce(){
		if(false){//$this->user['preference'] == 'E'){
			header('location:'.base_url().'account/license');
			exit;
		}
		$this->load_view('license_instruct', array('instruct' => $this->summary['steps'][3]));
	}
	public function appointment(){
		if(false){//$this->user['preference'] == 'E'){
			header('location:'.base_url().'account/license');
			exit;
		}
		$this->load_view('license_instruct', array('instruct' => $this->summary['steps'][4]));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */