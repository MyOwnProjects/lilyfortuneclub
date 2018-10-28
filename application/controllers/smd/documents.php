<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('smd_controller.php');
class Documents extends Smd_Controller {

	public function __construct(){
		parent::__construct();
		if(empty($this->user) || $this->user['grade'] !== 'SMD'){
			$this->redirect('smd/ac/sign_in');
			//header('location: '.base_url().'smd/ac/sign_in');
		}		
		$this->load->model('document_model');
		$this->nav_menus['documents']['active'] = true;
	}
	
	public function index()
	{
		$this->nav_menus['documents']['sub_menus']['']['active'] = true;
		$this->load_view('documents/list');
	}
	
	public function get_document_list(){
		global $grade_access;
		$search_str = trim($this->input->post('search'));
		$search = isset($search_str) && $search_str !== '' ? preg_split('/[^a-z0-9]/i', $search_str) : array();
		$current = $this->input->post('current');
		$row_count= $this->input->post('row_count');
		$sort = $this->input->post('sort');
		$filter = $this->input->post('filter');
		$where = '1=1 ';
		if(!empty($search)){
			$serch_where = array();
			foreach($search as $s){
				array_push($serch_where, "subject LIKE '%$s%' OR display_name LIKE '%$s%'");
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
		$total = $this->document_model->get_list_total($where);
		if($total > 0){
			$ret = paginate($total, $current, $row_count);
			$ret['search'] = $search_str;
			$order_by = array();
			if(!empty($sort)){
				foreach($sort as $k => $v){
					array_push($order_by, "$k $v");
				}
			}
			$ret['rows'] = $this->document_model->get_list($where, $order_by, (($ret['current'] - 1) * $ret['row_count']).", ".$ret['row_count']);
			foreach($ret['rows'] as $i => $r){
				$ret['rows'][$i]['id'] = $r['uniqid'];
				$ret['rows'][$i]['subject'] = '<a href="'.base_url().'/account/documents/view/'.$r['uniqid'].'">'.$r['subject'].'</a>';
				$ret['rows'][$i]['grade_access'] = $grade_access[$r['grade_access']];
				$ret['rows'][$i]['content_type'] = ucwords($r['content_type']);
				$ret['rows'][$i]['create_date'] = date_format(date_create($r['create_date']), 'm/d/Y H:i A');
				if(!empty($r['file_name'])){
					$mime_type = mime_type(getcwd().'/application/documents/'.$r['uniqid'].'.'.$r['file_name']);
					$ret['rows'][$i]['mime_content_type'] = '<img src="'.base_url().'/src/img/file_type/'.$mime_type[1].'.png'.'">&nbsp;'.strtoupper($mime_type[0]);
					$ret['rows'][$i]['file_name'] = $r['file_name'];
					if(file_exists(getcwd().'/application/documents/'.$r['uniqid'].'.'.$r['file_name'])){
						$file_size = filesize(getcwd().'/application/documents/'.$r['uniqid'].'.'.$r['file_name']);
					}
					else{
						$file_size = 0;
					}
					if($file_size / 1024 < 1){
						$ret['rows'][$i]['file_size'] = number_format($file_size, 0).' B';
					}
					else if($file_size / 1024 / 1024 < 1){
						$ret['rows'][$i]['file_size'] = number_format($file_size / 1024, 0).' KB';
					}
					else{
						$ret['rows'][$i]['file_size'] = number_format($file_size / 1024 / 1024, 0).' MB';
					}
				}
				else{
					if($r['mime_content_type'] == 'HTML'){
						$ret['rows'][$i]['mime_content_type'] = '<img src="'.base_url().'/src/img/file_type/html.png'.'">&nbsp;HTML';
					}
				}
				$ret['rows'][$i]['action'] =  array(
					'view' => base_url().'smd/documents/item/'.$r['uniqid']
				);
			}
		}
		echo json_encode($ret);
	}
	
	public function list_by_grade(){
		$this->nav_menus['documents']['sub_menus']['list_by_grade']['active'] = true;
		$this->load_view('documents/list', array('filter' => array(
			'id' => 'grade_access',
			'options' => array(
				'' => 'All',
				'SMD' => 'Senior Marketing Director',
				'MD' => 'Marketing Director',
				'SA' => 'Senior Associate',
				'A' => 'Associate',
				'TA' => 'Trainee Associate',
				'G' => 'Guest',
			)
		)));
	}
	
	public function list_by_content(){
		$this->nav_menus['documents']['sub_menus']['list_by_content']['active'] = true;
		$types = $this->document_model->get_all_content_types();
		$options = array('' => 'All');
		foreach($types as $t){
			$options[$t] = ucwords($t);
		}
		$this->load_view('documents/list', array('filter' => array(
			'id' => 'content_type',
			'options' => $options	
		)));
	}

	public function list_by_type(){
		$this->nav_menus['documents']['sub_menus']['list_by_type']['active'] = true;
		$types = $this->document_model->get_all_mime_content_types();
		$options = array('' => 'All');
		foreach($types as $t){
			$options[$t] = strtoupper($t);
		}
		$this->load_view('documents/list', array('filter' => array(
			'id' => 'mime_content_type',
			'options' => $options	
		)));
	}

	public function upload(){
		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$content_types = $this->document_model->get_all_content_types();
			$content_type_options = array();
			foreach($content_types as $t){
				array_push($content_type_options, array('value' => $t, 'text' => ucwords($t)));
			}
			$items = array(
				array(
					'label' => 'Subject',
					'name' => 'subject',
					'tag' => 'input'
				),
				array(
					'label' => 'Access',
					'name' => 'grade_access',
					'tag' => 'select',
					'options' => array(
						array('value' => 'G', 'text' => 'Guest an Above'),
						array('value' => 'TA', 'text' => 'Trainee Associate an Above'),
						array('value' => 'A', 'text' => 'Associate an Above'),
						array('value' => 'SA', 'text' => 'Senior Associate an Above'),
						array('value' => 'MD', 'text' => 'Margeting Director Only')
					),
					'value' => 'TA'
				),
				array(
					'label' => 'Content Type',
					'name' => 'content_type',
					'tag' => 'select',
					'options' => $content_type_options,
					'value' => ''
				),
				array(
					'label' => 'Selecte File(s)',
					'name' => 'upload_files',
					'tag' => 'input',
					'type' => 'file',
					'multiple' => true
				),
			);
			$this->load->view('smd/add_item', array('items' => $items));
		}
		else{
			$subject = $this->input->post('subject');
			$grade_access = $this->input->post('grade_access');
			$content_type = $this->input->post('content_type');
			$upload_files = $this->input->post('upload_files');
			$files = array();
			$upload_files = empty($upload_files) ? array() : explode(',', $upload_files);
			foreach($upload_files as $file){
				$mime_type = mime_type(getcwd().'/application/documents/temp/'.$file);
				if($mime_type == 'video' || $mime_type == 'audio'){
					$dest = getcwd().'/src/media/'.$file;
				}
				else{
					$dest = getcwd().'/application/documents/'.$file;
				}
				
				if(rename(getcwd().'/application/documents/temp/'.$file, $dest)){
					$pos = strpos($file, '.');
					$uniqid = substr($file, 0, $pos);
					$name =  substr($file, $pos + 1);
					array_push($files, array(
						'uniqid' => $uniqid,
						'subject' => addslashes($subject),
						'file_name' => $name,
						'grade_access' => $grade_access,
						'content_type' => $content_type,
						'mime_content_type' => $mime_type[0]
					));
				}
			}
			$success = $this->document_model->insert($files);
			echo json_encode(array('success' => $success));
		}
	}
	
	public function upload_files(){
		ini_set( 'memory_limit', '500M' );
		ini_set('upload_max_filesize', '500M');  
		ini_set('post_max_size', '500M');  
		ini_set('max_input_time', 3600);  
		ini_set('max_execution_time', 3600);		
		$this->load->library('upload');
		$uniq_id = uniqid();
		$dir = getcwd().'/application/documents/temp/';
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
			$this->load_view('documents/view', array('mime_type' => $mime_type[0], 'file' => $file, 'name' => $result[0]['file_name'],
				/*infolab.stanford.edu/pub/papers/google.pdf'*/ 'src'=> 'https://docs.google.com/gview?url=%s&embedded=true'));
		}
		else{
			if($result[0]['mime_content_type'] == 'HTML'){
			}
		}
	}
	
	public function bulk_update($field = null){
		if($this->input->server('REQUEST_METHOD') == 'GET'){
			if($field == 'content_type'){
				$content_types = $this->document_model->get_all_content_types();
				$content_type_options = array();
				foreach($content_types as $t){
					array_push($content_type_options, array('value' => $t, 'text' => ucwords($t)));
				}
				$items = array(
					array(
						'label' => 'You are assigning the content type as:',
						'name' => 'content_type',
						'tag' => 'select',
						'options' => $content_type_options,
						'value' => ''
					),
				);
			}
			else if($field == 'subject'){
				$items = array(
					array(
						'label' => 'You are changing the subject',
						'name' => 'subject',
						'tag' => 'input',
						'required' => true
					),
				);
			}
			else if($field == 'grade_access'){
				$items = array(
					array(
						'label' => 'You are assigning the grade access as',
						'name' => 'grade_access',
						'tag' => 'select',
						'options' => array(
							array('value' => 'G', 'text' => 'Guest an Above'),
							array('value' => 'TA', 'text' => 'Trainee Associate an Above'),
							array('value' => 'A', 'text' => 'Associate an Above'),
							array('value' => 'SA', 'text' => 'Senior Associate an Above'),
							array('value' => 'MD', 'text' => 'Margeting Director Only')
						), 
						'value' => ''
					),
				);
			}
			$this->load->view('smd/add_item', array('items' => $items));
		}
		else{
			$ids = $this->input->post('selected_ids');
			$grade_access = $this->input->post('grade_access');
			$content_type = $this->input->post('content_type');
			$prop = array();
			if(!empty($grade_access)){
				$prop['grade_access'] = $grade_access;
			}
			if(!empty($content_type)){
				$prop['content_type'] = $content_type;
			}
			
			$uniqids = array();
			foreach($ids as $id){
				array_push($uniqids, "'$id'");
			}
			$this->document_model->update($prop, "uniqid IN (".implode(",", $uniqids).")");
			echo json_encode(array('success' => true));
		}
	}
	
	public function delete(){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$ids = $this->input->post('selected_ids');
			$where = "uniqid IN ('".implode("','", $ids)."')";
			$result = $this->document_model->get_list($where);
			$files = array();
			foreach($result as $r){
				array_push($files, $r['uniqid'].'.'.$r['file_name']);
			}
			if($this->document_model->delete($where)){
				foreach($files as $f){
					$file = getcwd().'/application/documents/'.$f;
					if(file_exists($file)){
						unlink($file);
					}
				}
			}
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
	
	private function _second_to_time($a){
		$hour = floor($a / 60 / 60);
		$minute = floor(($a - $hour * 60 * 60) / 60);
		$second = $a - $hour * 60 * 60 - $minute * 60;
		return str_pad($hour, 2, '0', STR_PAD_LEFT).':'.str_pad($minute, 2, '0', STR_PAD_LEFT).':'.str_pad($second, 2, '0', STR_PAD_LEFT);
	}
	
	public function create(){
		$fields = array();
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$upload_files = $this->input->post('upload_files');
			if(empty($upload_files)){
				echo 'A file must be loaded';
				return;
			}
			$subject = $this->input->post('subject');
			$content_type = $this->input->post('content_type');
			$grade_access = $this->input->post('grade_access');
			$abstract = $this->input->post('abstract');
			$html_content = $this->input->post('html_content');
			$video_duration_start = intval($this->input->post('video_duration_start'));
			$video_duration_end = intval($this->input->post('video_duration_end'));
			if(!empty($video_duration_end)){
				$video_duration = ($video_duration_start).','.($video_duration_end);
			}
			$uniqid = uniqid();

			$values = array();
			$upload_files = explode(',', $upload_files);
			foreach($upload_files as $file){
				$src = getcwd().'/application/documents/temp/'.$file;
				$mime_type = mime_type($src);
				if($mime_type[0] == 'video' || $mime_type[0] == 'audio'){
					$dest = getcwd().'/src/media/'.$file;
				}
				else{
					$dest = getcwd().'/application/documents/'.$file;
				}
				
				if(rename($src, $dest)){
					$pos = strpos($file, '.');
					$uniqid = substr($file, 0, $pos);
					$name =  substr($file, $pos + 1);
					array_push($values, array(
						'uniqid' => $uniqid,
						'subject' => addslashes($subject),
						'file_name' => $name,
						'grade_access' => $grade_access,
						'content_type' => $content_type,
						'mime_content_type' => $mime_type[0],
						'abstract' => addslashes($abstract),
					));
					if(!empty($video_duration)){
						$values[0]['video_duration'] = $video_duration;
						$vtt_content = "WEBVTT FILE\r\n\r\n".$this->_second_to_time($video_duration_start)
							.".000 --> ".$this->_second_to_time($video_duration_end).".000\r\n"
							."Please contact Lilyfortuneclub for the full video\r\n";
						file_put_contents(getcwd().'/src/media/'.$uniqid.'.vtt', $vtt_content);
					}
				}
			}
			/*else{
				array_push($values, array(
					'uniqid' => $uniqid,
					'subject' => addslashes($subject),
					'grade_access' => $grade_access,
					'content_type' => $content_type,
					'mime_content_type' => 'HTML',
					'html_content' => addslashes($html_content)
				));
			}*/
			
			if($this->document_model->insert($values)){
				header('location: '.base_url().'smd/documents');
			}
			$fields = $this->input->post();
			$fields['error'] = '';
		}
		$content_types = $this->document_model->get_all_content_types();
		$access_grades = array(
			array('value' => 'G', 'text' => 'Guest and above'),
			array('value' => 'TA', 'text' => 'TA and above'),
			array('value' => 'A', 'text' => 'A and above'),
			array('value' => 'SA', 'text' => 'SA and above'),
			array('value' => 'MD', 'text' => 'MD Only')
		);
		$this->load_view('documents/create_web', array_merge(array('content_types' => $content_types, 'access_grades' => $access_grades), $fields));
	}
	
	public function update($field = null, $uniqid = null){
		$result = $this->document_model->get_item($uniqid);
		if(count($result) == 0){
			ajax_error(500, "The document does not eists, or you don't have permission to access the user.");
			exit;
		}

		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$items = array();
			switch($field){
				case 'grade_access':
					$items = array(
						array(
							'label' => 'Grade Access',
							'name' => 'grade_access',
							'tag' => 'select',
							'required' => true,
							'value' => $result[0]['grade_access'],
							'options' => array(
								array('value' => 'G', 'text' => 'Guest'),
								array('value' => 'TA', 'text' => 'Trainee Associate'),
								array('value' => 'A', 'text' => 'Associate'),
								array('value' => 'SA', 'text' => 'Senior Associate'),
								array('value' => 'MD', 'text' => 'Margeting Director')
							),
						)
					);
					break;
				case 'content_type':
					$items = array(
						array(
							'label' => 'Content Type',
							'name' => 'content_type',
							'tag' => 'select',
							'required' => true,
							'value' => $result[0]['content_type'],
							'options' => array(
								array('value' => 'business', 'text' => 'Business'),
								array('value' => 'team build', 'text' => 'Team Build'),
								array('value' => 'recruit', 'text' => 'Recruit'),
								array('value' => 'sales', 'text' => 'Sales'),
								array('value' => 'technical', 'text' => 'Technical'),
								array('value' => 'license', 'text' => 'License'),
								array('value' => 'other', 'text' => 'Other'),
							),
						)
					);
					break;
				case 'subject':
					$items = array(
						array(
							'label' => 'Subject',
							'name' => 'subject',
							'tag' => 'input',
							'value' => $result[0]['subject']
						),
					);
					break;
				case 'abstract':
					$items = array(
						array(
							'label' => 'Abstract',
							'name' => 'abstract',
							'tag' => 'textarea',
							'value' => $result[0]['abstract'],
						)
					);
					break;
				case 'video_duration':
					$items = array(
						array(
							'label' => 'Duration (Second)',
							'name' => 'video_duration',
							'tag' => '',
							'value' => $result[0]['video_duration'],
						)
					);
					break;
				default:
					ajax_error(500, "Invalid field.");
			}
			$this->load->view('smd/add_item', array('items' => $items));
		}
		else{
			$values = array();
			switch($field){
				case 'grade_access':
				case 'content_type':
				case 'subject':
				case 'abstract':
					$values[$field] = addslashes(trim($this->input->post($field)));
					break;
				case 'video_duration':
					$video_duration_start = intval($this->input->post('video_duration_start'));
					$video_duration_end = intval($this->input->post('video_duration_end'));
					if(!empty($video_duration_start) || !empty($video_duration_end)){
						$values[$field]= $video_duration_start.','.$video_duration_end;
					}
					break;
				default:
					ajax_error(500, "Invalid field.");
			}
			
			if($this->document_model->update($values, "uniqid='$uniqid'")){
				echo json_encode(array('success' => true));
			}
			else{
				echo json_encode(array('success' => false, 'message' => 'Failed to update value.'));
			}
		}
		
	}
	
	public function edit($uniqid = null){
		$fields = array();
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$subject = $this->input->post('subject');
			$content_type = $this->input->post('content_type');
			$grade_access = $this->input->post('grade_access');
			$abstract = $this->input->post('abstract');
			if($this->document_model->update(array(
				'uniqid' => $uniqid,
				'subject' => addslashes($subject),
				'grade_access' => $grade_access,
				'content_type' => $content_type,
				'abstract' => addslashes($abstract)
			), "uniqid='$uniqid'")){
				header('location: '.base_url().'smd/documents');
			}
			$fields = $this->input->post();
			$fields['error'] = '';
		}
		$result = $this->document_model->get_list("uniqid='$uniqid'");
		if(count($result) == 0){
			$fields['error'] = 'The document does not exist';
		}
		else{
			$fields = $result[0];
		}
		$content_types = $this->document_model->get_all_content_types();
		$access_grades = array(
			array('value' => 'G', 'text' => 'Guest an Above'),
			array('value' => 'TA', 'text' => 'Trainee Associate an Above'),
			array('value' => 'A', 'text' => 'Associate an Above'),
			array('value' => 'SA', 'text' => 'Senior Associate an Above'),
			array('value' => 'MD', 'text' => 'Margeting Director Only')
		);
		$this->load_view('documents/create_web', array_merge(array('content_types' => $content_types, 'access_grades' => $access_grades), 
			$fields));
	}
	
	public function item($uniqid){
		$result = $this->document_model->get_item($uniqid);
		$item = array(
			'documents_id'=>$result[0]['documents_id'],
			'uniqid'=>$result[0]['uniqid'],
			'file_name'=>$result[0]['file_name'],
			'grade_access'=>$result[0]['grade_access'],
			'mime_content_type'=>$result[0]['mime_content_type'],
			'content_type'=>$result[0]['content_type'],
			'video_duration' => $result[0]['video_duration'],
			'create_date'=>$result[0]['create_date'],
			'subject'=>$result[0]['subject'],
			'abstract'=>$result[0]['abstract'],
			'html_content'=>$result[0]['html_content'],
			'pub_code' => array()
		);
		foreach($result as $r){
			if(!empty($r['document_id'])){
				array_push($item['pub_code'],
					array(
						'document_pub_code_id' => $r['document_pub_code_id'],
						'code' => $r['code'],
						'expire' => $r['expire'], 
						'document_id' => $r['document_id'],
					)
				);
			}
		}
		$this->load_view('documents/item', array('document' => $item));
	}
	
	public function delete_pub_code($pub_code_id = null){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->document_model->delete_pub_code("document_pub_code_id='$pub_code_id'");
			echo json_encode(array('success' => true));
			return;
		}
		else{
			$items = array();
			array_push($items,
				array(
					'tag' => 'text',
					'text' => 'Do you want to delete the code?',
				)
			);
			$this->load->view('smd/add_item', array('items' => $items));
		}
	}
	
	public function generate_pub_code($uniqid = null){
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			$code = $this->input->post('code');
			$expire = intval($this->input->post('expire'));
			$expire = date_format(date_add(date_create(),date_interval_create_from_date_string("$expire hours")), "Y-m-d H:i:s");
			$res = $this->document_model->new_pub_code($code, $expire, $uniqid);
			if($res){
				echo json_encode(array('success' => true));
			}
			else{
				echo json_encode(array('success' => false, 'message' => 'Failed to generate pub code.'));
			}
			return;
		}
		else{
			$result = $this->document_model->get_pub_code();
			$all_codes = array();
			foreach($result as $r){
				array_push($all_codes, $r['code']);
			}
			do{
				$code = '';
				$len = mt_rand(5, 8);
				for($i = 0; $i < $len; ++$i){
					$t = mt_rand(1, 2);
					if($t == 1){
						$code .= chr(mt_rand(65, 90));
					}
					else{
						$code .= mt_rand(0, 9);
					}
				}
			}
			while(in_array($code, $all_codes));
			
			$items = array(
				array(
					'label' => 'Code',
					'name' => 'code',
					'tag' => 'input',
					'readonly' => true,
					'value' => $code
				),
				array(
					'label' => 'Expire',
					'name' => 'expire',
					'tag' => 'input',
					'type' => 'number',
					'min' => 1,
					'required' => true,
					'value' => 24
				),
			);
			$this->load->view('smd/add_item', array('items' => $items));		
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */