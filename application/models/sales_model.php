<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sales_model extends Base_model{
	private $_guest_passcode_list = array('2018today');
	public function __construct(){
		parent::__construct();
	}
	
	public function get_sales($id = null){
		$sql = "SELECT * FROM sales where sales_id='$id'";
		return $this->db->query($sql);
	}
	
	public function get_list($where = '', $sort = array(), $limit = '', $search = array(), $filter = array()){
		$order_by = array();
		if(!empty($sort)){
			foreach($sort as $name => $value){
				if($name == ''){
				}
				else{
					array_push($order_by, $name.' '.$value);
				}
			}
		}
		$like_array = array();
		if(!empty($search)){
			foreach($search as $s){
				array_push($like_array, "sales_insured LIKE '%$s%'");
				array_push($like_array, "sales_owner LIKE '%$s%'");
				array_push($like_array, "sales_policy_no LIKE '%$s%'");
				array_push($like_array, "u1.first_name LIKE '%$s%'");
				array_push($like_array, "u1.last_name LIKE '%$s%'");
				array_push($like_array, "u1.nick_name LIKE '%$s%'");
				array_push($like_array, "u2.first_name LIKE '%$s%'");
				array_push($like_array, "u2.last_name LIKE '%$s%'");
				array_push($like_array, "u2.nick_name LIKE '%$s%'");
			}
		}
		$filter_str = '';
		if(!empty($filter)){
			$k = key($filter);
			$v = $filter[$k];
			if($v != ''){
				$filter_str = "$k='$v'";
			}
		}
		$sql = "SELECT sales.*, u1.nick_name, u1.first_name, u1.last_name, u2.nick_name, u2.first_name, u2.last_name,
			CONCAT(IF(u1.nick_name IS NULL OR u1.nick_name='', u1.first_name, u1.nick_name), ' ', u1.last_name) AS agent1,
			CONCAT(IF(u2.nick_name IS NULL OR u2.nick_name='', u2.first_name, u2.nick_name), ' ', u2.last_name) AS agent2
			FROM sales 
			LEFT JOIN users u1 ON u1.membership_code= sales.sales_writing_agent
			LEFT JOIN users u2 ON u2.membership_code= sales.sales_split_agent
			WHERE 1=1 ".(empty($where) ? "" : " AND $where ")
			.(empty($filter_str) ? '' : " AND $filter_str")
			.(empty($like_array) ? "" : " AND (".implode(" OR ", $like_array).")")
			.(empty($order_by) ? "" : " ORDER BY ".implode(",", $order_by))
			.(empty($limit) ? "" : " LIMIT $limit");
		$result = $this->db->query($sql);
		return $result;
	}
	
	public function get_total($where = '', $search = array(), $filter = array()){
		$like_array = array();
		if(!empty($search)){
			foreach($search as $s){
				array_push($like_array, "sales_insured LIKE '%$s%'");
				array_push($like_array, "sales_owner LIKE '%$s%'");
				array_push($like_array, "sales_policy_no LIKE '%$s%'");
				array_push($like_array, "u1.first_name LIKE '%$s%'");
				array_push($like_array, "u1.last_name LIKE '%$s%'");
				array_push($like_array, "u1.nick_name LIKE '%$s%'");
				array_push($like_array, "u2.first_name LIKE '%$s%'");
				array_push($like_array, "u2.last_name LIKE '%$s%'");
				array_push($like_array, "u2.nick_name LIKE '%$s%'");
			}
		}
		$filter_str = '';
		if(!empty($filter)){
			$k = key($filter);
			$v = $filter[$k];
			if($v != ''){
				$filter_str = "$k='$v'";
			}
		}
		$sql = "SELECT COUNT(*) AS total FROM sales
			LEFT JOIN users u1 ON u1.membership_code= sales.sales_writing_agent
			LEFT JOIN users u2 ON u2.membership_code= sales.sales_split_agent
			WHERE 1=1 ".(empty($where) ? "" : " AND $where ")
			.(empty($filter_str) ? '' : " AND $filter_str")
			.(empty($like_array) ? "" : " AND (".implode(" OR ", $like_array).")");
	
		/*$sql = "SELECT COUNT(*) AS total FROM 
			(
				SELECT sales.*, CONCAT(u1.first_name, ' ', users.last_name) AS name, 
				CONCAT(IF(u1.nick_name IS NULL OR u1.nick_name='', u1.first_name, u1.nick_name), ' ', u1.last_name) AS agent1,
				CONCAT(IF(u2.nick_name IS NULL OR u2.nick_name='', u2.first_name, u2.nick_name), ' ', u2.last_name) AS agent2,
				FROM sales 
				LEFT JOIN users u1 ON u1.membership_code= sales.sales_writing_agent
				LEFT JOIN users u2 ON u1.membership_code= sales.sales_split_agent
			) t
			WHERE 1=1 ".(empty($where) ? "" : " AND $where ")
			.(empty($like_array) ? "" : " AND (".implode(" OR ", $like_array).")");*/
		$result = $this->db->query($sql);
		return $result[0]['total'];
	}
	
	public function insert($prop){
		$keys = array();
		$values = array();
		foreach($prop as $k => $v){
			array_push($keys, $k);
			array_push($values, $v);
		}
		$sql= "INSERT INTO sales (".implode(',', $keys).") VALUES (".implode(',', $values).")";
		$this->db->query($sql);
		return $this->db->insert_id();
		
	}
	
	public function update($id, $prop){
		$values = array();
		foreach($prop as $k => $v){
			array_push($values, $k.'='.$v);
		}
		$sql= "UPDATE sales SET ".implode(',', $values)." WHERE sales_id='$id'";
		return $this->db->query($sql);
	}
}