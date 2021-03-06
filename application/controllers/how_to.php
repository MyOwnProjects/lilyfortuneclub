<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class How_to extends Base_controller {
	private $list_content;
	public function __construct(){
		parent::__construct();
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
		
		$this->list_content = array(
			'ama' => array(
				'img' => 'WFG_logo.jpg',
				'text' => 'Sign up a new member',
				'content' => '
				1. Go to <a href="https://ama.mywfg.com" target="_blank">AMA</a>, choose United State (or Canada), then enter your personal information.<br/>
				2. Click "OK".<br/>
				3. Recruiter, enter the recruiter\' agent code, then Click "Verify"  Make sure it is recruiter\' legal name, Next, Next, Next.<br/>
				4. Enter Personal Information, Next.<br/>
				5. Background Questions (in general, NO on first 9 questions; Yes on #10), Next.<br/>
				6. Check on "I agree to use electronic records and signatures.", "Continue"; Verify your information; Look for "Sign"; Use "Select style" "Adopt and Sign".<br/>
				7. Acknowledgement; Initials.<br/>
				8. W-9; "Dedicated member"; Finish; Pay NOW $100 (fill in your credit card)  
				'
			),
			'business' => array('url' => base_url().'account/business',
				'img' => 'give-money.svg',
				'text' => 'Startup the business'
			),
			'license' => array('url' => base_url().'account/license',
				'img' => 'certificate.svg',
				'text' => 'Get license'
			),
			'e_o' => array(
				'name' => 'e_o',
				'img' => 'WFG_logo.jpg',
				'text' => 'Subscribe E&O recurring payment',
				'content' => '
				1. Log in to <a href="https://www.mywfg.com" target="_blank">MyWFG</a>.<br/>
				2. Click Menu > Administration > Errors & Omissions(E&O) > Errors & Omissions(E&O) Payment > Errors & Omissions(E&O) Payment(US).<br/>
				3. In the new page, select E&O Payment.<br/>
				4. Follow the instruction to subscribe the recurring E&O payment.'
			),
			'transamerica_illistration' => array(
				'img' => 'transamerica-worksite-marketing-squarelogo.png',
				'text' => 'Run Transamerica illustration',
				'content' => '				1. Log in to <a href="https://www.mywfg.com" target="_blank">MyWFG</a>.<br/>
					2. Click Menu > recruiting & Selling > Sales Tools & Info > MyTransWare Illustration System.<br/>
					3. Click "Click here to continued".<br/>
					4. To run a FFIUL illustration, select "Index Universal Life". To run a term illustration, select "Trendsetter ® Term Portfolio".<br/>
					5. After the webpage goes to the illustration page, click Producer on the left top of the page. In the new form, click New, then enter your (agent) information, save it, and close the form.<br/> 
					6. Then fill the required fields for the illustration.<br/>
					7. After all the fields are filled, click Report > Summary at the left bottom for summary data. To get full version of the illustration, click Report > Illustration.<br/>
					8. To save the illustration, click Case > Save/Save As.<br/>
				'
			),
			'igo' => array(
				'img' => 'transamerica-worksite-marketing-squarelogo.png',
				'text' => 'Fill Transamerica application online',
				'content' => '
					1. Log in to <a href="https://www.mywfg.com" target="_blank">MyWFG</a>.<br/>
					2. Click Menu > recruiting & Selling > Sales Tools & Info > iGO.<br/>
					3. Click "LAUNCH iGO for Transamerica".<br/>
					4. Click "Click here to continued".<br/>
					5. Click "Start New Case".<br/>
					6. Then follow the instruction to fill the pages.<br/>
				'
			),
			'medical_exam' => array(
				'img' => 'medical-kit.svg',
				'text' => 'Order medical exam',
				'content' => '<div>1. Medical order bloodwork for local in bay area</div>
					<div>
						<p>- Send an email to penghu501@gmail.com (the examiner is Peng Hu) to order the blood test.<br/>
						- Include the exam date, insured name, policy provider, policy number if applicable, policy type, with/without LTC, face amount, insured date of birth, insured address, phone number, email, agent name and agent code. And indicate that you are Lily Zhu\'s team.<br/>
						- Call Peng Hu at 408-315-7070, to confirm the appointment, and tell Peng your are in Lily Zhu\'s team.<br/>
						</p>
					</div>
					<div>2. Medical order bloodwork for remote city
						<p>- Go to <a href="https://www.mcmdms.com/" target="_blank">MCMDMS</a> and log in to your account (Create an account if you don not have one).<br/>
						- Select "AGENT" button in the main menu bar.<br/>
						- Click "Order Exam" in the Agent section.<br/>
						- Enter the information, and click "Submit".
						</p>
					</div>'
			),
			'seven_pay_dca' => array(
				'img' => 'cash.svg',
				'text' => 'Process FFIUL seven pay and DCA',
				'content' => '<div>1. Max Fund seven pay into BASIC INTEREST ACCOUNT.</div>'
				.'<p> - Before you call to the Transamerica inforce department, prepeare the your agent code, policy number, bank account information.<br/>'
				.' - Call the inforce department at (800) 322-3796, and follow the instruction.<br/>'
				.' - Stop monthly automatic draft.<br/>'
				.' - Stop monthly billing statement and change it to annual and bill seven pay amount.<br/>'
				.' - Max fund seven pay into BASIC INTEREST ACCOUNT, double confirm this is for basic interest account, and write down the date, time and dollar amount for record.</p>'
				.'<div>2. Fax the DCA form.</div>'
				.'<p> - Wait for 2 to 3 days, then check the status at premier.transamerica.com to make sure the transfer is done.<br/>'
				. '- If the $ is successfully tranfered in basic interest account, DCA into global index account, fill out and fax in the DCA form to 727-299-1620.</p>'
			),	
			'change_of_address' => array(
				'img' => 'address.svg',
				'text' => 'Change business address',
				'content' => '1. Download the <a href="'.base_url().'src/doc/upload/WFG10011_4 17 Authorization for Agent Info Change fillable.pdf" target="_blank">fillable form</a><br/>
					2. Fill the you name, code, date, and the new office address.<br/>
					3. Ask your SMD to sign the form.<br/>
					4. Send the filled from to wfglicenseapps@transamerica.com, and wfgcoding@transamerica.com'
			),
		);
		
	}
	
	public function index(){
		$this->load_view('account/how_to', array('list' => $this->list_content));
	}
	
	public function item($item = null){
		$how_to_steps = array(
			'igo' => array(
			),
			'ama' => array(
			),
			'transamerica_illistration' => array(
			),
			'nationwide_illistration' => array(
			),
		);
		if(array_key_exists($item, $how_to_steps)){
		}
		else{
			header('location:'.base_url().'how_to');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */