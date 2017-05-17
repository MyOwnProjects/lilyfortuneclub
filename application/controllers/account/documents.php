<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('account_base.php');
class Documents extends Account_base_controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('document_model');
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
		$result = $this->document_model->get_list($where, array(), "$page,1000000");
		foreach($result as $i => $r){
			if(!empty($r['file_name'])){
				$mime_type_i = mime_type(getcwd().'/application/documents/'.$r['uniqid'].'.'.$r['file_name']);
				$result[$i]['mime_type'] = $mime_type_i;
				$result[$i]['mime_content_type'] = strtoupper($mime_type_i[0]);
			}
			else{
				$result[$i]['mime_type'] = $r['mime_content_type'];
			}
		}

		$total = $this->document_model->get_list_total($where);
		$this->load_view('documents', array('current' => $page + 1, 'total' => ceil($total / 20), 'list' => $result, 
			'mime_type_list' => $mime_type_list, 'content_type_list' => $content_type_list, 
			'mime_type' => in_array($mime_type, $mime_type_list) ? $mime_type : 'All', 
			'content_type' => in_array($content_type, $content_type_list) ? $content_type : 'All'));
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
		var_dump($content_mime_type);
		if($content_mime_type == 'pdf'){
			$this->load->view('pdf_viewer', array('subject' => $result[0]['subject'], 'file' => $file));
		}
		else if($content_mime_type == 'doc' || $content_mime_type == 'ppt' || $content_mime_type == 'excel'){
			echo 123;exit;
			$this->load->view('doc_viewer', array('subject' => $result[0]['subject'], 'file' => $file));
		}
		else{
			if($this->input->is_ajax_request()){
				echo json_encode(array('subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'file' => $file, 'name' => $result[0]['file_name']));
			}
			else{
				$this->load_view('document_item', array('subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'file' => $file, 'name' => $result[0]['file_name'],
				/*infolab.stanford.edu/pub/papers/google.pdf'*/ 'src'=> 'https://docs.google.com/gview?url=%s&embedded=true'));
			}
		}
	}
	
	public function delete_temp_document(){
		$file = $this->input->get('file');
		unlink(getcwd().'/src/temp/'.$file);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */