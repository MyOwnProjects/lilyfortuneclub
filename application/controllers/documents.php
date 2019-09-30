<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('base.php');
class Documents extends Base_Controller {
	private $_params_str;
	public function __construct(){
		parent::__construct();
		$this->load->model('document_model');
	}
	
	public function index(){
		if($redirect = $this->not_signed_in()){
			header("location: $redirect");
			exit;
		}
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
				$mime_type_i = mime_type(getcwd().'/src/doc/'.$r['uniqid'].'.'.$r['file_name']);
				$result[$i]['mime_type'] = $mime_type_i;
				$result[$i]['mime_content_type'] = strtoupper($mime_type_i[0]);
			}
			else{
				$result[$i]['mime_type'] = strtolower($r['mime_content_type']);
			}
		}

		$total = $this->document_model->get_list_total($where);
		$this->load_view('documents', array('current' => $page + 1, 'total' => ceil($total / 20), 'list' => $result, 
			'mime_type_list' => $mime_type_list, 'content_type_list' => $content_type_list, 
			'mime_type' => in_array($mime_type, $mime_type_list) ? $mime_type : 'All', 
			'content_type' => in_array($content_type, $content_type_list) ? $content_type : 'All'));
	}
	
	public function view($file){
		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$result = $this->document_model->get_list("uniqid='$file'");
			if(empty($result)){
				$this->load_view('document_error', array('error' => 'The document or video does not exist.'));
				return;
			}
			if($result[0]['mime_content_type'] == 'VIDEO'){
				if($redirect = $this->not_signed_in()){
					$this->load_view('document_code', array('redirect' => $redirect));
					return;
				}
				if(!empty($result[0]['file_name'])){
					$full_path = getcwd().'/src/doc/'.$result[0]['uniqid'].'.'.$result[0]['file_name'];
					if(!file_exists($full_path)){
						$this->load_view('document_error', array('error' => 'The document does not exist.'));
						return;
					}
					$mime_type = mime_type($full_path);
					$content_mime_type = $mime_type[0];
					$file = $result[0]['uniqid'].'.'.$result[0]['file_name'];
				}

				if($this->input->is_ajax_request()){
					echo json_encode(array('subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'file' => $file, 'name' => $result[0]['file_name']));
				}
				else{//media
					$docs = $this->document_model->get_list('', array(), '');
					$this->load_view('document_item', array('uniqid' => $result[0]['uniqid'], 'abstract' => $result[0]['abstract'], 
						'expire' => 100000, 'duration' => 100000, 
						'subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 
						'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'file' => $file, 
						'name' => $result[0]['file_name'], 'abstract' => $result[0]['abstract'],
						'docs' => $docs));
				}
				//$this->load_view('document_code');
				return;
			}
			if($redirect = $this->not_signed_in()){
				header("location: $redirect");
				exit;
			}

			if(!empty($result[0]['file_name'])){
				$full_path = getcwd().'/src/doc/'.$result[0]['uniqid'].'.'.$result[0]['file_name'];
				if(!file_exists($full_path)){
					$this->load_view('document_error', array('error' => 'The document does not exist.'));
					return;
				}
			}
			$content_mime_type = strtolower($result[0]['mime_content_type']);
			if($content_mime_type == 'pdf'){
				$this->load->view('pdf_viewer', array('subject' => $result[0]['subject'], 'file' => 'src/doc/'.$result[0]['uniqid'].'.'.$result[0]['file_name']));
			}
			else if($content_mime_type == 'doc' || $content_mime_type == 'ppt' || $content_mime_type == 'excel'){
				$this->load->view('doc_viewer', array('subject' => $result[0]['subject'], 'file' => $file));
			}
			else if($content_mime_type == 'csv'){
				$max_columns = 0;
				$ret = array();
				$f = fopen($full_path, 'r');
				while(!feof($f)){
					$r = fgetcsv($f);
					$count = count($r);
					$max_columns = $count > $max_columns ? $count : $max_columns;
					array_push($ret, $r);
				}
				fclose($f);
				$this->load->view('csv_viewer', array('subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 
					'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'data' => $ret, 'max_columns' => $max_columns,  'name' => $result[0]['file_name']));
			}
			else{
				//if($this->input->is_ajax_request()){
				//	echo 1;exit;
				//	echo json_encode(array('subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'file' => $file, 'name' => $result[0]['file_name']));
				//}
				//else{
				$docs = $this->document_model->get_list('', array(), '');
				$this->load_view('document_item', 
					array_merge($result[0], array('mime_type' => $content_mime_type, 'file' => $file, 'docs' => $docs)));
				//}
			}			
			return;
		}

		$pub_code = strtoupper(trim($this->input->post('guest_code')));
		$result = $this->document_model->get_item_with_code($file, $pub_code);
		
		if(count($result) != 1){
			$this->load_view('document_error', array('error' => 'The access code is invalide. Please contact <a href="'.base_url().'contact">Lilyfortuneclub</a> to get the access code.'));
			return;
		}
//return;
		if(!empty($result[0]['file_name'])){
			$full_path = getcwd().'/src/doc/'.$result[0]['uniqid'].'.'.$result[0]['file_name'];
			if(!file_exists($full_path)){
				$this->load_view('document_error', array('error' => 'The document does not exist.'));
				return;
			}
			$mime_type = mime_type($full_path);
			$content_mime_type = $mime_type[0];
			$file = $result[0]['uniqid'].'.'.$result[0]['file_name'];
		}

		if($this->input->is_ajax_request()){
			echo json_encode(array('subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'file' => $file, 'name' => $result[0]['file_name']));
		}
		else{//media
			$docs = $this->document_model->get_list('', array(), '');
			$this->load_view('document_item', array('uniqid' => $result[0]['uniqid'], 'abstract' => $result[0]['abstract'], 
				'expire' => $result[0]['expire'], 'duration' => $result[0]['video_duration'], 
				'subject' => $result[0]['subject'], 'content_type' => $result[0]['content_type'], 
				'html_content' =>$result[0]['html_content'], 'mime_type' => $content_mime_type, 'file' => $file, 
				'name' => $result[0]['file_name'], 'abstract' => $result[0]['abstract'],
				'docs' => $docs));
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */