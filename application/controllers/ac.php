<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Ac extends Base_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function sign_in()
	{
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$role = $this->input->post('role');
			if($role == 'guest'){
				$guest_name = $this->input->post('guest-name');
				$username = "GUEST";
				$password = $this->input->post('password-g');
			}
			else{
				$username = $this->input->post('username');
				$password = $this->input->post('password');
			}
			$result = $this->set_session_user($username, $password, $this->input->post('save_password'));
			if($result === true && !empty($this->user)){
				if($this->user['membership_code'] == 'GUEST'){
					$this->user_model->update_guest_access($guest_name);
					$url = base_url().'account/welcome_guest';
				}
				else{
					$redirect = $this->input->get('redirect');
					$url = base_url().(empty($redirect) ? "" : "$redirect");
				}
				header("location: $url");
				exit;
			}
			else{
				$this->load_view('sign_in', array('error' => $result));
			}
		} 
		else{
			$as = $this->input->get('as', $_GET);
			$error = $this->input->get('error', $_GET);
			$this->load_view('sign_in', array('error'=>$error, 'as' => $as));
		}
	}
	
	public function sign_out()
	{
		$this->unset_session_user();
		header('location: '.base_url());
	}
	
	public function reset_password(){
		$error = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$token = $this->input->post('token');
			if(!empty($token)){
				$user = $this->user_model->get_user_by_token($token);
				if($user){
					$password = $this->input->post('password');
					$confirm_password = $this->input->post('confirm_password');
					if($password === $confirm_password){
						if($this->user_model->update($user['users_id'], array('password' => $password, 'reset_token' => null))){
							$this->load_view('reset_password', array('message' => 'The password has been reset. Please <a href="'.base_url().'ac/sign_in">sign in</a> your account'));
						}
						else{
							$this->load_view('reset_password', array('error' => 'Failed to reset password. Please enter another email.'));
						}
					}
					else{
						$this->load_view('reset_password', array('error' => 'Confirm password does not match. Please reenter the password and confirm password.', 'token' => $token));
					}
				}
				else{
					$this->load_view('reset_password', array('error' => 'Invalid token. Please enter another email.'));
				}
			}
			else{
				$username = trim($this->input->post('username'));
				$user = $this->user_model->get_user_by_username($username);
				if($user){
					$email = $user['email'];
					if($emal){
						$token = md5($email.time());
						if($this->user_model->update($user['users_id'], array('reset_token' =>$token))){
							$this->load_view('reset_password', array('message' => "A password reset notifiction email has been sent to $email. Please check the email."));
							$smtp = array(
								'secure' => 'tls',
								'host' => 'smtp.gmail.com',
								'port' => 587,
								'username' => 'lilyfortuneclub@gmail.com',
								'password' => 'happy99forever'
							);
							$body = $this->load->view('email_template/password_reset', array('token' => $token), true);
							my_email($smtp, 'lilyfortuneclub@gmail.com', 'Lily Zhu', 
								array($user['email']), array(), array(), '', 'Password Reset Notification from Lily Fortune Club', $body);
							//mail($user['email'], 'Password Reset Notification from Lily Fortune Club', $body);
						}
						else{
							$this->load_view('reset_password', array('error' => 'Failed to reset password.'));
						}
					}
					else{
						$this->load_view('reset_password', array('error' => 'No email associated to your account. Please contact your SMD'));
					}
				}
				else{
					$this->load_view('reset_password', array('error' => 'The username does not exist. Please contact your SMD'));
				}
			}
		}
		else{
			$token = $this->input->get('token');
			if(empty($token)){
				$this->load_view('reset_password');
			}
			else if($this->user_model->get_user_by_token($token)){
				$this->load_view('reset_password', array('token' => $token));
			}
			else{
				$this->load_view('reset_password', array('error' => 'Invalid token. Please enter another username.'));
			}
		}
	}
}

