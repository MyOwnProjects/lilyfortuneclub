<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Password extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}
	
	public function index(){
		$error = '';
		$success = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$password = $this->input->post('password');
			$confirm_password = $this->input->post('confirm_password');
			if(strlen($password) < 5){
				$error = "Password must be at least 5 characters.";
			}
			if(strpos($password, ' ') !== false){
				$error = "Password cannot contain space.";
			}
			else if($password != $confirm_password){
				$error = "Confirm password does not match.";
			}
			else{
				if(!$this->user_model->update($this->user['users_id'], array('password' => $password))){
					$error = "Failed to change password";
				}
				else{
					$success = 'Password has been changed successfully.';
				}
			}
		}
		$this->load_view('account/password', array('error' => $error, 'success' => $success));
	}
	
	public function view($file){
		$result = $this->document_model->get_list("uniqid='$file'");
		if(count($result) != 1){
			$this->load_view('documents/view', array('error' => 'The document does not exist.'));
			return;
		}
		if(!empty($result[0]['file_name'])){
			$full_path = getcwd().'/application/documents/'.$result[0]['uniqid'].'.'.$result[0]['file_name'];
			if(!file_exists($full_path)){
				$this->load_view('documents/view', array('error' => 'The document does not exist.'));
				return;
			}
			$ext = pathinfo($result[0]['uniqid'].'.'.$result[0]['file_name'], PATHINFO_EXTENSION);
			$file = uniqid().'.'.$ext;
			$to = getcwd().'/src/temp/'.$file;
			if(!@copy($full_path, $to)){
				$this->load_view('documents/view', array('error' => 'The document does not exist.'));
				return;
			}
			$mime_type = mime_type($full_path);
			$content_mime_type = $mime_type[0];
		}
		else{
			$content_mime_type = $result[0]['mime_content_type'];
		}
		$this->load_view('documents/view', array('subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'file' => $file, 'name' => $result[0]['file_name'],
			/*infolab.stanford.edu/pub/papers/google.pdf'*/ 'src'=> 'https://docs.google.com/gview?url=%s&embedded=true'));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */