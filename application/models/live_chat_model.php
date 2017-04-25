<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Live_chat_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function initiate_session($id, $name, $email){
		$sql = "INSERT INTO live_chat_session (session_code, init_time, guest_name, guest_email) VALUES ('$id', NOW(), '$name', '$email')";
		if(!$this->db->query($sql)){
			return false;
		}
		$insert_id = $this->db->insert_id();
		if($insert_id <= 0){
			return false;
		}
		return $insert_id;
	}
	
	public function insert_chat_message($session_id, $message_text, $message_type, $timestamp){
		$sql = "INSERT INTO live_chat_messages (session_id, message_text, message_type, timestamp) 
			VALUES ('$session_id', '$message_text', '$message_type', '$timestamp')";
		$this->db->query($sql);
	}
	
	public function get_response_messages($session_id){
		$sql = "SELECT live_chat_messages.*, CONCAT(users.first_name, ' ', users.last_name) AS respondent FROM live_chat_messages INNER JOIN live_chat_session ON live_chat_messages.session_id=live_chat_session.live_chat_session_id 
			INNER JOIN users ON users.users_id=live_chat_session.user_id
			 WHERE live_chat_session.session_code='$session_id' AND live_chat_messages.message_type = 'REP' ORDER BY live_chat_messages.live_chat_message_id ASC";
		return $this->db->query($sql);
	}
	
	public function delete_messages($message_ids){
		$sql = "DELETE FROM live_chat_messages WHERE 1=1 "
			.(empty($message_ids) ? "" : " AND live_chat_messages.live_chat_message_id IN ('".implode("','", $message_ids)."')");
		$this->db->query($sql);
	}
}