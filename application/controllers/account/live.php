<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Live extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('live_model');
	}
	
	public function index()
	{
		$mime_type = $this->input->get('mime_type');
		$content_type = $this->input->get('content_type');
		$mime_type_list = $this->document_model->get_all_mime_content_types();
		$content_type_list = $this->document_model->get_all_content_types();
		$page = $this->input->get('pg');
		if($page <= 0)
			$page = 0;
		else
			$page -= 1;
		$where = "1=1";
		if(!empty($mime_type) && $mime_type != 'All'){
			$where .= " AND mime_content_type='$mime_type'";
		} 
		if(!empty($content_type) && $content_type != 'All'){
			$where .= " AND content_type='$content_type'";
		} 
		$result = $this->document_model->get_list($where, array(), "$page,20");
		foreach($result as $i => $r){
			$mime_type_i = mime_type(getcwd().'/application/documents/'.$r['uniqid'].'.'.$r['file_name']);
			$result[$i]['mime_type'] = $mime_type_i;
			$r[$i]['mime_content_type'] = strtoupper($mime_type_i[0]);
		}

		$total = $this->document_model->get_list_total($where);
		$this->load_view('documents/list', array('current' => $page + 1, 'total' => ceil($total / 20), 'list' => $result, 
			'mime_type_list' => $mime_type_list, 'content_type_list' => $content_type_list, 
			'mime_type' => in_array($mime_type, $mime_type_list) ? $mime_type : 'All', 
			'content_type' => in_array($content_type, $content_type_list) ? $content_type : 'All'));
	}
	
	public function view(){
		$this->load_view('live/item', array());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */