<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Index extends Base_Controller {
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		if($this->not_signed_in()){
			$this->load_view('home');
		}
		else{
			$data = array();
			$this->_scan_dir('src/training', $data);
			$this->load_view('account/training', array('data' => $data));
		}
	}
	
	
	private function _scan_dir($path, &$result){
		$scan_files = scandir($path);
		foreach($scan_files as $file){
			if(in_array($file, array('.', '..', '.htaccess'))){
				continue;
			}
			$full_file = $path."\\".$file;
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */