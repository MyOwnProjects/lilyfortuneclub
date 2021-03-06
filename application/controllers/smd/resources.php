<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Resources extends Smd_Controller {

	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->load->model('resource_model');
		$this->nav_menus['resources']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['resources']['sub_menus']['']['active'] = true;
		$this->load_view('resources/list');
	}
	
	public function get_resource_list(){
		$search_str = trim($this->input->post('search'));
		$search = isset($search_str) && $search_str !== '' ? preg_split('/[\s,]+/', $search_str) : array();
		$current = $this->input->post('current');
		$row_count= $this->input->post('row_count');
		$sort = $this->input->post('sort');
		$filter = $this->input->post('filter');
		$where = '1=1 ';
		if(!empty($search)){
			$serch_where = array();
			foreach($search as $s){
				array_push($serch_where, "subject LIKE '%$s%' OR content LIKE '%$s%'");
			}
			$where .= " AND (".implode(" OR ", $serch_where).") ";
		}
		$where .= (empty($filter) || is_null($filter[key($filter)]) || $filter[key($filter)] == '' ? "" : " AND ".key($filter)."='".$filter[key($filter)]."'");
		$ret = array(
			'current' => 1,
			'last' => 0,
			'row_count' => $row_count,
			'search' => $search_str,
			'rows' => array(),
			'total' => 0
		);
		$total = $this->resource_model->get_list_total($where);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$order_by = array();
			if(!empty($sort)){
				foreach($sort as $k => $v){
					array_push($order_by, "$k $v");
				}
			}
			$ret['rows'] = $this->resource_model->get_list($where, $order_by, (($ret['current'] - 1) * $ret['row_count']).", ".$ret['row_count']);
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['id'] = $r['resources_id'];
				$ret['rows'][$i]['subject'] = '<a href="'.base_url().'resource/item/'.$r['url_id'].'" target="_blank">'.$r['subject'].'</a>';
				$ret['rows'][$i]['source'] = $r['source'];
				$ret['rows'][$i]['create_time'] = $r['create_time'];
				$ret['rows'][$i]['action'] =  array(
					'update' => base_url().'smd/resources/edit/'.$r['resources_id']
				);
			}
		}
		echo json_encode($ret);
	}
	
	public function create(){
		$error = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$subject = trim($this->input->post('subject'));
			$top = $this->input->post('top');
			$language = $this->input->post('language');
			$source = trim($this->input->post('source'));
			$source_url = trim($this->input->post('source_url'));
			//$content = $this->update_content(trim($this->input->post('content')));
			$content = update_content(trim($this->input->post('content')), 'src/img/resource');
			$upload_files = $this->input->post('upload_files');
			$ext = null;
			if(!empty($upload_files)){
				$ext = substr(strrchr($upload_files,'.'),1);
			}

			$id = $this->resource_model->insert($subject, $source, $source_url, $content, $top, $language, $ext);
			if($id){
				if(!empty($upload_files)){
					$ext = substr(strrchr($upload_files,'.'),1);
					$file_id = sha1($id).$id;
					rename(getcwd().'/src/doc/resources/'.$upload_files, getcwd().'/src/doc/resources/'.$file_id.'.'.$ext);
				}
				header('location: '.base_url().'smd/resources');
				exit;
			}
			$error = 'Failed to create resource';
		}
		$this->load_view('resources/create', array_merge($this->input->post() ? $this->input->post() : array(), array('error' => $error)));
	}
	
	public function edit($id){
		$fields = array();
		$error = '';
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$subject = trim($this->input->post('subject'));
			$source = trim($this->input->post('source'));
			$source_url = trim($this->input->post('source_url'));
			$content = update_content(trim($this->input->post('content')), 'src/img/resource');
			$top = $this->input->post('top');
			$language = $this->input->post('language');
			$prop = array(
				"subject='".addslashes($subject)."'",
				"source=".(empty($source) ? 'NULL' : "'".addslashes($source)."'"),
				"source_url=".(empty($source_url) ? 'NULL' : "'".addslashes($source_url)."'"),
				"content='".addslashes($content)."'",
				"top='$top'",
				"language='$language'"
			);
			if($this->resource_model->update("resources_id='$id'", $prop)){
				header('location: '.base_url().'smd/resources');
				exit;
			}
			$fields = $this->input->post();
			$error = 'Failed to create resource';
		}
		else{
			$result = $this->resource_model->get_items("resources_id='$id'");
			if(count($result) > 0){
				$fields = array(
					'subject' => $result[0]['subject'],
					'source' => $result[0]['source'],
					'source_url' => $result[0]['source_url'],
					'content' => $result[0]['content'],
					'top' => $result[0]['top'],
					'language' => $result[0]['language']
				);
			}
			else{
				$error = 'Invalid resource id';
			}
		}
		$this->load_view('resources/create', array_merge($fields, array('id' => $id, 'error' => $error)));
	}

	public function delete(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$ids = $this->input->post('selected_ids');
			$this->resource_model->delete("resources_id IN ('".implode("','", $ids)."')");
			echo json_encode(array('success' => true));
		}
		else{
			$items = array(
				array(
					'tag' => 'text', 'text' => 'Do you want to delete the resource(s)?' 
				)
			);
			$this->load->view('smd/add_item', array('items' => $items));
		}
	}
	
	public function upload_files(){
		$this->load->library('upload');
		$uniq_id = uniqid();
		$dir = getcwd().'/src/doc/resources/';
		$this->upload->set_upload_path($dir);
		$this->upload->set_allowed_types('*');
		if($this->upload->do_upload('ajax-upload-file')){
			$data = $this->upload->data();
			$data['final_file_name'] = $uniq_id.'.'.$data['file_name'];
			rename($dir.$data['file_name'], $dir.$data['final_file_name']);
			echo json_encode(array('success' => true, 'data' => $data));
		}
		else{
			echo json_encode(array('success' => false, 'error' => $this->upload->display_errors()));
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */