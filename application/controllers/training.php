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
		$full_file = getcwd().'/'.$file;
		if(!file_exists($full_file)){
			return;
		}
		$file_info = pathinfo ($full_file);
		$ext = strtolower($file_info['extension']);
		if($ext == 'pdf'){
			$this->load->view('pdf_viewer_1', array('file' => $file, 'name' => $file_info['basename']));
			//$this->load->view('pdf_viewer', array('file' => $file));
		}
		else if($ext == 'mp4'){
			$this->load->model('schedule_model');
			$schedule = $this->schedule_model->get_list("schedule_start_date>=".date_format(date_create(), "Y-m-d"), array("schedule_start_date ASC", "schedule_start_time ASC"));
			$this->load_view('video_viewer', array('schedule' => $schedule, 'file' => $file));
		}
		else if($ext == 'url'){
			$handle = fopen($full_file, "r");
			$str = '';
			while(!feof($handle)){
				$ch = fread($handle, 1);
				if(ord($ch) >= 33 && ord($ch) <= 126){
					$str .= $ch;
				}
			}
			header('location: '.$str);
		}
		else if(in_array($ext, array('ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx'))){
			$this->load->view('doc_viewer', array('subject' => $file_info['basename'], 'file' => $file.'?'.time()));
		}
	}
	
	function download(){
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
		$file = $this->input->get('file');
		$full_file = getcwd().'/'.$file;
		if(!file_exists($full_file)){
			return;
		}
		$file_info = pathinfo ($full_file);
		$ext = strtolower($file_info['extension']);
		if($ext == 'pdf'){
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="'.$file_info['basename'].'";');
			$f = fopen('php://output', 'w');
			$handle = fopen($full_file, "r");
			fwrite($f, fread($handle, filesize($full_file)));
			fclose($handle);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */