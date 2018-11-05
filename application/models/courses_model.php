<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Courses_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_course_list(){
		$sql = "SELECT c.*, d.uniqid, d.subject, d.mime_content_type, d.file_name FROM courses c LEFT JOIN documents d ON c.courses_id=d.courses_id ORDER BY c.courses_id ASC";
		return $this->db->query($sql);
	}
}