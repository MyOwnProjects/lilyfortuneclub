<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Editable_contents_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_all(){
		$sql = "SELECT * FROM editable_contents_categories ecc 
			LEFT JOIN editable_contents ec ON 
			ecc.editable_contents_categories_id=ec.editable_contents_category 
			ORDER BY ecc.editable_contents_categories_id ASC, ec.editable_contents_sub_category ASC, 
			ec.editable_contents_id DESC";
		return $this->db->query($sql);
	}
	
	public function new_question($user, $c_id, $subject, $body){
		$subject = addslashes(strip_tags(trim($subject)));
		$body = preg_replace('/\n+/', "\n", trim($body));
		$body = addslashes(strip_tags($body));
		try{
			$this->db->query("BEGIN");
			$sql = "INSERT INTO editable_contents (editable_contents_subject,editable_contents_body,
				editable_contents_editable,editable_contents_category,editable_contents_sub_category) VALUES (
				'$subject', '$body', 'Y', '$c_id', NULL)";
			if(!$this->db->query($sql)){
				throw new Exception("");
			}
			$insert_id = $this->db->insert_id();
			if($insert_id <= 0){
				throw new Exception("");
			}
			$sql = "INSERT INTO editable_contents_history (editable_contents_history_editable_contents_id,
				editable_contents_history_user_id,
				editable_contents_history_subject,
				editable_contents_history_body,
				editable_contents_history_category,
				editable_contents_history_sub_category,
				editable_contents_history_update_time) VALUES (
				'$insert_id', '".$user['users_id']."', '$subject', '$body', '$c_id', '', NOW())";
			if(!$this->db->query($sql)){
				throw new Exception("");
			}
			$insert_id = $this->db->insert_id();
			if($insert_id <= 0){
				throw new Exception("");
			}
			$this->db->query('COMMIT');
		}
		catch(Exception $e){
			$this->db->query('ROLLBACK');
			return false;
		}
		return true;
	}
	
	public function update_question($user, $g_id, $subject, $body){
		$subject = addslashes(strip_tags(trim($subject)));
		$body = preg_replace('/\n+/', "\n", trim($body));
		$body = addslashes(strip_tags($body));
		try{
			$this->db->query("BEGIN");
			$sql = "UPDATE editable_contents SET editable_contents_subject='$subject',
				editable_contents_body='$body' WHERE editable_contents_id='$g_id'";
			if(!$this->db->query($sql)){
				throw new Exception("");
			}
			if($this->db->affected_rows() != 1){
				throw new Exception("");
			}
			$sql = "INSERT INTO editable_contents_history (editable_contents_history_editable_contents_id,
				editable_contents_history_user_id,
				editable_contents_history_subject,
				editable_contents_history_body,
				editable_contents_history_update_time) VALUES (
				'$g_id', '".$user['users_id']."', '$subject', '$body', NOW())";
			if(!$this->db->query($sql)){
				throw new Exception("");
			}
			$insert_id = $this->db->insert_id();
			if($insert_id <= 0){
				throw new Exception("");
			}
			$this->db->query('COMMIT');
		}
		catch(Exception $e){
			$this->db->query('ROLLBACK');
			return false;
		}
		return true;
	}
	
	public function get_question($q_id){
		return $this->db->query("SELECT * FROM editable_contents WHERE editable_contents_id='$q_id'");
	}
}