<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Training extends Smd_Controller {

	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->load->model('training_model');
		$this->nav_menus['training']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['documents']['sub_menus']['']['active'] = true;
		$this->load_view('training/list');
	}
	
	public function get_files(){
		$path = $this->input->post('path');
		$sort = $this->input->post('sort');
		$scan_files = scandir($path, $sort);
		$folders = array();
		$files = array();
		foreach($scan_files as $file){
			if(in_array($file, array('.', '..', '.htaccess'))){
				continue;
			}
			$full_file = getcwd().'/'.$path."/".$file;
			$ext = pathinfo($full_file, PATHINFO_EXTENSION);
			$size = filesize($full_file);
			$type = filetype($full_file);
			$atime = date("Y-m-d H:i:s", fileatime($full_file));
			$ctime = date("Y-m-d H:i:s", filectime($full_file));
			$mtime = date("Y-m-d H:i:s", filemtime($full_file));
			if($type == 'dir'){
				array_push($folders, array(
					'name' => $file,
					'ext' => $ext,
					'size' => $size,
					'type' => $type,
					'atime' => $atime,
					'ctime' => $ctime,
					'mtime' => $mtime,
				));
			}
			else{
				array_push($files, array(
					'name' => $file,
					'ext' => $ext,
					'size' => $size,
					'type' => $type,
					'atime' => $atime,
					'ctime' => $ctime,
					'mtime' => $mtime,
				));
			}
		}
		
		echo json_encode(array('folders' => $folders, 'files' => $files));
	}
	
	public function upload_files(){
		$_FILES['uploaded']['name'];
		$path = $this->input->post('path');
		foreach($_FILES["uploaded"]["name"] as $i => $name){
			move_uploaded_file($_FILES["uploaded"]["tmp_name"][$i], $path.'/'.$name);
		}
	}
	
	public function delete_file(){
		$file = $this->input->post('file');
		unlink($file);
		echo json_encode(array('success' => true));
	}

	public function rename_file(){
		$old = $this->input->post('old');
		$new = $this->input->post('new');
		rename($old, $new);
		echo json_encode(array('success' => true));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */