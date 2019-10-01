<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Training extends Base_Controller {
	private $_params_str;
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$data = array();
		$this->_scan_dir('src/training', $data);
		$this->load_view('account/training', array('data' => $data));
	}
	
	private function _scan_dir($path, &$result){
		$scan_files = scandir($path);
		foreach($scan_files as $file){
			if(in_array($file, array('.', '..', '.htaccess'))){
				continue;
			}
			$full_file = getcwd().'/'.$path.'/'.$file;
			$ext = pathinfo($full_file, PATHINFO_EXTENSION);
			$size = filesize($full_file);
			$type = filetype($full_file);
			$atime = date("Y-m-d H:i:s", fileatime($full_file));
			$ctime = date("Y-m-d H:i:s", filectime($full_file));
			$mtime = date("Y-m-d H:i:s", filemtime($full_file));
			$item = array(
				'name' => $file,
				'path' => $path,
				'ext' => $ext,
				'size' => $size,
				'type' => $type,
				'atime' => $atime,
				'ctime' => $ctime,
				'mtime' => $mtime,
			);
			if($type == 'dir'){
				$item['children'] = array();
				$this->_scan_dir($path.'/'.$file, $item['children']);
			}
			array_push($result, $item);
		}
	}

	public function view(){
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
		$file = $this->input->get('file');
		if(!file_exists($file)){
			return;
		}
		$file_info = pathinfo ($file);
		$ext = strtolower($file_info['extension']);
		if($ext == 'pdf'){
			$this->load->view('pdf_viewer', array('file' => $file));
		}
		else if($ext == 'mp4'){
			$this->load->model('schedule_model');
			$schedule = $this->schedule_model->get_list("schedule_start_date>=".date_format(date_create(), "Y-m-d"), array("schedule_start_date ASC", "schedule_start_time ASC"));
			$this->load_view('video_viewer', array('schedule' => $schedule, 'file' => $file));
		}
		else if(in_array($ext, array('ppt', 'pptx', 'doc', 'docx'))){
			$this->load->view('doc_viewer', array('subject' => $file_info['basename'], 'file' => $file));
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */