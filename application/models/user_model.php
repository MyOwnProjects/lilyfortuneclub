<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_model extends Base_model{
	public function __construct(){
		parent::__construct();
	}
	
	public function get_user_by_id($id){
		$sql = "SELECT users.*, user_roles.*,  
			u1.first_name AS first_name1, u1.last_name AS last_name1, u1.nick_name AS nick_name1, 
			u2.first_name AS first_name2, u2.last_name AS last_name2, u2.nick_name AS nick_name2 
			FROM users 
			LEFT JOIN users u1 ON users.smd=u1.users_id 
			LEFT JOIN users u2 ON users.parent=u2.users_id 
			LEFT JOIN user_and_role ON user_and_role.user_id=users.users_id 
			LEFT JOIN user_roles ON user_roles.user_roles_id=user_and_role.role_id 
			WHERE users.users_id='$id'";
		$results = $this->db->query($sql);
		if(count($results) == 0)
			return null;
		$ret = array();
		foreach($results[0] as $n => $v){
			if($n != 'user_roles_id'){
				$ret[$n] = $v;
			}
		}
		$ret['roles'] = array();
		foreach($results as $r){
			if(isset($r['user_roles_id'])){
				$ret['roles'][$r['user_roles_id']] = $r['user_role_name'];
			}
		}
		return $ret;
	}
	
	public function get_user_by_email($email){
		$sql = "SELECT * FROM users WHERE email='$email'";
		$results = $this->db->query($sql);
		if(count($results) == 1)
			return $results[0];
	}

	public function get_user_by_username($username){
		$sql = "SELECT * FROM users WHERE username='$username'";
		$results = $this->db->query($sql);
		if(count($results) == 1)
			return $results[0];
	}

	public function get_user($username, $password){
		$sql = "SELECT * FROM users WHERE username='$username' AND password=SHA1('$password')";
		$results = $this->db->query($sql);
		if(count($results) == 1)
			return $results[0];
	}
	
	public function get_user_by_token($token){
		$sql = "SELECT * FROM users WHERE reset_token='$token'";
		$results = $this->db->query($sql);
		if(count($results) == 1)
			return $results[0];
	}
	
	public function get_user_by($value = array()){
		$where = array();
		foreach($value as $k=>$v){
			array_push($where, "users.".$k."='".$v."'");
		}
		if(!empty($where)){
			$where = ' WHERE '.implode(' AND ', $where);
		}
		else
			$where = '';
		$sql = "SELECT CONCAT(users.first_name, ' ', users.last_name) AS name, users.*,
			CONCAT(users.street, ', ', users.city, ', ', users.state, ' ', users.zipcode) AS address,
			CONCAT(u2.first_name, ' ', (u2.last_name)) AS upline, 
			CONCAT(u1.first_name, ' ', (u1.last_name)) AS SMD
			FROM users 
			LEFT JOIN users u1 ON users.smd=u1.users_id 
			LEFT JOIN users u2 ON users.parent=u2.users_id 
			$where";
		$results = $this->db->query($sql);
		return $results;
	}

	public function update($id, $value = array()){
		$set = array();
		foreach($value as $k=>$v){
			if($k == 'password')
				array_push($set, $k."=SHA1('".$v."')");
			else if(is_null($v))
				array_push($set, $k."=NULL");
			else
				array_push($set, $k."='".$v."'");
		}
		if(!empty($set)){
			$sql = "UPDATE users SET ".implode(',', $set)." WHERE users_id=$id";
			if($this->db->query($sql) && $this->db->affected_rows() == 1){
				return true;
			}
		}
		return false;
	}
	
	public function get_count($where = '', $order_by = array(), $limit = ''){
		$sql = "SELECT count(*) FROM users ".(empty($where) ? '' : ' WHERE '.$where).(empty($order_by) ? ' ORDER BY users_id DESC' : ' ORDER BY '.implode(',', $order_by).(empty($limit) ? ' LIMIT 0, 50' : ' LIMIT '.$limit));
		return $this->db->query($sql);
	}

	public function get_list($where = '', $sort = array(), $limit = '', $search = array()){
		$like_array = array();
		if(!empty($search)){
			foreach($search as $s){
				array_push($like_array, "name LIKE '%$s%'");
				array_push($like_array, "nick_name LIKE '%$s%'");
				array_push($like_array, "email LIKE '%$s%'");
				array_push($like_array, "membership_code LIKE '%$s%'");
				array_push($like_array, "upline LIKE '%$s%'");
			}
		}
		$order_by = array();
		if(!empty($sort)){
			foreach($sort as $name => $value){
				array_push($order_by, $name.' '.$value);
			}
		}

		$sql = "SELECT * FROM 
			(
				SELECT users.*, CONCAT(users.first_name, ' ', users.last_name) AS name, CONCAT(u1.first_name, ' ', u1.last_name) AS upline, IF(u2.count IS NULL,0, u2.count) AS downline 
				FROM users 
				LEFT JOIN users u1 ON users.parent=u1.users_id
				LEFT JOIN 
				(
					SELECT parent, COUNT(*) AS count FROM users GROUP BY parent
				) u2 ON users.users_id=u2.parent
			) t
			WHERE 1=1 ".(empty($where) ? "" : " AND $where ")
			.(empty($like_array) ? "" : " AND (".implode(" OR ", $like_array).")")
			.(empty($order_by) ? "" : " ORDER BY ".implode(",", $order_by))
			.(empty($limit) ? "" : " LIMIT $limit");
		return $this->db->query($sql);
	}
	
	public function get_total($where = '', $search = array()){
		$like_array = array();
		if(!empty($search)){
			foreach($search as $s){
				array_push($like_array, "name LIKE '%$s%'");
				array_push($like_array, "nick_name LIKE '%$s%'");
				array_push($like_array, "email LIKE '%$s%'");
				array_push($like_array, "membership_code LIKE '%$s%'");
				array_push($like_array, "upline LIKE '%$s%'");
			}
		}
		$sql = "SELECT COUNT(*) AS total FROM 
			(
				SELECT users.*, CONCAT(users.first_name, ' ', users.last_name) AS name, CONCAT(u1.first_name, ' ', u1.last_name) AS upline 
				FROM users 
				LEFT JOIN users u1 ON users.parent=u1.users_id 
			) t
			WHERE 1=1 ".(empty($where) ? "" : " AND $where ")
			.(empty($like_array) ? "" : " AND (".implode(" OR ", $like_array).")");
		$result = $this->db->query($sql);
		return $result[0]['total'];
	}
	
	public function new_user($prop){
		$name_list = array();
		$value_list = array();
		foreach($prop as $n => $v){
			if($n == 'membership_code' && empty($v)){
			}
			else{
				array_push($name_list, $n);
				array_push($value_list, trim($v));
			}
		}
		array_push($name_list, 'create_date');
		array_push($value_list, date_format(date_create(), 'Y-m-d'));
		if(!$this->db->query("INSERT INTO users (`".implode("`, `", $name_list)."`) VALUES ('".implode("', '", $value_list)."')")){
			return false;
		}
		$insert_id = $this->db->insert_id();
		return $insert_id > 0 ? $insert_id : false;
	}
	
	public function signup($email, $password, $first_name, $last_name, $phone_number, $address, $city, $state, $zip_code){
		$sql = "SELECT COUNT(*) as count FROM users WHERE UPPER(email)='".strtoupper($email)."'";
		$results = $this->db->query($sql);
		if($results[0]->count != 0){
			return 0;
		}
		$sql = "INSERT INTO users (email, password, first_name, last_name, phone, address, city, state, zipcode)"
				. " VALUES ('$email', SHA1('$password'), '$first_name', '$last_name', '$phone_number', '$address', '$city', '$state', '$zip_code')";
		if(!$this->db->query($sql))
			return -1;
		$user_id = $this->db->insert_id();
		return $user_id;
	}
	
	public function get_users_fields(){
		$sql = "SHOW COLUMNS FROM users WHERE FIELD <> 'users_id'";
		return $this->db->query($sql);
	}
	
	public function get_child_users($parent_id, $user_id = null){
		if(isset($parent_id)){
			$sql = "SELECT u1.*, IF(u2.count IS NULL, 0, u2.count) AS count FROM users u1 
				LEFT JOIN 
				(
					SELECT parent, COUNT(*) AS count FROM users GROUP BY parent
				) u2 ON u1.users_id=u2.parent 
				WHERE u1.parent='$parent_id'";
		}
		else{
			$sql = "SELECT u1.*, IF(u2.count IS NULL, 0, u2.count) AS count FROM users u1 
				LEFT JOIN 
				(
					SELECT parent, COUNT(*) AS count FROM users GROUP BY parent
				) u2 ON u1.users_id=u2.parent 
				WHERE u1.users_id = '$user_id'";
		}
		return $this->db->query($sql);
	}
	
	public function get_all_children($parent_id){
		$data = array();
		$parent_ids = array($parent_id);
		while(count($parent_ids) > 0){
			$sql = "SELECT * FROM users WHERE parent IN ('".implode("','", $parent_ids)."')";
			$result = $this->db->query($sql);
			$parent_ids = array();
			foreach($result as $r){
				$id = $r['users_id'];
				$data[$id] = $r;
				array_push($parent_ids, $id);	
			}
		}
		return $data;
	}
	
	public function insert_user_info($user_id, $values){
		$v = array();
		foreach($values as $value){
			array_push($v, "('$user_id', '".$value['user_info_label']."', '".$value['user_info_value']."')");
		}
		if(count($v) > 0){
			$sql = "INSERT INTO users_info (user_id, user_info_label, user_info_value) VALUES ".implode(",", $v);
			return $this->db->query($sql) && $this->db->insert_id() > 0;
		}
		return true;
	}
	
	public function delete_user_info($where){
		$sql = "DELETE FROM users_info ".(empty($where) ? "" : " WHERE $where");
		return $this->db->query($sql);	
	}
	
	public function update_user_info($values, $where){
		$va = array();
		foreach($values as $n => $v){
			array_push($va, "`$n`='$v'");
		}
		$sql = "UPDATE users_info SET ".implode(",", $va).(empty($where) ? "" : " WHERE $where");
		return $this->db->query($sql);	
	}

	public function get_user_info_by_user_id($users_ids, $smd = null){
		$sql = "SELECT * FROM users_info INNER JOIN users ON users_info.user_id=users.users_id "
			. "WHERE 1=1 ".(empty($users_ids) ? "" : " AND users_id IN ('".implode("','", $users_ids)."')").(empty($smd) ? "" : " AND users.smd='$smd'");
		return $this->db->query($sql);
	}
	
	public function get_user_info($users_info_id, $smd = null){
		$sql = "SELECT ui.* FROM users_info ui "
			. "INNER JOIN users u ON ui.user_id=u.users_id WHERE ui.users_info_id='$users_info_id' ".(empty($smd) ? "" : " AND u.smd='$smd'");
		$result = $this->db->query($sql);
		if(count($result) > 0)
			return $result[0];
		else
			return null;
	}
	
	public function get_all_assistants(){
		$sql = "SELECT * FROM users u 
			INNER JOIN user_and_role uar ON u.users_id=uar.user_id 
			INNER JOIN user_roles ur ON ur.user_roles_id=uar.role_id
			WHERE ur.user_roles_id=2";
		return $this->db->query($sql);
	}
}